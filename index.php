<?php
session_start();
require 'backend/connexionBDD.php';

$conn = connectBDD();

$films = [];
$q = mysqli_query($conn, "SELECT * FROM films");
while ($data = mysqli_fetch_assoc($q)) {
    $films[] = $data;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['film_id']) && isset($_SESSION['email'])) {
    $film_id = (int)$_POST['film_id'];
    $email = $_SESSION['email'];

    $check = mysqli_query($conn, "SELECT * FROM votes WHERE email = '" . mysqli_real_escape_string($conn, $email) . "'");
    if (mysqli_num_rows($check) > 0) {
        $message = "Vous avez déjà voté.";
    } else {
        $userQuery = mysqli_query($conn, "SELECT id FROM utilisateurs WHERE email = '" . mysqli_real_escape_string($conn, $email) . "' LIMIT 1");
        $user = mysqli_fetch_assoc($userQuery);
        $user_id = $user ? (int)$user['id'] : null;

        $insert = mysqli_query($conn, "INSERT INTO votes (email, film_id, date_vote, utilisateur_id) VALUES (
            '" . mysqli_real_escape_string($conn, $email) . "',
            $film_id,
            NOW(),
            " . ($user_id ? $user_id : "NULL") . "
        )");

        if ($insert) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Erreur lors de l'enregistrement du vote.";
        }
    }
}
closeBDD($conn);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Vote Film</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles/style.css" />

<?php
$conn = connectBDD();
$result = mysqli_query($conn, "SELECT films.titre, COUNT(votes.id) AS nb_votes
                               FROM votes
                               INNER JOIN films ON films.id = votes.film_id
                               GROUP BY films.id
                               ORDER BY nb_votes DESC");

$dataPoints = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dataPoints[] = [
        "label" => $row['titre'],
        "y" => (int)$row['nb_votes']
    ];
}

closeBDD($conn);
?>


<script>
window.onload = function () {
  var options = {
    theme: "dark1",
    animationEnabled: true,
    title: {
      text: "Nombre de votes par film"
    },
    axisY: {
      title: "Nombre de votes",
      includeZero: true
    },
    axisX: {
      title: "Films"
    },
    data: [{
      type: "column",
      yValueFormatString: "#,##0",
      dataPoints: <?= json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
  };
  $("#chartContainer").CanvasJSChart(options);
}
</script>


</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <div class="navbar-brand" style="width: 40px; height: 40px; background-color: white; border-radius: 50%;"></div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#resultats">Résultat</a>
        </li>
        <?php if (isset($_SESSION['email'])): ?>
          <li class="nav-item">
            <a href="backend/deconnexion.php" class="nav-link">Déconnexion</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a href="connexion.php" class="nav-link">Connexion</a>
          </li>
          <li class="nav-item">
            <a href="inscription.php" class="nav-link">Inscription</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<h4 class="text-center text-warning mt-5 fw-bold fs-2 fs-md-1 px-3 px-md-0">Bienvenue sur notre tournoi de films !</h4>
<p class="text-center text-white mb-4 fs-5 fs-md-4 px-3 px-md-0">Voici comment ça marche :</p>
<p class="text-center text-white mb-4 fs-5 fs-md-4 px-3 px-md-0">Vous allez voir s’affronter deux films à chaque étape. Pour chaque duel, votez pour votre film préféré. Le gagnant passe au tour suivant, jusqu’à ce qu’il n’en reste plus qu’un : le grand vainqueur du tournoi !</p>
<p class="text-center text-white mb-4 fs-5 fs-md-4 px-3 px-md-0">Le but est de découvrir ensemble quel film est le plus apprécié. Votre vote compte vraiment, alors prenez votre temps et amusez-vous !</p>
<p class="text-center text-white mb-4 fs-5 fs-md-4 px-3 px-md-0">Prêt à commencer ? Cliquez sur le bouton ci-dessous pour voter !</p>

<div class="text-center px-3 px-md-0">
  <?php if (isset($_SESSION['email'])): ?>
    <a href="#" id="toggleLien" class="btn btn-vote btn-sm btn-md">Voter maintenant</a>
  <?php else: ?>
    <p class="text-center text-white mb-4 fs-5 fs-md-4 px-3 px-md-0">Vous devez être connecté pour voter.</p>
    <a href="connexion.php" class="btn btn-warning btn-sm btn-md">Se connecter</a>
    <a href="inscription.php" class="btn btn-warning btn-sm btn-md">S'inscrire</a>
  <?php endif; ?>
</div>

<div id="contenu" style="display: none; text-align: center; margin-top: 20px;">
  <div class="container px-3 px-md-0 pt-5 pt-md-5">
    <div class="row mb-4 justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 text-dark p-3" style="background-color: #ffc107; border-radius: 10px;">
        <h3 class="mb-3 text-center fs-4 fs-md-3">Election du film de la soirée !</h3>
        <p class="mb-3 text-center fs-6 fs-md-5">Vote pour ton film préféré</p>

        <div id="carrousel1" class="carousel slide" data-bs-theme="light">
          <div class="carousel-indicators">
            <?php foreach ($films as $index => $film): ?>
              <button type="button" data-bs-target="#carrousel1" data-bs-slide-to="<?= $index ?>"
                class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>"
                aria-label="Slide <?= $index + 1 ?>"></button>
            <?php endforeach; ?>
          </div>
          <div class="carousel-inner">
            <?php foreach ($films as $index => $film): ?>
              <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <img src="<?= htmlspecialchars($film['images']) ?>" class="d-block w-100 img-fluid" alt="<?= htmlspecialchars($film['titre']) ?>" />
                <div class="carousel-caption d-block">
                  <h5><?= htmlspecialchars($film['titre']) ?> (Votes: <?= $votesCount[$film['id']] ?? 0 ?>)</h5>
                  <p><?= htmlspecialchars($film['synopsis']) ?></p> 
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carrousel1" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carrousel1" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>

        <div class="text-center mt-3">
          <button class="btn btn-dark btn-lg">Voter</button>
        </div>
      </div>
    </div>
  </div>
</div>


<?php if ($message): ?>
  <div class="alert alert-info text-center mt-3"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php
$userVote = null;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $conn = connectBDD();

    // Vérifier si l'utilisateur a déjà voté
    $check = mysqli_query($conn, "SELECT v.*, f.titre FROM votes v JOIN films f ON v.film_id = f.id WHERE v.email = '".mysqli_real_escape_string($conn, $email)."' LIMIT 1");
    if ($check && mysqli_num_rows($check) > 0) {
        $userVote = mysqli_fetch_assoc($check);
    }
    closeBDD($conn);
}
?>


<!-- Modal de vote -->
<!-- Modal de vote -->
<div class="modal fade" id="voteModal" tabindex="-1" aria-labelledby="voteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="index.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="voteModalLabel">Vote pour ton film préféré</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <?php if ($userVote): ?>
          <p>Vous avez déjà voté pour le film : <strong><?= htmlspecialchars($userVote['titre']) ?></strong>.</p>
        <?php else: ?>
          <label for="filmSelect" class="form-label">Choisis un film :</label>
          <select id="filmSelect" name="film_id" class="form-select" required>
            <option value="" disabled selected>-- Sélectionnez un film --</option>
            <?php foreach ($films as $film): ?>
              <option value="<?= htmlspecialchars($film['id']) ?>">
                <?= htmlspecialchars($film['titre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <?php if (!$userVote): ?>
          <button type="submit" class="btn btn-primary">Voter</button>
        <?php else: ?>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>

<?php if ($userVote): ?>
<div id="resultats" style="height: 60px;"></div>
<div id="chartContainer" style="height: 370px; width: 50%; margin: 0 auto;"></div>
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
<?php endif; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('toggleLien')?.addEventListener('click', function(e) {
    e.preventDefault();
    const contenu = document.getElementById('contenu');
    if (contenu.style.display === 'none') {
      contenu.style.display = 'block';
    } else {
      contenu.style.display = 'none';
    }
  });
</script>


<video autoplay muted loop style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">
  <source src="video/background.mp4" type="video/mp4">
</body>
</html>
