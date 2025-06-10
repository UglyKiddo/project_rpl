<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BacterFly - Dashboard Lab</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      margin: 0;
      background-color: #000;
      color: #FFA347;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .top-bar {
      padding: 10px;
      background-color: #000;
      border-bottom: 1px solid #333;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .logo {
      display: flex;
      align-items: center;
      justify-content: center;
      color: #FF8C42;
      font-size: 14px;
    }

    .logo img {
      height: 30px;
      margin-right: 10px;
    }

    main {
      flex: 1;
      padding: 20px 16px;
    }

    .grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      justify-items: center;
    }

    .card {
      background-color: #222;
      color: white;
      padding: 20px;
      border-radius: 12px;
      width: 100%;
      max-width: 140px;
      text-align: center;
      border: 2px solid transparent;
      transition: border 0.3s ease;
      cursor: pointer;
    }

    .card:hover {
      border-color: #FFA347;
    }

    .card img {
      width: 48px;
      height: 48px;
      margin-bottom: 10px;
    }

    .card span {
      display: block;
      font-size: 0.9rem;
    }

    .bottom-nav {
      display: flex;
      justify-content: space-around;
      background: #000;
      padding: 10px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
      box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.5);
      border-top: 1px solid #555;
    }

    .bottom-nav a {
      color: #fff;
      text-decoration: none;
      display: flex;
      flex-direction: column;
      align-items: center;
      font-size: 12px;
      transition: transform 0.2s, opacity 0.2s;
    }

    .bottom-nav img {
      width: 24px;
      height: 24px;
      margin-bottom: 2px;
      opacity: 0.7;
    }

    .bottom-nav a:hover img,
    .bottom-nav a.active img {
      opacity: 1;
      transform: scale(1.2);
    }

    .bottom-nav a.active {
      color: #FF8C42;
    }

    .bottom-nav a:hover {
      color: #FF8C42;
    }

    @media (max-width: 600px) {
      .card img {
        width: 40px;
        height: 40px;
      }
      .card span {
        font-size: 0.8rem;
      }
      .bottom-nav img {
        width: 20px;
        height: 20px;
      }
      .bottom-nav a {
        font-size: 10px;
      }
    }
  </style>
</head>
<body>
  <header class="top-bar">
    <div class="logo"> 
      <img src="logo.png" alt="BacterFly Logo">
      <span>Welcome To <strong>BacterFly</strong></span>
    </div>
  </header>

  <main>
    <div class="grid">
      <div class="card" onclick="location.href='inokulasi_peternakan.php'">
        <img src="assets/cow-icon.png" alt="Peternakan" />
        <span>Peternakan</span>
      </div>
      <div class="card" onclick="location.href='inokulasi_perikanan.php'">
        <img src="assets/fish-icon.png" alt="Perikanan" />
        <span>Perikanan</span>
      </div>
      <div class="card" onclick="location.href='inokulasi_pertanian.php'">
        <img src="assets/plant-icon.png" alt="Pertanian" />
        <span>Pertanian</span>
      </div>
    </div>
  </main>

  <div class="bottom-nav">
    <a href="manajer.php">
      <img src="images/home.png" alt="Home">
      <span>Home</span>
    </a>
    <a href="pengawasan.php" class="active">
      <img src="images/timer.png" alt="Pengawasan">
      <span>Pengawasan</span>
    </a>
    <a href="list_manajer.php">
      <img src="images/list.png" alt="List">
      <span>List</span>
    </a>
    <a href="profile_manajer.php">
      <img src="images/profile.png" alt="Profile">
      <span>Profile</span>
    </a>
  </div>
</body>
</html>