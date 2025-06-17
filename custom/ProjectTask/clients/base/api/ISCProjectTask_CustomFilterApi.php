<?php
/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 03.12.2018
 * Change Date   : 03.12.2018
 * Main Program  : Extension
 * Description   : Adds filtering on empty Project
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once("clients/base/api/FilterApi.php");

class ISCProjectTask_CustomFilterApi extends FilterApi {

    public function registerApiRest() {
        //in case we want to add additional endpoints


        return array(
            'Zeiterfassung_filterModuleAll' => array(
                'reqType'    => 'GET',
                'path'       => array('ProjectTask'),
                'pathVars'   => array('module'),
                'method'     => 'filterList',
                'jsonParams' => array('filter'),
                'shortHelp'  => 'Sonderlocke für Pjtask',
                'longHelp'   => 'include/api/help/module_filter_get_help.html',
                'exceptions' => array(
                    // Thrown in getPredefinedFilterById
                    'SugarApiExceptionNotFound',
                    'SugarApiExceptionError',
                    // Thrown in filterList and filterListSetup
                    'SugarApiExceptionInvalidParameter',
                    // Thrown in filterListSetup, getPredefinedFilterById, and parseArguments
                    'SugarApiExceptionNotAuthorized',
                ),
            )
        );


    }

    protected static function addFilter($field, $filter, SugarQuery_Builder_Where $where, SugarQuery $q) {
        // It's an email participant filter if the module is Emails and the field is an email participants operand.
        if ($q->getFromBean()->getModuleName() === 'Emails' && in_array($field, ['$from', '$to', '$cc', '$bcc'])) {
            static::addEmailParticipantFilter($q, $where, $filter, $field);
        } elseif (in_array($q->getFromBean()->getModuleName(), ['Calls', 'Meetings']) && $field === '$guest') {
            static::addGuestFilter($q, $where, $filter);
        } elseif ($field == '$or') {
            static::addFilters($filter, $where->queryOr(), $q);
        } elseif ($field == '$and') {
            static::addFilters($filter, $where->queryAnd(), $q);
        } elseif ($field == '$favorite') {
            static::addFavoriteFilter($q, $where, $filter);
        } elseif ($field == '$owner') {
            static::addOwnerFilter($q, $where, $filter);
        } elseif ($field == '$creator') {
            static::addCreatorFilter($q, $where, $filter);
        } elseif ($field == '$tracker') {
            static::addTrackerFilter($q, $where, $filter);
        } elseif ($field == '$following') {
            static::addFollowFilter($q, $where, $filter);
        }//ISC KOK Added current user Filter
        elseif ($field == '$isc_user') {
            static::addISCOwnerFilter($q);
        } //ISC END
        else {
            static::addFieldFilter($q, $where, $filter, $field);
        }
    }

    protected static function addFieldFilter(SugarQuery $q, SugarQuery_Builder_Where $where, $filter, $field) {
        static $sfh;
        if (!isset($sfh)) {
            $sfh = new SugarFieldHandler();
        }

        // Looks like just a normal field, parse its options
        $fieldInfo = self::verifyField($q, $field);

        // If the field was a related field and we added a join, we need to adjust the table name used
        // to get the right join table alias
        if (!empty($fieldInfo['field'])) {
            $field = $fieldInfo['field'];
        }

        // It's an email participant filter if the module is Emails and the field is an email participants field.
        $fromModule = $q->getFromBean()->getModuleName();
        $emailParticipantsFields = ['from_collection', 'to_collection', 'cc_collection', 'bcc_collection'];
        if ($fromModule === 'Emails' && in_array($field, $emailParticipantsFields)) {
            static::addEmailParticipantFieldFilter($q, $where, $filter, $field);
            return;
        }

        $fieldType = !empty($fieldInfo['def']['custom_type']) ? $fieldInfo['def']['custom_type'] :
            $fieldInfo['def']['type'];
        $sugarField = $sfh->getSugarField($fieldType);
        if (!is_array($filter)) {
            $value = $filter;
            $filter = array();
            $filter['$equals'] = $value;
        }
        foreach ($filter as $op => $value) {
            /*
             * occasionally fields may need to be fixed up for the Filter, for instance if you are
             * doing an operation on a datetime field and only send in a date, we need to fix that field to
             * be a dateTime then unFormat it so that its in GMT ready for DB use
             */

            if (strpos($field, '.') === false) {
                if (isset($fieldInfo['def']['source']) && $fieldInfo['def']['source'] === 'custom_fields') {
                    $tableName = $fieldInfo['bean']->get_custom_table_name();
                } else {
                    $tableName = $fieldInfo['bean']->getTableName();
                }
                $columnName = $tableName . '.' . $field;
            } else {
                $columnName = $field;
            }

            if ($sugarField->fixForFilter($value, $columnName, $fieldInfo['bean'], $q, $where, $op) == false) {
                continue;
            }

            if (is_array($value)) {
                foreach ($value as $i => $val) {
                    // FIXME: BR-4063 apiUnformat() is deprecated, this will change to apiUnformatField() in
                    // next API version
                    $value[$i] = $sugarField->apiUnformat($val);
                }
            } else {
                // FIXME: BR-4063 apiUnformat() is deprecated, this will change to apiUnformatField() in
                // next API version
                $value = $sugarField->apiUnformat($value);
            }

            switch ($op) {
                case '$equals':
                    $where->equals($field, $value);
                    break;
                case '$not_equals':
                    $where->notEquals($field, $value);
                    break;
                case '$starts':
                    $where->starts($field, $value);
                    break;
                case '$ends':
                    $where->ends($field, $value);
                    break;
                case '$contains':
                    $where->contains($field, $value);
                    break;
                case '$not_contains':
                    $where->notContains($field, $value);
                    break;
                case '$in':
                    if (!is_array($value)) {
                        throw new SugarApiExceptionInvalidParameter('$in requires an array');
                    }
                    //ISC GmbH RK: Fix for Project Task Filter
                    if ((count($value) == 1) && (empty($value[0]))) {
                        break;
                    }
                    //END
                    $where->in($field, $value);
                    break;
                case '$not_in':
                    if (!is_array($value)) {
                        throw new SugarApiExceptionInvalidParameter('$not_in requires an array');
                    }
                    $where->notIn($field, $value);
                    break;
                case '$dateBetween':
                case '$between':
                    if (!is_array($value) || count($value) != 2) {
                        throw new SugarApiExceptionInvalidParameter(
                            '$between requires an array with two values.'
                        );
                    }
                    $where->between($field, $value[0], $value[1]);
                    break;
                case '$is_null':
                    $where->isNull($field);
                    break;
                case '$not_null':
                    $where->notNull($field);
                    break;
                case '$empty':
                    $where->isEmpty($field);
                    break;
                case '$not_empty':
                    $where->isNotEmpty($field);
                    break;
                case '$lt':
                    $where->lt($field, $value);
                    break;
                case '$lte':
                    $where->lte($field, $value);
                    break;
                case '$gt':
                    $where->gt($field, $value);
                    break;
                case '$gte':
                    $where->gte($field, $value);
                    break;
                case '$dateRange':
                    $where->dateRange($field, $value, $fieldInfo['bean']);
                    break;
                //ISC Kok 23.08.17 //Auswahl der Projekte, bei denen in einer Projektaufgabe der aktuelle Nutzer enthalten ist
                case '$isc_current_user':
                    //ISC TF, 14.12.18: Einzelne Gruppierung der Abfrage hinzugefügt
                    $q->distinct(true)->joinTable('project_task')->on()->equalsField('project.id', 'project_task.project_id')
                        ->equals('project_task.deleted', '0');
                    static::addISCOwnerFilter($q);
                    //Filter auf Status von Projektaufgabe
                    global $sugar_config;
                    $Filter = $sugar_config['ISCProjektTaskStatus'];
                    $q->where()->equals('project_task.status', $Filter);
                    break;
                case '$isc_today':
                    $where->dateRange("date_from", 'today');
                    break;
                default:
                    throw new SugarApiExceptionInvalidParameter('Did not recognize the operand: ' . $op);
            }
        }
    }
    /**
     * Add filters to the query
     *
     * @param array                    $filterDefs
     * @param SugarQuery_Builder_Where $where
     * @param SugarQuery               $q
     * @throws SugarApiExceptionInvalidParameter
     */
//    protected static function addFilters(array $filterDefs, SugarQuery_Builder_Where $where, SugarQuery $q) {
//        static $sfh;
//        if (!isset($sfh)) {
//            $sfh = new SugarFieldHandler();
//        }
//
//        foreach ($filterDefs as $filterDef) {
//            if (!is_array($filterDef)) {
//                throw new SugarApiExceptionInvalidParameter(
//                    sprintf(
//                        'Did not recognize the definition: %s', print_r($filterDef, true)
//                    )
//                );
//            }
//            foreach ($filterDef as $field => $filter) {
//                if ($field == '$or') {
//                    static::addFilters($filter, $where->queryOr(), $q);
//                } elseif ($field == '$and') {
//                    static::addFilters($filter, $where->queryAnd(), $q);
//                } elseif ($field == '$favorite') {
//                    static::addFavoriteFilter($q, $where, $filter);
//                } elseif ($field == '$owner') {
//                    static::addOwnerFilter($q, $where, $filter);
//                } elseif ($field == '$creator') {
//                    static::addCreatorFilter($q, $where, $filter);
//                } elseif ($field == '$tracker') {
//                    static::addTrackerFilter($q, $where, $filter);
//                } elseif ($field == '$following') {
//                    static::addFollowFilter($q, $where, $filter);
//                } //ISC KOK Added current user Filter
//                elseif ($field == '$isc_user') {
//                    static::addISCOwnerFilter($q);
//                } //ISC END
//                else {
//                    // Looks like just a normal field, parse its options
//                    $fieldInfo = self::verifyField($q, $field);
//
//                    // If the field was a related field and we added a join, we need to adjust the table name used
//                    // to get the right join table alias
//                    if (!empty($fieldInfo['field'])) {
//                        $field = $fieldInfo['field'];
//                    }
//                    $fieldType = !empty($fieldInfo['def']['custom_type']) ? $fieldInfo['def']['custom_type'] :
//                        $fieldInfo['def']['type'];
//                    $sugarField = $sfh->getSugarField($fieldType);
//                    if (!is_array($filter)) {
//                        $value = $filter;
//                        $filter = array();
//                        $filter['$equals'] = $value;
//                    }
//                    foreach ($filter as $op => $value) {
//                        /*
//                         * occasionally fields may need to be fixed up for the Filter, for instance if you are
//                         * doing an operation on a datetime field and only send in a date, we need to fix that field to
//                         * be a dateTime then unFormat it so that its in GMT ready for DB use
//                         */
//                        if ($sugarField->fixForFilter($value, $field, $fieldInfo['bean'], $q, $where, $op) == false) {
//                            continue;
//                        }
//
//                        if (is_array($value)) {
//                            foreach ($value as $i => $val) {
//                                // FIXME: BR-4063 apiUnformat() is deprecated, this will change to apiUnformatField() in
//                                // next API version
//                                $value[$i] = $sugarField->apiUnformat($val);
//                            }
//                        } else {
//                            // FIXME: BR-4063 apiUnformat() is deprecated, this will change to apiUnformatField() in
//                            // next API version
//                            $value = $sugarField->apiUnformat($value);
//                        }
//
//                        switch ($op) {
//                            case '$equals':
//                                $where->equals($field, $value);
//                                break;
//                            case '$not_equals':
//                                $where->notEquals($field, $value);
//                                break;
//                            case '$starts':
//                                $where->starts($field, $value);
//                                break;
//                            case '$ends':
//                                $where->ends($field, $value);
//                                break;
//                            case '$contains':
//                                $where->contains($field, $value);
//                                break;
//                            case '$not_contains':
//                                $where->notContains($field, $value);
//                                break;
//                            case '$in':
//                                if (!is_array($value)) {
//                                    throw new SugarApiExceptionInvalidParameter('$in requires an array');
//                                }
//                                //ISC GmbH RK: Fix for Project Task Filter
//                                if ((count($value) == 1) && (empty($value[0]))) {
//                                    break;
//                                }
//                                //END
//                                $where->in($field, $value);
//                                break;
//                            case '$not_in':
//                                if (!is_array($value)) {
//                                    throw new SugarApiExceptionInvalidParameter('$not_in requires an array');
//                                }
//                                $where->notIn($field, $value);
//                                break;
//                            case '$dateBetween':
//                            case '$between':
//                                if (!is_array($value) || count($value) != 2) {
//                                    throw new SugarApiExceptionInvalidParameter(
//                                        '$between requires an array with two values.'
//                                    );
//                                }
//                                $where->between($field, $value[0], $value[1]);
//                                break;
//                            case '$is_null':
//                                $where->isNull($field);
//                                break;
//                            case '$not_null':
//                                $where->notNull($field);
//                                break;
//                            case '$empty':
//                                $where->isEmpty($field);
//                                break;
//                            case '$not_empty':
//                                $where->isNotEmpty($field);
//                                break;
//                            case '$lt':
//                                $where->lt($field, $value);
//                                break;
//                            case '$lte':
//                                $where->lte($field, $value);
//                                break;
//                            case '$gt':
//                                $where->gt($field, $value);
//                                break;
//                            case '$gte':
//                                $where->gte($field, $value);
//                                break;
//                            case '$dateRange':
//                                $where->dateRange($field, $value, $fieldInfo['bean']);
//                                break;
//                            //ISC Kok 23.08.17 //Auswahl der Projekte, bei denen in einer Projektaufgabe der aktuelle Nutzer enthalten ist
//                            case '$isc_current_user':
//                                $q->joinTable('project_task')->on()->equalsField('project.id', 'project_task.project_id')
//                                    ->equals('project_task.deleted', '0');
//                                static::addISCOwnerFilter($q);
//                                //Filter auf Status von Projektaufgabe
//                                global $sugar_config;
//                                $Filter = $sugar_config['ISCProjektTaskStatus'];
//                                $q->where()->equals('project_task.status', $Filter);
//                                break;
//                            case '$isc_today':
//                                $where->dateRange("date_from", 'today');
//                                break;
//                            default:
//                                throw new SugarApiExceptionInvalidParameter('Did not recognize the operand: ' . $op);
//                        }
//                    }
//                }
//            }
//        }
//    }


    /**
     * This function adds an owner filter to the sugar query
     *
     * @param SugarQuery               $q The whole SugarQuery object
     * @param SugarQuery_Builder_Where $where The Where part of the SugarQuery object
     * @param string                   $link Which module are you adding the owner filter to.
     */
//    protected static function addOwnerFilter(SugarQuery $q, SugarQuery_Builder_Where $where, $link) {
//        if ($link == '' || $link == '_this') {
//            $linkPart = '';
//        } else {
//            $join = $q->join($link, array('joinType' => 'LEFT'));
//            $linkPart = $join->joinName() . '.';
//        }
//
//        $where->equals($linkPart . 'assigned_user_id', self::$current_user->id);
//    }

    //ISC Kok Added Filter on current user in Project Task
    protected static function addISCOwnerFilter(SugarQuery $q) {
        $q->joinTable('projecttask_users_1_c', array('joinType' => 'INNER'))->on()
            ->equalsField('project_task.id', 'projecttask_users_1_c.projecttask_users_1projecttask_ida');
        $q->where()->equals('projecttask_users_1_c.projecttask_users_1users_idb', self::$current_user->id);
        $q->where()->equals('projecttask_users_1_c.deleted', '0');
    }

    //ISC End
}
