# Projekt PHP + MySQLi: Blog kulinarny (baza `przepisy`)

**Słowa kluczowe:** GET z wartością domyślną, `JOIN`, mapowanie liczby na tekst (`if`/`elseif`), relacja wiele-do-wielu (podwójny `JOIN`), tło CSS z pola bazy danych.

Projekt uczy pięciu wzorców na jednej, uniwersalnej stronie przepisu: ID z
wartością domyślną, JOIN do rodzaju potrawy, mapowanie liczby na tekst,
podwójny JOIN po relacji wiele-do-wielu (alergeny) oraz wstawienie pola z
bazy jako tła CSS. Całość zebrana w jednym pliku: `przepisy.php`.

## Struktura projektu

```text
02_projekt_przepisy/
├── 01_polaczenie_z_baza_i_id/    -> połączenie + $id z GET (domyślnie 7)
├── 02_wyswietlanie_rodzaju/      -> JOIN z tabelą rodzaje
├── 03_dane_potrawy_i_trudnosc/   -> nazwa, trudność słownie, kalorie
├── 04_lista_alergenow/           -> podwójny JOIN + lista alergenów
├── 05_przepis_i_tlo_css/         -> treść przepisu + tło z bazy
└── przepisy.php                  -> STRONA PRZEPISU: łączy moduły 1-5
```

`przepisy.php` to jeden uniwersalny plik — działa jako `?id=1` … `?id=10`,
a bez parametru pokazuje domyślnie przepis o ID 7. Otwiera i zamyka własne
połączenie z bazą `przepisy`.

---

## Ściągawka wzorców

### 1. Połączenie i ID z wartością domyślną

```php
$conn = new mysqli($host, $user, $pass, "przepisy");

$id = isset($_GET['id']) ? $_GET['id'] : 7;
// ...
$conn->close();
```

Standardowe połączenie MySQLi, ale dodatkowo: jeśli w adresie nie ma
`?id=...`, zmienna `$id` dostaje wartość domyślną `7`, więc strona zawsze
ma co wyświetlić, nawet bez parametru w URL.

→ Pełne wytłumaczenie: [`01_polaczenie_z_baza_i_id/README.md`](./01_polaczenie_z_baza_i_id/README.md)

### 2. Rodzaj potrawy (JOIN)

```php
$query = "SELECT rodzaje.rodzaj
          FROM potrawy
          JOIN rodzaje ON potrawy.idRodzaju = rodzaje.idRodzaju
          WHERE potrawy.idPotrawy = $id";

$row = $conn->query($query)->fetch_assoc();
echo $row['rodzaj'];
```

Tabela `potrawy` trzyma tylko ID rodzaju, a jego nazwę (`rodzaj`) trzeba
dociągnąć złączeniem z tabelą `rodzaje`. Wynik filtrowany jest do jednej
potrawy przez `WHERE ... idPotrawy = $id`.

→ Pełne wytłumaczenie: [`02_wyswietlanie_rodzaju/README.md`](./02_wyswietlanie_rodzaju/README.md)

### 3. Nazwa, trudność i kalorie

```php
$row = $conn->query("SELECT nazwa, trudnosc, kalorie FROM potrawy WHERE idPotrawy = $id")->fetch_assoc();

if ($row['trudnosc'] == 1) {
    $trudnoscTekst = "łatwe";
} elseif ($row['trudnosc'] == 2) {
    $trudnoscTekst = "średnie";
} else {
    $trudnoscTekst = "trudne";
}
```

W bazie trudność trzymana jest jako liczba `1`/`2`/`3` — `if / elseif / else`
zamienia ją na czytelny tekst przed wypisaniem w `<h2>` i paragrafie.

→ Pełne wytłumaczenie: [`03_dane_potrawy_i_trudnosc/README.md`](./03_dane_potrawy_i_trudnosc/README.md)

### 4. Lista alergenów (podwójny JOIN)

```php
$query = "SELECT alergeny.alergen
          FROM potrawy
          JOIN lista_alergenow ON potrawy.idPotrawy = lista_alergenow.idPotrawy
          JOIN alergeny ON lista_alergenow.idAlergenu = alergeny.idAlergenu
          WHERE potrawy.idPotrawy = $id";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo $row['alergen'] . " ";
}
```

Relacja wiele-do-wielu (potrawa może mieć wiele alergenów, alergen może
występować w wielu potrawach) wymaga tabeli pośredniczącej
`lista_alergenow` — stąd dwa `JOIN` z rzędu: najpierw do tabeli
pośredniczącej, potem do właściwej tabeli `alergeny`.

→ Pełne wytłumaczenie: [`04_lista_alergenow/README.md`](./04_lista_alergenow/README.md)

### 5. Treść przepisu i tło z bazy

```php
$row = $conn->query("SELECT przepis, plik FROM potrawy WHERE idPotrawy = $id")->fetch_assoc();

echo "<p>" . $row['przepis'] . "</p>";
echo "<section style='background-image: url(" . $row['plik'] . ")'>";
```

Pole `przepis` trafia wprost do treści strony. Pole `plik` (nazwa obrazka
z bazy) nie jest wyświetlane jako `<img>`, tylko wstawione do atrybutu
`style` jako `background-image` sekcji.

→ Pełne wytłumaczenie: [`05_przepis_i_tlo_css/README.md`](./05_przepis_i_tlo_css/README.md)

---

## Tabela referencyjna

| Plik / moduł                 | Kluczowa funkcja                                | Do czego służy                                 |
| ---------------------------- | ----------------------------------------------- | ---------------------------------------------- |
| `01_polaczenie_z_baza_i_id`  | `new mysqli()`, `isset($_GET['id'])`, `$id = 7` | Połączenie i ustalenie ID z wartością domyślną |
| `02_wyswietlanie_rodzaju`    | `JOIN rodzaje`, `$row['rodzaj']`                | Nagłówek z rodzajem potrawy                    |
| `03_dane_potrawy_i_trudnosc` | `if / elseif` na `trudnosc`                     | Nazwa, trudność słownie, kalorie               |
| `04_lista_alergenow`         | podwójny `JOIN` + `while` + `$row['alergen']`   | Lista alergenów oddzielonych spacją            |
| `05_przepis_i_tlo_css`       | `$row['przepis']`, `$row['plik']` w CSS inline  | Treść przepisu i tło sekcji                    |
| `przepisy.php`               | Połączenie + ID + moduły 1-5 + `$conn->close()` | Pełna strona bloga kulinarnego                 |
