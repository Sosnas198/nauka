<?php
// Skrypt #1
if (isset($_POST["login"]) && isset($_POST["haslo"]) && isset($_POST["haslo2"])) {
    if (!empty($_POST["login"]) && !empty($_POST["haslo"]) && !empty($_POST["haslo2"])) {
        $login = $_POST["login"];
        $haslo = $_POST["haslo"];
        $haslo2 = $_POST["haslo2"];
        $istniejelogin = false;
        $conn = new mysqli("localhost", "root", "", "psy");

        $sql = "SELECT login FROM uzytkownicy;";
        $result = $conn->query($sql);

        while ($row = $result->fetch_array()) {
            if ($login == $row[0]) {
                echo "<p>login występuje w bazie danych, konto nie zostało dodane</p>";
                $istniejelogin = true;
            }
        }
        if ($istniejelogin == false) {
            if ($haslo == $haslo2) {
                $hash = sha1($haslo);
                $sql = "INSERT INTO uzytkownicy VALUES (NULL, '$login', '$hash');";
                $result = $conn->query($sql);
                echo "<p>Konto zostało dodane</p>";
            } else {
                echo "<p>hasła nie są takie same, konto nie zostało dodane</p>";
            }
        }

        $conn->close();
    } else {
        echo "<p>wypełnij wszystkie pola</p>";
    }
}
