/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 03.12.2018
 * Change Date   : 25.06.2021
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Changed behaviour of the create button aswell as save and
 *                 cancel
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 01.02.2019  RK      Added new validations aswell as bug fixes
 * 05.02.2019  TF      Exclude own id for validation and fixed setter for save
 * 28.05.2019  RK      Changed filter to validate times properly
 * 02.07.2019  RK      Changed alert message to label
 * ----------------------------------------------------------------------------
 */
({
    events: {
        'click [name=inline-save]': 'saveClicked',
        'click [name=inline-cancel]': 'cancelClicked'
    },
    extendsFrom: 'ButtonField',
    initialize: function (options) {
        this._super("initialize", [options]);
        if (this.name === 'inline-save') {
            this.model.off("change", null, this);
            this.model.on("change", function () {
                this.changed = true;
            }, this);
        }
        app.error.errorName2Keys['isc_project_projecttask_error'] = 'ISC_PROJECT_PROJECTTASK_ERROR';
        app.error.errorName2Keys['isc_projecttask_status_error'] = 'ISC_PROJECTTASK_STATUS_ERROR';
        app.error.errorName2Keys['isc_project_status_error'] = 'ISC_PROJECT_STATUS_ERROR';
        app.error.errorName2Keys['isc_project_required'] = 'ISC_PROJECT_REQUIRED';
        app.error.errorName2Keys['isc_projecttask_required'] = 'ISC_PROJECTTASK_REQUIRED';
        app.error.errorName2Keys['isc_user_required'] = 'ISC_USER_REQUIRED';
        app.error.errorName2Keys['isc_admin_required'] = 'ISC_ADMIN_REQUIRED';
        app.error.errorName2Keys['isc_projecttask_user_error'] = 'ISC_PROJECTTASK_USER_ERROR';
        app.error.errorName2Keys['isc_error_within_one_week'] = 'ISC_ERROR_WITHIN_ONE_WEEK';
    },
    _loadTemplate: function () {
        app.view.Field.prototype._loadTemplate.call(this);
        if (this.view.action === 'list' && _.indexOf(['edit', 'disabled'], this.action) >= 0) {
            this.template = app.template.getField('button', 'edit', this.module, 'edit');
        } else {
            this.template = app.template.empty;
        }
    },
    /**
     * Called whenever validation completes on the model being edited
     * @param {boolean} isValid TRUE if model is valid
     * @private
     */
    _validationComplete: function (isValid) {
        if (!isValid) {
            this.setDisabled(false);
            return;
        }
        //ISC GmbH RK 01.02.2019 Removed to fix save-bug after creating a new element
        /*if (!this.changed) {
            this.cancelEdit();
            return;
        }*/
        //ISC GmbH RK 14.01.2019: Validate if the dates overlap with an existing record
        let self = this;
        app.api.call('read', app.api.buildURL('ISC_Zeiterfassung', null, null,
            {
                "fields": ["name"], "max_num": 1, "filter": [{
                    "$and": [
                        {
                            "$or": [
                                {
                                    "$and": [
                                        {
                                            "date_from": {"$gt": this.model.attributes.date_from}
                                        },
                                        {
                                            "date_from": {"$lt": this.model.attributes.date_to}
                                        }
                                    ]
                                },
                                {
                                    "$and": [
                                        {
                                            "date_to": {"$gt": this.model.attributes.date_from}
                                        },
                                        {
                                            "date_to": {"$lt": this.model.attributes.date_to}
                                        }
                                    ]
                                },
                                {
                                    "$and": [
                                        {
                                            "date_from": {"$lt": this.model.attributes.date_from}
                                        },
                                        {
                                            "date_to": {"$gt": this.model.attributes.date_to}
                                        }
                                    ]
                                },
                                {
                                    "date_from": {"$equals": this.model.attributes.date_from}
                                },
                                {
                                    "date_to": {"$equals": this.model.attributes.date_to}
                                }
                            ]
                        },
                        {
                            "assigned_user_id": {"$equals": this.model.attributes.assigned_user_id}
                        },
                        {
                            "id": {"$not_equals": this.model.attributes.id}
                        }
                    ]
                }]
            }), null, {
            success: function (data) {
                if (data.records[0]) {
                    app.alert.show('message-id', {
                        level: 'confirmation',
                        messages: app.lang.get('LBL_ERROR_UEBERSCHNEIDUNG'),
                        autoClose: false,
                        onConfirm: function () {
                            //ISC GmbH RK 20.11.2018: We have to differ between a regular record and a new line which just got added to the
                            // collection but not yet saved to the db
                            if (self.model.attributes.date_entered) {
                                self._save();
                            } else {
                                self.saveNewRow();
                            }
                        },
                        onCancel: function () {
                            self.setDisabled(false);
                        }
                    });
                } else {
                    //ISC GmbH RK 20.11.2018: We have to differ between a regular record and a new line which just got added to the
                    // collection but not yet saved to the db
                    if (self.model.attributes.date_entered) {
                        self._save();
                    } else {
                        self.saveNewRow();
                    }
                }
            },
            error: function () {
                self.setDisabled(false);
            }
        });
    },

    validateBudget: function(model) {
        var self = this;
        if (typeof this.iscSelectedProject !== 'undefined') {
            this.iscSelectedProject.fetch({
                success: function(model) {
                    if(model.get('budget_c') !== 0 && model.get('budget_c') !== 0 && model.get('budget_c')) {
                        if (!self.checkIfAllBudgetUsed(model)) {
                            self.checkIfMostBudgetUsed(model);
                        }
                    }
                }
            });
        }
        if (typeof this.iscSelectedProjectTask !== 'undefined') {
            this.iscSelectedProjectTask.fetch({
                success: function (model) {
                    if(model.get('budget_c') !== 0 && model.get('budget_c') !== 0 && model.get('budget_c')) {
                        if (!self.checkIfAllBudgetUsed(model)) {
                            self.checkIfMostBudgetUsed(model);
                        }
                    }
                }
            });
        }
    },

    checkIfMostBudgetUsed: function (model) {
        //Check if more than 80% of the budget is used
        if ((model.get('kosten_c') >= (0.8 * model.get('budget_c')))) {
            if (model.module == 'Project') {
                app.alert.show('BudgetProjectWarning', {
                    level: 'warning',
                    messages: app.lang.getAppString('ISC_ERROR_BUDGET_PROJECT_PARTIAL'),
                    autoClose: false
                });
            } else {
                app.alert.show('BudgetProjectTaskWarning', {
                    level: 'warning',
                    messages: app.lang.getAppString('ISC_ERROR_BUDGET_PROJECT_PARTIAL'),
                    autoClose: false
                });
            }
        }
    },

    checkIfAllBudgetUsed: function (model) {
        //Check if all the budget is used
        if ((model.get('kosten_c') >= model.get('budget_c'))) {
            if (model.module == 'Project') {
                app.alert.show('BudgetProjectNotification', {
                    level: 'warning',
                    messages: app.lang.getAppString('ISC_ERROR_BUDGET_PROJECT_FULL'),
                    autoClose: false
                });
                this.notifyAboutBudget(model);
                return true;
            } else {
                app.alert.show('BudgetProjectTaskNotification', {
                    level: 'warning',
                    messages: app.lang.getAppString('ISC_ERROR_BUDGET_PROJECTTASK_FULL'),
                    autoClose: false
                });
                this.notifyAboutBudget(model, false);
                return true;
            }
        }
        return false;
    },

    notifyAboutBudget(model, isProject = true) {
        //Notification für zugewiesenen Benutzer anlegen
        var notification = app.data.createBean('Notifications');
        if (isProject) {
            notification.set('name', app.lang.getAppString('ISC_ERROR_BUDGET_PROJECT_FULL'));
        } else {
            notification.set('name', app.lang.getAppString('ISC_ERROR_BUDGET_PROJECTTASK_FULL'));
        }
        notification.set('assigned_user_id', model.get('assigned_user_id'));
        notification.set('parent_type', model.module);
        notification.set('parent_id', model.get('id'));
        notification.set('description', 'Das Budget beträgt ' + model.get('budget_c') + ' Stunden,' +
            ' jedoch wurden bereits ' + model.get('kosten_c') + ' Stunden gebucht!');
        notification.save();
    },
    /**
     * ISC GmbH RK 21.11.2018
     * Saves our bean when the bean isn't already in the DB.
     * Unsets the id of the model, saves the model, opens success popup and resets the collection
     */
    saveNewRow: function () {
        //we need this, because otherwise Sugar would look for our id and not save it.
        let id = this.model.id;
        this.model.unset("id");
        self = this;
        this.model.save({}, {
            success: function (data) {
                app.alert.show('message-id', {
                    level: 'success',
                    messages: app.lang.get('LBL_RECORD_SAVED', self.module),
                    autoClose: true
                });
                self.view.toggleRow(id, false);
                self.changed = false;
                self.collection.trigger('reset');
                for (let i in self.view.toggledModels) {
                    self.view.editClicked(self.view.toggledModels[i], {'def': ''});
                }
                //Check, if we run out of Budget
                self.validateBudget(data);
            },
            error: function (data) {
            }
        });
    },

    _save: function () {
        var self = this,
            successCallback = function (model) {
                self.changed = false;
                self.view.toggleRow(model.id, false);
                //Check, if we run out of Budget
                self.validateBudget(model);
            },
            options = {
                success: successCallback,
                error: function (model, error) {
                    if (error.status === 409) {
                        app.utils.resolve409Conflict(error, self.model, function (model, isDatabaseData) {
                            if (model) {
                                if (isDatabaseData) {
                                    successCallback(model);
                                } else {
                                    self._save();
                                }
                            }
                        });
                    }
                },
                complete: function () {
                    // remove this model from the list if it has been unlinked
                    if (self.model.get('_unlinked')) {
                        self.collection.remove(self.model, {silent: true});
                        self.collection.trigger('reset');
                        self.view.render();
                    } else {
                        self.setDisabled(false);
                    }
                },
                lastModified: self.model.get('date_modified'),
                //Show alerts for this request
                showAlerts: {
                    'process': true,
                    'success': {
                        messages: app.lang.get('LBL_RECORD_SAVED', self.module)
                    }
                },
                relate: this.model.link ? true : false
            };

        options = _.extend({}, options, this.getCustomSaveOptions(options));

        this.model.save({}, options);
    },

    /**
     * Initiates validation on the model with fields that the user has edit
     * access to.
     */
    saveModel: function () {
        this.setDisabled(true);

        var fieldsToValidate = this.view.getFields(this.module, this.model);
        fieldsToValidate = _.pick(fieldsToValidate, function (vardef, fieldName) {
            return app.acl.hasAccessToModel('edit', this.model, fieldName);
        }, this);

        this.model.doValidate(fieldsToValidate, _.bind(this._validationComplete, this));
    },

    getCustomSaveOptions: function (options) {
        return {};
    },

    cancelEdit: function () {
        if (this.isDisabled()) {
            this.setDisabled(false);
        }
        this.changed = false;
        this.model.revertAttributes();
        this.view.clearValidationErrors();
        this.view.toggleRow(this.model.id, false);

        // trigger a cancel event across the parent context so listening components
        // know the changes made in this row are being reverted
        if (this.context.parent) {
            this.context.parent.trigger('editablelist:cancel', this.model);
        }
    },
    //ISC KOK Validierungsfunktion
    _doValiDate: function (fields, errors, callback) {
        //validate date requirements
        var error = false;
        var message = app.lang.getAppString('ISC_VALIDATION_ERROR') + ":<br>";
        var datevon = app.date(this.model.get('date_from')).format('HH:mm');
        var datebis = app.date(this.model.get('date_to')).format('HH:mm');
        if (!this.model.get('date_from')) {
            errors['date_from'] = errors['date_from'] || {};
            errors['date_from'].required = true;
        }
        if (this.model.get('description') === "") {
            errors['description'] = errors['description'] || {};
            errors['description'].required = true;
            error = true;
            message = message + app.lang.getAppString('ISC_ERROR_EMPTY_DESCRIPTION') + "<br>";
        }
        if (this.model.get('assigned_user_name') === "") {
            errors['assigned_user_name'] = errors['assigned_user_name'] || {};
            errors['assigned_user_name'].isc_user_required = true;
            error = true;
            message = message + app.lang.getAppString('ISC_USER_REQUIRED') + "<br>";
        }
        //Only Admins are allowed to set the assigned_user_id
        else if ((this.model.get('assigned_user_id') !== app.user.id) && (!app.acl.hasAccess('admin','ISC_Zeiterfassung'))) {
            errors['assigned_user_name'] = errors['assigned_user_name'] || {};
            errors['assigned_user_name'].isc_admin_required = true;
            error = true;
            message = message + app.lang.getAppString('ISC_ADMIN_REQUIRED') + "<br>";
        }
        if (this.model.get('project_isc_zeiterfassung_1_name') === "") {
            errors['project_isc_zeiterfassung_1_name'] = errors['project_isc_zeiterfassung_1_name'] || {};
            errors['project_isc_zeiterfassung_1_name'].isc_project_required = true;
            error = true;
            message = message + app.lang.getAppString('ISC_PROJECT_REQUIRED') + "<br>";
        }
        if (this.model.get('projecttask_isc_zeiterfassung_1_name') === "") {
            errors['projecttask_isc_zeiterfassung_1_name'] = errors['projecttask_isc_zeiterfassung_1_name'] || {};
            errors['projecttask_isc_zeiterfassung_1_name'].isc_projecttask_required = true;
            error = true;
            message = message + app.lang.getAppString('ISC_PROJECTTASK_REQUIRED') + "<br>";
        }
        //Check if someone deleted the dates
        if (datebis === "Invalid date") {
            error = true;
            message = message + app.lang.getAppString('ISC_ERROR_EMPTY_TO') + "<br>";
        }
        if (datevon === "Invalid date") {
            error = true;
            message = message + app.lang.getAppString('ISC_ERROR_EMPTY_FROM') + "<br>";
        }
        //Check if the date start is before the end for valid dates
        if ((datebis <= datevon) && (datebis !== "Invalid date") && (datevon !== "Invalid date")) {
            errors['date_to'] = errors['date_to'] || {};
            errors['date_to'].isAfter = true;
            error = true;
            message = message + app.lang.getAppString('ISC_DATE_ERROR') + "<br>";
        }
        //ISC GmbH Kok 14.01.2019 Validierung "Innerhalb von 7 Tagen"
        let dateDiff = Date.parse(new Date) - Date.parse(this.model.attributes.date_from);
        if ((dateDiff > 7 * 24 * 60 * 60 * 1000) && (!app.acl.hasAccess('admin','ISC_Zeiterfassung'))) {
            errors['date_from'] = errors['date_from'] || {};
            errors['date_from'].isc_error_within_one_week = true;
            error = true;
            message = message + app.lang.getAppString('ISC_ERROR_WITHIN_ONE_WEEK') + "<br>";
        }

        //Validate the relation between project and project task
        if (this.model.get('projecttask_isc_zeiterfassung_1projecttask_ida') && this.model.get('project_isc_zeiterfassung_1project_ida')) {
            var projecttask = app.data.createBean('ProjectTask', {'id': this.model.get('projecttask_isc_zeiterfassung_1projecttask_ida')});
            var self = this;
            projecttask.fetch({
                async: false,
                success: function (Data) {
                    self.iscSelectedProjectTask = Data;
                    //Check if the project fits to the project task
                    if (Data.get('project_id') !== self.model.get('project_isc_zeiterfassung_1project_ida')) {
                        errors['projecttask_isc_zeiterfassung_1_name'] = errors['projecttask_isc_zeiterfassung_1_name'] || {};
                        errors['projecttask_isc_zeiterfassung_1_name'].isc_project_projecttask_error = true;
                        error = true;
                        message = message + app.lang.getAppString('ISC_PROJECT_PROJECTTASK_ERROR') + "<br>";
                    }
                    //Check if the user fits to the project task
                    app.api.call('read', app.api.buildURL('ProjectTask/' + self.model.get('projecttask_isc_zeiterfassung_1projecttask_ida') + '/link/projecttask_users_1', null, null,
                        {"fields": ["id"], "filter": [{"id": {"$equals": app.user.id}}]}), null, {
                        success: function (data) {
                            if ((!data.records[0]) && (
                                !app.acl.hasAccess('admin','ISC_Zeiterfassung'))) {
                                errors['projecttask_isc_zeiterfassung_1_name'] = errors['projecttask_isc_zeiterfassung_1_name'] || {};
                                errors['projecttask_isc_zeiterfassung_1_name'].isc_projecttask_user_error = true;
                                error = true;
                                message = message + app.lang.getAppString('ISC_PROJECTTASK_USER_ERROR') + "<br>";
                            }
                        }
                    });
                    var ProjectTaskStatus;
                    //Retrieve the value for a valid project task
                    $.ajax({
                        url: app.api.buildURL('ISC_Zeiterfassung', 'get_isc_projecttask_status'),
                        data: {},
                        headers: {"OAuth-Token": app.api.getOAuthToken()},
                        success: function (data) {
                            if (data.error === "false") {
                                ProjectTaskStatus = data.message;
                            } else {
                                alert(data.message);
                            }
                        },
                        type: "GET",
                        dataType: "json",
                        async: false
                    });
                    //Validate if the status of the project task is valid for non-admins
                    if ((Data.get('status') !== ProjectTaskStatus) && (!app.acl.hasAccess('admin','ISC_Zeiterfassung'))) {
                        errors['projecttask_isc_zeiterfassung_1_name'] = errors['projecttask_isc_zeiterfassung_1_name'] || {};
                        errors['projecttask_isc_zeiterfassung_1_name'].isc_projecttask_status_error = true;
                        error = true;
                        message = message + app.lang.getAppString('ISC_PROJECTTASK_STATUS_ERROR') + "<br>";
                    }
                    var Buchungshinweis = Data.attributes.buchungshinweis_c;

                    //Retrieve the project
                    var project = app.data.createBean('Project', {'id': self.model.get('project_isc_zeiterfassung_1project_ida')});
                    project.fetch({
                        async: false,
                        success: function (Bohne) {
                            self.iscSelectedProject = Bohne;
                            var ProjectStatus;
                            //Retrieve the valid status for a project
                            $.ajax({
                                url: app.api.buildURL('ISC_Zeiterfassung', 'get_isc_project_status'),
                                data: {},
                                headers: {"OAuth-Token": app.api.getOAuthToken()},
                                success: function (data) {
                                    if (data.error === "false") {
                                        ProjectStatus = data.message;
                                    } else {
                                        alert(data.message);
                                    }
                                },
                                type: "GET",
                                dataType: "json",
                                async: false
                            });
                            //Validate if the status of the project is valid for non-admins
                            if ((Bohne.get('status') !== ProjectStatus) && (!app.acl.hasAccess('admin','ISC_Zeiterfassung'))) {
                                errors['project_isc_zeiterfassung_1_name'] = errors['project_isc_zeiterfassung_1_name'] || {};
                                errors['project_isc_zeiterfassung_1_name'].isc_project_status_error = true;
                                error = true;
                                message = message + app.lang.getAppString('ISC_PROJECT_STATUS_ERROR') + "<br>";
                            }
                            //Show alert if errors have been set
                            if (error === true) {
                                app.alert.dismiss('validation-error');
                                app.alert.show('validation-error', {
                                    level: 'error',
                                    messages: message,
                                    autoClose: true,
                                    autoCloseDelay: 10000
                                });
                            }
                            //Show alert with Buchungshinweis in case one exists
                            else if (Buchungshinweis !== "") {
                                app.alert.show('message-id', {
                                    level: 'info',
                                    messages: Buchungshinweis,
                                    autoClose: true,
                                    autoCloseDelay: 10000
                                });
                            }
                            callback(null, fields, errors);
                        },
                        error: function (xx, yy) {

                            app.alert.show('server-error', {
                                level: 'error',
                                messages: 'ERR_GENERIC_SERVER_ERROR'
                            });
                            errors['project_isc_zeiterfassung_1_name'] = errors['project_isc_zeiterfassung_1_name'] || {};
                            errors['project_isc_zeiterfassung_1_name'].required = true;
                            callback(null, fields, errors);
                        }
                    });
                },
                error: function (xx, yy) {

                    app.alert.show('server-error', {
                        level: 'error',
                        messages: 'ERR_GENERIC_SERVER_ERROR'
                    });
                    errors['projecttask_isc_zeiterfassung_1_name'] = errors['projecttask_isc_zeiterfassung_1_name'] || {};
                    errors['projecttask_isc_zeiterfassung_1_name'].required = true;
                    callback(null, fields, errors);
                }
            });
        } else {
            if (error === true) {
                app.alert.dismiss('validation-error');
                app.alert.show('validation-error', {
                    level: 'error',
                    messages: message,
                    autoClose: true,
                    autoCloseDelay: 10000
                });
            }
            callback(null, fields, errors);
        }
    },
    //ISC KOK ValidationTask hinzugefügt
    saveClicked: function (evt) {
        this.modifyToDate();
        if (!$(evt.currentTarget).hasClass('disabled')) {
            this.model.addValidationTask('check_date', _.bind(this._doValiDate, this));
            this.saveModel();
        }

    },

    /**
     * ISC GmbH 31.01.2019
     * Sets the models date_to field to the date of the date_from field
     */
    modifyToDate: function () {
        let date_from = new Date(this.model.attributes.date_from);
        let new_date_to = new Date(this.model.attributes.date_to);
        new_date_to.setFullYear(date_from.getFullYear());
        new_date_to.setMonth(date_from.getMonth());
        new_date_to.setDate(date_from.getDate());
        this.model.set('date_to', app.date(new_date_to).formatServer());
    },

    /**
     * ISC GmbH RK 21.11.2018
     * @param evt
     * Cancels the Edit and removes the model from the collection
     */
    cancelClicked: function (evt) {
        this.cancelEdit();
        if (!(this.model.attributes.date_entered)) {
            delete this.view.toggledModels[this.model.id];
            this.collection.remove(this.model);
            this.collection.trigger('reset');
            this.view.changed = false;
            for (let i in this.view.toggledModels) {
                this.view.toggleRow(i, true);
            }
        } else {
            //08.01.2019: fixes a bug which would keep the changed value when cancel is clicked
            this.model.fetch();
        }
    }
})
