# Projekt PHP + MySQLi: Piekarnia (baza `piekarnia`)

**Słowa kluczowe:** `SELECT DISTINCT`, argumenty nazwane w `new mysqli(...)`, formularz → filtrowanie (`WHERE`), `isset()` jako strażnik pustego stanu początkowego.

Projekt uczy klasycznego wzorca "formularz przygotowuje wybór, drugi
skrypt go wykorzystuje": lista rozwijana wypełniona unikalnymi wartościami
z bazy, a po jej wybraniu — tabela przefiltrowana tą właśnie wartością.
Oba moduły współdzielą jedno połączenie. Całość w jednym pliku:
`piekarnia.php`.

## Struktura projektu

```text
22_projekt_piekarnia/
├── 01_lista_rozwijana/  -> SELECT DISTINCT rodzajów wypieków
├── 02_tabela_wyrobow/   -> WHERE Rodzaj = wybór z formularza
└── piekarnia.php        -> STRONA: lista + tabela
```

Połączenie zapisane jest z **argumentami nazwanymi** (PHP 8+):

```php
$conn = new mysqli(hostname: "localhost", username: "root", password: "", database: "piekarnia");
```

Działa dokładnie tak samo jak `new mysqli("localhost", "root", "", "piekarnia")`,
ale jawnie pokazuje, który parametr to co — przydatne, gdy funkcja
przyjmuje wiele argumentów w określonej kolejności i łatwo się pomylić.

---

## Ściągawka wzorców

### 1. Lista rozwijana z unikalnymi wartościami

```php
$result = $conn->query("SELECT DISTINCT Rodzaj FROM wyroby ORDER BY Rodzaj DESC");

echo "<select name='rodzaj'>";
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['Rodzaj'] . "'>" . $row['Rodzaj'] . "</option>";
}
echo "</select>";
```

`SELECT DISTINCT Rodzaj` daje każdy rodzaj wypieku tylko raz, nawet jeśli
w tabeli `wyroby` powtarza się przy wielu produktach. `ORDER BY Rodzaj
DESC` sortuje malejąco (Z→A), w odróżnieniu od domyślnego rosnącego.

→ Pełne wytłumaczenie: [`01_lista_rozwijana/README.md`](./01_lista_rozwijana/README.md)

### 2. Tabela produktów przefiltrowana wyborem

```php
if (isset($_POST['rodzaj'])) {
    $rodzaj = $_POST['rodzaj'];
    $result = $conn->query("SELECT nazwa, cena FROM wyroby WHERE Rodzaj = '$rodzaj'");

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['nazwa'] . "</td><td>" . $row['cena'] . " zł</td></tr>";
    }
}
```

`isset($_POST['rodzaj'])` pełni tu rolę strażnika: dopóki formularz nie
zostanie wysłany, ten blok w ogóle się nie wykonuje i tabela pokazuje
tylko sam nagłówek — bez żadnego zapytania do bazy w tle. Wybrana w
module 1 wartość trafia do `WHERE Rodzaj = '$rodzaj'`, filtrując wyniki
do jednego rodzaju wypieku.

→ Pełne wytłumaczenie: [`02_tabela_wyrobow/README.md`](./02_tabela_wyrobow/README.md)

---

## Tabela referencyjna

| Plik / moduł         | Kluczowa funkcja                                     | Do czego służy                                |
| -------------------- | ---------------------------------------------------- | --------------------------------------------- |
| Połączenie (wspólne) | `new mysqli(hostname: ..., ...)` — argumenty nazwane | Jedno `$conn` dla obu modułów                 |
| `01_lista_rozwijana` | `SELECT DISTINCT ... ORDER BY ... DESC`              | Wypełnienie `<select>` unikalnymi wartościami |
| `02_tabela_wyrobow`  | `isset($_POST[...])`, `WHERE Rodzaj = '$rodzaj'`     | Tabela przefiltrowana wyborem z listy         |
