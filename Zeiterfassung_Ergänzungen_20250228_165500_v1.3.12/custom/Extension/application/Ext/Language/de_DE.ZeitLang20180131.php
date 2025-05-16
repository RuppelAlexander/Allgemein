<?php
/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : ?
 * Change Date   : 31.01.2018
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Adds the error label for "withinOneWeek"
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
$app_list_strings['moduleList']['ISC_Zeiterfassung'] = 'ISC_Zeiterfassung';
$app_list_strings['moduleListSingular']['ISC_Zeiterfassung'] = 'ISC_Zeiterfassung';
//ISC KOK
global $sugar_config;
if (isset($sugar_config['ISCProjektStatus']) && isset($sugar_config['ISCProjektTaskStatus'])) {
  $ProjectStatus = $sugar_config['ISCProjektStatus'];
  $ProjectTaskStatus = $sugar_config['ISCProjektTaskStatus'];
  $app_strings['ISC_PROJECT_PROJECTTASK_ERROR'] = 'Bitte wählen Sie eine Projektaufgabe die zum gewählten Projekt gehört!';
  $app_strings['ISC_PROJECTTASK_STATUS_ERROR'] = "Der Status der gewählten Projektaufgabe muss '" . $ProjectTaskStatus . "' sein!";
  $app_strings['ISC_PROJECT_STATUS_ERROR'] = "Der Status des gewählten Projektes muss '" . $ProjectStatus . "' sein!";
  $app_strings['ISC_VALIDATION_ERROR'] = "Folgende Validierungsfehler sind aufgetreten";
  $app_strings['ISC_DATE_ERROR'] = "Das 'Bis' Feld muss nach dem 'Von' Feld sein!";
  $app_strings['ISC_PROJECT_REQUIRED'] = "Das 'Projekt' Feld muss gesetzt sein!";
  $app_strings['ISC_PROJECTTASK_REQUIRED'] = "Das 'Projektaufgabe' Feld muss gesetzt sein!";
  $app_strings['ISC_USER_REQUIRED'] = "Das 'Mitarbeiter' Feld muss gesetzt sein!";
  $app_strings['ISC_ADMIN_REQUIRED'] = "Nur Administratoren dürfen das 'Mitarbeiter' Feld bearbeiten!";
  $app_strings['ISC_PROJECTTASK_USER_ERROR'] = "Sie müssen in der gewählten Projektaufgabe als Ressource aufgeführt sein!";
}
