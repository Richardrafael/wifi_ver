<?php

/**
 * PHP API usage example
 *
 * contributed by: Art of WiFi
 * description:    example PHP script to perform a basic auth of a guest device
 */

/**
 * using the composer autoloader
 */
require_once 'config/Client.php';

/**
 * include the config file (place your credentials etc. there if not already present)
 * see the config.template.php file for an example
 */
require_once 'config/config.php';

/**
 * the MAC address of the device to authorize
 */
$mac = '60:3c:ee:02:66:bb';

/**
 * the MAC address of the Access Point the guest is currently connected to, enter null (without quotes)
 * if not known or unavailable
 *
 * NOTE:
 * although the AP MAC address is not a required parameter for the authorize_guest() function,
 * adding this parameter will speed up the initial authorization process
 */
$ap_mac = '60:22:32:57:44:48';

/**
 * the duration to authorize the device for in minutes
 */
$duration = 2000;

/**
 * The site to authorize the device with
 */
$site_id = 'default';

/**
 * initialize the UniFi API connection class and log in to the controller
 */
$unifi_connection = new UniFi_API\Client(
  'portalsc',
  'Santacasa123@',
  'https://10.6.0.51:443',
  $site_id,
  '7.1.65'
);

$set_debug_mode = $unifi_connection->set_debug($debug);
$loginresults   = $unifi_connection->login();

/**
 * then we authorize the device for the requested duration
 */
$auth_result = $unifi_connection->authorize_guest($mac, $duration, null, null, null, $ap_mac);

/**
 * provide feedback in json format
 */
echo json_encode($auth_result, JSON_PRETTY_PRINT);
