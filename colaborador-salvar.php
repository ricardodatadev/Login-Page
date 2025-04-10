<?php
include("config.php");

switch ($_POST['acao']) {
    case 'cadastrar':
        // Captura os valores do formulário
        $nome = $_POST['nome'];
        $cargo = $_POST['cargo'];
        $setor = $_POST['setor'];
        $registro = $_POST['registro'];
        $data_admissao = $_POST['data_admissao'];

        // Verifica se algum campo obrigatório está vazio
        if (empty($nome) || empty($cargo) || empty($setor) || empty($registro) || empty($data_admissao)) {
            die("Erro: Todos os campos devem ser preenchidos!");
        }

        // Query correta com todas as colunas necessárias
        $sql = "INSERT INTO colaboradores (nome, cargo, setor, numero_registro, data_admissao) 
                VALUES ('$nome', '$cargo', '$setor', '$registro', '$data_admissao')";

        // Executa a query
        $res = $conn->query($sql);

        // Verifica se a inserção foi bem-sucedida
        if ($res) {
            echo "<script>alert('Cadastrou com sucesso!');</script>";
        } else {
            die("Erro no SQL: " . $conn->error);
        }

        // Redireciona para a página
        echo "<script>location.href='?page=colaborador-listar';</script>";
        break;
}
?>