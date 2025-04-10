<?php
include("config.php");

switch ($_POST['acao']) {
    case 'cadastrar':
        // Captura os valores do formulário
        $frota = $_POST['frota'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $placa = $_POST['placa'];
        $data_aquisicao = $_POST['data_aquisicao'];

        // Verifica se algum campo obrigatório está vazio
        if (empty($frota) || empty($marca) || empty($modelo) || empty($placa) || empty($data_aquisicao)) {
            die("Erro: Todos os campos devem ser preenchidos!");
        }

        // Query correta com todas as colunas necessárias
        $sql = "INSERT INTO equipamentos (Frota, Marca, Modelo, Placa, Data_Aquisicao) 
                VALUES ('$frota', '$marca', '$modelo', '$placa', '$data_aquisicao')";

        // Executa a query
        $res = $conn->query($sql);

        // Verifica se a inserção foi bem-sucedida
        if ($res) {
            echo "<script>alert('Cadastrou com sucesso!');</script>";
        } else {
            die("Erro no SQL: " . $conn->error);
        }

        // Redireciona para a página
        echo "<script>location.href='?page=marca-listar';</script>";
        break;
}
?>
