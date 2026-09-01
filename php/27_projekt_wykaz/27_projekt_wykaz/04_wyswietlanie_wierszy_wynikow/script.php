<?php
// [ZOBACZ W README: SEC-1]
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
        echo "<td>".$row['miasta_nazwa']."</td>";
        echo "<td>".$row['wojewodztwa_nazwa']."</td>";
    echo "</tr>";
}

// [ZOBACZ W README: SEC-2]
echo "</table>";
