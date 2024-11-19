<?php

include 'conexao.php';

$consulta = "SELECT *
FROM dbamv.atendime  
WHERE CD_ATENDIMENTO = :cd_atendimento 
AND (
(tp_atendimento = 'I' AND dt_alta IS NULL)
OR (tp_atendimento = 'U' AND dt_alta = SYSDATE - 1)
OR (tp_atendimento = 'A' AND dt_alta = SYSDATE)
OR  (tp_atendimento = 'E' AND dt_alta = SYSDATE )
)";

// Prepara a declaração
$stmt = oci_parse($conn_ora, $consulta);

// Associa os valores aos parâmetros na consulta
$cd_atendimento = '5164609';


$stmt = oci_parse($conn_ora, $consulta);

oci_bind_by_name($stmt, ':cd_atendimento', $cd_atendimento);
// oci_bind_by_name($stmt, ':nr_cpf', $cpf_formatado);
// oci_bind_by_name($stmt, ':dt_nascimento', $data_nascimento);
// oci_bind_by_name($stmt, ':cd_senha_triagem', $senha_toten);



// Executa a consulta
if (oci_execute($stmt)) {
    // Verifica se há algum resultado retornado
    if ($row = oci_fetch_assoc($stmt)) {
        // Se houver resultados, significa que o funcionário foi encontrado
        echo "Funcionário encontrado";
        // Você pode acessar os dados do funcionário através do array $row
    } else {
        // Se nenhum resultado foi retornado, significa que o funcionário não foi encontrado
        echo "Funcionário não encontrado";
    }
} else {
    // Se a execução da consulta falhou
    echo "Erro ao executar a consulta: " . oci_error($stmt)['message'];
}


?>