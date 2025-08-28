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
 * Description   : DeepLService.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
//custom/modules/isc_deepl_translator/isc_src/Service/DeepLService.php
namespace ISC\DeepL\Service;

use SugarConfig;
use Administration;
use RuntimeException;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7\LazyOpenStream;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\StreamInterface;

class DeepLService
{


    private bool $dryRun = false;

    public function enableDryRun(bool $on): void
    {
        $this->dryRun = $on;
    }

    
    private string $apiKey;
    private string $endpoint = 'https://api.deepl.com/v2/translate';
    private Guzzle $http;
    private bool $simulateOnError = false;

    public function __construct()
    {
        // ► Dry-Run Header erlauben
        $hdr = $_SERVER['HTTP_X_ISC_DRYRUN'] ?? null;
        if ($hdr !== null) {
            $this->dryRun = ($hdr === '1' || strtolower((string)$hdr) === 'true');
        }

        // ► Simulation-on-error (nur Schritt 3) per Header/Config
        $hdrSim = $_SERVER['HTTP_X_ISC_SIMULATE'] ?? null;
        $this->simulateOnError = ($hdrSim === '1' || strtolower((string)$hdrSim) === 'true')
            || (bool)\SugarConfig::getInstance()->get('isc_deepl_simulate_on_error', false);

        // ► API-Key (nur erforderlich, wenn nicht Dry-Run)
        $this->apiKey = SugarConfig::getInstance()->get('isc_deepl_api_key') ?: '';
        if (!$this->apiKey) {
            $adm = new Administration();
            $adm->retrieveSettings('isc_deepl');
            $this->apiKey = $adm->settings['isc_deepl_api_key'] ?? '';
        }
        if (!$this->apiKey && !$this->dryRun) {
            throw new RuntimeException('DeepL-API-Key fehlt (isc_deepl_api_key).');
        }

        // ► Guzzle-Client
        $headers = ['User-Agent' => 'SugarCRM DeepL Integration'];
        if ($this->apiKey) {
            $headers['Authorization'] = 'DeepL-Auth-Key ' . $this->apiKey;
        }
        $this->http = new Guzzle(['timeout' => 15, 'headers' => $headers]);

        // UploadStream sicher laden, unabhängig vom CWD
        if (!class_exists(\UploadStream::class)) {
            if (class_exists(\SugarAutoLoader::class) && method_exists(\SugarAutoLoader::class, 'requireWithCustom')) {
                \SugarAutoLoader::requireWithCustom('include/UploadStream.php');
            } else {
                // Fallback, falls ältere Sugar-Version
                $path = method_exists(\SugarAutoLoader::class, 'existing')
                    ? \SugarAutoLoader::existing('include/UploadStream.php')
                    : 'include/UploadStream.php';
                require_once $path;
            }
        }
        \UploadStream::register();
        
    }

    /* ============ Öffentliche Methoden ============ */

    public function translate(string $text, string $src, string $trg): string
    {
        $payload = [
            'form_params' => [
                'text'                => $text,
                'source_lang'         => strtoupper($src),
                'target_lang'         => strtoupper($trg),
                'preserve_formatting' => 1,
            ],
        ];

        $raw = $this->request('POST', $this->endpoint, $payload);
        $json = json_decode($raw, true);

        return $json['translations'][0]['text'] ?? '';
    }

    public function testKey(): bool
    {
        try {
            $this->getUsage();
            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    /** Liefert ['used'=>int,'limit'=>int,'percent'=>float] */

    public function getUsage(): array
    {
        // Bei Free: https://api-free.deepl.com ; bei Pro: https://api.deepl.com
        $raw = $this->request('GET', 'https://api.deepl.com/v2/usage');
        $j   = json_decode($raw, true);

        $count = (int)($j['character_count'] ?? 0);
        $limit = (int)($j['character_limit'] ?? 0);

        // API-konforme Felder + bequeme Zusatzwerte
        $resp = [
            'character_count' => $count,
            'character_limit' => $limit,
            'remaining'       => max(0, $limit - $count),
            'percent'         => $limit > 0 ? round($count / $limit * 100, 2) : 0.0,
        ];

        // Rückwärtskompatibilität zu deinem bisherigen Code
        $resp['used']  = $count;
        $resp['limit'] = $limit;

        return $resp;
    }


    /* ============ Interner HTTP-Helper ============ */

    private function request(string $method, string $url, array $opts = []): string
    {
        try {
            $res = $this->http->request(strtoupper($method), $url, $opts);
        } catch (GuzzleException $e) {
            throw new RuntimeException('Netzwerkfehler: ' . $e->getMessage(), 0, $e);
        }

        $code = $res->getStatusCode();
        $body = (string)$res->getBody();

        if ($code >= 400) {
            throw new RuntimeException("DeepL-HTTP $code: $body");
        }
        return $body;
    }

    /** Basis-URL für Dokumente (Free-API) */
    private string $docBase = 'https://api.deepl.com/v2/document';

    public function translateDocumentToSink(
        string $filePath,   
        string $fileName,
        string $targetLang,
        string $sinkPath,
        string $sourceLang = ''
    ): array {
        // UploadStream sicher laden, unabhängig vom CWD
        if (!class_exists(\UploadStream::class)) {
            if (class_exists(\SugarAutoLoader::class) && method_exists(\SugarAutoLoader::class, 'requireWithCustom')) {
                \SugarAutoLoader::requireWithCustom('include/UploadStream.php');
            } else {
                // Fallback, falls ältere Sugar-Version
                $path = method_exists(\SugarAutoLoader::class, 'existing')
                    ? \SugarAutoLoader::existing('include/UploadStream.php')
                    : 'include/UploadStream.php';
                require_once $path;
            }
        }
        \UploadStream::register();
        // Header-Schalter
        $mockEnabled = $this->isMockEnabled();

        $hdrSim = $_SERVER['HTTP_X_ISC_SIMULATE'] ?? null;
        $simulateOnError = ($hdrSim === '1' || strtolower((string)$hdrSim) === 'true') || $this->simulateOnError;

        // ========== MOCK: E2E ohne DeepL, ohne Zeichen ==========
        if ($mockEnabled) {
            $GLOBALS['log']->info('[DeepL] MOCK enabled');
            $this->ensureUploadShardDir($sinkPath);
            $dst = new \GuzzleHttp\Psr7\LazyOpenStream($sinkPath, 'w');
            try {
                $dst->write($this->buildMiniPdf('MOCK '.strtoupper($targetLang)));
            } finally {
                if ($dst instanceof \Psr\Http\Message\StreamInterface) { $dst->close(); }
            }
            return ['document_id'=>'MOCK','simulated'=>true];
        }
        // ---------- CACHE-LOOKUP ----------
        $srcHash  = $this->computeUploadSha256($filePath);
        $cacheKey = $this->makeCacheKey($srcHash, $sourceLang, $targetLang, ['kind'=>'document']);
        if ($hit = $this->cacheLoad($cacheKey)) {
            $cachedId = (string)($hit['upload_id'] ?? '');
            if ($cachedId) {
                $this->ensureUploadShardDir($sinkPath);
                if ($this->duplicateUpload($cachedId, substr($sinkPath, 9))) {
                    return ['document_id'=>'CACHE','simulated'=>false,'cache'=>true];
                }
            }
        }

// ----------------------------------

        

        // ========== DRY-RUN ==========
        if ($this->dryRun) {
            if (strpos($filePath, 'upload://') === 0 && strpos($sinkPath, 'upload://') === 0) {
                require_once 'include/upload_file.php';
                $fromId = substr($filePath, 9);
                $toId   = substr($sinkPath, 9);
                $this->ensureUploadShardDir($sinkPath);
                $up = new \UploadFile();
                if (!$up->duplicate_file($fromId, $toId)) {
                    throw new \RuntimeException('DRY-RUN: duplicate_file fehlgeschlagen.');
                }
                return ['document_id' => 'DRYRUN', 'simulated' => false];
            }
            // Fallback: kleine PDF schreiben
            $this->ensureUploadShardDir($sinkPath);
            $dst = new \GuzzleHttp\Psr7\LazyOpenStream($sinkPath, 'w');
            $dst->write($this->buildMiniPdf('DRY-RUN'));
            $dst->close();
            return ['document_id' => 'DRYRUN', 'simulated' => true];
        }

        // ========== REAL-RUN ==========
        // 1) Upload
        $srcStream = new \GuzzleHttp\Psr7\LazyOpenStream($filePath, 'r');
        $mp = [
            ['name'=>'file',        'contents'=>$srcStream, 'filename'=>$fileName],
            ['name'=>'target_lang', 'contents'=>strtoupper($targetLang)],
        ];
        if ($sourceLang !== '') {
            $mp[] = ['name'=>'source_lang', 'contents'=>strtoupper($sourceLang)];
        }

        try {
            $res = $this->http->request('POST', $this->docBase, [
                \GuzzleHttp\RequestOptions::MULTIPART => $mp,
            ]);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            throw new \RuntimeException('DeepL Upload fehlgeschlagen: '.$e->getMessage(), 0, $e);
        } finally {
            if ($srcStream instanceof \Psr\Http\Message\StreamInterface) { $srcStream->detach(); }
        }

        $j = json_decode((string)$res->getBody(), true);
        $docId  = $j['document_id']  ?? '';
        $docKey = $j['document_key'] ?? '';
        if (!$docId || !$docKey) {
            throw new \RuntimeException('DeepL Dokument-Upload fehlgeschlagen.');
        }

        // 2) Poll
        $maxWait=180; $delay=1; $elapsed=0; $st='unknown';
        do {
            try {
                $status = $this->http->request('POST', "{$this->docBase}/{$docId}", [
                    \GuzzleHttp\RequestOptions::FORM_PARAMS => ['document_key'=>$docKey],
                    \GuzzleHttp\RequestOptions::TIMEOUT     => 15,
                ]);
            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                throw new \RuntimeException('DeepL Status fehlgeschlagen: '.$e->getMessage(), 0, $e);
            }
            $sj = json_decode((string)$status->getBody(), true);
            $st = $sj['status'] ?? 'unknown';

            if ($st === 'done') break;
            if ($st === 'error') {
                $msg = trim($sj['message'] ?? 'Unbekannter Fehler bei DeepL.');
                if (stripos($msg, 'Source and target language are equal') !== false) {
                    throw new \RuntimeException('DEEPL_SAME_LANG');
                }
                throw new \RuntimeException("DeepL Dokument-Fehler: {$msg}");
            }

            sleep($delay);
            $elapsed += $delay;
            $delay = min($delay+1, 5);
        } while ($elapsed < $maxWait);

        if ($st !== 'done') {
            throw new \RuntimeException('DeepL: Übersetzung nicht rechtzeitig abgeschlossen.');
        }

        // 3) Result holen
        try {
            $result = $this->http->request('POST', "{$this->docBase}/{$docId}/result", [
                \GuzzleHttp\RequestOptions::FORM_PARAMS => ['document_key'=>$docKey],
                \GuzzleHttp\RequestOptions::STREAM      => true,
                \GuzzleHttp\RequestOptions::TIMEOUT     => 60,
            ]);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            if ($simulateOnError) {
                $this->ensureUploadShardDir($sinkPath);
                $dst = new \GuzzleHttp\Psr7\LazyOpenStream($sinkPath, 'w');
                $dst->write($this->buildMiniPdf('SIMULIERT – Download-Fehler'));
                $dst->close();
                return ['document_id'=>$docId, 'simulated'=>true];
            }
            throw new \RuntimeException('DeepL Download fehlgeschlagen: '.$e->getMessage(), 0, $e);
        }

        $ctype = $result->getHeaderLine('Content-Type');
        if (stripos($ctype, 'pdf') === false) {
            if ($simulateOnError) {
                $this->ensureUploadShardDir($sinkPath);
                $dst = new \GuzzleHttp\Psr7\LazyOpenStream($sinkPath, 'w');
                $dst->write($this->buildMiniPdf('SIMULIERT – kein PDF'));
                $dst->close();
                return ['document_id'=>$docId, 'simulated'=>true];
            }
            $probe = '';
            try { $probe = substr((string)$result->getBody()->read(256), 0, 256); } catch (\Throwable $t) {}
            throw new \RuntimeException('DeepL lieferte kein PDF. Typ='.$ctype.' Probe='.$probe);
        }

        // 4) Kopieren nach upload://
        $body = $result->getBody();
        if (method_exists($body, 'isSeekable') && $body->isSeekable()) { $body->rewind(); }

        $this->ensureUploadShardDir($sinkPath);
        $dst = new \GuzzleHttp\Psr7\LazyOpenStream($sinkPath, 'w');

        try {
            if (method_exists(\GuzzleHttp\Psr7\Utils::class, 'copyToStream')) {
                \GuzzleHttp\Psr7\Utils::copyToStream($body, $dst);
            } else {
                \GuzzleHttp\Psr7\copy_to_stream($body, $dst);
            }
        } finally {
            if ($dst instanceof \Psr\Http\Message\StreamInterface) { try { $dst->close(); } catch (\Throwable $e) {} }
            if ($body instanceof \Psr\Http\Message\StreamInterface) { try { $body->detach(); } catch (\Throwable $e) {} }
        }
        $st = ['exists'=>false,'size'=>null,'md5'=>null];
        try {
            $probe = new \GuzzleHttp\Psr7\LazyOpenStream($sinkPath,'r');
            $h = hash_init('md5'); $total = 0;
            while (!$probe->eof()) { $buf = $probe->read(65536); if ($buf==='') break; $total += strlen($buf); hash_update($h,$buf); }
            $st = ['exists'=>true,'size'=>$total,'md5'=>hash_final($h)];
            $probe->detach();
        } catch (\Throwable $e) {}

        // ---------- CACHE-SAVE ----------
        $cacheData = [
            'upload_id' => substr($sinkPath, 9),
            'src_hash'  => $srcHash,
            'src_lang'  => strtoupper($sourceLang ?: ''),
            'tgt_lang'  => strtoupper($targetLang),
            'size'      => $st['size'],
            'md5'       => $st['md5'],
            'ts'        => gmdate('c'),
        ];
        $this->cacheSave($cacheKey, $cacheData);
// ----------------------------------
        return ['document_id' => $docId, 'simulated' => false];
    }

    private function isMockEnabled(): bool
    {
        $hdr = $_SERVER['HTTP_X_ISC_MOCK'] ?? null;
        if ($hdr !== null) {
            return ($hdr === '1' || strtolower((string)$hdr) === 'true');
        }
        if (class_exists(\Administration::class)) {
            $adm = new \Administration();
            $adm->retrieveSettings('isc_deepl');
            return !empty($adm->settings['isc_deepl_mock']);
        }
        return false;
    }

    private function buildMiniPdf(string $text): string
    {
        $text   = preg_replace('/[()\\\\]/','',$text);
        $stream = "BT /F1 12 Tf 50 800 Td ($text) Tj ET";
        $len    = strlen($stream);
        return "%PDF-1.4\n".
            "1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n".
            "2 0 obj<</Type/Pages/Count 1/Kids[3 0 R]>>endobj\n".
            "3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 595 842]/Contents 4 0 R>>endobj\n".
            "4 0 obj<</Length $len>>stream\n$stream\nendstream\nendobj\n".
            "xref\n0 5\n0000000000 65535 f \n".
            "0000000010 00000 n \n0000000061 00000 n \n".
            "0000000122 00000 n \n0000000242 00000 n \n".
            "trailer<</Root 1 0 R/Size 5>>\nstartxref\n350\n%%EOF";
    }


    private function ensureUploadShardDir(string $uploadUri): void
    {
        if (strpos($uploadUri, 'upload://') !== 0) return;
        $guid  = substr($uploadUri, 9);
        $first = explode('-', $guid)[0] ?? '';
        if ($first === '') return;
        $shard = substr($first, -3);
        $dir = 'upload/'.$shard;
        if (class_exists(\SugarAutoLoader::class)) {
            \SugarAutoLoader::ensureDir($dir);
        }
    }


    /** ------- Logging-Helper ------- */

    private function slog(string $cid, string $level, string $msg, array $ctx = []): void
    {
        $line = "[DeepL:$cid] $msg" . ($ctx ? ' ' . json_encode($ctx, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) : '');
        switch ($level) {
            case 'error': $GLOBALS['fatal']->error($line); break;
            case 'warn':  $GLOBALS['fatal']->warn($line);  break;
            case 'info':  $GLOBALS['fatal']->info($line);  break;
            default:      $GLOBALS['fatal']->debug($line); break;
        }
    }

    private function safeHeaders($res): array
    {
        // nur relevante, unverfängliche Header
        return [
            'status' => method_exists($res,'getStatusCode') ? $res->getStatusCode() : null,
            'content_type' => method_exists($res,'getHeaderLine') ? $res->getHeaderLine('Content-Type') : null,
            'content_length' => method_exists($res,'getHeaderLine') ? $res->getHeaderLine('Content-Length') : null,
            'req_id' => method_exists($res,'getHeaderLine') ? ($res->getHeaderLine('x-request-id') ?: $res->getHeaderLine('x-amzn-requestid')) : null,
        ];
    }

    private function maskKey(string $s, int $keep = 4): string
    {
        if ($s === '') return '';
        return substr($s, 0, $keep) . str_repeat('*', max(0, strlen($s) - 2*$keep)) . substr($s, -$keep);
    }

    private function logUploadFileStats(string $cid, string $path, string $label): void
    {
        $exists = false; $size = null; $md5 = null;
        try {
            $s = new \GuzzleHttp\Psr7\LazyOpenStream($path, 'r');
            $exists = true;
            $h = hash_init('md5');
            $total = 0;
            while (!$s->eof()) {
                $buf = $s->read(65536);
                if ($buf === '') break;
                $total += strlen($buf);
                hash_update($h, $buf);
            }
            $size = $total;
            $md5  = hash_final($h);
            $s->detach();
        } catch (\Throwable $e) {
            // bleibt exists=false
        }
        $this->slog($cid,'info','upload:// stats',[
            'label'=>$label,'path'=>$path,'exists'=>$exists,'size'=>$size,'md5'=>$md5
        ]);
    }


    private function logStream(string $cid, string $name, $s): void
    {
        if ($s instanceof \Psr\Http\Message\StreamInterface) {
            $meta = $s->getMetadata();
            $uri  = is_array($meta) && isset($meta['uri']) ? $meta['uri'] : 'n/a';
            $this->slog($cid, 'debug', 'Stream meta', [
                'name'     => $name,
                'readable' => method_exists($s,'isReadable') ? (bool)$s->isReadable() : null,
                'writable' => method_exists($s,'isWritable') ? (bool)$s->isWritable() : null,
                'seekable' => method_exists($s,'isSeekable') ? (bool)$s->isSeekable() : null,
                'uri'      => $uri
            ]);
        } else {
            $this->slog($cid, 'debug', 'Stream meta (non-psr)', ['name' => $name, 'type' => gettype($s)]);
        }
    }

    private function computeUploadSha256(string $uploadUri): string
    {
        $h = hash_init('sha256');
        $s = new LazyOpenStream($uploadUri, 'r');
        try {
            while (!$s->eof()) {
                $buf = $s->read(32768);
                if ($buf !== '') { hash_update($h, $buf); }
            }
        } finally {
            if ($s instanceof StreamInterface) { $s->detach(); } // kein close()
        }
        return hash_final($h);
    }

    private function makeCacheKey(string $srcHash, string $src, string $tgt, array $opts = []): string
    {
        $src = strtolower($src ?: '');
        $tgt = strtolower($tgt ?: '');
        // relevante Deepl-Optionen in den Key aufnehmen, falls genutzt
        $sig = json_encode(['src'=>$src,'tgt'=>$tgt,'opts'=>$opts], JSON_UNESCAPED_SLASHES);
        return hash('sha256', $srcHash.'|'.$sig);
    }

    private function cachePath(string $key): string
    {
        $base = 'upload/isc_deepl_cache';
        $sub  = substr($key, 0, 2);
        if (class_exists(\SugarAutoLoader::class)) {
            \SugarAutoLoader::ensureDir("$base/$sub");
        }
        return "$base/$sub/$key.json";
    }

    private function cacheLoad(string $key): ?array
    {
        $p = $this->cachePath($key);
        try {
            $s = new \GuzzleHttp\Psr7\LazyOpenStream($p, 'r');
            $json = (string)$s->getContents();
            $s->detach();
            $d = json_decode($json, true);
            return is_array($d) ? $d : null;
        } catch (\Throwable $e) {
            return null;
        }
    }


    private function cacheSave(string $key, array $data): void
    {
        $p = $this->cachePath($key); // stellt Unterordner sicher
        $s = new \GuzzleHttp\Psr7\LazyOpenStream($p, 'w');
        try {
            $s->write(json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
        } finally {
            $s->close();
        }
    }

    private function duplicateUpload(string $fromUploadId, string $toUploadId): bool
    {
        require_once 'include/upload_file.php';
        $up = new \UploadFile();
        return (bool)$up->duplicate_file($fromUploadId, $toUploadId);
    }





}
