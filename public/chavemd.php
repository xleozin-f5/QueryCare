<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Desenvolvimento em Andamento</title>
  <!-- Adicionando o Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Adicionando o Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* Pq não em um arquivo css? */
    body {
      background-image: url('../assets/img/background.png');
      background-size: cover;
      background-position: center;
      height: 100vh;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 80%;
      margin: 20px; /* Adicionando margem */
    }

    h1 {
      color: #333;
      font-size: 28px;
      margin-bottom: 20px;
    }

    p {
      color: #666;
      font-size: 18px;
      margin-bottom: 30px;
    }

    .contact-info {
      font-size: 16px;
      color: #999;
    }

    .icon-container {
      margin-bottom: 20px;
    }

    .icon-container i {
      font-size: 64px;
      margin-right: 20px;
      color: #007bff;
      /* Cor azul para o ícone */
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .icon-container i.spin {
      animation: spin 2s linear infinite;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="icon-container text-center">
      <i class="fas fa-cog fa-5x spin"></i> <!-- Ícone do Font Awesome para uma engrenagem -->
    </div>
    <h1 class="text-center">EM DESENVOLVIMENTO...</h1>
    <p class="text-center">Esta função está em desenvolvimento, porém prometemos ser breves!</p>
    <p class="contact-info text-center">Para qualquer dúvida ou assistência, entre em contato conosco em <a href="mailto:suporte@querycare.pt">suporte@querycare.pt</a></p>
    <!-- Usando um link em vez de um botão dentro de um formulário -->
    <a href="./login.html" class="btn btn-primary btn-block">Voltar</a>
  </div>
  <!-- Adicionando o Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
