<?php

$servidor = "localhost";
$usuario = "acess_wifi";
$senha = "Sant@Wifi!24";
$dbname = "Wifi";
// $servidor = "localhost";
// $usuario = "root";
// $senha = "";
// $dbname = "wifi";
//Criar a conexao MYSQL
$conn_my = mysqli_connect($servidor, $usuario, $senha, $dbname);

// Change character set to utf8
//mysqli_set_charset($conn_my,"utf8");
