> **Krok 3 z 3** | [W Kroku 2](../02_lista_maturzystow_get_linki/README.md) link wysłał `id`, `imie` i `nazwisko`. Teraz **Skrypt 3** na `wynik.php`: nagłówek z GET i wyniki z `JOIN`.

---

# Kompletny przewodnik: Skrypt 3 — odczyt GET, `<h2>` oraz `JOIN` po `symbol`

Ta ściąga wytłumaczy Ci **od A do Z** trzy parametry z adresu, złączenie tabel `arkusz` i `wynik` oraz układ `<h3>` + `<p>` dla każdego arkusza.

---

## SEC-1: Odczyt `id`, `imie`, `nazwisko` z `$_GET`

Adres: `wynik.php?id=5&imie=Anna&nazwisko=Kowalska`

```php
$id = $_GET["id"];
$imie = $_GET["imie"];
$nazwisko = $_GET["nazwisko"];
```

W kontrolce bywa wersja ze strażnikiem (gdy ktoś wejdzie bez parametrów):

```php
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
$imie = isset($_GET["imie"]) ? $_GET["imie"] : "";
$nazwisko = isset($_GET["nazwisko"]) ? $_GET["nazwisko"] : "";
```

- **`$id`** — do SQL (`WHERE wynik.maturzysta_id = $id`).
- **`$imie` / `$nazwisko`** — **tylko na ekran**, nie do tego zapytania JOIN.

Arkusz nie każe tu wartości domyślnej jak `7` w projekcie przepisów — strona szczegółów zakłada kliknięcie z listy.

---

## SEC-2: Imię i nazwisko w `<h2>` (dane z GET, nie z SELECT)

```php
echo "<h2>" . $imie . " " . $nazwisko . "</h2>";
```

Nie musisz robić `SELECT imie, nazwisko FROM maturzysta WHERE id = …`, bo te pola już przyszły w URL. Zapytanie SQL służy **wynikom arkuszy**, nie powtórzeniu imienia.

---

## SEC-3: Zapytanie JOIN — `arkusz.symbol = wynik.symbol`

```sql
SELECT arkusz.rok, arkusz.sesja, arkusz.przedmiot, wynik.punkty
FROM arkusz
JOIN wynik ON arkusz.symbol = wynik.symbol
WHERE wynik.maturzysta_id = $id;
```

- **`arkusz`** — rok, sesja, przedmiot (opis egzaminu).
- **`wynik`** — punkty konkretnego maturzysty na danym arkuszu.
- **`ON arkusz.symbol = wynik.symbol`** — wspólny kod arkusza (nie `id` ucznia).
- **`WHERE wynik.maturzysta_id = $id`** — tylko kliknięty uczeń.

Wiele wierszy (kilka przedmiotów / sesji) → **`while`**.

Klucze: `$row["rok"]`, `$row["sesja"]`, `$row["przedmiot"]`, `$row["punkty"]`.

---

## SEC-4: Dla każdego wiersza — `<h3>` i `<p>` z dwukropkiem

Arkusz:

- w **`<h3>`**: rok i sesja,
- w **`<p>`**: przedmiot i punkty **oddzielone dwukropkiem**.

```php
while ($row = mysqli_fetch_assoc($res)) {
    echo "<h3>" . $row["rok"] . " " . $row["sesja"] . "</h3>";
    echo "<p>" . $row["przedmiot"] . ": " . $row["punkty"] . "</p>";
}
```

Przykład: nagłówek `2023 maj`, paragraf `matematyka: 86`.

Spacja między rokiem a sesją; po dwukropku spacja przed punktami.

---

# Podsumowanie przepływu danych

```text
wynik.php?id=5&imie=Anna&nazwisko=Kowalska
                 ↓
<h2>Anna Kowalska</h2>     ← GET, bez SQL
                 ↓
JOIN arkusz + wynik ON symbol
WHERE maturzysta_id = 5
                 ↓
while:
  <h3>rok sesja</h3>
  <p>przedmiot: punkty</p>
```

Na tej samej stronie, w `#drugi`, wklejasz ponownie **Skrypt 1** (statystyki globalne, nie tego ucznia).

---

# Ściągawka

| **Pojęcie**                 | **Co robi?**                                       |
| --------------------------- | -------------------------------------------------- |
| **`$_GET["imie"]`**         | Imię z linku do `<h2>`.                            |
| **`$_GET["id"]`**           | Filtr wyników w SQL.                               |
| **`JOIN … ON symbol`**      | Łączy opis arkusza z punktami.                     |
| **`<h3>` rok + sesja**      | Nagłówek jednego egzaminu.                         |
| **`<p>` przedmiot: punkty** | Dwukropek zgodnie z arkuszem.                      |

---

### Gratulacje!

Masz pełny cykl: statystyki agregujące, listę GET z trzema parametrami oraz kartę wyników ze złączeniem po `symbol`.

🏠 **[Wróć do głównego spisu treści](../README.md)**
