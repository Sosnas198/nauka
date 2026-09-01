# Kompletny przewodnik: Skrypt 1 — cztery bloki statystyk (`DISTINCT`, `MIN`/`MAX`, `AVG`)

Ta ściąga wytłumaczy Ci **od A do Z** połączenie proceduralne z bazą `matura` oraz cztery niezależne zapytania agregujące w bloku drugim strony (`#drugi`).

Ten sam Skrypt 1 wklejasz na **`index.php` i `wynik.php`** (w kontrolce statystyki są na obu widokach).

---

## SEC-1: Połączenie — baza `matura`

```php
$conn = mysqli_connect("localhost", "root", "", "matura");
```

Na końcu pliku:

```php
mysqli_close($conn);
```

Host **localhost**, użytkownik **root**, puste hasło, baza **`matura`**. Funkcje proceduralne: `mysqli_query($conn, $sql)`, `mysqli_fetch_assoc($wynik)`.

Każdy z czterech bloków to osobne zapytanie i osobny wynik — nie mieszasz ich w jednej pętli.

---

## SEC-2: Blok „Przedmioty” — `SELECT DISTINCT`

```sql
SELECT DISTINCT przedmiot FROM arkusz;
```

**`DISTINCT`** usuwa powtórzenia: jeśli „matematyka” jest na wielu arkuszach, nazwa pojawi się **raz**.

Wiele wierszy → pętla. Arkusz: nazwy **oddzielone spacją**.

```php
$q = "SELECT DISTINCT przedmiot FROM arkusz";
$res = mysqli_query($conn, $q);
while ($row = mysqli_fetch_assoc($res)) {
    echo $row["przedmiot"] . " ";
}
```

Klucz tablicy: **`przedmiot`** (nazwa kolumny).

---

## SEC-3: Blok „Lata” — `MIN`, `MAX` i aliasy

```sql
SELECT MIN(rok) AS min_rok, MAX(rok) AS max_rok FROM arkusz;
```

- **`MIN(rok)`** — najmniejszy rok w tabeli arkuszy.
- **`MAX(rok)`** — największy rok.
- **`AS min_rok` / `AS max_rok`** — czytelne klucze w PHP: `$row["min_rok"]`, `$row["max_rok"]`.

To **jeden wiersz** (dwie liczby) — **bez** `while`:

```php
$row = mysqli_fetch_assoc($res);
echo $row["min_rok"] . " - " . $row["max_rok"];
```

Arkusz: lata **oddzielone myślnikiem** (w kontrolce spacje wokół `-`).

---

## SEC-4: Blok „Najlepszy wynik” — `AVG`, `GROUP BY`, `DESC LIMIT 1`

```sql
SELECT maturzysta_id, AVG(punkty) AS Wynik
FROM wynik
GROUP BY maturzysta_id
ORDER BY Wynik DESC
LIMIT 1;
```

| Fragment                 | Znaczenie                                                              |
| ------------------------ | ---------------------------------------------------------------------- |
| **`AVG(punkty)`**        | Średnia punktów **jednego** maturzysty (po wszystkich jego wierszach). |
| **`GROUP BY maturzysta_id`** | Najpierw grupuj po uczniu, potem licz średnią w grupie.            |
| **`AS Wynik`**           | Alias — w PHP **`$row["Wynik"]`** (wielka litera jak w SQL).           |
| **`ORDER BY Wynik DESC`**| Od najwyższej średniej.                                                |
| **`LIMIT 1`**            | Tylko zwycięzca — jeden wiersz.                                        |

Zaokrąglenie i znak `%` robi **PHP** (arkusz: wynik zaokrąglony ze znakiem %):

```php
echo round($row["Wynik"], 2) . "%";
```

**`round(..., 2)`** — dwa miejsca po przecinku. Potem doklejasz `"%"`.

---

## SEC-5: Blok „Najgorszy wynik” — to samo zapytanie, `ASC LIMIT 1`

Identyczny `SELECT` / `GROUP BY`, zmiana sortowania:

```sql
… ORDER BY Wynik ASC LIMIT 1
```

**`ASC`** — od najniższej średniej. Znów jeden wiersz i:

```php
echo round($row["Wynik"], 2) . "%";
```

Nie myl z `MIN(punkty)` na całej tabeli — tu liczy się **średnia per maturzysta**, a potem bierzesz skrajną grupę.

---

## SEC-6: Szablon HTML czterech bloków

Każda statystyka w `<div class="blok">` z nagłówkiem `<h4>`:

```php
echo "<div class='blok'>";
echo "<h4>Przedmioty</h4>";
// zapytanie + echo
echo "</div>";
```

Kolejność jak w arkuszu: Przedmioty → Lata → Najlepszy wynik → Najgorszy wynik.

---

# Podsumowanie przepływu danych

```text
DISTINCT przedmiot     → pętla, nazwy + spacja
MIN/MAX rok            → jeden wiersz, „min - max”
AVG … GROUP BY … DESC LIMIT 1 → round(..., 2) + "%"
AVG … GROUP BY … ASC  LIMIT 1 → round(..., 2) + "%"
```

---

# Ściągawka

| **Pojęcie**           | **Co robi?**                                          |
| --------------------- | ----------------------------------------------------- |
| **`DISTINCT`**        | Unikalne nazwy przedmiotów.                           |
| **`MIN` / `MAX`**     | Skrajne lata w jednej krotce.                         |
| **`AVG` + `GROUP BY`**| Średnia punktów każdego maturzysty.                   |
| **`DESC` / `ASC` + `LIMIT 1`** | Najlepszy albo najgorszy ze średnich.          |
| **`round(..., 2) . "%"`** | Zaokrąglenie i procent w PHP.                      |
| **`$row["Wynik"]`**   | Alias z SQL (wielkość liter jak w `AS Wynik`).        |

---

### Co dalej?

Statystyki są w bloku drugim. W bloku pierwszym na stronie głównej budujemy **listę linków** do `wynik.php`.

👉 **[Przejdź do Kroku 2: Lista maturzystów i GET](../02_lista_maturzystow_get_linki/README.md)**
