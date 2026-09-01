# Projekt PHP + MySQLi: klub zdobywców gór (rejestracja i lista osób)

**Słowa kluczowe:** połączenie z bazą (`mysqli`), metoda żądania (`$_SERVER["REQUEST_METHOD"]`), dane z formularza (`$_POST`), zapis rekordu (`INSERT INTO`), lista rekordów (`while` + `fetch_assoc`), wyświetlanie tabeli HTML, zamknięcie połączenia (`close`).

Projekt uczy pełnego cyklu pracy z formularzem i bazą danych w PHP: sprawdzenia,
czy formularz w ogóle wysłano, zapisania nowego rekordu na podstawie danych
użytkownika, a następnie pobrania i wyświetlenia wszystkich rekordów — w tym
tego właśnie dodanego. Całość jest zebrana w jednym działającym pliku, opartym
o zapytania z treści zadania. Poniżej znajdziesz **esencję każdego wzorca** —
jeśli tylko chcesz sobie przypomnieć jak coś działało, masz to tutaj. Pełne,
powolne tłumaczenie "od zera" (z podziałem na sekcje SEC-1, SEC-2...) znajduje
się w README każdego podfolderu.

## Struktura projektu

```text
25_projekt_zdobywcy/
├── 01_polaczenie_z_baza/                  -> otwarcie połączenia z bazą
├── 02_dodawanie_osoby_z_formularza/       -> odbiór $_POST + INSERT
├── 03_wyswietlanie_listy_osob/            -> SELECT + lista w tabeli
└── 04_zamkniecie_polaczenia/              -> $conn->close()
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.php`
(czysta implementacja wzorca). Moduły wykonują się w tej właśnie kolejności —
najpierw dodanie osoby (jeśli formularz wysłano), dopiero potem pobranie
listy, dzięki czemu nowo dodana osoba od razu widoczna jest w tabeli, bez
osobnego odświeżania strony.

---

## Ściągawka wzorców

### 1. Połączenie z bazą

```php
$conn = new mysqli("localhost", "root", "", "zdobywcy");
// ...
$conn->close();
```

`new mysqli(host, user, pass, db)` tworzy połączenie na samej górze skryptu —
zanim wykona się jakakolwiek inna logika. Zamykamy je dopiero na końcu,
`close()`, po tym jak wszystkie operacje na bazie (zapis i odczyt) się
zakończą.

→ Pełne wytłumaczenie: [`01_polaczenie_z_baza/README.md`](./01_polaczenie_z_baza/README.md)

### 2. Odbiór formularza i zapis rekordu

```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nazwisko = $_POST['nazwisko'];
    $imie = $_POST['imie'];
    $funkcja = $_POST['funkcja'];
    $email = $_POST['email'];

    $sql = "INSERT INTO osoby VALUES (NULL, '$nazwisko', '$imie', '$funkcja', '$email');";
    $result = $conn->query($sql);
}
```

`$_SERVER["REQUEST_METHOD"] == "POST"` to strażnik: kod w środku wykonuje się
tylko wtedy, gdy formularz faktycznie wysłano, a nie przy zwykłym wejściu na
stronę. Każde pole formularza trafia do zmiennej przez `$_POST['nazwa_pola']`
— nazwa musi się zgadzać z atrybutem `name` w formularzu HTML. `NULL` jako
pierwsza wartość w `INSERT` zostawia bazie decyzję o wygenerowaniu ID
(auto-increment).

→ Pełne wytłumaczenie: [`02_dodawanie_osoby_z_formularza/README.md`](./02_dodawanie_osoby_z_formularza/README.md)

### 3. Pobranie i wyświetlenie listy

```php
$sql = "SELECT nazwisko, imie, funkcja, email FROM osoby;";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
        echo "<th>" . $row["nazwisko"] . "</th>";
        echo "<th>" . $row["imie"] . "</th>";
        echo "<th>" . $row["funkcja"] . "</th>";
        echo "<th>" . $row["email"] . "</th>";
    echo "</tr>";
}
```

`query()` zwraca kursor po wszystkich wierszach tabeli `osoby`. `fetch_assoc()`
wyciąga jeden wiersz jako tablicę asocjacyjną i zwraca `null`, gdy wierszy
braknie — dlatego `while` zatrzymuje się samo. Każdy wiersz jest od razu
wypisywany jako `<tr>...</tr>`, czyli jeden wiersz tabeli HTML na jedną osobę
z bazy.

→ Pełne wytłumaczenie: [`03_wyswietlanie_listy_osob/README.md`](./03_wyswietlanie_listy_osob/README.md)

### 4. Zamknięcie połączenia

```php
$conn->close();
```

Połączenie zamyka się jednym wywołaniem, dopiero po tym jak wykonają się
wszystkie zapytania — zarówno `INSERT` (jeśli formularz wysłano), jak i
`SELECT` do wyświetlenia listy. To ostatnia linia całego przepływu.

→ Pełne wytłumaczenie: [`04_zamkniecie_polaczenia/README.md`](./04_zamkniecie_polaczenia/README.md)

---

## Tabela referencyjna

| Plik / moduł                      | Kluczowa funkcja                                      | Do czego służy                             |
| --------------------------------- | ----------------------------------------------------- | ------------------------------------------ |
| `01_polaczenie_z_baza`            | `new mysqli()`                                        | Otwarcie połączenia z bazą danych          |
| `02_dodawanie_osoby_z_formularza` | `$_SERVER["REQUEST_METHOD"]`, `$_POST[...]`, `INSERT` | Odbiór formularza i zapis nowej osoby      |
| `03_wyswietlanie_listy_osob`      | `SELECT ... FROM ...`, `while` + `fetch_assoc()`      | Pobranie i wyświetlenie wszystkich osób    |
| `04_zamkniecie_polaczenia`        | `$conn->close()`                                      | Zamknięcie połączenia po zakończeniu pracy |
