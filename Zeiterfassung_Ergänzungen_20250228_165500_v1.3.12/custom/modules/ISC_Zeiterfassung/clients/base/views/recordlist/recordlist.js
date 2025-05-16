/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 03.12.2018
 * Change Date   : 08.02.2019
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Contains the logic of the create button, adds model to the
 *                 collection instead of saving the bean.
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 01.02.2019  RK      Added double CLick to edit functionality and checks for
 *                     unsaved changes
 * 05.02.2019  TF      chain dates for creation only for current entries
 * 08.02.2019  TF      refined date handling for creation
 * 02.07.2019  RK      Checking for toggled models when sorting
 * 28.02.2025  AR      Added project task field listener to update the
 *                     description field dynamically
 * ----------------------------------------------------------------------------
 */
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Views.Base.RecordlistView
 * @alias SUGAR.App.view.views.BaseRecordlistView
 * @extends View.Views.Base.FlexListView
 */
({
    extendsFrom: 'RecordlistView',

    /**
     * @override
     * @param {Object} options
     */
    initialize: function (options) {
        this._super("initialize", [options]);
        app.controller.context.on('isc:setEditable', this.insertNewEditableRow, this);
        app.controller.context.on('isc:editClicked', this.doubleClickEdit, this);
        //ISC GmbH, AR, 2025-02-28: Register a collection event listener for changes
        this.listenTo(this.collection, 'change:projecttask_isc_zeiterfassung_1_name', this.handleTaskChange);
    },

    /**
     * ISC GmbH, AR, 2025-02-28: Event handler for project task changes.
     * Updates the description field based on the new task value.
     *
     * @param {Backbone.Model} model - The model that changed.
     * @param {string} newTaskValue - New value for the project task field.
     * @param {Object} options - Additional options.
     */
    handleTaskChange: function(model, newTaskValue, options)
    {
        // Avoid infinite loops by checking the source of the change
        if (options && options.source === 'handleTaskChange') {
            return;
        }
        // Get the current description from the model
        let currentDescription = model.get('description') || '';

        // Update the description based on the new task value
        if (newTaskValue) {
            this.updateDescription(model, newTaskValue, currentDescription);
        } else {
            this.updateDescription(model, '', currentDescription);
        }
    },

    /**
     * ISC GmbH, AR, 2025-02-28: Updates the description field.
     * The description is prefixed with the task name in the format: '[TaskName]':
     *
     * @param {Backbone.Model} model - The model to update.
     * @param {string} taskName - The name of the selected project task.
     * @param {string} currentDescription - The current description.
     */
    updateDescription: function(model, taskName, currentDescription) {
        // Create the expected prefix based on the task name
        let expectedPrefix = taskName ? "'[" + taskName + "]': " : '';
        // Handle case when no task is selected
        if (!taskName) {

            setTimeout(function() {
                let updatedDescription = model.get('description') || '';
                let match = updatedDescription.match(/^'?\[[^\]]+\]'?:\s*/);

                if (match) {
                    // If description is just the prefix, clear it; otherwise, remove the prefix
                    if (updatedDescription.trim() === match[0].trim()) {
                        model.set('description', '', { source: 'handleTaskChange' });
                    } else {
                        let cleanedDescription = updatedDescription.substring(match[0].length);

                        model.set('description', cleanedDescription, { source: 'handleTaskChange' });
                    }
                } else {

                }
            }, 100); // 100ms
            return;
        }
        // If description is empty, set it to the expected prefix
        if (currentDescription.trim() === "") {
            model.set('description', expectedPrefix, { source: 'handleTaskChange' });
            return;
        }
        // If description already has a prefix, replace it; otherwise, prepend the new prefix
        if (/^'?\[[^\]]+\]'?:\s*!/.test(currentDescription)) {
            let newDescription = currentDescription.replace(/^'?\[[^\]]+\]'?:\s*/, expectedPrefix);
            if (newDescription !== currentDescription) {
                model.set('description', newDescription, { source: 'handleTaskChange' });
            }
        } else {
            let newDescription = expectedPrefix + currentDescription;
            model.set('description', newDescription, { source: 'handleTaskChange' });
        }
    },


    /**
     * Gets called from double clicking in List View
     * Uses name to get the model and set it editable
     * ISC GmbH RK 11.01.2019
     * @param name
     */
    doubleClickEdit: function(name) {
        if (name) {
            var id = name.slice(-36);
            if (!this.toggledModels[id]) {
                var model = this.collection.findWhere({'id' : id});
                this.editClicked(model, {'def': ''});
            }
        }
    },

    /**
     * ISC GmbH RK 20.11.2018
     * insertNewEditableRow:
     * Creates new Bean, adds it to the collection and triggers edit clicked
     */
    /*insertNewEditableRow: function(startDate, stopDate) {
        var self=this;
        var suDate = "";
        var id = app.utils.generateUUID();
        if (!startDate && !stopDate) {
            for (var n = 0; n < this.collection.models.length; n++) {
                if (n == 0) {
                    suDate = this.collection.models[n].attributes.date_to;
                    continue;
                }
                if (Date.parse(this.collection.models[n].attributes.date_to) > Date.parse(suDate) ) {
                    suDate = this.collection.models[n].attributes.date_to;
                }
            }
            stopDate = suDate;
        } else {
            startDate = app.date(startDate).formatServer();
            stopDate = app.date(stopDate).formatServer();
        }
        if (suDate == "") {
            if (!startDate) {
                if (!stopDate) {
                    suDate = this.getSuDate();
                    stopDate = suDate;
                }
            }else {
                suDate = startDate;
            }

        }
        var NewZeit = app.data.createBean('ISC_Zeiterfassung',
            {'id': id,'date_from': suDate, 'date_to': stopDate, 'assigned_user_id': app.user.get('id'),
                'assigned_user_name': app.user.get('full_name'), 'project_isc_zeiterfassung_1_name': "", 'projecttask_isc_zeiterfassung_1_name': "",
                'description': ""});
        this.collection.add(NewZeit, {at: 0});
        this.render();
        this.editClicked(this.collection.models[0], {'def': ''});
        for (var i in this.toggledModels) {
            if (i === id) {
                continue;
            }
            this.editClicked(this.toggledModels[i], {'def': ''});
        }
    },*/

    /**
     * ISC GmbH RK 20.11.2018
     * insertNewEditableRow:
     * Creates new Bean, adds it to the collection and triggers edit clicked
     */
    insertNewEditableRow: function(startDate, stopDate) {
        var id = app.utils.generateUUID();
        if (startDate === "newrow") {
            var sFromDate = '';
            var sToDate = this.getSuDate();

            if (this.collection.models.length > 0) {
                for (let n = 0; n < this.collection.models.length; n++) {
                    if (this.isLaterThatDay(sFromDate, this.collection.models[n].attributes.date_to)) {
                        sFromDate = this.collection.models[n].attributes.date_to;
                    }
                }
            }
            if (sFromDate == '') {
                //no current entry
                sFromDate = sToDate;
            } else {
                //entries of the day are greater than the actual time
                if (Date.parse(sToDate) < Date.parse(sFromDate)) {
                    sToDate = sFromDate;
                }
            }
            var NewZeit = app.data.createBean(
                'ISC_Zeiterfassung',
                {
                    'id': id,
                    'date_from': sFromDate,
                    'date_to': sToDate,
                    'assigned_user_id': app.user.get('id'),
                    'assigned_user_name': app.user.get('full_name'),
                    'project_isc_zeiterfassung_1_name': "",
                    'projecttask_isc_zeiterfassung_1_name': "",
                    'description': ""
                }
            );
        } else {
            startDate = app.date(startDate).formatServer();
            stopDate = app.date(stopDate).formatServer();
            var NewZeit = app.data.createBean('ISC_Zeiterfassung',
                {'id': id,'date_from': startDate, 'date_to': stopDate, 'assigned_user_id': app.user.get('id'),
                    'assigned_user_name': app.user.get('full_name'), 'project_isc_zeiterfassung_1_name': "", 'projecttask_isc_zeiterfassung_1_name': "",
                    'description': ""});
        }

        this.collection.add(NewZeit, {at: 0});
        this.render();
        this.editClicked(this.collection.models[0], {'def': ''});
        for (let i in this.toggledModels) {
            if (i === id) {
                continue;
            }
            this.editClicked(this.toggledModels[i], {'def': ''});
        }
    },

    /**
     * ISC 02.07.2019 RK: Modified to check for toggled models
     * Sets order by on collection and view.
     *
     * The event is canceled if an element being dragged is found.
     *
     * @param {Event} event jQuery event object.
     */
    setOrderBy: function(event) {
      self = this;
      if (this.warnUnsavedChanges(function(){self.removeEditableModelsAndSort(event)},null, null)) {
          this._super("setOrderBy", [event]);
      }
    },

    removeEditableModelsAndSort(event) {
        for (var i in this.toggledModels) {
            delete this.toggledModels[i];
        }
        this._super("setOrderBy", [event]);
    },

    /**
     * Compare if date is greater than the current date (for the same day)
     * @param {string} sDateTo date string currently set
     * @param {string} sNewDateTo date string to compare
     * @return {boolean} greater than input
     */
    isLaterThatDay: function (sDateTo, sNewDateTo) {
        var bGreater = false;

        var dDateTo;
        if (sDateTo == '') {
            //current date if nothing is set
            dDateTo = new Date();
            dDateTo.setHours(0, 0, 0, 0);
        } else {
            dDateTo = new Date(sDateTo);
        }

        dNewDateTo = new Date(sNewDateTo);

        //compare if it matches the day
        if (
            dDateTo.getFullYear() === dNewDateTo.getFullYear() &&
            dDateTo.getMonth() === dNewDateTo.getMonth() &&
            dDateTo.getDate() === dNewDateTo.getDate()
        ) {
            bGreater = Date.parse(dNewDateTo) > Date.parse(dDateTo);
        }

        return bGreater;
    },

    render: function () {
        var self = this;
        this._super("render");
        var Mid = $("#QuickCreateModelId").val();
        if (Mid != '') {
            $('#QuickCreateModelId').val('');
            _.each(this.collection.models, function (Model, index) {
                if (Mid == Model.attributes.id) {
                    var fi = {'def': ''};
                    self.editClicked(Model, fi);
                }
            }
            );
        }
    },

    /**
     * ISC GmbH RK: 07.01.2018
     *If there are toggled models, then return true, else false.
     * We need this because otherwise the user could leave the module without saving.
     * @returns {boolean}
     */
    hasUnsavedChanges: function() {
        if ((Object.keys(this.toggledModels).length === 0) || (!this.toggledModels)) {
            return false;
        }
        return true;
    },

    /**
     * Popup dialog message to confirm delete action
     *
     * @param {Backbone.Model} model the bean to delete
     */
    warnDelete: function (model) {
        var self = this;
        self._targetUrl = Backbone.history.getFragment();
        if (_.isEmpty(model.get('project_isc_zeiterfassung_1project_ida')))
        {
            self._modelToDelete = model;
            self.deleteModel();
        } else {
            //self._super("warnDelete", [model]);
            self.parentWarnDelete(model);
        }

    },

    parentWarnDelete: function (model) {
        var self = this;
        this._modelToDelete = model;

        self._targetUrl = Backbone.history.getFragment();
        //Replace the url hash back to the current staying page
        if (self._targetUrl !== self._currentUrl) {
            app.router.navigate(self._currentUrl, {trigger: false, replace: true});
        }

        app.alert.show('delete_confirmation', {
            level: 'confirmation',
            messages: self.getDeleteMessages(model).confirmation,
            onConfirm: function() {
                self.deleteModel();
            },
            onCancel: function() {
                self._modelToDelete = null;
            }
        });
    },

    /**
     * Delete the model once the user confirms the action
     */
    deleteModel: function() {
        var self = this,
            model = this._modelToDelete;

        model.destroy({
            //Show alerts for this request
            showAlerts: {
                'process': true,
                'success': {
                    messages: self.getDeleteMessages(self._modelToDelete).success
                }
            },
            success: function() {
                var redirect = self._targetUrl !== self._currentUrl;
                self._modelToDelete = null;
                self.collection.remove(model, { silent: redirect });
                if (redirect) {
                    self.unbindBeforeRouteDelete();
                    //Replace the url hash back to the current staying page
                    app.router.navigate(self._targetUrl, {trigger: true});
                    return;
                }
                app.events.trigger("preview:close");
                if (!self.disposed) {
                    self.render();
                }

                self.layout.trigger("list:record:deleted", model);
                for (var i in self.toggledModels) {
                    self.editClicked(self.toggledModels[i], {'def': ''});
                }
            }
        });
    },

    getSuDate: function ()
    {
        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1;
        var year = currentDate.getFullYear();
        var Hour = currentDate.getHours();
        var Min = currentDate.getMinutes();
        var Offset = currentDate.getTimezoneOffset() / 60;
        Offset = -Offset;
        if (Offset < 10) {
            var Offset_tmp = '0' + String(Offset);
            Offset = Offset_tmp;
        }
        if (day < 10)
        {
            var day_tmp = '0' + String(day);
            day = day_tmp;
        }
        if (month < 10)
        {
            var month_tmp = '0' + String(month);
            month = month_tmp;
        }
        if (Hour < 10)
        {
            var Hour_tmp = '0' + String(Hour);
            Hour = Hour_tmp;
        }
        Minutes = '00';

        if (Min > 14 && Min < 30)
        {
            Minutes = '15';
        }
        if (Min > 29 && Min < 45)
        {
            Minutes = '30';
        }
        if (Min > 44)
        {
            Minutes = '45';
        }
        return year + '-' + month + '-' + day + 'T' + Hour + ':' + Minutes + ':00+' + Offset + ':00';
    },

})
