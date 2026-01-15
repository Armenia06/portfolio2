<?php
function connectBDD()
{
    $conn = mysqli_connect("127.0.0.1", "root", "", "vote");
    mysqli_set_charset($conn, "utf8");
    return $conn;
}

function closeBDD($conn)
{
    mysqli_close($conn);
}

function listFilms()
{
    $conn = connectBDD();
    $q = mysqli_query($conn, "SELECT * FROM films
    ");
    $res = [];
    while ($data = mysqli_fetch_array($q)) {
        array_push($res, $data);
    }
    closeBDD($conn);
    return $res;
}