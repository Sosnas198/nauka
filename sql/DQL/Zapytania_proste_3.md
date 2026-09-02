# ⚽ Kompletny Podręcznik SQL: Baza danych „REPREZENTACJA”

Oto kompleksowy podręcznik ukierunkowany na analizę danych reprezentantów Polski w piłce nożnej. Zostaną w nim omówione kwestie kodowania znaków, masowego importu danych, czyszczenia spójności oraz pisania zaawansowanych zapytań SQL.

W tym module nauczysz się:

1. Konfigurować kodowanie znaków (**CHARACTER SET** i **COLLATE**) na poziomie bazy danych.

   PDF+ 1

2. Importować dane z plików CSV bezpośrednio do tabeli MySQL/MariaDB (`LOAD DATA INFILE`).

   PDF+ 1

3. Czyścić i aktualizować błędne wpisy (`UPDATE` i obsługa wartości `NULL`).

   PDF+ 1

4. Stosować funkcje matematyczne (`ABS`), tekstowe (`CONCAT`, `UPPER`) oraz operatory filtrujące (`LIKE`, `BETWEEN`, `IS NULL`).

   PDF+ 1

5. Przetwarzać dane w locie i migrować je do nowych struktur tabelarycznych (`INSERT INTO ... SELECT`).

   PDF+ 1

## 1. Kodowanie znaków i tworzenie bazy danych

Praca z polskimi znakami (`ą`, `ę`, `ć`, `ł`, `ó`, `ś`, `ź`, `ż`) wymaga odpowiedniego ustawienia kodowania. Jeśli baza danych ma domyślne kodowanie inne niż plik źródłowy, powstaną tzw. „krzaczki”.

PDF+ 1

### Pojęcia kluczowe:

- **CHARACTER SET (Zestaw znaków):** Zbiór obsługiwanych symboli i ich cyfrowych reprezentacji (np. `utf8` / `utf8mb4`).

  PDF+ 1

- **COLLATION (Metoda porównywania):** Reguły odpowiadające za sortowanie i porównywanie znaków.

  PDF+ 1
  - `_ci` (_case insensitive_) – ignoruje wielkość liter (np. 'A' == 'a').

    PDF+ 1

  - `_cs` (_case sensitive_) – rozróżnia wielkość liter.

    PDF+ 1

  - `_bin` (_binary_) – porównuje wartości na podstawie ich binarnych bajtów.

    PDF+ 1

  - `utf8_polish_ci` – sortuje polskie znaki zgodnie z polskim alfabetem (np. 'Ł' pojawia się po 'L', a nie na końcu alfabetu).

    PDF+ 1

SQL

```sql
-- Tworzenie bazy danych z polskim kodowaniem UTF-8
CREATE DATABASE REPREZENTACJA
CHARACTER SET utf8
COLLATE utf8_polish_ci;

-- Wybór bazy do użycia
USE REPREZENTACJA;

-- Sprawdzenie aktualnych ustawień kodowania bazy danych
SELECT @@character_set_database, @@collation_database;
```

## 2. Tworzenie tabeli i właściwy dobór typów danych

Tworzymy tabelę `PILKARZE`, dopasowując typy danych tak, aby nie marnować pamięci RAM i dyskowej.

PDF+ 1

SQL

```sql
CREATE TABLE PILKARZE (
    id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    imie VARCHAR(30) NOT NULL,
    nazwisko VARCHAR(50) NOT NULL,
    data_urodz DATE,
    data_smierci DATE,
    mecze TINYINT UNSIGNED,
    bramki SMALLINT,
    data_debiutu DATE,
    mecz_debiutu VARCHAR(30),
    minuta_debiutu TINYINT UNSIGNED
);
```

### 🧠 Dlaczego właśnie takie typy?

- `SMALLINT UNSIGNED` dla **id**: Zakres od 0 do 65 535. Ponieważ w historii reprezentacji grało kilkuset piłkarzy, `SMALLINT` wystarcza w zupełności (w przeciwieństwie do cięższego `INT`).

  PDF+ 3

- `TINYINT UNSIGNED` dla **meczy** i **minuty debiutu**: Zakres od 0 do 255. Liczba występów czy minuta meczu nigdy nie przekroczy 255.

  PDF+ 3

- `SMALLINT` (ze znakiem) dla **bramek**: Zakres od -32 768 do 32 767.

  PDF+ 1

  > **Ważna logika biznesowa:** Pilkarze pola mają wartości **dodatnie** (zdobyte goli), a bramkarze **ujemne** (stracone goli). Służy to do rozróżnienia ich ról!
  >
  > PDF+ 1

## 3. Masowy import danych (`LOAD DATA INFILE`)

Zamiast pisać setki instrukcji `INSERT INTO`, wczytujemy plik CSV za pomocą jednej komendy.

PDF+ 1

SQL

```sql
LOAD DATA INFILE 'BazaPilkarzy_UTF8.csv'
INTO TABLE PILKARZE
CHARACTER SET utf8
FIELDS TERMINATED BY ';'
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
```

### 🛠️ Rozbicie polecenia na części:

1. `FIELDS TERMINATED BY ';'` – informuje, że kolumny są rozdzielone średnikami.

   PDF+ 1

2. `ENCLOSED BY '"'` – wskazuje, że wartości tekstowe ujęte są w cudzysłowy (np. `"Jan"`), co zapobiega błędom, gdy tekst zawiera średnik.

   PDF+ 1

3. `LINES TERMINATED BY '\n'` – oznacza, że każdy nowy wiersz w pliku to nowy rekord w bazie.

   PDF+ 1

4. `IGNORE 1 ROWS` – pomija pierwszy wiersz pliku CSV, w którym znajdują się nagłówki kolumn.

   PDF+ 1

## 4. Czyszczenie danych (`UPDATE` i brakujące wartości)

W starych bazach danych nieznane daty bywają zapisywane jako `'0000-00-00'`. W SQL prawidłowym oznaczeniem braku danych jest wartość **`NULL`**.

PDF+ 3

SQL

```sql
UPDATE PILKARZE
SET data_urodz = NULL
WHERE data_urodz = '0000-00-00';
```

## 5. Praktyczne zapytania DQL (`SELECT`)

### Zadanie A: Statystyki bramkarzy i funkcja `ABS()`

Wypisz imiona, nazwiska oraz liczbę straconych bramek (jako wartość dodatnią) dla wszystkich bramkarzy. Posortuj ich od tych, którzy stracili najwięcej bramek.

PDF+ 1

SQL

```sql
SELECT
    imie,
    nazwisko,
    ABS(bramki) AS stracone_bramki
FROM PILKARZE
WHERE bramki < 0
ORDER BY ABS(bramki) DESC;
```

- **`bramki < 0`** – filtruje wyłącznie bramkarzy.

  PDF+ 1

- **`ABS(bramki)`** – funkcja wartości bezwzględnej zmienia minus na plus (np. `-15` zmieni na `15`).

  PDF+ 1

### Zadanie B: Filtrowanie po dacie i wartościach dodatnich

Wypisz piłkarzy pola, którzy zadebiutowali po 1970 roku, posortowanych alfabetycznie.

PDF+ 1

SQL

```sql
SELECT
    imie,
    nazwisko,
    data_debiutu
FROM PILKARZE
WHERE bramki >= 0
  AND data_debiutu > '1970-12-31'
ORDER BY nazwisko ASC;
```

### Zadanie C: Wiele warunków filtrujących

Wypisz graczy, którzy zadebiutowali w meczach ze Stanami Zjednoczonymi i zdobyli co najmniej 5 bramek. Sortuj rosnąco po liczbie bramek.

PDF+ 1

SQL

```sql
SELECT
    nazwisko,
    imie,
    mecz_debiutu,
    bramki
FROM PILKARZE
WHERE mecz_debiutu = 'Stany Zjednoczone'
  AND bramki >= 5
ORDER BY bramki ASC;
```

### Zadanie D: Eliminacja duplikatów (`DISTINCT`)

Wypisz unikalne reprezentacje, z którymi debiutowali nasi piłkarze.

PDF+ 1

SQL

```sql
SELECT DISTINCT
    mecz_debiutu
FROM PILKARZE
ORDER BY mecz_debiutu ASC;
```

### Zadanie E: Szukanie wartości brakujących (`IS NULL`)

Wypisz piłkarzy, których data urodzenia nie jest znana.

PDF+ 1

SQL

```sql
SELECT
    imie,
    nazwisko,
    data_urodz
FROM PILKARZE
WHERE data_urodz IS NULL;
```

> **Ważne:** W SQL nigdy nie używamy `= NULL`! Prawidłowa składnia to zawsze **`IS NULL`** lub **`IS NOT NULL`**.

### Zadanie F: Łączenie ciągów tekstowych (`CONCAT`)

Wypisz zawodników w formacie: `zawodnik` (imię + nazwisko) oraz `debiut` (mecz + minuta).

PDF+ 1

SQL

```sql
SELECT
    CONCAT(imie, ' ', nazwisko) AS zawodnik,
    bramki AS "zdobyte bramki",
    CONCAT(mecz_debiutu, ' (', minuta_debiutu, ' min)') AS debiut
FROM PILKARZE;
```

- **`CONCAT(a, b, c...)`** – sklejanie napisów i wartości z kolumn w jeden ciąg znaków.

  PDF+ 1

### Zadanie G: Wyszukiwanie wzorców tekstowych (`LIKE`)

Znajdź reprezentantów, których nazwiska kończą się na `er`, `ke` lub zawierają `man`.

PDF+ 1

SQL

```sql
SELECT
    imie,
    nazwisko
FROM PILKARZE
WHERE nazwisko LIKE '%er'
   OR nazwisko LIKE '%ke'
   OR nazwisko LIKE '%man%';
```

- `'%er'` – dowolny ciąg znaków zakończony na "er".

  PDF+ 1

- `'%'man%'` – ciąg znaków posiadający frazę "man" w dowolnym miejscu.

  PDF+ 1

### Zadanie H: Zakresy dat (`BETWEEN ... AND ...`)

Wypisz piłkarzy pola, którzy zadebiutowali w latach 1920–1939.

PDF+ 1

SQL

```sql
SELECT
    imie,
    nazwisko,
    data_debiutu
FROM PILKARZE
WHERE bramki >= 0
  AND data_debiutu BETWEEN '1920-01-01' AND '1939-12-31'
ORDER BY nazwisko ASC;
```

### Zadanie I: Transformacja tekstu na wielkie litery (`UPPER`)

Znajdź 10 piłkarzy, którzy zadebiutowali najwcześniej biorąc pod uwagę minutę meczu. Wypisz ich dane wielkimi literami.

PDF+ 1

SQL

```sql
SELECT
    UPPER(nazwisko) AS nazwisko,
    UPPER(imie) AS imie,
    data_debiutu,
    mecz_debiutu,
    minuta_debiutu
FROM PILKARZE
ORDER BY minuta_debiutu ASC
LIMIT 10;
```

## 6. Modyfikacja danych i migracja do nowej struktury

Częstą praktyką jest tworzenie tabel podsumowujących lub agregujących dane.

PDF+ 1

### Krok 1: Tworzenie nowej tabeli docelowej

SQL

```sql
CREATE TABLE PILKARZE2 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reprezentant VARCHAR(100),
    zdobyte_bramki INT UNSIGNED,
    data_debiutu DATE
);
```

### Krok 2: Kopiowanie zasilające z filtrowaniem (`INSERT INTO ... SELECT`)

Przenieś do nowej tabeli graczy pola, którzy zadebiutowali nie wcześniej niż 20 marca 1970 roku i zdobyli co najmniej 4 bramki.

PDF+ 1

SQL

```sql
INSERT INTO PILKARZE2 (reprezentant, zdobyte_bramki, data_debiutu)
SELECT
    CONCAT(imie, ' ', nazwisko),
    bramki,
    data_debiutu
FROM PILKARZE
WHERE bramki >= 4
  AND data_debiutu >= '1970-03-20';
```

## 📊 Szybka ściągawka z najważniejszych funkcji SQL

| FunkcjaOpis działaniaPrzykład zastosowania |                                                         |     |
| ------------------------------------------ | ------------------------------------------------------- | --- |
| **`ABS(x)`**                               | Wartość bezwzględna (zmienia liczby ujemne na dodatnie) |     |

`ABS(bramki)`

PDF+ 1

| **`CONCAT(a, b)`** | Łączy kilka ciągów tekstowych w jeden |     |
| ------------------ | ------------------------------------- | --- |

`CONCAT(imie, ' ', nazwisko)`

PDF+ 1

| **`UPPER(s)`** | Zamienia wszystkie litery na wielkie |     |
| -------------- | ------------------------------------ | --- |

`UPPER(nazwisko)`

PDF+ 1

svg

[image](https://drive-thirdparty.googleusercontent.com/32/type/application/pdf)

PDF

rozwiazanie.pdf

[image](https://drive-thirdparty.googleusercontent.com/32/type/application/pdf)

PDF

SELECT - ćwiczenie trzecie_2024.pdf

| **`LIKE`** | Dopasowuje tekst ze wzorcem (`%` dowolny ciąg, `_` jeden znak) |     |
| ---------- | -------------------------------------------------------------- | --- |

`nazwisko LIKE '%er'`

PDF+ 1

| **`BETWEEN a AND b`** | Sprawdza, czy wartość mieści się w zamkniętym przedziale |     |
| --------------------- | -------------------------------------------------------- | --- |

`data BETWEEN '1920-01-01' AND '1939-12-31'`

PDF+ 1

| **`IS NULL`** | Sprawdza, czy pole jest puste |     |
| ------------- | ----------------------------- | --- |

`WHERE data_urodz IS NULL`

PDF+ 1
