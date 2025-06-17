/**
 * ------------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ------------------------------------------------------------------------------
 * Author        : dontg
 * Create Date   : 14.04.2021
 * Change Date   : 14.04.2021
 * Main Program  : sugarcrm_intern_upgradetest
 * Description   : sugarcrm_intern_upgradetest
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date       name   Description
 * ------------------------------------------------------------------------------
 * ------------------------------------------------------------------------------
 */
function isc_handleProjektVk() {
    try {
        var _form = document.getElementById('EditView');
        var RelName = _form.relate_to.value;
        if (RelName == 'projects_project_tasks') {
            var RelId = _form.relate_id.value;
            var NewRel = _form.project_id.value;
            if (RelId != NewRel) {
                _form.relate_id.value = NewRel;
            }
        }
    }
    catch (e) {
    }
}
