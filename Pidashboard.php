<?php
session_start();

// Sertakan file koneksi
require_once 'koneksi.php';

// Pemeriksaan session
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - BacterFly</title>
  <style>
    body {
      margin: 0;
      background-color: black;
      color: white;
      font-family: sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    header, footer {
      background-color: #111;
      color: #FFA347;
      padding: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    main {
      flex: 1; /* Allows main to take available space */
      padding: 16px;
    }
    .reminder-box {
      background-color: purple;
      padding: 12px;
      border-radius: 8px;
      color: white;
      margin-top: 20px;
    }
    nav {
      display: flex;
      justify-content: space-around;
      background-color: #111;
      border-top: 1px solid #FFA347;
      padding: 10px 0;
    }
    nav a {
      text-decoration: none;
      color: #FFA347;
      font-size: 1.4rem;
    }
    nav a.active {
      color: white;
    }
  </style>
</head>
<body>

<header>
  <div><b>Welcome To</b> <span style="color: #FFA347;">Bacter</span><span style="color: white;">Fly</span></div>
  <div>Tim Produksi</div>
  <a href="proses.php?logout=true">
  <button type="button" class="btn btn-outline-warning">Logout</button>
  </a>
</header>

<main>
  <div class="reminder-box">
    <b>📣 Reminder</b><br>
    Kamu sedang di Beranda
  </div>
</main>

<nav>
  <a href="Pidashboard.php" class="active">🏠</a>
  <a href="Pihome.php">🕒</a>
  <a href="Piinstruksi.php">📋</a>
  <a href="Piprofile.php">👤</a>
</nav>



</body>
</html>