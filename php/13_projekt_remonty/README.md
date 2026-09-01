# Projekt PHP + MySQLi: Remonty (baza `remonty`, prepared statements)

**Słowa kluczowe:** `prepare`/`bind_param`/`execute`/`get_result`, placeholder `?`, `DISTINCT`, dwa formularze POST na jednej stronie, `JOIN USING`.

Projekt uczy bezpiecznego przekazywania filtrów z formularza do SQL przez
**prepared statements** — zamiast wklejać `$zmienna` prosto do stringa
zapytania, jak we wcześniejszych projektach. Trzy moduły: wyszukiwanie
wykonawców po liczbie pracowników, unikalna lista miast oraz wyszukiwanie
klientów po mieście i rodzaju usługi. Całość w jednym pliku: `zlecenia.php`,
z dwoma niezależnymi formularzami POST.

## Struktura projektu

```text
13_projekt_remonty/
├── 01_wyszukiwanie_wykonawcow/  -> POST + prepared statement, >= ?
├── 02_lista_miast/              -> DISTINCT miasto do <select>
├── 03_wyszukiwanie_klientow/    -> JOIN + prepared statement, 2 placeholdery
└── zlecenia.php                 -> STRONA ZLECEŃ: oba formularze
```

`zlecenia.php` sam otwiera i zamyka połączenie z bazą `remonty`. Ma dwa
osobne `<form method="post">` — po kliknięciu jednego z nich w `$_POST`
trafiają tylko pola tego konkretnego formularza.

---

## Ściągawka wzorców

### 1. Prepared statement z jednym placeholderem (`>= ?`)

```php
if (isset($_POST['pracownicy'])) {
    $min = $_POST['pracownicy'];

    $stmt = $conn->prepare("SELECT firma, liczba_pracownikow FROM wykonawcy WHERE liczba_pracownikow >= ?");
    $stmt->bind_param("i", $min);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['firma'] . ", " . $row['liczba_pracownikow'] . " pracowników</li>";
    }
}
```

Zamiast wklejać `$min` bezpośrednio w tekst zapytania, w SQL stawia się
znak zapytania `?` jako placeholder. `prepare()` przygotowuje zapytanie z
placeholderem, `bind_param("i", $min)` podstawia pod niego wartość
(`"i"` mówi, że to liczba całkowita — `integer`), `execute()` uruchamia
zapytanie, a `get_result()` zwraca obiekt wyniku, na którym działa już
znane `fetch_assoc()`.

→ Pełne wytłumaczenie: [`01_wyszukiwanie_wykonawcow/README.md`](./01_wyszukiwanie_wykonawcow/README.md)

### 2. Unikalna lista miast

```php
$result = $conn->query("SELECT DISTINCT miasto FROM klienci ORDER BY miasto");

echo "<select name='miasto'>";
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['miasto'] . "'>" . $row['miasto'] . "</option>";
}
echo "</select>";
```

`DISTINCT miasto` daje każde miasto tylko raz, nawet jeśli w tabeli
`klienci` powtarza się wielokrotnie. To zwykłe `query()`, bez prepared
statement — nie ma tu żadnej wartości z zewnątrz do podstawienia.

→ Pełne wytłumaczenie: [`02_lista_miast/README.md`](./02_lista_miast/README.md)

### 3. Prepared statement z dwoma placeholderami + JOIN

```php
if (isset($_POST['szukaj_klientow'])) {
    $miasto = $_POST['miasto'];
    $usluga = $_POST['usluga'];

    $stmt = $conn->prepare("SELECT klienci.imie, zlecenia.cena
                             FROM klienci
                             JOIN zlecenia USING (id_klienta)
                             WHERE klienci.miasto = ? AND zlecenia.rodzaj = ?");
    $stmt->bind_param("ss", $miasto, $usluga);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['imie'] . " - " . $row['cena'] . " zł</li>";
    }
}
```

Ten sam mechanizm co w module 1, ale z dwoma placeholderami naraz — stąd
`bind_param("ss", $miasto, $usluga)`: dwie litery `"s"` (string) w
kolejności odpowiadającej dwóm znakom `?` w zapytaniu. `JOIN USING
(id_klienta)` łączy klienta z jego zleceniami, a `WHERE ... AND ...`
filtruje jednocześnie po mieście i rodzaju usługi.

→ Pełne wytłumaczenie: [`03_wyszukiwanie_klientow/README.md`](./03_wyszukiwanie_klientow/README.md)

---

## Ściągawka: typy w `bind_param`

| Znak | Typ danych                         |
| ---- | ---------------------------------- |
| `i`  | integer (liczba całkowita)         |
| `d`  | double (liczba zmiennoprzecinkowa) |
| `s`  | string (tekst)                     |
| `b`  | blob (dane binarne)                |

Kolejność liter musi odpowiadać kolejności `?` w zapytaniu i kolejności
zmiennych podanych po nich w `bind_param()`.

---

## Tabela referencyjna

| Plik / moduł                                  | Kluczowa funkcja                          | Do czego służy                                    |
| --------------------------------------------- | ----------------------------------------- | ------------------------------------------------- |
| `prepare`/`bind_param`/`execute`/`get_result` | Placeholder `?` zamiast sklejania stringa | Bezpieczne przekazanie danych z formularza do SQL |
| `01_wyszukiwanie_wykonawcow`                  | `bind_param("i", ...)`, `>= ?`            | Wykonawcy z minimalną liczbą pracowników          |
| `02_lista_miast`                              | `DISTINCT miasto`                         | Lista miast bez duplikatów                        |
| `03_wyszukiwanie_klientow`                    | `bind_param("ss", ...)`, `JOIN USING`     | Klienci po mieście i rodzaju usługi               |
