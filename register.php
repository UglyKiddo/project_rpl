<?php
session_start();

// Sertakan file koneksi
require_once 'koneksi.php';

// Sertakan PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Aktifkan debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Tangani tombol "Send Code"
$pesan = '';
if (isset($_POST['send_code'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Periksa apakah email sudah terdaftar
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $pesan = "Email sudah terdaftar!";
    } else {
        // Buat kode 6 digit
        $kode = str_pad(rand(0, 999999), 6, "0", STR_PAD_LEFT);

        // Simpan email dan kode di session untuk digunakan saat pendaftaran
        $_SESSION['email'] = $email;
        $_SESSION['verification_code'] = $kode;

        // Kirim email dengan kode menggunakan PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bacterfly@gmail.com';
            $mail->Password = 'igob zvnb pska qqbq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('bacterfly@gmail.com', 'BacterFly');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Kode Verifikasi Anda';
            $mail->Body = "Kode verifikasi Anda adalah: <b>$kode</b>";
            $mail->AltBody = "Kode verifikasi Anda adalah: $kode";

            $mail->send();
            $pesan = "Kode verifikasi telah dikirim ke email Anda!";
        } catch (Exception $e) {
            $pesan = "Gagal mengirim kode verifikasi. Kesalahan: {$mail->ErrorInfo}";
        }
    }

    // Simpan pesan ke session untuk ditampilkan di index.php
    $_SESSION['pesan'] = $pesan;
    header("Location: index.php");
    exit();
}

// Tangani tombol "Sign Up"
if (isset($_POST['signup'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $kode = $_POST['code'];
    $division = $_POST['division']; // Ambil divisi dari formulir

    // Validasi input
    if ($password !== $confirm_password) {
        $pesan = "Kata sandi tidak cocok!";
    } elseif (!isset($_SESSION['verification_code']) || $kode !== $_SESSION['verification_code']) {
        $pesan = "Kode verifikasi salah!";
    } elseif (empty($division)) {
        $pesan = "Pilih divisi terlebih dahulu!";
    } else {
        // Hash kata sandi
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Masukkan pengguna ke database
        $stmt = $pdo->prepare("INSERT INTO users (email, password, verification_code, is_verified, division) VALUES (?, ?, ?, ?, ?)");
        $is_verified = 1; // Tandai sebagai terverifikasi
        $stmt->execute([$email, $hashed_password, $kode, $is_verified, $division]);

        // Set session login
        session_regenerate_id(true); // Regenerasi session ID untuk keamanan
        $_SESSION['user_email'] = $email;
        $_SESSION['logged_in'] = true;
        $_SESSION['division'] = $division; // Simpan divisi di session

        // Bersihkan session sementara
        unset($_SESSION['email']);
        unset($_SESSION['verification_code']);

        // Redirect ke halaman sesuai divisi
        switch ($division) {
            case 'Laboratorium':
                header("Location: PiDashboard.php");
                break;
            case 'Produksi':
                header("Location: produksi.php");
                break;
            case 'Manager':
                header("Location: manajer.php");
                break;
            default:
                header("Location: home.php");
        }
        exit();
    }

    // Simpan pesan ke session untuk ditampilkan di index.php
    $_SESSION['pesan'] = $pesan;
    header("Location: index.php");
    exit();
}
?>