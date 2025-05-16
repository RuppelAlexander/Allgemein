/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : DontG
 * Create Date   : 19.06.2023
 * Change Date   : 19.06.2023
 * Main Program  : isc_ZE_task_rel
 * Description   : Set Default Initiator (analog Create)
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
({
    extendsFrom: 'QuickcreateView',

    /**
     * @inheritDoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
        this.model.setDefault(
            {
                'user_id_c': app.user.id,
                'initiator_c': app.user.get('full_name')
            });

        // Remove Assigned User
        this.model.set(
            {
                'assigned_user_id': '',
                'assigned_user_name': '',
            });
        this.model.relatedAttributes.assigned_user_id = '';
        this.model.relatedAttributes.assigned_user_name = '';
    }
})
