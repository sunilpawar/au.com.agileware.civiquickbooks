<?php

/**
 * Civiquickbooks.ContactPush API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_civiquickbooks_ContactPush_spec(&$spec) {
}

/**
 * Civiquickbooks.ContactPush API
 *
 * @param array $params
 *
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_civiquickbooks_ContactPush($params) {
  $options = _civicrm_api3_get_options_from_params($params);

  $quickbooks = new CRM_Civiquickbooks_Contact();
  $output = $quickbooks->push($params, $options['limit']);

  // ALTERNATIVE: $returnValues = array(); // OK, success
  // ALTERNATIVE: $returnValues = array("Some value"); // OK, return a single value

  // Spec: civicrm_api3_create_success($values = 1, $params = array(), $entity = NULL, $action = NULL)

  return civicrm_api3_create_success($output, $params, 'Civiquickbooks', 'Contactpush');
}
