# Kompletny przewodnik: Losowanie pary rekordów i wypisanie ich w jednym nagłówku

Ten przewodnik tłumaczy **od A do Z**, jak Skrypt #2 obsługuje przycisk "Losuj nową parę graczy" — losuje dwóch zawodników z bazy danych i wyświetla ich pseudonimy oraz klasy obok siebie, w jednym wspólnym nagłówku.

---

## 🎯 Cel skryptu

Po kliknięciu przycisku formularza, wylosować **dokładnie dwóch** zawodników z tabeli `zawodnicy` i wyświetlić oba pobrane rekordy (pseudonim + klasa każdego z nich) w nagłówku czwartego stopnia (`<h4>`), oddzielając poszczególne wartości spacją.

> ℹ️ **Uwaga:** Ten skrypt korzysta ze zmiennej `$conn` (połączenia z bazą danych), tworzonej raz na początku głównego pliku projektu.

---

## SEC-1: Sprawdzenie, czy kliknięto przycisk "Losuj" (`isset`)

```php
if (isset($_POST['losuj'])) {
    // ... (patrz SEC-2, SEC-3)
}
```

### Jak to działa?

- **`isset($_POST['losuj'])`** — sprawdza, czy w danych formularza istnieje klucz `losuj`. To nazwa przycisku formularza (`<input type="submit" ... id="losuj" name="losuj">`). PHP zapisuje ten klucz w `$_POST` **tylko wtedy**, gdy formularz z tym przyciskiem zostanie faktycznie wysłany (czyli po kliknięciu "Losuj nową parę graczy"). Dzięki temu kod losujący graczy uruchamia się dokładnie wtedy, kiedy powinien — nie przy zwykłym wejściu na stronę.

---

## SEC-2: Losowanie dwóch zawodników (`ORDER BY RAND()` + `LIMIT 2`)

```php
$sql = "SELECT pseudonim, klasa FROM zawodnicy ORDER BY RAND() LIMIT 2;";
$result = $conn->query($sql);
```

### Jak to działa?

- **`SELECT pseudonim, klasa FROM zawodnicy`** — pobieramy tylko dwie kolumny: `pseudonim` i `klasa`, ze wszystkich zawodników w bazie (bez żadnego filtrowania rankingiem — w przeciwieństwie do Skryptu #1, tutaj losujemy spośród **wszystkich** zawodników koła).
- **`ORDER BY RAND()`** — funkcja SQL `RAND()` przypisuje każdemu wierszowi losową liczbę, a sortowanie po niej sprawia, że kolejność wyników jest **losowa** przy każdym wykonaniu zapytania.
- **`LIMIT 2`** — z tak losowo posortowanej listy bierzemy tylko **pierwsze 2** wiersze. W praktyce oznacza to: *"wylosuj dwóch dowolnych zawodników"* — to właśnie ta losowa "para graczy" z nazwy przycisku.
- **`$conn->query($sql)`** — wysyła zapytanie do bazy danych, a dwaj wylosowani zawodnicy trafiają do `$result`.

---

## SEC-3: Wypisanie obu zawodników w jednym nagłówku, oddzielonych spacją

```php
echo "<h4>";
while ($row = $result->fetch_assoc()) {
    echo $row["pseudonim"]." ".$row['klasa']." ";
}
echo "</h4>";
```

### Jak to działa?

- **`echo "<h4>";`** — otwieramy znacznik nagłówka czwartego stopnia. Zwróć uwagę, że ten znacznik otwierający jest wypisany **raz, przed pętlą** — a nie osobno dla każdego zawodnika. To kluczowa różnica względem np. Skryptu #1, gdzie każdy wiersz tabeli miał **swój własny** `<tr>...</tr>`. Tutaj chcemy, żeby **oba** rekordy trafiły do **jednego, wspólnego** nagłówka `<h4>`.
- **`while ($row = $result->fetch_assoc())`** — pętla wykonująca się dokładnie **2 razy** (bo zapytanie w SEC-2 zwróciło maksymalnie 2 wiersze dzięki `LIMIT 2`) — raz dla każdego wylosowanego zawodnika.
- **`echo $row["pseudonim"]." ".$row['klasa']." ";`** — dla każdego zawodnika wypisujemy jego pseudonim, potem spację (`" "`), potem jego klasę, a na końcu jeszcze jedną spację (`" "`), która oddzieli go od danych **kolejnego** zawodnika wypisanych w następnym przebiegu pętli. Dzięki tym spacjom, gdy pętla wykona się dwa razy, końcowy tekst będzie wyglądał np. tak: `"szachowykrol MK szachyfan1 AM "` — czyli pseudonim i klasa pierwszego gracza, spacja, pseudonim i klasa drugiego gracza.
- **`echo "</h4>";`** — dopiero **po zakończeniu całej pętli** (czyli po wypisaniu obu zawodników) zamykamy nagłówek. To właśnie sprawia, że oba rekordy lądują wewnątrz **jednego wspólnego** `<h4>`, a nie w dwóch osobnych nagłówkach.

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**       | **Co oznacza / Co robi?**                                                                     |
| ---------------------------- | -------------------------------------------------------------------------------------------------|
| `isset($_POST["nazwa_przycisku"])` | Sprawdza, czy formularz z danym przyciskiem został wysłany.                                  |
| `ORDER BY RAND()`             | Sortuje wyniki zapytania w losowej kolejności — za każdym wykonaniem inaczej.                      |
| `LIMIT 2`                      | Ogranicza liczbę zwróconych wierszy do maksymalnie 2 (tu: dwóch losowych zawodników).               |
| Znacznik otwarty **przed** pętlą, zamknięty **po** pętli | Technika łączenia wielu rekordów bazy danych w **jeden wspólny** element HTML (tu: jeden `<h4>` dla obu graczy), zamiast osobnego znacznika dla każdego rekordu. |
| `fetch_assoc()`                | Pobiera jeden wiersz wyniku jako tablicę z kluczami-nazwami kolumn (np. `$row["pseudonim"]`).       |
