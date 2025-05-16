/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 04.01.2023
 * Change Date   : 31.05.2023
 * Main Program  : isc_ZE_task_rel
 * Description   : Add Filter / Clear  Field
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 31.05.2023  DontG   set projecttask_tasks if only one in Projects
 * ----------------------------------------------------------------------------
 */
({
    extendsFrom: 'RelateField',
    DoFilterByProject: false,
    DoFilterByUser: false,
    /**
     * @inheritDoc
     */
    initialize: function (options) {
        var self = this;
        this._super('initialize', [options]);
        if (this.model.isNew()) {
            self.InitOnchanges();
        } else {
            this.model.once("sync", self.InitOnchanges, self);

        }

    },
    InitOnchanges: function () {
        if (this.name == 'project_c') {
            this.DoFilterByUser = true;
            this.model.on("change:project_c", this.onProjectChange, this);
        } else if (this.name == 'projecttask_tasks_1_name') {
            this.DoFilterByProject = true;
        } else if (this.name == 'assigned_user_name') {
            this.model.on("change:assigned_user_name", this.onassigned_user_nameChange, this);
        } else if (this.name == 'developer_c') {
            this.model.on("change:developer_c", this.onDeveloper_nameChange, this);
        }
    },
    onassigned_user_nameChange: function () {
        var assigned_user_id = this.model.get('assigned_user_id');
        var assigned_user_name = this.model.get('assigned_user_name');
        var developer_c = this.model.get("developer_c");
        if (!_.isEmptyValue(assigned_user_id) && !_.isEmptyValue(assigned_user_name) && _.isEmptyValue(developer_c)) {
            this.model.set({'user_id1_c': assigned_user_id, 'developer_c': assigned_user_name});
        }
    },
    onDeveloper_nameChange: function () {
        var assigned_user_id = this.model.get('assigned_user_id');
        var assigned_user_name = this.model.get('assigned_user_name');
        var developer_c = this.model.get("developer_c");
        var user_id1_c = this.model.get("user_id1_c");
        if (!_.isEmptyValue(user_id1_c) && !_.isEmptyValue(developer_c) && _.isEmptyValue(assigned_user_name)) {
            this.model.set({'assigned_user_id': user_id1_c, 'assigned_user_name': developer_c});
        }
    },
    /**
     * If New Project selected
     * @param ChangedModel
     */
    onProjectChange: function (ChangedModel) {
        var self = this;

        var project_id = ChangedModel.get('project_id_c');
        if (_.isEmptyValue(project_id)) {
            // If project Clear then Clear Projecttask
            self.model.set({'projecttask_tasks_1_name': '', 'projecttask_tasks_1projecttask_ida': ''});
            return;
        }
        var PjCallbacks = {
            success: _.bind(this.PjRequesstResultSuccess, this),
            error: _.bind(function (data) {
                app.error.handleHttpError(data, self.model);
            }, this),
        };
        var projecturl = app.api.buildURL("Project", "link/projecttask", {id: project_id}, {"fields": "id,name,status,projecttask_users_1"});

        app.api.call('read', projecturl, null, PjCallbacks);
        // Get Account for Project
        var PjACCallbacks = {
            success: _.bind(this.PjAcRequesstResultSuccess, this),
            error: _.bind(function (data) {
                app.error.handleHttpError(data, self.model);
            }, this),
        };
        var projectACurl = app.api.buildURL("Project", "link/accounts", {id: project_id}, {"fields": "id,name"});
        app.api.call('read', projectACurl, null, PjACCallbacks);
    },

    PjAcRequesstResultSuccess: function (response) {
        var self = this;
        var project_Name = self.model.get('project_c');
        var project_id = self.model.get('project_id_c');
        if (response.records.length >= 1) {
            var ActAccId = self.model.get('accounts_tasks_1accounts_ida');
            if (ActAccId != response.records[0].id) {
                self.model.set({'accounts_tasks_1accounts_ida': response.records[0].id, 'accounts_tasks_1_name': response.records[0].name});
            }
        } else {
            self.model.set({
                               'accounts_tasks_1accounts_ida': "", 'accounts_tasks_1_name': "",
                               'projecttask_tasks_1_name': '', 'projecttask_tasks_1projecttask_ida': '',
                               'project_c': '', 'project_id_c': ''
            });
            app.alert.show("accwarning", {
                level: 'error',
                messages: 'Missing Account in Project <a href="#Project/'+project_id+ '">'+ project_Name+'</a> Fix before select'                ,
                autoClose: false
            });
        }
    },
    PjRequesstResultSuccess: function (response) {
        var self = this;
        var UsrId = app.user.get('id');
        var Akt_projecttask_id = self.model.get('projecttask_tasks_1projecttask_ida');
        var projecttasks_count = response.records.length;
        if (projecttasks_count == 0) {
            self.model.set({'projecttask_tasks_1_name': '', 'projecttask_tasks_1projecttask_ida': ''});
            return;
        }
        var FoundRecs = _.filter(response.records, function (projecttask_record) {
            return _.findWhere(projecttask_record.projecttask_users_1.records, {id: UsrId}); // Filter Nach Resource User == app.user.get('id')
        });
        if (FoundRecs.length == 1) {
            if (Akt_projecttask_id != FoundRecs[0].id) {
                self.model.set({'projecttask_tasks_1_name': FoundRecs[0].name, 'projecttask_tasks_1projecttask_ida': FoundRecs[0].id});
            }
        } else {
            if (!_.pluck(FoundRecs, 'id').includes(Akt_projecttask_id)) {
                self.model.set({'projecttask_tasks_1_name': '', 'projecttask_tasks_1projecttask_ida': ''});
            }
        }
    },

    /**
     * Extend filterOptions if projecttask_tasks_1_name
     * @param force
     * @returns {*}
     */
    getFilterOptions: function (force) {
        if (!this.DoFilterByProject && !this.DoFilterByUser) {
            if (this._filterOptions && !force) {
                return this._filterOptions;
            }
            return this._super('getFilterOptions', [force]);
        }
        if (this.DoFilterByUser) {
            this._filterOptions = new app.utils.FilterOptions()
            this._filterOptions = new app.utils.FilterOptions()
                .config({
                            'initial_filter': 'Resources',
                            'initial_filter_label': 'LBL_RESOURCES_FILTER',
                        })
                .populateRelate(this.model)
                .format();

        } else {
            this._filterOptions = new app.utils.FilterOptions()
                .config({
                            'initial_filter': 'filterProjectTaskTemplate',
                            'initial_filter_label': 'LBL_FILTER_PROJECTTASK_TEMPLATE',
                            'filter_populate': {
                                'project_id': [this.model.get('project_id_c')]
                            }
                        })
                .populateRelate(this.model)
                .format();
        }
        return this._filterOptions;
    },
})
