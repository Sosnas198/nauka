<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BIBLIOTEKA SZKOLNA</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <header>
            <h2>STRONA BIBLIOTEKI SZKOLNEJ WIEDZAMIN</h2>
        </header>
        <section>
            <h3>Nasze dzisiejsze propozycje:</h3>
            <table>
                <tr>
                    <th>Autor</th>
                    <th>Tytuł</th>
                    <th>Katalog</th>
                </tr>
                <?php
                    // Moduł 01: [SEC-1] Połączenie z bazą danych
                    $polaczenie = new mysqli("localhost", "root", "", "biblioteka");

                    // Moduł 01: [SEC-2] Zapytanie 4 — losowanie 5 książek
                    $sql = "SELECT autor, tytul, kod FROM ksiazki ORDER BY RAND() LIMIT 5";

                    // Moduł 01: [SEC-3] Wykonanie zapytania i sprawdzenie wyniku
                    if ($wynik = $polaczenie->query($sql)) {
                        // Moduł 01: [SEC-4] Pętla po wynikach i wypisanie wierszy tabeli
                        while ($rekord = $wynik->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($rekord["autor"]) . "</td>";
                            echo "<td>" . htmlspecialchars($rekord["tytul"]) . "</td>";
                            echo "<td>" . htmlspecialchars($rekord["kod"]) . "</td>";
                            echo "</tr>";
                        }
                        $wynik->free();
                    }
                    // Moduł 01: [SEC-5] Zamknięcie połączenia z bazą
                    $polaczenie->close();
                ?>
            </table>
        </section>
        <main>
            <article>
                <img src="ksiazka1.jpg" alt="okładka książki">
                <p>Według różnych podań najpaskudniejsza ropucha nosi w głowie piękny, cenny klejnot.</p>
            </article>
            <article>
                <img src="ksiazka2.jpg" alt="okładka książki">
                <p>Panna Stefcia i Maryla nie są to zbyt grzeczne damy, nawet nie słuchają mamy...</p>
            </article>
            <article>
                <img src="ksiazka3.jpg" alt="okładka książki">
                <p>Ratuj mnie, przyjacielu, w ostatniej potrzebie: Kocham piękną Irenę. Rodzice i ona...</p>
            </article>
        </main>
        <footer>
            <p>Stronę wykonał: <a href="https://ee-informatyk.pl/" target="_blank" style="text-decoration: none;color: unset;">EE-Informatyk.pl</a>
            </p>
        </footer>
    </body>
</html>
