<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['division'] !== 'Laboratorium') {
    header("Location: home.php");
    exit();
}

if (isset($_POST['submit_report'])) {
    $user_id = $pdo->query("SELECT id FROM users WHERE email = '{$_SESSION['user_email']}'")->fetchColumn();
    $bacteria_progress = $_POST['bacteria_progress'];
    $stmt = $pdo->prepare("INSERT INTO laboratory_reports (user_id, report_date, bacteria_progress) VALUES (?, CURDATE(), ?)");
    $stmt->execute([$user_id, $bacteria_progress]);
    $_SESSION['pesan'] = "Laporan berhasil disimpan!";
    header("Location: laboratory_report.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laboratorium</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #1a1a1a; color: #fff; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #333; color: #fff; }
        .submit-btn { padding: 10px 20px; background-color: #ff6200; border: none; border-radius: 5px; color: #fff; cursor: pointer; }
        .message { text-align: center; margin-bottom: 15px; color: #ff6200; }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['pesan'])): ?>
            <div class="message"><?php echo $_SESSION['pesan']; unset($_SESSION['pesan']); ?></div>
        <?php endif; ?>
        <h1>Laporan Perkembangan Bakteri</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="bacteria_progress">Perkembangan Bakteri:</label>
                <textarea name="bacteria_progress" id="bacteria_progress" rows="5" required></textarea>
            </div>
            <button type="submit" name="submit_report" class="submit-btn">Kirim Laporan</button>
        </form>
    </div>
</body>
</html>