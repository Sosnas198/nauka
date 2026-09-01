# Projekt PHP + MySQLi: Konkurs — losowe nagrody (baza `konkurs`)

**Słowa kluczowe:** `ORDER BY RAND() LIMIT`, ręczny licznik wierszy (`$i`, `$i++`), numerowanie niezależne od bazy, argumenty nazwane w `new mysqli(...)`.

Krótki, jednoskryptowy projekt: losowanie 5 nagród i wyświetlenie ich w
tabeli, w której numer wiersza (1-5) jest **liczony przez sam skrypt**,
a nie pobierany z bazy. Całość w jednym pliku: `konkurs.php`
(sam kod PHP też osobno w `script.php`).

> Ten projekt, jak "psy" i "atlas zwierząt", nie ma podziału na
> podfoldery `01_`, `02_` — cała logika mieści się w jednym skrypcie.

## Główny szkielet logiki

```text
połącz → wylosuj 5 rekordów (RAND + LIMIT) → dla każdego: wypisz $i i dane → $i++ → zamknij połączenie
```

---

## Ściągawka wzorca

### Losowanie z licznikiem numerującym wiersze

```php
$conn = new mysqli(hostname: "localhost", username: "root", password: "", database: "konkurs");

$result = $conn->query("SELECT nazwa, opis, cena FROM nagrody ORDER BY RAND() LIMIT 5");

$i = 1;
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $i . "</td>";
    echo "<td>" . $row["nazwa"] . "</td>";
    echo "<td>" . $row["opis"] . "</td>";
    echo "<td>" . $row["cena"] . "</td></tr>";
    $i++;
}

$conn->close();
```

`ORDER BY RAND()` sortuje wszystkie wiersze losowo przy każdym
wykonaniu, `LIMIT 5` bierze z tego pierwsze pięć — czyli w praktyce
"wylosuj 5 różnych nagród". Numer w pierwszej kolumnie **nie pochodzi z
bazy** — to zwykły licznik PHP: `$i = 1` przed pętlą, `$i++` na końcu
każdego przebiegu. Dzięki temu tabela zawsze jest ponumerowana 1-5,
niezależnie od tego, które konkretnie nagrody trafiły do wyniku.

---

## Tabela referencyjna

| Funkcja / pojęcie                | Do czego służy                                                        |
| -------------------------------- | --------------------------------------------------------------------- |
| `ORDER BY RAND() LIMIT 5`        | Losowanie 5 rekordów z całej tabeli                                   |
| `$i = 1; ... $i++;`              | Ręczny licznik, gdy numer wiersza ma pochodzić ze skryptu, nie z bazy |
| `new mysqli(hostname: ..., ...)` | Połączenie z argumentami nazwanymi (PHP 8+)                           |
