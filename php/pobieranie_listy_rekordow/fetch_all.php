<?php
// UNIWERSALNY WZORZEC: Wyświetlanie listy rekordów w pętli

$query = "SELECT * FROM aktorzy ORDER BY nazwisko ASC, imie ASC;";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $id = $row['id_aktora'];
    $imie = $row['imie'];
    $nazwisko = $row['nazwisko'];
    $avatar = $row['plik_awatara'];

    // Wyświetlanie karty pojedynczego rekordu
    echo "<div>";
    echo "<a href='aktor.php?id=" . $id . "'>";
    echo "<img src='" . $avatar . "' alt='" . $imie . " " . $nazwisko . "'>";
    echo "<p>" . $imie . " " . $nazwisko . "</p>";
    echo "</a>";
    echo "</div>";
}
