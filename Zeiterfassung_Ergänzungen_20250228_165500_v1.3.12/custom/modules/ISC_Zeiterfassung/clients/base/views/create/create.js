/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : dontg
 * Create Date   : 23.11.2022
 * Change Date   : 20.06.2022
 * Main Program  : isc_ZE_task_rel
 * Description   : sonder logik
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 20.06.2022  Dont Mod simplify Filter same function (used in create,record,subpanel)
 * ----------------------------------------------------------------------------
 */
({
    extendsFrom: 'CreateView',

    /**
     * @inheritDoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
        this.model.addValidationTask('check_email', _.bind(this._rk_additionalvalidator, this));
        app.error.errorName2Keys['isc_project_projecttask_error'] = 'ISC_PROJECT_PROJECTTASK_ERROR';
        app.error.errorName2Keys['isc_projecttask_status_error'] = 'ISC_PROJECTTASK_STATUS_ERROR';
        app.error.errorName2Keys['isc_project_status_error'] = 'ISC_PROJECT_STATUS_ERROR';
        app.error.errorName2Keys['isc_project_required'] = 'ISC_PROJECT_REQUIRED';
        app.error.errorName2Keys['isc_projecttask_required'] = 'ISC_PROJECTTASK_REQUIRED';
        app.error.errorName2Keys['isc_user_required'] = 'ISC_USER_REQUIRED';
        app.error.errorName2Keys['isc_admin_required'] = 'ISC_ADMIN_REQUIRED';
        app.error.errorName2Keys['isc_projecttask_user_error'] = 'ISC_PROJECTTASK_USER_ERROR';
        app.error.errorName2Keys['isc_error_within_one_week'] = 'ISC_ERROR_WITHIN_ONE_WEEK';
        app.error.errorName2Keys['isc_error_time_ueberschneidung'] = 'ISC_ERROR_TIME_UEBERSCHNEIDUNG';

    },
    _rk_additionalvalidator: function (fields, errors, callback) {
        //validate date requirements
        var self = this;

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
        else if ((this.model.get('assigned_user_id') !== app.user.id) && (!app.acl.hasAccess('admin', 'ISC_Zeiterfassung'))) {
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
        if ((dateDiff > 7 * 24 * 60 * 60 * 1000) && (!app.acl.hasAccess('admin', 'ISC_Zeiterfassung'))) {
            errors['date_from'] = errors['date_from'] || {};
            errors['date_from'].isc_error_within_one_week = true;
            error = true;
            message = message + app.lang.getAppString('ISC_ERROR_WITHIN_ONE_WEEK') + "<br>";
        }

        //Validate the relation between project and project task
        if (this.model.get('projecttask_isc_zeiterfassung_1projecttask_ida') && this.model.get('project_isc_zeiterfassung_1project_ida')) {
            var projecttask = app.data.createBean('ProjectTask', {'id': this.model.get('projecttask_isc_zeiterfassung_1projecttask_ida')});

            projecttask.fetch({
                                  async: false, success: function (Data) {
                    self.iscSelectedProjectTask = Data;
                    //Check if the project fits to the project task
                    if (Data.get('project_id') !== self.model.get('project_isc_zeiterfassung_1project_ida')) {
                        errors['projecttask_isc_zeiterfassung_1_name'] = errors['projecttask_isc_zeiterfassung_1_name'] || {};
                        errors['projecttask_isc_zeiterfassung_1_name'].isc_project_projecttask_error = true;
                        error = true;
                        message = message + app.lang.getAppString('ISC_PROJECT_PROJECTTASK_ERROR') + "<br>";
                    }
                    //Check if the user fits to the project task
                    app.api.call('read', app.api.buildURL('ProjectTask/' + self.model.get('projecttask_isc_zeiterfassung_1projecttask_ida') + '/link/projecttask_users_1', null, null, {"fields": ["id"], "filter": [{"id": {"$equals": app.user.id}}]}), null, {
                        success: function (data) {
                            if ((!data.records[0]) && (!app.acl.hasAccess('admin', 'ISC_Zeiterfassung'))) {
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
                               url: app.api.buildURL('ISC_Zeiterfassung', 'get_isc_projecttask_status'), data: {}, headers: {"OAuth-Token": app.api.getOAuthToken()}, success: function (data) {
                            if (data.error === "false") {
                                ProjectTaskStatus = data.message;
                            } else {
                                alert(data.message);
                            }
                        }, type: "GET", dataType: "json", async: false
                           });
                    //Validate if the status of the project task is valid for non-admins
                    if ((Data.get('status') !== ProjectTaskStatus) && (!app.acl.hasAccess('admin', 'ISC_Zeiterfassung'))) {
                        errors['projecttask_isc_zeiterfassung_1_name'] = errors['projecttask_isc_zeiterfassung_1_name'] || {};
                        errors['projecttask_isc_zeiterfassung_1_name'].isc_projecttask_status_error = true;
                        error = true;
                        message = message + app.lang.getAppString('ISC_PROJECTTASK_STATUS_ERROR') + "<br>";
                    }
                    var Buchungshinweis = Data.attributes.buchungshinweis_c;

                    //Retrieve the project
                    var project = app.data.createBean('Project', {'id': self.model.get('project_isc_zeiterfassung_1project_ida')});
                    project.fetch({
                                      async: false, success: function (Bohne) {
                            self.iscSelectedProject = Bohne;
                            var ProjectStatus;
                            //Retrieve the valid status for a project
                            $.ajax({
                                       url: app.api.buildURL('ISC_Zeiterfassung', 'get_isc_project_status'), data: {}, headers: {"OAuth-Token": app.api.getOAuthToken()}, success: function (data) {
                                    if (data.error === "false") {
                                        ProjectStatus = data.message;
                                    } else {
                                        alert(data.message);
                                    }
                                }, type: "GET", dataType: "json", async: false
                                   });
                            //Validate if the status of the project is valid for non-admins
                            if ((Bohne.get('status') !== ProjectStatus) && (!app.acl.hasAccess('admin', 'ISC_Zeiterfassung'))) {
                                errors['project_isc_zeiterfassung_1_name'] = errors['project_isc_zeiterfassung_1_name'] || {};
                                errors['project_isc_zeiterfassung_1_name'].isc_project_status_error = true;
                                error = true;
                                message = message + app.lang.getAppString('ISC_PROJECT_STATUS_ERROR') + "<br>";
                            }
                            //Show alert if errors have been set
                            if (error === true) {
                                app.alert.dismiss('validation-error');
                                app.alert.show('validation-error', {
                                    level: 'error', messages: message, autoClose: true, autoCloseDelay: 10000
                                });
                            }
                            //Show alert with Buchungshinweis in case one exists
                            else if (Buchungshinweis !== "") {
                                app.alert.show('message-id', {
                                    level: 'info', messages: Buchungshinweis, autoClose: true, autoCloseDelay: 10000
                                });
                            }
                            self.ProofuberschneidungZulassen(fields, errors, callback);
                        }, error: function (xx, yy) {

                            app.alert.show('server-error', {
                                level: 'error', messages: 'ERR_GENERIC_SERVER_ERROR'
                            });
                            errors['project_isc_zeiterfassung_1_name'] = errors['project_isc_zeiterfassung_1_name'] || {};
                            errors['project_isc_zeiterfassung_1_name'].required = true;
                            self.ProofuberschneidungZulassen(fields, errors, callback);
                        }
                                  });
                }, error: function (xx, yy) {

                    app.alert.show('server-error', {
                        level: 'error', messages: 'ERR_GENERIC_SERVER_ERROR'
                    });
                    errors['projecttask_isc_zeiterfassung_1_name'] = errors['projecttask_isc_zeiterfassung_1_name'] || {};
                    errors['projecttask_isc_zeiterfassung_1_name'].required = true;
                    self.ProofuberschneidungZulassen(fields, errors, callback);
                }
                              });
        } else {
            if (error === true) {
                app.alert.dismiss('validation-error');
                app.alert.show('validation-error', {
                    level: 'error', messages: message, autoClose: true, autoCloseDelay: 10000
                });
            }

            self.ProofuberschneidungZulassen(fields, errors, callback);

        }
    },

    /**
     * CUSTOM OVERIDE PROOF  dateTime Range
     * @param isValid
     */
    ProofuberschneidungZulassen: function (fields, errors, callback) {
        if (errors.length > 0) {
            callback(null, fields, errors);
            return;
        }
        let RestCallBack = {
            success: function (data) {
                if (data.records.length>0) {
                    // Result Need Request
                    app.alert.show('message-id', {
                        level: 'confirmation', messages: app.lang.get('LBL_ERROR_UEBERSCHNEIDUNG'),
                        autoClose: false,
                        onConfirm: function () {
                            callback(null, fields, errors);
                        },
                        onCancel: function () {
                            errors['date_to'] = errors['date_to'] || {};
                            errors['date_to'].isc_error_time_ueberschneidung = true;
                            errors['date_from'] = errors['date_from'] || {};
                            errors['date_from'].isc_error_time_ueberschneidung = true;
                            callback(null, fields, errors);
                        }
                    });
                } else {
                    // No Results
                    callback(null, fields, errors);
                }
            },
            error: function () {
                callback(null, fields, errors);
            }
        };
        let Filterurl = app.api.buildURL('ISC_Zeiterfassung', 'filter');
        let Params = this.GetChecktimeOverlapFilter();
        app.api.call('create', Filterurl, Params, RestCallBack);
    },
    GetChecktimeOverlapFilter: function () {
        let self = this;
        let date_from = self.model.get('date_from');
        let date_to = self.model.get('date_to');
        let assigned_user_id = self.model.get('assigned_user_id');
        let ModId = self.model.get('id');
        let Params = {
            "fields": "id,name,description,date_from,date_to",
            "max_num": 1,
            "filter": [{
                "$and": [
                    {
                        "$or": [{
                            "$and": [{"date_from": {"$gt": date_from}}, {"date_from": {"$lt": date_to}}]
                        }, {
                            "$and": [{"date_to": {"$gt": date_from}}, {"date_to": {"$lt": date_to}}]
                        }, {
                            "$and": [{"date_from": {"$lt": date_from}}, {"date_to": {"$gt": date_to}}]
                        }, {"date_from": {"$equals": date_from}}, {"date_to": {"$equals": date_to}}]
                    },
                    {"assigned_user_id": {"$equals": assigned_user_id}},
                    {"id": {"$not_equals": ModId}}
                ]
            }]
        };
        return Params;
    },

})
