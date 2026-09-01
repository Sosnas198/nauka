# Projekt PHP + MySQLi: Biblioteka szkolna (baza `biblioteka`)

**Słowa kluczowe:** `ORDER BY RAND() LIMIT`, `htmlspecialchars`, kod PHP osadzony wewnątrz `<table>`, jeden skrypt bez podziału na moduły.

Najprostszy z projektów — jeden skrypt, jedna tabela z losowymi
propozycjami książek. Wart uwagi ze względu na `htmlspecialchars()`
(zabezpieczenie wyjścia HTML) i sposób osadzenia PHP wprost w środku
tabeli. Całość w jednym pliku: `biblioteka_szkolna.php`.

## Struktura projektu

```text
18_projekt_biblioteka_szkolna/
├── 01_losowe_propozycje_ksiazek/  -> jedyny moduł: cała logika strony
└── biblioteka_szkolna.php         -> STRONA: losowe propozycje książek
```

Ten projekt ma tylko jeden moduł — oryginalne zadanie opisywało jeden
skrypt, więc nie ma tu podziału na kilka podfolderów jak w innych
projektach. W module README rozbite jest to jednak na kroki SEC-1 do
SEC-5, żeby prześledzić kolejność działań.

`biblioteka_szkolna.php` sam otwiera i zamyka połączenie z bazą
`biblioteka` przez `new mysqli(...)` → obiekt `$polaczenie`.

---

## Ściągawka wzorca

### Losowe propozycje książek (RAND + htmlspecialchars)

```php
$polaczenie = new mysqli("localhost", "root", "", "biblioteka");

$sql = "SELECT autor, tytul, kod FROM ksiazki ORDER BY RAND() LIMIT 5";
$result = $polaczenie->query($sql);

echo "<table>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['autor']) . "</td>";
    echo "<td>" . htmlspecialchars($row['tytul']) . "</td>";
    echo "<td>" . $row['kod'] . "</td>";
    echo "</tr>";
}
echo "</table>";

$polaczenie->close();
```

Kod PHP jest wpisany wprost pomiędzy `<table>` a `</table>` — kolejne
`<tr>` "dopisują się" do tabeli w locie, w trakcie działania pętli
`while`. `htmlspecialchars()` zamienia znaki specjalne (`<`, `>`, `&`,
cudzysłowy) na ich bezpieczne odpowiedniki HTML, zanim tekst z bazy
trafi na stronę — bez tego tytuł zawierający np. `<` mógłby zepsuć
strukturę HTML.

→ Pełne wytłumaczenie: [`01_losowe_propozycje_ksiazek/README.md`](./01_losowe_propozycje_ksiazek/README.md)

---

## Tabela referencyjna

| Element      | Kluczowa funkcja                  | Do czego służy                            |
| ------------ | --------------------------------- | ----------------------------------------- |
| Połączenie   | `new mysqli(...)` → `$polaczenie` | Styl obiektowy                            |
| Zapytanie    | `ORDER BY RAND() LIMIT 5`         | 5 losowych książek                        |
| Wyświetlanie | `htmlspecialchars()`              | Bezpieczne wypisanie tekstu z bazy w HTML |
