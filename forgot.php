<?php
include 'config.php'; 

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer; 

// Variáveis para mensagem
$message = ''; // Mensagem de erro ou sucesso
$message_class = ''; // Classe para o estilo da mensagem

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = $_POST['email']; // Pode ser e-mail ou nome de usuário

    // Verifica se o input parece com um e-mail
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM usuarios WHERE email = '$input'";
    } else {
        // Caso contrário, é tratado como nome de usuário
        $sql = "SELECT * FROM usuarios WHERE usuario = '$input'";
    }

    // Executa a consulta
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Gerar um token único
        $token = bin2hex(random_bytes(50)); // Gera um token aleatório de 100 caracteres
        $expira = date("Y-m-d H:i:s", strtotime('+1 hour')); // O token expira em 1 hora

        // Atualiza o banco de dados com o token e data de expiração
        $sql = "UPDATE usuarios SET reset_token = '$token', reset_token_expira = '$expira' WHERE email = '{$user['email']}'";
        if ($conn->query($sql) === TRUE) {
            // Enviar o e-mail com o link de redefinição
            $link = "http://rdatadev.site/automotiva/reset.php?token=$token";

            // Usando PHPMailer para enviar o e-mail
            $mail = new PHPMailer();
            $mail->setFrom('contato@rdatadev.site', 'Equipe PCMA');
            $mail->addAddress($user['email']);
            $mail->Subject = 'Redefinir sua senha';
            $mail->Body = "Olá,\n\n"
                    . "Recebemos uma solicitação para redefinir a sua senha. Se foi você quem fez a solicitação, "
                    . "basta clicar no link abaixo para criar uma nova senha para sua conta:\n\n"
                    . $link 
                    . " \n\n Este link é válido por 1 hora. Se você não solicitou a redefinição, ignore este e-mail.\n\n"
                    . "Atenciosamente,\n"
                    . "Ricardo Pereira";

            if ($mail->send()) {
                $message = 'Enviamos um e-mail para você! Agora é só verificar sua caixa de entrada para redefinir sua senha.';
                $message_class = 'alert-success'; // Classe para mensagem de sucesso
            } else {
                $message = 'Erro ao enviar o e-mail. Por favor, tente novamente.';
                $message_class = 'alert-danger'; // Classe para mensagem de erro
            }
        } else {
            $message = 'Erro ao atualizar o banco de dados.';
            $message_class = 'alert-danger'; // Classe para mensagem de erro
        }
    } else {
        $message = 'Este e-mail ou nome de usuário não está registrado. Por favor, tente novamente.';
        $message_class = 'alert-danger'; // Classe para mensagem de erro
    }

    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Minha Página de Login &mdash; Redefinir Senha</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="my-login.css">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center align-items-center h-100">
				<div class="card-wrapper">
					
					<div class="card fat">
						<div class="text-center mt-3">
						    
							<h4 class="card-title">Problemas para acessar sua conta?</h4>

                            <!-- Exibe a mensagem de erro/sucesso -->
                            <?php if ($message): ?>
                                <div class="alert <?php echo $message_class; ?>">
                                    <?php echo $message; ?>
                                </div>
                            <?php endif; ?>
							
							<form action=" " method="POST" class="my-login-validation" novalidate="">

								<!-- Input para e-mail ou nome de usuário -->
								<div class="form-group">
									<label for="email">Insira seu email ou nome de usuário e enviaremos um link para você voltar a acessar sua conta</label>
									<input id="email" type="text" class="form-control" name="email" value="" required autofocus> <!-- Mudança aqui para permitir texto -->

									<div class="invalid-feedback">
										Email ou nome de usuário inválido
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Enviar Link
									</button>
								</div>
							</form>
							
							<!-- Links para criar uma nova conta e voltar ao login -->
							<div class="text-center mt-3">
								<p><a href="register.php" class="btn btn-link">Criar uma nova conta</a></p>
								<p><a href="index.php" class="btn btn-link">Voltar ao Login</a></p>
							</div>

						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2025 &mdash; Ricardo Pereira
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="js/my-login.js"></script>
</body>
</html> 
