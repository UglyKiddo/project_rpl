<?php
session_start();
require 'koneksi.php'; // koneksi ke database menggunakan $pdo

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data with prepared statement
$id_user = $_SESSION['id'];
$query = "SELECT nama, division FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);

try {
    $stmt->execute([$id_user]); // Use positional parameter
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $nama = $row['nama'] ?? 'Tidak Ditemukan';
        $divisi = $row['division'] ?? '-';
        $role = '-'; // Role not in table, set manually
    } else {
        $nama = 'Tidak Ditemukan';
        $divisi = '-';
        $role = '-';
    }
} catch (PDOException $e) {
    $nama = 'Error';
    $divisi = '-';
    $role = 'Error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Laboratorium</title>
    <style>
        body {
            margin: 0;
            font-family: 'Courier New', monospace;
            background-color: #000;
            color: white;
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

        .nav-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            width: 80%;
            max-width: 300px;
        }

        .nav-bar a,
        .nav-bar span {
            color: white;
            font-size: 16px;
            text-decoration: none;
        }

        .nav-bar .title {
            font-weight: bold;
        }

        .profile-container {
            text-align: center;
            margin-top: 40px;
        }

        .avatar img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #666;
        }

        .username {
            font-family: Georgia, serif;
            margin-top: 10px;
            font-size: 24px;
        }

        .user-info {
            text-align: left;
            width: 80%;
            margin: 20px auto;
            font-size: 18px;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: linear-gradient(90deg, #222, #444);
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
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
            .bottom-nav img {
                width: 20px;
                height: 20px;
            }
            .bottom-nav a {
                font-size: 10px;
            }
            .nav-bar {
                width: 90%;
                max-width: 250px;
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
        <div class="nav-bar">
            <a href="javascript:history.back()" class="back">< Back</a>
            <span class="title">Profile</span>
            <a href="Piedit_profil.php" class="edit">Edit</a>
        </div>
    </header>

    <main class="profile-container">
        <div class="avatar">
            <img src="images/profile-icon.png" alt="Profile Picture">
        </div>
        <h2 class="username"><?= htmlspecialchars($nama) ?></h2>

        <div class="user-info">
            <p>Divisi: <?= htmlspecialchars($divisi !== '' ? $divisi : '-') ?></p>
            <p>Role: <?= htmlspecialchars($role) ?></p>
        </div>
    </main>
    <div class="bottom-nav">
        <a href="Pidashboard.php">
            <img src="images/home.png" alt="Home">
            <span>Home</span>
        </a>
        <a href="Pihome.php">
            <img src="images/clock.png" alt="Clock">
            <span>Pengawasan</span>
        </a>
        <a href="Piinstruksi.php">
            <img src="images/list.png" alt="List">
            <span>List</span>
        </a>
        <a href="Piprofile.php" class="active">
            <img src="images/profile.png" alt="Profile">
            <span>Profile</span>
        </a>
    </div>

</body>
</html>