# Projekt PHP + MySQLi obiektowe: Medica (baza `medica`)

**Słowa kluczowe:** styl obiektowy, lista bez filtra, relacja wiele-do-wielu (podwójny `JOIN`), powtórzone zapytania z różnym `WHERE id`.

Projekt uczy dwóch wzorców: prostej listy pakietów (nazwa, cena, opis) oraz
cech pakietu wyciąganych podwójnym `JOIN`-em przez tabelę pośredniczącą,
gdzie to samo zapytanie powtarza się trzy razy z inną wartością `id`.
Całość w jednym pliku: `index.php`.

## Struktura projektu

```text
10_projekt_medica/
├── 01_wyswietlanie_pakietow/         -> nazwa, cena, opis (h3 + p)
├── 02_generowanie_cech_abonamentu/   -> JOIN N:M, cechy trzech pakietów
└── index.php                         -> STRONA PRZYCHODNI: oba moduły
```

`index.php` sam otwiera i zamyka połączenie z bazą `medica` (styl
obiektowy: `$conn->query()`, `$result->fetch_assoc()`, `$conn->close()`).

---

## Ściągawka wzorców

### 1. Lista pakietów abonamentowych

```php
$result = $conn->query("SELECT nazwa, cena, opis FROM abonamenty");

while ($row = $result->fetch_assoc()) {
    echo "<article>";
    echo "<h3>" . $row['nazwa'] . " - " . $row['cena'] . " zł</h3>";
    echo "<p>" . $row['opis'] . "</p>";
    echo "</article>";
}
```

Zwykła pętla po wszystkich wierszach tabeli `abonamenty` — bez `WHERE`,
bez `JOIN`. Nazwa i cena trafiają razem do jednego `<h3>`, opis do
osobnego `<p>`.

→ Pełne wytłumaczenie: [`01_wyswietlanie_pakietow/README.md`](./01_wyswietlanie_pakietow/README.md)

### 2. Cechy pakietu (podwójny JOIN, powtórzony dla trzech ID)

```php
$query = "SELECT cechy.opis
          FROM abonamenty
          JOIN szczegolyabonamentu ON abonamenty.id = szczegolyabonamentu.id_abonamentu
          JOIN cechy ON szczegolyabonamentu.id_cechy = cechy.id
          WHERE abonamenty.id = 1";

$result = $conn->query($query);

echo "<ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row['opis'] . "</li>";
}
echo "</ul>";
// dokładnie to samo zapytanie powtórzone z WHERE abonamenty.id = 2, potem = 3
```

Relacja wiele-do-wielu (pakiet ↔ cecha) przechodzi przez tabelę
`szczegolyabonamentu`, dlatego potrzebne są dwa `JOIN`-y z rzędu. Kod nie
jest tu pisany w pętli po wszystkich pakietach — to samo zapytanie
wklejone jest trzykrotnie, osobno dla `id = 1` (Standardowy), `2`
(Premium) i `3` (Dziecko), każdy w swojej sekcji `<section>`.

→ Pełne wytłumaczenie: [`02_generowanie_cech_abonamentu/README.md`](./02_generowanie_cech_abonamentu/README.md)

---

## Tabela referencyjna

| Plik / moduł                     | Kluczowa funkcja                    | Do czego służy                     |
| -------------------------------- | ----------------------------------- | ---------------------------------- |
| Połączenie                       | `new mysqli(..., "medica")`         | Styl obiektowy                     |
| `01_wyswietlanie_pakietow`       | `while` bez `WHERE`/`JOIN`          | Opisy wszystkich pakietów          |
| `02_generowanie_cech_abonamentu` | podwójny `JOIN`, `WHERE id = 1/2/3` | Cechy Standard / Premium / Dziecko |
