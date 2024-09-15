<?php

if(!isset($_SESSION)) session_start();

if(!isset($_SESSION['email'])) {
    session_destroy();
    echo "<script Language='javascript'> window.location.href='../html/Login.html'</script>";
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela principal</title>
</head>
<body>
    <h1>Teste Tela Inicial</h1>
    <a href="perfil.php">
        <?php echo $_SESSION['nome']; ?>
    </a>
    <a href="perfil.php"><img></a> 
    <a href="quest.php"><button>Adicionar Pergunta</button></a>
    <br/><br/>

    <a href="administracao.html">Administração</a><br/>
    <a href="logistica.html">Logística</a><br/>
    <a href="informatica.html">Informática</a><br/>
    <a href="marketing.html">Marketing</a><br/>
    <a href="logisticaReversa.html">Logística Reversa</a><br/>

            
      <br/><br/>

    <br/>
    <br/>
    <br/>

    <h2>Perguntas Abaixo</h2>

    <?php 
    require_once("../php/conexao.php");

    $conn = new Conexao();
    $consulta = $conn->mostrarPergunta();

    if (count($consulta) > 0) {
        for ($i = 0; $i < count($consulta); $i++) {
            echo "<br/>";
            echo "<strong>Título:</strong> " . htmlspecialchars($consulta[$i]['titulo']) . "<br/>";
            echo "<strong>Conteúdo:</strong> " . htmlspecialchars($consulta[$i]['conteudo']) . "<br/>";
            echo "<strong>Usuário:</strong> " . htmlspecialchars($consulta[$i]['nome_usuario']) . "<br/>";
            echo "<strong>Curso:</strong> " . htmlspecialchars($consulta[$i]['nome_curso']) . "<br/>";
            echo "<strong>Data:</strong> " . htmlspecialchars($consulta[$i]['dataHora']) . "<br/>";

            // Exibir a imagem, se houver
            if (!empty($consulta[$i]['imagem'])) {
                echo "<strong>Imagem:</strong><br/>";
                echo "<img src='../php/imagens/" . htmlspecialchars($consulta[$i]['imagem']) . "' alt='Imagem da Pergunta' style='max-width:200px; max-height:200px;'><br/>";
            }

            echo "<hr/>";
        }
    } else {
        echo "Nenhuma pergunta encontrada.";
    }
    ?>
</body>
</html>
