# Projekt PHP + MySQLi obiektowe: Opony (baza `opony`)

**Słowa kluczowe:** automatyczne odświeżanie strony (`header("Refresh")`), `ORDER BY` + `LIMIT`, ikona zależna od wartości (`if`), stały filtr `WHERE`, `JOIN ... USING`, losowanie (`RAND()`), obliczenia w PHP (`ilość * cena`).

Projekt uczy trzech wzorców: listy najtańszych produktów z ikoną zależną
od kategorii, pobrania jednego stałego rekordu po ustalonym kluczu oraz
losowego zamówienia łączonego `JOIN`-em, gdzie wartość liczona jest w PHP.
Całość odświeża się automatycznie co 10 sekund. Wszystko w jednym pliku:
`index.php`.

## Struktura projektu

```text
11_projekt_opony/
├── 01_lista_opon_sezony/   -> 10 najtańszych opon + ikona sezonu
├── 02_opona_dnia/          -> stały rekord (nr_kat = 9)
├── 03_zamowienie_opon/     -> JOIN USING + RAND() + ilość × cena
└── index.php               -> STRONA SKLEPU: wszystkie 3 moduły
```

`index.php` sam otwiera i zamyka połączenie z bazą `opony` (styl
obiektowy). Na samej górze pliku, **przed jakimkolwiek HTML-em**, stoi
`header("Refresh: 10;")` — nagłówki HTTP trzeba wysłać zanim cokolwiek
innego trafi na wyjście.

---

## Ściągawka wzorców

### 1. Automatyczne odświeżanie + lista najtańszych opon

```php
header("Refresh: 10;");
// ... dopiero potem $conn = new mysqli(...) i reszta HTML

$result = $conn->query("SELECT * FROM opony ORDER BY cena LIMIT 10");

while ($row = $result->fetch_assoc()) {
    if ($row['sezon'] == "lato") {
        $ikona = "lato.png";
    } elseif ($row['sezon'] == "zima") {
        $ikona = "zima.png";
    } else {
        $ikona = "uniwer.png";
    }

    echo "<div class='opona'><h4>" . $row['nazwa'] . "</h4><h3>" . $row['cena'] . " zł</h3>";
    echo "<img src='" . $ikona . "'></div>";
}
```

`header("Refresh: 10;")` każe przeglądarce przeładować całą stronę co 10
sekund — musi wystartować przed pierwszym `echo` czy tagiem HTML, inaczej
PHP zgłosi błąd "headers already sent". `ORDER BY cena LIMIT 10` daje
dziesięć najtańszych opon, a `if/elseif/else` na polu `sezon` dobiera
odpowiednią ikonę.

→ Pełne wytłumaczenie: [`01_lista_opon_sezony/README.md`](./01_lista_opon_sezony/README.md)

### 2. Opona dnia (stały rekord)

```php
$row = $conn->query("SELECT * FROM opony WHERE nr_kat = 9")->fetch_assoc();

echo "<h2>" . $row['nazwa'] . "</h2>";
echo "<h2>" . $row['cena'] . " zł</h2>";
echo "<h2>" . $row['sezon'] . "</h2>";
```

Zamiast filtrować po parametrze z URL czy formularza, kod ma na sztywno
wpisane `WHERE nr_kat = 9` — zawsze wyświetla tę samą, jedną, wybraną z
góry oponę.

→ Pełne wytłumaczenie: [`02_opona_dnia/README.md`](./02_opona_dnia/README.md)

### 3. Losowe zamówienie (JOIN USING + RAND())

```php
$query = "SELECT opony.nazwa, opony.cena, zamowienia.ilosc
          FROM opony
          JOIN zamowienia USING (nr_kat)
          ORDER BY RAND()
          LIMIT 1";

$row = $conn->query($query)->fetch_assoc();
$wartosc = $row['ilosc'] * $row['cena'];

echo $row['nazwa'] . ": " . $wartosc . " zł";
```

`JOIN ... USING (nr_kat)` to skrócona forma `JOIN ... ON a.nr_kat =
b.nr_kat`, dostępna gdy obie tabele mają kolumnę o tej samej nazwie.
`ORDER BY RAND() LIMIT 1` losuje jedno zamówienie spośród wszystkich —
dzięki automatycznemu odświeżaniu strony co 10 sekund, za każdym razem
pokazuje się inne. Wartość zamówienia (`ilość × cena`) liczona jest w PHP.

→ Pełne wytłumaczenie: [`03_zamowienie_opon/README.md`](./03_zamowienie_opon/README.md)

---

## Tabela referencyjna

| Plik / moduł             | Kluczowa funkcja                                 | Do czego służy                          |
| ------------------------ | ------------------------------------------------ | --------------------------------------- |
| `header("Refresh: 10;")` | Odświeżanie strony, wywołane przed HTML          | Automatyczne losowanie na nowo co 10 s  |
| `01_lista_opon_sezony`   | `ORDER BY cena LIMIT 10`, `if/elseif` na sezonie | Lista najtańszych opon z ikoną          |
| `02_opona_dnia`          | `WHERE nr_kat = 9`                               | Zawsze ta sama, wybrana z góry opona    |
| `03_zamowienie_opon`     | `JOIN ... USING`, `RAND()`, `ilość * cena`       | Losowe zamówienie z wyliczoną wartością |
