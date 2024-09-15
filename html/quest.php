<?php
require_once("../php/conexao.php");

// Inicia a sessão
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['email'])) {
    session_destroy();
    echo "<script>window.location.href='../html/Login.html'</script>";
    exit;
}

// Obtém o nome do usuário da sessão
$nomeUsuario = isset($_SESSION['nome']) ? htmlspecialchars($_SESSION['nome']) : 'Usuário';

// Cria um novo objeto de conexão e obtém a lista de cursos
$cursoObj = new Conexao();
$cursos = $cursoObj->selectCurso(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Adicione jQuery -->
    <script>
           $(document).ready(function() {
            $('#curso').on('change', function() {
                var cursoId = $(this).val();
                if (cursoId) {
                    $.ajax({
                        url: '../php/getCompTec.php',
                        type: 'POST',
                        data: { cursoId: cursoId },
                        success: function(response) {
                            $('#compTec').html(response);
                        }
                    });
                } else {
                    $('#compTec').html('<option value="">Selecione o curso primeiro</option>');
                }
            });
        });
        </script>
</head>
<body>
    olá, <?php echo $nomeUsuario; ?>
    <form action="../php/recebequest.php" method="post" enctype="multipart/form-data">
        <label>Insira o título da sua pergunta:</label>
        <input type="text" name="txtTitulo" required><br/><br/>

        <label>Insira sua pergunta:</label>
        <input type="text" name="txtPergunta" required><br/><br/>

        <label>Selecione o curso:</label>
        <select name="curso" id="curso" required>
            <option value="">Selecione um curso</option>
            <?php
            foreach ($cursos as $curso) {
                echo "<option value=\"" . htmlspecialchars($curso['IdCurso']) . "\">" . htmlspecialchars($curso['nome']) . "</option>";
            }
            ?>
        </select><br/><br/>

        <label>Selecione o componente:</label>
        <select name="compTec" id="compTec" required>
            <option value="">Selecione um componente</option>
        </select><br/><br/>
        
        <label>adicione uma imagem</label>
        <input type="file" name="imgQuest">
        <br/><br/>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>
