
<?php
include "project_rpl/awal/connection.php";
include "partials/header.php";
include "partials/footer.php";

session_start();

// Pastikan user memiliki role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != "peneliti") {
    header("location:login.php");
    exit();
}
?>

<div class="main">
  <a href="index.php?page=peternakan" class="category-btn">
    <i class="fa-solid fa-cow"></i>Peternakan
  </a>
  <a href="index.php?page=perikanan" class="category-btn">
    <i class="fa-solid fa-fish"></i>Perikanan
  </a>
  <a href="index.php?page=pertanian" class="category-btn">
    <i class="fa-solid fa-wheat-awn"></i>Pertanian
  </a>
</div>
