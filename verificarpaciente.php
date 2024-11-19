<?php

include 'config/conexao.php';

require_once 'config/database.php';
require_once 'config/Client.php';
require_once 'config/config.php';

$response = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // echo "console.log('paps1' )";
  $number_mac = $_POST['id'];
  if ($_POST['pa'] == 'com') {
    $cd_atendimento = $_POST['numero_atend'];
    $sql = 'SELECT * FROM dados WHERE dt_acesso >= DATE_SUB(NOW(), INTERVAL 1 WEEK) AND nm_mac = ? AND numero_atend = ? AND tipo_usuario = "pc"';
  } else {
    $senha_toten = $_POST['senha_toten'];
    $sql = 'SELECT * FROM dados WHERE dt_acesso >= DATE_SUB(NOW(), INTERVAL 1 WEEK) AND nm_mac = ? AND senha_toten = ? AND tipo_usuario = "ps"';
  }
  $vert = mysqli_prepare($conn_my, $sql);
  if ($vert) {

    if ($_POST['pa'] == 'com') {
      mysqli_stmt_bind_param($vert, 'ss', $number_mac, $cd_atendimento);
    } else {
      // echo "console.log('paps1' )";
      mysqli_stmt_bind_param($vert, 'ss', $number_mac, $senha_toten);
    }
    mysqli_stmt_execute($vert);
    mysqli_stmt_store_result($vert);
    if (!mysqli_stmt_num_rows($vert)) {
      if ($_POST['pa'] == 'com') {
        $consulta = "SELECT *
        FROM dbamv.atendime  
        WHERE CD_ATENDIMENTO = :cd_atendimento 
        AND (
        (tp_atendimento = 'I' AND TRUNC(dt_alta) IS NULL)
        OR (tp_atendimento = 'U' AND TRUNC(dt_alta) BETWEEN (TRUNC(SYSDATE - 1)) AND (TRUNC(SYSDATE)))
        OR (tp_atendimento = 'A' AND TRUNC(dt_alta) = TRUNC(SYSDATE))
        OR  (tp_atendimento = 'E' AND TRUNC(dt_alta) = TRUNC(SYSDATE) )
        )";
      } else {
        $consulta =  "SELECT *
        FROM TRIAGEM_ATENDIMENTO
        WHERE DH_PRE_ATENDIMENTO 
        BETWEEN TRUNC(SYSDATE - 1) AND TRUNC(SYSDATE) + INTERVAL '1' 
        DAY - INTERVAL '1' SECOND AND 
        DS_SENHA = :senha_toten ORDER BY CD_TRIAGEM_ATENDIMENTO DESC";
      }
      $stmt = oci_parse($conn_ora, $consulta);
      if ($_POST['pa'] == 'com') {
        oci_bind_by_name($stmt, ':cd_atendimento', $cd_atendimento);
      } else {
        oci_bind_by_name($stmt, ':senha_toten', $senha_toten);
      }
      if (oci_execute($stmt)) {
        if ($row = oci_fetch_assoc($stmt)) {
          $response['success'] = false;
        } else {
          $response['success'] = true;
        }
      } else {
        $response['success'] = true;
      }
      oci_free_statement($stmt);
      oci_close($conn_ora);
    } else {
      $response['logado'] = true;
    }
  } else {
    $response['success'] = true;
  }
  mysqli_stmt_close($vert);
} else {
  $response['success'] = true;
  $response['message'] = "Requisição inválida";
}



// $response['success'] = true;
// $response['success'] = true;
header('Content-Type: application/json');
echo json_encode($response);
