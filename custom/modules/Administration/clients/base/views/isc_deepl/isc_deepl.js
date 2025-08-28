/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 11.07.2025
 * Change Date   : 11.07.2025
 * Main Program  : ISC_DeepL_Translator
 * Description   : isc_deepl.js
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

/*custom/modules/Administration/clients/base/views/isc_deepl/isc_deepl.js*/

({
    extendsFrom: 'BaseView',

    initialize: function(opts){
        this._super('initialize',[opts]);
        this.once('render', this.load, this);
    },

    events:{
        'click .isc-save'  : 'save',
        'click .isc-close' : function(){app.router.navigate('#Administration',{trigger:true});},
        'click .isc-test'  : 'testKey'
    },


    testKey: function(){
        var self=this;
        app.alert.show('isc-test-wait',{level:'process',title:'',messages:'…',autoClose:false});
        app.api.call('read', app.api.buildURL('isc_deepl/test'), {}, {
            success:function(res){
                app.alert.dismiss('isc-test-wait');
                var lbl = res.valid
                    ? 'LBL_ISC_DEEPL_TEST_OK'
                    : 'LBL_ISC_DEEPL_TEST_FAIL';
                var lvl = res.valid ? 'success' : 'error';
                app.alert.show('isc-test', {level:lvl, messages: app.lang.get(lbl), autoClose:true});
            },
            error:function(e){
                app.alert.dismiss('isc-test-wait');
                app.alert.show('isc-test', {level:'error', messages:e.message, autoClose:true});
            }
        });
    },

    load: function(){
        var self=this;
        app.api.call('read', app.api.buildURL('isc_deepl/load'), {}, {
            success:function(res){
                self.$('input[name="iscKey"]').val(res.key||'');
            }
        });
    },

    save:function(){
        var key = this.$('input[name="iscKey"]').val().trim();
        var url = app.api.buildURL('isc_deepl/save');
        app.api.call('create', url, {key:key},{
            success: ()=> app.alert.show('isc-ok',{level:'success',messages:'✓ gespeichert', autoClose: true}),
            error  : e => app.alert.show('isc-err',{level:'error',messages:e.message, autoClose: true})
        });
    }
})
