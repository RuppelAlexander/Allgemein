/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 22.11.2022
 * Change Date   : 22.11.2022
 * Main Program  : isc_ZE_task_rel
 * Description   : Set Default Initiator
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
({
    extendsFrom: 'CreateView',

    /**
     * @inheritDoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);

        var isinitiatorDuplicate = this.model.has('user_id_c') && this.model.has('initiator_c');
        if (!isinitiatorDuplicate) {
            this.model.setDefault({
                                      'user_id_c': app.user.id,
                                      'initiator_c': app.user.get('full_name')
                                  });
        }
        // Remove Assigned User
        this.model.set({
                           'assigned_user_id': '',
                           'assigned_user_name': '',
                       });
        this.model.relatedAttributes.assigned_user_id = '';
        this.model.relatedAttributes.assigned_user_name = '';
    }
})
