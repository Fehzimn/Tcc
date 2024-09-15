<?php

if(!isset($_SESSION)) session_start();

if(!isset($_SESSION['email']))
{
session_destroy();

echo"<script Language='javascript'> window.location.href='../html/Login.html'</script>";
}

require_once("../php/conexao.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>perfil</title>
</head>
<body>
    <form>
    <label for="">Imagem</label>
    <input type="file" name="imagem" accept="image/*">

    <button type="submit" class="btn btn-success">Enviuar</button>
    </form>
</body>
</html>