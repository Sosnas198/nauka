<?php
    // Skrypt #2
    if (isset($_POST['losuj'])) {
        $sql = "SELECT pseudonim, klasa FROM zawodnicy ORDER BY RAND() LIMIT 2;";
        $result = $conn->query($sql);
        echo "<h4>";
        while ($row = $result->fetch_assoc()) {
            echo $row["pseudonim"]." ".$row['klasa']." ";
        }
        echo "</h4>";
    }
?>
