<?php 
require "backend/connexionBDD.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin – Liste des Films</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    .btn {
      box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
      transition: box-shadow 0.25s ease-in-out;
    }
    .btn-success {
      box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }
    .btn-danger {
      box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }
    .btn:hover, .btn:focus {
      box-shadow: 0 6px 15px rgba(0, 123, 255, 0.5);
    }
    .btn-success:hover, .btn-success:focus {
      box-shadow: 0 6px 15px rgba(40, 167, 69, 0.5);
    }
    .btn-danger:hover, .btn-danger:focus {
      box-shadow: 0 6px 15px rgba(220, 53, 69, 0.5);
    }
  </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid position-relative">
    <div class="navbar-brand" style="width: 40px; height: 40px; background-color: white; border-radius: 50%;"></div>
    <h4 class="text-white mb-0 position-absolute top-50 start-50 translate-middle">Admin – Liste des Films</h4>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="backend/deconnexion.php" class="nav-link">Déconnexion</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<main class="container flex-grow-1">

  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="h4 mb-0 mt-5">Liste des films</h2>
  </div>

  <div class="card mb-5">
    <div class="card-body">
      <form action="backend/ajout.php" method="POST" class="row g-3">
        <div class="col-md-6">
          <label for="titre" class="form-label">Titre</label>
          <input type="text" id="titre" name="titre" class="form-control" placeholder="Titre du film" required />
        </div>
        <div class="col-md-6">
          <label for="created_at" class="form-label">Date de création</label>
          <input type="date" id="created_at" name="created_at" class="form-control" required />
        </div>
        <div class="col-12">
          <label for="synopsis" class="form-label">Synopsis</label>
          <input type="text" id="synopsis" name="synopsis" class="form-control" placeholder="Synopsis du film" required />
        </div>
        <div class="col-12">
          <label for="synopsis" class="form-label">Affiche</label>
          <input type="text" id="synopsis" name="images" class="form-control" placeholder="Mettez le lien de l'affiche de votre film ( Ex : https:// ... )" required />
        </div>

        <div class="col-12 text-end">
          <button type="submit" name="ajouter" class="btn btn-success">
            <i class="bi bi-check2-circle me-1"></i> Ajouter
          </button>
        </div>
      </form>
    </div>
  </div>

  <table class="table table-striped table-bordered align-middle shadow-sm">
    <thead class="table-dark">
      <tr>
        <td>Affiche</td>
        <td>Titre</td>
        <td>Date de création</td>
        <td>Synopsis</td>
        <td>Votes</td>
        <td>Actions</td>

      </tr>
    </thead>
    <tbody>
      <?php foreach (listFilms() as $value){ ?>
        <tr>
          <td><img src="<?= $value["images"] ?>" alt="Affiche" style="height: 100px; object-fit: cover;"></td>
          <td><?= $value["titre"] ?></td>
          <td><?= $value["created_at"] ?></td>
          <td><?= $value["synopsis"] ?></td>
          <td>Votes</td>
          <td>
            <a href="backend/delete.php?del=<?= $value['id']; ?>" 
               class="btn btn-danger btn-sm" 
               title="Supprimer"
               onclick="return confirm('Confirmer la suppression ?')">
              <i class="bi bi-trash3-fill"></i>
            </a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
  <a href="index.php" class="text-white text-decoration-none fw-bold">
    <i class="bi bi-arrow-left-circle-fill"></i> Retour au vote
  </a>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
