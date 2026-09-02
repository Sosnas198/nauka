# 🏨 Kurs SQL od Podstaw: Praktyczny Przewodnik po Komendzie `SELECT`

Witaj w kolejnej lekcji SQL! Dzisiaj opanujemy najważniejsze narzędzie każdego analityka i programisty baz danych – instrukcję **`SELECT`**. Pozwala ona pobierać, filtrować, sortować oraz przekształcać dane znajdujące się w tabelach[cite: 22].

Nauczymy się tego na realnym przykładzie **Systemu Zarządzania Pensjonatem**[cite: 22].

---

## 📐 1. Anatomia Instrukcji `SELECT`

Zapytanie `SELECT` składa się z klauzul ukierunkowanych na konkretne zadania[cite: 22]. Kolejność ich zapisywania ma kluczowe znaczenie[cite: 22]:

````sql
SELECT [DISTINCT] kolumny
FROM tabele
[WHERE warunek_filtrowania]
[GROUP BY grupowanie_wynikow]
[HAVING warunek_grupowania]
[ORDER BY sortowanie_kolumn ASC|DESC]
[LIMIT maksymalna_liczba_wierszy];
```[cite: 22]

### 💡 Słowniczek klauzul dla początkujących[cite: 22]:
* **`SELECT`** – co chcesz zobaczyć? (wyznacza kolumny)[cite: 22].
* **`DISTINCT`** – usuwa powtarzające się wartości z wyniku[cite: 22].
* **`FROM`** – skąd pobrać dane? (wskazuje tabelę lub tabele)[cite: 22].
* **`WHERE`** – które wiersze spełniają warunek? (filtrowanie podstawowe)[cite: 22].
* **`ORDER BY`** – jak ułożyć wyniki? (`ASC` = rosnąco od A do Z / od najmniejszej; `DESC` = malejąco)[cite: 22].
* **`LIMIT`** – ile maksymalnie wierszy wyświetlić na ekranie?[cite: 22]

---

## 🗄️ 2. Przygotowanie Bazy Danych `PENSJONAT`

Zanim przejdziemy do zapytań, zbudujmy strukturę tabel oraz zaimportujmy dane z plików CSV (`POKOJE.csv` oraz `Rezerwacje.csv`)[cite: 22].

### A. Tworzenie bazy i tabel z dopasowaniem typów danych[cite: 22]

```sql
-- 1. Tworzenie bazy danych
CREATE DATABASE IF NOT EXISTS PENSJONAT;
USE PENSJONAT;

-- 2. Tabela POKOJE
CREATE TABLE POKOJE (
    numer TINYINT UNSIGNED PRIMARY KEY,
    liczba_miejsc TINYINT UNSIGNED,
    cena_za_dobe SMALLINT UNSIGNED,
    kolor VARCHAR(20)
);

-- 3. Tabela REZERWACJE
CREATE TABLE REZERWACJE (
    id MEDIUMINT UNSIGNED PRIMARY KEY,
    nrpokoju TINYINT UNSIGNED NOT NULL,
    odDnia DATE,
    liczba_dni TINYINT UNSIGNED,
    nazwisko VARCHAR(30),
    CONSTRAINT FK_P FOREIGN KEY (nrpokoju) REFERENCES POKOJE(numer)
);
```[cite: 22]

---

### B. Import danych z plików CSV (`LOAD DATA INFILE`)[cite: 22]

Jeśli posiadasz pliki CSV na serwerze bazy, importujesz je w następujący sposób[cite: 22]:

```sql
-- Import pokojów z POKOJE.csv
LOAD DATA INFILE 'POKOJE.csv'
INTO TABLE POKOJE
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(numer, liczba_miejsc, cena_za_dobe, kolor);

-- Import rezerwacji z Rezerwacje.csv
LOAD DATA INFILE 'Rezerwacje.csv'
INTO TABLE REZERWACJE
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(id, nrpokoju, odDnia, liczba_dni, nazwisko);
```[cite: 22]

---

## 🎯 3. Wyszukiwanie i Filtrowanie Danych w Praktyce

Przejdźmy krok po kroku przez najważniejsze przypadki użycia instrukcji `SELECT` na danych z naszego pensjonatu[cite: 22].

---

### Zadanie 1: Filtrowanie warunkiem numerycznym i sortowanie rosnące
> **Cel:** Wypisz z tabeli `POKOJE` pokoje, w których cena za dobę jest niższa niż 150 zł. Wynik posortuj rosnąco według ceny[cite: 22].

```sql
SELECT *
FROM POKOJE
WHERE cena_za_dobe < 150
ORDER BY cena_za_dobe ASC;
```[cite: 22]

💡 **Jak to działa?**
1. Baza szuka w tabeli `POKOJE` tylko wierszy, gdzie `cena_za_dobe` jest mniejsza od 150[cite: 22].
2. Klauzula `ORDER BY ... ASC` układa je od najtańszego do najdroższego (`ASC` oznacza *ascending* – rosnąco)[cite: 22].
3. `*` wskazuje, że wyświetlamy wszystkie kolumny tabeli[cite: 22].

---

### Zadanie 2: Sprawdzanie wielu wartości tekstowych (`OR` oraz `IN`)
> **Cel:** Wypisz z tabeli `REZERWACJE` wszystkie rezerwacje złożone przez osoby o nazwiskach **Paluszkiewicz** oraz **Prokurent**[cite: 22].

#### Sposób A (z operatorem `OR`)[cite: 22]:
```sql
SELECT *
FROM REZERWACJE
WHERE nazwisko = 'Paluszkiewicz' OR nazwisko = 'Prokurent';
```[cite: 22]

#### Sposób B (bardziej elegancki – z operatorem `IN`):
```sql
SELECT *
FROM REZERWACJE
WHERE nazwisko IN ('Paluszkiewicz', 'Prokurent');

````

💡 **Wskazówka:** Operator `IN (...)` sprawdza, czy wartość z kolumny znajduje się na liście podanej w nawiasie. Jest znacznie czytelniejszy, gdy szukamy kilku różnych tekstów lub liczb!

### Zadanie 3: Filtrowanie po tekście wielkimi/małymi literami

> **Cel:** Wypisz numery pokojów o kolorze ścian niebieskim lub zielonym[cite: 22].

SQL

````
SELECT numer
FROM POKOJE
WHERE kolor = 'NIEBIESKI' OR kolor = 'ZIELONY';
```[cite: 22]

💡 **Wskazówka:** Pobieramy tylko kolumnę `numer`, a nie całe wiersze[cite: 22]. Baza nie rozróżnia wielkości liter przy domyślnym kodowaniu `utf8_polish_ci`, więc `'niebieski'` zadziała tak samo jak `'NIEBIESKI'`.

---

### Zadanie 4: Eliminowanie powtórzeń (`DISTINCT`)
> **Cel:** Wypisz wszystkie unikalne zestawienia kolorów ścian i liczby miejsc w pokojach. Uporządkuj je alfabetycznie według koloru[cite: 22].

```sql
SELECT DISTINCT kolor, liczba_miejsc
FROM POKOJE
ORDER BY kolor ASC;
```[cite: 22]

💡 **Jak działa `DISTINCT`?[cite: 22]**
Jeśli w bazie mamy 5 pokojów zielonych 2-osobowych, `DISTINCT` sprawi, że para `(ZIELONY, 2)` pojawi się w wynikach **tylko jeden raz**[cite: 22].

---

### Zadanie 5: Sortowanie dat od najnowszej (`DESC`)
> **Cel:** Wyświetl wszystkie rezerwacje z tabeli `REZERWACJE` posortowane od najnowszego dnia przyjazdu do najstarszego[cite: 22].

```sql
SELECT *
FROM REZERWACJE
ORDER BY odDnia DESC;
```[cite: 22]

💡 **Wskazówka:** `DESC` (*descending*) oznacza sortowanie malejące[cite: 22]. Przy typach danych `DATE` najnowsza data ma większą wartość numeryczną niż starsza, dlatego ułoży się na samej górze.

---

### Zadanie 6: Ograniczanie liczby wyników (`LIMIT`)
> **Cel:** Wypisz 3 pierwsze rezerwacje na czas dłuższy niż 3 dni, sortując je od najkrótszej rezerwacji[cite: 22].

```sql
SELECT *
FROM REZERWACJE
WHERE liczba_dni > 3
ORDER BY liczba_dni ASC
LIMIT 3;
```[cite: 22]

💡 **Kolejność wykonywania:**
1. Filtrowanie (`WHERE liczba_dni > 3`)[cite: 22].
2. Sortowanie rosnące (`ORDER BY liczba_dni ASC`)[cite: 22].
3. Obcięcie wyniku do 3 rekordów (`LIMIT 3`)[cite: 22].

---

### Zadanie 7: Przezwiska kolumn (Aliasy – `AS`)
> **Cel:** Wyświetl numery pokojów, liczbę miejsc i kolor, zmieniając nazwy kolumn w nagłówkach wyniku na odpowiednio: `nr`, `liczba miejsc`, `pomalowany na`[cite: 22].

```sql
SELECT
    numer AS nr,
    liczba_miejsc AS 'liczba miejsc',
    kolor AS 'pomalowany na'
FROM POKOJE;
```[cite: 22]

💡 **Zapamiętaj:** Jeżeli alias zawiera spacię (np. `liczba miejsc`), **musisz ująć go w cudzysłów lub apostrofy**[cite: 22]!

---

### Zadanie 8: Wybieranie zakresów liczbowych (`BETWEEN ... AND`)
> **Cel:** Wypisz rezerwacje dla pokojów o numerach od 10 do 13 włącznie[cite: 22].

```sql
SELECT *
FROM REZERWACJE
WHERE nrpokoju BETWEEN 10 AND 13;
```[cite: 22]

💡 **Wskazówka:** Zapis `nrpokoju BETWEEN 10 AND 13` jest dokładnie tym samym co `nrpokoju >= 10 AND nrpokoju <= 13`[cite: 22]. Pamiętaj, że wartości skrajne (10 i 13) również wchodzą w zakres!

---

### Zadanie 9: Wielopoziomowe sortowanie (`ORDER BY k1, k2`)
> **Cel:** Wyświetl rezerwacje dla pokojów o numerach 1, 2, 3, 12 i 13[cite: 22]. Posortuj je według numeru pokoju malejąco (`DESC`), a przy tym samym numerze pokoju – rosnąco według liczby dni (`ASC`)[cite: 22].

```sql
SELECT *
FROM REZERWACJE
WHERE nrpokoju IN (1, 2, 3, 12, 13)
ORDER BY nrpokoju DESC, liczba_dni ASC;
```[cite: 22]

💡 **Jak działa sortowanie po wielu kolumnach?[cite: 22]**
Baza w pierwszej kolejności układa dane według `nrpokoju` malejąco (np. 13, 12, 3...)[cite: 22]. Jeśli pokój `13` ma kilka rezerwacji, baza uporządkuje te konkretne rezerwacje według `liczba_dni` od najkrótszej do najdłuższej[cite: 22].

---

## 🛠️ Ściągawka Operatorów i Warunków w SQL

| Operator | Zastosowanie | Przykład |
| :--- | :--- | :--- |
| **`=` / `!=`** | Równość / Nierówność | `WHERE kolor = 'RÓŻOWY'` |
| **`<` / `>` / `<=` / `>=`** | Porównania liczbowe i dat | `WHERE cena_za_dobe <= 200` |
| **`BETWEEN A AND B`** | Przynależność do przedziału domkniętego `<A; B>` | `WHERE nrpokoju BETWEEN 5 AND 10`[cite: 22] |
| **`IN (A, B, C)`** | Dopasowanie do dowolnej wartości z listy | `WHERE nrpokoju IN (1, 2, 3)`[cite: 22] |
| **`LIKE`** | Szukanie wzorca tekstowego (`%` = dowolny ciąg znaków) | `WHERE nazwisko LIKE 'Kow%'` |
| **`IS NULL` / `IS NOT NULL`** | Sprawdzanie braku wartości (pustego pola) | `WHERE odDnia IS NOT NULL` |
| **`AND` / `OR` / `NOT`** | Łączenie warunków logicznych | `WHERE cena_za_dobe < 100 AND lic
```
````
