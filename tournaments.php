<?php

require_once "config.php";
require_login();

if (isset($_POST['add_tournament'])) {

    $stmt = $pdo->prepare("
        INSERT INTO tournaments
        (tournament_name, game, tournament_date, status)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['tournament_name'],
        $_POST['game'],
        $_POST['tournament_date'],
        $_POST['status']
    ]);

    header("Location: tournaments.php");
    exit;
}

if (isset($_GET['delete'])) {

    $stmt = $pdo->prepare(
        "DELETE FROM tournaments WHERE tournament_id=?"
    );

    $stmt->execute([$_GET['delete']]);

    header("Location: tournaments.php");
    exit;
}

$tournaments = $pdo->query("
    SELECT *
    FROM tournaments
    ORDER BY tournament_date ASC
")->fetchAll(PDO::FETCH_ASSOC);

include "includes/header.php";

?>

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="page-title">
Tournaments
</h2>

<p class="page-subtitle">
Manage upcoming and completed tournaments.
</p>

</div>

<button
class="btn btn-primary"
data-bs-toggle="modal"
data-bs-target="#tournamentModal">

<i class="bi bi-plus-lg"></i>
Add Tournament

</button>

</div>

<div class="table-card">

<div class="table-responsive">

<table class="table">

<thead>

<tr>

<th>Tournament</th>
<th>Game</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php foreach ($tournaments as $t): ?>

<tr>

<td>
<strong>
<?= htmlspecialchars($t['tournament_name']) ?>
</strong>
</td>

<td>

<span class="badge-game">
<?= htmlspecialchars($t['game']) ?>
</span>

</td>

<td>
<?= date("d M Y", strtotime($t['tournament_date'])) ?>
</td>

<td>

<span class="badge rounded-pill
<?= $t['status'] === 'Completed'
    ? 'bg-success'
    : ($t['status'] === 'Ongoing'
        ? 'bg-warning text-dark'
        : 'bg-primary') ?>">

<?= htmlspecialchars($t['status']) ?>

</span>

</td>

<td>

<a
href="?delete=<?= $t['tournament_id'] ?>"
class="btn btn-sm btn-outline-danger"
onclick="return confirm('Delete tournament?')">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

<div class="modal fade" id="tournamentModal">

<div class="modal-dialog">

<div class="modal-content bg-dark text-white">

<form method="POST">

<div class="modal-header">

<h5>Add Tournament</h5>

<button
class="btn-close btn-close-white"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<div class="mb-3">

<label class="form-label">
Tournament Name
</label>

<input
name="tournament_name"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">
Game
</label>

<select
name="game"
class="form-select">

<option>BGMI</option>
<option>Valorant</option>
<option>Free Fire</option>
<option>CS2</option>

</select>

</div>

<div class="mb-3">

<label class="form-label">
Date
</label>

<input
type="date"
name="tournament_date"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">
Status
</label>

<select
name="status"
class="form-select">

<option>Upcoming</option>
<option>Ongoing</option>
<option>Completed</option>

</select>

</div>

</div>

<div class="modal-footer">

<button
name="add_tournament"
class="btn btn-primary">

Add Tournament

</button>

</div>

</form>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>