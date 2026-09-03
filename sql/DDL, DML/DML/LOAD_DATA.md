# `LOAD DATA` w MySQL — kompletna ściąga

`LOAD DATA` służy w MySQL do **szybkiego importowania dużej liczby danych z pliku**, najczęściej CSV, do tabeli.

---

## 1. Podstawowa składnia

```sql
LOAD DATA INFILE 'plik.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';
```

Czyli:

> Weź dane z pliku `plik.csv`, podziel je po przecinkach i wstaw kolejne wiersze do tabeli `klienci`.

---

## 2. Przykład od zera

Tabela:

```sql
CREATE TABLE klienci (
    id_klienta INT PRIMARY KEY,
    imie VARCHAR(50),
    nazwisko VARCHAR(50)
);
```

Plik `klienci.csv`:

```text
1,Jan,Kowalski
2,Anna,Nowak
3,Piotr,Wiśniewski
```

Import:

```sql
LOAD DATA INFILE 'klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';
```

Zamiast wielu instrukcji `INSERT` możesz załadować cały plik jednym poleceniem.

---

## 3. Co oznaczają poszczególne elementy?

### `LOAD DATA`

Rozpoczyna import danych z pliku.

```sql
LOAD DATA
```

### `INFILE`

Wskazuje plik, z którego MySQL ma pobrać dane.

```sql
INFILE 'klienci.csv'
```

### `INTO TABLE`

Określa tabelę, do której dane mają zostać wstawione.

```sql
INTO TABLE klienci
```

### `FIELDS TERMINATED BY`

Określa separator między kolumnami.

```sql
FIELDS TERMINATED BY ','
```

Dla pliku:

```text
1,Jan,Kowalski
```

oznacza:

```text
1          → pierwsza kolumna
Jan        → druga kolumna
Kowalski   → trzecia kolumna
```

### `LINES TERMINATED BY`

Określa, czym kończy się jeden wiersz danych.

```sql
LINES TERMINATED BY '\n'
```

---

# 4. Separatory kolumn

Jeśli plik ma przecinki:

```text
1,Jan,Kowalski
2,Anna,Nowak
```

użyj:

```sql
FIELDS TERMINATED BY ','
```

Jeśli ma średniki:

```text
1;Jan;Kowalski
2;Anna;Nowak
```

użyj:

```sql
FIELDS TERMINATED BY ';'
```

Jeśli kolumny są oddzielone tabulatorem:

```sql
FIELDS TERMINATED BY '\t'
```

Najważniejsza zasada:

> Separator w SQL musi odpowiadać separatorowi użytemu w pliku.

---

# 5. `LINES TERMINATED BY`

Najczęściej spotkasz:

```sql
LINES TERMINATED BY '\n'
```

Dla niektórych plików Windows może być potrzebne:

```sql
LINES TERMINATED BY '\r\n'
```

Warto znać różnicę:

```text
\n      → koniec linii typu Unix/Linux
\r\n    → koniec linii typu Windows
```

---

# 6. Kolejność kolumn

Załóżmy tabelę:

```sql
CREATE TABLE klienci (
    id_klienta INT,
    imie VARCHAR(50),
    nazwisko VARCHAR(50)
);
```

Plik:

```text
1,Jan,Kowalski
2,Anna,Nowak
```

MySQL domyślnie przyjmie:

```text
1         → id_klienta
Jan       → imie
Kowalski  → nazwisko
```

Czyli kolejność danych w pliku powinna odpowiadać kolejności kolumn w tabeli.

---

# 7. Jawne określenie kolumn

Możesz dokładnie wskazać, do których kolumn mają trafić dane:

```sql
LOAD DATA INFILE 'klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
(id_klienta, imie, nazwisko);
```

Jest to szczególnie przydatne, gdy kolejność danych w pliku różni się od kolejności kolumn w tabeli.

Przykład pliku:

```text
Jan,Kowalski,1
Anna,Nowak,2
```

Import:

```sql
LOAD DATA INFILE 'klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
(imie, nazwisko, id_klienta);
```

Wtedy:

```text
Jan        → imie
Kowalski   → nazwisko
1          → id_klienta
```

---

# 8. `IGNORE 1 ROWS`

Bardzo często plik CSV ma nagłówek:

```text
id_klienta,imie,nazwisko
1,Jan,Kowalski
2,Anna,Nowak
3,Piotr,Wiśniewski
```

Pierwszy wiersz nie jest rekordem klienta.

Dlatego używamy:

```sql
IGNORE 1 ROWS
```

Pełne polecenie:

```sql
LOAD DATA INFILE 'klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
```

Czyli:

> Pomiń pierwszy wiersz pliku.

---

# 9. `ENCLOSED BY`

Czasami CSV wygląda tak:

```text
1,"Jan","Kowalski"
2,"Anna","Nowak"
```

Wartości są otoczone cudzysłowami.

Możemy użyć:

```sql
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
```

Pełny przykład:

```sql
LOAD DATA INFILE 'klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n';
```

`ENCLOSED BY '"'` oznacza:

> Wartości w pliku mogą być otoczone cudzysłowem.

---

# 10. `LOCAL`

Bardzo ważna różnica:

```sql
LOAD DATA INFILE
```

oraz:

```sql
LOAD DATA LOCAL INFILE
```

## `LOAD DATA INFILE`

MySQL odczytuje plik z systemu plików **serwera MySQL**.

```sql
LOAD DATA INFILE '/ścieżka/klienci.csv'
INTO TABLE klienci
...
```

## `LOAD DATA LOCAL INFILE`

Plik znajduje się na **komputerze, z którego wykonujesz polecenie**.

```sql
LOAD DATA LOCAL INFILE 'C:/dane/klienci.csv'
INTO TABLE klienci
...
```

W praktycznych zadaniach bardzo często spotkasz:

```sql
LOAD DATA LOCAL INFILE
```

---

# 11. Pełny przykład CSV

Plik:

```text
id_klienta;imie;nazwisko
1;Jan;Kowalski
2;Anna;Nowak
3;Piotr;Wiśniewski
```

Tabela:

```sql
CREATE TABLE klienci (
    id_klienta INT PRIMARY KEY,
    imie VARCHAR(50),
    nazwisko VARCHAR(50)
);
```

Import:

```sql
LOAD DATA LOCAL INFILE 'klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
```

Po imporcie:

```text
id_klienta | imie  | nazwisko
-----------+-------+------------
1          | Jan   | Kowalski
2          | Anna  | Nowak
3          | Piotr | Wiśniewski
```

---

# 12. Zmienne `@`

W `LOAD DATA` możesz najpierw wczytać dane do zmiennych:

```sql
(@imie, @nazwisko)
```

a następnie zdecydować, co z nimi zrobić:

```sql
SET
    imie = UPPER(@imie),
    nazwisko = UPPER(@nazwisko);
```

Przykład:

Plik:

```text
jan,kowalski
anna,nowak
```

SQL:

```sql
LOAD DATA INFILE 'klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ','
(@imie, @nazwisko)
SET
    imie = UPPER(@imie),
    nazwisko = UPPER(@nazwisko);
```

W tabeli otrzymasz:

```text
JAN      | KOWALSKI
ANNA     | NOWAK
```

Schemat:

```text
plik
  ↓
@zmienna
  ↓
SET
  ↓
kolumna tabeli
```

---

# 13. Pomijanie kolumn za pomocą `@dummy`

Załóżmy, że plik ma cztery wartości:

```text
1,Jan,Kowalski,ABC123
2,Anna,Nowak,XYZ456
```

Ale tabela potrzebuje tylko pierwszych trzech.

Możesz zrobić:

```sql
LOAD DATA INFILE 'klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ','
(id_klienta, imie, nazwisko, @dummy);
```

`@dummy` oznacza, że wartość zostanie odczytana, ale nie zostanie zapisana do żadnej kolumny tabeli.

---

# 14. `SET` i przekształcanie danych

Możesz zmieniać dane podczas importu.

Przykład:

```sql
LOAD DATA INFILE 'klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ','
(@id, @imie, @nazwisko)
SET
    id_klienta = @id,
    imie = TRIM(@imie),
    nazwisko = TRIM(@nazwisko);
```

`TRIM()` usuwa zbędne spacje.

Dla:

```text
1, Jan , Kowalski
```

otrzymasz:

```text
Jan
Kowalski
```

zamiast wartości zawierających dodatkowe spacje.

---

# 15. Puste wartości i `NULL`

Przykładowy plik:

```text
1,Jan,Kowalski
2,Anna,
3,,Wiśniewski
```

Możesz użyć:

```sql
LOAD DATA INFILE 'klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ','
(@id, @imie, @nazwisko)
SET
    id_klienta = NULLIF(@id, ''),
    imie = NULLIF(@imie, ''),
    nazwisko = NULLIF(@nazwisko, '');
```

Funkcja:

```sql
NULLIF(@imie, '')
```

oznacza:

> Jeżeli wartość jest pustym tekstem `''`, zamień ją na `NULL`.

---

# 16. Daty

Jeżeli plik zawiera datę w formacie MySQL:

```text
1,Jan,2000-05-12
2,Anna,1999-03-20
```

możesz załadować ją bezpośrednio:

```sql
LOAD DATA INFILE 'pracownicy.csv'
INTO TABLE pracownicy
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n';
```

Jeżeli jednak plik ma:

```text
1,Jan,12.05.2000
2,Anna,20.03.1999
```

możesz użyć `STR_TO_DATE()`:

```sql
LOAD DATA INFILE 'pracownicy.csv'
INTO TABLE pracownicy
FIELDS TERMINATED BY ','
(@id, @imie, @data)
SET
    id = @id,
    imie = @imie,
    data_urodzenia = STR_TO_DATE(@data, '%d.%m.%Y');
```

---

# 17. `LOAD DATA` a `PRIMARY KEY`

Załóżmy:

```sql
CREATE TABLE klienci (
    id_klienta INT PRIMARY KEY,
    imie VARCHAR(50),
    nazwisko VARCHAR(50)
);
```

Tabela zawiera:

```text
1 | Jan | Kowalski
```

A plik zawiera:

```text
1,Piotr,Nowak
```

Wystąpi konflikt, ponieważ `id_klienta = 1` już istnieje.

`LOAD DATA` nadal respektuje ograniczenia tabeli, takie jak:

- `PRIMARY KEY`
- `NOT NULL`
- `UNIQUE`
- `FOREIGN KEY`
- typy danych

---

# 18. `IGNORE` przy konfliktach

Możesz spotkać:

```sql
LOAD DATA INFILE 'klienci.csv'
IGNORE
INTO TABLE klienci
FIELDS TERMINATED BY ',';
```

`IGNORE` zmienia sposób obsługi niektórych konfliktów podczas importu.

Nie należy mylić tego z:

```sql
IGNORE 1 ROWS
```

To są dwie różne rzeczy.

```sql
IGNORE 1 ROWS
```

→ pomija pierwszy wiersz pliku.

```sql
IGNORE
```

→ wpływa na obsługę konfliktów/błędów podczas importu.

---

# 19. `REPLACE`

Możesz również spotkać:

```sql
LOAD DATA INFILE 'klienci.csv'
REPLACE
INTO TABLE klienci
FIELDS TERMINATED BY ',';
```

Jeżeli importowany rekord koliduje z istniejącym rekordem, `REPLACE` może spowodować zastąpienie istniejącego rekordu.

Przykład:

Tabela:

```text
1 | Jan | Kowalski
```

Plik:

```text
1 | Piotr | Nowak
```

Przy odpowiednim użyciu `REPLACE` rekord z kluczem `1` może zostać zastąpiony.

Uwaga: `REPLACE` należy stosować świadomie, ponieważ może nadpisać istniejące dane.

---

# 20. `LOAD DATA` + `FOREIGN KEY`

To ważne, jeśli pracujesz z relacjami między tabelami.

Tabela klientów:

```sql
CREATE TABLE klienci (
    id_klienta INT PRIMARY KEY,
    imie VARCHAR(50),
    nazwisko VARCHAR(50)
);
```

Tabela zamówień:

```sql
CREATE TABLE zamowienia (
    id_zamowienia INT PRIMARY KEY,
    data_zamowienia DATE,
    id_klienta INT,
    FOREIGN KEY (id_klienta)
        REFERENCES klienci(id_klienta)
);
```

Najpierw importujemy klientów:

```sql
LOAD DATA LOCAL INFILE 'klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
```

Dopiero później zamówienia:

```sql
LOAD DATA LOCAL INFILE 'zamowienia.csv'
INTO TABLE zamowienia
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
```

Dlaczego?

Ponieważ zamówienie zawiera:

```text
id_klienta
```

które musi wskazywać na istniejącego klienta.

Przykład:

```text
klienci

id_klienta
    1
    2
    3

       ↑
       │
       │ FOREIGN KEY
       │
       ↓

zamowienia

id_zamowienia | id_klienta
101           | 1
102           | 2
103           | 1
```

Jeżeli spróbujesz dodać zamówienie dla:

```text
id_klienta = 15
```

ale klient `15` nie istnieje, ograniczenie `FOREIGN KEY` może zablokować import.

---

# 21. `secure_file_priv`

MySQL posiada ustawienie bezpieczeństwa:

```sql
SHOW VARIABLES LIKE 'secure_file_priv';
```

Może ono ograniczać katalogi, z których `LOAD DATA INFILE` może odczytywać pliki.

Jeżeli `LOAD DATA INFILE` zwraca błąd związany z dostępem do pliku, warto sprawdzić właśnie to ustawienie.

Przy:

```sql
LOAD DATA LOCAL INFILE
```

sytuacja jest inna, ponieważ plik znajduje się po stronie klienta i jest przesyłany do serwera.

---

# 22. `LOAD DATA` vs `INSERT`

`INSERT`:

```sql
INSERT INTO klienci
VALUES (1, 'Jan', 'Kowalski');
```

Nadaje się do ręcznego dodawania pojedynczych lub niewielkiej liczby rekordów.

`LOAD DATA`:

```sql
LOAD DATA LOCAL INFILE 'klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ',';
```

Nadaje się do importowania dużej liczby danych znajdujących się już w pliku.

W skrócie:

```text
INSERT
   ↓
podajesz dane bezpośrednio w SQL

LOAD DATA
   ↓
MySQL pobiera dane z pliku
```

---

# 23. Najczęstsze błędy

## Zły separator

Plik:

```text
1;Jan;Kowalski
```

a SQL:

```sql
FIELDS TERMINATED BY ','
```

To jest błąd logiczny.

Powinno być:

```sql
FIELDS TERMINATED BY ';'
```

---

## Zapomniany nagłówek

Plik:

```text
id_klienta;imie;nazwisko
1;Jan;Kowalski
```

Jeżeli nie użyjesz:

```sql
IGNORE 1 ROWS
```

MySQL spróbuje potraktować nagłówek jako dane.

---

## Zła ścieżka

```sql
LOAD DATA LOCAL INFILE 'C:/dane/klienci.csv'
```

Plik musi faktycznie znajdować się pod wskazaną ścieżką.

---

## Problem z `LOCAL`

Czasami:

```sql
LOAD DATA INFILE
```

nie działa, ponieważ serwer nie może odczytać wskazanego pliku.

W takiej sytuacji właściwe może być:

```sql
LOAD DATA LOCAL INFILE
```

o ile klient i serwer mają włączoną obsługę `LOCAL`.

---

## Problem z końcem linii

Jeżeli dane są importowane dziwnie, sprawdź:

```sql
LINES TERMINATED BY '\n'
```

lub:

```sql
LINES TERMINATED BY '\r\n'
```

---

## Konflikt `PRIMARY KEY`

Jeżeli tabela ma:

```sql
PRIMARY KEY
```

nie możesz normalnie zaimportować dwóch rekordów z takim samym kluczem.

---

## Konflikt `FOREIGN KEY`

Jeżeli tabela ma:

```sql
FOREIGN KEY (id_klienta)
REFERENCES klienci(id_klienta)
```

to wartość `id_klienta` musi wskazywać na istniejącego klienta.

---

# 24. Wzór do zapamiętania

Najważniejszy schemat:

```sql
LOAD DATA LOCAL INFILE 'dane.csv'
INTO TABLE tabela
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
```

Jeżeli trzeba wskazać kolumny:

```sql
LOAD DATA LOCAL INFILE 'dane.csv'
INTO TABLE tabela
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(kolumna1, kolumna2, kolumna3);
```

Jeżeli trzeba przekształcić dane:

```sql
LOAD DATA LOCAL INFILE 'dane.csv'
INTO TABLE tabela
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@a, @b, @c)
SET
    kolumna1 = @a,
    kolumna2 = TRIM(@b),
    kolumna3 = @c;
```

---

# 25. Ściąga — co musisz znać?

| Element | Znaczenie |
|---|---|
| `LOAD DATA` | rozpoczęcie importu |
| `LOCAL` | plik jest po stronie klienta |
| `INFILE` | wskazanie pliku |
| `INTO TABLE` | tabela docelowa |
| `FIELDS TERMINATED BY` | separator kolumn |
| `ENCLOSED BY` | znak otaczający wartości |
| `LINES TERMINATED BY` | separator wierszy |
| `IGNORE 1 ROWS` | pominięcie pierwszego wiersza |
| `(kolumny...)` | określenie kolejności kolumn |
| `SET` | przekształcanie danych |
| `@zmienna` | tymczasowe przechowanie wartości |
| `@dummy` | pominięcie wartości |
| `NULLIF()` | zamiana pustej wartości na `NULL` |
| `TRIM()` | usuwanie zbędnych spacji |
| `STR_TO_DATE()` | konwersja tekstu na datę |
| `IGNORE` | łagodniejsza obsługa niektórych konfliktów |
| `REPLACE` | zastępowanie konfliktujących rekordów |

---

# 26. Przykład „egzaminacyjny”

Masz plik:

```text
id_klienta;imie;nazwisko
1;Jan;Kowalski
2;Anna;Nowak
3;Piotr;Wiśniewski
```

Tabela:

```sql
CREATE TABLE klienci (
    id_klienta INT PRIMARY KEY,
    imie VARCHAR(50),
    nazwisko VARCHAR(50)
);
```

Prawidłowy import:

```sql
LOAD DATA LOCAL INFILE 'C:/dane/klienci.csv'
INTO TABLE klienci
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(id_klienta, imie, nazwisko);
```

Zapamiętaj przede wszystkim:

```text
LOAD DATA
    ↓
LOCAL INFILE
    ↓
INTO TABLE
    ↓
FIELDS TERMINATED BY
    ↓
LINES TERMINATED BY
    ↓
IGNORE 1 ROWS
    ↓
lista kolumn
```

To jest podstawowy schemat, który pozwala rozwiązać większość prostych zadań z `LOAD DATA`.
