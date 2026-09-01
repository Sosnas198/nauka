<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>WOLONTARIAT SZKOLNY</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <header>
            <h1>KONKURS - WOLONTARIAT SZKOLNY</h1>
        </header>
        <div id="lewy">
            <h3>Konkursowe nagrody</h3>
            <button onclick="location.reload()">Losuj nowe nagrody</button>
            <table>
                <thead>
                    <tr>
                        <th>Nr</th>
                        <th>Nazwa</th>
                        <th>Opis</th>
                        <th>Wartość</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Skrypt #1
                        $conn = new mysqli(hostname: "localhost",username: "root",password: "",database: "konkurs");
                        $sql = "SELECT nazwa, opis, cena FROM nagrody ORDER BY RAND() LIMIT 5;";
                        $result = $conn -> query($sql);
                        $i = 1;
                        while ($row = $result -> fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                                echo "<td>" . $row["nazwa"] . "</td>";
                                echo "<td>" . $row["opis"] . "</td>";
                                echo "<td>" . $row["cena"] . "</td>";
                            echo "</tr>";
                            $i++;
                        }
                        $conn -> close();
                    ?>
                </tbody>
            </table>
        </div>
        <div id="prawy">
            <img src="puchar.png" alt="Puchar dla wolontariusza">
            <h4>Polecane linki</h4>
            <ul>
                <li><a href="kw1.png">Kwerenda1</a></li>
                <li><a href="kw2.png">Kwerenda2</a></li>
                <li><a href="kw3.png">Kwerenda3</a></li>
                <li><a href="kw4.png">Kwerenda4</a></li>
            </ul>
        </div>
        <footer>
            Numer zdającego: <a href="https://ee-informatyk.pl/" target="_blank" style="text-decoration: none;color: unset;">EE-Informatyk.pl</a>
        </footer>
    </body>
</html>
