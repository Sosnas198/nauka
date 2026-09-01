# Kompletny przewodnik: Filtrowanie zamówień po zakresie dat z formularza (JOIN + WHERE)

Ta ściąga wytłumaczy Ci **od A do Z**, jak PHP sprawdza, czy formularz wyszukiwania został wysłany, jak odczytuje z niego zakres dat oraz jak buduje zapytanie SQL łączące dwie tabele i filtrujące wyniki po dacie.

---

## SEC-1: Sprawdzenie, czy formularz wyszukiwania został wysłany (`isset($_POST['wyszukaj'])`)

```php
if (isset($_POST['wyszukaj'])) {
    // ... tu wchodzimy TYLKO, jeśli kliknięto przycisk "Wyszukaj"
}
```

### Jak to działa?

- **`isset(...)`** – to wbudowana w PHP funkcja sprawdzająca, czy dana zmienna (lub w tym przypadku: dany element tablicy) **w ogóle istnieje i ma jakąkolwiek wartość** (nie jest `null`). Zwraca `true` (prawda) albo `false` (fałsz).
- **`$_POST['wyszukaj']`** – w formularzu HTML przycisk wygląda tak: `<button type="submit" name="wyszukaj" id="wyszukaj">Wyszukaj</button>`. Zwróć uwagę na atrybut **`name="wyszukaj"`** — to sprawia, że gdy użytkownik kliknie ten konkretny przycisk, w tablicy `$_POST` pojawi się klucz `'wyszukaj'`.
- **`isset($_POST['wyszukaj'])`** – więc to zapytanie tak naprawdę oznacza: *"czy formularz w ogóle został wysłany, czyli czy przycisk 'Wyszukaj' został kliknięty?"*. Jeśli użytkownik dopiero wszedł na stronę (i nie kliknął jeszcze niczego), `$_POST['wyszukaj']` nie istnieje, więc `isset(...)` zwróci `false`, a cały blok `if` zostanie pominięty.
- **Różnica względem `$_SERVER["REQUEST_METHOD"] == "POST"`** (użytego w innych projektach): tam sprawdzaliśmy ogólnie, *jaką metodą* wysłano żądanie. Tutaj sprawdzamy coś bardziej precyzyjnego — czy konkretny, nazwany przycisk formularza został kliknięty. Obie metody prowadzą do podobnego efektu, ale `isset($_POST['nazwa_przycisku'])` jest przydatne zwłaszcza wtedy, gdy na jednej stronie mielibyśmy kilka różnych formularzy/przycisków i musielibyśmy rozróżnić, który z nich wysłano.

---

## SEC-2: Odczytanie zakresu dat z formularza (`$_POST['dataod']`, `$_POST['datado']`)

```php
$dataod = $_POST['dataod'];
$datado = $_POST['datado'];
```

### Jak to działa?

- **`$_POST['dataod']`** – pobiera wartość pola `<input type="date" name="dataod">` z formularza, czyli datę początkową zakresu, wpisaną (lub wybraną z kalendarzyka) przez użytkownika.
- **`$_POST['datado']`** – analogicznie, pobiera wartość pola `<input type="date" name="datado">`, czyli datę końcową zakresu.
- Pole typu `date` w HTML zwraca datę w formacie `RRRR-MM-DD` (np. `2026-08-30`) — to jest wygodne, bo dokładnie w takim formacie MySQL domyślnie przechowuje i porównuje daty.
- Zapisujemy obie wartości do osobnych, krótszych zmiennych `$dataod` i `$datado`, żeby wygodnie użyć ich w zapytaniu SQL w kolejnym kroku.

---

## SEC-3: Budowa zapytania z połączeniem tabel (`JOIN`) i filtrem dat (`WHERE`)

```php
$sql = "SELECT nazwisko, imie, zamowienia.id, kod_koloru, pojemnosc, data_odbioru FROM klienci JOIN zamowienia ON klienci.id = id_klienta WHERE data_odbioru >= '$dataod' AND data_odbioru <= '$datado' ORDER BY data_odbioru;";
$result = $conn->query($sql);
```

### Jak to działa? Rozbijmy to zapytanie SQL na części

- **`SELECT nazwisko, imie, zamowienia.id, kod_koloru, pojemnosc, data_odbioru`** – wskazujemy, jakie kolumny nas interesują. Zwróć uwagę na **`zamowienia.id`** — piszemy tak (z nazwą tabeli przed kropką), a nie po prostu `id`, ponieważ **obie łączone tabele mogą mieć własną kolumnę `id`** (np. `klienci.id` i `zamowienia.id`), więc trzeba jednoznacznie wskazać, o które konkretnie `id` nam chodzi (tutaj: numer zamówienia z tabeli `zamowienia`).
- **`FROM klienci`** – zaczynamy od tabeli `klienci` (dane osobowe: imię, nazwisko).
- **`JOIN zamowienia ON klienci.id = id_klienta`** – to jest tzw. **złączenie tabel** (*JOIN*). Mówimy bazie danych: *"dołącz do każdego klienta te wiersze z tabeli `zamowienia`, w których kolumna `id_klienta` (w tabeli zamówień) zgadza się z kolumną `id` klienta (w tabeli klientów)"*. Dzięki temu z dwóch osobnych tabel (klienci i ich zamówienia) powstaje jedna, wspólna "wirtualna tabela", w której przy każdym zamówieniu widać też dane klienta, który je złożył.
- **`WHERE data_odbioru >= '$dataod' AND data_odbioru <= '$datado'`** – to jest filtr. Bierzemy pod uwagę tylko te wiersze, w których data odbioru zamówienia mieści się **pomiędzy** datą początkową a końcową (włącznie), podanymi przez użytkownika w formularzu. Wartości `$dataod` i `$datado` są tu automatycznie wklejane do tekstu zapytania (interpolacja zmiennych w stringu wewnątrz cudzysłowów `" "`).
- **`ORDER BY data_odbioru`** – sortuje wynikowe wiersze rosnąco według daty odbioru (od najwcześniejszej do najpóźniejszej).
- **`$conn->query($sql)`** – wysyła tak zbudowane zapytanie do bazy danych przez nasze wcześniej otwarte połączenie `$conn` (moduł `01_polaczenie_z_baza`) i zapisuje zwrócony zestaw wyników do `$result`.

---

## SEC-4: Wyświetlenie wyników w wierszach tabeli, z kolorowym tłem komórki koloru

```php
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["nazwisko"] . "</td>";
    echo "<td>" . $row["imie"] . "</td>";
    echo "<td style='background-color: #".$row["kod_koloru"].";'>" . $row["kod_koloru"] . "</td>";
    echo "<td>" . $row["pojemnosc"] . "</td>";
    echo "<td>" . $row["data_odbioru"] . "</td>";
    echo "</tr>";
}
```

### Jak to działa?

- **`while ($row = $result->fetch_assoc())`** – tak jak w poprzednich projektach: pętla pobiera po jednym wierszu wyników na każdy przebieg, dopóki wiersze się nie skończą (wtedy `fetch_assoc()` zwraca `false` i pętla się zatrzymuje).
- **`echo "<tr>";`** – otwiera nowy wiersz tabeli HTML.
- **`echo "<td>" . $row["id"] . "</td>";`** – tutaj, w przeciwieństwie do poprzednich projektów, użyto **kropki `.`** zamiast wklejania zmiennej wprost w cudzysłów. Kropka w PHP to *operator sklejania stringów* (konkatenacji) — łączy ze sobą dwa kawałki tekstu w jeden. Efekt jest identyczny jak przy interpolacji (`"$zmienna"`), tylko zapisany w inny sposób: `"<td>" . $row["id"] . "</td>"` sklejamy z trzech kawałków: tekstu `"<td>"`, wartości `$row["id"]` oraz tekstu `"</td>"`.
- **Najważniejsza linijka:** `"<td style='background-color: #".$row["kod_koloru"].";'>" . $row["kod_koloru"] . "</td>"`
  - W bazie danych kolumna `kod_koloru` przechowuje kod szesnastkowy koloru **bez znaku `#`** na początku (np. `ff5733`, a nie `#ff5733`) — tak zwykle robi się to w bazach danych, żeby oszczędzić miejsce i uniknąć zamieszania ze znakiem specjalnym.
  - Fragment `"#".$row["kod_koloru"]` doklejа znak `#` **przed** wartością z bazy — dzięki temu powstaje poprawny zapis koloru CSS, np. `#ff5733`.
  - Cały atrybut `style='background-color: #ff5733;'` jest wklejany bezpośrednio do znacznika `<td>`, dzięki czemu przeglądarka **ustawia kolor tła tej konkretnej komórki** dokładnie na taki, jaki jest zapisany w bazie dla danego zamówienia.
  - Jednocześnie, dla czytelności, w treści komórki nadal wypisujemy sam kod koloru jako tekst (`$row["kod_koloru"]`), więc użytkownik widzi zarówno kolorowe tło, jak i wartość tekstową kodu.
- Pozostałe komórki (`pojemnosc`, `data_odbioru`) są wypisywane analogicznie, bez żadnych dodatkowych stylów.
- **`echo "</tr>";`** – zamyka wiersz tabeli. Cały blok powtarza się dla każdego zamówienia spełniającego warunek daty z SEC-3.

---

# Podsumowanie przepływu danych

```text
SEC-1: if (isset($_POST['wyszukaj']))
       — Sprawdzenie, czy kliknięto przycisk "Wyszukaj"
                 ↓
SEC-2: $dataod = $_POST['dataod']; $datado = $_POST['datado'];
       — Odczytanie zakresu dat z formularza
                 ↓
SEC-3: SELECT ... FROM klienci JOIN zamowienia ON ... WHERE data_odbioru BETWEEN ...
       — Połączenie tabel i przefiltrowanie zamówień po dacie odbioru
                 ↓
SEC-4: while (...) { echo "<tr>...<td style='background-color:#...'>...</tr>"; }
       — Wypisanie każdego znalezionego zamówienia jako wiersza tabeli, z kolorowym tłem
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**              | **Co oznacza / Co robi?**                                                                    |
| ------------------------------------- | ------------------------------------------------------------------------------------------------ |
| **`isset($_POST['nazwa_przycisku'])`** | Sprawdza, czy formularz z danym, nazwanym przyciskiem został wysłany.                            |
| **`JOIN ... ON ...`**                 | Łączy dwie tabele w bazie danych na podstawie wspólnej kolumny (tu: id klienta).                 |
| **`WHERE kolumna >= x AND kolumna <= y`** | Filtruje wiersze mieszczące się w podanym zakresie (tu: dat).                                |
| **`ORDER BY`**                        | Sortuje wyniki zapytania według wskazanej kolumny.                                                |
| **operator `.` (kropka)**             | Skleja (konkatenuje) ze sobą kawałki tekstu w PHP.                                                |
| **`style='background-color: #...'`**  | Atrybut HTML ustawiający kolor tła elementu na podstawie kodu szesnastkowego z bazy danych.       |
