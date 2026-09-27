<?php

require_once "config.php";
require_login();

if (isset($_POST['add_team'])) {

    $stmt = $pdo->prepare("
        INSERT INTO teams
        (team_name, game, manager_name)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $_POST['team_name'],
        $_POST['game'],
        $_POST['manager_name']
    ]);

    header("Location: teams.php");
    exit;
}

if (isset($_GET['delete'])) {

    $stmt = $pdo->prepare(
        "DELETE FROM teams WHERE team_id=?"
    );

    $stmt->execute([$_GET['delete']]);

    header("Location: teams.php");
    exit;
}

$teams = $pdo->query("
    SELECT t.*, COUNT(p.player_id) AS player_count
    FROM teams t
    LEFT JOIN players p
    ON t.team_id=p.team_id
    GROUP BY t.team_id
    ORDER BY t.team_id DESC
")->fetchAll(PDO::FETCH_ASSOC);

include "includes/header.php";

?>

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="page-title">Teams</h2>

<p class="page-subtitle">
Manage eSports teams and managers.
</p>

</div>

<button
class="btn btn-primary"
data-bs-toggle="modal"
data-bs-target="#teamModal">

<i class="bi bi-plus-lg"></i>
Add Team

</button>

</div>

<div class="table-card">

<div class="table-responsive">

<table class="table">

<thead>

<tr>
<th>Team</th>
<th>Game</th>
<th>Manager</th>
<th>Players</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php foreach ($teams as $team): ?>

<tr>

<td>
<strong>
<?= htmlspecialchars($team['team_name']) ?>
</strong>
</td>

<td>
<span class="badge-game">
<?= htmlspecialchars($team['game']) ?>
</span>
</td>

<td>
<?= htmlspecialchars($team['manager_name']) ?>
</td>

<td>
<?= $team['player_count'] ?>
</td>

<td>

<a
href="?delete=<?= $team['team_id'] ?>"
class="btn btn-sm btn-outline-danger"
onclick="return confirm('Delete this team?')">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

<div class="modal fade" id="teamModal">

<div class="modal-dialog">

<div class="modal-content bg-dark text-white">

<form method="POST">

<div class="modal-header">

<h5>Add Team</h5>

<button
class="btn-close btn-close-white"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<div class="mb-3">

<label class="form-label">
Team Name
</label>

<input
name="team_name"
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
Manager Name
</label>

<input
name="manager_name"
class="form-control"
required>

</div>

</div>

<div class="modal-footer">

<button
name="add_team"
class="btn btn-primary">

Add Team

</button>

</div>

</form>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>