/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 13.08.2025
 * Change Date   : 13.08.2025
 * Main Program  : ISC_DeepL_Translator
 * Description   :
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
({
    extendsFrom: 'ButtonField',
    baseClass  : 'isc-pdf2de-btn',

    initialize: function (opts) {
        opts = opts || {};
        opts.def = opts.def || {};

        // Klick-Handler exakt wie bei deinen anderen Buttons
        opts.def.events = _.extend({}, opts.def.events, {
            'click .isc-pdf2de-btn': '_preflight'
        });

        this._super('initialize', [opts]);
    },

    /**
     * Preflight: prüft Datei/MIME/Größe/Quota (kostenlos) und fragt um Bestätigung.
     */
    _preflight: function () {
        var m = this.model;

        app.alert.show('isc-pdf2de-pre', {
            level    : 'info',
            messages : 'Prüfe Voraussetzungen …',
            autoClose: false
        });

        app.api.call('create',
            app.api.buildURL('isc/deepl/note/pdf/preflight'),
            { note_id: m.id },
            {
                success: _.bind(function (res) {
                    app.alert.dismiss('isc-pdf2de-pre');

                    if (!res || res.ok === false) {
                        var msg = (res && res.message) ? res.message : 'Preflight fehlgeschlagen.';
                        app.alert.show('isc-preflight-fail', { level: 'error', messages: msg, autoClose: true });
                        return;
                    }

                    var rest = (res.remaining_characters || 0).toLocaleString();
                    var min  = (res.min_charge_per_doc || 50000).toLocaleString();

                    var msgHtml = '<b>Warnung:</b> Dokument ist OK.<br>' +
                        'Mindestabrechnung: ' + min + ' Zeichen.<br>' +
                        'Verfügbar: ' + rest + ' Zeichen. Übersetzung starten?';

                    app.alert.show('isc-pdf2de-confirm', {
                        level     : 'confirmation',
                        messages  : msgHtml,
                        onConfirm : _.bind(this._runTranslation, this),
                        onCancel  : function () {}
                    });
                }, this),
                error: function (e) {
                    app.alert.dismiss('isc-pdf2de-pre');
                    app.alert.show('isc-preflight-err', {
                        level: 'error', autoClose: true,
                        messages: (e && e.message) ? e.message : 'Preflight-Fehler.'
                    });
                }
            }
        );
    },

    /**
     * Startet die echte PDF-Übersetzung auf dem Server.
     */
    _runTranslation: function () {
        var m = this.model;

        app.alert.show('isc-pdf2de-wait', {
            level    : 'info',
            messages : app.lang.get('LBL_ISC_PDF2DE_WAIT') || 'Übersetze PDF …',
            autoClose: false
        });

        app.api.call('create',
            app.api.buildURL('isc/deepl/note/pdf'),
            { note_id: m.id, target_lang: 'DE' },
            {
                success: _.bind(function (res) {
                    if (res && res.ok === false && res.reason === 'SAME_LANG') {
                        app.alert.dismiss('isc-pdf2de-wait');
                        app.alert.show('isc-same-lang', {
                            level: 'warning',
                            title: app.lang.getAppString('LBL_ISC_DEEPL_SAME_LANG_TITLE'),
                            messages: res.message || app.lang.getAppString('LBL_ISC_DEEPL_SAME_LANG_MSG'),
                            autoClose: false
                        });
                        return;
                    }
                    
                    app.alert.dismiss('isc-pdf2de-wait');
                    app.alert.show('isc-pdf2de-ok', {
                        level: 'success',
                        messages: app.lang.get('LBL_ISC_PDF2DE_OK') || 'Übersetztes PDF wurde erstellt.',
                        autoClose: true
                    });

                    // Relate-Feld sofort lokal setzen (Name + ID) und danach serverseitig nachladen
                    this._applyRelateFromResponse(res);
                }, this),
                error: function (e) {
                    app.alert.dismiss('isc-pdf2de-wait');
                    app.alert.show('isc-pdf2de-err', {
                        level: 'error', autoClose: false,
                        messages: (e && e.message) ? e.message : 'Fehler bei der PDF-Übersetzung.'
                    });
                }
            }
        );
    },

    /**
     * Trägt das Dokument in das Relate-Feld 'uebersetzungs_anhang_c' ein (inkl. GUID).
     * Liest den tatsächlichen ID-Feldnamen aus den Vardefs (id_name).
     */
    _applyRelateFromResponse: function (res) {
        var m = this.model;
        if (!res || !res.document_id || !res.document_name) {
            // Fallback: einfach refetchen
            m.fetch();
            return;
        }

        // id_name des Relate-Feldes sicher ermitteln
        var fldDef  = (m.fields && m.fields.uebersetzungs_anhang_c) ||
            (app.metadata.getModule('Notes').fields['uebersetzungs_anhang_c']);
        var idField = (fldDef && fldDef.id_name) ? fldDef.id_name : 'uebersetzungs_anhang_id_c';

        m.set('uebersetzungs_anhang_c', res.document_name);
        m.set(idField,                  res.document_id);

        // zur Sicherheit nochmal vom Server ziehen (z.B. für Audit/weitere Felder)
        m.fetch();
    }
});
