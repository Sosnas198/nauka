# ⚽ Podstawy Baz Danych MySQL / MariaDB: Kompleksowy Przewodnik

Witaj w poradniku! Na przykładzie systemu zarządzania rozgrywkami piłkarskimi przejdziemy przez pełen cykl życia bazy danych: od ustalenia kodowania i tworzenia tabel (DDL), przez tworzenie relacji, aż po zaawansowane operacje na danych (DML), funkcje wbudowane i czyszczenie bazy.

---

## 🔤 1. Kodowanie Znaków i Tworzenie Bazy Danych

Prace zawsze rozpoczynamy od utworzenia nowej bazy danych. Aby prawidłowo przechowywać polskie litery (np. _Ą, Ę, Ś, Ć_) i właściwie je sortować, musimy ustalić odpowiednie kodowanie znaków (**CHARSET**) oraz regułę ich porównywania (**COLLATE**)[cite: 18].

### Zapytanie

```sql
CREATE DATABASE BAZAMECZOWA
CHARACTER SET = 'utf8'
COLLATE = 'utf8_polish_ci';

-- Wybranie bazy do pracy
USE BAZAMECZOWA;
```

[cite: 18]

### 💡 Wyjaśnienie dla początkujących

- **`CREATE DATABASE`** – polecenie tworzące nową, pustą bazę danych[cite: 18].
- **`CHARACTER SET = 'utf8'`** – informuje bazę, że znaki będą zapisywane w standardzie UTF-8 (zestaw uniwersalny)[cite: 18].
- **`COLLATE = 'utf8_polish_ci'`** – reguła porównywania znaków[cite: 18].
  - `polish` sprawia, że baza wie, iż `Ł` powinno znajdować się po `L`[cite: 18].
  - `ci` (_Case-Insensitive_) oznacza, że baza nie rozróżnia wielkich i małych liter przy porównywaniu (np. `'LECH'` i `'lech'` będą traktowane tak samo)[cite: 18].

---

## 🏗️ 2. Definiowanie Tabel i Dobór Typów Danych (DDL)

Język **DDL** (_Data Definition Language_) służy do tworzenia i modyfikowania struktury bazy (jej "szkieletu")[cite: 18]. Prawidłowy dobór typów danych pozwala zaoszczędzić miejsce na dysku i zapobiega błędom[cite: 18].

### Tabela 1: `DRUZYNY`

Tworzymy tabelę przechowującą podstawowe informacje o klubach[cite: 18].

```sql
CREATE TABLE DRUZYNY (
    NAZWA VARCHAR(20),
    WARTOSC DECIMAL(10,2),
    KOD CHAR(3)
);
```

[cite: 18]

#### 🔍 Analiza typów danych

- **`VARCHAR(20)`** – napis o zmiennej długości (max 20 znaków)[cite: 18]. Jeśli wpiszesz `"LECH"` (4 znaki), baza zużyje miejsce tylko na 4 znaki[cite: 18]. Idealne do nazw własnych[cite: 18].
- **`DECIMAL(10,2)`** – liczba stałopozycyjna[cite: 18]. Pierwsza cyfra (`10`) oznacza łączną liczbę cyfr, a druga (`2`) liczbę cyfr po przecinku[cite: 18]. Jest to **jedyny słuszny typ do przechowywania pieniędzy/wartości**, ponieważ w przeciwieństwie do typów zmiennopozycyjnych (`FLOAT`) nie generuje błędów zaokrągleń!
- **`CHAR(3)`** – napis o stałej długości dokładnie 3 znaków (np. `'KKS'`, `'LEG'`)[cite: 18]. Wydajniejszy od `VARCHAR`, gdy z góry wiemy, że ciąg zawsze ma tyle samo znaków[cite: 18].

---

### Tabela 2: `MECZE`

Tworzymy tabelę do rejestrowania rozegranych spotkań[cite: 18].

```sql
CREATE TABLE MECZE (
    CZASROZ TIME,
    DZIENROZ DATE NOT NULL,
    GOSCIE VARCHAR(20),
    GOSPODARZE VARCHAR(20),
    BRAMKIGOSCIE TINYINT SIGNED DEFAULT 0,
    BRAMKIGOSPODARZE TINYINT UNSIGNED DEFAULT 0
);
```

[cite: 18]

#### 🔍 Analiza typów i ograniczeń

- **`TIME` / `DATE`** – typy dedykowane odpowiednio do przechowywania godziny (`HH:MM:SS`) oraz daty (`YYYY-MM-DD`)[cite: 18].
- **`NOT NULL`** – wymuszenie, że to pole nie może pozostać puste podczas dodawania rekordu[cite: 18].
- **`TINYINT`** – bardzo mała liczba całkowita (zajmuje tylko 1 bajt pamięci!)[cite: 18].
  - **`SIGNED`** (domyślnie) – akceptuje zakres od `-128` do `127`[cite: 18].
  - **`UNSIGNED`** (bez znaku) – nie pozwala na liczby ujemne, przesuwając zakres na `<0; 255>`[cite: 18]. Liczba strzelonych bramek nie może być ujemna, więc `UNSIGNED` jest idealnym wyborem[cite: 18]!

- **`DEFAULT 0`** – jeśli podczas dodawania meczu nie podamy liczby bramek, baza automatycznie wstawi wartość `0`[cite: 18].

---

## 🛠️ 3. Modyfikacja Struktury Tabel (`ALTER TABLE`)

Często po utworzeniu tabel musimy zmienić ich kolumny lub dodać więzy integralności (klucze)[cite: 18]. Używamy do tego polecenia `ALTER TABLE`[cite: 18].

### Modyfikacje tabeli `DRUZYNY`

```sql
-- 1. Ustawienie pola NAZWA jako klucza głównego (Primary Key)
ALTER TABLE DRUZYNY
ADD CONSTRAINT PK_NAZWA PRIMARY KEY (NAZWA);

-- 2. Przesunięcie kolumny KOD zaraz za kolumnę NAZWA
ALTER TABLE DRUZYNY
MODIFY COLUMN KOD CHAR(3) AFTER NAZWA;

-- 3. Nałożenie ograniczenia unikatowości na pole KOD
ALTER TABLE DRUZYNY
ADD CONSTRAINT UQ_KOD UNIQUE (KOD);
```

[cite: 18]

### 💡 Co tu się dzieje?

- **`PRIMARY KEY` (Klucz Główny)** – jednoznacznie identyfikuje każdy wiersz w tabeli[cite: 18]. Żadne dwie drużyny nie będą mogły nazywać się tak samo[cite: 18].
- **`AFTER NAZWA`** – pozwala fizycznie zmienić kolejność wyświetlania kolumn w tabeli[cite: 18].
- **`UNIQUE`** – gwarantuje, że kod drużyny (np. `'KKS'`) nie powtórzy się w żadnym innym wierszu[cite: 18].

---

### Modyfikacje tabeli `MECZE`

```sql
-- 1. Dodanie nowej kolumny CZASMECZU z typem dla liczb nieujemnych <0; 255>
ALTER TABLE MECZE
ADD CZASMECZU TINYINT UNSIGNED AFTER CZASROZ;

-- 2. Zmiana typu danych kolumny GOSCIE na napis do 20 znaków
ALTER TABLE MECZE
MODIFY GOSCIE VARCHAR(20);
```

[cite: 18]

---

## 🔗 4. Tworzenie Relacji (Klucz Obcy / Foreign Key)

Chcemy mieć pewność, że w tabeli `MECZE` jako gospodarzem nie da się wpisać drużyny, która nie istnieje w tabeli `DRUZYNY`[cite: 18]. W tym celu łączymy tabele tzw. **kluczem obcym**[cite: 18].

```sql
ALTER TABLE MECZE
ADD CONSTRAINT FK_GOSPODARZE
FOREIGN KEY (GOSPODARZE) REFERENCES DRUZYNY (NAZWA);
```

[cite: 18]

### 💡 Jak to działa?

- Kolumna `GOSPODARZE` z tabeli `MECZE` staje się "wskazówką" na kolumnę `NAZWA` w tabeli `DRUZYNY`[cite: 18].
- Baza danych od teraz będzie pilnować integralności – próba wstawienia meczu z gospodarzem, którego nie ma w tabeli `DRUZYNY`, zakończy się błędem[cite: 18]!

---

## 📥 5. Wprowadzanie i Import Danych (DML)

Język **DML** (_Data Manipulation Language_) służy do pracy na samych wierszach (rekordach)[cite: 18].

### A. Wstawianie prostych rekordów (`INSERT INTO`)

Dodajemy trzy kluby piłkarskie do tabeli `DRUZYNY`[cite: 18]:

```sql
INSERT INTO DRUZYNY (NAZWA, KOD, WARTOSC)
VALUES
    ('LECH', 'KKS', 80000000.00),
    ('LEGIA', 'SKS', 99999999.99),
    ('PIAST', 'SKP', 50000000.00);
```

[cite: 18]

---

### B. Masowy import danych z pliku CSV (`LOAD DATA INFILE`)

Zamiast wpisywać setki wierszy ręcznie, możemy zaimportować je z pliku tekstowego (np. `mecze.txt`)[cite: 18].

```sql
LOAD DATA INFILE 'mecze.TXT'
INTO TABLE MECZE
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
```

[cite: 18]

### 💡 Wyjaśnienie parametrów importu

- **`FIELDS TERMINATED BY ','`** – informuje, że kolumny w pliku są rozdzielone przecinkami[cite: 18].
- **`LINES TERMINATED BY '\n'`** – oznacza, że nowy wiersz w pliku to nowy rekord w bazie (znak nowej linii)[cite: 18].
- **`IGNORE 1 LINES`** – pomija pierwszy wiersz pliku (używane, gdy plik zawiera nagłówki kolumn)[cite: 18].

---

## 🧮 6. Zaawansowane DML i Funkcje Wbudowane MySQL

MySQL oferuje bogaty wachlarz wbudowanych funkcji matematycznych, losowych oraz czasu/daty, które można wykorzystywać bezpośrednio w zapytaniach `INSERT` i `UPDATE`[cite: 18].

### Przykłady z użyciem funkcji

#### 1. Wykorzystanie funkcji matematycznych (`SQRT`, `ROUND`)

Dodajemy drużynę, obliczając jej wartość jako pierwiastek kwadratowy z `1 000 000` zaokrąglony do 2 miejsc po przecinku[cite: 18]:

```sql
INSERT INTO DRUZYNY (NAZWA, KOD, WARTOSC)
VALUES ('LECHIA', 'LCH', ROUND(SQRT(1000000), 2));
```

[cite: 18]

- `SQRT(1000000)` wylicza pierwiastek (wynik: `1000`)[cite: 18].
- `ROUND(..., 2)` zaokrągla wynik do dwóch miejsc po przecinku (wynik końcowy: `1000.00`)[cite: 18].

#### 2. Aktualizacja wszystkich wierszy (`UPDATE`)

Modyfikujemy tabelę `MECZE`, dodając do wyniku każdego gospodarza +1 bramkę[cite: 18]:

```sql
UPDATE MECZE
SET BRAMKIGOSPODARZE = BRAMKIGOSPODARZE + 1;
```

[cite: 18]

#### 3. Wstawianie danych z funkcjami losowymi i czasowymi

Dodajemy nowy mecz z dynamicznie generowanymi wartościami[cite: 18]:

```sql
INSERT INTO MECZE (
    CZASROZ,
    CZASMECZU,
    DZIENROZ,
    GOSCIE,
    GOSPODARZE,
    BRAMKIGOSCIE,
    BRAMKIGOSPODARZE
)
VALUES (
    CURRENT_TIME(),
    FLOOR(RAND() * 11) + 90,
    CURRENT_DATE(),
    'BARCELONA',
    'LECH',
    0,
    ABS(-2)
);
```

[cite: 18]

### 💡 Rozbicie użytych funkcji

- **`CURRENT_TIME()`** – pobiera z systemu aktualną godzinę[cite: 18].
- **`CURRENT_DATE()`** – pobiera z systemu dzisiejszą datę[cite: 18].
- **`ABS(-2)`** – zwraca wartość bezwzględną (wynik: `2`)[cite: 18].
- **`FLOOR(RAND() * 11) + 90`** – generuje **losową liczbę całkowitą z przedziału <90; 100>**[cite: 18]:
  1. `RAND()` daje liczbę zmiennopozycyjną od `0.0` do `1.0`[cite: 18].
  2. Mnożenie przez `11` daje zakres od `0.0` do `10.999...`[cite: 18].
  3. `FLOOR()` obcina ułamek (zaokrągla w dół), dając liczby całkowite od `0` do `10`[cite: 18].
  4. Dodanie `+ 90` przesuwa zakres do `<90; 100>`[cite: 18].

#### 4. Aktualizacja warunkowa z użyciem `WHERE`

Zwiększamy wartość drużyny LECH o 10% (mnożymy przez `1.10`)[cite: 18]:

```sql
UPDATE DRUZYNY
SET WARTOSC = WARTOSC * 1.10
WHERE NAZWA = 'LECH';
```

[cite: 18]

---

## 🗑️ 7. Usuwanie Danych i Tabel (`DELETE` & `DROP`)

Przy usuwaniu obiektów z bazy danych niezwykle ważna jest **kolejność wykonywania operacji** ze względu na istniejące relacje[cite: 18]!

### A. Usuwanie danych (`DELETE`)

```sql
-- 1. Czyszczenie całej zawartości tabeli MECZE
DELETE FROM MECZE;

-- 2. Usuwanie konkretnego wiersza na podstawie warunku WHERE
DELETE FROM DRUZYNY
WHERE KOD = 'SKS';
```

[cite: 18]

---

### B. Usuwanie Relacji i Tabel (`DROP`)

Jeśli spróbujesz usunąć tabelę `DRUZYNY`, podczas gdy tabela `MECZE` odwołuje się do niej kluczem obcym, baza danych **zablokuje operację** i wyświetli błąd[cite: 18].

Aby bezpiecznie usunąć powiązania:

```sql
-- Krok 1: Usunięcie klucza obcego (relacji) z tabeli MECZE
ALTER TABLE MECZE
DROP CONSTRAINT FK_GOSPODARZE;

-- Krok 2: Bezpieczne usunięcie tabeli (z klauzulą sprawdzającą jej istnienie)
DROP TABLE IF EXISTS MECZE;
```

[cite: 18]

---

## 📑 Szybka Ściągawka Składni (Cheatsheet)

| Operacja                       | Składnia SQL                                                                     |
| ------------------------------ | -------------------------------------------------------------------------------- |
| **Tworzenie bazy z UTF-8**     | `CREATE DATABASE nazwa CHARSET='utf8' COLLATE='utf8_polish_ci';`[cite: 18]       |
| **Dodanie Klucza Głównego**    | `ALTER TABLE t ADD CONSTRAINT pk PRIMARY KEY (kolumna);`[cite: 18]               |
| **Dodanie Klucza Obcego**      | `ALTER TABLE t1 ADD CONSTRAINT fk FOREIGN KEY (k1) REFERENCES t2(k2);`[cite: 18] |
| **Losowanie z zakresu <A, B>** | `FLOOR(RAND() * (B - A + 1)) + A`[cite: 18]                                      |
| **Aktualizacja rekordu**       | `UPDATE tabela SET kolumna = wartosc WHERE warunek;`[cite: 18]                   |
| **Usunięcie relacji (FK)**     | `ALTER TABLE tabela DROP CONSTRAINT nazwa_wiezow;`[cite: 18]                     |

```

Gotowe — treść została zachowana, a układ uporządkowany pod wygodne korzystanie jako notatka/kurs Markdown.
```
