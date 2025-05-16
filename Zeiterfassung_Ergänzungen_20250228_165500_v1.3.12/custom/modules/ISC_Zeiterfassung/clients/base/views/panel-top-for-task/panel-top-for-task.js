/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 23.11.2022
 * Change Date   : 23.11.2022
 * Main Program  : isc_ZE_task_rel
 * Description   : Subpanel Button Logik for Tasks
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
({
    extendsFrom: 'PanelTopView',
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    createRelatedClicked: function (event) {
        this.openCreateDrawer(this.module);
    },

    openCreateDrawer: function (module, link) {
        link = link || this.context.get('link');
        var context = (this.context.get('name') === 'tabbed-dashlet') ? this.context : (this.context.parent || this.context);
        var parentModel = context.get('model') || context.parent.get('model');
        var model = this.createLinkModel(parentModel, link);
        var self = this;
        var sToDate = this.getSuDate();
        var project_name = parentModel.get('project_c');
        var project_id = parentModel.get('project_id_c');
        var projecttask_id = parentModel.get('projecttask_tasks_1projecttask_ida');
        var projecttask_name = parentModel.get('projecttask_tasks_1_name');
        model.set("project_isc_zeiterfassung_1project_ida", project_id);
        model.set("project_isc_zeiterfassung_1_name", project_name);
        model.set("projecttask_isc_zeiterfassung_1projecttask_ida", projecttask_id);
        model.set("projecttask_isc_zeiterfassung_1_name", projecttask_name);
        var sFromDate = '';
        var sToDate = this.getSuDate();
        if (sFromDate == '') {
            //no current entry
            sFromDate = sToDate;
        } else {
            //entries of the day are greater than the actual time
            if (Date.parse(sToDate) < Date.parse(sFromDate)) {
                sToDate = sFromDate;
            }
        }
        model.set("date_from", sFromDate);
        model.set("date_to", sToDate);

        app.drawer.open({
                            layout: 'create',
                            context: {
                                create: true,
                                module: model.module,
                                model: model
                            }
                        }, function (context, model) {
            if (!model) {
                return;
            }
            self.trigger('linked-model:create', model);
        });
    },

    getSuDate: function () {
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
        if (day < 10) {
            var day_tmp = '0' + String(day);
            day = day_tmp;
        }
        if (month < 10) {
            var month_tmp = '0' + String(month);
            month = month_tmp;
        }
        if (Hour < 10) {
            var Hour_tmp = '0' + String(Hour);
            Hour = Hour_tmp;
        }
        Minutes = '00';

        if (Min > 14 && Min < 30) {
            Minutes = '15';
        }
        if (Min > 29 && Min < 45) {
            Minutes = '30';
        }
        if (Min > 44) {
            Minutes = '45';
        }
        return year + '-' + month + '-' + day + 'T' + Hour + ':' + Minutes + ':00+' + Offset + ':00';
    },
})
