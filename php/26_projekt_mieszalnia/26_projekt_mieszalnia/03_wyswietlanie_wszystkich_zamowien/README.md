# Kompletny przewodnik: Wyświetlanie wszystkich zamówień, gdy nie wysłano formularza (gałąź `else`)

Ta ściąga tłumaczy drugą część logiki skryptu — to, co się dzieje, gdy użytkownik **jeszcze nie kliknął** przycisku "Wyszukaj" (czyli dopiero wszedł na stronę). W takim przypadku pokazujemy po prostu **wszystkie** zamówienia z bazy, bez żadnego filtrowania po dacie.

> Ten moduł jest bardzo podobny do modułu `02_wyszukiwanie_zamowien_wg_dat` — jeśli któreś z pojęć (`JOIN`, `fetch_assoc`, kolorowe tło komórki) nie jest dla Ciebie jasne, koniecznie zajrzyj najpierw tam, znajdziesz tam pełne wyjaśnienie krok po kroku.

> **Uwaga techniczna:** W oryginalnym skrypcie ta logika znajduje się w gałęzi `else { ... }`, sparowanej z warunkiem `if` z modułu 02. Ponieważ te dwa moduły są w osobnych plikach, w `script.php` tego modułu celowo pominięto samo słowo kluczowe `else` (zostawienie go w osobnym pliku powodowałoby błąd składni PHP przy otwarciu tego pliku samodzielnie) — sama logika (zapytanie SQL i pętla wyświetlająca) pozostała **dokładnie taka, jak w oryginale, bez żadnych zmian**.

---

## SEC-1: Zapytanie o wszystkie zamówienia, bez filtra dat

```php
$sql = "SELECT nazwisko, imie, zamowienia.id, kod_koloru, pojemnosc, data_odbioru FROM klienci JOIN zamowienia ON klienci.id = id_klienta ORDER BY data_odbioru;";
$result = $conn->query($sql);
```

### Jak to działa? Co jest inne względem modułu 02?

- Zapytanie jest **niemal identyczne** jak w module `02_wyszukiwanie_zamowien_wg_dat`, z jedną kluczową różnicą: **brakuje tu fragmentu `WHERE data_odbioru >= ... AND data_odbioru <= ...`**.
- Ponieważ nie ma żadnego warunku `WHERE`, zapytanie zwróci **kompletnie wszystkie** wiersze z połączonych tabel `klienci` i `zamowienia` — czyli wszystkie zamówienia, jakie kiedykolwiek złożono, niezależnie od daty odbioru.
- `JOIN zamowienia ON klienci.id = id_klienta` działa dokładnie tak samo jak w module 02 — łączy dane klienta z jego zamówieniem.
- `ORDER BY data_odbioru` również działa identycznie — sortuje wynik od najwcześniejszej do najpóźniejszej daty odbioru.
- Ta gałąź kodu wykonuje się **tylko wtedy**, gdy warunek `isset($_POST['wyszukaj'])` z modułu 02 był **fałszywy** — czyli dokładnie wtedy, gdy formularz nie został jeszcze wysłany (użytkownik dopiero wszedł na stronę).

---

## SEC-2: Wyświetlenie wszystkich zamówień w tabeli

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

- Ten fragment jest **dosłownie taki sam** jak SEC-4 w module `02_wyszukiwanie_zamowien_wg_dat` — pętla `while` pobiera po jednym wierszu (`fetch_assoc()`) i wypisuje go jako wiersz tabeli HTML (`<tr>...</tr>`), z kolorowym tłem komórki koloru (`#`.kod_koloru).
- Jedyna różnica polega na tym, **skąd pochodzą dane** w `$result` — tutaj z zapytania bez filtra (SEC-1 powyżej), a nie z zapytania z warunkiem `WHERE` po dacie.
- Pełne wyjaśnienie każdej linijki tej pętli (dlaczego używamy kropki `.` do sklejania tekstu, skąd bierze się `#` przed kodem koloru, jak działa `fetch_assoc()`) znajdziesz w README modułu `02_wyszukiwanie_zamowien_wg_dat`, sekcja SEC-4.

---

# Podsumowanie przepływu danych

```text
(warunek isset($_POST['wyszukaj']) z modułu 02 = FAŁSZ)
                 ↓
SEC-1: SELECT ... FROM klienci JOIN zamowienia ON ... ORDER BY data_odbioru;
       — Pobranie WSZYSTKICH zamówień, bez filtrowania po dacie
                 ↓
SEC-2: while (...) { echo "<tr>...</tr>"; }
       — Wypisanie każdego zamówienia jako wiersza tabeli
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**   | **Co oznacza / Co robi?**                                                              |
| -------------------------- | ------------------------------------------------------------------------------------------ |
| **gałąź `else`**            | Kod wykonywany wtedy, gdy warunek z `if` (tu: wysłanie formularza) nie jest spełniony.     |
| **zapytanie bez `WHERE`**   | Zwraca wszystkie wiersze z tabeli/złączenia tabel, bez żadnego filtrowania.                |
| **`JOIN`, `fetch_assoc`, kolorowe tło** | Działają identycznie jak w module `02_wyszukiwanie_zamowien_wg_dat` — zobacz tam pełne wyjaśnienie. |
