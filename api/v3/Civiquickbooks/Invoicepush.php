<?php

/**
 * Civiquickbooks.InvoicePush API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_civiquickbooks_InvoicePush_spec(&$spec) {
  $spec['contribution_id'] = array(
    'type' => CRM_Utils_Type::T_INT,
    'name' => 'contribution_id',
    'title' => 'Contribution ID',
    'description' => 'contribution id (optional, overrides needs_update flag)',
  );
  $spec['last_sync_date'] = array(
    'type' => CRM_Utils_Type::T_STRING,
    'name' => 'last_sync_date',
    'title' => 'Contribution Record modified date',
    'description' => 'use this.month, this.year as input to this field',
  );
}

/**
 * Civiquickbooks.InvoicePush API
 *
 * @param array $params
 *
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_civiquickbooks_InvoicePush($params) {
  $options = _civicrm_api3_get_options_from_params($params);
  // get date range for updated contribution records in civicrm to push to QB
  // expected input is like report filter date relative dates.
  // eg : this.month, this.year, this convert into actual date range and provide input to account api
  if (!empty($params['last_sync_date'])) {
    list($from, $to) = CRM_Utils_Date::getFromTo($params['last_sync_date'], '', '');
    $params['last_sync_date'] = [
      'BETWEEN' => [
        '0' => $from,
        '1' => $to,
      ],
    ];
  }

  $quickbooks = new CRM_Civiquickbooks_Invoice($params);
  $result = $quickbooks->push($params, $options['limit']);

  return civicrm_api3_create_success($result, $params, 'Civiquickbooks', 'Invoicepush');
}
