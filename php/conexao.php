<?php

class Conexao {

    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:dbname=TCC;host=localhost", "root", "");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erro de conexão: ' . $e->getMessage();
            exit();
        }
    }

    public function registro($nome, $email, $senha, $senha2) {

    if($senha !=$senha2)
		{
			echo "<script Language='javascript'> 
			window.location.href='../html/Register.html';
			alert('confirmação de senha incorreta')</script>";
		}
		else{

        $query = "SELECT idusuario FROM usuario WHERE emailInstitucional = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return false; 
        }

        $stmt = $this->conn->prepare("INSERT INTO usuario (nome, emailInstitucional, senha) VALUES (:nome, :email, :senha)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        return true;
    }
}

    public function autentica($email, $senha){
		$query = "SELECT * FROM usuario WHERE emailInstitucional = :email AND senha = :senha";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
		$stmt->bindParam(':senha', $senha);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return true;    
        }
		else{
        	echo "<script Language='javascript'> 
			window.location.href='../html/Login.html';
			alert('email ou senha incorrtos incorreta')</script>";
		}
	}

    public function recebequest($titulo, $conteudo, $email, $idcompTec, $idArquivo) {
        // Recupera o ID do usuário pelo email
        $usuarioQuery = "SELECT idUsuario FROM usuario WHERE emailInstitucional = :email";
        $stmt2 = $this->conn->prepare($usuarioQuery);
        $stmt2->bindParam(':email', $email);
        $stmt2->execute();
    
        // Verifica se o usuário foi encontrado
        if ($stmt2->rowCount() > 0) {
            $usuario = $stmt2->fetch(PDO::FETCH_ASSOC);
            $idUsuario = $usuario['idUsuario'];
    
            // Insere a pergunta no banco de dados, com ou sem imagem
            $query = "INSERT INTO pergunta(titulo, conteudo, idUsuario, IdcompTec, idArquivo, dataHora) 
                      VALUES(:titulo, :conteudo, :idUsuario, :idcompTec, :idArquivo, NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':conteudo', $conteudo);
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':idcompTec', $idcompTec);
    
            if ($idArquivo !== null) {
                $stmt->bindParam(':idArquivo', $idArquivo);
            } else {
                $stmt->bindValue(':idArquivo', null, PDO::PARAM_NULL);
            }
    
            $stmt->execute();
        } else {
            echo "Usuário não encontrado.";
        }
    }
    

    public function selectCurso() {
        $seleciona = $this->conn->prepare("SELECT * FROM Curso ORDER BY nome ASC");
        $seleciona->execute();
        return $seleciona->fetchAll(PDO::FETCH_ASSOC);
    }

    public function comptecExists($idcompTec) {
        $query = "SELECT COUNT(*) FROM compTec WHERE IdcompTec = :idcompTec";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idcompTec', $idcompTec);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }

    public function mostrarPergunta(){
        $stmt = $this->conn->query("SELECT 
            pergunta.titulo, 
            pergunta.conteudo, 
            pergunta.dataHora, 
            curso.nome AS nome_curso, 
            usuario.nome AS nome_usuario,
            arquivo.nomeArquivo AS imagem
        FROM pergunta
        INNER JOIN compTec ON pergunta.IdcompTec = compTec.IdcompTec
        INNER JOIN curso ON compTec.IdCurso = curso.IdCurso
        INNER JOIN usuario ON pergunta.IdUsuario = usuario.idUsuario
        LEFT JOIN arquivo ON pergunta.idArquivo = arquivo.idArquivo
        ORDER BY pergunta.dataHora DESC
        LIMIT 3;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCompTec($cursoId) {
        // Preparar a consulta
        $query = "SELECT IdcompTec, nome FROM compTec WHERE IdCurso = :cursoId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cursoId', $cursoId, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Verifica se há resultados e gera as opções
        if (count($result) > 0) {
            $options = '<option value="">Selecione a competência técnica</option>';
            foreach ($result as $row) {
                $options .= '<option value="' . htmlspecialchars($row['IdcompTec']) . '">' . htmlspecialchars($row['nome']) . '</option>';
            }
        } else {
            $options = '<option value="">Nenhuma competência técnica encontrada</option>';
        }
        
        // Retorna as opções para preencher o select
        return $options;
    }

    public function insereImg($arquivo) {
        $ext = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $nomeArq = md5(microtime()) . ".$ext";
        $local = "imagens/$nomeArq";
    
        // Move o arquivo para o diretório
        if (move_uploaded_file($arquivo['tmp_name'], $local)) {
            // Prepara a inserção do nome do arquivo no banco de dados
            $query = $this->conn->prepare("INSERT INTO arquivo(nomeArquivo) VALUES(:nomeArquivo)");
            $query->bindParam(":nomeArquivo", $nomeArq);
            $query->execute();
    
            // Retorna o ID do arquivo inserido
            return $this->conn->lastInsertId();
        }
    
        return false; // Caso o upload ou inserção falhe
    }
    
    public function mostrarPerguntaComp($idcompTec){
        $query = $this->conn->prepare("SELECT
            pergunta.titulo, 
            pergunta.conteudo, 
            pergunta.dataHora, 
            curso.nome AS nome_curso, 
            usuario.nome AS nome_usuario,
            arquivo.nomeArquivo AS imagem
        FROM pergunta
        INNER JOIN compTec ON pergunta.IdcompTec = compTec.IdcompTec
        INNER JOIN curso ON compTec.IdCurso = curso.IdCurso
        INNER JOIN usuario ON pergunta.IdUsuario = usuario.idUsuario
        LEFT JOIN arquivo ON pergunta.idArquivo = arquivo.idArquivo
        ORDER BY pergunta.dataHora DESC 
        WHERE compTec.IdCompTec = :idCompTec");
         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(':idCompTec', $idcompTec);
         $stmt->execute();
    }
    public function verificaCompTec(){
        
    }

}
?>