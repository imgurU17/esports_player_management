<?php

require_once "config.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_name = trim($_POST["user_name"] ?? "");
    $rating = intval($_POST["rating"] ?? 0);
    $feedback = trim($_POST["feedback"] ?? "");

    if ($user_name === "") {

        $message = "Please enter your name.";
        $messageType = "danger";

    } elseif ($rating < 1 || $rating > 5) {

        $message = "Please select a rating from 1 to 5 stars.";
        $messageType = "danger";

    } else {

        $stmt = $pdo->prepare("
            INSERT INTO ratings
            (user_name, rating, feedback)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $user_name,
            $rating,
            $feedback
        ]);

        $message = "Thank you for rating our project! 🎮";
        $messageType = "success";
    }
}

$averageRating = $pdo->query("
    SELECT COALESCE(AVG(rating), 0)
    FROM ratings
")->fetchColumn();

$totalRatings = $pdo->query("
    SELECT COUNT(*)
    FROM ratings
")->fetchColumn();

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Rate Our Project | eSports Manager</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
rel="stylesheet">

<link
rel="stylesheet"
href="assets/css/style.css">

<style>

.rating-page {

    min-height: 100vh;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 30px;

}

.rating-container {

    width: 100%;

    max-width: 650px;

}

.rating-card {

    background: rgba(17, 24, 39, 0.96);

    border: 1px solid rgba(255,255,255,0.08);

    border-radius: 25px;

    padding: 40px;

    box-shadow:
        0 25px 70px rgba(0,0,0,.45);

}

.rating-icon {

    width: 75px;

    height: 75px;

    margin: auto;

    border-radius: 20px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 35px;

    background:
        linear-gradient(
            135deg,
            #7c3aed,
            #06b6d4
        );

}

.rating-stars {

    display: flex;

    flex-direction: row-reverse;

    justify-content: center;

    gap: 8px;

    margin: 20px 0 30px;

}

.rating-stars input {

    display: none;

}

.rating-stars label {

    font-size: 50px;

    color: #475569;

    cursor: pointer;

    transition: 0.2s;

}

.rating-stars label:hover,

.rating-stars label:hover ~ label,

.rating-stars input:checked ~ label {

    color: #facc15;

    transform: scale(1.08);

}

.average-rating {

    font-size: 42px;

    font-weight: 800;

}

.rating-count {

    color: #94a3b8;

}

.feedback-box {

    background: rgba(255,255,255,.03);

    border-radius: 15px;

    padding: 15px;

    margin-top: 20px;

}

</style>

</head>

<body>

<div class="rating-page">

<div class="rating-container">

<div class="rating-card">

<!-- Header -->

<div class="text-center">

<div class="rating-icon mb-3">

🎮

</div>

<h2 class="fw-bold">

Rate Our eSports Project

</h2>

<p class="text-secondary">

We would love to know what you think!

</p>

</div>


<!-- Current Rating -->

<div class="text-center my-4">

<div class="average-rating">

<?= number_format($averageRating, 1) ?>

<span class="fs-5 text-secondary">
/ 5
</span>

</div>

<div class="text-warning fs-3">

<?php

$roundedRating = round($averageRating);

for ($i = 1; $i <= 5; $i++) {

    echo ($i <= $roundedRating)
        ? "★"
        : "☆";

}

?>

</div>

<div class="rating-count">

Based on <?= $totalRatings ?> rating(s)

</div>

</div>


<!-- Message -->

<?php if ($message): ?>

<div class="alert alert-<?= $messageType ?>">

<?= htmlspecialchars($message) ?>

</div>

<?php endif; ?>


<!-- Rating Form -->

<form method="POST">

<div class="mb-3">

<label class="form-label">

Your Name

</label>

<input
type="text"
name="user_name"
class="form-control"
placeholder="Enter your name"
maxlength="100"
required>

</div>


<label class="form-label">

Your Rating

</label>

<div class="rating-stars">

<input
type="radio"
name="rating"
id="star5"
value="5"
required>

<label for="star5"
title="Excellent">
★
</label>


<input
type="radio"
name="rating"
id="star4"
value="4">

<label for="star4"
title="Very Good">
★
</label>


<input
type="radio"
name="rating"
id="star3"
value="3">

<label for="star3"
title="Good">
★
</label>


<input
type="radio"
name="rating"
id="star2"
value="2">

<label for="star2"
title="Average">
★
</label>


<input
type="radio"
name="rating"
id="star1"
value="1">

<label for="star1"
title="Poor">
★
</label>

</div>


<div class="mb-4">

<label class="form-label">

Feedback

</label>

<textarea
name="feedback"
class="form-control"
rows="4"
maxlength="1000"
placeholder="Tell us what you think about our project..."></textarea>

</div>


<button
type="submit"
class="btn btn-primary w-100 py-3">

<i class="bi bi-star-fill"></i>

&nbsp; Submit Rating

</button>

</form>


<div class="text-center mt-4">

<a href="login.php"
class="text-secondary">

<i class="bi bi-arrow-left"></i>

Admin Login

</a>

</div>

</div>

</div>

</div>

</body>

</html>