<?php
session_start();
include("./config/conexao.php");
require_once 'config/database.php';
require_once 'config/Client.php';
require_once 'config/config.php';


if (isset($_POST['mmac']) && $_POST['mmac'] == 'logado') {
  if (isset($_SESSION['id']) && isset($_SESSION['ap'])) {
    $error = '';
    $iserror = false;
    $device_mac = $_SESSION['id'];
    $ap = $_SESSION['ap'];
    $tipo1 =  $_POST['tipo'];
    $login_time = 720;
    $unifi_connection = new UniFi_API\Client($controller_user, $controller_password, $controller_url, $site_id, $controller_version);
    if ($tipo1 == 'fu') {
      $matricula = $_POST['matricula'];
      $sql = 'SELECT COUNT(DISTINCT nm_mac) FROM dados WHERE dt_acesso >= DATE_SUB(NOW(), INTERVAL 1 WEEK) and matricula = ? and tipo_usuario = "fu" GROUP BY matricula HAVING COUNT(DISTINCT nm_mac) > 1';
    } else {
      $crm = $_POST['crm'];
      $sql = 'SELECT COUNT(DISTINCT nm_mac) FROM dados WHERE dt_acesso >= DATE_SUB(NOW(), INTERVAL 1 WEEK) and crm = ? and tipo_usuario = "me" GROUP BY crm HAVING COUNT(DISTINCT nm_mac) > 1';
    }
    $vert = mysqli_prepare($conn_my, $sql);
    if ($vert) {
      if ($tipo1 == 'fu') {
        mysqli_stmt_bind_param($vert, 's', $matricula);
      } else {
        mysqli_stmt_bind_param($vert, 's', $crm);
      }
      mysqli_stmt_execute($vert);
      mysqli_stmt_store_result($vert);
      if (!mysqli_stmt_num_rows($vert)) {
        $login = $unifi_connection->login();
        if ($login) {
          $result = $unifi_connection->authorize_guest($device_mac,  $login_time, null, null, null, $ap);
          if ($result) {
          } else {
            $iserror = true;
            $error = 'Falha ao autorizar o dispositivo.';
          }
          $unifi_connection->logout();
        } else {
          $iserror = true;
          $error = 'Falha na autenticação.';
        }
      } else {
        if ($tipo1 == 'fu') {
          $consulta = 'SELECT *
          FROM (
              SELECT nm_mac
              FROM dados
              WHERE dt_acesso >= DATE_SUB(NOW(), INTERVAL 1 WEEK) AND matricula = ?
          ) AS subquery
          WHERE nm_mac = ?';
        } else {
          $consulta = 'SELECT *
          FROM (
              SELECT nm_mac
              FROM dados
              WHERE dt_acesso >= DATE_SUB(NOW(), INTERVAL 1 WEEK) AND crm = ?
          ) AS subquery
          WHERE nm_mac = ?';
        }

        $va = mysqli_prepare($conn_my, $consulta);
        if ($tipo1 == 'fu') {
          mysqli_stmt_bind_param($va, 'ss', $device_mac, $matricula);
        } else {
          mysqli_stmt_bind_param($va, 'ss', $device_mac, $crm);
        }
        mysqli_stmt_execute($va);
        mysqli_stmt_store_result($va);
        if (!mysqli_stmt_num_rows($va)) {
          $login = $unifi_connection->login();
          if ($login) {
            $result = $unifi_connection->authorize_guest($device_mac,  $login_time, null, null, null, $ap);
            if ($result) {
            } else {
              $iserror = true;
              $error = 'Falha ao autorizar o dispositivo.';
            }
            $unifi_connection->logout();
          } else {
            $iserror = true;
            $error = 'Falha na autentica&ccedil&atildeo.';
          }
        } else {
          $iserror = true;
          $error = "limite de dispositivos conectados ";
        }
      }
    } else {
      $iserror = true;
      $error = "Erro na prepara&ccedil&atildeo da consulta: " . mysqli_error($conn_my);
    }
  } else {
    $iserror = true;
    $error = 'Vari&aacuteveis de sess&atildeo ausentes ou inv&aacutelidas.';
  }
} else {
  if (isset($_SESSION['id']) && isset($_SESSION['ap'])) {
    $error = '';
    $iserror = false;
    $device_mac = $_SESSION['id'];
    $ap = $_SESSION['ap'];
    $tipo1 = $_POST['tipo1'];
    switch ($tipo1) {
      case  "fu":
        $matricula = $_POST['matricula'];
        $cpf = $_POST['cpf'];
        $tipo = 'fu';
        $cpf_formatado = preg_replace('/[^0-9]/', '', $cpf);
        $login_time = 720;
        $consulta = "SELECT * FROM dbamv.Sta_Tb_Funcionario WHERE  TP_SITUACAO = 'A' AND NM_FUNCIONARIO = :nome AND CHAPA = :chapa AND CPF = :CPF";
        $stmt = oci_parse($conn_ora, $consulta);
        // $nome = strtoupper($_POST['nome']);
        $nome = trim($_POST['nome']);
        oci_bind_by_name($stmt, ':nome', $nome);
        oci_bind_by_name($stmt, ':chapa', $matricula);
        oci_bind_by_name($stmt, ':CPF', $cpf_formatado);
        break;
      case "me":
        $tipo = 'me';
        $crm = $_POST['crm'];
        $cpf_formatado = preg_replace('/[^0-9]/', '',  $_POST['cpf']);
        $login_time = 720;
        $consulta = "SELECT * FROM dbamv.prestador WHERE cd_tip_presta = 8 AND TP_SITUACAO = 'A' AND nr_cpf_cgc = :nr_cpf_cgc AND ds_codigo_conselho = :ds_codigo_conselho and NM_prestador = :nome OR NM_MNEMONICO = :nome ";
        $stmt = oci_parse($conn_ora, $consulta);
        // $nome = strtoupper($_POST['nome']);
        $nome = trim($_POST['nome']);
        oci_bind_by_name($stmt, ':nome', $nome);
        oci_bind_by_name($stmt, ':ds_codigo_conselho', $crm);
        oci_bind_by_name($stmt, ':nr_cpf_cgc', $cpf_formatado);
        break;
    }

    if (oci_execute($stmt)) {
      if ($row = oci_fetch_assoc($stmt)) {
        $unifi_connection = new UniFi_API\Client($controller_user, $controller_password, $controller_url, $site_id, $controller_version);
        switch ($tipo1) {
          case "fu":
            $sql = 'SELECT COUNT(DISTINCT nm_mac) FROM dados WHERE dt_acesso >= DATE_SUB(NOW(), INTERVAL 1 WEEK) and matricula = ? GROUP BY matricula HAVING COUNT(DISTINCT nm_mac) > 1';
            break;
          case "me":
            $sql = 'SELECT COUNT(DISTINCT nm_mac) FROM dados WHERE dt_acesso >= DATE_SUB(NOW(), INTERVAL 1 WEEK) and crm = ? GROUP BY crm HAVING COUNT(DISTINCT nm_mac) > 1';
            break;
        }
        $vert = mysqli_prepare($conn_my, $sql);
        if ($vert) {
          switch ($tipo1) {
            case "fu":
              mysqli_stmt_bind_param($vert, 'i', $matricula);
              break;
            case "me":
              mysqli_stmt_bind_param($vert, 's', $crm);
              break;
          }
          mysqli_stmt_execute($vert);
          mysqli_stmt_store_result($vert);
          if (!mysqli_stmt_num_rows($vert)) {
            $login = $unifi_connection->login();
            if ($login) {
              $result = $unifi_connection->authorize_guest($device_mac,  $login_time, null, null, null, $ap);
              if ($result) {
                switch ($tipo1) {
                  case "fu":
                    $sql = "INSERT INTO dados (cd_conexao, dt_acesso, nm_mac, ds_nome, matricula, cpf , sn_termo , tipo_usuario) VALUES (NULL, NOW(), '$device_mac', '$nome', '$matricula', '$cpf_formatado', 'S' , '$tipo' )";
                    break;
                  case "me":
                    $sql = "INSERT INTO dados (cd_conexao, dt_acesso, nm_mac, crm, ds_nome, cpf , sn_termo , tipo_usuario) VALUES (NULL, NOW(), '$device_mac', '$crm', '$nome', '$cpf_formatado', 'S' , '$tipo' )";
                    break;
                }
                if (mysqli_query($conn_my, $sql)) {
                } else {
                  $iserror = true;
                  $error = "Erro na inserção: " . mysqli_error($conn_my);
                }
              } else {
                $iserror = true;
                $error = 'Falha ao autorizar o dispositivo.';
              }
              $unifi_connection->logout();
            } else {
              $iserror = true;
              $error = 'Falha na autenticação.';
            }
          } else {
            $iserror = true;
            $error = "limite de dispositivos conectados ";
          }
        } else {
          $iserror = true;
          $error = "Erro na prepara&ccedil&atildeo da consulta: " . mysqli_error($conn_my);
        }
      } else {
        $iserror = true;
        if ($tipo1 == "fu") {
          $error = "Funcion&aacuterio n&atildeo encontrado ";
        } else {
          $error = "Medico n&atildeo encontrado";
        }
      }
    } else {
      $iserror = true;
      $error = "Erro ao executar a consulta: " . oci_error($stmt)['message'];
    }
    oci_free_statement($stmt);
    oci_close($conn_ora);
  } else {
    $iserror = true;
    $error = 'Vari&aacuteveis de sessão ausentes ou inválidas.';
  }
}

$pagina = '';

if ($tipo1 == 'fu') {
  $pagina = 'funcionario.php';
} else {
  $pagina = 'medico.php';
}


?>
<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="estilos/results.css">
  <link rel="stylesheet" href="css/fontawesomee/css/all.min.css">
  <link rel="icon" type="image/x-icon" href="https://www.santacasasjc.com.br/wp-content/uploads/2018/06/cropped-favicon-ht-32x32.png">
  <title>Authorização medico</title>
</head>

<body>
  <div class="header">
    <a href="<?php echo $pagina; ?>?id=<?php echo $device_mac; ?>&ap=<?php echo $ap ?>" class="botao-seta">
      <i class="fa-regular fa-circle-left"></i>
    </a>
    <img class="logo" src="image/santacasa.png" alt="Santa Casa São José dos Campos" class="logowifi">
  </div>
  <?php if ($iserror) : ?>
    <div class="container-results">
      <span class="error">
        <?= $error; ?>
      </span>
      <span class="volte">
        Volte e tente novamente
      </span>
      <a class="btn" href="<?php echo $pagina; ?>?id=<?php echo $device_mac; ?>&ap=<?php echo $ap ?>">
        Voltar
      </a>
    </div>
  <?php else : ?>
    <div class="container-results">
      <span class="sucesso">Autentifica&ccedil&atildeo bem sucedida</span>
      <span class="descrition">
        Sua sess&atildeo ser&aacute expirada em
      </span>
      <div class="hours">
        <i class="fa-solid fa-clock"></i>
        1h
      </div>
    </div>
  <?php endif; ?>
</body>

</html>