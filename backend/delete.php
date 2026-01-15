<?php
require "connexionBDD.php";

if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];
    $conn = connectBDD();
    $n = "DELETE FROM films WHERE id = $id";
    $result = mysqli_query($conn, $n);
    closeBDD($conn);
    header("Location: ../admin.php");
    exit;
}

?>