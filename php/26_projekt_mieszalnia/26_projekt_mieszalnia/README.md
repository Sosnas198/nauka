# Projekt PHP + MySQLi: mieszalnia farb (wyszukiwanie zamówień wg daty odbioru)

**Słowa kluczowe:** połączenie z bazą (`mysqli`), strażnik przycisku (`isset($_POST['wyszukaj'])`), pola daty (`$_POST['dataod']` / `$_POST['datado']`), złączenie `JOIN`, filtrowanie po zakresie (`WHERE ... BETWEEN`), lista rekordów (`while` + `fetch_assoc`), dynamiczny styl inline (`background-color`), zamknięcie połączenia (`close`).

Projekt uczy warunkowego wyboru zapytania na podstawie tego, czy użytkownik
wysłał formularz: jeśli tak — wyniki filtrowane są po zakresie dat, jeśli nie
— pokazywane są wszystkie zamówienia. Obie gałęzie łączą tabelę `klienci` z
`zamowienia` przez `JOIN` i wyświetlają wynik w tabeli HTML, gdzie kolor farby
z bazy trafia bezpośrednio do stylu `background-color` komórki. Całość jest
zebrana w jednym działającym pliku, opartym o zapytania z treści zadania.
Poniżej znajdziesz **esencję każdego wzorca** — jeśli tylko chcesz sobie
przypomnieć jak coś działało, masz to tutaj. Pełne, powolne tłumaczenie "od
zera" (z podziałem na sekcje SEC-1, SEC-2...) znajduje się w README każdego
podfolderu.

## Struktura projektu

```text
26_projekt_mieszalnia/
├── 01_polaczenie_z_baza/                  -> otwarcie połączenia z bazą
├── 02_wyszukiwanie_zamowien_wg_dat/       -> JOIN + WHERE BETWEEN (formularz wysłany)
├── 03_wyswietlanie_wszystkich_zamowien/   -> JOIN bez WHERE (formularz pominięty)
└── 04_zamkniecie_polaczenia/              -> $conn->close()
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.php`
(czysta implementacja wzorca). Moduły 02 i 03 to w oryginale dwie gałęzie
jednego bloku `if (isset($_POST['wyszukaj'])) { ... } else { ... }` —
rozdzielone tu dla przejrzystości nauki. Pełny, złożony kod obu gałęzi
znajdziesz w sekcji "Wzorzec końcowy" poniżej.

---

## Ściągawka wzorców

### 1. Połączenie z bazą

```php
$conn = new mysqli("localhost", "root", "", "mieszalnia");
// ...
$conn->close();
```

`new mysqli(host, user, pass, db)` tworzy połączenie na samej górze skryptu.
Zamykamy je dopiero na końcu, `close()`, po tym jak wykona się właściwe
zapytanie — niezależnie od tego, którą gałęzią (z filtrem czy bez) poszedł
skrypt.

→ Pełne wytłumaczenie: [`01_polaczenie_z_baza/README.md`](./01_polaczenie_z_baza/README.md)

### 2. Wyszukiwanie wg zakresu dat (formularz wysłany)

```php
if (isset($_POST['wyszukaj'])) {
    $dataod = $_POST['dataod'];
    $datado = $_POST['datado'];

    $sql = "SELECT nazwisko, imie, zamowienia.id, kod_koloru, pojemnosc, data_odbioru
            FROM klienci JOIN zamowienia ON klienci.id = id_klienta
            WHERE data_odbioru >= '$dataod' AND data_odbioru <= '$datado'
            ORDER BY data_odbioru;";
    $result = $conn->query($sql);
}
```

`isset($_POST['wyszukaj'])` to strażnik — sprawdza, czy kliknięto konkretny,
nazwany przycisk formularza (`name="wyszukaj"`), a nie tylko czy formularz w
ogóle istnieje. Dwa pola typu `date` z formularza trafiają do `$dataod` i
`$datado`. `JOIN klienci ON klienci.id = id_klienta` łączy dane klienta z jego
zamówieniem, a `WHERE data_odbioru >= ... AND <= ...` ogranicza wynik do
podanego zakresu dat.

→ Pełne wytłumaczenie: [`02_wyszukiwanie_zamowien_wg_dat/README.md`](./02_wyszukiwanie_zamowien_wg_dat/README.md)

### 3. Wszystkie zamówienia (formularz pominięty)

```php
else {
    $sql = "SELECT nazwisko, imie, zamowienia.id, kod_koloru, pojemnosc, data_odbioru
            FROM klienci JOIN zamowienia ON klienci.id = id_klienta
            ORDER BY data_odbioru;";
    $result = $conn->query($sql);
}
```

To samo złączenie `JOIN` co w module 2, ale bez klauzuli `WHERE` — zwraca
więc wszystkie zamówienia, posortowane po dacie odbioru. Ta gałąź wykonuje
się, gdy użytkownik nie wysłał formularza (zwykłe wejście na stronę).

→ Pełne wytłumaczenie: [`03_wyswietlanie_wszystkich_zamowien/README.md`](./03_wyswietlanie_wszystkich_zamowien/README.md)

### 4. Wyświetlanie z kolorowym tłem komórki

```php
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["nazwisko"] . "</td>";
        echo "<td style='background-color: #" . $row["kod_koloru"] . ";'>" . $row["kod_koloru"] . "</td>";
        echo "<td>" . $row["data_odbioru"] . "</td>";
    echo "</tr>";
}
```

Ta sama pętla `while` + `fetch_assoc()` działa identycznie w obu gałęziach
(02 i 03). Ciekawostka projektu: kod koloru z bazy (np. `ff0000`) jest
doklejany bezpośrednio do atrybutu `style`, poprzedzony `#` — dzięki temu
komórka tabeli sama pokazuje kolor farby, bez dodatkowej logiki w PHP.

→ Pełne wytłumaczenie: [`02_wyszukiwanie_zamowien_wg_dat/README.md`](./02_wyszukiwanie_zamowien_wg_dat/README.md)

### 5. Zamknięcie połączenia

```php
$conn->close();
```

Wywoływane raz, na samym końcu, poza obiema gałęziami `if`/`else` — wykonuje
się niezależnie od tego, którą ścieżką poszedł skrypt.

→ Pełne wytłumaczenie: [`04_zamkniecie_polaczenia/README.md`](./04_zamkniecie_polaczenia/README.md)

---

## Tabela referencyjna

| Plik / moduł                          | Kluczowa funkcja                                         | Do czego służy                                   |
| ------------------------------------- | -------------------------------------------------------- | ------------------------------------------------ |
| `01_polaczenie_z_baza`                | `new mysqli()`                                           | Otwarcie połączenia z bazą `mieszalnia`          |
| `02_wyszukiwanie_zamowien_wg_dat`     | `isset($_POST['wyszukaj'])`, `JOIN`, `WHERE ... BETWEEN` | Filtrowanie zamówień po zakresie dat             |
| `03_wyswietlanie_wszystkich_zamowien` | `JOIN` bez `WHERE`                                       | Pokazanie wszystkich zamówień (bez filtra)       |
| `background-color: #".kod_koloru.";`  | Dynamiczny styl inline                                   | Ustawienie tła komórki na kolor zapisany w bazie |
| `04_zamkniecie_polaczenia`            | `$conn->close()`                                         | Zamknięcie połączenia po zakończeniu pracy       |
