<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Bebas Neue', sans-serif;
      background: linear-gradient(to right, #000000, #1a1a1a);
      color: #f5f5f5;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
    }
    .shadow-gold {
      box-shadow: 0 0 15px 3px #ffd700;
      border-radius: 0.5rem;
    }
    input, textarea, select {
    font-family: Arial, sans-serif !important;
    }
  </style>
</head>
<body>

  <div class="bg-dark p-4 shadow-gold" style="width: 360px;">
    <h2 class="text-center text-warning mb-4">Créer un compte</h2>
    <form method="POST" action="./backend/register.php" class="needs-validation" novalidate>
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control bg-secondary text-white border-warning" id="email" name="email" placeholder="exemple@mail.com" required>
        <div class="invalid-feedback">Veuillez entrer un email valide.</div>
      </div>

      <div class="mb-4">
        <label for="mdp" class="form-label">Mot de passe</label>
        <input type="password" class="form-control bg-secondary text-white border-warning" id="mdp" name="mdp" placeholder="Mot de passe" required>
        <div class="invalid-feedback">Veuillez entrer un mot de passe.</div>
      </div>

      <p>
        Continuer en tant qu'<a href="index.php" class="text-warning">invité</a>
      </p>

      <p>
        Vous avez déjà un compte ? <a href="connexion.php" class="text-warning">Connectez-vous</a>
      </p>

      <button type="submit" name="submit" class="btn btn-warning w-100 fw-bold">S'inscrire</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
