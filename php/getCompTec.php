<?php
require_once('conexao.php');

// Verificar se o cursoId foi enviado via POST
if (isset($_POST['cursoId'])) {
    $cursoId = $_POST['cursoId'];
    
    // Criar uma nova instância de Conexao
    $conexao = new Conexao();
    
    // Chamar a função getCompTec
    echo $conexao->getCompTec($cursoId);
}
?>
