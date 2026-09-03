# 🗄️ Kompletny Course SQL: Od Tworzenia Baz po Zaawansowane Zapytania SELECT i DML

Witaj w podręczniku SQL! W tym materiale przejdziemy przez dwa kompletne scenariusze bazodanowe:

1. **System Rezerwacji Pensjonatu** (skupiony na precyzyjnym dobieraniu typów danych oraz budowaniu zapytań wyszukujących `SELECT`)[cite: 19].
2. **System Obsługi Egzaminów OKE** (skupiony na operacjach modyfikacji `DML`, funkcjach wbudowanych oraz warunkach)[cite: 20].

---

## 🏗️ Moduł 1: Definiowanie Struktury i Relacji (DDL)

Język **DDL** (_Data Definition Language_) służy do tworzenia i zmieniania konstrukcji bazy danych (jej "szkieletu")[cite: 19, 20].

### 1. Tworzenie Bazy Danych

Zawsze warto upewnić się, czy baza o danej nazwie nie została utworzona wcześniej, używając klauzuli `IF NOT EXISTS`[cite: 20].

````sql
-- Tworzenie bazy OKE z domyślnym kodowaniem dla języka polskiego
CREATE DATABASE IF NOT EXISTS OKE
CHARACTER SET = 'utf8'
COLLATE = 'utf8_polish_ci';

USE OKE;
```[cite: 20]

---

### 2. Dobór Typów Danych na Przykładowych Tabelach

Przy tworzeniu tabel kluczowy jest **dobór minimalnego odpowiedniego typu danych**, aby baza działała szybko i nie marnowała pamięci RAM[cite: 19, 20].

#### Tabela: `POKOJE` & `REZERWACJE` (System Pensjonat)[cite: 19]

```sql
-- Tabela POKOJE
CREATE TABLE POKOJE (
    numer TINYINT UNSIGNED,
    liczba_osob TINYINT UNSIGNED,
    cena_za_dobe SMALLINT UNSIGNED,
    kolor VARCHAR(20)
);

-- Tabela REZERWACJE
CREATE TABLE REZERWACJE (
    id MEDIUMINT UNSIGNED,
    nrpokoju TINYINT UNSIGNED NOT NULL,
    odDnia DATE,
    liczba_dni TINYINT UNSIGNED,
    nazwisko VARCHAR(30)
);
```[cite: 19]

💡 **Dlaczego zastosowano takie typy danych?[cite: 19]**
* **`TINYINT UNSIGNED`**: Przechowuje liczby od `0` do `255` (zajmuje tylko 1 bajt!)[cite: 19]. Idealny na `numer` pokoju, `liczba_osob` czy `liczba_dni`[cite: 19].
* **`SMALLINT UNSIGNED`**: Zakres `<0; 65 535>`[cite: 19]. Odpowiedni na cenę za dobę w złotówkach (`cena_za_dobe`)[cite: 19].
* **`MEDIUMINT UNSIGNED`**: Zakres `<0; 16 777 215>`[cite: 19]. Wykorzystany dla pola `id` rezerwacji, gdyż w systemie rezerwacji może pojawić się setki tysięcy wpisów[cite: 19].
* **`NOT NULL`**: Oznacza, że pole jest obowiązkowe – rezerwacja nie może istnieć bez przypisanego numeru pokoju[cite: 19].

---

#### Tabela: `EGZAMIN` & `ZDAJACY` (System OKE)[cite: 20]

```sql
-- Tabela ZDAJACY
CREATE TABLE IF NOT EXISTS ZDAJACY (
    IDZDA TINYINT UNSIGNED PRIMARY KEY,
    HASLO CHAR(8) DEFAULT 'zaq1@WSX',
    STANOWISKO SMALLINT UNSIGNED CHECK (STANOWISKO BETWEEN 1 AND 100)
);

-- Tabela EGZAMIN
CREATE TABLE IF NOT EXISTS EGZAMIN (
    IDEGZ MEDIUMINT SIGNED,
    DATAEGZAMINU DATE NOT NULL,
    OSOBA TINYINT UNSIGNED,
    SYMBOLKWALIFIKACJI VARCHAR(6) UNIQUE
) CHARACTER SET = 'utf8' COLLATE = 'utf8_polish_ci';
```[cite: 20]

💡 **Przydatne sztuczki i składnie:[cite: 20]**
* **`MEDIUMINT SIGNED`**: Zakres od `-8 388 608` do `8 388 607` (odpowiada potrzebom identyfikatora egzaminu)[cite: 20].
* **`CHAR(8)`**: Gdy długość napisu jest zawsze stała (np. hasło 8-znakowe), używamy `CHAR` zamiast `VARCHAR` dla lepszej wydajności[cite: 20].
* **`DEFAULT 'zaq1@WSX'`**: Domyślna wartość wstawiana automatycznie, gdy użytkownik nie poda hasła[cite: 20].
* **`CHECK (STANOWISKO BETWEEN 1 AND 100)`**: Ograniczenie warunkowe pilnujące, aby do bazy nie trafił numer stanowiska spoza przedziału `<1; 100>`[cite: 20].

---

### 3. Modyfikacje Tabel (`ALTER TABLE`)[cite: 19, 20]

Często musimy zmienić nazwę kolumny, dodać precyzyjne typy finansowe lub połączyć tabele relacją[cite: 19, 20].

```sql
-- A. Zmiana nazwy i typu kolumny (z 'liczba_osob' na 'liczba_miejsc')
ALTER TABLE POKOJE
CHANGE liczba_osob liczba_miejsc TINYINT UNSIGNED;

-- B. Dodanie kluczy głównych (PRIMARY KEY)
ALTER TABLE POKOJE ADD PRIMARY KEY (numer);
ALTER TABLE REZERWACJE ADD PRIMARY KEY (id);

-- C. Dodanie kolumny KOSZT z typem stałopozycyjnym (np. max 9999.99)
-- DECIMAL(6,2) = 6 cyfr łącznie, z czego 2 po przecinku (czyli 4 przed przecinkiem)
ALTER TABLE EGZAMIN
ADD COLUMN KOSZT DECIMAL(6,2) AFTER OSOBA;

-- D. Połączenie tabel kluczem obcym (FOREIGN KEY)
ALTER TABLE REZERWACJE
ADD CONSTRAINT FK_P
FOREIGN KEY (nrpokoju) REFERENCES POKOJE(numer);
```[cite: 19, 20]

---

## 📥 Moduł 2: Import Danych (LOAD DATA INFILE)

Dane do bazy można hurtowo wczytać z plików tekstowych lub CSV[cite: 19, 20].

```sql
-- Import danych do tabeli POKOJE z pliku CSV
LOAD DATA INFILE 'Pokoje.csv'
INTO TABLE POKOJE
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(numer, liczba_miejsc, cena_za_dobe, kolor);
```[cite: 19]

💡 **Opis parametrów:[cite: 19]**
* **`FIELDS TERMINATED BY ','`**: Kolumny w pliku rozdzielone są przecinkiem[cite: 19].
* **`LINES TERMINATED BY '\n'`**: Każdy nowy wiersz w pliku odpowiada nowemu rekordowi[cite: 19].
* **`IGNORE 1 ROWS`**: Pomija pierwszy wiersz pliku, jeśli znajdują się w nim nagłówki kolumn (np. `numer,liczba_osob...`)[cite: 19].

---

## 🔍 Moduł 3: Wyszukiwanie i Filtrowanie Danych (`SELECT`)

Klauzula `SELECT` pozwala na wyciąganie danych z bazy wedle ściśle określonych kryteriów[cite: 19].

### Struktura zapytania `SELECT`:[cite: 19]
```sql
SELECT [DISTINCT] kolumny
FROM tabela
WHERE warunek
GROUP BY grupowanie
HAVING warunek_grupowania
ORDER BY sortowanie ASC|DESC
LIMIT ile_wierszy;
```[cite: 19]

---

### Praktyczne Przykłady Zapytania `SELECT` (na bazie Pensjonat)[cite: 19]:

#### 1. Filtrowanie i sortowanie według wartości liczbowych (`WHERE`, `ORDER BY`)[cite: 19]
*Pobierz pokoje z ceną poniżej 150 zł, posortowane od najtańszego:*
```sql
SELECT *
FROM POKOJE
WHERE cena_za_dobe < 150
ORDER BY cena_za_dobe ASC;
```[cite: 19]

#### 2. Warunki logiczne `OR` oraz teksty (`WHERE`)[cite: 19]
*Pobierz numery pokojów o kolorze ścian niebieskim lub zielonym:*
```sql
SELECT numer
FROM POKOJE
WHERE kolor = 'NIEBIESKI' OR kolor = 'ZIELONY';
```[cite: 19]

#### 3. Bez powtórzeń (`DISTINCT`)[cite: 19]
*Wyświetl unikalne pary kolorów i liczby miejsc, posortowane po kolorze (A-Z):*
```sql
SELECT DISTINCT kolor, liczba_miejsc
FROM POKOJE
ORDER BY kolor ASC;
```[cite: 19]

#### 4. Ograniczanie liczby wyników (`LIMIT`)[cite: 19]
*Wypisz 3 pierwsze rezerwacje na czas dłuższy niż 3 dni (od najkrótszej):*
```sql
SELECT *
FROM REZERWACJE
WHERE liczba_dni > 3
ORDER BY liczba_dni ASC
LIMIT 3;
```[cite: 19]

#### 5. Przezwiska kolumn (Aliasy - `AS`)[cite: 19]
*Wyświetl dane z czytelnymi dla człowieka etykietami kolumn:*
```sql
SELECT
    nazwisko AS 'Rezerwujący',
    liczba_dni AS 'Czas rezerwacji'
FROM REZERWACJE
ORDER BY liczba_dni ASC;
```[cite: 19]

#### 6. Warunek przedziału (`BETWEEN ... AND`)[cite: 19]
*Znajdź rezerwacje dla pokojów o numerach od 10 do 13:*
```sql
SELECT *
FROM REZERWACJE
WHERE nrpokoju BETWEEN 10 AND 13;
```[cite: 19]

#### 7. Dopasowanie do zbioru wartości (`IN`) i wielopoziomowe sortowanie[cite: 19]
*Pobierz rezerwacje dla pokoi 1, 2, 3, 12, 13; posortuj malejąco po pokoju, a dla tego samego pokoju – rosnąco po liczbie dni:*
```sql
SELECT *
FROM REZERWACJE
WHERE nrpokoju IN (1, 2, 3, 12, 13)
ORDER BY nrpokoju DESC, liczba_dni ASC;
```[cite: 19]

---

## ⚡ Moduł 4: Modyfikacja Danych i Funkcje SQL (DML)

Język **DML** (*Data Manipulation Language*) pozwala dodawać (`INSERT`), edytować (`UPDATE`) oraz usuwać (`DELETE`) rekordy[cite: 20].

### 1. Zaawansowany `INSERT INTO` z użyciem funkcji wbudowanych[cite: 20]

#### Wykorzystane funkcje SQL[cite: 20]:
* **`SQRT(x)`** – pierwiastek kwadratowy z $x$[cite: 20].
* **`ABS(x)`** – wartość bezwzględna z $x$[cite: 20].
* **`ROUND(x, d)`** – zaokrągla wartość $x$ do $d$ miejsc po przecinku[cite: 20].
* **`CEIL(x)`** – zaokrągla liczbę w górę do najbliższej liczby całkowitej[cite: 20].
* **`FLOOR(RAND() * (max - min + 1)) + min`** – wyznacza losową liczbę całkowitą z domkniętego przedziału `<min; max>`[cite: 20].
* **`CURRENT_DATE()`** – zwraca aktualną datę systemową[cite: 20].
* **`CONCAT(a, b)`** – łączy ciągi tekstowe[cite: 20].
* **`SUBSTRING(tekst, start, dlugosc)`** – wycina fragment napisu[cite: 20].

#### Przykład A: Dodanie Zdającego (z wyliczaniem wartości)[cite: 20]
* **`IDZDA`**: Zaokrąglenie w górę pierwiastka z wartości bezwzględnej z `-17` ($\lceil\sqrt{|-17|}\rceil = \lceil4.123\rceil = 5$)[cite: 20].
* **`HASLO`**: Pierwsze 4 litery imienia + pierwsze 4 litery nazwiska[cite: 20].
* **`STANOWISKO`**: Losowa liczba całkowita z zakresu `<5; 10>`[cite: 20].

```sql
INSERT INTO ZDAJACY (IDZDA, HASLO, STANOWISKO)
VALUES (
    CEIL(SQRT(ABS(-17))),
    CONCAT(SUBSTRING('Janusz', 1, 4), SUBSTRING('Kowalski', 1, 4)),
    FLOOR(RAND() * (10 - 5 + 1)) + 5
);
```[cite: 20]

#### Przykład B: Dodanie Egzaminu[cite: 20]
* **`IDEGZ`**: Liczba losowa ze zbioru `{4, 5}`[cite: 20].
* **`DATAEGZAMINU`**: Dzisiejsza data[cite: 20].
* **`KOSZT`**: Pierwiastek ze 100 zaokrąglony do 2 miejsc po przecinku[cite: 20].

```sql
INSERT INTO EGZAMIN (IDEGZ, DATAEGZAMINU, OSOBA, SYMBOLKWALIFIKACJI, KOSZT)
VALUES (
    FLOOR(RAND() * (5 - 4 + 1)) + 4,
    CURRENT_DATE(),
    5, -- ID wcześniej dodanego zdającego
    'INF.04',
    ROUND(SQRT(100), 2)
);
```[cite: 20]

---

### 2. Modyfikacja Rekordów (`UPDATE`)[cite: 20]

#### A. Podwyżka procentowa z warunkiem przedziałowym[cite: 20]
*Podwyższ o 20% koszt egzaminów, których koszt mieści się w przedziale 100 - 150 zł:*
```sql
UPDATE EGZAMIN
SET KOSZT = KOSZT * 1.20
WHERE KOSZT BETWEEN 100 AND 150;
```[cite: 20]

#### B. Aktualizacja kilku wartości za pomocą zbioru `IN`[cite: 20]
*Zmień datę egzaminów z kwalifikacji INF.03 oraz INF.02 na 5 stycznia 2026 roku:*
```sql
UPDATE EGZAMIN
SET DATAEGZAMINU = '2026-01-05'
WHERE SYMBOLKWALIFIKACJI IN ('INF.03', 'INF.02');
```[cite: 20]

---

### 3. Usuwanie Danych i Tabel (`DELETE` & `DROP`)[cite: 20]

```sql
-- Czyszczenie całej tabeli z wierszy (bez usuwania samej struktury)
DELETE FROM EGZAMIN;

-- Usuwanie tabeli z bazy ze sprawdzeniem czy istnieje
DROP TABLE IF EXISTS EGZAMIN;
```[cite: 20]

---

## 📌 Podsumowanie / Ściągawka Składniowa

| Zastosowanie | Składnia SQL |
| :--- | :--- |
| **Klucz Główny** | `ALTER TABLE t ADD PRIMARY KEY (kolumna);`[cite: 19] |
| **Klucz Obcy (Relacja)** | `ALTER TABLE t1 ADD CONSTRAINT fk_nazwa FOREIGN KEY (k1) REFERENCES t2(k2);`[cite: 19, 20] |
| **Unikalność wartości** | `ALTER TABLE t ADD UNIQUE (kolumna);`[cite: 20] |
| **Pobieranie przedziału** | `WHERE kolumna BETWEEN min AND max`[cite: 19, 20] |
| **Dopasowanie z listy** | `WHERE kolumna IN ('val1', 'val2')`[cite: 19, 20] |
| **Losowanie z przedziału `<A; B>`** | `FLOOR(RAND() * (B - A + 1)) + A`[cite: 20] |
| **Wartość bezwzględna / Pierwiastek** | `ABS(liczba)` / `SQRT(liczba)`[cite: 20] |
````

Następny tekst mogę przygotować dokładnie w tym samym sposobie: **tylko Markdown, zero zmian treści**.
