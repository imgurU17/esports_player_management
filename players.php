<?php

require_once "config.php";
require_login();

if (isset($_POST['add_player'])) {

    $stmt = $pdo->prepare("
        INSERT INTO players
        (name, username, game, age, skill_level, team_id)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['name'],
        $_POST['username'],
        $_POST['game'],
        $_POST['age'],
        $_POST['skill_level'],
        $_POST['team_id'] ?: null
    ]);

    header("Location: players.php");
    exit;
}

if (isset($_GET['delete'])) {

    $stmt = $pdo->prepare(
        "DELETE FROM players WHERE player_id=?"
    );

    $stmt->execute([$_GET['delete']]);

    header("Location: players.php");
    exit;
}

$teams = $pdo
    ->query("SELECT * FROM teams ORDER BY team_name")
    ->fetchAll(PDO::FETCH_ASSOC);

$players = $pdo->query("
    SELECT p.*, t.team_name
    FROM players p
    LEFT JOIN teams t
    ON p.team_id=t.team_id
    ORDER BY p.player_id DESC
")->fetchAll(PDO::FETCH_ASSOC);

include "includes/header.php";

?>

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="page-title">
Players
</h2>

<p class="page-subtitle">
Manage all registered eSports players.
</p>

</div>

<button
class="btn btn-primary"
data-bs-toggle="modal"
data-bs-target="#addPlayer">

<i class="bi bi-plus-lg"></i>
Add Player

</button>

</div>

<div class="table-card">

<div class="table-responsive">

<table class="table">

<thead>

<tr>
<th>Name</th>
<th>Username</th>
<th>Game</th>
<th>Age</th>
<th>Skill</th>
<th>Team</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php foreach ($players as $p): ?>

<tr>

<td>
<strong><?= htmlspecialchars($p['name']) ?></strong>
</td>

<td>
@<?= htmlspecialchars($p['username']) ?>
</td>

<td>
<span class="badge-game">
<?= htmlspecialchars($p['game']) ?>
</span>
</td>

<td><?= $p['age'] ?></td>

<td><?= htmlspecialchars($p['skill_level']) ?></td>

<td>
<?= htmlspecialchars($p['team_name'] ?? 'Unassigned') ?>
</td>

<td>

<a
href="?delete=<?= $p['player_id'] ?>"
class="btn btn-sm btn-outline-danger"
onclick="return confirm('Delete this player?')">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

<div class="modal fade" id="addPlayer">

<div class="modal-dialog">

<div class="modal-content bg-dark text-white">

<div class="modal-header">

<h5 class="modal-title">
Add New Player
</h5>

<button
class="btn-close btn-close-white"
data-bs-dismiss="modal">
</button>

</div>

<form method="POST">

<div class="modal-body">

<div class="mb-3">

<label class="form-label">Name</label>

<input
name="name"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Username</label>

<input
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Game</label>

<select name="game"
class="form-select"
required>

<option>BGMI</option>
<option>Valorant</option>
<option>Free Fire</option>
<option>CS2</option>
<option>Call of Duty</option>
<option>League of Legends</option>

</select>

</div>

<div class="mb-3">

<label class="form-label">Age</label>

<input
type="number"
name="age"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Skill Level</label>

<select
name="skill_level"
class="form-select">

<option>Beginner</option>
<option>Intermediate</option>
<option>Advanced</option>
<option>Expert</option>

</select>

</div>

<div class="mb-3">

<label class="form-label">Team</label>

<select
name="team_id"
class="form-select">

<option value="">No Team</option>

<?php foreach ($teams as $team): ?>

<option value="<?= $team['team_id'] ?>">

<?= htmlspecialchars($team['team_name']) ?>

</option>

<?php endforeach; ?>

</select>

</div>

</div>

<div class="modal-footer">

<button
type="button"
class="btn btn-secondary"
data-bs-dismiss="modal">

Cancel

</button>

<button
name="add_player"
class="btn btn-primary">

Add Player

</button>

</div>

</form>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>