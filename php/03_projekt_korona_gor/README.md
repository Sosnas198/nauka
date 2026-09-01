# Projekt PHP + MySQLi: Korona Gór Polskich (baza `korona`)

**Słowa kluczowe:** lista rekordów z linkiem GET (`ORDER BY`), galeria obrazów (`LIMIT`), złączenie `JOIN` z tabelą opisu, `$_GET['id']`.

Projekt uczy trzech wzorców: listy rekordów z linkiem GET, powtarzalnej
galerii miniatur używanej na dwóch stronach oraz pobrania jednego rekordu
połączonego złączeniem `JOIN` z tabelą opisów. Całość zebrana w dwóch
działających plikach: `index.php` i `szczyty.php`.

## Struktura projektu

```text
03_projekt_korona_gor/
├── 01_lista_szczyty_get/       -> lista szczytów + link GET
├── 02_galeria_miniatur/        -> galeria 10 miniatur (obie strony)
├── 03_szczegoly_szczytu_join/  -> szczegóły szczytu + JOIN z opisem
├── index.php                   -> strona główna: lista + galeria
└── szczyty.php                 -> strona szczytu: szczegóły + galeria
```

Połączenie z bazą `korona` (`localhost`, `root`, puste hasło) każdy z plików
`index.php` i `szczyty.php` otwiera i zamyka samodzielnie, bez `require` /
`include`.

---

## Ściągawka wzorców

### 1. Lista szczytów z linkiem GET

```php
$result = $conn->query("SELECT id, nazwa FROM szczyty ORDER BY wysokosc DESC");

while ($row = $result->fetch_assoc()) {
    echo "<span><a href='szczyty.php?id=" . $row['id'] . "'>" . $row['nazwa'] . "</a></span>";
}
```

Sortowanie `ORDER BY wysokosc DESC` układa listę od najwyższego szczytu.
Każdy wiersz staje się linkiem `szczyty.php?id=X` — kliknięcie przenosi na
stronę szczegółów tego konkretnego rekordu.

→ Pełne wytłumaczenie: [`01_lista_szczyty_get/README.md`](./01_lista_szczyty_get/README.md)

### 2. Galeria miniatur (na obu stronach)

```php
$result = $conn->query("SELECT nazwa, plik FROM szczyty LIMIT 10");

while ($row = $result->fetch_assoc()) {
    echo "<img src='" . $row['plik'] . "' alt='" . $row['nazwa'] . "' class='miniatury'>";
}
```

`LIMIT 10` ogranicza wynik do dziesięciu wierszy niezależnie od tego, ile
szczytów jest w bazie. Ten sam skrypt wklejony jest w `index.php` i w
`szczyty.php` — dlatego galeria wygląda identycznie na obu stronach.

→ Pełne wytłumaczenie: [`02_galeria_miniatur/README.md`](./02_galeria_miniatur/README.md)

### 3. Szczegóły szczytu (JOIN z opisem)

```php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT szczyty.*, opis.tresc
              FROM szczyty
              JOIN opis ON szczyty.id = opis.id_szczytu
              WHERE szczyty.id = $id";

    $row = $conn->query($query)->fetch_assoc();
    // obraz .duze, <h2>nazwa</h2>, wysokość, pasmo, opis.tresc
}
```

`$_GET['id']` odbiera ID przekazane z linku na stronie głównej. `JOIN opis`
dokłada do wiersza szczytu treść opisu z osobnej tabeli, żeby nie trzeba
było robić drugiego zapytania. Wynik renderowany jest jako karta: duży
obraz (klasa `.duze`), nazwa w `<h2>`, wysokość, pasmo i opis.

→ Pełne wytłumaczenie: [`03_szczegoly_szczytu_join/README.md`](./03_szczegoly_szczytu_join/README.md)

---

## Tabela referencyjna

| Plik / moduł                | Kluczowa funkcja                              | Do czego służy                           |
| --------------------------- | --------------------------------------------- | ---------------------------------------- |
| Połączenie (oba pliki)      | `new mysqli(..., "korona")`, `$conn->close()` | Most do bazy na początku i końcu skryptu |
| `01_lista_szczyty_get`      | `ORDER BY wysokosc DESC`, `<span><a>`         | Lista rekordów + link GET                |
| `02_galeria_miniatur`       | `LIMIT 10`, `class="miniatury"`               | Powtarzalna galeria na obu stronach      |
| `03_szczegoly_szczytu_join` | `$_GET['id']`, `JOIN opis`, `class="duze"`    | Szczegóły klikniętego rekordu            |
| `index.php`                 | Moduł 01 + Moduł 02                           | Strona główna                            |
| `szczyty.php`               | Moduł 03 + Moduł 02                           | Strona jednego szczytu                   |
