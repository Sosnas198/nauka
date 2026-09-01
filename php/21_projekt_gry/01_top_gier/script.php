<?php
    // Skrypt #1
    $sql = "SELECT nazwa, punkty FROM gry ORDER BY punkty DESC LIMIT 5;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li>" . $row["nazwa"] . " <span class='pkt'>" . $row["punkty"] . "</span></li>";
        }
        echo "</ul>";
    }
    else {
        echo "0 results";
    }
?>
