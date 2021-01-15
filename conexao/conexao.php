<?php
require 'config.php';
//ABRE A CONEXÃO COM O BANCO DE DADOS
function DBConnect(){
    $conexao = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if(!$conexao){
        die('Erro na Conexao '. mysqli_error($conexao));
    }else{
    //   echo "<h1>Conexão OK</h1>";  
    }
    return $conexao;
}
//FECHA ACONEXÃO COM O BANCO DE DADOS
function DBClose($conexao){
    mysqli_close($conexao);
    if(!$conexao){
        die('Erro na Conexao '. mysqli_error($conexao));
    }
    //echo "<h1>Conexão Finalizada</h1>";
    return $conexao;
}


