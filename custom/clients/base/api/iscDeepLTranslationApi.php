<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 07.07.2025
 * Change Date   : 07.07.2025
 * Main Program  : ISC_DeepL_Translator
 * Description   : iscDeepLTranslationApi.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
//custom/clients/base/api/iscDeepLTranslationApi.php
  
//require_once 'custom/modules/isc_deepl_translator/isc_src/Service/DeepLService.php';


class iscDeepLTranslationApi extends SugarApi
{
    public function registerApiRest()
    {
        return [
            'createNote' => [
                'reqType'   => 'POST',
                'path'      => ['isc','deepl','note'],
                'pathVars'  => ['', '', ''],
                'method'    => 'createNote',
                'shortHelp' => 'Erzeugt eine Notiz mit Übersetzung und verknüpft sie zur Aufgabe',
            ],

            'test' => [
                'reqType'  => 'GET',
                'path'     => ['isc_deepl','test'],
                'pathVars' => ['module','action'],
                'method'   => 'testKey',
                'shortHelp'=> 'Prüft DeepL-API-Key',
                'acl'      => 'admin',
            ],


            'isc_translate' => [
                 'reqType' => 'POST',
                'path' => ['isc', 'deepl', 'translate'],
                'pathVars' => ['', '', ''],
                'method' => 'translate',
                'shortHelp' => 'DeepL translate',
                'acl' => 'admin',
            ],

            'load' => [
                'reqType'   => 'GET',
                'path'      => ['isc_deepl','load'],
                'pathVars'  => ['module','action'],
                'method'    => 'loadKey',
                'shortHelp' => 'Lädt DeepL-API-Key',
                'acl'       => 'admin',
            ],

            'save' => [
                'reqType'   => 'POST',
                'path'      => ['isc_deepl','save'],
                'pathVars'  => ['module','action'],
                'method'    => 'saveKey',
                'shortHelp' => 'Speichert DeepL-API-Key',
                'acl'       => 'admin',
            ],
            'notePdf' => [
                'reqType'   => 'POST',
                'path'      => ['isc','deepl','note','pdf'],
                'pathVars'  => ['',   '',     '',    '' ],
                'method'    => 'translateNotePdf',
                'shortHelp' => 'Übersetzt den PDF-Anhang einer Notiz (Auto-Detect → DE), speichert als Dokument und verknüpft zur Notiz.',
                'acl'       => 'view',
            ],

            'preflightNotePdf' => [
                'reqType'   => 'POST',
                'path'      => ['isc','deepl','note','pdf','preflight'],
                'pathVars'  => ['',   '',     '',    '',    ''        ],
                'method'    => 'preflightNotePdf',
                'shortHelp' => 'Prüft Key/Kontingent/Datei-Limits für den PDF-Übersetzungs-Flow, ohne Kosten zu verursachen.',
                'acl'       => 'view',
            ],
            'storageTestNotePdf' => [
                'reqType'   => 'POST',
                'path'      => ['isc','deepl','note','pdf','storage-test'],
                'pathVars'  => ['',   '',     '',    '',    '' ],
                'method'    => 'storageTestNotePdf',
                'shortHelp' => 'Legt testweise eine Kopie der Quell-PDF als Dokument ab (ohne DeepL).',
                'acl'       => 'view',
            ],


        ];
    }



    private function setNoteRelateToDocument(\SugarBean $note, \SugarBean $doc, string $relateField = 'uebersetzungs_anhang_c'): void
    {
        $defs = $note->field_defs[$relateField] ?? null;
        if (!$defs || (($defs['type'] ?? '') !== 'relate')) {
            $GLOBALS['log']->warn("Relate-Feld {$relateField} nicht gefunden oder kein 'relate'.");
            return;
        }
        $idField = $defs['id_name'] ?? ($relateField . '_id');
        $display = $doc->document_name ?? $doc->name ?? $doc->id;

        $note->$idField     = $doc->id;
        $note->$relateField = $display;      
        $note->save();
    }




    public function storageTestNotePdf($api, $args)
    {
        $noteId = (string)($args['note_id'] ?? '');
        if ($noteId === '') {
            throw new SugarApiExceptionInvalidParameter('note_id fehlt.');
        }

        $src = $this->findNoteAttachmentOrThrow($noteId);

        /** @var Document $doc */
        $doc = \BeanFactory::newBean('Documents');
        $doc->name             = ($src['note_name'] ?: $src['filename']) . ' (Simulation)';
        $doc->assigned_user_id = $GLOBALS['current_user']->id ?? '';
        $doc->status_id        = 'Active';
        $doc->doc_type         = 'Sugar';
        $doc->save();

        /** @var DocumentRevision $rev */
        $rev = \BeanFactory::newBean('DocumentRevisions');
        $rev->document_id    = $doc->id;
        $rev->revision       = '1';
        $rev->filename       = $src['filename'];
        $rev->file_mime_type = $src['mime'] ?: 'application/octet-stream';
        $rev->save();

        // UploadFile-API: upload-Kopie (Cloud-konform)
        require_once 'include/upload_file.php';
        $fromId = substr((string)$src['path'], strlen('upload://'));
        $toId   = $rev->id;
        $up     = new \UploadFile();
        $ok     = $up->duplicate_file($fromId, $toId);

        if (!$ok) {
            throw new SugarApiExceptionError('Konnte Testdatei nicht speichern (duplicate_file).');
        }

        // Document → aktuelle Revision
        $doc->document_revision_id = $rev->id;
        $doc->save();

        // Note holen & Relate-Feld setzen
        /** @var Note $note */
        $note = \BeanFactory::retrieveBean('Notes', $noteId, ['disable_row_level_security' => true]);
        if ($note) {
            $this->setNoteRelateToDocument($note, $doc, 'uebersetzungs_anhang_c');
        }

        return [
            'ok'            => true,
            'document_id'   => $doc->id,
            'document_name' => $doc->name,
        ];
    }




    public function createNote($api, $args)
    {
        $parentId    = $args['parent_id']    ?? '';
        $translation = $args['translation']  ?? '';
        $src         = strtoupper($args['source_lang'] ?? '');
        $dst         = strtoupper($args['target_lang'] ?? '');
        $parentSubj  = $args['parent_subject'] ?? '';

        if ($parentId === '' || $translation === '') {
            throw new SugarApiExceptionInvalidParameter('Fehlende Parameter für Notiz.');
        }

        /* ► Aufgabe laden & Beziehung prüfen */
        $task = BeanFactory::retrieveBean('Tasks', $parentId, ['disable_row_level_security'=>true]);
        if (!$task) {
            throw new SugarApiExceptionNotFound('Aufgabe nicht gefunden.');
        }
        if (!$task->load_relationship('notes')) {
            throw new SugarApiExceptionInvalidParameter('Beziehung tasks_notes nicht vorhanden.');
        }

        /* ► Notiz erzeugen */
        $note              = BeanFactory::newBean('Notes');
        $note->name        = "$src → $dst ($parentSubj)";
        $note->description = $translation;
        $note->assigned_user_id = $GLOBALS['current_user']->id;
        $note->save();

        /* ► Verknüpfen */
        $task->notes->add($note->id);

        return ['status'=>'OK','note_id'=>$note->id];
    }


    public function testKey($api, $args)
    {
        require_once 'custom/modules/isc_deepl_translator/isc_src/Service/DeepLService.php';
        $svc = new ISC\DeepL\Service\DeepLService();
        return ['valid' => $svc->testKey()];
    }

    public function translate($api, $args)
    {
        require_once 'custom/modules/isc_deepl_translator/isc_src/Service/DeepLService.php';

        if (!$GLOBALS['current_user']->isAdmin()) {
            throw new SugarApiExceptionNotAuthorized();
        }

        // Eingaben validieren
        $text   = (string)($args['text'] ?? '');
        $source = strtoupper(trim((string)($args['source_lang'] ?? ''))); // optional → Auto-Detect wenn leer
        $target = strtoupper(trim((string)($args['target_lang'] ?? ''))); // Pflicht

        if ($text === '') {
            throw new SugarApiExceptionInvalidParameter('text fehlt.');
        }
        if ($target === '') {
            throw new SugarApiExceptionInvalidParameter('target_lang fehlt.');
        }

        try {
            $svc = new ISC\DeepL\Service\DeepLService();

            // Text-Übersetzung
            $translated = $svc->translate($text, $source, $target);

            // Usage holen (kann je nach Implementierung unterschiedliche Keys haben)
            $usageRaw = $svc->getUsage();

            // --- Normalisieren auf einheitliches Schema ---
            // DeepL liefert laut Doku mind. character_count / character_limit (Free/Pro Classic).
            // https://developers.deepl.com/docs/api-reference/usage-and-quota
            $used  = (int)($usageRaw['character_count'] ?? $usageRaw['used']  ?? 0);
            $limit = (int)($usageRaw['character_limit'] ?? $usageRaw['limit'] ?? 0);
            $remaining = max(0, $limit - $used);
            $percent   = $limit > 0 ? round($used / $limit * 100, 2) : 0.0;

            // Vereinheitlichte Usage-Struktur zurückgeben (inkl. Backwards-Compat-Feldern)
            $usage = array_merge($usageRaw, [
                'character_count' => $used,
                'character_limit' => $limit,
                'remaining'       => $remaining,
                'percent'         => $percent,
                // BC-Felder für bestehendes Frontend (dein JS nutzte used/limit):
                'used'            => $used,
                'limit'           => $limit,
            ]);

            return [
                'translated' => $translated,
                'usage'      => $usage,
            ];

        } catch (\RuntimeException $e) {
            $GLOBALS['log']->error('DeepL-RTE: '.$e->getMessage());
            throw new SugarApiExceptionInvalidParameter($e->getMessage());

        } catch (\Throwable $e) {
            $GLOBALS['log']->fatal('DeepL-Fatal: '.$e->getMessage());
            throw new SugarApiExceptionError('Unerwarteter Fehler – siehe Log.');
        }
    }


    public function loadKey($api,$args)
    {
        try {
            $adm = new Administration();
            $adm->retrieveSettings('isc_deepl');
            return ['key' => $adm->settings['isc_deepl_api_key'] ?? ''];
        } catch (\Throwable $e) {
            $GLOBALS['log']->error('DeepL loadKey: '.$e->getMessage());
            throw new SugarApiExceptionError('Konfiguration konnte nicht geladen werden.');
        }
    }

    public function saveKey($api,$args)
    {
        $val = (string)($args['key'] ?? '');
        try {
            (new Administration())->saveSetting('isc_deepl','api_key',$val);
            return ['success'=>true];
        } catch (\Throwable $e) {
            $GLOBALS['log']->error('DeepL saveKey: '.$e->getMessage());
            throw new SugarApiExceptionError('Speichern fehlgeschlagen.');
        }
    }

    /**
     * Übersetzt den PDF-Anhang einer Notiz nach Deutsch (oder Ziel aus args)
     * und legt das Ergebnis als Dokument ab. Unterstützt Notes mit Legacy-Anhang
     * und mit Multi-Attachments (Attachment-Notes).
     *
     * Args:
     *  - note_id      (string, required)
     *  - target_lang  (string, optional, default "DE")
     *
     * Rückgabe:
     *  [
     *    'status'        => 'OK',
     *    'document_id'   => <GUID>,
     *    'document_name' => <string>
     *  ]
     */

    public function translateNotePdf($api, $args)
    {
        $noteId = (string)($args['note_id'] ?? '');
        $target = strtoupper((string)($args['target_lang'] ?? 'DE'));
        $dry    = !empty($args['dry_run']); // optionaler Schalter

        if ($noteId === '') {
            throw new SugarApiExceptionInvalidParameter('note_id fehlt.');
        }

        // Quelle ermitteln (DB/SugarQuery, keine FS-Funktionen)
        $src = $this->findNoteAttachmentOrThrow($noteId);
        $srcPath     = $src['path'];      // upload://<id>
        $srcFilename = $src['filename'];
        $srcMime     = $src['mime'];
        $srcSize     = (int)($src['size'] ?? 0);

        // Note laden (für Relate)
        /** @var Note $note */
        $note = \BeanFactory::retrieveBean('Notes', $noteId, ['disable_row_level_security' => true]);
        if (!$note) {
            throw new SugarApiExceptionNotFound('Notiz nicht gefunden.');
        }

        // Nur PDF
        $isPdf = (stripos($srcMime, 'pdf') !== false) || preg_match('~\\.pdf$~i', $srcFilename);
        if (!$isPdf) {
            throw new SugarApiExceptionInvalidParameter('Nur PDF-Dateien werden unterstützt.');
        }

        // Größenbremse (nur aus DB, kein filesize)
        $maxBytes = 10 * 1024 * 1024; // Free
        if ($srcSize > 0 && $srcSize > $maxBytes) {
            throw new SugarApiExceptionInvalidParameter('Datei zu groß (max. 10 MB im aktuellen Plan).');
        }

        // Service laden (Dry-Run muss der Konstruktor notfalls sofort sehen)
        require_once 'custom/modules/isc_deepl_translator/isc_src/Service/DeepLService.php';
        if ($dry) { $_SERVER['HTTP_X_ISC_DRYRUN'] = '1'; }
        $svc = new \ISC\DeepL\Service\DeepLService();
        $svc->enableDryRun($dry);

        try {
            // Document + Revision anlegen
            /** @var Document $doc */
            $doc = \BeanFactory::newBean('Documents');
            $doc->document_name    = trim(($src['note_name'] ?: $srcFilename) . ' (Übersetzung ' . $target . ')');
            $doc->name             = $doc->document_name;
            $doc->assigned_user_id = $GLOBALS['current_user']->id ?? '';
            $doc->status_id        = 'Active';
            $doc->doc_type         = 'Sugar';
            $doc->save();

            /** @var DocumentRevision $rev */
            $rev = \BeanFactory::newBean('DocumentRevisions');
            $rev->document_id    = $doc->id;
            $rev->revision       = '1';
            $rev->filename       = preg_replace('~\\.pdf$~i', '', $srcFilename) . '_' . $target . '.pdf';
            $rev->file_mime_type = 'application/pdf';
            $rev->save();

            // Zielpfad als Upload-Stream
            $sink = 'upload://' . $rev->id;
            $GLOBALS['log']->fatal('[ISC-DEEPL] API before service ' . json_encode([
                    'noteId' => $note->id,
                    'docId'  => $doc->id,
                    'revId'  => $rev->id,
                    'sink'   => $sink,
                    'dry'    => (bool)$dry,
                    'target' => $target,
                ]));
            // DeepL (oder Dry-Run-Kopie) → direkt in $sink
            $svc->translateDocumentToSink($srcPath, $srcFilename, $target, $sink, '');

            // Document → aktuelle Revision setzen
            $doc->document_revision_id = $rev->id;
            $doc->save();

            $GLOBALS['log']->fatal('[ISC-DEEPL] API after service ' . json_encode([
                    'docId' => $doc->id,
                    'revId' => $rev->id,
                    'sink'  => $sink,
                ]));

            // Relate-Feld an Note setzen (speichert Note intern)
            try {
                $this->setNoteRelateToDocument($note, $doc, 'uebersetzungs_anhang_c');
                $GLOBALS['log']->fatal('[ISC-DEEPL] API set relate OK ' . json_encode([
                        'noteId' => $note->id,
                        'docId'  => $doc->id,
                    ]));
            } catch (\Throwable $e) {
                $GLOBALS['log']->fatal('[ISC-DEEPL] API set relate FAILED ' . json_encode([
                        'noteId' => $note->id,
                        'docId'  => $doc->id,
                        'msg'    => $e->getMessage(),
                    ]));
                throw $e; 
            }
            

            return [
                'status'        => 'OK',
                'document_id'   => $doc->id,
                'document_name' => $doc->document_name,
                'dry_run'       => (bool)$dry,
            ];

        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'DEEPL_SAME_LANG') {
                $lang = strtoupper((string)($args['target_lang'] ?? ''));
                $msg  = translate('LBL_ISC_DEEPL_SAME_LANG_MSG', 'application');
                return [
                    'ok'      => false,
                    'reason'  => 'SAME_LANG',
                    'message' => sprintf($msg, $lang ?: ''),
                    'lang'    => $lang,
                ];
            }
            $GLOBALS['log']->error('DeepL translateNotePdf: '.$e->getMessage());
            throw new SugarApiExceptionError($e->getMessage());

        } catch (\Throwable $e) {
            $GLOBALS['log']->fatal('DeepL translateNotePdf fatal: '.$e->getMessage());
            throw new SugarApiExceptionError('Unerwarteter Fehler – siehe Log.');
        }
    }
    public function translateNotePdfDry($api, $args)
    {
        $args['dry_run'] = true;
        return $this->translateNotePdf($api, $args);
    }





    public function preflightNotePdf($api, $args)
    {
        $noteId = (string)($args['note_id'] ?? '');
        if ($noteId === '') {
            throw new SugarApiExceptionInvalidParameter('note_id fehlt.');
        }

        $src = $this->findNoteAttachmentOrThrow($noteId);

        // Nur PDF
        $isPdf = (stripos($src['mime'], 'pdf') !== false) || preg_match('~\\.pdf$~i', $src['filename']);
        if (!$isPdf) {
            return ['ok'=>false,'reason'=>'NOT_PDF','message'=>'Nur PDF wird unterstützt.'];
        }

        // Größe nur aus DB-Feld
        $isFree   = true;
        $maxBytes = $isFree ? 10*1024*1024 : 30*1024*1024;
        $size     = (int)($src['size'] ?? 0);
        if ($size > 0 && $size > $maxBytes) {
            return ['ok'=>false,'reason'=>'TOO_LARGE','message'=>"Datei zu groß ($size Bytes). Max: {$maxBytes} Bytes."];
        }

        require_once 'custom/modules/isc_deepl_translator/isc_src/Service/DeepLService.php';
        $svc   = new \ISC\DeepL\Service\DeepLService();
        $usage = $svc->getUsage();

        $used = (int)($usage['character_count'] ?? $usage['used']  ?? 0);
        $lim  = (int)($usage['character_limit'] ?? $usage['limit'] ?? 0);
        $remaining = max(0, $lim - $used);
        $minCharge = 50000;

       /* if ($remaining < $minCharge) {
            return [
                'ok'                   => false,
                'reason'               => 'LOW_QUOTA',
                'message'              => 'Verfügbares Kontingent < 50.000 Zeichen (Mindestabrechnung).',
                'character_count'      => $used,
                'character_limit'      => $lim,
                'remaining_characters' => $remaining,
                'min_charge_per_doc'   => $minCharge,
                'file_size'            => $size,
                'file_size_limit'      => $maxBytes,
                'filename'             => $src['filename'],
            ];
        }*/

        $resp = [
            'ok'                   => true,
            'file_size'            => (int)($size ?? 0),
            'file_size_limit'      => (int)($maxBytes ?? 0),
            'filename'             => (string)($src['filename'] ?? $src['name'] ?? ''),
            'mime'                 => (string)($src['mime'] ?? $src['content_type'] ?? ''),
            'remaining_characters' => (int)($remaining ?? 0),
            'min_charge_per_doc'   => (int)($minCharge ?? 0),
        ];
        $GLOBALS['log']->fatal('[ISC-DEEPL] preflightNotePdf return '.json_encode($resp, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        return $resp;
    }



  
    private function findNoteAttachmentOrThrow(string $noteId): array
    {
        /** @var Note $note */
        $note = \BeanFactory::retrieveBean('Notes', $noteId, ['disable_row_level_security'=>true]);
        if (!$note) {
            throw new SugarApiExceptionNotFound('Notiz nicht gefunden.');
        }

        // 1) Legacy direkt an der Haupt-Note?
        if (!empty($note->filename)) {
            return [
                'path'      => 'upload://' . $note->id,
                'filename'  => (string)$note->filename,
                'mime'      => (string)$note->file_mime_type,
                'size'      => (int)($note->file_size ?? 0),
                'note_name' => (string)$note->name,
            ];
        }

        // 2) Multi-Attachments (neueste zuerst)
        $sq = new \SugarQuery();
        $n  = \BeanFactory::newBean('Notes');
        $sq->from($n, ['team_security'=>false]);
        $sq->select(['id','filename','file_mime_type','date_entered','upload_id','file_size']);
        $sq->where()->equals('note_parent_id', $note->id)->equals('attachment_flag', 1);
        $sq->orderBy('date_entered','DESC');
        $sq->limit(1);
        $rows = $sq->execute();

        if (!empty($rows)) {
            $row = $rows[0];
            $path = 'upload://' . ($row['id'] ?: $row['upload_id']);
            return [
                'path'      => $path,
                'filename'  => (string)$row['filename'],
                'mime'      => (string)$row['file_mime_type'],
                'size'      => (int)($row['file_size'] ?? 0),
                'note_name' => (string)$note->name,
            ];
        }

        throw new SugarApiExceptionInvalidParameter('Diese Notiz hat keinen Datei-Anhang.');
    }






}