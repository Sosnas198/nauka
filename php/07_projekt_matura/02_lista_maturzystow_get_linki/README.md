> **Krok 2 z 3** | [W Kroku 1](../01_statystyki_matur_agregacja/README.md) masz statystyki. Teraz **Skrypt 2** na `index.php`: lista maturzystów ze szkoły T3 i odnośniki z **kilkoma** parametrami GET.

---

# Kompletny przewodnik: Skrypt 2 — lista `<a>` z `id`, `imie` i `nazwisko` w adresie

Ta ściąga wytłumaczy Ci **od A do Z** filtr `szkola = 'T3'`, treść linku „id. imie nazwisko” oraz sklejanie URL z wieloma parami `klucz=wartość`.

---

## SEC-1: Zapytanie — tylko szkoła T3, alfabetycznie po nazwisku

```sql
SELECT id, imie, nazwisko FROM maturzysta WHERE szkola = 'T3' ORDER BY nazwisko ASC;
```

- **`WHERE szkola = 'T3'`** — literał tekstowy w cudzysłowie SQL (to nie liczba).
- **`ORDER BY nazwisko ASC`** — od A do Z.
- Potrzebujesz **trzech** kolumn: `id` (do GET i do treści), `imie` i `nazwisko` (do GET i do treści). Nie odpytujesz tu tabeli `wynik`.

```php
$q = "SELECT id, imie, nazwisko FROM maturzysta WHERE szkola = 'T3' ORDER BY nazwisko ASC";
$res = mysqli_query($conn, $q);
```

---

## SEC-2: Kilka parametrów GET — znak `?` i `&`

Jeden parametr: `wynik.php?id=5`.

Kolejne doklejasz **`&`**:

```text
wynik.php?id=5&imie=Anna&nazwisko=Kowalska
```

- **`id`** — do `WHERE` w Skrypcie 3 (wyniki z bazy).
- **`imie` i `nazwisko`** — Skrypt 3 **nie musi** ich znowu czytać z tabeli `maturzysta`; bierze je z adresu do `<h2>`.

W PHP składasz adres tak:

```php
$link = "wynik.php?id=" . $id . "&imie=" . $imie . "&nazwisko=" . $nazwisko;
```

Spacje i polskie znaki w URL warto zakodować (`urlencode($imie)`), żeby link się nie rozjechał. Na egzaminie bywa też wersja bez `urlencode`, jeśli imiona są „proste”.

---

## SEC-3: Treść odnośnika — `id. imie nazwisko`

Arkusz: treść **„id. imie nazwisko”**, znacznik **`<a>`**, cel **`wynik.php`**.

Przykład: `7. Jan Nowak`

```php
while ($row = mysqli_fetch_assoc($res)) {
    $id = $row["id"];
    $imie = $row["imie"];
    $nazwisko = $row["nazwisko"];

    echo "<a href='wynik.php?id=" . $id . "&imie=" . $imie . "&nazwisko=" . $nazwisko . "'>";
    echo $id . ". " . $imie . " " . $nazwisko;
    echo "</a><br>";
}
```

Kropka i spacja po numerze (`7. `) są częścią **widocznego tekstu**, nie adresu.

Każdy link w osobnej linii (`<br>`), jak w kontrolce.

---

## SEC-4: Jeden plik `wynik.php` dla wszystkich uczniów

Nie tworzysz `nowak.php`, `kowalska.php`. Pętla generuje różne adresy do **tego samego** szablonu. Różnią się tylko query stringiem. Odczyt po drugiej stronie: Moduł 3.

---

# Podsumowanie przepływu danych

```text
SELECT id, imie, nazwisko WHERE szkola = 'T3' ORDER BY nazwisko
                 ↓
while fetch_assoc
                 ↓
<a href="wynik.php?id=…&imie=…&nazwisko=…">id. imie nazwisko</a>
```

---

# Ściągawka

| **Pojęcie**              | **Co robi?**                                      |
| ------------------------ | ------------------------------------------------- |
| **`szkola = 'T3'`**      | Filtr szkoły z arkusza.                           |
| **`?`**                  | Start parametrów GET.                             |
| **`&`**                  | Kolejny parametr w tym samym adresie.             |
| **`id` / `imie` / `nazwisko`** | Trzy wartości dla `wynik.php`.              |
| **`id. imie nazwisko`**  | Widoczny tekst linku.                             |

---

### Co dalej?

Po kliknięciu otwiera się `wynik.php`. Tam **Skrypt 3** pokaże imię z GET i listę arkuszy.

👉 **[Przejdź do Kroku 3: Szczegóły wyników i JOIN](../03_szczegoly_wynikow_get_join/README.md)**
