# Projekt PHP + MySQLi: koło szachowe (ranking / losowanie pary)

**Słowa kluczowe:** wspólne połączenie (`mysqli`), filtrowanie `WHERE`, sortowanie `ORDER BY ... DESC`, ręczny licznik pozycji (`$i++`), `isset($_POST[...])` jako strażnik akcji przycisku, losowanie `ORDER BY RAND() LIMIT`, otwieranie znacznika HTML przed pętlą i zamykanie po niej.

Projekt uczy dwóch wzorców opartych na tej samej tabeli (`zawodnicy`): wyświetlenia
przefiltrowanego i posortowanego rankingu z ręczną numeracją wierszy oraz
losowania rekordów po kliknięciu przycisku formularza. Całość jest zebrana w
jednym działającym pliku: `szachy.php`. Poniżej znajdziesz **esencję każdego
wzorca** — jeśli tylko chcesz sobie przypomnieć jak coś działało, masz to
tutaj. Pełne, powolne tłumaczenie "od zera" (z podziałem na sekcje SEC-1,
SEC-2...) znajduje się w README każdego podfolderu.

## Struktura projektu

```text
24_projekt_szachy/
├── 01_ranking_zawodnikow/    -> tabela rankingowa (WHERE + ORDER BY + licznik)
├── 02_losowanie_pary/        -> losowanie dwóch graczy po kliknięciu przycisku
└── szachy.php                -> pełna strona: formularz + oba skrypty razem
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.php`
(czysta implementacja wzorca). `szachy.php` łączy te wzorce w działającą
stronę — oba korzystają z jednego, wspólnego połączenia z bazą, otwartego raz
na górze pliku i zamkniętego raz na dole.

> **Uwaga:** plik odwołuje się do `styles.css` i `logo.png`, których nie było
> w treści zadania — trzeba je samodzielnie dodać, żeby strona wyglądała
> poprawnie.

---

## Ściągawka wzorców

### 1. Wspólne połączenie z bazą

```php
$conn = new mysqli("localhost", "root", "", "szachy");

// ... oba skrypty korzystają z tej samej zmiennej $conn ...

$conn->close();
```

Połączenie jest tworzone **raz**, na samej górze pliku, i używane przez oba
skrypty poniżej — nie trzeba (i nie należy) otwierać go ponownie w każdym z
nich. `close()` wywołujemy dopiero na końcu, po tym jak obydwa skrypty się
wykonają.

→ Pełne wytłumaczenie: [`01_ranking_zawodnikow/README.md`](./01_ranking_zawodnikow/README.md)

### 2. Ranking z filtrem i ręcznym licznikiem

```php
$result = $conn->query("SELECT * FROM zawodnicy WHERE ranking > 2787 ORDER BY ranking DESC");

$i = 1;
while ($row = $result->fetch_assoc()) {
    echo $i . ". " . $row['pseudonim'] . " - " . $row['ranking'];
    $i++;
}
```

`WHERE ranking > 2787` odsiewa słabszych zawodników jeszcze na poziomie
zapytania SQL — PHP dostaje tylko tych, którzy spełniają warunek.
`ORDER BY ranking DESC` sortuje malejąco, więc najlepszy jest pierwszy.
Ponieważ MySQL nie numeruje wierszy, pozycję trzymamy sami w zmiennej `$i`,
zwiększając ją o 1 przy każdym obrocie pętli.

→ Pełne wytłumaczenie: [`01_ranking_zawodnikow/README.md`](./01_ranking_zawodnikow/README.md)

### 3. Losowanie pary po kliknięciu przycisku

```php
if (isset($_POST['losuj'])) {
    $result = $conn->query("SELECT * FROM zawodnicy ORDER BY RAND() LIMIT 2");

    echo "<h4>";
    while ($row = $result->fetch_assoc()) {
        echo $row['pseudonim'] . " (" . $row['klasa'] . ") ";
    }
    echo "</h4>";
}
```

`isset($_POST['losuj'])` to strażnik: kod w środku wykonuje się tylko wtedy,
gdy formularz faktycznie został wysłany (kliknięto przycisk), a nie przy
zwykłym wejściu na stronę. `ORDER BY RAND() LIMIT 2` sortuje tabelę losowo i
ucina wynik do dwóch wierszy — to prosty sposób na "wylosuj N rekordów" w
czystym SQL, bez logiki w PHP. Znacznik `<h4>` jest otwierany **przed**
pętlą i zamykany **po** niej, dzięki czemu obaj wylosowani zawodnicy trafiają
do jednego, wspólnego nagłówka zamiast dwóch osobnych.

→ Pełne wytłumaczenie: [`02_losowanie_pary/README.md`](./02_losowanie_pary/README.md)

---

## Tabela referencyjna

| Plik / moduł            | Kluczowa funkcja                                     | Do czego służy                                 |
| ----------------------- | ---------------------------------------------------- | ---------------------------------------------- |
| `01_ranking_zawodnikow` | `WHERE ... ORDER BY ... DESC`, licznik `$i` / `$i++` | Ranking najlepszych graczy z numeracją pozycji |
| `02_losowanie_pary`     | `isset($_POST[...])`, `ORDER BY RAND() LIMIT 2`      | Losowanie pary graczy po kliknięciu przycisku  |
| `szachy.php`            | moduły 1 + 2, jedno wspólne `$conn`                  | Pełna strona koła szachowego                   |
