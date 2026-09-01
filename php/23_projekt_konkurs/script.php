<?php
    // Skrypt #1
    $conn = new mysqli(hostname: "localhost",username: "root",password: "",database: "konkurs");
    $sql = "SELECT nazwa, opis, cena FROM nagrody ORDER BY RAND() LIMIT 5;";
    $result = $conn -> query($sql);
    $i = 1;
    while ($row = $result -> fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $i . "</td>";
            echo "<td>" . $row["nazwa"] . "</td>";
            echo "<td>" . $row["opis"] . "</td>";
            echo "<td>" . $row["cena"] . "</td>";
        echo "</tr>";
        $i++;
    }
    $conn -> close();
?>
