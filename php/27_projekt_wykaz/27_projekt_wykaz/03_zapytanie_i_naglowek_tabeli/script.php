<?php
// [ZOBACZ W README: SEC-1]
$sql = "SELECT miasta.nazwa AS miasta_nazwa, wojewodztwa.nazwa AS wojewodztwa_nazwa FROM miasta JOIN wojewodztwa ON wojewodztwa.id = id_wojewodztwa WHERE miasta.nazwa LIKE '$miasto%' ORDER BY miasta.nazwa;";
$result = $conn->query($sql);

// [ZOBACZ W README: SEC-2]
echo "<table>";
    echo "<tr>";
        echo "<th>Miasto</th>";
        echo "<th>Województwo</th>";
    echo "</tr>";
