/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 03.12.2018
 * Change Date   : 14.12.2018
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Added logic between Project Task and Project
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 14.12.2018  TF      Add population of the filter for quick search to work
 * 03.06.2019  RK      Moved Project/Projekttask related stuff so it only gets
 *                     executed, when the model is no array. This fixes the
 *                     quicksearch, when multiple Projects are selected.
 * 12.06.2024  DontG  fix line endings lf
 * ----------------------------------------------------------------------------
 */
({
    extendsFrom: 'RelateField',
    /**
     * Formats the filter options.
     *
     * @param {Boolean} force `true` to force retrieving the filter options
     *   whether or not it is available in memory.
     * @return {Object} The filter options.
     */
    initialize: function (options) {
        this._super('initialize', [options]);
        this._minChars = options.def.minChars || 0;
    },
    search: _.debounce(function (query) {
        var term = query.term || '',
            self = this,
            searchModule = this.getSearchModule(),
            params = {},
            limit = self.def.limit || 5,
            relatedModuleField = this.getRelatedModuleField();

        if (query.context) {
            params.offset = this.searchCollection.next_offset;
        }
        params.filter = this.buildFilterDefinition(term);

        this.searchCollection.fetch({
            //Don't show alerts for this request
            showAlerts: false,
            update: true,
            remove: _.isUndefined(params.offset),
            reset: _.isUndefined(params.offset),
            fields: this.getSearchFields(),
            context: self,
            params: params,
            limit: limit,
            success: function (data) {
                var fetch = {results: [], more: data.next_offset > 0, context: data};
                if (fetch.more) {
                    var fieldEl = self.$(self.fieldTag),
                        //For teamset widget, we should specify which index element to be filled in
                        plugin = (fieldEl.length > 1) ? $(fieldEl.get(self._currentIndex)).data("select2") : fieldEl.data("select2"),
                        height = plugin.searchmore.children("li:first").children(":first").outerHeight(),
                        //0.2 makes scroll not to touch the bottom line which avoid fetching next record set
                        maxHeight = height * (limit - .2);
                    plugin.results.css("max-height", maxHeight);
                }
                _.each(data.models, function (model, index) {
                    if (params.offset && index < params.offset) {
                        return;
                    }
                    fetch.results.push({
                        id: model.id,
                        text: model.get(relatedModuleField) + ''
                    });
                });
                if (query.callback && _.isFunction(query.callback)) {
                    query.callback(fetch);
                }
            },
            error: function () {
                if (query.callback && _.isFunction(query.callback)) {
                    query.callback({results: []});
                }
                app.logger.error("Unable to fetch the bean collection.");
            }
        });
    }, app.config.requiredElapsed || 200),
    getFilterOptions: function (force) {

        if (this._filterOptions && !force) {
            return this._filterOptions;
        }
        switch (this.name) {
            case 'projecttask_isc_zeiterfassung_1_name':
                this._filterOptions = new app.utils.FilterOptions()
                    .config({
                        'initial_filter': 'filterProjectTaskTemplate',
                        'initial_filter_label': 'LBL_FILTER_PROJECTTASK_TEMPLATE',
                        'filter_populate': {
                            'project_id': [this.model.get('project_isc_zeiterfassung_1project_ida')]
                        }
                    })
                    .populateRelate(this.model)
                    .format();
                break;
            case 'project_isc_zeiterfassung_1_name':
                this._filterOptions = new app.utils.FilterOptions()
                    .config({
                        'initial_filter': 'Resources',
                        'initial_filter_label': 'LBL_RESOURCES_FILTER',
                        //ISC TF, 2018-12-14: Added filter population
                        'filter_populate': {
                            'id': [this.model.get('assigned_user_id')],
                        }
                    })
                    .populateRelate(this.model)
                    .format();
                break;
            default:


                this._filterOptions = new app.utils.FilterOptions()
                    .config(this.def)
                    .setInitialFilter(this.def.initial_filter || '$relate')
                    .populateRelate(this.model)
                    .format();


                break;
        }
        return this._filterOptions;
    },

    /**
     * Renders the editable dropdown using the `select2` plugin.
     *
     * Since a filter may have to be applied on the field, we need to fetch
     * the list of filters for the current module before rendering the dropdown
     * (and enabling the searchahead feature that requires the filter
     * definition).
     *
     * @private
     */

    /**
     * Sets the value in the field.
     *
     * @param {Object|Array} models The source models attributes.
     */
    setValue: function (models) {
        if (!models) {
            return;
        }
        var updateRelatedFields = true,
            values = {};
        if (_.isArray(models)) {
            // Does not make sense to update related fields if we selected
            // multiple models
            updateRelatedFields = false;
        } else {
            models = [models];
        }

        values[this.def.id_name] = [];
        values[this.def.name] = [];

        _.each(models, _.bind(function (model) {
            values[this.def.id_name].push(model.id);
            //FIXME SC-4196 will fix the fallback to `formatNameLocale` for person type models.
            values[this.def.name].push(model[this.getRelatedModuleField()] ||
                app.utils.formatNameLocale(model) || model.value);
        }, this));

        // If it's not a multiselect relate, we get rid of the array.
        if (!this.def.isMultiSelect) {
            values[this.def.id_name] = values[this.def.id_name][0];
            values[this.def.name] = values[this.def.name][0];
        }
        this.model.set(values);

        if (updateRelatedFields) {
            // TODO: move this to SidecarExpressionContext
            // check if link field is currently populated
            if (this.model.get(this.fieldDefs.link)) {
                // unset values of related bean fields in order to make the model load
                // the values corresponding to the currently selected bean
                this.model.unset(this.fieldDefs.link);
            } else {
                // unsetting what is not set won't trigger "change" event,
                // we need to trigger it manually in order to notify subscribers
                // that another related bean has been chosen.
                // the actual data will then come asynchronously
                this.model.trigger('change:' + this.fieldDefs.link);
            }
            this.updateRelatedFields(models[0]);
            //ISC GmbH RK 03.06.2019: Fix for quicksearch
            //ISC GmbH 09.11.2018: Added logic between the fields for Project Task and Project
            if ((this.def.module === "Project") && (values[this.def.id_name].length === 0) && (values[this.def.name].length === 0)) {
                this.model.set({
                    projecttask_isc_zeiterfassung_1_name: "",
                    projecttask_isc_zeiterfassung_1projecttask_ida: ""
                })
            }
            if ((this.def.name === "project_isc_zeiterfassung_1_name") && ((values[this.def.id_name].length > 0) && (values[this.def.name].length > 0))) {
                let statusUrl = app.api.buildURL('ISC_Zeiterfassung', 'get_isc_projecttask_status');
                let projectTaskStatus;
                app.api.call('read', statusUrl, null, null, {
                    success: _.bind(function (response) {
                        if (response.error === "false") {
                            projectTaskStatus = response.message;
                        }
                    })
                });
                let projecturl = app.api.buildURL("Project/" + values[this.def.id_name] + "/link/projecttask", null, null, {
                    "fields": "id,name,status,projecttask_users_1"
                });
                app.api.call('read', projecturl, null, null, {
                    success: _.bind(function (response) {
                        let hitMarker = 0;
                        let indexOfHit;
                        for (let i = 0; i < response.records.length; i++) {
                            //Checking if the current user is a resource of the Project Task
                            for (let m in response.records[i].projecttask_users_1.records) {
                                if ((response.records[i].projecttask_users_1.records[m].id === app.user.get('id')) &&
                                    (response.records[i].status === projectTaskStatus)) {
                                    hitMarker++;
                                    indexOfHit = i;
                                    break;
                                }
                            }
                        }
                        if (hitMarker === 1) {
                            this.model.set({
                                projecttask_isc_zeiterfassung_1_name: response.records[indexOfHit].name,
                                projecttask_isc_zeiterfassung_1projecttask_ida: response.records[indexOfHit].id
                            });
                        } else {
                            this.model.set({
                                projecttask_isc_zeiterfassung_1_name: "",
                                projecttask_isc_zeiterfassung_1projecttask_ida: ""
                            });
                        }
                    }, this),
                    error: _.bind(function (error) {
                    }, this),
                });
            }
            if ((this.def.name === "projecttask_isc_zeiterfassung_1_name") && ((values[this.def.id_name].length > 0) && (values[this.def.name].length > 0))) {
                let projecttaskurl = app.api.buildURL("ProjectTask", values[this.def.id_name], null, {});
                app.api.call('read', projecttaskurl, null, {
                    success: _.bind(function (response) {
                        if ((this.model.get("project_isc_zeiterfassung_1_name") !== response.project_name) &&
                            (this.model.get("project_isc_zeiterfassung_1project_ida") !== response.project_id)) {
                            this.model.set({
                                project_isc_zeiterfassung_1_name: response.project_name,
                                project_isc_zeiterfassung_1project_ida: response.project_id
                            });
                        }
                    }, this),
                    error: _.bind(function (error) {
                    }, this),
                });
            }
            //--------------------------------------------------------------------------------
        }
    },
});
