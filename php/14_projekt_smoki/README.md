# Projekt PHP, MySQLi i JavaScript: Smoki (baza `smoki`)

**Słowa kluczowe:** `DISTINCT`, prepared statement (`bind_param("s")`), filtr POST, JavaScript `onclick`, przełączanie widoczności (`display: block/none`), zmiana koloru tła w JS.

Projekt jako jedyny łączy PHP z bazą **i** JavaScript po stronie
przeglądarki: lista pochodzenia i tabela smoków filtrowana formularzem
(PHP + prepared statement), oraz interaktywna nawigacja bez przeładowania
strony, sterowana czystym JS. PHP w `index.php`, JS w osobnym `main.js`.

## Struktura projektu

```text
14_projekt_smoki/
├── 01_lista_rozwijana_pochodzenie/  -> DISTINCT pochodzenie do <select>
├── 02_tabela_smokow_filtr/          -> POST + prepared statement
├── 03_interaktywna_nawigacja_js/    -> JS: przełączanie sekcji i kolorów
├── index.php                        -> STRONA: 3 sekcje + formularz (PHP)
└── main.js                          -> logika nawigacji (JS, bez PHP)
```

`index.php` sam otwiera i zamyka połączenie z bazą `smoki`. Moduł 3 to
**jedyny w tym zestawie moduł czysto frontendowy** — nie dotyka bazy
danych w ogóle, działa tylko na strukturze HTML wygenerowanej wcześniej.

---

## Ściągawka wzorców

### 1. Unikalna lista pochodzenia

```php
$result = $conn->query("SELECT DISTINCT pochodzenie FROM smoki ORDER BY pochodzenie");

echo "<select name='pochodzenie'>";
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['pochodzenie'] . "'>" . $row['pochodzenie'] . "</option>";
}
echo "</select>";
```

Ten sam wzorzec `DISTINCT` co w projekcie remonty — każde pochodzenie
pojawia się na liście tylko raz, niezależnie od liczby smoków z danego
kraju w bazie.

→ Pełne wytłumaczenie: [`01_lista_rozwijana_pochodzenie/README.md`](./01_lista_rozwijana_pochodzenie/README.md)

### 2. Tabela smoków filtrowana przez POST (prepared statement)

```php
if (isset($_POST['baza'])) {
    $pochodzenie = $_POST['pochodzenie'];

    $stmt = $conn->prepare("SELECT nazwa, dlugosc, szerokosc FROM smoki WHERE pochodzenie = ?");
    $stmt->bind_param("s", $pochodzenie);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['nazwa'] . "</td><td>" . $row['dlugosc'] . "</td><td>" . $row['szerokosc'] . "</td></tr>";
    }
}
```

Filtr z wybranego w module 1 pochodzenia trafia do zapytania przez
prepared statement (`?` + `bind_param("s", ...)`), tak jak w projekcie
remonty — tu z jednym placeholderem typu string.

→ Pełne wytłumaczenie: [`02_tabela_smokow_filtr/README.md`](./02_tabela_smokow_filtr/README.md)

### 3. Interaktywna nawigacja (czysty JavaScript)

```javascript
function pokaz(sekcja) {
  const sekcje = ["baza", "opisy", "galeria"];

  sekcje.forEach(function (id) {
    document.getElementById(id).style.display =
      id === sekcja ? "block" : "none";
  });

  document.querySelectorAll("nav a").forEach(function (link) {
    link.style.backgroundColor = "#FFAEA5";
  });

  event.target.style.backgroundColor = "MistyRose";
}
```

Zamiast przeładowywać stronę, JS ukrywa wszystkie sekcje (`display =
"none"`) i pokazuje tylko tę klikniętą (`display = "block"`) —
`getElementById` odnajduje element po jego `id` w HTML. Dodatkowo klikany
link w nawigacji dostaje inny kolor tła (`MistyRose`) niż pozostałe
(`#FFAEA5`), żeby było widać, która sekcja jest aktywna.

→ Pełne wytłumaczenie: [`03_interaktywna_nawigacja_js/README.md`](./03_interaktywna_nawigacja_js/README.md)

---

## Tabela referencyjna

| Plik / moduł                     | Kluczowa funkcja                                    | Do czego służy                               |
| -------------------------------- | --------------------------------------------------- | -------------------------------------------- |
| `01_lista_rozwijana_pochodzenie` | `DISTINCT pochodzenie`                              | Select krajów pochodzenia                    |
| `02_tabela_smokow_filtr`         | `prepare`, `bind_param("s", ...)`                   | Tabela smoków po wybranym pochodzeniu        |
| `03_interaktywna_nawigacja_js`   | `onclick`, `style.display`, `style.backgroundColor` | Przełączanie sekcji bez przeładowania strony |
