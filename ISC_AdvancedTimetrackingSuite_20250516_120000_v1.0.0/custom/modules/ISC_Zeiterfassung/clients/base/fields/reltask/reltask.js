/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 17.11.2022
 * Change Date   : 17.11.2022
 * Main Program  : isc_ZE_task_rel
 * Description   : ISC Zeiterfassung Aufgangeben Relation Button
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
({

    /**
     * Init Field
     * @param options
     */
    initialize: function (options) {
        this.events = _.extend({}, this.events, options.def.events, {
            'click [name="TaskSel-preview"]': 'tasksel_preview',
            'click [name="TaskSel-openlink"]': 'tasksel_openlink',
            'click [name="TaskSel-unlink"]': 'tasksel_unlink',
            'click [name="TaskSel-link"]': 'tasksel_link',
            'click [name="tasksel_switchedit"]': 'tasksel_edit',
        });
        this._super('initialize', [options]);
    },
    /**
     * Format Value for Output
     * @param value
     * @returns {*|string}
     */
    format: function (value) {

        if (_.isString(value)) {
            return value;
        }
        if (_.isUndefined(value) ||
            _.isNull(value) ||
            (_.isObject(value) && !_.isArray(value))
        ) {
            return '';
        }
        return value.toString();
    },
    tasksel_edit:function (event) {
       

    },
    /**
     * Button Action Select
     * @param event
     */
    tasksel_link: function (event) {

        var self = this;
        app.drawer.open(
            this.getDrawerOptions(),
            _.bind(this.selectDrawerCallback, self)
        );

    },
    /**
     * Button Action Remove
     * @param event
     */
    tasksel_unlink: function (event) {

        var self = this;
        this.model.set(
            {
                'tasks_isc_zeiterfassung_1tasks_ida': "",
                'tasks_isc_zeiterfassung_1_name': "",
            }
        );
        self.render();
    },
    tasksel_openlink: function () {
        var TaskId = this.model.get('tasks_isc_zeiterfassung_1tasks_ida');
        app.router.navigate("Tasks/" + TaskId, {trigger: true});
    },
    /**
     * Button Action Remove
     * @param event
     */
    tasksel_preview: function () {
        var data, model, success;
        if (!this.model) {
            return;
        }
        var TaskId = this.model.get('tasks_isc_zeiterfassung_1tasks_ida');
        if (_.isEmptyValue(TaskId)) {
            return;
        }
        success = _.bind(function (model) {
            model.module = "Tasks";
            app.events.trigger('preview:render', model);
        }, this);

        model = app.data.createBean("Tasks", {id: TaskId});
        model.fetch({
                        showAlerts: true,
                        success: success,
                        params: {
                            erased_fields: true
                        }
                    });

    },

    /**
     * Oper Select Task view
     * @param event
     */
    getDrawerOptions: function () {

        var FilterUserId = this.model.get('assigned_user_id');
        var filterOptions = new app.utils.FilterOptions()
            .config({
                        'initial_filter': 'filterUserTasksTemplate',
                        'initial_filter_label': 'LBL_FILTER_USERTASK_TEMPLATE',
                        'filter_populate': {
                            'assigned_user_id': [FilterUserId],
                        }
                    })
            .populateRelate(this.model);

        return {
            layout: 'selection-list',
            context: {
                module: 'Tasks',
                filterOptions: filterOptions.format(),
            }
        };
    },
    /**
     * Callback for Drawer Open (after selection Done)
     * @param model
     */
    selectDrawerCallback: function (model) {
        var self = this;
        if (!model) {
            return;
        }

        var Task_id = model['id'];
        var Task_name = model['name'];
        var pjt_id = model['projecttask_tasks_1projecttask_ida'];
        var pjt_name = model['projecttask_tasks_1_name'];

        var project_name = model['project_c'];
        var project_id_c = model['project_id_c'];
        var pjac_id = model['accounts_tasks_1accounts_ida'];
        var pjac_name = model['accounts_tasks_1_name'];
        var CleanupAll = false;

        if (_.isEmptyValue(project_id_c) || _.isEmptyValue(pjac_id)) {
            CleanupAll = true;
            app.alert.show('msg-emtytask', {
                level: 'warning',
                messages: app.lang.get('MSG_TASK_MISSING_PRJ', 'Tasks'),
                autoClose: true
            });
        }
        if (CleanupAll) {
            Task_id = '';
            Task_name = '';
            project_id_c = '';
            project_name = '';
            pjt_id = '';
            pjt_name = '';
        }
        this.model.set(
            {
                'tasks_isc_zeiterfassung_1tasks_ida': Task_id,
                'tasks_isc_zeiterfassung_1_name': Task_name,
                'project_isc_zeiterfassung_1project_ida': project_id_c,
                'project_isc_zeiterfassung_1_name': project_name,
                'projecttask_isc_zeiterfassung_1projecttask_ida': pjt_id,
                'projecttask_isc_zeiterfassung_1_name': pjt_name,
            }
        );
        self.render();
    }
})
