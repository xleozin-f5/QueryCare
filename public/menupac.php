<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital System</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/menumed.css"> <!-- Incluir o arquivo CSS personalizado -->
  <style>
    /* Personalize o botão do menu responsivo */
    .navbar-toggler {
      color: #fff;
      border-color: #fff;
    }
  </style>
</head>
<body class="bg-light"> <!-- Fundo azul claro -->

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">Hospital System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#"><i class="fas fa-home"></i> Início</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-user"></i> Perfil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-cog"></i> Configurações</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../src/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-3 sidebar bg-primary">
      <div class="profile-info text-center text-white">
        <div class="profile-img">
          <img src="../assets/img/profile.png" alt="Profile Picture" class="rounded-circle" width="100">
        </div>
        <div class="profile-text">
          <h5 id="user-name">Nome do Paciente</h5> <!-- Nome do paciente -->
          <p id="user-health-number">Health Number: XXXXXXXX</p> <!-- Health Number -->
        </div>
      </div>
      <ul class="pl-0">
        <li>
          <a href="#" class="text-white">
            <i class="fas fa-columns d-flex justify-content-center"></i>
            <span class="">Painel</span>
          </a>
        </li>
        <li >
          <a href="#" class="text-white d-flex justify-content-center">
            <i class="far fa-calendar-alt"></i>
            <span class="">Consultas</span>
          </a>
        </li>
        <li>
          <a href="#" class="text-white d-flex justify-content-center">
            <i class="fas fa-notes-medical"></i>
            <span class="">Relatórios Médicos</span>
          </a>
        </li>
        <li>
          <a href="#" class="text-white d-flex justify-content-center">
            <i class="fas fa-hospital-user"></i>
            <span class="">Hospital</span>
          </a>
        </li>
        <li>
          <a href="#" class="text-white d-flex justify-content-center">
            <i class="fas fa-cog"></i>
            <span class="">Configurações</span>
          </a>
        </li>
      </ul>
    </div>

    <div class="col-md-9 content">
      <h1>Bem-vindo ao Sistema Hospitalar</h1>
      <p>Esta é a área de conteúdo. Você pode colocar seu conteúdo principal aqui.</p>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
