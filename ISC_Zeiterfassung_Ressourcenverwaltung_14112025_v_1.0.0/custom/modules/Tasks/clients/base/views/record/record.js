/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 13.11.2025
 * Change Date   : 13.11.2025
 * Main Program  : ISC_Ressourcenverwaltung
 * Description   : record.js
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */


// custom/modules/Tasks/clients/base/views/record/record.js
({
    extendsFrom: 'RecordView',

    initialize: function(options) {
        this._super('initialize', [options]);


        this._isAdmin      = (app.user.get('type') === 'admin');
        this._rsAllowed    = false;

        this._fetchRoles(_.bind(function(isAllowed) {
            this._rsAllowed = !!isAllowed;
        }, this));
    },


    /**
     * Save-Override: ruft zuerst die Status-API auf.
     * - Wenn User bereits Ressource der ProjectTask ist → normal speichern.
     * - Wenn nicht → Dialog „Ja/Nein“ anzeigen.
     */
    saveClicked: function() {
        var uid  = this.model.get('assigned_user_id');
        var ptId = this.model.get('projecttask_tasks_1projecttask_ida');
        var isAllowed = this._rsAllowed;


        this.model.unset('isc_rs_skip_resource');


        if (!uid || !ptId || !isAllowed) {
            return this._super('saveClicked');
        }

        var url = app.api.buildURL('TasksResourceStatus', null, null, {
            pt_id: ptId,
            user_id: uid
        });

        app.api.call('read', url, null, {
            success: _.bind(function(data) {

                if (!data || data.exists) {
                    this.model.unset('isc_rs_skip_resource');
                    this._super('saveClicked');
                    return;
                }


                this._showResourceDialog(uid, ptId);
            }, this),
            error: _.bind(function() {
               
                this.model.unset('isc_rs_skip_resource');
                this._super('saveClicked');
            }, this)
        });
    },


    _fetchRoles: function(cb) {
        var url = app.api.buildURL('TasksResourceAccess');

        app.api.call('read', url, null, {
            success: function(resp) {
                var allowed = false;
                if (resp && resp.allowed) {
                    allowed = true;
                }
                cb(allowed);
            },
            error: function() {
                cb(false);
            }
        });
    },


    /**
     * Dialog:
     * - Ja  → normal speichern, Hook darf Ressourcen anlegen.
     * - Nein → Flag setzen, Task speichern, Hook soll keine Ressourcen anlegen.
     */
    _showResourceDialog: function(uid, ptId) {
        var self = this;

        app.alert.show('rs-task-add-resource', {
            level: 'confirmation',
            messages: 'Der Mitarbeiter ist nicht als Ressource an der Projektaufgabe hinterlegt. Soll er als Ressource hinzugefügt werden?',
            // Button-Beschriftungen hart setzen
            confirm: { label: 'Ja' },
            cancel:  { label: 'Nein' },
            onConfirm: function() {
                // Ja → Flag löschen, normal speichern
                self.model.unset('isc_rs_skip_resource');
                self._super('saveClicked');
            },
            onCancel: function() {
                // Nein → Flag setzen, Task trotzdem speichern
                self.model.set('isc_rs_skip_resource', 1);
                self._super('saveClicked');
            }
        });
    }

});

