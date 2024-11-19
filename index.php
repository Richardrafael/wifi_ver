<?php
session_start();
$_SESSION['id'] = $_GET['id'];          //user's mac address
$_SESSION['ap'] = $_GET['ap'];          // user ap
include('estilos/all_users.php')
?>
<!DOCTYPE html>


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Wi-Fi
  </title>
  <link href="estilos/all_users.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="css/fontawesomee/css/all.min.css">
  <link rel="icon" type="image/x-icon" href="https://www.santacasasjc.com.br/wp-content/uploads/2018/06/cropped-favicon-ht-32x32.png">
</head>

<body>
  <img class="logo" src="image/santacasa.png" alt="Santa Casa São José dos Campos">
  <h2 class="titulo">Portal Wi-Fi
    </h1>
    <div class="container">
      <div class="grid">
 <a href="paciente.php?id=<?php echo $_GET['id']; ?>&ap=<?php echo $_GET['ap']; ?>">Paciente</a>        
 <a href="funcionario.php?id=<?php echo $_GET['id']; ?>&ap=<?php echo $_GET['ap']; ?>">Funcionário</a>
<a href="medico.php?id=<?php echo $_GET['id']; ?>&ap=<?php echo $_GET['ap']; ?>">Médico</a>
<a href="visitante.php?id=<?php echo $_GET['id']; ?>&ap=<?php echo $_GET['ap']; ?>">Visitante</a>
       
       
        
      </div>
    </div>
</body>

</html>