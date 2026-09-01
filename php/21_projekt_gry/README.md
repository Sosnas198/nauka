# Projekt PHP + MySQLi: Ranking gier komputerowych (baza `gry`)

**Słowa kluczowe:** `ORDER BY ... DESC LIMIT`, katalog ze zdjęciami, prepared statement (`bind_param`), `LEFT()` (skrócenie tekstu w SQL), `htmlspecialchars()`, `trim()`, operator `??`.

Projekt uczy czterech niezależnych od siebie wzorców na jednej stronie:
rankingu TOP 5, pełnego katalogu, bezpiecznego wyszukiwania po ID
(prepared statement + skrócenie opisu w SQL) oraz dodawania rekordu z
walidacją braków. Wszystkie cztery współdzielą jedno połączenie z bazą
`gry`, ale nie przekazują sobie nawzajem żadnych danych. Całość w jednym
pliku: `gry.php`.

## Struktura projektu

```text
21_projekt_gry/
├── 01_top_gier/         -> TOP 5 wg punktów
├── 02_wszystkie_gry/    -> pełny katalog ze zdjęciami
├── 03_pokaz_opis/       -> wyszukiwanie po ID (prepared statement)
├── 04_dodaj_gre/        -> dodawanie nowej gry (prepared INSERT)
└── gry.php              -> STRONA: wszystkie 4 moduły obok siebie
```

`gry.php` otwiera jedno wspólne połączenie z bazą `gry`
(`new mysqli(...)`) na samej górze pliku i zamyka je jedną linią
`$conn->close()` na samym końcu — korzystają z niego wszystkie cztery
moduły.

---

## Ściągawka wzorców

### 1. TOP 5 gier

```php
$result = $conn->query("SELECT nazwa, punkty FROM gry ORDER BY punkty DESC LIMIT 5");

while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row['nazwa'] . " - " . $row['punkty'] . " pkt</li>";
}
```

`ORDER BY punkty DESC` sortuje gry od najwyższego wyniku, `LIMIT 5`
ucina listę do pięciu pozycji — cała logika rankingu dzieje się w samym
SQL, PHP tylko wypisuje gotowy wynik.

→ Pełne wytłumaczenie: [`01_top_gier/README.md`](./01_top_gier/README.md)

### 2. Katalog wszystkich gier

```php
$result = $conn->query("SELECT id, nazwa, zdjecie, opis FROM gry");

while ($row = $result->fetch_assoc()) {
    echo "<div class='gra'>";
    echo "<img src='" . $row['zdjecie'] . "' alt='" . $row['nazwa'] . "' title='id: " . $row['id'] . "'>";
    echo "<h3>" . $row['nazwa'] . "</h3><p>" . $row['opis'] . "</p>";
    echo "</div>";
}
```

Zwykłe `SELECT` bez `LIMIT` czy `WHERE` — pełna lista. Warto zwrócić
uwagę na atrybut `title` w `<img>`: to dymek, który pokazuje się po
najechaniu myszką, tu wykorzystany do podejrzenia `id` gry bez
zaśmiecania widoku strony tym numerem.

→ Pełne wytłumaczenie: [`02_wszystkie_gry/README.md`](./02_wszystkie_gry/README.md)

### 3. Wyszukiwanie po ID (prepared statement + `LEFT()`)

```php
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("SELECT nazwa, punkty, cena, LEFT(opis, 100) AS opis_skrot FROM gry WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    echo "<h3>" . htmlspecialchars($row['nazwa']) . "</h3>";
    echo "<p>" . $row['punkty'] . " pkt, " . $row['cena'] . " zł</p>";
    echo "<p>" . htmlspecialchars($row['opis_skrot']) . "...</p>";
}
```

`LEFT(opis, 100)` to funkcja SQL, która ucina tekst do pierwszych 100
znaków już na poziomie zapytania — nie trzeba tego robić w PHP.
`htmlspecialchars()` zabezpiecza tekst z bazy przed zepsuciem HTML (jak
w projekcie biblioteka szkolna). Filtr ID idzie przez prepared
statement, tak jak w projektach remonty i smoki.

→ Pełne wytłumaczenie: [`03_pokaz_opis/README.md`](./03_pokaz_opis/README.md)

### 4. Dodanie nowej gry (walidacja + prepared INSERT)

```php
if (isset($_POST['dodaj'])) {
    $nazwa  = trim($_POST['nazwa'] ?? '');
    $opis   = trim($_POST['opis'] ?? '');
    $cena   = trim($_POST['cena'] ?? '');
    $zdjecie = trim($_POST['zdjecie'] ?? '');

    $stmt = $conn->prepare("INSERT INTO gry (nazwa, opis, cena, zdjecie, punkty) VALUES (?, ?, ?, ?, 0)");
    $stmt->bind_param("ssss", $nazwa, $opis, $cena, $zdjecie);
    $stmt->execute();
}
```

`trim()` usuwa białe znaki (spacje, tabulacje) z początku i końca
tekstu — chroni przed zapisaniem pola, które wygląda na wypełnione, a w
rzeczywistości to same spacje. Operator `??` (null coalescing) daje
wartość domyślną (`''`), gdy pole w ogóle nie istnieje w `$_POST` —
dzięki temu `trim()` nie dostaje `null`, co w nowszym PHP jest błędem.
Nowa gra zawsze startuje z `punkty = 0`, wpisanym na sztywno w zapytaniu.

→ Pełne wytłumaczenie: [`04_dodaj_gre/README.md`](./04_dodaj_gre/README.md)

---

## Tabela referencyjna

| Plik / moduł         | Kluczowa funkcja                                            | Do czego służy                         |
| -------------------- | ----------------------------------------------------------- | -------------------------------------- |
| Połączenie (wspólne) | `new mysqli(..., "gry")`                                    | Jedno `$conn` dla wszystkich 4 modułów |
| `01_top_gier`        | `ORDER BY punkty DESC LIMIT 5`                              | Ranking najlepszych gier               |
| `02_wszystkie_gry`   | `SELECT` bez filtra, `title` w `<img>`                      | Katalog wszystkich gier                |
| `03_pokaz_opis`      | `prepare`/`bind_param("i")`, `LEFT()`, `htmlspecialchars()` | Bezpieczne wyszukanie po ID            |
| `04_dodaj_gre`       | `trim()`, `??`, `bind_param("ssss")`, `INSERT`              | Dodanie nowej gry z punktami = 0       |
