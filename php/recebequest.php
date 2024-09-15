<?php
require_once("conexao.php");

// Inicia a sessão
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['txtTitulo'];
    $conteudo = $_POST['txtPergunta'];
    $idComponente = $_POST['compTec']; // Certifique-se de que este campo existe no seu formulário
    $email = $_SESSION['email'];

    // Cria uma nova instância de conexão
    $conexao = new Conexao();

    // Verifica se há um arquivo de imagem enviado
    if (isset($_FILES['imgQuest']) && $_FILES['imgQuest']['error'] === UPLOAD_ERR_OK) {
        $idArquivo = $conexao->insereImg($_FILES['imgQuest']); // Insere o arquivo e obtém o ID
    } else {
        $idArquivo = null; // Caso não haja imagem, define como nulo
    }

    try {
        // Chama a função para inserir a pergunta no banco de dados
        $conexao->recebequest($titulo, $conteudo, $email, $idComponente, $idArquivo);
        echo "Pergunta enviada com sucesso!";
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>
