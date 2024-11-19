<?php
session_start();
require_once 'config/database.php';
require_once 'config/Client.php';
require_once 'config/config.php';


if (isset($_SESSION['id']) && isset($_SESSION['ap'])) {
  $error = '';
  $iserror = false;
  if (isset($_POST['tipo1'])) {
    $tipo = $_POST['tipo1'];
  }
  if ($_POST['mmac'] != 'logado') {
    if ($tipo == 'pc') {
      $cpf1 = $_POST['cpf1'];
      $cpf_formatado = preg_replace('/[^0-9]/', '', $cpf1);
    } else {
      $cpf = $_POST['cpf'];
      $cpf_formatado = preg_replace('/[^0-9]/', '', $cpf);
    }
  } else {
    $tipo_logado = true;
  }

  $controller_urls = [
    'https://10.6.0.41:443',
    'https://10.6.0.51:443'
  ];
  $errors = [];

  $login_time = 60;

  foreach ($controller_urls as $controller_url) {
    $unifi_connection = new UniFi_API\Client($controller_user, $controller_password, $controller_url, $site_id, $controller_version);
    $login = $unifi_connection->login();

    if ($login) {
      $result = $unifi_connection->authorize_guest($_SESSION['id'],  $login_time, null, null, null, $_SESSION['ap']);
      if ($result) {
        // $passou = true;
        $authorization_results[$controller_url] = true;

      } else {
        // echo 'console.log("lxsdpmxcskl")';
        $authorization_results[$controller_url] = false;
        $iserror = true;
        if ($controller_url == 'https://10.6.0.41:443') {
          $error = 'Falha ao autorizar o dispositivo na controladora 1';
        } else {
          $error = 'Falha ao autorizar o dispositivo na controladora 2';
        }
        // exit();
      }
    } else {
      $authorization_results[$controller_url] = false;
      $iserror = true;
      if ($controller_url == 'https://10.6.0.41:443') {
        $error = 'Falha ao autorizar o dispositivo na controladora 1';
      } else {
        $error = 'Falha ao autorizar o dispositivo na controladora 2';
      }
      // exit();
    }
  }

  // $unifi_connection = new UniFi_API\Client($controller_user, $controller_password, $controller_url, $site_id, $controller_version);
  // $login = $unifi_connection->login();
  if (count($authorization_results) == count($controller_urls) && !in_array(false, $authorization_results)) {
    if ($_POST['mmac'] != 'logado' && isset($_POST['mmac'])) {
      if ($tipo == 'pc' || $tipo == 'ps') {
        if ($tipo == 'pc') {
          $sql = "INSERT INTO dados (cd_conexao, dt_acesso, nm_mac, numero_atend, cpf , ds_email , sn_termo , tipo_usuario , data_nasc) VALUES (NULL, NOW(), '{$_SESSION['id']}', '{$_POST['numero_atend']}', '$cpf_formatado', '{$_POST['email_1']}',  'S' , '$tipo' , '{$_POST['data_nasc']}')";
        } else {
          $sql = "INSERT INTO dados (cd_conexao, dt_acesso, nm_mac, senha_toten, ds_nome, cpf , ds_email , ds_telefone , sn_termo , tipo_usuario , data_nasc) VALUES (NULL, NOW(), '{$_SESSION['id']}' , '{$_POST['senha_toten']}', '{$_POST['nome']}', '$cpf_formatado', '{$_POST['email']}',  '{$_POST['tel']}' ,'S' , '$tipo' , '{$_POST['data_nascimento']}')";
        }
      } else {
        $sql = "INSERT INTO dados (cd_conexao, dt_acesso, nm_mac, ds_nome, ds_email, ds_telefone, sn_termo , tipo_usuario , cpf) VALUES (NULL, NOW(), '{$_SESSION['id']}', '{$_POST['nome']}', '{$_POST['email']}', '{$_POST['tel']}', 'S' , '$tipo' ,'$cpf_formatado')";
      }
      if (mysqli_query($conn_my, $sql)) {
      } else {
        $iserror = true;
        $error = "Erro na insers o " . mysqli_error($conn_my);
      }
    }
  }
  $unifi_connection->logout();
} else {
  $iserror = true;
  $error = 'Variaveis de sess o ausentes ou inv lidas.';
}



if (isset($tipo) && ($tipo == 'ps' || $tipo == 'pc')) {
  $pagina = 'paciente.php';
} else {
  $pagina = 'visitante.php';
}



?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="estilos/results.css">
  <link rel="stylesheet" href="css/fontawesomee/css/all.min.css">
  <link rel="icon" type="image/x-icon" href="https://www.santacasasjc.com.br/wp-content/uploads/2018/06/cropped-favicon-ht-32x32.png">
  <title>Exemplo de PHP</title>
</head>

<body>
  <div class="header">
    <a href="<?php echo $pagina ?>?id=<?php echo $_SESSION['id']; ?>&ap=<?php echo $_SESSION['ap']; ?>" class="botao-seta">
      <i class="fa-regular fa-circle-left"></i>
    </a>
    <img class="logo" src="image/santacasa.png" alt="Santa Casa S�o Jos� dos Campos" class="logowifi">
  </div>
  <?php if ($iserror) : ?>
    <div class="container-results">
      <span class="error">
        <?= $error; ?>
      </span>
      <span class="volte">
        Volte e tente novamente
      </span>
      <a class="btn" href="<?php echo $pagina ?>?id=<?php echo $_SESSION['id']; ?>&ap=<?php echo $_SESSION['ap']; ?>">
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