# Projekt PHP + MySQLi obiektowe: Szkolenia (baza `szkolenia`)

**Słowa kluczowe:** obraz budowany z kodu rekordu (`$kod . ".jpg"`), `ORDER BY`, lista rozwijana z bazy, formularz POST, walidacja `empty()`, `INSERT`.

Projekt uczy trzech wzorców: budowania ścieżki do obrazu z wartości pola
zamiast osobnej kolumny na nazwę pliku, listy rozwijanej z bazy oraz
formularza POST z walidacją pól przed zapisaniem `INSERT`-em. Całość w
jednym pliku: `index.php`.

## Struktura projektu

```text
12_projekt_szkolenia/
├── 01_tabela_kursow/            -> tabela: obraz z kodu, nazwa, cena
├── 02_lista_rozwijana_kursow/   -> <select> z nazw kursów
├── 03_obsluga_formularza_post/  -> POST + empty() + INSERT
└── index.php                    -> STRONA ZAPISÓW: wszystkie 3 moduły
```

`index.php` sam otwiera i zamyka połączenie z bazą `szkolenia` (styl
obiektowy).

---

## Ściągawka wzorców

### 1. Tabela kursów z obrazem budowanym z kodu

```php
$result = $conn->query("SELECT kod, nazwa, cena FROM kursy ORDER BY cena");

while ($row = $result->fetch_assoc()) {
    echo "<tr><td><img src='" . $row['kod'] . ".jpg'></td>";
    echo "<td>" . $row['nazwa'] . "</td><td>" . $row['cena'] . " zł</td></tr>";
}
```

W bazie nie ma osobnej kolumny z nazwą pliku obrazka — ścieżkę buduje się
doklejając `.jpg` do wartości kolumny `kod` (np. `kod = "php"` daje
`php.jpg`). `ORDER BY cena` sortuje kursy od najtańszego.

→ Pełne wytłumaczenie: [`01_tabela_kursow/README.md`](./01_tabela_kursow/README.md)

### 2. Lista rozwijana kursów

```php
$result = $conn->query("SELECT nazwa FROM kursy");

echo "<select name='kurs'>";
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['nazwa'] . "'>" . $row['nazwa'] . "</option>";
}
echo "</select>";
```

Tu, w odróżnieniu od innych projektów, `value` opcji to nie ID, tylko
sama `nazwa` kursu — bo do zapisu uczestnika wystarczy nazwa, nie trzeba
odnosić się do ID kursu w tabeli `kursy`.

→ Pełne wytłumaczenie: [`02_lista_rozwijana_kursow/README.md`](./02_lista_rozwijana_kursow/README.md)

### 3. Formularz zapisu (walidacja + INSERT)

```php
if (isset($_POST['dodaj'])) {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $wiek = $_POST['wiek'];
    $kurs = $_POST['kurs'];

    if (empty($imie) || empty($nazwisko) || empty($wiek) || empty($kurs)) {
        echo "Wprowadź wszystkie dane";
    } else {
        $conn->query("INSERT INTO uczestnicy (imie, nazwisko, wiek, kurs) VALUES ('$imie', '$nazwisko', $wiek, '$kurs')");
        echo "Dane uczestnika " . $imie . " " . $nazwisko . " zostały dodane";
    }
}
```

`empty()` sprawdza każde pole z osobna, zanim cokolwiek trafi do bazy —
jeśli **którekolwiek** jest puste, `INSERT` w ogóle się nie wykonuje i
pokazuje się komunikat o brakujących danych. Dopiero gdy wszystkie pola
są wypełnione, dane trafiają do tabeli `uczestnicy` i pojawia się
komunikat potwierdzający.

→ Pełne wytłumaczenie: [`03_obsluga_formularza_post/README.md`](./03_obsluga_formularza_post/README.md)

---

## Tabela referencyjna

| Plik / moduł                 | Kluczowa funkcja                        | Do czego służy               |
| ---------------------------- | --------------------------------------- | ---------------------------- |
| Połączenie                   | `new mysqli(..., "szkolenia")`          | Styl obiektowy               |
| `01_tabela_kursow`           | `$row['kod'] . ".jpg"`, `ORDER BY cena` | Cennik kursów z obrazem      |
| `02_lista_rozwijana_kursow`  | `<option value="nazwa">`                | Wybór kursu w formularzu     |
| `03_obsluga_formularza_post` | `empty()`, `INSERT`                     | Walidacja i zapis uczestnika |
