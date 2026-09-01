# Projekt PHP + MySQLi proceduralne: Bazar (baza `bazar`)

**Słowa kluczowe:** styl proceduralny (`mysqli_fetch_array`), galeria (`LIMIT`), lista rozwijana, formularz POST, obliczenia w PHP przed `INSERT`.

Projekt uczy trzech wzorców: galerii ograniczonej `LIMIT`-em, listy
rozwijanej z bazy oraz obsługi zamówienia POST, gdzie cenę trzeba
przeliczyć w PHP (cena × waga) przed zapisaniem jej `INSERT`-em.
Całość w jednym pliku: `index.php`.

## Struktura projektu

```text
08_projekt_bazar/
├── 01_wyswietlanie_obrazow_towarow/    -> galeria 10 towarów (LIMIT)
├── 02_generowanie_listy_rozwijanej/    -> <select> towarów
├── 03_obsluga_zamowienia_post_insert/  -> POST, cena × waga, INSERT
└── index.php                           -> STRONA BAZARU: wszystkie 3 moduły
```

`index.php` sam łączy się z bazą `bazar` (`mysqli_connect`) i sam zamyka
połączenie (`mysqli_close`) — styl proceduralny.

**Różnica w tym projekcie:** do odczytu wiersza użyto `mysqli_fetch_array`
zamiast `mysqli_fetch_assoc`. Nie zmienia to sposobu sięgania po kolumny —
nadal robisz to po nazwie (`$row['plik']`), nie po numerze.

---

## Ściągawka wzorców

### 1. Galeria towarów

```php
$result = mysqli_query($conn, "SELECT nazwa, plik FROM towary LIMIT 10");

while ($row = mysqli_fetch_array($result)) {
    echo "<img src='" . $row['plik'] . "' alt='" . $row['nazwa'] . "'>";
}
```

`LIMIT 10` ogranicza galerię do dziesięciu towarów niezależnie od tego,
ile ich jest w bazie. `mysqli_fetch_array` zwraca wiersz zarówno z
kluczami liczbowymi, jak i nazwami kolumn — tu i tak korzysta się tylko
z nazw (`['plik']`, `['nazwa']`).

→ Pełne wytłumaczenie: [`01_wyswietlanie_obrazow_towarow/README.md`](./01_wyswietlanie_obrazow_towarow/README.md)

### 2. Lista rozwijana towarów

```php
$result = mysqli_query($conn, "SELECT id, nazwa FROM towary");

echo "<select name='id'>";
while ($row = mysqli_fetch_array($result)) {
    echo "<option value='" . $row['id'] . "'>" . $row['nazwa'] . "</option>";
}
echo "</select>";
```

Ten sam wzorzec `<option value="id">nazwa</option>` co w innych projektach
z listą rozwijaną — `value` to ID wysyłane formularzem, tekst opcji to to,
co widzi użytkownik.

→ Pełne wytłumaczenie: [`02_generowanie_listy_rozwijanej/README.md`](./02_generowanie_listy_rozwijanej/README.md)

### 3. Zamówienie (POST + przeliczenie + INSERT)

```php
if (isset($_POST['zamow'])) {
    $id   = $_POST['id'];
    $waga = $_POST['waga'];

    $row = mysqli_fetch_array(mysqli_query($conn, "SELECT nazwa, cena FROM towary WHERE id = $id"));

    $wartosc = $row['cena'] * $waga;
    echo $row['nazwa'] . ": " . $wartosc . " zł";

    mysqli_query($conn, "INSERT INTO zamowienie (id_towaru, waga, wartosc) VALUES ($id, $waga, $wartosc)");
}
```

Cena za jednostkę leży w bazie, ale wartość całego zamówienia (cena ×
waga) trzeba policzyć w PHP — SQL nic tu nie liczy. Dopiero policzoną
wartość zapisuje się `INSERT`-em do tabeli `zamowienie`, razem z ID
towaru i wagą.

→ Pełne wytłumaczenie: [`03_obsluga_zamowienia_post_insert/README.md`](./03_obsluga_zamowienia_post_insert/README.md)

---

## Tabela referencyjna

| Plik / moduł                        | Kluczowa funkcja                             | Do czego służy                  |
| ----------------------------------- | -------------------------------------------- | ------------------------------- |
| Połączenie                          | `mysqli_connect`, `mysqli_close`             | Baza `bazar`, styl proceduralny |
| Odczyt wiersza                      | `mysqli_fetch_array` (zamiast `fetch_assoc`) | Kolumny nadal po nazwie         |
| `01_wyswietlanie_obrazow_towarow`   | `LIMIT 10`, `<img>`                          | Galeria towarów                 |
| `02_generowanie_listy_rozwijanej`   | `<option value="id">nazwa</option>`          | Wybór towaru                    |
| `03_obsluga_zamowienia_post_insert` | `$_POST`, `cena * waga`, `INSERT`            | Złożenie zamówienia             |
