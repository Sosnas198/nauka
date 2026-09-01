<?php
    $conn = new mysqli('localhost', 'root', '', 'gry');

    // Skrypt #4
    if (isset($_POST['dodaj'])) {
        $nazwa = trim($_POST['nazwa'] ?? '');
        $opis = trim($_POST['opis'] ?? '');
        $cena = trim($_POST['cena'] ?? '0');
        $zdjecie = trim($_POST['zdjecie'] ?? '');

        $stmt = $conn->prepare("INSERT INTO gry (nazwa, opis, punkty, cena, zdjecie) VALUES (?, ?, 0, ?, ?)");
        $stmt->bind_param("ssss", $nazwa, $opis, $cena, $zdjecie);
        $stmt->execute();
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gry komputerowe</title>
        <link rel="stylesheet" href="styl.css">
    </head>
    <body>
        <header>
            <h1>Ranking gier komputerowych</h1>
        </header>

        <div id="lewy">
            <h3>Top 5 gier w tym miesiącu</h3>
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
            <br>
            <h3>Nasz sklep</h3><br>
            <a href="http://sklep.gry.pl">Tu kupisz gry</a><br><br>
            <h3>Stronę wykonał</h3><br>
            <p><a href="https://ee-informatyk.pl" target="_blank">EE-Informatyk.pl</a></p>
        </div>

        <main>
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
        </main>

        <div id="prawy">
            <h3>Dodaj nową grę</h3>
            <form action="gry.php" method="post">
                <label for="nazwa">nazwa</label><br>
                <input type="text" name="nazwa" id="nazwa"><br>
                <label for="opis">opis</label><br>
                <input type="text" name="opis" id="opis"><br>
                <label for="cena">cena</label><br>
                <input type="text" name="cena" id="cena"><br>
                <label for="zdjecie">zdjecie</label><br>
                <input type="text" name="zdjecie" id="zdjecie"><br>
                <button type="submit" name="dodaj">DODAJ</button>
            </form>
        </div>

        <footer>
            <form action="gry.php" method="post">
                <input type="text" name="inputopis" id="inputopis">
                <button type="submit" name="pokazopis">Pokaż opis</button>
            </form>
            <?php
                // Skrypt #3
            if (isset($_POST['pokazopis'])) {
                $id = $_POST['inputopis'];
                if ($id !== false && $id !== null) {
                    $stmt = $conn->prepare("SELECT nazwa, LEFT(opis, 100) AS opis, punkty, cena FROM gry WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($row = $result->fetch_assoc()) {
                        echo "<h2>" . htmlspecialchars($row["nazwa"]) . ", " . (int)$row["punkty"] . " punktów, " . htmlspecialchars($row["cena"]) . " zł</h2>";
                        echo "<p>" . htmlspecialchars($row["opis"]) . "</p>";
                    } else {
                        echo "<p>Nie znaleziono gry.</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p>Podaj poprawne ID.</p>";
                }
            }
            ?>
        </footer>
    </body>
</html>

<?php
    $conn->close();
?>
