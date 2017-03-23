<?php

require_once 'cshtokens.civix.php';

/**
 * Implements hook_civicrm_tokens().
 */
function cshtokens_civicrm_tokens(&$tokens) {
  if (pogstone_is_user_authorized('access CiviPledge')) {
    _cshtokens_append_pledge_tokens($tokens);
  }
}

/**
 * Implements hook_civicrm_tokenValues().
 */
function cshtokens_civicrm_tokenValues(&$values, &$contactIDs, $job = null, $tokens = array(), $context = null) {
  _cshtokens_append_pledge_token_values($values, $contactIDs, $job, $tokens, $context);
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function cshtokens_civicrm_config(&$config) {
  _cshtokens_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function cshtokens_civicrm_xmlMenu(&$files) {
  _cshtokens_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function cshtokens_civicrm_install() {
  _cshtokens_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function cshtokens_civicrm_postInstall() {
  _cshtokens_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function cshtokens_civicrm_uninstall() {
  _cshtokens_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function cshtokens_civicrm_enable() {
  _cshtokens_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function cshtokens_civicrm_disable() {
  _cshtokens_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function cshtokens_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _cshtokens_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function cshtokens_civicrm_managed(&$entities) {
  _cshtokens_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function cshtokens_civicrm_caseTypes(&$caseTypes) {
  _cshtokens_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function cshtokens_civicrm_angularModules(&$angularModules) {
  _cshtokens_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function cshtokens_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _cshtokens_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function cshtokens_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function cshtokens_civicrm_navigationMenu(&$menu) {
  _cshtokens_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'com.jvillage.cshtokens')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _cshtokens_civix_navigationMenu($menu);
} // */

/**
 * Append pledge tokens to the given $tokens array, if the CiviPledge component
 * is enabled.
 *
 * @param array $tokens As given in the first parameter of hook_civicrm_tokens().
 */
function _cshtokens_append_pledge_tokens(&$tokens) {
  // Only add these tokens if the CiviPledge component is enabled.
  if (_cshtokens_is_civipledge_enabled()) {
    $tokens['CSH'] = array();
    $financialTypes = CRM_Contribute_PseudoConstant::financialType();
    foreach ($financialTypes as $id => $title) {
      $tokens['CSH']["CSH.givingtotal_financialtype___{$id}"] = "CSH: Giving Total: {$title}";
    }
  }
}

/**
 * Check whether the CiviPledge component is enabled.
 *
 * @staticvar Bool $is_civipledge_enabled The return value.
 *
 * @return Bool
 */
function _cshtokens_is_civipledge_enabled() {
  static $is_civipledge_enabled;
  if (!isset($is_civipledge_enabled)) {
    $result = civicrm_api3('Setting', 'get', array(
      'sequential' => 1,
      'return' => array("enable_components"),
    ));
    $is_civipledge_enabled = (!empty($result['values'][0]['enable_components']) && in_array('CiviPledge', $result['values'][0]['enable_components']));
  }
  return $is_civipledge_enabled;
}

/**
 * Append pledge token values to the given $values array, if the CiviPledge
 * component is enabled. All params are passed through as they are received in
 * financialtokens_civicrm_tokenValues().
 *
 * @see cshtokens_civicrm_tokenValues
 */
function _cshtokens_append_pledge_token_values(&$values, &$contactIDs, $job = null, $tokens = array(), $context = null) {
  // Presently we only support tokens in the form
  // "finances.pledge_givingtotal_financialtype___{$id}", where $id is a financial
  // type ID.

  // Only proceed if pledge tokens are in use and CiviPledge is enabled.
  if (!empty($tokens['CSH']) && _cshtokens_is_civipledge_enabled()) {
    // Compile a list of values that appear after the '___' delimiter in the
    // token string.
    $tokenbase_values = array();

    foreach ($tokens['CSH'] as $token) {
      $tokenparts = explode('___', strrev($token), 2);
      $financial_type_id = strrev($tokenparts[0]);
      $tokenbase = strrev($tokenparts[1]);
      $tokenbase_values[$tokenbase][] = $financial_type_id;
    }

    // Only proceed if any 'givingtotal_financialtype___N' tokens are in use.
    if (array_key_exists('givingtotal_financialtype', $tokenbase_values)) {
      // Query the database and store any found values.
      $db_values = array();
      $contact_ids_string = implode(',', $contactIDs);
      $financial_type_ids_string = implode(',', $tokenbase_values['givingtotal_financialtype']);
      $query = "
        -- 1.  A person's pledge total for a specific financial type (like DU2016)
        -- Includes:
        -- a. All pledged amounts with this financial type, whether they've been paid or not.
        --
        -- PLUS
        -- 2.  A person's total recurring contributions for a specific financial type (like DU2016)
        -- Includes:
        -- a. All line items with this financial type in completed installments on recurring contributions.
        -- b. All line items with this financial type in expected future installments on recurring contributions that have a known number of installments.
        -- Excludes:
        -- a. Line items in expected future installments on open-ended recurring contributions (since their total is effectively infinite).
        --
        -- PLUS
        -- 3.  A person's total completed contributions that are not either of 1 or 2 for a specific financial type (like DU2016)
        -- Includes:
        -- a. All line items with this financial type in completed contribution not tied to a pledge (since it would be counted in item 1).
        -- a. All line items with this financial type in completed contribution not tied to a recurring contribution having a known number of installments (since it would be counted in item 2).


        select t.contact_id, t.financial_type_id, sum(t.amount) as sum_amount
        FROM (
          -- Pledges
          SELECT contact_id, financial_type_id, amount
          FROM civicrm_pledge
          WHERE
            contact_id in ($contact_ids_string)
            AND financial_type_id in ($financial_type_ids_string)

          UNION ALL -- (get all rows; otherwise, UNION will remove duplicate rows)
          -- recurring contributions
          SELECT ctrb.contact_id, li.financial_type_id, (cr.installments * li.line_total) as amount
          FROM
            civicrm_contribution_recur cr
            INNER JOIN civicrm_contribution ctrb ON cr.id = ctrb.contribution_recur_id
            INNER JOIN civicrm_line_item li ON li.contribution_id = ctrb.id
          WHERE
            ctrb.contact_id in ($contact_ids_string)
            AND li.financial_type_id in ($financial_type_ids_string)
            AND cr.contribution_status_id = 5 -- 'in progress'
            AND cr.installments IS NOT NULL

          UNION ALL -- (get all rows; otherwise, UNION will remove duplicate rows)
          -- completed contributions
          SELECT ctrb.contact_id, li.financial_type_id, li.line_total as amount
          FROM
            civicrm_contribution ctrb
            INNER JOIN civicrm_line_item li ON li.contribution_id = ctrb.id
            LEFT JOIN civicrm_pledge_payment pp ON pp.contribution_id = ctrb.id
            LEFT JOIN civicrm_contribution_recur cr ON cr.id = ctrb.contribution_recur_id AND cr.installments IS NOT NULL
          WHERE
            ctrb.contact_id in ($contact_ids_string)
            AND li.financial_type_id in ($financial_type_ids_string)
            AND ctrb.contribution_status_id = 1 -- 'completed'
            AND pp.id IS NULL
            AND cr.id IS NULL
        ) t
        GROUP BY t.contact_id, t.financial_type_id
      ";
      
      $dao = &CRM_Core_DAO::executeQuery($query);
      while ($dao->fetch()) {
        $db_values[$dao->contact_id]["CSH.givingtotal_financialtype___{$dao->financial_type_id}"] = $dao->sum_amount;
      }

      // Now populate all 'givingtotal_financialtype___N' values or all contacts,
      // defaulting to 0 if there's nothing in $db_values.
      foreach ($contactIDs as $contact_id) {
        foreach ($tokenbase_values['givingtotal_financialtype'] as $financial_type_id) {
          if (!empty($db_values[$contact_id]["CSH.givingtotal_financialtype___{$financial_type_id}"])) {
            $value = $db_values[$contact_id]["CSH.givingtotal_financialtype___{$financial_type_id}"];
          }
          else {
            $value = 0;
          }
          $values[$contact_id]["CSH.givingtotal_financialtype___{$financial_type_id}"] = CRM_Utils_Money::format($value);
        }
      }
    }
  }
}
