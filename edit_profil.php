<?php
require 'koneksi.php'; // koneksi ke database menggunakan PDO

// Pengecekan koneksi
if (!$pdo) {
    die("Koneksi gagal: Periksa pesan sebelumnya di log atau konfigurasi.");
}

// Inisialisasi variabel
$nama = '';
$divisi = '';
$message = '';

// Ambil ID pengguna (misalnya, dari sesi atau parameter; di sini kita gunakan ID statis untuk contoh)
$id_user = 1; // Ganti dengan ID pengguna dari sesi atau autentikasi

// Ambil data pengguna saat ini
$query = "SELECT nama, division FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);

try {
    $stmt->execute(['id' => $id_user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $nama = $row['nama'] ?? 'Tidak Ditemukan';
        $divisi = $row['division'] ?? '-';
    } else {
        $nama = 'Tidak Ditemukan';
        $divisi = '-';
    }
} catch (PDOException $e) {
    $message = "Error: " . $e->getMessage();
}

// Proses pembaruan data jika formulir disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_nama = $_POST['nama'] ?? '';
    $new_divisi = $_POST['division'] ?? '';

    // Validasi input
    if (empty($new_nama)) {
        $message = "Nama tidak boleh kosong.";
    } else {
        // Update data di database
        $update_query = "UPDATE users SET nama = :nama, division = :division WHERE id = :id";
        $update_stmt = $pdo->prepare($update_query);

        try {
            $update_stmt->execute([
                'nama' => $new_nama,
                'division' => $new_divisi,
                'id' => $id_user
            ]);
            $message = "Profil berhasil diperbarui!";
            // Perbarui variabel untuk menampilkan data baru
            $nama = $new_nama;
            $divisi = $new_divisi;
        } catch (PDOException $e) {
            $message = "Error saat memperbarui profil: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - BacterFly</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            width: 80%;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .avatar img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #666;
        }

        .form-container {
            margin-top: 20px;
        }

        .form-container label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-size: 18px;
        }

        .form-container input {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            font-family: 'Courier New', monospace;
            background-color: #222;
            color: white;
            border: 1px solid #555;
            border-radius: 5px;
        }

        .form-container input:focus {
            outline: none;
            border-color: #FF8C42;
        }

        .form-container button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #FF8C42;
            color: #000;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .form-container button:hover {
            background-color: #FFA500;
        }

        .message {
            margin: 10px 0;
            font-size: 16px;
            color: #FF8C42;
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
            .profile-container {
                width: 90%;
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
            <a href="profil_manajer.php" class="back">< Back</a>
            <span class="title">Edit Profil</span>
            <span></span> <!-- Placeholder untuk menjaga tata letak -->
        </div>
    </header>

    <main class="profile-container">
        <div class="avatar">
            <img src="images/profile-icon.png" alt="Profile Picture">
        </div>
        <h2 class="username"><?= htmlspecialchars($nama) ?></h2>

        <div class="form-container">
            <?php if (!empty($message)): ?>
                <p class="message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
            <form method="POST" action="edit_profil.php">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($nama) ?>" required>
            </form>
        </div>
    </main>

    <div class="bottom-nav">
        <a href="manajer.php">
            <img src="images/home.png" alt="Home">
            <span>Home</span>
        </a>
        <a href="pengawasan.php">
            <img src="images/clock.png" alt="Clock">
            <span>Pengawasan</span>
        </a>
        <a href="#">
            <img src="images/list.png" alt="List">
            <span>List</span>
        </a>
        <a href="profil_manajer.php" class="active">
            <img src="images/profile.png" alt="Profile">
            <span>Profile</span>
        </a>
    </div>
</body>
</html>