<?php
    // Skrypt #1
    $sql = "SELECT DISTINCT Rodzaj FROM wyroby ORDER BY Rodzaj DESC;";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["Rodzaj"] . "'>" . $row["Rodzaj"] . "</option>";
    }
?>
