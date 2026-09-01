# Kompletny przewodnik: Wyświetlanie katalogu wszystkich gier (obrazy z podpowiedzią)

Ten przewodnik tłumaczy **od A do Z**, jak Skrypt #2 pobiera z bazy danych **wszystkie gry** i wyświetla każdą z nich jako blok z obrazkiem i nazwą.

---

## 🎯 Cel skryptu

Pobrać z tabeli `gry` **wszystkie** rekordy (bez limitu) i dla każdego wypisać blok `<div>` zawierający: obrazek gry, jego tekst alternatywny, podpowiedź (dymek) z numerem `id`, oraz paragraf z nazwą gry.

> ℹ️ **Uwaga:** Ten skrypt korzysta ze zmiennej `$conn` (połączenia z bazą danych), która jest tworzona raz na początku głównego pliku projektu i współdzielona przez wszystkie skrypty.

---

## SEC-1: Pobranie wszystkich gier z bazy danych

```php
$sql = "SELECT id, nazwa, zdjecie FROM gry;";
$result = $conn->query($sql);
```

### Jak to działa?

- **`SELECT id, nazwa, zdjecie FROM gry;`** — pobieramy trzy kolumny z tabeli `gry`: `id` (unikalny numer gry), `nazwa` (tytuł gry) i `zdjecie` (nazwa pliku graficznego). W odróżnieniu od Skryptu #1, tutaj **nie ma** `ORDER BY` ani `LIMIT` — pobieramy komplet wszystkich gier, w kolejności, w jakiej są zapisane w bazie.
- **`$conn->query($sql)`** — wysyłamy zapytanie, a wynik ląduje w `$result`.

---

## SEC-2: Sprawdzenie, czy są jakieś wyniki

```php
if ($result->num_rows > 0) {
    // ... (patrz SEC-3)
}
else {
    echo "0 results";
}
```

### Jak to działa?

- Dokładnie tak samo jak w Skrypcie #1: `$result->num_rows` mówi, ile wierszy zwróciło zapytanie. Jeśli tabela `gry` byłaby pusta, wypisujemy `"0 results"` zamiast pustej strony.

---

## SEC-3: Wypisanie każdej gry jako bloku z obrazkiem (`while` + `fetch_assoc`)

```php
while($row = $result->fetch_assoc()) {
    echo "<div class='gra'>";
        echo "<img src='" . $row["zdjecie"] . "' alt='" . $row["nazwa"] . "' title='" . $row['id'] . "'>";
        echo "<p>" . $row["nazwa"] . "</p>";
    echo "</div>";
}
```

### Jak to działa?

- **`while($row = $result->fetch_assoc())`** — pętla pobierająca kolejno każdy wiersz wyniku (każdą grę) jako tablicę asocjacyjną.
- **`echo "<div class='gra'>";`** — dla każdej gry tworzymy osobny kontener `<div>` z klasą CSS `gra` (dzięki niej można później nadać każdemu "kafelkowi" gry wspólny styl w `styl.css` — np. ramkę, szerokość, odstępy).
- **`<img src='" . $row["zdjecie"] . "' ...>`** — tworzymy znacznik obrazka:
  - **`src="..."`** — źródło obrazka to wartość pola `zdjecie` z bazy danych (czyli np. nazwa pliku `mario.png`).
  - **`alt="..."`** — tekst alternatywny (wyświetlany, gdyby obrazek się nie załadował, czytany też przez czytniki ekranu dla osób niewidomych) to nazwa gry.
  - **`title="..."`** — to atrybut, który powoduje wyświetlenie **dymka z podpowiedzią** po najechaniu myszką na obrazek. Tutaj ustawiamy go na `id` gry — czyli po najechaniu na obrazek zobaczysz jego numer identyfikacyjny w bazie. To właśnie ta "podpowiedź" wspomniana w treści zadania.
- **`<p>" . $row["nazwa"] . "</p>`** — pod obrazkiem wypisujemy paragraf z nazwą gry.
- **`echo "</div>";`** — zamykamy kontener danej gry.
- Cała pętla powtarza się dla **każdej** gry w bazie, tworząc siatkę/listę kafelków w sekcji `<main>`.

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Atrybut**  | **Co oznacza / Co robi?**                                                                 |
| ------------------------ | -------------------------------------------------------------------------------------- |
| `SELECT kol1, kol2 FROM tabela` | Pobiera wskazane kolumny ze wszystkich wierszy tabeli (bez sortowania/limitu = wszystkie rekordy). |
| `src` (w `<img>`)         | Wskazuje plik graficzny, który ma się wyświetlić.                                        |
| `alt` (w `<img>`)         | Tekst zastępczy/opisowy obrazka — ważny dla dostępności strony.                          |
| `title` (w `<img>`)       | Tworzy "dymek" z podpowiedzią widoczny po najechaniu myszką na element.                  |
| `class='gra'`             | Klasa CSS nadana każdemu blokowi gry, żeby móc je wspólnie stylować w arkuszu CSS.       |
