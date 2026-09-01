# Projekt PHP + MySQLi: wyszukiwarka miast (filtrowanie po początku nazwy)

**Słowa kluczowe:** strażnik przycisku (`isset($_POST['szukaj'])`), odczyt frazy (`$_POST['miasto']`), połączenie z bazą (`mysqli`), złączenie `JOIN`, aliasy kolumn (`AS`), wyszukiwanie częściowe (`LIKE 'fraza%'`), budowa tabeli HTML (nagłówek + wiersze), zamknięcie połączenia (`close`).

Projekt uczy wzorca "wyszukiwarki": cała logika — od sprawdzenia formularza,
przez połączenie z bazą, aż po wyświetlenie wyników — działa tylko wtedy, gdy
użytkownik faktycznie coś wyszukał. Zapytanie łączy tabelę miast z tabelą
województw i filtruje wyniki po **początku** wpisanej frazy, a nie jej
dokładnym dopasowaniu. Całość jest zebrana w jednym działającym pliku, opartym
o zapytania z treści zadania. Poniżej znajdziesz **esencję każdego wzorca** —
jeśli tylko chcesz sobie przypomnieć jak coś działało, masz to tutaj. Pełne,
powolne tłumaczenie "od zera" (z podziałem na sekcje SEC-1, SEC-2...) znajduje
się w README każdego podfolderu.

## Struktura projektu

```text
27_projekt_wykaz/
├── 01_sprawdzenie_formularza_i_filtra/    -> isset($_POST) + pokazanie frazy
├── 02_polaczenie_z_baza/                  -> otwarcie połączenia z bazą
├── 03_zapytanie_i_naglowek_tabeli/        -> JOIN + LIKE 'fraza%' + nagłówek
├── 04_wyswietlanie_wierszy_wynikow/       -> pętla wierszy + zamknięcie tabeli
└── 05_zamkniecie_polaczenia/              -> $conn->close()
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.php`
(czysta implementacja wzorca). W oryginale moduły 02–05 znajdują się **w
całości wewnątrz** jednego bloku `if (isset($_POST['szukaj'])) { ... }` z
modułu 01 — rozdzielone tu dla przejrzystości nauki. Pełny, złożony razem kod
znajdziesz w sekcji "Wzorzec końcowy" poniżej.

---

## Ściągawka wzorców

### 1. Sprawdzenie formularza i pokazanie filtra

```php
if (isset($_POST['szukaj'])) {
    $miasto = $_POST['miasto'];
    echo "<p>$miasto</p>";
    // ... reszta logiki dalej w tym samym bloku ...
}
```

`isset($_POST['szukaj'])` to strażnik obejmujący **cały** dalszy kod strony —
połączenie z bazą, zapytanie i wyświetlanie wyników wykonują się tylko, gdy
formularz faktycznie wysłano. Wpisana fraza trafia do `$miasto`, a następnie
jest od razu wypisywana użytkownikowi jako potwierdzenie, czego szuka.

→ Pełne wytłumaczenie: [`01_sprawdzenie_formularza_i_filtra/README.md`](./01_sprawdzenie_formularza_i_filtra/README.md)

### 2. Połączenie z bazą

```php
$conn = new mysqli("localhost", "root", "", "wykaz");
```

Połączenie otwiera się dopiero **wewnątrz** bloku `if` — czyli tylko wtedy,
gdy wiadomo, że będzie faktycznie potrzebne (formularz wysłano), a nie przy
każdym wejściu na stronę.

→ Pełne wytłumaczenie: [`02_polaczenie_z_baza/README.md`](./02_polaczenie_z_baza/README.md)

### 3. Wyszukiwanie po początku nazwy i nagłówek tabeli

```php
$sql = "SELECT miasta.nazwa AS miasta_nazwa, wojewodztwa.nazwa AS wojewodztwa_nazwa
        FROM miasta JOIN wojewodztwa ON wojewodztwa.id = id_wojewodztwa
        WHERE miasta.nazwa LIKE '$miasto%'
        ORDER BY miasta.nazwa;";
$result = $conn->query($sql);

echo "<table>";
    echo "<tr><th>Miasto</th><th>Województwo</th></tr>";
```

Obie tabele (`miasta` i `wojewodztwa`) mają kolumnę `nazwa`, więc `AS` nadaje
im unikalne aliasy (`miasta_nazwa`, `wojewodztwa_nazwa`), po których można je
później rozróżnić w `$row`. `LIKE '$miasto%'` dopasowuje nazwy miast
**zaczynające się** od wpisanej frazy — znak `%` na końcu oznacza "cokolwiek
dalej". Nagłówek tabeli wypisywany jest raz, przed pętlą po wynikach.

→ Pełne wytłumaczenie: [`03_zapytanie_i_naglowek_tabeli/README.md`](./03_zapytanie_i_naglowek_tabeli/README.md)

### 4. Wiersze wyników i zamknięcie tabeli

```php
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
        echo "<td>" . $row['miasta_nazwa'] . "</td>";
        echo "<td>" . $row['wojewodztwa_nazwa'] . "</td>";
    echo "</tr>";
}
echo "</table>";
```

`fetch_assoc()` zwraca wiersz z kluczami odpowiadającymi aliasom z `AS`, a nie
oryginalnym nazwom kolumn — stąd `$row['miasta_nazwa']`, nie `$row['nazwa']`.
Każdy wiersz wyniku staje się jednym `<tr>` w tabeli. Znacznik `</table>`
zamyka się dopiero **po** pętli, gdy wszystkie wiersze są już wypisane.

→ Pełne wytłumaczenie: [`04_wyswietlanie_wierszy_wynikow/README.md`](./04_wyswietlanie_wierszy_wynikow/README.md)

### 5. Zamknięcie połączenia

```php
$conn->close();
```

Ostatnia linia całego bloku `if` — połączenie zamyka się dopiero po
wyświetleniu wszystkich wyników.

→ Pełne wytłumaczenie: [`05_zamkniecie_polaczenia/README.md`](./05_zamkniecie_polaczenia/README.md)

---

## Tabela referencyjna

| Plik / moduł                         | Kluczowa funkcja                              | Do czego służy                                       |
| ------------------------------------ | --------------------------------------------- | ---------------------------------------------------- |
| `01_sprawdzenie_formularza_i_filtra` | `isset($_POST['szukaj'])`, `$_POST['miasto']` | Sprawdzenie wysłania formularza i pokazanie frazy    |
| `02_polaczenie_z_baza`               | `new mysqli()`                                | Otwarcie połączenia z bazą `wykaz`                   |
| `03_zapytanie_i_naglowek_tabeli`     | `JOIN`, `AS`, `LIKE 'fraza%'`                 | Wyszukanie miast wg początku nazwy + nagłówek tabeli |
| `04_wyswietlanie_wierszy_wynikow`    | `while` + `fetch_assoc()`, `</table>`         | Wypisanie wyników jako wierszy i zamknięcie tabeli   |
| `05_zamkniecie_polaczenia`           | `$conn->close()`                              | Zamknięcie połączenia po zakończeniu pracy           |
