<?php

require_once "config.php";
require_login();

if (isset($_POST['add_performance'])) {

    $stmt = $pdo->prepare("
        INSERT INTO performance
        (player_id, matches_played, wins, losses, points, kills, assists)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_POST['player_id'],
        $_POST['matches_played'],
        $_POST['wins'],
        $_POST['losses'],
        $_POST['points'],
        $_POST['kills'],
        $_POST['assists']
    ]);

    header("Location: performance.php");
    exit;
}

if (isset($_GET['delete'])) {

    $stmt = $pdo->prepare(
        "DELETE FROM performance WHERE performance_id=?"
    );

    $stmt->execute([$_GET['delete']]);

    header("Location: performance.php");
    exit;
}

$players = $pdo
    ->query("SELECT player_id,name,username FROM players")
    ->fetchAll(PDO::FETCH_ASSOC);

$performance = $pdo->query("
    SELECT pf.*, p.name, p.username, p.game
    FROM performance pf
    JOIN players p
    ON pf.player_id=p.player_id
    ORDER BY pf.performance_id DESC
")->fetchAll(PDO::FETCH_ASSOC);

include "includes/header.php";

?>

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="page-title">
Performance
</h2>

<p class="page-subtitle">
Track player match statistics and performance.
</p>

</div>

<button
class="btn btn-primary"
data-bs-toggle="modal"
data-bs-target="#performanceModal">

<i class="bi bi-plus-lg"></i>
Add Performance

</button>

</div>

<div class="table-card">

<div class="table-responsive">

<table class="table">

<thead>

<tr>

<th>Player</th>
<th>Game</th>
<th>Matches</th>
<th>Wins</th>
<th>Losses</th>
<th>Points</th>
<th>Kills</th>
<th>Assists</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php foreach ($performance as $p): ?>

<tr>

<td>

<strong>
<?= htmlspecialchars($p['name']) ?>
</strong>

<br>

<small class="text-secondary">
@<?= htmlspecialchars($p['username']) ?>
</small>

</td>

<td>

<span class="badge-game">
<?= htmlspecialchars($p['game']) ?>
</span>

</td>

<td><?= $p['matches_played'] ?></td>

<td class="text-success">
<?= $p['wins'] ?>
</td>

<td class="text-danger">
<?= $p['losses'] ?>
</td>

<td><?= $p['points'] ?></td>

<td><?= $p['kills'] ?></td>

<td><?= $p['assists'] ?></td>

<td>

<a
href="?delete=<?= $p['performance_id'] ?>"
class="btn btn-sm btn-outline-danger"
onclick="return confirm('Delete performance record?')">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

<div class="modal fade" id="performanceModal">

<div class="modal-dialog">

<div class="modal-content bg-dark text-white">

<form method="POST">

<div class="modal-header">

<h5>Add Performance</h5>

<button
class="btn-close btn-close-white"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<div class="mb-3">

<label class="form-label">
Player
</label>

<select
name="player_id"
class="form-select"
required>

<?php foreach ($players as $player): ?>

<option value="<?= $player['player_id'] ?>">

<?= htmlspecialchars($player['name']) ?>

</option>

<?php endforeach; ?>

</select>

</div>

<?php

$fields = [
    'matches_played' => 'Matches Played',
    'wins' => 'Wins',
    'losses' => 'Losses',
    'points' => 'Points',
    'kills' => 'Kills',
    'assists' => 'Assists'
];

foreach ($fields as $name => $label):

?>

<div class="mb-3">

<label class="form-label">
<?= $label ?>
</label>

<input
type="number"
name="<?= $name ?>"
class="form-control"
value="0"
min="0"
required>

</div>

<?php endforeach; ?>

</div>

<div class="modal-footer">

<button
name="add_performance"
class="btn btn-primary">

Save Performance

</button>

</div>

</form>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>