<?php
require_once("conexao.php");
session_start();
    
$conn = new Conexao();

    $nome = $_POST['txtNome'];
    $_SESSION["nome"]=$nome;
    $email = $_POST['txtEmail'];
    $_SESSION["email"]=$email;
    $senha = $_POST['txtSenha'];
    $senha2 = $_POST['txtSenha2'];

    $conn ->registro($nome, $email, $senha,$senha2);
    
    echo"<script Language='javascript'> 
    window.location.href='../html/Login.html'</script>";

?>