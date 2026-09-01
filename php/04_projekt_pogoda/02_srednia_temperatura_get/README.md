> **Krok 2 z 2** | [W Kroku 1](../01_tabela_temperatur_i_ikony/README.md) zbudowaliśmy tabelę lipca. Teraz **Skrypt 2**: średnia temperatura **tylko** po kliknięciu odnośnika z parametrem GET.

---

# Kompletny przewodnik: Skrypt 2 — `month` w GET, `AVG`, `ROUND` i tekst „X stopni”

Ta ściąga wytłumaczy Ci **od A do Z**, kiedy w ogóle uruchamiać skrypt, jak wstawić numer miesiąca do SQL oraz jak odczytać jedną liczbę z funkcji agregującej.

---

## SEC-1: Skrypt tylko po kliknięciu odnośnika (`isset` + GET)

Arkusz: Skrypt 2 wykonuje się **tylko jeżeli zostały wysłane dane poprzez kliknięcie odnośnika (metoda GET)**.

Linki w HTML (stałe, bez PHP):

```html
<a href="index.php?month=1">Styczeń</a>
<a href="index.php?month=7">Lipiec</a>
```

Po kliknięciu adres to np. `index.php?month=7`. PHP automatycznie tworzy `$_GET["month"]`.

```php
if (isset($_GET["month"])) {
    $month = $_GET["month"];
    // tu zapytanie i echo
}
```

Bez `?month=…` (pierwsze wejście na stronę) **nie** liczysz średniej i **nie** wypisujesz liczby. Zostaje tylko stały tekst: *„Średnia temperatura dla wybranego miesiąca wynosi”*.

To **nie** jest ten sam parametr co w projekcie Korony Gór (`id` szczytu). Tutaj klucz nazywa się **`month`**, a wartość to numer miesiąca `1`–`12`.

---

## SEC-2: Zapytanie z `AVG` i `ROUND` — filtr po wybranym miesiącu

Arkusz podaje wzorzec (w miejscu id miesiąca wstawiasz wartość z GET):

```sql
SELECT ROUND(AVG(temperatura), 2) AS srednia
FROM pomiary
WHERE id_miesiac = $month;
```

### Co robią funkcje SQL?

| Fragment                 | Znaczenie                                                                 |
| ------------------------ | ------------------------------------------------------------------------- |
| **`AVG(temperatura)`**   | Średnia arytmetyczna kolumny `temperatura` (dla wierszy po `WHERE`).      |
| **`ROUND(..., 2)`**      | Zaokrąglenie wyniku do **dwóch** miejsc po przecinku.                     |
| **`AS srednia`**         | Alias — w PHP odczytasz `$row["srednia"]`, a nie długą nazwę funkcji.     |
| **`WHERE id_miesiac = $month`** | Tylko pomiary klikniętego miesiąca (1 = styczeń, 7 = lipiec, …).   |

Agregacja dzieje się **w MySQL**, nie w pętli PHP. Baza zwraca **jeden wiersz, jedną kolumnę**.

Nie wstawiasz tu `JOIN` z `miejscowosc` — arkusz liczy średnią ze wszystkich pomiarów danego miesiąca w tabeli `pomiary`.

---

## SEC-3: Jedno `fetch_assoc()` i alias `srednia`

```php
$result = $conn->query($query);
$row = $result->fetch_assoc();
```

Nie używasz `while` — jest jeden wynik agregacji.

`$row["srednia"]` to już zaokrąglona liczba (np. `18.45`). Nazwa klucza **musi** zgadzać się z aliasem `AS srednia`.

---

## SEC-4: Wyświetlenie „`<wartość> stopni`”

Arkusz: zwróconą temperaturę wyświetl w sposób **„`<wartość> stopni`”** (albo `h3`/`p` z wyliczoną średnią).

```php
echo "<p>" . $row["srednia"] . " stopni</p>";
```

Przykład na stronie: `21.37 stopni`.

Zwróć uwagę na **spację** przed słowem `stopni`. Nie dopisujesz jednostki `°C` w tym zdaniu, jeśli arkusz każe formę ze słowem „stopni”.

---

# Podsumowanie przepływu danych

```text
Klik: index.php?month=3
                 ↓
isset($_GET["month"]) → TAK
                 ↓
$month = 3
                 ↓
SELECT ROUND(AVG(temperatura), 2) AS srednia
WHERE id_miesiac = 3
                 ↓
$row["srednia"]
                 ↓
<p>… stopni</p>
```

Bez GET: warunek `isset` jest fałszywy → Skrypt 2 się **nie** wykonuje.

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie**              | **Co robi?**                                              |
| ------------------------ | --------------------------------------------------------- |
| **`?month=X`**           | Parametr GET z odnośnika miesiąca.                        |
| **`isset($_GET["month"])`** | Strażnik: skrypt tylko po kliknięciu.                  |
| **`AVG()`**              | Średnia w SQL.                                            |
| **`ROUND(..., 2)`**      | Dwa miejsca po przecinku.                                 |
| **`AS srednia`**         | Klucz w `$row["srednia"]`.                                |
| **`… stopni`**           | Dokładna forma wyświetlenia z arkusza.                    |

---

### Gratulacje!

Masz pełny cykl strony pogody: stała tabela lipca z ikonami oraz średnia miesiąca liczona w bazie po GET.

🏠 **[Wróć do głównego spisu treści](../README.md)**
