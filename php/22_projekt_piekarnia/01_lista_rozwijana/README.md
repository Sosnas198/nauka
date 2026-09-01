# Kompletny przewodnik: Wypełnianie listy rozwijanej unikalnymi wartościami z bazy danych

Ten przewodnik tłumaczy **od A do Z**, jak Skrypt #1 pobiera z bazy danych wszystkie **unikalne** rodzaje wypieków i wypełnia nimi listę rozwijaną (`<select>`) w formularzu.

---

## 🎯 Cel skryptu

Pobrać z tabeli `wyroby` każdy **rodzaj** wypieku **tylko raz** (bez powtórzeń), posortowany malejąco alfabetycznie, i wygenerować dla każdego z nich osobną opcję (`<option>`) w liście rozwijanej.

> ℹ️ **Uwaga:** Ten skrypt korzysta ze zmiennej `$conn`, czyli połączenia z bazą danych. Połączenie to jest tworzone raz, na samej górze głównego pliku projektu (`$conn = new mysqli(hostname: "localhost", ..., database: "piekarnia");`) i jest wspólne dla obu skryptów w tym projekcie.

---

## SEC-1: Pobranie unikalnych rodzajów wypieków (`SELECT DISTINCT`)

```php
$sql = "SELECT DISTINCT Rodzaj FROM wyroby ORDER BY Rodzaj DESC;";
$result = $conn->query($sql);
```

### Jak to działa?

- **`SELECT DISTINCT Rodzaj FROM wyroby`** — słowo kluczowe **`DISTINCT`** jest tutaj najważniejsze. Bez niego zapytanie `SELECT Rodzaj FROM wyroby` zwróciłoby rodzaj wypieku dla **każdego** produktu z osobna — jeśli w tabeli jest 20 różnych rodzajów chleba, a każdy rodzaj ma po kilka produktów (np. różne gramatury), otrzymalibyśmy wiele powtórzeń tego samego rodzaju. `DISTINCT` sprawia, że każda **unikalna** wartość z kolumny `Rodzaj` pojawi się w wyniku **tylko raz**.
- **`ORDER BY Rodzaj DESC`** — sortuje wynikowe rodzaje **malejąco** (alfabetycznie od Z do A). Słowo `DESC` oznacza *descending* (malejąco).
- **`$conn->query($sql)`** — wysyła zapytanie do bazy danych, a wynik (lista unikalnych rodzajów) trafia do `$result`.

---

## SEC-2: Wypełnienie listy rozwijanej opcjami (`while` + `fetch_assoc`)

```php
while($row = $result->fetch_assoc()) {
    echo "<option value='" . $row["Rodzaj"] . "'>" . $row["Rodzaj"] . "</option>";
}
```

### Jak to działa?

- **`while($row = $result->fetch_assoc())`** — pętla pobierająca kolejno każdy wiersz wyniku (czyli każdy unikalny rodzaj wypieku) jako tablicę asocjacyjną, z kluczem będącym nazwą kolumny (`$row["Rodzaj"]`).
- **`<option value='...'>...</option>`** — to pojedyncza opcja listy rozwijanej HTML:
  - **`value='" . $row["Rodzaj"] . "'`** — wartość, która zostanie **wysłana do serwera** po zaznaczeniu tej opcji i wysłaniu formularza (to właśnie ta wartość trafi później do `$_POST["rodzaj"]` w Skrypcie #2).
  - **`" . $row["Rodzaj"] . "`** (między `>` a `</option>`) — to tekst **widoczny dla użytkownika** na liście rozwijanej. W tym przypadku jest identyczny jak `value`, więc użytkownik widzi dokładnie taką nazwę rodzaju, jaka zostanie wysłana do serwera.
- Ta pętla powtarza się dla **każdego** unikalnego rodzaju, budując kompletną listę opcji wewnątrz znacznika `<select name="rodzaj" id="rodzaj">` z głównego pliku strony.

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**       | **Co oznacza / Co robi?**                                                              |
| ---------------------------- | ----------------------------------------------------------------------------------------|
| `SELECT DISTINCT kolumna`     | Pobiera wartości z kolumny, usuwając duplikaty — każda unikalna wartość pojawia się raz. |
| `ORDER BY kolumna DESC`       | Sortuje wynik malejąco (Z-A dla tekstu, od największej do najmniejszej dla liczb).       |
| `fetch_assoc()`                | Pobiera jeden wiersz wyniku jako tablicę z kluczami-nazwami kolumn.                       |
| `<option value='...'>tekst</option>` | Pojedyncza opcja listy rozwijanej — `value` to co zostanie wysłane, tekst to co widzi użytkownik. |
