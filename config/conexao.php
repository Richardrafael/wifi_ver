<?php

//////////
//ORACLE//
//////////

//TREINAMENTO

$dbstr1 = "(DESCRIPTION =
(ADDRESS = (PROTOCOL = TCP)(HOST = 10.200.0.211)(PORT = 1521))
(ADDRESS = (PROTOCOL = TCP)(HOST = 10.200.0.212)(PORT = 1521))
(LOAD_BALANCE = yes)
(FAILOVER=ON)
(CONNECT_DATA =
  (SERVER = DEDICATED)
  (SERVICE_NAME = prdmv)
  (FAILOVER_MODE =
  (TYPE = SELECT)
  (METHOD = BASIC)
  (RETRIES = 10)
  (DELAY = 1)
  )
)
)";

//Criar a conexao ORACLE
//if(!@($conn_ora = oci_connect('dbamv','treinamento123',$dbstr1,'AL32UTF8'))){
//	echo "Conexão falhou!";	
//} else { 
//echo "Conexão OK!";	
//}

//PRODUCAO

//$dbstr1 ="(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST =10.200.0.211)(PORT = 1521))
//(CONNECT_DATA = (SERVICE_NAME = prdmv)))";

//Criar a conexao ORACLE
if (!@($conn_ora = oci_connect('CONTROLER_WIFI', 'Wifi_Controler#2024new', $dbstr1, 'AL32UTF8'))) {
	echo "Conexão falhou!";
} else {
	//TEMPO MAXIMO DE CONSULTA 20 MINUTOS
	set_time_limit(1200);
}
