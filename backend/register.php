<?php
require "connexionBDD.php";
session_start();

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $mdp = trim($_POST['mdp']);

    if (empty($email) || empty($mdp)) {
        echo "<script>alert('Tous les champs sont obligatoires.'); window.location.href='../inscription.php';</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Adresse e-mail invalide.'); window.location.href='../inscription.php';</script>";
        exit();
    }


    $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);


    $conn = connectBDD();

    $email_safe = mysqli_real_escape_string($conn, $email);

    $check = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE email = '$email_safe'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Cet email est déjà utilisé'); window.location.href='../inscription.php';</script>";
        exit();
    }

    $mdpHash_safe = mysqli_real_escape_string($conn, $mdpHash);
    $sql = "INSERT INTO utilisateurs (email, mdp) VALUES ('$email_safe', '$mdpHash_safe')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['email'] = $email;
        echo "<script>alert('Inscription réussie !'); window.location.href='../connexion.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'inscription'); window.location.href='../inscription.php';</script>";
    }

    mysqli_close($conn);
}
?>
