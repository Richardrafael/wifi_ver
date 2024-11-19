<?php
require_once 'config/database.php';
require_once 'config/Client.php';
require_once 'config/config.php';

$response = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $number_mac = $_POST['id'];
  if ($_POST['fu'] == 'fu') {
    $matricula = $_POST['matricula'];
    $sql = 'SELECT * FROM dados WHERE dt_acesso >= DATE_SUB(NOW(), INTERVAL 1 WEEK) AND nm_mac = ? AND matricula = ? AND tipo_usuario = "fu"';
  } else {
    $crm = $_POST['crm'];
    $sql = 'SELECT * FROM dados WHERE dt_acesso >= DATE_SUB(NOW(), INTERVAL 1 WEEK) AND nm_mac = ? AND crm = ? AND tipo_usuario = "me"';
  }
  $stmt = mysqli_prepare($conn_my, $sql);
  if ($stmt) {
    if ($_POST['fu'] == 'fu') {
      mysqli_stmt_bind_param($stmt, 'ss', $number_mac, $matricula);
    } else {
      mysqli_stmt_bind_param($stmt, 'ss', $number_mac, $crm);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (!mysqli_stmt_num_rows($stmt)) {
      $response['success'] = false;
    } else {
      $response['success'] = true;
    }
    mysqli_stmt_close($stmt);
  } else {
    $response['success'] = false;
    $response['message'] = "Erro na preparação da consulta: " . mysqli_error($conn_my);
  }
} else {
  $response['success'] = false;
  $response['message'] = "Requisição inválida";
}

// Envia a resposta como JSON
header('Content-Type: application/json');
echo json_encode($response);
