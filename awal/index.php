<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BacterFly</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #000;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      color: #FFA347;
      flex-direction: column;
    }

    .logo {
      width: 100px;
      height: 150px;
      background: url('assets/logo.png') no-repeat center;
      background-size: contain;
      margin-bottom: 20px;
    }

    .text {
      font-size: 1.2rem;
    }

    .highlight {
      font-weight: bold;
      color: #FFA347;
    }

    .loading {
      margin-top: 20px;
      width: 30px;
      height: 30px;
      border: 3px solid #FFA347;
      border-top: 3px solid transparent;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <div class="logo" style="background-image: url('assets/logo.png');"></div>
  <div class="text">Hi, Welcome To <span class="highlight">BacterFly</span></div>
  <div class="loading"></div>

  <!-- Opsional: Arahkan ke halaman utama setelah beberapa detik -->
  <script>
    setTimeout(() => {
      window.location.href = "home.php"; // ganti dengan halaman utama Anda
    }, 3000);
  </script>
</body>
</html>
