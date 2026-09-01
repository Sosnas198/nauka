# Kompletny przewodnik: Wyszukiwanie miast po fragmencie nazwy (JOIN + LIKE) i budowa nagłówka tabeli

Ta ściąga wytłumaczy Ci **od A do Z**, jak PHP buduje zapytanie SQL łączące dwie tabele i wyszukujące miasta zaczynające się od podanej frazy, oraz jak przygotowuje nagłówek tabeli HTML na wyniki.

---

## SEC-1: Zapytanie z połączeniem tabel (`JOIN`) i wyszukiwaniem częściowym (`LIKE`)

```php
$sql = "SELECT miasta.nazwa AS miasta_nazwa, wojewodztwa.nazwa AS wojewodztwa_nazwa FROM miasta JOIN wojewodztwa ON wojewodztwa.id = id_wojewodztwa WHERE miasta.nazwa LIKE '$miasto%' ORDER BY miasta.nazwa;";
$result = $conn->query($sql);
```

### Jak to działa? Rozbijmy to zapytanie SQL na części

- **`SELECT miasta.nazwa AS miasta_nazwa, wojewodztwa.nazwa AS wojewodztwa_nazwa`** – wybieramy dwie kolumny o nazwie `nazwa`, ale **z dwóch różnych tabel** (`miasta` i `wojewodztwa`). Ponieważ obie tabele mają kolumnę o identycznej nazwie `nazwa`, musimy:
  - poprzedzić ją nazwą tabeli (`miasta.nazwa`, `wojewodztwa.nazwa`), żeby jednoznacznie wskazać, o którą chodzi,
  - nadać jej alias za pomocą **`AS`** (np. `AS miasta_nazwa`) — czyli "tymczasową, unikalną nazwę" dla wyniku zapytania. Dzięki temu w PHP, przy odczytywaniu wyniku, będziemy mogli odwołać się po prostu do `$row['miasta_nazwa']` i `$row['wojewodztwa_nazwa']`, bez konfliktu nazw.
- **`FROM miasta JOIN wojewodztwa ON wojewodztwa.id = id_wojewodztwa`** – łączymy tabelę `miasta` z tabelą `wojewodztwa`. Warunek złączenia mówi: *"połącz każde miasto z tym województwem, którego `id` zgadza się z kolumną `id_wojewodztwa` w tabeli miast"*. Dzięki temu przy każdym mieście od razu mamy dostępną nazwę województwa, w którym leży — mimo że te dane fizycznie siedzą w dwóch osobnych tabelach.
- **`WHERE miasta.nazwa LIKE '$miasto%'`** – to jest filtr wyszukiwania częściowego:
  - **`LIKE`** – operator SQL do porównywania tekstu we "wzorcowy" sposób (nie musi być identyczny, wystarczy pasujący wzorzec).
  - **`'$miasto%'`** – wzorzec zbudowany z wartości zmiennej `$miasto` (odczytanej z formularza w module `01_sprawdzenie_formularza_i_filtra`) oraz znaku **`%`** na końcu. Znak `%` w `LIKE` oznacza *"dowolny ciąg znaków (także pusty)"*. Zapis `'$miasto%'` (np. `'Wro%'`) oznacza więc: *"nazwa miasta zaczynająca się dokładnie od liter `Wro`, a potem może być cokolwiek"* — pasować będą np. "Wrocław", "Wronki" itd. Gdyby `%` było też z przodu (`'%$miasto%'`), pasowałyby też miasta zawierające tę frazę w środku nazwy — ale w tym zadaniu wymagane jest wyszukiwanie **od początku** nazwy, dlatego `%` występuje tylko na końcu.
- **`ORDER BY miasta.nazwa`** – sortuje znalezione miasta alfabetycznie po nazwie.
- **`$conn->query($sql)`** – wysyła tak zbudowane zapytanie do bazy danych przez połączenie `$conn` (moduł `02_polaczenie_z_baza`) i zapisuje zwrócony zestaw wyników do `$result`.

---

## SEC-2: Rozpoczęcie tabeli HTML i wypisanie wiersza nagłówkowego

```php
echo "<table>";
    echo "<tr>";
        echo "<th>Miasto</th>";
        echo "<th>Województwo</th>";
    echo "</tr>";
```

### Jak to działa?

- **`echo "<table>";`** – wypisuje na stronę znacznik otwierający tabelę HTML. Od tego miejsca wszystko, co wypiszemy dalej (aż do `</table>`), będzie wnętrzem tej tabeli.
- **`echo "<tr>";`** – otwiera pierwszy wiersz tabeli — właśnie ten, który będzie zawierał **nagłówki kolumn** (a nie jeszcze dane).
- **`echo "<th>Miasto</th>";`** i **`echo "<th>Województwo</th>";`** – wypisują dwie komórki nagłówkowe (`<th>` = *table header*, czyli komórka nagłówkowa, zwykle pogrubiona przez przeglądarkę). To są stałe, niezmienne napisy — nie pochodzą z bazy danych, tylko wprost z wymagań zadania ("Miasto", "Województwo").
- **`echo "</tr>";`** – zamyka wiersz nagłówkowy.
- Zwróć uwagę na wcięcia w kodzie (spacje przed kolejnymi `echo`) — nie mają one żadnego znaczenia dla działania PHP, służą wyłącznie **czytelności kodu** dla programisty, żeby wizualnie było widać, co jest "w środku" tabeli, a co jest wierszem, a co komórką.
- Ten fragment wykonuje się **tylko raz**, zanim jeszcze zaczniemy wypisywać właściwe wyniki wyszukiwania — te pojawią się w kolejnym module, w osobnych wierszach `<tr>` dodawanych w pętli.

---

# Podsumowanie przepływu danych

```text
SEC-1: SELECT ... FROM miasta JOIN wojewodztwa ON ... WHERE miasta.nazwa LIKE '$miasto%' ORDER BY ...
       — Wyszukanie w bazie miast zaczynających się od podanej frazy, wraz z nazwą województwa
                 ↓
SEC-2: echo "<table>"; echo "<tr><th>Miasto</th><th>Województwo</th></tr>";
       — Rozpoczęcie tabeli HTML i wypisanie wiersza z nagłówkami kolumn
                 ↓
       (dalej: moduł 04 — wypisanie znalezionych wyników w kolejnych wierszach)
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**       | **Co oznacza / Co robi?**                                                                    |
| ------------------------------ | ------------------------------------------------------------------------------------------------ |
| **`JOIN ... ON ...`**          | Łączy dwie tabele w bazie danych na podstawie wspólnej kolumny (tu: id województwa).             |
| **`AS alias`**                 | Nadaje kolumnie wynikowej tymczasową, unikalną nazwę, żeby uniknąć konfliktu nazw kolumn.         |
| **`LIKE 'fraza%'`**            | Wyszukuje teksty **zaczynające się** od podanej frazy (`%` = dowolny dalszy ciąg znaków).         |
| **`ORDER BY`**                 | Sortuje wyniki zapytania według wskazanej kolumny.                                                |
| **`<table>`, `<tr>`, `<th>`**  | Znaczniki HTML: tabela, wiersz tabeli, komórka nagłówkowa.                                        |
