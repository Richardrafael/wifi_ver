<?php
session_start();
require_once 'config/Client.php';
require_once 'config/config.php';
$_GET['id'];
$_GET['ap'];


$mac = $_GET['id'];
$ap_mac = $_GET['ap'];;


$duration = 720;


$site_id = 'default';


$controller_urls = [
  'https://10.6.0.41:443',
  'https://10.6.0.51:443'
];
foreach ($controller_urls as $controller_url) {
  $unifi_connection = new UniFi_API\Client(
    'portalsc',
    'Santacasa123@',
    $controller_url,
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
  // echo json_encode($auth_result, JSON_PRETTY_PRINT);
}
