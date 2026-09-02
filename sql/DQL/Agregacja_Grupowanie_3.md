# 📊 Kompletny Podręcznik SQL: Agregacja i Grupowanie Danych

W tym module nauczysz się:

1. Jak streszczać tysiące wierszy do pojedynczych liczb za pomocą **funkcji agregujących** (`SUM`, `AVG`, `COUNT`, `MAX`, `MIN`).
2. Jak właściwie zliczać rekordy i czym różnią się `COUNT(*)`, `COUNT(kolumna)` oraz `COUNT(DISTINCT kolumna)`.
3. Dzielić dane na podgrupy za pomocą klauzuli **`GROUP BY`** (w tym grupowanie dwustopniowe).
4. Przeprowadzać selekcję grup przy użyciu **`HAVING`** oraz unikać mylenia go z **`WHERE`**.

## 1. Przygotowanie struktury i danych

Pracujemy na bazie `AGREGACJA` i tabeli `PRACOWNICY`:

```sql
CREATE DATABASE AGREGACJA;
USE AGREGACJA;

CREATE TABLE PRACOWNICY (
    ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    IMIE VARCHAR(20),
    NAZWISKO VARCHAR(25),
    DZIAL CHAR(5),
    STANOWISKO VARCHAR(25),
    POBORY DECIMAL(6,2)
);

INSERT INTO PRACOWNICY (IMIE, NAZWISKO, DZIAL, STANOWISKO, POBORY) VALUES
('Adam', 'Kowal', 'PD303', 'robotnik', 1500.00),
('Artur', 'Kowalik', 'PD303', 'kierownik', 2500.00),
('Adam', 'Kowalski', 'PR202', 'robotnik', 3500.00),
('Amadeusz', 'Kowalczyk', 'PK101', 'kierownik', 1000.00),
('Antoni', 'Kowalski', 'PD303', 'robotnik', 4500.00),
('Alojzy', 'Kowalowski', 'PK101', 'robotnik', 2500.00),
('Tomasz', 'Rogalski', 'PK101', 'robotnik', 2800.00),
('Adrian', 'Kowalczuk', 'PR202', 'kierownik', 2500.00),
('Andrzej', 'Kawula', 'PK101', 'robotnik', 2500.00),
('Jerzy', 'Janiak', 'PK101', 'analityk', 5500.00),
('Jan', 'Jakubiak', 'PG404', 'straznik', 2000.00),
('Mateusz', 'Jakubowski', 'PG404', 'robotnik', 2300.00);

```

## 2. Podstawy Agregacji (Prosta agregacja całej tabeli)

Agregacja polega na połączeniu wielu wierszy tabeli w jeden podsumowujący wynik. Zamiast czytać każdy wiersz z osobna, pytasz bazę o **sumę**, **średnią** czy **liczbę wierszy**.

### Najważniejsze funkcje agregujące:

- **`SUM(kolumna)`** – oblicza sumę wszystkich wartości.
- **`AVG(kolumna)`** – oblicza średnią arytmetyczną.
- **`COUNT(...)`** – zlicza wiersze / rekordy.
- **`MAX(kolumna)`** / **`MIN(kolumna)`** – zwraca wartość maksymalną / minimalną.
- **`ROUND(wartość, miejsca)`** – funkcja pomocnicza zaokrąglająca wynik.

```sql
SELECT
    SUM(POBORY) AS suma_zarobkow,
    ROUND(AVG(POBORY), 2) AS srednia_zarobkow,
    MIN(POBORY) AS najnizsza,
    MAX(POBORY) AS najwyzsza,
    COUNT(*) AS liczba_pracownikow
FROM PRACOWNICY;

```

## 3. Zrozumieć `COUNT`: Trzy różne sposoby zliczania

Zliczanie rekordów to jedno z najczęstszych zadań w SQL, ale diabeł tkwi w szczegółach:

1. **`COUNT(*)`** – zlicza **wszystkie wiersze** w tabeli (niezależnie od tego, czy zawierają `NULL`).
2. **`COUNT(kolumna)`** – zlicza wiersze, w których dana kolumna **nie jest pusta (\*\***`NOT NULL`\***\*)**.
3. **`COUNT(DISTINCT kolumna)`** – zlicza wyłącznie **unikalne (niepowtarzające się)** i niepuste wartości.

```sql
-- Zlicza wszystkie wiersze w tabeli
SELECT COUNT(*) FROM PRACOWNICY;

-- Zlicza, ile osób ma wpisane imię (pomija NULLe w kolumnie IMIE)
SELECT COUNT(IMIE) FROM PRACOWNICY;

-- Zlicza, ile jest unikalnych imion w firmie
SELECT COUNT(DISTINCT IMIE) FROM PRACOWNICY;

```

## 4. Agregacja z warunkiem (`WHERE`)

Zanim dane zostaną zagregowane (zsumowane, uśrednione), możesz je przefiltrować za pomocą znanej Ci klauzuli `WHERE`.

Oblicz sumę i średnią zarobków, ale tylko dla pracowników na stanowisku 'robotnik':

```sql
SELECT
    SUM(POBORY) AS suma_robotnicy,
    ROUND(AVG(POBORY), 2) AS srednia_robotnicy,
    COUNT(*) AS liczba_robotnikow
FROM PRACOWNICY
WHERE STANOWISKO = 'robotnik';

```

> **Jak baza to wykonuje?** Najpierw odrzuca wszystkich kierowników, analityków i strażników (`WHERE`), a dopiero ze pozostałych wierszy wylicza sumę i średnią.

## 5. Grupowanie danych (`GROUP BY`)

Co jeśli chcesz poznać średnie zarobki w **każdym dziale z osobna**? Pisanie osobnego zapytania z `WHERE DZIAL = 'PK101'`, `WHERE DZIAL = 'PD303'` itd. byłoby nieefektywne.

Do tego służy **`GROUP BY`** — dzieli tabelę na mniejsze grupy na podstawie wartości w wybranej kolumnie.

```sql
SELECT
    DZIAL,
    SUM(POBORY) AS suma,
    ROUND(AVG(POBORY), 2) AS srednia,
    COUNT(*) AS liczba_osob
FROM PRACOWNICY
GROUP BY DZIAL;

```

### ⚠️ Złota zasada `GROUP BY` dla początkujących:

Jeśli używasz `GROUP BY`, to w klauzuli `SELECT` możesz umieścić **tylko**:

1. Kolumny, po których grupujesz (np. `DZIAL`).
2. Funkcje agregujące (np. `SUM(POBORY)`, `COUNT(*)`).

_Próba wyświetlenia kolumny_ _`NAZWISKO`_ _bez agregacji przy grupowaniu po_ _`DZIAL`_ _jest błędem logicznym, ponieważ w jednym dziale jest wielu pracowników o różnych nazwiskach!_

## 6. Grupowanie wielostopniowe (Wielopoziomowe)

Możesz grupować dane według więcej niż jednej kolumny — na przykład rozbić wydatki według **działu**, a wewnątrz każdego działu według **stanowiska**.

```sql
SELECT
    DZIAL,
    STANOWISKO,
    SUM(POBORY) AS suma,
    ROUND(AVG(POBORY), 2) AS srednia,
    COUNT(*) AS liczba
FROM PRACOWNICY
GROUP BY DZIAL, STANOWISKO
ORDER BY DZIAL ASC, STANOWISKO ASC;

```

## 7. Selekcja grup: `WHERE` vs `HAVING`

To jedno z najważniejszych zagadnień na rozmowach kwalifikacyjnych i kolokwiach z SQL!

| **Klauzula** | **Kiedy działa?** | **Po czym filtruje?** | **Czy pozwala na funkcje agregujące?** |
| ------------ | ----------------- | --------------------- | -------------------------------------- |
| **`WHERE`**  |                   |                       |                                        |

**PRZED** grupowaniem danych

|     |
| --- |

Po pojedynczych wierszach/rekordach

| ❌ NIE (np. `WHERE SUM(POBORY) > 1000` to BŁĄD) |     |
| ----------------------------------------------- | --- |
| **`HAVING`**                                    |     |

**PO** pogrupowaniu danych (`GROUP BY`)

|     |
| --- |

Po podsumowanych grupach

|     |
| --- |

✅ TAK (np. `HAVING AVG(POBORY) > 2500`)

### Przykład 1: Filtrowanie grup (`HAVING`)

Wyświetl tylko te działy, w których pracuje **więcej niż 2 pracowników**:

```sql
SELECT
    DZIAL,
    ROUND(AVG(POBORY), 2) AS srednia,
    COUNT(*) AS liczba_pracownikow
FROM PRACOWNICY
GROUP BY DZIAL
HAVING COUNT(*) > 2;

```

### Przykład 2: Połączenie `WHERE`, `GROUP BY` oraz `HAVING`

Odrzuć kierowników (`WHERE`), pogrupuj pozostałych pracowników po dziale (`GROUP BY`), a następnie wyświetl tylko te działy, w których średnia pensja tak przefiltrowanych pracowników przekracza 2500 zł (`HAVING`):

```sql
SELECT
    DZIAL,
    ROUND(AVG(POBORY), 2) AS srednia_pensja,
    COUNT(*) AS liczba
FROM PRACOWNICY
WHERE STANOWISKO <> 'kierownik'
GROUP BY DZIAL
HAVING AVG(POBORY) > 2500;

```

## 8. Kolejność wykonywania klauzul w zapytaniu SQL

Aby pisać bezbłędne zapytania, zapamiętaj stałą kolejność słów kluczowych w zapytaniu `SELECT`:

```text
1. SELECT    -> co chcemy wyświetlić
2. FROM      -> z jakiej tabeli
3. WHERE     -> przefiltruj wiersze
4. GROUP BY  -> podziel na grupy
5. HAVING    -> przefiltruj grupy
6. ORDER BY  -> posortuj wynik
7. LIMIT     -> ogranicz liczbę wierszy
```
