# Kompletny przewodnik: Skrypt 1 — `INNER JOIN`, cena całkowita i wiersze tabeli

Ta ściąga wytłumaczy Ci **od A do Z** połączenie obiektowe z bazą `samochody`, złączenie `pojazdy` z `kolory`, sumę **ceny i dopłaty** oraz wypisywanie kolejnych rekordów jako `<tr>`.

---

## SEC-1: Połączenie obiektowe — baza `samochody`

```php
$conn = new mysqli("localhost", "root", "", "samochody");
```

Albo ze zmiennymi:

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "samochody";
$conn = new mysqli($host, $user, $pass, $db);
```

Na **końcu** skryptu:

```php
$conn->close();
```

Zapytania: **`$conn->query($query)`**. Wiersz: **`$row = $result->fetch_assoc()`**.

To nie jest `mysqli_connect` / `mysqli_fetch_array` z projektu bazaru.

---

## SEC-2: Zapytanie — `INNER JOIN` i filtr `model = 'alfa'`

```sql
SELECT marka, model, cena, nazwa, doplata
FROM pojazdy
INNER JOIN kolory ON kolor = kolory.id
WHERE model = 'alfa';
```

- **`pojazdy.kolor`** — klucz obcy (numer koloru).
- **`kolory.id`** — klucz główny palety.
- **`ON kolor = kolory.id`** — dopasuj nazwę i dopłatę koloru do pojazdu. Kolumna `kolor` bez prefiksu tabeli pochodzi z `pojazdy` (w `kolory` analogiczna kolumna nazywa się `id`).
- **`nazwa` / `doplata`** — z tabeli `kolory`.
- **`WHERE model = 'alfa'`** — tylko ten model (cudzysłów: to tekst).

**`INNER JOIN`** zostawia wyłącznie pojazdy, które **mają** dopasowany kolor. Gdyby kolor był pusty, wiersz by zniknął (inaczej niż `LEFT JOIN` w projekcie zgłoszeń).

Wyników może być **wiele** (ta sama alfa w różnych kolorach) → pętla `while`.

---

## SEC-3: Cena całkowita — suma w PHP, czwarta kolumna

Arkusz: w **czwartej kolumnie** cena całkowita = suma **ceny z `pojazdy`** oraz **dopłaty z `kolory`**.

```php
$cena_calkowita = $row["cena"] + $row["doplata"];
```

To **dodawanie w PHP**, nie `SUM()` w SQL (to nie jest agregacja wielu wierszy). Każdy wiersz ma własną parę cena + dopłata.

Nie wypisujesz surowej `cena` jako ostatniej komórki — tam idzie **`$cena_calkowita`**.

---

## SEC-4: Układ komórek w wierszu tabeli

Kolejność w kontrolce (cztery `<td>`):

| Kolumna | Źródło                    |
| ------- | ------------------------- |
| 1       | `$row["marka"]`           |
| 2       | `$row["model"]`           |
| 3       | `$row["nazwa"]` (kolor)   |
| 4       | `$cena_calkowita`         |

```php
while ($row = $result->fetch_assoc()) {
    $cena_calkowita = $row["cena"] + $row["doplata"];
    echo "<tr>";
    echo "<td>" . $row["marka"] . "</td>";
    echo "<td>" . $row["model"] . "</td>";
    echo "<td>" . $row["nazwa"] . "</td>";
    echo "<td>" . $cena_calkowita . "</td>";
    echo "</tr>";
}
```

Znacznik `<table>` jest w HTML sekcji `#lewa`. PHP dopisuje **kolejne rekordy jako kolejne wiersze**.

---

# Podsumowanie przepływu danych

```text
new mysqli(..., "samochody")
                 ↓
INNER JOIN pojazdy + kolory  WHERE model = 'alfa'
                 ↓
while fetch_assoc
                 ↓
cena_calkowita = cena + doplata
                 ↓
<tr> marka | model | nazwa koloru | cena całkowita
```

---

# Ściągawka

| **Pojęcie**              | **Co robi?**                                      |
| ------------------------ | ------------------------------------------------- |
| **`new mysqli`**         | Połączenie obiektowe.                             |
| **`INNER JOIN kolory`**  | Dokleja nazwę i dopłatę koloru.                   |
| **`model = 'alfa'`**     | Filtr Skryptu 1.                                  |
| **`cena + doplata`**     | Cena całkowita (4. kolumna).                      |
| **`fetch_assoc`**        | Jeden wiersz jako tablica po nazwach kolumn.      |

---

### Co dalej?

Tabela alfa jest po lewej. Na środku **losujemy dwie** konfiguracje.

👉 **[Przejdź do Kroku 2: Losowanie RAND() LIMIT 2](../02_losowanie_konfiguracji_oop/README.md)**
