# Projekt PHP + MySQLi proceduralne: System informacji dla maturzystów (baza `matura`)

**Słowa kluczowe:** styl proceduralny, agregacja SQL (`DISTINCT`, `MIN`/`MAX`, `AVG`, `GROUP BY`, `LIMIT 1`), link z wieloma parametrami GET, `JOIN` po polu innym niż `id`.

Projekt uczy trzech wzorców w stylu proceduralnym: czterech niezależnych
bloków agregacji SQL (`DISTINCT`, `MIN`/`MAX`, `AVG` + `GROUP BY`), listy z
linkiem przenoszącym **kilka** parametrów GET naraz, oraz karty wyników
jednego ucznia złączonej `JOIN`-em po wspólnym polu `symbol`. Całość w
dwóch plikach: `index.php` i `wynik.php`.

## Struktura projektu

```text
07_projekt_matura/
├── 01_statystyki_matur_agregacja/   -> 4 bloki: DISTINCT, MIN/MAX, AVG
├── 02_lista_maturzystow_get_linki/  -> lista T3 + link z 3 parametrami GET
├── 03_szczegoly_wynikow_get_join/   -> GET + JOIN po symbol
├── index.php                        -> lista maturzystów + statystyki
└── wynik.php                        -> karta wyników ucznia + te same statystyki
```

Obie strony (`index.php` i `wynik.php`) same łączą się z bazą `matura`
funkcją `mysqli_connect` i same zamykają połączenie `mysqli_close($conn)`
(styl proceduralny, jak w projekcie zgłoszeń).

---

## Ściągawka wzorców

### 1. Cztery bloki statystyk (agregacja SQL)

```php
// Unikalne przedmioty / lata — DISTINCT usuwa duplikaty
$przedmioty = mysqli_query($conn, "SELECT DISTINCT przedmiot FROM arkusz");

// Najlepszy i najgorszy pojedynczy wynik
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MIN(wynik) AS min, MAX(wynik) AS max FROM arkusz"));

// Przedmiot z najwyższą średnią — GROUP BY + ORDER BY + LIMIT 1
$query = "SELECT przedmiot, ROUND(AVG(wynik), 2) AS srednia
          FROM arkusz
          GROUP BY przedmiot
          ORDER BY srednia DESC
          LIMIT 1";
$najlepszy = mysqli_fetch_assoc(mysqli_query($conn, $query));
// ten sam wzorzec z ORDER BY ... ASC daje przedmiot z najniższą średnią
```

Cztery bloki to w istocie dwa mechanizmy: `DISTINCT` do listy unikalnych
wartości oraz `GROUP BY` + `AVG` + `ORDER BY` + `LIMIT 1`, żeby z wielu
średnich (po jednej na przedmiot) wyciągnąć tylko jedną — najwyższą albo
najniższą, zależnie od kierunku sortowania.

→ Pełne wytłumaczenie: [`01_statystyki_matur_agregacja/README.md`](./01_statystyki_matur_agregacja/README.md)

### 2. Lista maturzystów z linkiem o wielu parametrach GET

```php
$query = "SELECT id, imie, nazwisko FROM maturzysci WHERE szkola = 'T3' ORDER BY nazwisko";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<a href='wynik.php?id=" . $row['id']
       . "&imie=" . $row['imie']
       . "&nazwisko=" . $row['nazwisko'] . "'>"
       . $row['imie'] . " " . $row['nazwisko'] . "</a>";
}
```

W odróżnieniu od projektów z jednym `?id=X`, tu link niesie od razu trzy
wartości połączone znakiem `&`. Dzięki temu `wynik.php` ma imię i nazwisko
gotowe do wyświetlenia bez dodatkowego zapytania do bazy.

→ Pełne wytłumaczenie: [`02_lista_maturzystow_get_linki/README.md`](./02_lista_maturzystow_get_linki/README.md)

### 3. Karta wyników ucznia (GET + JOIN po `symbol`)

```php
$id = $_GET['id'];
echo "<h2>" . $_GET['imie'] . " " . $_GET['nazwisko'] . "</h2>";

$query = "SELECT arkusz.rok, arkusz.sesja, arkusz.przedmiot, arkusz.wynik
          FROM wyniki
          JOIN arkusz ON wyniki.symbol = arkusz.symbol
          WHERE wyniki.maturzysta_id = $id";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<h3>" . $row['rok'] . " – " . $row['sesja'] . "</h3>";
    echo "<p>" . $row['przedmiot'] . ": " . $row['wynik'] . "</p>";
}
```

Imię i nazwisko do `<h2>` biorą się wprost z GET (przekazane linkiem z
modułu 2, bez ponownego zapytania). Wyniki poszczególnych arkuszy łączone
są przez wspólne pole `symbol`, a nie przez typowe `id` — to na co warto
zwrócić uwagę przy czytaniu tego JOIN-a.

→ Pełne wytłumaczenie: [`03_szczegoly_wynikow_get_join/README.md`](./03_szczegoly_wynikow_get_join/README.md)

---

## Tabela referencyjna

| Plik / moduł                     | Kluczowa funkcja                                        | Do czego służy                    |
| -------------------------------- | ------------------------------------------------------- | --------------------------------- |
| Połączenie                       | `mysqli_connect`, `mysqli_close`                        | Baza `matura`, styl proceduralny  |
| `01_statystyki_matur_agregacja`  | `DISTINCT`, `MIN`/`MAX`, `AVG` + `GROUP BY` + `LIMIT 1` | 4 bloki statystyk na obu stronach |
| `02_lista_maturzystow_get_linki` | link z kilkoma parametrami GET (`&`)                    | Lista maturzystów w `index.php`   |
| `03_szczegoly_wynikow_get_join`  | `$_GET`, `JOIN` po `symbol`                             | Karta wyników w `wynik.php`       |
