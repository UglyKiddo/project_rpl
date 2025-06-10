<?php
require 'koneksi.php'; // koneksi ke database menggunakan PDO

// Pengecekan koneksi
if (!$pdo) {
    die("Koneksi gagal: Periksa pesan sebelumnya di log atau konfigurasi.");
}

// Ambil data pengguna manajer (opsional, berdasarkan id_user)
$id_user = 1; // Ganti dengan id pengguna yang sedang login
$query_user = "SELECT nama, division FROM users WHERE id = :id";
$stmt_user = $pdo->prepare($query_user);
$stmt_user->execute(['id' => $id_user]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);
$nama = $user ? $user['nama'] : 'Manajer';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Laporan - BacterFly</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #000;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            justify-content: space-between;
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
            font-family: 'Courier New', monospace;
        }
        .logo img {
            height: 30px;
            margin-right: 10px;
        }
        .division-buttons {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            gap: 20px;
            padding: 20px;
        }
        .division-button {
            background-color: #FF8C42;
            color: #fff;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 18px;
            display: flex;
            align-items: center;
            width: 200px;
            justify-content: center;
            gap: 10px;
        }
        .division-button img {
            height: 24px;
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
            .division-button {
                width: 150px;
                font-size: 16px;
            }
            .division-button img {
                height: 20px;
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

    <div class="division-buttons">
        <a href="pilih_div.php?division=Produksi" class="division-button">
            <img src="images/box.png" alt="Produksi Icon"> Produksi
        </a>
        <a href="pilih_div.php?division=Laboratorium" class="division-button">
            <img src="images/microscope.png" alt="Inokulasi Icon"> Inokulasi
        </a>
    </div>

    <div class="bottom-nav">
        <a href="manajer.php">
            <img src="images/home.png" alt="Home">
            <span>Home</span>
        </a>
        <a href="pengawasan.php" class="active">
            <img src="images/timer.png" alt="Timer">
            <span>Pengawasan</span>
        </a>
        <a href="list_manajer.php">
            <img src="images/list.png" alt="List">
            <span>List</span>
        </a>
        <a href="profil_manajer.php">
            <img src="images/profile.png" alt="Profile">
            <span>Profile</span>
        </a>
    </div>
</body>
</html>