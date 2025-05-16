({
    /**
     * ----------------------------------------------------------------------------
     *  ISC it & software consultants GmbH
     * ----------------------------------------------------------------------------
     * Author        : RK
     * Create Date   : 03.12.2018
     * Change Date   : 03.12.2018
     * Main Program  : Extension
     * Description   : Added trigger for create Button
     * ----------------------------------------------------------------------------
     * Change Log    :
     * Date        Name    Description
     * ----------------------------------------------------------------------------
     * ----------------------------------------------------------------------------
     */
    extendsFrom: 'ListHeaderpaneView',

    QuickCreateModelId:'', // Merker fuer neu angelegten Satz
    /**
     * Initialisierung
     * @param {type} options
     * @returns {undefined}
     */
    initialize: function (options) {

        this._super('initialize', [options]);
        this.context.on('button:addtime_button:click', _.debounce(this.addtime_button, 500), this);
         this.context.on("reload", this.AfterReload, this);
        app.shortcuts.register({
            id: 'List:Headerpane:Create',
            keys: 'a',
            component: this,
            description: 'LBL_SHORTCUT_CREATE_RECORD',
            handler: function() {
                this.context.trigger('isc:setEditable', "newrow");
            }
        });
    },
    AfterReload: function(args) {
        if(this.QuickCreateModelId!=='')
        {
            var Id=this.QuickCreateModelId;
        }
    },

    /**
     * ISC GmbH RK 20.11.2018
     * addtime_button:
     * Triggers "isc:setEditable" in the recordlist to add a new row.
     */
    addtime_button: function () {
        this.context.trigger('isc:setEditable', "newrow");
    },
})
