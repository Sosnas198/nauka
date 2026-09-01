<?php
// [ZOBACZ W README: SEC-1]
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // [ZOBACZ W README: SEC-2]
    $nazwisko = $_POST['nazwisko'];
    $imie = $_POST['imie'];
    $funkcja = $_POST['funkcja'];
    $email = $_POST['email'];

    // Skrypt - dodawanie
    // [ZOBACZ W README: SEC-3]
    $sql = "INSERT INTO osoby VALUES (NULL, '$nazwisko', '$imie', '$funkcja', '$email');";
    $result = $conn->query(query: $sql);
}
