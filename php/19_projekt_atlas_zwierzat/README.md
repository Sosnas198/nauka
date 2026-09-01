# Projekt PHP + MySQLi: Atlas zwierząt (baza `baza`)

**Słowa kluczowe:** formularz POST + `if/elseif` (mapowanie liczby na tekst), stary styl `JOIN` przecinkiem (`FROM a, b WHERE ...`), `fetch_array` po nazwie i po indeksie, argument nazwany (`query: $sql`).

Projekt uczy dwóch wariantów tego samego zapytania: raz przefiltrowanego
przez `WHERE` do jednej wybranej grupy (gromady), raz bez filtra — dla
pełnej listy. Dobra okazja, żeby zobaczyć różnicę między odczytem wiersza
po nazwie kolumny a po numerze indeksu. Całość w jednym pliku: `index.php`.

## Struktura projektu

```text
19_projekt_atlas_zwierzat/
├── 01_wyswietlanie_gromady/    -> formularz POST + WHERE (jedna gromada)
├── 02_wszystkie_zwierzeta/     -> ten sam JOIN bez filtra (cała lista)
└── index.php                   -> STRONA: formularz + oba wyniki obok siebie
```

`index.php` sam otwiera połączenie z bazą `baza` (`new mysqli(...)`) i sam
je zamyka (`$conn->close()`) na końcu pliku. Moduł 1 renderuje się w
`<div id="srodek">` i wykonuje się tylko po wysłaniu formularza, moduł 2
w `<div id="prawy">` i wykonuje się zawsze, niezależnie od formularza.

---

## Ściągawka wzorców

### 1. Formularz POST: nagłówek + zapytanie z `WHERE`

```php
if (isset($_POST["gromada"])) {
    $gromada = $_POST["gromada"];

    if ($gromada == 1) {
        echo "<h2>RYBY</h2>";
    } elseif ($gromada == 2) {
        echo "<h2>PŁAZY</h2>";
    } // ... i tak dalej do 5 (GADY, PTAKI, SSAKI)

    $sql = "SELECT gatunek, wystepowanie
            FROM zwierzeta, gromady
            WHERE zwierzeta.Gromady_id = gromady.id AND gromady.id = $gromada";
    $result = $conn->query(query: $sql);

    while ($row = $result->fetch_array()) {
        echo $row["gatunek"] . ", " . $row["wystepowanie"] . "<br>";
    }
}
```

Ta sama liczba z formularza (`$gromada`) robi dwie niezależne rzeczy:
najpierw seria `if/elseif` (porównanie `==`, nie `===` — działa mimo że
dane z formularza to zawsze tekst) tłumaczy ją na nazwę gromady w
nagłówku, bez dotykania bazy. Potem trafia jako dodatkowy warunek
`AND gromady.id = $gromada` do zapytania, które filtruje wynik do jednej
gromady. `FROM zwierzeta, gromady` to starszy, "przecinkowy" zapis
złączenia tabel — działa jak `JOIN`, ale wymaga warunku dopasowania
(`zwierzeta.Gromady_id = gromady.id`) w `WHERE`, inaczej SQL skrzyżowałby
każdy wiersz z każdym. `query: $sql` to argument nazwany (PHP 8+) — robi
dokładnie to samo co `$conn->query($sql)`.

→ Pełne wytłumaczenie: [`01_wyswietlanie_gromady/README.md`](./01_wyswietlanie_gromady/README.md)

### 2. Pełna lista zwierząt (ten sam JOIN, bez filtra)

```php
$sql = "SELECT zwierzeta.id, zwierzeta.gatunek, gromady.nazwa
        FROM zwierzeta, gromady
        WHERE zwierzeta.Gromady_id = gromady.id";
$result = $conn->query(query: $sql);

while ($row = $result->fetch_array()) {
    echo $row[0] . ". " . $row[1] . " " . $row[2] . "<br>";
}
```

Dokładnie ten sam mechanizm złączenia co w module 1, ale bez warunku
`AND gromady.id = ...` — więc zwraca komplet zwierząt razem z nazwą ich
gromady. Tym razem wiersz odczytywany jest **po numerze indeksu**
(`$row[0]`, `$row[1]`, `$row[2]`) zamiast po nazwie kolumny — kolejność
numerów odpowiada dokładnie kolejności kolumn w `SELECT`, więc zmiana
kolejności w zapytaniu wymagałaby też zmiany numerów tutaj.

→ Pełne wytłumaczenie: [`02_wszystkie_zwierzeta/README.md`](./02_wszystkie_zwierzeta/README.md)

---

## Tabela referencyjna

| Plik / moduł              | Kluczowa funkcja                                                     | Do czego służy                  |
| ------------------------- | -------------------------------------------------------------------- | ------------------------------- |
| Połączenie                | `new mysqli(..., "baza")`                                            | Styl obiektowy                  |
| `01_wyswietlanie_gromady` | `if/elseif`, `FROM a, b WHERE ... AND ...`, `fetch_array()["nazwa"]` | Nagłówek + lista jednej gromady |
| `02_wszystkie_zwierzeta`  | ten sam JOIN bez filtra, `fetch_array()[0]`                          | Pełna lista wszystkich zwierząt |
