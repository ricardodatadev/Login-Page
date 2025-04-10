<?php
session_start();
$usuarios_permitidos = ['violao', 'ricardopereira'];

if (!isset($_SESSION['name']) || !in_array($_SESSION['name'], $usuarios_permitidos)) {
    // Se o usuário não estiver logado ou não estiver na lista de usuários permitidos, redireciona para o login
    $_SESSION['error_message'] = "Você não tem permissão para acessar esta página.";
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema de Gestão</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistema de Gestão</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="test.html">Home</a>
            </li>
            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Equipamentos
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=marca-listar">Listar</a></li>
                <li><a class="dropdown-item" href="?page=marca-cadastrar">Cadastrar</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Colaboradores
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=colaborador-listar">Listar</a></li>
                <li><a class="dropdown-item" href="?page=colaborador-cadastrar">Cadastrar</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Fornecedores
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=fornecedor-listar">Listar</a></li>
                <li><a class="dropdown-item" href="?page=fornecedor-cadastrar">Cadastrar</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dashboards
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Controle de OS</a></li>
                <li><a class="dropdown-item" href="#">Acompanhamento Reforma</a>
                <li><a class="dropdown-item" href="#">Orçamento Automotivo</a></li>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Chat
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Listar</a></li>
                <li><a class="dropdown-item" href="#">Cadastrar</a>
                </li>
              </ul>
            </li>
            
            
          </ul>
          <?php session_start(); ?>
            <div class="d-flex align-items-center">
              <img src="login.png" alt="User" class="rounded-circle me-2 img-fluid" style="max-width: 40px;">
              <span class="fw-bold"><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Usuário'; ?></span>
              <a href="logout.php" class="ms-3 btn btn-outline-danger btn-sm">Sair</a>
            </div>
      </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col">
                <?php
                    //arquivo que faz a conexão com o banco
                    include('config.php');
                    
                    //includes das páginas
                    switch (@$_REQUEST['page']) {
                        //Equipamentos
                        case 'marca-listar':
                            include('marca-listar.php');
                            break;
                        case 'marca-cadastrar':
                            include('marca-cadastrar.php');
                            break;
                        case 'marca-editar':
                            include('marca-editar.php');
                            break;
                        case 'marca-salvar':
                            include('marca-salvar.php');
                            break;
                            
                        //Colaboradores
                        case 'colaborador-listar':
                            include('colaborador-listar.php');
                            break;
                        case 'colaborador-cadastrar':
                            include('colaborador-cadastrar.php');
                            break;
                        case 'marca-editar':
                            include('colaborador-editar.php');
                            break;
                        case 'marca-salvar':
                            include('colaborador-salvar.php');
                            break;
                            
                        //Fornecedores
                        case 'fornecedor-listar':
                            include('fornecedor-listar.php');
                            break;
                        case 'fornecedor-cadastrar':
                            include('fornecedor-cadastrar.php');
                            break;
                        case 'fornecedor-editar':
                            include('fornecedor-editar.php');
                            break;
                        case 'fornecedor-salvar':
                            include('fornecedor-salvar.php');
                            break;
                            
                        //Dashs
                        case 'modelos-listar':
                            include('modelos-listar.php');
                            break;
                        case 'marca-cadastrar':
                            include('marca-cadastrar.php');
                            break;
                        case 'marca-editar':
                            include('marca-editar.php');
                            break;
                        case 'marca-salvar':
                            include('marca-salvar.php');
                            break;
                        
                        
                        default:
                            print "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>
                                        <h1>Olá, seja bem-vindo!</h1>
                                   </div>";
                            break;
                            
                        
                    }
                
                ?>
            </div>
        </div>
    </div>
	<script type="text/javascript" src="/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
