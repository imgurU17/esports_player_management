<?php

require_once "config.php";
require_login();

$players = $pdo
    ->query("SELECT COUNT(*) FROM players")
    ->fetchColumn();

$teams = $pdo
    ->query("SELECT COUNT(*) FROM teams")
    ->fetchColumn();

$tournaments = $pdo
    ->query("SELECT COUNT(*) FROM tournaments")
    ->fetchColumn();

$matches = $pdo
    ->query("SELECT COALESCE(SUM(matches_played),0) FROM performance")
    ->fetchColumn();

$averageRating = $pdo->query("
    SELECT COALESCE(AVG(rating), 0)
    FROM ratings
")->fetchColumn();

$totalRatings = $pdo->query("
    SELECT COUNT(*)
    FROM ratings
")->fetchColumn();

$recentPlayers = $pdo->query("
    SELECT p.*, t.team_name
    FROM players p
    LEFT JOIN teams t
    ON p.team_id = t.team_id
    ORDER BY p.player_id DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

$ratings = $pdo->query("
    SELECT *
    FROM ratings
    ORDER BY created_at DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

include "includes/header.php";

?>

<div class="mb-4">

<h2 class="page-title">
Dashboard
</h2>

<p class="page-subtitle">
Welcome back, <?= htmlspecialchars($_SESSION['username']) ?>.
Manage your eSports organization from one place.
</p>

</div>

<div class="row g-4 mb-4">

<div class="col-lg col-md-6">

<div class="card-stat">

<div class="stat-icon">
<i class="bi bi-person"></i>
</div>

<div class="stat-number">
<?= $players ?>
</div>

<div class="stat-label">
Total Players
</div>

</div>

</div>

<div class="col-lg col-md-6">

<div class="card-stat">

<div class="stat-icon">
<i class="bi bi-people"></i>
</div>

<div class="stat-number">
<?= $teams ?>
</div>

<div class="stat-label">
Teams
</div>

</div>

</div>

<div class="col-lg col-md-6">

<div class="card-stat">

<div class="stat-icon">
<i class="bi bi-trophy"></i>
</div>

<div class="stat-number">
<?= $tournaments ?>
</div>

<div class="stat-label">
Tournaments
</div>

</div>

</div>

<div class="col-lg col-md-6">

<div class="card-stat">

<div class="stat-icon">
<i class="bi bi-controller"></i>
</div>

<div class="stat-number">
<?= $matches ?>
</div>

<div class="stat-label">
Matches Played
</div>

</div>

</div>

</div>

<div class="col-lg col-md-6">

    <div class="card-stat">

        <div class="stat-icon">

            <i class="bi bi-star-fill"></i>

        </div>

        <div class="stat-number">

            <?= number_format($averageRating, 1) ?>

            <small>/5</small>

        </div>

        <div class="stat-label">

            Project Rating

        </div>

    </div>

</div>

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h5 class="mb-1">
Recent Players
</h5>

<p class="text-secondary mb-0">
Latest registered eSports players
</p>

</div>

<a href="players.php"
class="btn btn-primary">

<i class="bi bi-plus"></i>
Add Player

</a>

</div>

<div class="table-responsive">

<table class="table">

<thead>

<tr>

<th>Player</th>
<th>Username</th>
<th>Game</th>
<th>Team</th>
<th>Skill</th>

</tr>

</thead>

<tbody>

<?php foreach ($recentPlayers as $player): ?>

<tr>

<td>
<strong>
<?= htmlspecialchars($player['name']) ?>
</strong>
</td>

<td>
@<?= htmlspecialchars($player['username']) ?>
</td>

<td>
<span class="badge-game">
<?= htmlspecialchars($player['game']) ?>
</span>
</td>

<td>
<?= htmlspecialchars($player['team_name'] ?? 'Unassigned') ?>
</td>

<td>
<?= htmlspecialchars($player['skill_level']) ?>
</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

<div class="table-card mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h5 class="mb-1">
                ⭐ User Feedback
            </h5>

            <p class="text-secondary mb-0">
                Recent reviews from project visitors
            </p>

        </div>

        <a href="rating.php"
           class="btn btn-primary">

            <i class="bi bi-star"></i>
            Rate Project

        </a>

    </div>


    <?php if (empty($ratings)): ?>

        <div class="text-center py-4">

            <div class="fs-1">
                ⭐
            </div>

            <p class="text-secondary">
                No ratings yet.
            </p>

        </div>

    <?php else: ?>


        <?php foreach ($ratings as $review): ?>

            <div class="feedback-box">

                <div class="d-flex justify-content-between">

                    <strong>

                        <?= htmlspecialchars(
                            $review['user_name']
                        ) ?>

                    </strong>


                    <span class="text-warning">

                        <?php

                        for ($i = 1; $i <= 5; $i++) {

                            echo $i <= $review['rating']
                                ? "★"
                                : "☆";

                        }

                        ?>

                    </span>

                </div>


                <?php if (!empty($review['feedback'])): ?>

                    <p class="text-secondary mt-2 mb-1">

                        <?= htmlspecialchars(
                            $review['feedback']
                        ) ?>

                    </p>

                <?php endif; ?>


                <small class="text-secondary">

                    <?= date(
                        "d M Y, h:i A",
                        strtotime($review['created_at'])
                    ) ?>

                </small>

            </div>

        <?php endforeach; ?>


    <?php endif; ?>

</div>

<?php include "includes/footer.php"; ?>