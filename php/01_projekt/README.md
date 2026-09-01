# Projekt PHP + MySQLi: baza kinowa (aktorzy / filmy)

**Słowa kluczowe:** połączenie z bazą (`mysqli`), lista rekordów (`while` + `fetch_assoc`), parametr GET (`$_GET['id']`), `num_rows`, złączenie `JOIN`, zliczanie relacji.

Projekt uczy czterech podstawowych operacji na bazie danych w PHP: połączenia,
listy rekordów, pobrania pojedynczego rekordu po ID oraz złączenia tabel (JOIN).
Całość jest zebrana w dwóch działających plikach: `index.php` i `aktor.php`.
Poniżej znajdziesz **esencję każdego wzorca** — jeśli tylko chcesz sobie
przypomnieć jak coś działało, masz to tutaj. Pełne, powolne tłumaczenie "od
zera" (z podziałem na sekcje SEC-1, SEC-2...) znajduje się w README każdego
podfolderu.

## Struktura projektu

```text
01_projekt/
├── 01_polaczenie_z_baza_mysqli/     -> połączenie z bazą
├── 02_pobieranie_listy_rekordow/    -> lista rekordów (pętla while)
├── 03_pobieranie_danych_po_id/      -> pojedynczy rekord po $_GET['id']
├── 04_zliczanie_rekordow_relacji/   -> JOIN + zliczanie (num_rows)
├── index.php                        -> strona główna: lista aktorów
└── aktor.php                        -> profil aktora + jego filmy (JOIN)
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.php`
(czysta implementacja wzorca). `index.php` i `aktor.php` łączą te wzorce w
działającą stronę — każdy z nich sam otwiera i zamyka własne połączenie z bazą.

---

## Ściągawka wzorców

### 1. Połączenie z bazą

```php
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}
// ...
$conn->close();
```

`new mysqli(host, user, pass, db)` tworzy połączenie. `connect_error` mówi,
czy się nie udało — jeśli tak, `die()` zatrzymuje skrypt, żeby nie odpalać
zapytań na martwym połączeniu. Na końcu skryptu zamykamy połączenie
`close()`.

→ Pełne wytłumaczenie: [`01_polaczenie_z_baza_mysqli/README.md`](./01_polaczenie_z_baza_mysqli/README.md)

### 2. Lista rekordów

```php
$result = $conn->query("SELECT * FROM aktorzy ORDER BY nazwisko ASC");

while ($row = $result->fetch_assoc()) {
    echo $row['imie'] . " " . $row['nazwisko'];
    echo "<a href='aktor.php?id=" . $row['id_aktora'] . "'>...</a>";
}
```

`query()` zwraca obiekt `$result` (kursor po wierszach). `fetch_assoc()`
wyciąga jeden wiersz jako tablicę asocjacyjną (`$row['nazwa_kolumny']`) i
zwraca `null`, gdy wierszy braknie — dlatego `while` zatrzymuje się samo.
Z ID każdego wiersza budujemy link do `aktor.php?id=X`.

→ Pełne wytłumaczenie: [`02_pobieranie_listy_rekordow/README.md`](./02_pobieranie_listy_rekordow/README.md)

### 3. Pojedynczy rekord po ID

```php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM aktorzy WHERE id_aktora = $id");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // bez pętli - jeden rekord
    }
}
```

`isset($_GET['id'])` sprawdza, czy w adresie w ogóle jest parametr `?id=...`.
`WHERE id_aktora = $id` filtruje zapytanie do jednego wiersza, więc zamiast
`while` robimy jedno `fetch_assoc()`. `num_rows > 0` sprawdza, czy w ogóle
coś znaleziono, zanim spróbujemy to wyciągnąć.

→ Pełne wytłumaczenie: [`03_pobieranie_danych_po_id/README.md`](./03_pobieranie_danych_po_id/README.md)

### 4. JOIN i zliczanie relacji

```php
$query = "SELECT filmy.id_filmu
          FROM filmy
          JOIN filmy_aktorzy ON filmy.id_filmu = filmy_aktorzy.id_filmu
          WHERE filmy_aktorzy.id_aktora = $id";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "Liczba filmów: " . $result->num_rows;
    while ($row = $result->fetch_assoc()) {
        echo $row['id_filmu'];
    }
}
```

Relacja wiele-do-wielu (aktor ↔ film) wymaga tabeli pośredniczącej
(`filmy_aktorzy`), która trzyma tylko pary ID. `JOIN ... ON` łączy tabelę
główną z pośredniczącą po wspólnej kolumnie. Dwuetapowość: najpierw
`num_rows` mówi _ile_ jest wyników, dopiero `while` + `fetch_assoc()`
wyciąga _jakie konkretnie_.

→ Pełne wytłumaczenie: [`04_zliczanie_rekordow_relacji/README.md`](./04_zliczanie_rekordow_relacji/README.md)

---

## Tabela referencyjna

| Plik / moduł                    | Kluczowa funkcja                                 | Do czego służy                      |
| ------------------------------- | ------------------------------------------------ | ----------------------------------- |
| `01_polaczenie_z_baza_mysqli`   | `new mysqli()`, `$conn->connect_error`           | Nawiązanie i weryfikacja połączenia |
| `02_pobieranie_listy_rekordow`  | `while ($row = $result->fetch_assoc())`          | Wyświetlenie wielu rekordów         |
| `03_pobieranie_danych_po_id`    | `isset($_GET['id'])`, pojedynczy `fetch_assoc()` | Odczyt parametru URL, jeden rekord  |
| `04_zliczanie_rekordow_relacji` | `JOIN ... ON`, `$result->num_rows`               | Złączenie tabel, zliczanie relacji  |
| `index.php`                     | moduły 1 + 2                                     | Strona główna z listą aktorów       |
| `aktor.php`                     | moduły 1 + 3 + 4                                 | Profil aktora + lista jego filmów   |
