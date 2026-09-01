<?php
// [ZOBACZ W README: SEC-1]
if (isset($_POST['wyszukaj'])) {
    // [ZOBACZ W README: SEC-2]
    $dataod = $_POST['dataod'];
    $datado = $_POST['datado'];

    // [ZOBACZ W README: SEC-3]
    $sql = "SELECT nazwisko, imie, zamowienia.id, kod_koloru, pojemnosc, data_odbioru FROM klienci JOIN zamowienia ON klienci.id = id_klienta WHERE data_odbioru >= '$dataod' AND data_odbioru <= '$datado' ORDER BY data_odbioru;";
    $result = $conn->query($sql);

    // [ZOBACZ W README: SEC-4]
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
}
