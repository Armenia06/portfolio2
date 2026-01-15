<?php
require "connexionBDD.php";

if (isset($_POST["ajouter"])) {
    $titre = trim($_POST["titre"]);
    $created_at = $_POST["created_at"];
    $synopsis = trim($_POST["synopsis"]);
    $images = $_POST["images"];

    if (!empty($titre) && !empty($created_at) && !empty($synopsis) && !empty($images)) {
        $conn = connectBDD();

        // Sécurité : on échappe les données avant insertion
        $titre = mysqli_real_escape_string($conn, $titre);
        $created_at = mysqli_real_escape_string($conn, $created_at);
        $synopsis = mysqli_real_escape_string($conn, $synopsis);
        $images = mysqli_real_escape_string($conn, $images);

        $a = mysqli_query($conn, "INSERT INTO films (titre, created_at, synopsis,images)
                VALUES ('$titre', '$created_at', '$synopsis','$images')");

        closeBDD($conn);
        header("Location: ../admin.php");
        exit;
    }
}
?>
