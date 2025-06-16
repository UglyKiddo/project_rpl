<?php
session_start();

require 'koneksi.php'; // koneksi ke database

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Query to fetch all instructions from the 'Laboratorium' division
$query = "SELECT * FROM instructions WHERE division = 'Laboratorium' ORDER BY created_at DESC";
$stmt = $pdo->prepare($query); 
$stmt->execute();

// Fetch all rows into an array
$instructions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch the latest instruction for the alert with status check
$latest_query = "SELECT * FROM instructions WHERE division = 'Laboratorium' ORDER BY created_at DESC LIMIT 1";
$latest_stmt = $pdo->prepare($latest_query);
$latest_stmt->execute();
$latest_row = $latest_stmt->fetch(PDO::FETCH_ASSOC);
$message = $latest_row ? $latest_row['content'] : "No instructions available for Laboratorium.";
$isLatestDone = $latest_row && strtolower($latest_row['status']) === 'done'; // Check if latest is done
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Bakteri - BacterFly</title>
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
    header {
      background-color: #111;
      padding: 16px;
      border-bottom: 1px solid #FFA347;
      color: #FFA347;
    }
    main {
      flex: 1; /* Allows main to take available space */
      padding: 16px;
    }
    .alert {
      background-color: purple;
      padding: 12px;
      border-radius: 8px;
      margin-top: 20px;
      transition: all 0.3s ease; /* Smooth transition for fade */
    }
    .alert.completed {
      color: #888; /* Faded text color */
      opacity: 0.5; /* Faded effect */
      text-decoration: line-through; /* Strike through for done items */
    }
    .instructions-list {
      margin-top: 20px;
    }
    .instruction-item {
      background-color: purple;
      padding: 12px;
      border-radius: 8px;
      margin-top: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all 0.3s ease; /* Smooth transition for the entire item */
    }
    .instruction-content {
      flex-grow: 1;
    }
    .instruction-content.completed {
      color: #888; /* Faded text color */
      opacity: 0.5; /* Faded effect */
      text-decoration: line-through; /* Strike through for done items */
    }
    .instruction-item p {
      margin: 0;
    }
    .actions a {
      text-decoration: none;
      color: #FFA347;
      padding: 5px 10px;
      border: 1px solid #FFA347;
      border-radius: 5px;
      transition: all 0.3s ease; /* Smooth transition for the button */
    }
    .actions a.completed {
      color: #888; /* Faded button text color */
      border-color: #888; /* Faded border color */
      opacity: 0.5; /* Faded effect on button */
      pointer-events: none; /* Disable clicking on completed items */
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
  <a href="dashboard_lab.php" style="color:white; text-decoration:none;">← Back</a>
  <div style="text-align:center; font-weight:bold;">Data Bakteri</div>
</header>

<main>
  <div class="alert <?= $isLatestDone ? 'completed' : '' ?>">
    <b>✅ Pesan !!</b><br>
    <?php echo htmlspecialchars($message); ?>
  </div>
  <div class="instructions-list">
    <?php foreach ($instructions as $row): ?>
      <div class="instruction-item">
        <div class="instruction-content <?= strtolower($row['status']) === 'done' ? 'completed' : '' ?>">
          <p><?php echo htmlspecialchars($row['title'] . ' (' . $row['division'] . ')'); ?></p>
          <p><?php echo htmlspecialchars($row['content']); ?></p>
        </div>
        <div class="actions">
          <a href="proses.php?action=mark_done&id=<?php echo $row['id']; ?>" class="done <?= strtolower($row['status']) === 'done' ? 'completed' : '' ?>">Mark as Done</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<nav>
  <a href="lab_dashboard.php">🏠</a>
  <a href="lab_bakteri.php">🕒</a>
  <a href="lab_intruksi.php" class="active">📋</a>
  <a href="profil.php">👤</a>
</nav>

</body>
</html>