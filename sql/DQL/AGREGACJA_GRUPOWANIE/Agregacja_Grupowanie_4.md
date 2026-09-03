Oto przejrzysty, dedykowany plik Markdown przygotowany na podstawie przesłanych materiałów (zrzutu bazy SQL `SELECT5` oraz karty zadań `Select - ćwiczenie piąte`).

Ten moduł poświęcony jest **praktycznej analizie danych w sklepie internetowym** z wykorzystaniem zapytań `SELECT`, filtrowania warunkowego, grupowania, sortowania oraz limitowania wyników.

# 🛒 Kompletny Podręcznik SQL: Analiza Danych Sklepu Internetowego (`SELECT5`)

W tym module nauczysz się:

1. Pracy z wieloma kryteriami sortowania (`ORDER BY col1, col2`).
2. Ograniczania liczby zwracanych wyników za pomocą klauzuli **`LIMIT`**.
3. Precyzyjnego filtrowania brakujących wartości **`IS NULL`** oraz pracowania z datami (`YYYY-MM-DD`).
4. Zaawansowanych analiz za pomocą **`GROUP BY`** i filtrowania zagregowanych grup za pomocą **`HAVING`**.
5. Tworzenia i przywracania kopii zapasowych bazy danych MySQL z poziomu wiersza poleceń (`mysqldump`).

## 1. Architektura Bazy Danych Sklepu (`SELECT5`)

Baza danych składa się z dwóch głównych tabel: `towary` oraz `klienci`.

### Tabela `towary` (Asortyment)

- `idtowaru` – unikalny identyfikator towaru (Klucz Główny).
- `rodzaj` – kategoria (np. _Smartfon_, _Tablet_, _Konsola_, _Aparat_).
- `producent`, `model`, `opis` – szczegóły produktu.
- `cena`, `iloscsztuk`, `wartosc` – dane finansowo-magazynowe.

### Tabela `klienci` (Klienci i Zakupy)

- `idklienta` – unikalny identyfikator klienta (Klucz Główny).
- `nazwisko`, `imie`, `miasto`, `plec` – dane demograficzne (`plec`: 'K' lub 'M').
- `liczbaodwiedzinsklepu`, `datarejestracji`, `lacznakwotazakupow` – zachowania klientów.

## 2. Praktyczne Zapytania SQL: Od Prostych po Złożone

### Zadanie A: Sortowanie wielokryterialne

Wypisz informacje o Smartfonach, posortuj wynik rosnąco wg ceny oraz producentów.

SQL

```sql id="8v3mqp"
SELECT *
FROM towary
WHERE rodzaj = 'Smartfon'
ORDER BY cena ASC, producent ASC;

```

> **🧠 Przelicznik amatora:** Gdy podajesz dwa pola w `ORDER BY`, baza najpierw sortuje dane według pierwszego pola (`cena`). Jeśli dwa towary mają taką samą cenę, o ich kolejności decyduje drugie pole (`producent`).

### Zadanie B: Ograniczanie wyników (`LIMIT`)

Wypisz 3 najtańsze produkty dostępne na magazynie (`iloscsztuk > 0`), posortowane wg ceny.

```sql id="3zqf7n"
SELECT *
FROM towary
WHERE iloscsztuk > 0
ORDER BY cena ASC
LIMIT 3;

```

- **`LIMIT N`\*\***:** Zwraca tylko pierwsze $N$ wierszy z gotowej, posortowanej listy. Zawsze stosuj `LIMIT` **na samym końcu\*\* zapytania.

### Zadanie C: Wykrywanie braków danych (`IS NULL`)

Policz, dla ilu towarów brakuje opisu w bazie.

```sql id="m4z9ka"
SELECT COUNT(*) AS brakujace_opisy
FROM towary
WHERE opis IS NULL;

```

> **Błąd początkujących:** Pamiętaj, że w SQL nie piszemy `WHERE opis = NULL`! Wartość `NULL` oznacza "brak danych" i sprawdza się ją wyłącznie operatorem **`IS NULL`** lub **`IS NOT NULL`**.

### Zadanie D: Minimum i Maksimum w kategoriach

Wypisz najtańszą i najdroższą cenę urządzenia dla każdej z kategorii (`rodzaj`).

```sql id="p6w2jx"
SELECT
    rodzaj,
    MIN(cena) AS najtaniej,
    MAX(cena) AS najdrozzej
FROM towary
GROUP BY rodzaj;

```

### Zadanie E: Grupowanie po wielu kolumnach

Policz łączną liczbę sztuk urządzeń dla każdej kategorii od każdego producenta.

```sql id="c8n5rt"
SELECT
    rodzaj,
    producent,
    SUM(iloscsztuk) AS laczna_ilosc
FROM towary
GROUP BY rodzaj, producent;

```

### Zadanie F: Filtrowanie zakresu dat

Wypisz najmniejszą i największą kwotę zakupów klientów zarejestrowanych przed 1 grudnia 2014 roku.

```sql id="r7k3mw"
SELECT
    MIN(lacznakwotazakupow) AS min_zakupy,
    MAX(lacznakwotazakupow) AS max_zakupy
FROM klienci
WHERE datarejestracji < '2014-12-01';

```

- Format daty w SQL to zawsze **`YYYY-MM-DD`** w ujęciu tekstowym (ujęty w apostrofy `' '`).

### Zadanie G: Agregacja całej tabeli

Wypisz średnią kwotę wydaną przez klientów oraz średnią liczbę odwiedzin sklepu.

```sql id="t2q8nv"
SELECT
    ROUND(AVG(lacznakwotazakupow), 2) AS srednie_zakupy,
    ROUND(AVG(liczbaodwiedzinsklepu), 2) AS srednie_odwiedziny
FROM klienci;

```

### Zadanie H: Analiza demograficzna (Płeć)

Wypisz średnią kwotę wydaną na towary w rozbiciu na kobiety ('K') i mężczyzn ('M').

```sql id="b5x9qk"
SELECT
    plec,
    ROUND(AVG(lacznakwotazakupow), 2) AS srednia_kwota
FROM klienci
GROUP BY plec;

```

### Zadanie I: Złożone grupowanie z eliminacją `NULL`

Wypisz liczbę klientów oraz średnią kwotę wydaną na towary pogrupowane wg miasta i płci. Zaokrąglij kwotę do 2 miejsc po przecinku. Pomijaj klientów bez podanego miasta.

```sql id="n6v3pz"
SELECT
    miasto,
    plec,
    COUNT(*) AS liczba_klientow,
    ROUND(AVG(lacznakwotazakupow), 2) AS srednia_kwota
FROM klienci
WHERE miasto IS NOT NULL
GROUP BY miasto, plec;

```

### Zadanie J: Filtrowanie zagregowanych wyników (`HAVING`)

Wypisz dla każdego rodzaju towaru danego producenta te grupy, których łączna ilość na magazynie jest mniejsza niż 3 sztuki.

```sql id="k4y7ms"
SELECT
    rodzaj,
    producent,
    SUM(iloscsztuk) AS lacznie_sztuk
FROM towary
GROUP BY rodzaj, producent
HAVING SUM(iloscsztuk) < 3;

```

> **Różnica w działaniu:**
>
> - `WHERE` przefiltrowałoby pojedyncze wiersze przed zsumowaniem.
> - **`HAVING`** sprawdza obliczoną sumę (`SUM(iloscsztuk)`) dopierodostarczoną po zgrupowaniu.

### Zadanie K: Statystyki cenowe dla kategorii

Dla każdego rodzaju towaru wypisz cenę minimalną, maksymalną oraz średnią (zaokrągloną do 2 miejsc po przecinku).

```sql id="q9w4jx"
SELECT
    rodzaj,
    MIN(cena) AS cena_min,
    MAX(cena) AS cena_max,
    ROUND(AVG(cena), 2) AS cena_srednia
FROM towary
GROUP BY rodzaj;

```

### Zadanie L: Top 3 Klientki (Łączenie warunków, sortowania i limitu)

Znajdź 3 klientki (kobiety), które zakupiły towary za największą kwotę.

```sql id="z3m8pv"
SELECT *
FROM klienci
WHERE plec = 'K'
ORDER BY lacznakwotazakupow DESC
LIMIT 3;

```

## 3. Zarządzanie Bazą: Backup i Przywracanie (Terminal / CLI)

Oprócz pisania samych zapytań, jako administrator bazy musisz umieć tworzyć kopie zapasowe (dump) oraz je przywracać. Operacje te wykonuje się w wierszu poleceń systemu operacyjnego (CMD / Bash).

### 📤 1. Tworzenie kopii bazy danych (`mysqldump`)

Tworzy plik `.sql` zawierający kompletny kod zrzutu struktury i danych:

Bash

```bash id="u5n2kr"
mysqldump -u user -p select5 > kopia_select5.sql

```

- **`-u user`**: nazwa użytkownika MySQL (np. `root`).
- **`-p`**: nakazuje systemowi zapytać o hasło.
- **`select5`**: nazwa bazy danych, którą kopiujemy.
- **`>`**: operator przekierowania strumienia – zapisuje wynik do pliku.

### 📥 2. Przywracanie bazy z pliku `.sql`

Wgrywa strukturę i dane z pliku kopii zapasowej do istniejącej pustej bazy danych:

```bash id="f7q4mv"
mysql -u user -p select5 < kopia_select5.sql

```

- **`<`**: operator wczytania strumienia z pliku do narzędzia `mysql`.

## 📊 Ściągawka Klauzul SQL – Prawidłowa Kolejność

Pamiętaj o sztywnej kolejności wpisywania słów kluczowych w zapytaniu `SELECT`:

```sql id="y6k3pt"
SELECT   -- 1. Określ, które kolumny/agregaty wyświetlić
FROM     -- 2. Wskazuj tabelę źródłową
WHERE    -- 3. Filtruj pojedyncze wiersze (przed grupowaniem)
GROUP BY -- 4. Grupuj dane według podanych kolumn
HAVING   -- 5. Filtruj zagregowane grupy
ORDER BY -- 6. Sortuj wyniki (ASC / DESC)
LIMIT    -- 7. Ogranicz liczbę zwracanych wierszy
```
