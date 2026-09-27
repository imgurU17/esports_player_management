<?php
require_once "config.php";
require_login();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>eSports Manager</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
rel="stylesheet">

<link rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">

<div class="container-fluid px-4">

<a class="navbar-brand" href="dashboard.php">
🎮 eSports Manager
</a>

<button class="navbar-toggler"
data-bs-toggle="collapse"
data-bs-target="#navbarNav">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse"
id="navbarNav">

<ul class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link" href="dashboard.php">
<i class="bi bi-grid"></i> Dashboard
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="players.php">
<i class="bi bi-person"></i> Players
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="teams.php">
<i class="bi bi-people"></i> Teams
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="tournaments.php">
<i class="bi bi-trophy"></i> Tournaments
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="performance.php">
<i class="bi bi-bar-chart"></i> Performance
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="rating.php">
<i class="bi bi-star-fill"></i> Rate Project
</a>
</li>

<li class="nav-item">
<a class="nav-link text-danger"
href="logout.php">
<i class="bi bi-box-arrow-right"></i> Logout
</a>
</li>

</ul>

</div>

</div>

</nav>

<main class="container-fluid px-4 py-4">