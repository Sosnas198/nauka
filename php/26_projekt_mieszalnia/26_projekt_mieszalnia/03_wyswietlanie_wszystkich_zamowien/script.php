<?php
// Ta część kodu odpowiada gałęzi "else" z oryginalnego skryptu
// (patrz moduł 02_wyszukiwanie_zamowien_wg_dat - tam jest warunek "if")

// [ZOBACZ W README: SEC-1]
$sql = "SELECT nazwisko, imie, zamowienia.id, kod_koloru, pojemnosc, data_odbioru FROM klienci JOIN zamowienia ON klienci.id = id_klienta ORDER BY data_odbioru;";
$result = $conn->query($sql);

// [ZOBACZ W README: SEC-2]
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["nazwisko"] . "</td>";
    echo "<td>" . $row["imie"] . "</td>";
    echo "<td style='background-color: #".$row["kod_koloru"].";'>" . $row["kod_koloru"] . "</td>";
    echo "<td>" . $row["pojemnosc"] . "</td>";
    echo "<td>" . $row["data_odbioru"] . "</td>";
    echo "</tr>";
}
