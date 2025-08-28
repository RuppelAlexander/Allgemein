/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 15.07.2025
 * Main Program  : ISC_DeepL_Translator
 * Description   : Englisch → Deutsch Übersetzung + Kopier-Button
 * ----------------------------------------------------------------------------
 */

//custom/modules/Tasks/clients/base/fields/isc_translate_en2de-rowaction/isc_translate_en2de-rowaction.js
({
    extendsFrom: 'ButtonField',
    baseClass  : 'isc-translate-en2de-btn',

    initialize: function (opts) {
        opts.def.events = _.extend({}, opts.def.events, {
            'click .isc-translate-en2de-btn': 'translate'
        });
        this._super('initialize', [opts]);
    },

    /* ---------- Action ---------- */
    translate: function () {
        var text = this.model.get('description') || '';
        if (!text.trim()) {
            app.alert.show('isc-no-desc',{
                level:'info',
                messages: app.lang.get('LBL_ISC_DEEPL_NO_DESC')
            });
            return;
        }

        app.alert.show('isc-tx',{
            level:'info',
            messages: app.lang.get('LBL_ISC_DEEPL_TX_EN2DE'),
            autoClose:false
        });

        app.api.call('create', app.api.buildURL('isc/deepl/translate'), {
            text        : text,
            source_lang : 'EN',
            target_lang : 'DE'
        },{
            success : _.bind(this._handleSuccess,this),
            error   : _.bind(this._handleError,  this)
        });
    },

    /* ---------- Erfolg ---------- */
    _handleSuccess: function (data) {
        app.alert.dismiss('isc-tx');

        
        this._fullText = data.translated;
        var full    = data.translated,
            preview = _.escape(full.length > 400 ? full.substring(0,400) + ' …' : full);
        
        var lang   = app.lang.getLanguage() || 'en_US',
            locale = lang.startsWith('de') ? 'de-DE' : 'en-US',
            fmt    = new Intl.NumberFormat(locale),
            used   = fmt.format(data.usage.used),
            limit  = fmt.format(data.usage.limit);

        var body =
            '<div style="max-height:220px;overflow:auto;">'+ preview +'</div>' +
            /* gesamter Text unsichtbar für Copy/Note */
            '<div id="isc-tx-text" style="display:none;">'+ _.escape(full) +'</div>' +
            '<br><small>' + app.lang.get('LBL_ISC_DEEPL_USAGE')
                .replace('%1$s', used).replace('%2$s', limit) + '</small>' +
            '<br>' +
            '<button class="btn btn-xs btn-primary isc-copy m-t-2 m-r-1">' +
            app.lang.get('LBL_ISC_COPY_BTN') +
            '</button>' +
            '<button class="btn btn-xs btn-secondary isc-note m-t-2">' +
            app.lang.get('LBL_ISC_NOTE_BTN') +
            '</button>';

        app.alert.show('isc-result',{level:'info', messages: body, autoClose:false});

        /* Kopier-Button einmalig binden */
        $(document).off('click.iscCopy click.iscNote')
            .on('click.iscCopy', '.isc-copy', _.bind(this._copyToField,this))
            .on('click.iscNote', '.isc-note', _.bind(this._createNote,this));
        
        /* Quota-Warnung */
        var p = data.usage.percent;
        if (p >= 95) {
            app.alert.show('isc-quota',{level:'error',
                messages: app.lang.get('LBL_ISC_DEEPL_QUOTA_95')});
        } else if (p >= 50) {
            app.alert.show('isc-quota',{level:'warning',
                messages: app.lang.get('LBL_ISC_DEEPL_QUOTA_50')});
        }
    },

    /* ---------- Fehler ---------- */
    _handleError: function (e) {
        app.alert.dismiss('isc-tx');
        app.alert.show('isc-err',{
            level:'error',
            autoClose:true,
            messages: e.message || app.lang.get('LBL_ISC_DEEPL_BACKEND_ERR')
        });
    },

    /* ---------- Kopieren in Feld uebersetzung_c ---------- */
    _copyToField: function () {

        var txt = this._fullText || $('#isc-tx-text').text();

        this.model.set('uebersetzung_c', txt);
        this.model.save(null,{
            success: () => app.alert.show('isc-copy-ok',{
                level:'success',
                messages: app.lang.get('LBL_ISC_COPIED'),
                autoClose:true }),
            error  : e => app.alert.show('isc-copy-err',{
                level:'error',
                messages: e.message,
                autoClose:true })
        });
    } ,



    _createNote: function () {
        var $btn = $('.isc-note').prop('disabled', true);
        var txtFull = $('#isc-tx-text').text();
        var parentId      = this.model.id;
        var parentSubject = this.model.get('name') || '';

        /* 1) Busy-Hinweis */
        app.alert.show('isc-note-wait', {
            level     : 'info',
            messages  : '…',
            autoClose : false
        });

        app.api.call(
            'create',
            app.api.buildURL('isc/deepl/note'),
            {
                parent_id      : parentId,
                parent_subject : parentSubject,
                source_lang    : 'EN',
                target_lang    : 'DE',
                translation    : txtFull
            },
            {

                success: _.bind(function (res) {

                    app.alert.dismiss('isc-note-wait');
                    app.alert.show('isc-note-ok', {
                        level     : 'success',
                        messages  : app.lang.get('LBL_ISC_NOTE_OK'),
                        autoClose : true
                    });

                    var notesCol = this.model.getRelatedCollection('notes');
                    if (notesCol) {
                        var stub = app.data.createBean('Notes', { id: res.id });
                        notesCol.add(stub, { at: 0, silent: true });
                        notesCol.fetch({ relate: true });
                    } else {
                        app.logger.warn('Notes-Collection nicht gefunden – Subpanel bleibt unverändert.');
                    }
                    $btn.prop('disabled', false);
                }, this),

                /* -------- Fehler -------- */
                error: _.bind(function (e) {
                    app.alert.dismiss('isc-note-wait');
                    app.alert.show('isc-note-err', {
                        level     : 'error',
                        messages  : e.message,
                        autoClose : true
                    });
                    $btn.prop('disabled', false);
                }, this)
            }
        );
    },


    
    

})
