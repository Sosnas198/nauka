<?php
    $conn = new mysqli("localhost","root","","baza");
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dane o zwierzętach</title>
        <link rel="stylesheet" href="styl3.css">
    </head>
    <body>
        <header>
            <h1>ATLAS ZWIERZĄT</h1>
        </header>
        <main>
            <h2>Gromady</h2>
            <ol>
                <li>Ryby</li>
                <li>Płazy</li>
                <li>Gady</li>
                <li>Ptaki</li>
                <li>Ssaki</li>
            </ol>
            <form action="index.php" method="post">
                <label for="gromada">Wybierz gromadę: </label> <input type="number" name="gromada" id="gromada"> <button type="submit" id="wyswietl" id="wyswietl">Wyświetl</button>
            </form>
        </main>
        <div id="lewy">
            <img src="zwierzeta.jpg" alt="dzikie zwierzęta">
        </div>
        <div id="srodek">
            <?php
                // Moduł 01: [SEC-1] Sprawdzenie, czy formularz został wysłany
                if(isset($_POST["gromada"])) {
                    $gromada = $_POST["gromada"];

                    // Moduł 01: [SEC-2] Wypisanie nazwy gromady w nagłówku h2
                    if($gromada == 1) {
                        echo "<h2>RYBY</h2>";
                    }
                    else if ($gromada == 2) {
                        echo "<h2>PŁAZY</h2>";
                    }
                    else if ($gromada == 3) {
                        echo "<h2>GADY</h2>";
                    }
                    else if ($gromada == 4) {
                        echo "<h2>PTAKI</h2>";
                    }
                    else if ($gromada == 5) {
                        echo "<h2>SSAKI</h2>";
                    }

                    // Moduł 01: [SEC-3] Zapytanie 1 zmodyfikowane — zwierzęta z wybranej gromady
                    $sql = "SELECT gatunek, wystepowanie FROM zwierzeta, gromady WHERE zwierzeta.Gromady_id = gromady.id AND gromady.id = $gromada;";
                    $result = $conn->query(query: $sql);

                    // Moduł 01: [SEC-4] Wypisanie wyników w formacie "gatunek, występowanie"
                    while($row = $result -> fetch_array()) {
                        echo $row["gatunek"].", ".$row["wystepowanie"]."<br>";
                    }
                }
            ?>
        </div>
        <div id="prawy">
            <h2>Wszystkie zwierzęta w bazie</h2>
            <?php
                // Moduł 02: [SEC-1] Zapytanie 2 — wszystkie zwierzęta z nazwą gromady
                $sql = "SELECT zwierzeta.id, zwierzeta.gatunek, gromady.nazwa FROM zwierzeta, gromady WHERE zwierzeta.Gromady_id = gromady.id;";
                $result = $conn->query(query: $sql);
                // Moduł 02: [SEC-2] Wypisanie rekordów w formacie "id. gatunek nazwa_gromady"
                while($row = $result -> fetch_array()) {
                    echo $row[0].". ".$row[1]." ".$row[2]."<br>";
                }
            ?>
        </div>
        <footer>
            <a href="https://atlas-zwierzat.pl" target="_blank">Poznaj inne strony o zwierzętach</a>, autor Atlasu zwierząt: <a href="https://ee-informatyk.pl/" target="_blank" style="text-decoration: none;color: unset;">EE-Informatyk.pl</a>
        </footer>
    </body>
</html>
<?php
    $conn -> close();
?>
