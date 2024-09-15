<?php
require_once("conexao.php");

$conn = new Conexao();

$email = $_POST['txtEmailLogin'];
$senha = $_POST['txtSenhaLogin'];

$conn ->autentica($email,$senha);

echo"<script Language='javascript'> window.location.href='../html/homePage.php'</script>";
?>
