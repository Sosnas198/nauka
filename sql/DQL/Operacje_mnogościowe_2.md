# 🚀 Kompletny Przewodnik SQL: Operacje Mnogościowe, Agregacja i Analiza Plików

Witamy w kolejnym module nauki SQL! Tym razem zajmiemy się **operacjami mnogościowymi na zbiorach** (łączeniem, porównywaniem i wykluczaniem danych z wielu tabel), zaawansowaną agregacją danych oraz operacjami na typach dat i rozmiarach plików.

## 📚 TEORIA: Operacje Mnogościowe (Set Operations)

Gdy mamy dwie lub więcej tabel o **takiej samej strukturze kolumn**, możemy traktować ich wiersze jak elementy zbiorów matematycznych.

```text
Tabela A: [Jan, Marek]
Tabela B: [Marek, Anna]
```

### 1. `UNION` (Suma bez duplikatów)

Łączy wyniki dwóch zapytań i **usuwa powtarzające się wiersze**.

> _Wynik dla A UNION B:_ `Jan, Marek, Anna`

### 2. `UNION ALL` (Suma z duplikatami)

Łączy wyniki dwóch zapytań **zachowując wszystkie wiersze**, nawet jeśli się powtarzają. Jest to operacja znacznie szybsza, bo baza nie musi sprawdzać i unikalniać wyników.

> _Wynik dla A UNION ALL B:_ `Jan, Marek, Marek, Anna`

### 3. `INTERSECT` (Część wspólna / Iloczyn zbiorów)

Zwraca tylko te wiersze, które **występują jednocześnie** w pierwszym i drugim zapytaniu.

> _Wynik dla A INTERSECT B:_ `Marek`

### 4. `EXCEPT` / `MINUS` (Różnica zbiorów)

Zwraca wiersze z pierwszego zapytania, których **nie ma** w drugim zapytaniu.

> _Wynik dla A EXCEPT B:_ `Jan`

## 🛠️ KROK 1: Przygotowanie Struktury Bazy i Tabel

Tworzymy bazę danych oraz cztery tabele reprezentujące nośniki danych: `source1`, `source2`, `pendrive` oraz `source4`.

SQL

```sql
CREATE DATABASE IF NOT EXISTS select6;
USE select6;

-- Przykład struktury jednej z tabel (pozostałe mają identyczną)
CREATE TABLE source1 (
    FILENAME VARCHAR(20) DEFAULT NULL,
    EXTENSION CHAR(3) DEFAULT NULL,
    LENGTH INT(11) DEFAULT NULL,
    DATA DATE DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## 📊 KROK 2: Zadania Praktyczne i Zapytania SQL

Poniżej znajduje się omówienie 12 zadań krok po kroku wraz z dokładnym wyjaśnieniem logiki i poprawną składnią.

### Zadanie 1: Przeliczenie jednostek pamięci i filtrowanie

**Polecenie:** Wyświetl pliki ze źródła `source1`, które mają długość większą od 3 MB i posiadają rozszerzenie `avi` lub `pdf`.

#### 💡 Przeliczanie Bajtów:

- $1\text{ KB} = 1024\text{ B}$

- $1\text{ MB} = 1024\text{ KB} = 1024 \times 1024\text{ B} = 1\ 048\ 576\text{ B}$

- $3\text{ MB} = 3 \times 1\ 048\ 576\text{ B} = 3\ 145\ 728\text{ B}$

SQL

```sql
SELECT FILENAME, EXTENSION, LENGTH
FROM source1
WHERE LENGTH > 3145728
  AND (EXTENSION = 'avi' OR EXTENSION = 'pdf');
```

> **Wskazówka:** Używaj nawiasów przy łączeniu operatorów `AND` oraz `OR`, aby zapewnić prawidłową kolejność sprawdzania warunków logiki!

### Zadanie 2: Grupowanie i sumowanie danych (`GROUP BY`)

**Polecenie:** Pogrupuj pliki z `source2` według rozszerzeń, wyświetl ich liczbę oraz łączny rozmiar, a wynik posortuj malejąco po rozszerzeniu.

SQL

```sql
SELECT
    EXTENSION,
    COUNT(*) AS liczba_plikow,
    SUM(LENGTH) AS laczny_rozmiar
FROM source2
GROUP BY EXTENSION
ORDER BY EXTENSION DESC;
```

- **`SUM(LENGTH)`**: Sumuje bajty wszystkich plików w danej grupie rozszerzeń.
- **`COUNT(*)`**: Zlicza ile plików należy do każdego rozszerzenia.

### Zadanie 3: Suma mnogościowa bez powtórzeń (`UNION`)

**Polecenie:** Wyświetl wszystkie różne pliki (różniące się przynajmniej jednym z pól) dostępne w `source1` i `source2`, posortowane rosnąco według nazw.

SQL

```sql
SELECT * FROM source1
UNION
SELECT * FROM source2
ORDER BY FILENAME ASC;
```

- Słowo `UNION` automatycznie porówna całe wiersze i odrzuci te, które w obu tabelach są identyczne.

### Zadanie 4: Suma mnogościowa z powtórzeniami (`UNION ALL`)

**Polecenie:** Wyświetl nazwy i rozszerzenia plików z obu źródeł (`source1`, `source2`), uwzględniając także te, które się powtarzają.

SQL

```sql
SELECT FILENAME, EXTENSION FROM source1
UNION ALL
SELECT FILENAME, EXTENSION FROM source2
ORDER BY FILENAME ASC;
```

- Użycie `UNION ALL` zachowuje duplikaty i wykonuje się szybciej.

### Zadanie 5: Łączenie filtrowanych wyników z dwóch źródeł

**Polecenie:** Wyświetl wszystkie pliki na źródłach `pendrive` oraz `source2`, które mają rozszerzenie `txt` lub `exe`.

SQL

```sql
SELECT * FROM pendrive WHERE EXTENSION IN ('txt', 'exe')
UNION
SELECT * FROM source2 WHERE EXTENSION IN ('txt', 'exe')
ORDER BY FILENAME ASC;
```

- Operator `IN ('txt', 'exe')` stanowi czytelniejszy zapis zamiast wielokrotnego `OR`.

### Zadanie 6: Różnica zbiorów (`EXCEPT` / `NOT EXISTS`)

**Polecenie:** Wyświetl nazwy plików dostępnych na źródle `pendrive`, które nie występują na `source1`.

SQL

```sql
-- Standardowy SQL (oraz MariaDB/MySQL 8.0+)
SELECT FILENAME FROM pendrive
EXCEPT
SELECT FILENAME FROM source1;
```

#### 🛠️ Alternatywa dla starszych wersji MySQL (np. starszy XAMPP):

W starszych wersjach MySQL komenda `EXCEPT` nie była wspierana. Można ją zastąpić podzapytaniem `NOT IN` lub `NOT EXISTS`:

SQL

```sql
SELECT DISTINCT FILENAME
FROM pendrive
WHERE FILENAME NOT IN (SELECT FILENAME FROM source1 WHERE FILENAME IS NOT NULL);
```

### Zadanie 7: Część wspólna zbiorów (`INTERSECT`)

**Polecenie:** Sprawdź, czy na źródle `source1` są pliki wykonywalne (`exe`), które mają identyczną nazwę na `source2`.

SQL

```sql
-- Standardowy SQL (oraz MariaDB/MySQL 8.0+)
SELECT FILENAME FROM source1 WHERE EXTENSION = 'exe'
INTERSECT
SELECT FILENAME FROM source2 WHERE EXTENSION = 'exe';
```

### Zadanie 8: Tworzenie kolumn tekstowych "Etykiet"

**Polecenie:** Wyświetl maksymalną długość oraz ilość plików na źródłach `source1` i `source2` w jednym zapytaniu z kolumnami: `source`, `max_length`, `number`.

SQL

```sql
SELECT
    'SOURCE1' AS source,
    MAX(LENGTH) AS max_length,
    COUNT(*) AS number
FROM source1

UNION ALL

SELECT
    'SOURCE2' AS source,
    MAX(LENGTH) AS max_length,
    COUNT(*) AS number
FROM source2;
```

- Instrukcja `'SOURCE1' AS source` tworzy sztuczną kolumnę tekstową wypełnioną stałą wartością, co pozwala zidentyfikować, z którego źródła pochodzą statystyki.

### Zadanie 9: Filtrowanie zakresem dat (`BETWEEN`)

**Polecenie:** Wyświetl pliki z datami od 01-01-2014 do 01-12-2014 o długości przekraczającej 1 KB ($1024\text{ B}$) z dysków `pendrive` oraz `source2`.

SQL

```sql
SELECT * FROM pendrive
WHERE DATA BETWEEN '2014-01-01' AND '2014-12-01'
  AND LENGTH > 1024

UNION ALL

SELECT * FROM source2
WHERE DATA BETWEEN '2014-01-01' AND '2014-12-01'
  AND LENGTH > 1024;
```

> **Ważne:** Daty w SQL podajemy zawsze w formacie tekstowym RRRR-MM-DD ujęte w cudzysłów lub apostrofy (np. `'2014-01-01'`). Zapis bez cudzysłowów (`2014-01-01`) zostanie zinterpretowany jako odejmowanie liczb ($2014 - 1 - 1 = 2012$)!

### Zadanie 10: Wstawianie wyników zapytania (`INSERT INTO ... SELECT`)

**Polecenie:** Wprowadź do tabeli `source4` wszystkie unikalne pliki ze źródeł `source1` oraz `source2`.

SQL

```sql
INSERT INTO source4 (FILENAME, EXTENSION, LENGTH, DATA)
SELECT FILENAME, EXTENSION, LENGTH, DATA FROM source1
UNION
SELECT FILENAME, EXTENSION, LENGTH, DATA FROM source2;
```

- Instrukcja `INSERT INTO ... SELECT` umożliwia szybkie kopiowanie danych między tabelami bez konieczności ręcznego podawania wartości `VALUES`.
- Wykorzystanie operatora `UNION` zapobiega ponownemu wstawieniu duplikatów.

### Zadanie 11: Podzapytanie skorelowane (`EXISTS`)

**Polecenie:** Wypisz pliki wspólne z tabel `source4` oraz `source1`.

SQL

```sql
SELECT * FROM source1 s1
WHERE EXISTS (
    SELECT 1 FROM source4 s4
    WHERE s1.FILENAME = s4.FILENAME
      AND s1.EXTENSION = s4.EXTENSION
      AND s1.LENGTH = s4.LENGTH
      AND s1.DATA = s4.DATA
);
```

- **`EXISTS`**: Sprawdza, czy wewnętrzne podzapytanie zwróci chociaż jeden pasujący wiersz. Jest to wydajna metoda przy porównywaniu wielu kolumn naraz.

### Zadanie 12: Iloczyn Kartezjański (`CROSS JOIN`)

**Polecenie:** Wypisz iloczyn kartezjański tabel `source1` oraz `source2`.

SQL

```sql
SELECT *
FROM source1
CROSS JOIN source2;
```

#### 🧠 Czym jest iloczyn kartezjański?

Iloczyn kartezjański łączy **każdy wiersz** z pierwszej tabeli z **każdym wierszem** z drugiej tabeli.

- Jeśli tabela `source1` ma 13 wierszy, a `source2` ma 12 wierszy, wynik zapytania zwróci dokładnie $13 \times 12 = 156$ wierszy!

## 📝 Podsumowanie i Dobre Praktyki

1. **Pamiętaj o cudzysłowach dla dat:** Zawsze zapisuj daty w formacie `'YYYY-MM-DD'`.
2. **Uważaj na nawiasy przy operatorze** **`OR`\*\***:\*\* Łączenie `AND` z `OR` bez użycia nawiasów może prowadzić do niezamierzonych wyników filtracji.
3. **Wybieraj odpowiedni typ sumowania:** Jeśli wiesz, że dane z dwóch tabel nie zawierają duplikatów lub zależy Ci na wydajności, wybierz `UNION ALL`.
4. **Zadbaj o porządek wyników:** `ORDER BY` umieszcza się na samym końcu zapytania złożonego z wielu operacji `UNION`.
