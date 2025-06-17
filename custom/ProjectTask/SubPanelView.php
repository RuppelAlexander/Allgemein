<?php
/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 17.06.2025
 * Change Date   : 17.06.2025
 * Main Program  : Intern_upgrade_test_dev
 * Description   : SubPanelView.php
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */

# custom/modules/ProjectTask/SubPanelView.php
require_once 'modules/ProjectTask/SubPanelView.php';

/**
 * Erweiterte Subpanel-Ansicht, die unten unser Dialog-Script injiziert.
 */
class ISC_ResourceSync_SubPanelView extends ProjectTask_SubPanelView
{
    public function display()
    {
        $html = parent::display();

        // ① Script-Tag anhängen (Pfad bleibt wie gehabt)
        $html .= '<script src="custom/modules/ProjectTask/javascript/isc_resource_sync.js"></script>';

        return $html;
    }
}
