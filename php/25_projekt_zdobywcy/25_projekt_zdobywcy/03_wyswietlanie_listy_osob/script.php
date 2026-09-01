<?php
// Skrypt - lista
// [ZOBACZ W README: SEC-1]
$sql = "SELECT nazwisko, imie, funkcja, email FROM osoby;";
$result = $conn -> query($sql);

// [ZOBACZ W README: SEC-2]
while ($row = $result -> fetch_assoc()) {
    $nazwisko = $row["nazwisko"];
    $imie = $row["imie"];
    $funkcja = $row["funkcja"];
    $email = $row["email"];

    // [ZOBACZ W README: SEC-3]
    echo "<tr>";
        echo "<th>$nazwisko</th>";
        echo "<th>$imie</th>";
        echo "<th>$funkcja</th>";
        echo "<th>$email</th>";
    echo "</tr>";
}
