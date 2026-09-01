# Projekt PHP + MySQLi: Wyprawy (baza `wyprawy`)

**Słowa kluczowe:** lista rozwijana z bazy, prepared statement, symulacja kosztu (obliczenia w PHP, zniżka procentowa), karty produktów (`class="wycieczka"`).

Projekt uczy trzech wzorców: listy miejsc do wyboru, symulacji kosztu
liczonej w PHP na podstawie ceny pobranej prepared statementem (dorośli
pełna cena, dzieci połowa) oraz wyświetlania ofert jako kart z obrazem.
Całość w jednym pliku: `index.php`.

## Struktura projektu

```text
15_projekt_wyprawy/
├── 01_lista_rozwijana_miejsca/  -> <select> miejsc z bazy
├── 02_symulacja_kosztu/         -> POST + prepared statement + obliczenia
├── 03_bloki_wycieczek/          -> karty .wycieczka: obraz, nazwa, cena
└── index.php                    -> STRONA BIURA: wszystkie 3 moduły
```

`index.php` sam otwiera i zamyka połączenie z bazą `wyprawy`.

---

## Ściągawka wzorców

### 1. Lista rozwijana miejsc

```php
$result = $conn->query("SELECT nazwa FROM miejsca ORDER BY nazwa");

echo "<select name='miejsce'>";
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['nazwa'] . "'>" . $row['nazwa'] . "</option>";
}
echo "</select>";
```

Zwykłe wypełnienie `<select>` wartościami z bazy, posortowane
alfabetycznie — bez filtra, bez JOIN-a.

→ Pełne wytłumaczenie: [`01_lista_rozwijana_miejsca/README.md`](./01_lista_rozwijana_miejsca/README.md)

### 2. Symulacja kosztu (prepared statement + obliczenia w PHP)

```php
if (isset($_POST['symuluj'])) {
    $miejsce = $_POST['miejsce'];
    $dorosli = $_POST['dorosli'];
    $dzieci  = $_POST['dzieci'];
    $termin  = $_POST['termin'];

    $stmt = $conn->prepare("SELECT cena FROM miejsca WHERE nazwa = ?");
    $stmt->bind_param("s", $miejsce);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    $koszt = $row['cena'] * $dorosli + $row['cena'] * 0.5 * $dzieci;

    echo "<p>W dniu: " . $termin . "</p>";
    echo "<p>" . $koszt . " złotych</p>";
}
```

Cena pojedynczego miejsca pobierana jest prepared statementem (jeden
placeholder `?` typu string). Sam koszt — jak w projekcie bazar — liczony
jest w PHP, nie w SQL: dorośli płacą pełną cenę, dzieci połowę
(`cena * 0.5`), a wynik to suma obu.

→ Pełne wytłumaczenie: [`02_symulacja_kosztu/README.md`](./02_symulacja_kosztu/README.md)

### 3. Karty wycieczek

```php
$result = $conn->query("SELECT nazwa, cena, link_obraz FROM miejsca");

while ($row = $result->fetch_assoc()) {
    echo "<div class='wycieczka'>";
    echo "<img src='" . $row['link_obraz'] . "'>";
    echo "<h3>" . $row['nazwa'] . "</h3>";
    echo "<p>" . $row['cena'] . " zł</p>";
    echo "</div>";
}
```

Prosta pętla po wszystkich miejscach, gdzie każdy wiersz staje się jedną
kartą `<div class="wycieczka">` z obrazem, nazwą i ceną — bez filtrów i
złączeń.

→ Pełne wytłumaczenie: [`03_bloki_wycieczek/README.md`](./03_bloki_wycieczek/README.md)

---

## Tabela referencyjna

| Plik / moduł                 | Kluczowa funkcja                     | Do czego służy           |
| ---------------------------- | ------------------------------------ | ------------------------ |
| `01_lista_rozwijana_miejsca` | `ORDER BY nazwa`                     | Select miejsc            |
| `02_symulacja_kosztu`        | `prepare`/`bind_param`, `cena * 0.5` | Termin + wyliczona kwota |
| `03_bloki_wycieczek`         | `link_obraz`, `class="wycieczka"`    | Karty ofert              |
