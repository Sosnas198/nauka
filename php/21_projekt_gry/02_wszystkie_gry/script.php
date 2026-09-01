<?php
    // Skrypt #2
    $sql = "SELECT id, nazwa, zdjecie FROM gry;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='gra'>";
                echo "<img src='" . $row["zdjecie"] . "' alt='" . $row["nazwa"] . "' title='" . $row['id'] . "'>";
                echo "<p>" . $row["nazwa"] . "</p>";
            echo "</div>";
        }
    }
    else {
        echo "0 results";
    }
?>
