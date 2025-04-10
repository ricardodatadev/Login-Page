<?php
include 'config.php'; // Conexão com o banco de dados

$senhaAtualizada = false; // Variável para controle se a senha foi atualizada
$erro = ''; // Variável para mensagens de erro
$sucesso = ''; // Variável para mensagens de sucesso
$mensagemSenha = ''; // Variável para mensagens de validação de senha

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar se o token existe e não expirou
    $sql = "SELECT * FROM usuarios WHERE reset_token = '$token' AND reset_token_expira > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // O token é válido, exibe o formulário de redefinição de senha
        $user = $result->fetch_assoc();
    } else {
        $erro = "Link de redefinição inválido ou expirado.";
        exit();
    }
} else {
    $erro = "Token não encontrado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['password'];

    // Validar a senha (mínimo 8 caracteres, deve conter letra e caractere especial)
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/", $newPassword)) {
        $mensagemSenha = "A senha deve ter pelo menos 8 caracteres, incluindo uma letra e um caractere especial (!@#$%^&*).";
    } else {
        // Senha válida, realizar atualização no banco de dados
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Criptografa a senha

        $sql = "UPDATE usuarios SET senha = '$hashedPassword', reset_token = NULL, reset_token_expira = NULL WHERE reset_token = '$token'";
        if ($conn->query($sql) === TRUE) {
            // Senha atualizada com sucesso
            $senhaAtualizada = true;
            $sucesso = "Senha atualizada com sucesso!";
            // Redireciona após 3 segundos
            header("Refresh: 3; url=index.php"); 
            exit();
        } else {
            $erro = "Erro ao atualizar a senha.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="my-login.css">
</head>
<body class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center align-items-center h-100">
                <div class="card-wrapper">
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">Cadastrar Nova Senha</h4>
                            
                            <!-- Exibir mensagem de sucesso ou erro -->
                            <?php if ($sucesso): ?>
                                <div class="alert alert-success">
                                    <?php echo $sucesso; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($erro): ?>
                                <div class="alert alert-danger">
                                    <?php echo $erro; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($mensagemSenha): ?>
                                <div class="alert alert-warning">
                                    <?php echo $mensagemSenha; ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" class="my-login-validation" novalidate="">
                                <div class="form-group">
                                    <label for="new-password">Insira uma nova senha</label>
                                    <input id="new-password" type="password" class="form-control" name="password" required autofocus data-eye 
                                        pattern="^(?=.*[A-Za-z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$" 
                                        title="A senha deve ter pelo menos 8 caracteres, incluindo uma letra e um caractere especial (!@#$%^&*).">
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                    <div class="form-text text-muted">
                                        Crie uma senha fácil de você lembrar
                                    </div>
                                </div>

                                <div class="form-group m-0">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Criar Nova Senha
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer">
                        Copyright &copy; 2025 &mdash; PCMA
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/my-login.js"></script>
</body>
</html>

