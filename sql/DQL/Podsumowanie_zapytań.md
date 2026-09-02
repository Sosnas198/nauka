# Kompleksowy Kurs SQL: Przygotowanie Bazy i Analiza Danych (Poziom Od Podstaw do Średniozaawansowanego)

Witaj! Niniejszy poradnik został przygotowany na podstawie dostarczonych przez Ciebie zadań oraz skryptu struktury bazy danych `DANE_WYPADKOW` (opartej na zadaniu maturalnym).

Zamiast jedynie podać proste odpowiedzi, przejdziemy krok po kroku przez wszystkie pojęcia SQL – od tworzenia baz i tabel, przez nakładanie więzów integralności (klucze obce), aż po pisanie zapytań analitycznych z użyciem funkcji agregujących oraz złączeń (`JOIN`).

## Rozdział 1. Tworzenie Bazy Danych i Struktury Tabel (DDL)

DDL (_Data Definition Language_) to część języka SQL służąca do definiowania struktury danych (baz, tabel, kolumn).

### 1.1. Tworzenie Bazy Danych z Kodowaniem Znaków

Pracując z polskimi znakami (ą, ę, ś, ć...), niezwykle ważne jest poprawne ustawienie kodowania (_charset_). Domyślnym i zalecanym standardem jest **UTF-8**.

SQL

```sql
CREATE DATABASE DANE_WYPADKOW
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
```

**Wyjaśnienie pojęć:**

- `CREATE DATABASE DANE_WYPADKOW`: Polecenie tworzące nową bazę o nazwie `DANE_WYPADKOW`.
- `DEFAULT CHARACTER SET utf8`: Określa zestaw znaków.
- `DEFAULT COLLATE utf8_general_ci`: Określa metodę porównywania i sortowania znaków (`ci` oznacza _case-insensitive_ – brak rozróżniania wielkości liter).

### 1.2. Tworzenie Tabel i Typy Danych

Struktura relationalnej bazy danych wymaga zdefiniowania tabel. Poniżej przedstawiono standardowy kod do utworzenia trzech podstawowych tabel: `osoby`, `auta` oraz `wypadki`.

SQL

```sql
-- 1. Tabela OSOBY
CREATE TABLE osoby (
    PESEL CHAR(11) NOT NULL,
    IMIE VARCHAR(20) NOT NULL,
    NAZWISKO VARCHAR(20) NOT NULL,
    MIEJSCOWOSC CHAR(1) NOT NULL,
    CONSTRAINT PK_OSOBY PRIMARY KEY (PESEL)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2. Tabela AUTA
CREATE TABLE auta (
    REJESTRACJA VARCHAR(10) NOT NULL,
    MARKA VARCHAR(20) NOT NULL,
    ROCZNIK YEAR NOT NULL,
    PESEL CHAR(11) NOT NULL,
    CONSTRAINT PK_AUTA PRIMARY KEY (REJESTRACJA)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3. Tabela WYPADKI
CREATE TABLE wypadki (
    ID_WYPADKU INT AUTO_INCREMENT NOT NULL,
    DATA_WYPADKU DATE NOT NULL,
    REJESTRACJA VARCHAR(10) NOT NULL,
    STRATA DECIMAL(10,2) NOT NULL,
    CONSTRAINT PK_WYPADKI PRIMARY KEY (ID_WYPADKU)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

**Wyjaśnienie kluczowych pojęć:**

1. **Typy danych:**
   - `CHAR(N)`: Stała długość ciągu znaków. Idealny dla numeru PESEL (`CHAR(11)`), który zawsze ma dokładnie 11 znaków, oraz dla oznaczania typu miejscowości (`CHAR(1)`).
   - `VARCHAR(N)`: Zmienna długość ciągu znaków do maksymalnie $N$ bajtów/znaków. Używany dla imion, nazwisk czy marek samochodów.
   - `DECIMAL(10,2)`: Typ zmiennopozycyjny o stałej precyzji, używany do przechowywania kwot finansowych. `10` oznacza łączną liczbę cyfr, a `2` – liczbę cyfr po przecinku (np. `10453.00`).
   - `YEAR`, `DATE`: Typy danych przeznaczone do przechowywania lat oraz pełnych dat (`YYYY-MM-DD`).

2. **Atrybuty i ograniczenia:**
   - `NOT NULL`: Określa, że dane pole nie może pozostać puste.
   - `PRIMARY KEY` (Klucz Główny): Unikalny identyfikator danego wiersza w tabeli. Żadne dwa wiersze nie mogą mieć takiej samej wartości w kolumnie będącej kluczem głównym.
   - `ENGINE=InnoDB`: Mechanizm bazy MySQL/MariaDB obsługujący m.in. transakcje oraz **klucze obce** (_Foreign Keys_).

## Rozdział 2. Klucze Obce i Relacje (Foreign Keys)

Klucz obcy (_Foreign Key_) to kolumna w jednej tabeli, która wskazuje na klucz główny w innej tabeli. Zapewnia to tzw. **integralność referencyjną** – np. nie można przypisać auta do numeru PESEL, którego nie ma w tabeli `osoby`.

### Tworzenie ograniczników nazwanych (punkt 3 z zadania):

W treści zadania wymagane było utworzenie dwóch kluczy obcych o konkretnych nazwach:

1. `FK_AUTA`: z tabeli `wypadki` (`REJESTRACJA`) do tabeli `auta` (`REJESTRACJA`)
2. `FK_OSOBY`: z tabeli `auta` (`PESEL`) do tabeli `osoby` (`PESEL`)

Polecenia `ALTER TABLE`:

SQL

```sql
-- a) Dodanie ograniczenia FK_AUTA do tabeli wypadki
ALTER TABLE wypadki
ADD CONSTRAINT FK_AUTA
FOREIGN KEY (REJESTRACJA) REFERENCES auta(REJESTRACJA)
ON DELETE CASCADE
ON UPDATE CASCADE;

-- b) Dodanie ograniczenia FK_OSOBY do tabeli auta
ALTER TABLE auta
ADD CONSTRAINT FK_OSOBY
FOREIGN KEY (PESEL) REFERENCES osoby(PESEL)
ON DELETE CASCADE
ON UPDATE CASCADE;
```

**Wyjaśnienie:**

- `ALTER TABLE nazwa_tabeli`: Modyfikacja istniejącej struktury tabeli.
- `ADD CONSTRAINT nazwa_ograniczenia`: Nadanie własnej, jednoznacznej nazwy kluczowi obcemu (ułatwia to późniejsze zarządzenie bazą lub usuwanie klucza).
- `FOREIGN KEY (kolumna_lokalna) REFERENCES tabela_docelowa(kolumna_docelowa)`: Wskazanie relacji powiązania.
- `ON DELETE CASCADE / ON UPDATE CASCADE`: Zasady usuwania/aktualizacji. Gdy osoba zostanie usunięta z bazy, jej auta również automatycznie zostaną usunięte.

## Rozdział 3. Zapytania SQL – Od Podstaw do Zaawansowanych (DML / DQL)

Przejdźmy do omówienia zapytań pobierających i analizujących dane (`SELECT`).

### Zapytanie 1: Grupowanie i zliczanie wypadków według typu miejscowości

> _Podaj liczby wypadków z udziałem właścicieli z małego, średniego i dużego miasta oraz ze wsi (oddzielnie dla każdego typu miejscowości)._

SQL

```sql
SELECT
    osoby.MIEJSCOWOSC,
    COUNT(wypadki.ID_WYPADKU) AS LICZBA_WYPADKOW
FROM wypadki
JOIN auta ON wypadki.REJESTRACJA = auta.REJESTRACJA
JOIN osoby ON auta.PESEL = osoby.PESEL
GROUP BY osoby.MIEJSCOWOSC;
```

**Wyjaśnienie:**

- **`JOIN`**: Aby dowiedzieć się, skąd pochodzi sprawca wypadku, musimy połączyć trzy tabele: `wypadki` $\rightarrow$ `auta` $\rightarrow$ `osoby`.
- **`COUNT(...)`**: Funkcja agregująca zliczająca wiersze w danej grupie.
- **`GROUP BY osoby.MIEJSCOWOSC`**: Informuje bazę danych, że ma pogrupować wyniki według wartości w kolumnie `MIEJSCOWOSC` (A, B, C, D) i dla każdej z nich policzyć liczbę rekordów.
- **`AS LICZBA_WYPADKOW`**: Alias – nadaje czytelną nazwę wyliczonej kolumnie w wyniku.

### Zapytanie 2: Filtrowanie warunkowe i sortowanie

> _Wypisz liczbę osób w zależności od rodzaju miejscowości w której mieszkają, uwzględniając tylko miasta i sortując wynik w zależności od liczby osób malejąco._

SQL

```sql
SELECT
    MIEJSCOWOSC,
    COUNT(*) AS LICZBA_OSOB
FROM osoby
WHERE MIEJSCOWOSC IN ('A', 'B', 'C')
GROUP BY MIEJSCOWOSC
ORDER BY LICZBA_OSOB DESC;
```

**Wyjaśnienie:**

- **`WHERE MIEJSCOWOSC IN ('A', 'B', 'C')`**: Filtruje wiersze **przed** grupowaniem. Wyklucza wieś (`'D'`).
- **`ORDER BY LICZBA_OSOB DESC`**: Sortuje wyniki malejąco (`DESC` = _descending_). Jeśli chciałbyś sortować rosnąco, użyłbyś słowa `ASC` (_ascending_).

### Zapytanie 3: Filtrowanie zagregowanych wyników (`HAVING`)

> _Wypisz liczbę aut w zależności od marki, pomiń marki dla których jest tylko jedno auto._

SQL

```sql
SELECT
    MARKA,
    COUNT(*) AS LICZBA_AUT
FROM auta
GROUP BY MARKA
HAVING COUNT(*) > 1;
```

**Kluczowa różnica:** **`WHERE`** **vs** **`HAVING`**

- `WHERE` filtruje pojedyncze wiersze **przed** wykonaniem grupowania.
- **`HAVING`** filtruje zagregowane grupy **po** wykonaniu funkcji `GROUP BY`. Ponieważ warunek dotyczy wyniku funkcji `COUNT(*)`, musimy zastosować klauzulę `HAVING`.

### Zapytanie 4: Dopasowywanie wzorców tekstowych (`LIKE` i Wildcards)

> _Wyświetl numer rejestracyjny i markę aut dla tych właścicieli, których nazwisko rozpoczyna się na literę 'B' lub 'C'._

SQL

```sql
SELECT
    auta.REJESTRACJA,
    auta.MARKA,
    osoby.NAZWISKO
FROM auta
JOIN osoby ON auta.PESEL = osoby.PESEL
WHERE osoby.NAZWISKO LIKE 'B%'
   OR osoby.NAZWISKO LIKE 'C%';
```

**Wyjaśnienie:**

- **`LIKE 'B%'`**: Symbol `%` działa jak wildcard (dowolny ciąg znaków o dowolnej długości). Wzorzec `'B%'` oznacza "wszystko, co zaczyna się na literę B".
- Alternatywnie w MySQL można użyć wyrażeń regularnych: `WHERE osoby.NAZWISKO REGEXP '^[BC]'`.

### Zapytanie 5: Rodzaje Złączeń Tabel (`INNER JOIN`, `LEFT JOIN`, `RIGHT JOIN`)

> _Wykonaj trzy rodzaje złączeń tabel AUTA i OSOBY stosując kolumnę wspólną PESEL._

Różnice między rodzajami złączeń to jeden z najważniejszych tematów w relacyjnych bazach danych:

SQL

```sql
-- a) Złączenie wewnętrzne (INNER JOIN)
-- Zwraca tylko te wiersze, które mają dopasowanie w OBU tabelach.
SELECT auta.REJESTRACJA, auta.MARKA, osoby.PESEL, osoby.IMIE, osoby.NAZWISKO
FROM auta
INNER JOIN osoby ON auta.PESEL = osoby.PESEL;

-- b) Złączenie zewnętrzne prawostronne (RIGHT JOIN)
-- Zwraca WSZYSTKIE osoby (z prawej tabeli), nawet jeśli nie posiadają żadnego auta (wtedy pola z auta będą miały wartość NULL).
SELECT auta.REJESTRACJA, auta.MARKA, osoby.PESEL, osoby.IMIE, osoby.NAZWISKO
FROM auta
RIGHT JOIN osoby ON auta.PESEL = osoby.PESEL;

-- c) Złączenie zewnętrzne lewostronne (LEFT JOIN)
-- Zwraca WSZYSTKIE auta (z lewej tabeli), nawet jeśli z jakiegoś powodu nie miałyby przypisanego właściciela w tabeli osoby.
SELECT auta.REJESTRACJA, auta.MARKA, osoby.PESEL, osoby.IMIE, osoby.NAZWISKO
FROM auta
LEFT JOIN osoby ON auta.PESEL = osoby.PESEL;
```

### Zapytanie 6: Unikalne wartości (`DISTINCT` i `COUNT(DISTINCT ...)`)

> _Podaj, ilu właścicieli samochodów miało co najmniej jeden wypadek. Uwaga: Właściciela odnotowanego w kilku wypadkach liczymy jeden raz._

SQL

```sql
SELECT
    COUNT(DISTINCT auta.PESEL) AS LICZBA_WLASCICIELI_Z_WYPADKIEM
FROM wypadki
JOIN auta ON wypadki.REJESTRACJA = auta.REJESTRACJA;
```

**Wyjaśnienie:**

- `COUNT(auta.PESEL)` zliczyłoby wszystkie wypadki (ten sam właściciel biorący udział w 3 wypadkach zostałby policzony 3 razy).
- **`COUNT(DISTINCT auta.PESEL)`** unika dublowania i zlicza wyłącznie **unikalne** wartości numerów PESEL.

### Zapytanie 7: Funkcje Agregujące (`MAX`, `MIN`, `AVG`)

> _Ustal maksymalną, minimalną i średnią kwotę jaką wypłacono jako odszkodowania._

SQL

```sql
SELECT
    MAX(STRATA) AS MAX_ODSZKODOWANIE,
    MIN(STRATA) AS MIN_ODSZKODOWANIE,
    ROUND(AVG(STRATA), 2) AS SREDNIE_ODSZKODOWANIE
FROM wypadki;
```

**Wyjaśnienie:**

- `MAX()` / `MIN()` – wyznaczają wartość najwyższą i najniższą.
- `AVG()` – oblicza średnią arytmetyczną.
- `ROUND(..., 2)` – zaokrągla wynik średniej do 2 miejsc po przecinku.

### Zapytanie 8: Podzapytania (_Subqueries_) oraz limitowanie wyników

> _Podaj numer rejestracyjny samochodu oraz imię i nazwisko właściciela, któremu wypłacono największą kwotę odszkodowania oraz jej wysokość._

Możemy to zadanie rozwiązać na dwa sposoby:

#### Sposób A: Z podzapytaniem (Standard SQL)

SQL

```sql
SELECT
    auta.REJESTRACJA,
    osoby.IMIE,
    osoby.NAZWISKO,
    wypadki.STRATA
FROM wypadki
JOIN auta ON wypadki.REJESTRACJA = auta.REJESTRACJA
JOIN osoby ON auta.PESEL = osoby.PESEL
WHERE wypadki.STRATA = (SELECT MAX(STRATA) FROM wypadki);
```

#### Sposób B: Sortowanie z ograniczeniem `LIMIT`

SQL

```sql
SELECT
    auta.REJESTRACJA,
    osoby.IMIE,
    osoby.NAZWISKO,
    wypadki.STRATA
FROM wypadki
JOIN auta ON wypadki.REJESTRACJA = auta.REJESTRACJA
JOIN osoby ON auta.PESEL = osoby.PESEL
ORDER BY wypadki.STRATA DESC
LIMIT 1;
```

### Zapytanie 9: Agregacja ze zliczaniem warunkowym (`SUM` + `CASE / IF`)

> _Podaj łączne sumy odszkodowań, jakie wypłaciło towarzystwo ubezpieczeniowe w roku 2006 oraz w roku 2007 (należy utworzyć jedno zapytanie, które wypisuje dwie wartości)._

SQL

```sql
SELECT
    SUM(CASE WHEN YEAR(DATA_WYPADKU) = 2006 THEN STRATA ELSE 0 END) AS SUMA_2006,
    SUM(CASE WHEN YEAR(DATA_WYPADKU) = 2007 THEN STRATA ELSE 0 END) AS SUMA_2007
FROM wypadki;
```

**Wyjaśnienie:**

- **`YEAR(DATA_WYPADKU)`**: Wyciąga sam rok z pełnej daty `YYYY-MM-DD`.
- **`CASE WHEN ... THEN ... ELSE ... END`**: Instrukcja warunkowa wewnątrz funkcji agregującej `SUM()`. Jeśli rok to 2006, kwota jest sumowana; w przeciwnym razie dodawane jest `0`.

### Zapytanie 10: Sortowanie i zliczanie wystąpień relacyjnych

> _Podaj zestawienie zawierające markę samochodu oraz liczbę wypadków, w których samochody tej marki były odnotowane. Posortuj to zestawienie w zależności od liczby wypadków malejąco._

SQL

```sql
SELECT
    auta.MARKA,
    COUNT(wypadki.ID_WYPADKU) AS LICZBA_WYPADKOW
FROM wypadki
JOIN auta ON wypadki.REJESTRACJA = auta.REJESTRACJA
GROUP BY auta.MARKA
ORDER BY LICZBA_WYPADKOW DESC;
```

## Ściągawka Podsumowująca dla Uczącego Się

| **Struktura Zapytania SQL** | **Kolejność Wykonywania Bazy** | **Opis**                               |
| --------------------------- | ------------------------------ | -------------------------------------- |
| `SELECT ...`                | 5                              | Wybór kolumn i wyliczeń                |
| `FROM ... JOIN ...`         | 1                              | Określenie źródeł danych i relacji     |
| `WHERE ...`                 | 2                              | Filtrowanie pojedynczych wierszy       |
| `GROUP BY ...`              | 3                              | Grupowanie wierszy według kategorii    |
| `HAVING ...`                | 4                              | Filtrowanie zagregowanych grup         |
| `ORDER BY ...`              | 6                              | Sortowanie końcowego wyniku            |
| `LIMIT ...`                 | 7                              | Ograniczenie liczby zwracanych wierszy |
