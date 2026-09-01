<?php
    // Skrypt #2
    if(isset($_POST["rodzaj"])) {
        $rodzaj = $_POST['rodzaj'];
        $sql = "SELECT Rodzaj, Nazwa, Gramatura, Cena FROM wyroby WHERE Rodzaj = '$rodzaj';";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
                echo "<td>" . $row["Rodzaj"] . "</td>";
                echo "<td>" . $row["Nazwa"] . "</td>";
                echo "<td>" . $row["Gramatura"] . "</td>";
                echo "<td>" . $row["Cena"] . "</td>";
            echo "</tr>";
        }
    }
?>
