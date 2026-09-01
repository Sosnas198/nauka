# Projekt PHP + MySQLi: Wykaz chorób (baza `choroby`)

**Słowa kluczowe:** filtr `WHERE` na wartości tekstowej, lista rozwijana (`<select>` z bazy), formularz POST, relacja wiele-do-wielu (`JOIN` przez tabelę pośredniczącą).

Projekt uczy trzech wzorców: listy filtrowanej warunkiem tekstowym,
generowania opcji `<select>` z bazy oraz obsługi formularza POST z
JOIN-em przez tabelę pośredniczącą. Całość w jednym pliku: `zdrowie.php`.

## Struktura projektu

```text
05_projekt_choroby/
├── 01_lista_chorob_zakaznych/    -> lista chorób zakaźnych (WHERE + ORDER BY)
├── 02_rozwijana_lista_select/    -> <select> wypełniany z bazy
├── 03_objawy_choroby_post_join/  -> objawy po POST (JOIN przez tabelę łączącą)
└── zdrowie.php                   -> STRONA: lista + formularz + wynik
```

`zdrowie.php` sam otwiera i zamyka połączenie z bazą `choroby`.

---

## Ściągawka wzorców

### 1. Lista chorób zakaźnych

```php
$result = $conn->query("SELECT nazwa FROM choroby WHERE zakazna = 'T' ORDER BY nazwa ASC");

while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row['nazwa'] . "</li>";
}
```

`WHERE zakazna = 'T'` filtruje tylko choroby oznaczone jako zakaźne
(kolumna trzyma wartość tekstową `'T'`/`'N'`, nie liczbę). Wynik
wypisywany jest jako kolejne `<li>` wewnątrz gotowego już `<ol>` w HTML.

→ Pełne wytłumaczenie: [`01_lista_chorob_zakaznych/README.md`](./01_lista_chorob_zakaznych/README.md)

### 2. Rozwijana lista (`<select>`)

```php
$result = $conn->query("SELECT id, nazwa FROM choroby");

while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['id'] . "'>" . $row['nazwa'] . "</option>";
}
```

`value` to ID choroby — to ono zostanie wysłane formularzem, a użytkownik
widzi tylko `nazwa`. To rozróżnienie (co widać vs. co faktycznie leci w
danych formularza) jest tu kluczowe.

→ Pełne wytłumaczenie: [`02_rozwijana_lista_select/README.md`](./02_rozwijana_lista_select/README.md)

### 3. Objawy wybranej choroby (POST + JOIN)

```php
if (isset($_POST['sprawdz'])) {
    $id = $_POST['choroba'];

    $query = "SELECT objawy.nazwa
              FROM objawy
              JOIN choroby_objawy ON objawy.id = choroby_objawy.id_objawu
              WHERE choroby_objawy.id_choroby = $id";

    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        echo "<span>" . $row['nazwa'] . "</span> ";
    }
}
```

Skrypt uruchamia się tylko po wysłaniu formularza (`isset($_POST['sprawdz'])`).
Choroba i objaw łączą się przez tabelę pośredniczącą `choroby_objawy` (ten
sam wzorzec relacji wiele-do-wielu, co JOIN-y w innych projektach). Każdy
objaw trafia do osobnego `<span>`, ze spacją między nimi.

→ Pełne wytłumaczenie: [`03_objawy_choroby_post_join/README.md`](./03_objawy_choroby_post_join/README.md)

---

## Tabela referencyjna

| Plik / moduł                  | Kluczowa funkcja                            | Do czego służy                 |
| ----------------------------- | ------------------------------------------- | ------------------------------ |
| Połączenie                    | `new mysqli(..., "choroby")`                | Most do bazy                   |
| `01_lista_chorob_zakaznych`   | `WHERE zakazna = 'T'`, `<ol><li>`           | Lista chorób zakaźnych         |
| `02_rozwijana_lista_select`   | `<option value="id">nazwa</option>`         | Wybór choroby w formularzu     |
| `03_objawy_choroby_post_join` | `isset($_POST[...])`, `JOIN choroby_objawy` | Objawy po kliknięciu „Sprawdź” |
| `zdrowie.php`                 | Moduły 01 + 02 + 03                         | Cała strona z arkusza          |
