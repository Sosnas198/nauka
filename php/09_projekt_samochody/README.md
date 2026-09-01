# Projekt PHP + MySQLi obiektowe: Samochody (baza `samochody`)

Projekt uczy dwóch wzorców w stylu **obiektowym** (`$conn->query()`,
`$result->fetch_assoc()`, `$conn->close()` — nie `mysqli_query($conn, ...)`):
tabeli modelu ze złączeniem kolorów i doliczoną dopłatą do ceny, oraz
losowania dwóch konfiguracji pojazdów przez `ORDER BY RAND() LIMIT 2`.
Całość w jednym pliku: `index.php`.

## Struktura projektu

```text
09_projekt_samochody/
├── 01_tabela_pojazdow_join/       -> INNER JOIN kolory + cena z dopłatą
├── 02_losowanie_konfiguracji_oop/ -> ORDER BY RAND() LIMIT 2
└── index.php                      -> STRONA SALONU: oba moduły
```

`index.php` sam otwiera i zamyka połączenie z bazą `samochody` (styl
obiektowy — inaczej niż w projektach zgłoszenia/matura/bazar).

---

## Ściągawka wzorców

### 1. Tabela modelu ze złączonym kolorem i ceną

```php
$query = "SELECT pojazdy.model, pojazdy.cena, kolory.nazwa AS kolor, kolory.doplata
          FROM pojazdy
          INNER JOIN kolory ON pojazdy.kolor = kolory.id
          WHERE pojazdy.model = 'alfa'";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $cenaCalkowita = $row['cena'] + $row['doplata'];
    echo "<tr><td>" . $row['model'] . "</td><td>" . $row['kolor'] . "</td>";
    echo "<td>" . $cenaCalkowita . " zł</td></tr>";
}
```

`INNER JOIN kolory ON pojazdy.kolor = kolory.id` dokłada nazwę koloru i
jego dopłatę do wiersza pojazdu. Cena całkowita (`cena` bazowa + `doplata`
za kolor) liczona jest dopiero w PHP, nie w samym zapytaniu SQL.

→ Pełne wytłumaczenie: [`01_tabela_pojazdow_join/README.md`](./01_tabela_pojazdow_join/README.md)

### 2. Losowa konfiguracja dwóch pojazdów

```php
$result = $conn->query("SELECT marka, model, cena FROM pojazdy ORDER BY RAND() LIMIT 2");

while ($row = $result->fetch_assoc()) {
    echo "<tr><td rowspan='2'>" . $row['cena'] . " zł</td></tr>";
    echo "<tr><td>" . $row['marka'] . "</td><td>" . $row['model'] . "</td></tr>";
}
```

`ORDER BY RAND()` tasuje wiersze losowo przy każdym odświeżeniu strony,
`LIMIT 2` bierze z tego tylko dwa pierwsze — czyli dwa losowe pojazdy.
Cena każdego z nich wyświetlana jest w komórce z `rowspan`, rozciągniętej
na dwa wiersze marki i modelu tego samego auta.

→ Pełne wytłumaczenie: [`02_losowanie_konfiguracji_oop/README.md`](./02_losowanie_konfiguracji_oop/README.md)

---

## Tabela referencyjna

| Plik / moduł                    | Kluczowa funkcja                        | Do czego służy                |
| ------------------------------- | --------------------------------------- | ----------------------------- |
| Połączenie                      | `new mysqli(..., "samochody")`          | Styl obiektowy                |
| `01_tabela_pojazdow_join`       | `INNER JOIN`, `cena + doplata` w PHP    | Tabela modelu alfa z kolorami |
| `02_losowanie_konfiguracji_oop` | `ORDER BY RAND()`, `LIMIT 2`, `rowspan` | Dwie losowe konfiguracje      |
