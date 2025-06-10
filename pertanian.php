<?php
session_start();
require 'koneksi.php'; // koneksi ke database

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}



$query = "SELECT * FROM DataInokulasi WHERE kategori = 'Pertanian'";
$stmt = $pdo->prepare($query); // Siapkan query
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Peternakan - BacterFly</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background: #000;
      color: #FFA347;
      font-family: 'Segoe UI';
      margin: 0;
      padding: 1rem;
    }
    h1 {
      text-align: center;
      padding: 1rem 0;
    }
    a {
      color: #FFA347;
      margin-bottom: 1rem;
      display: inline-block;
    }
    .card {
      background: #111;
      border-left: 10px solid #FFA347;
      border-radius: 10px;
      padding: 1rem;
      margin-bottom: 1rem;
      color: white;
    }
    .card h3 {
      margin: 0 0 0.5rem;
      color: #FFA347;
    }
    .fab {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #FFA347;
      color: black;
      font-size: 30px;
      width: 50px;
      height: 50px;
      text-align: center;
      border-radius: 50%;
      text-decoration: none;
      line-height: 50px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
  </style>
</head>
<body>
  <a href="Pihome.php">← Kembali</a>
  <h1>Data Inokulasi - Pertanian</h1>

  <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <div class="card">
      <h3><?= htmlspecialchars($row['nama_bakteri']) ?></h3>
      <p><strong>Media</strong> : <?= htmlspecialchars($row['media']) ?></p>
      <p><strong>Metode Inokulasi</strong> : <?= htmlspecialchars($row['metode_inokulasi']) ?></p>
      <p><strong>Tanggal Inokulasi</strong> : <?= htmlspecialchars($row['tanggal_inokulasi']) ?></p>
      <p><strong>Status Kualitas</strong> : <?= htmlspecialchars($row['status_kualitas']) ?></p>
      <p><strong>Jumlah Bakteri</strong> : <?= htmlspecialchars($row['jumlah_bakteri']) ?></p>
      <p><strong>Tanggal Keluar</strong> : <?= $row['tanggal_keluar'] ?: 'belum' ?></p>
      <p><strong>Inokulasi berhasil</strong> : <?= htmlspecialchars($row['inokulasi_berhasil']) ?></p>
    </div>
  <?php endwhile; ?>
<div style="text-align: center; margin: 10px;">
    <button onclick="location.href='tambahbakteri.php?kategori=Pertanian'" style="background:#FFA347; color:black; padding:10px 20px; border:none; border-radius:5px;">
    ➕
    </button>
    </div>
</body>
</html>
