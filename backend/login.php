<?php
require "connexionBDD.php";
session_start();

if (isset($_POST['submit'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $pass = isset($_POST['mdp']) ? $_POST['mdp'] : '';

    if (empty($email) || empty($pass)) {
        echo "<script>alert('Veuillez remplir tous les champs'); window.location.href = '../connexion.php';</script>";
        exit();
    }

    $conn = connectBDD();

    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT * FROM utilisateurs WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        if (password_verify($pass, $data['mdp'])) {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $data['role'];

            $redirectPage = ($data['role'] === 'admin') ? '../admin.php' : '../index.php';
            echo "<script>window.location.href = '$redirectPage';</script>";
            exit();
        } else {
            echo "<script>alert('Mot de passe incorrect'); window.location.href = '../connexion.php';</script>";
        }
    } else {
        echo "<script>alert('Email introuvable'); window.location.href = '../connexion.php';</script>";
    }

    mysqli_close($conn);
}
?>
