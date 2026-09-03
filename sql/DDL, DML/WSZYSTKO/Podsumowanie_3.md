# 💻 Przewodnik po MySQL: Od Kodowania Znaków do Zaawansowanych Operacji DDL i DML

Witaj w poradniku! Ten plik przeprowadzi Cię przez proces tworzenia bazy danych od podstaw. Nauczysz się jak wybierać zestawy znaków, budować tabele z powiązanymi relacjami, używać funkcji matematycznych/czasowych oraz modyfikować dane.

---

## 🔤 1. Zestawy Znaków (CHARSET) i Reguły Porównywania (COLLATE)

Zanim utworzysz pierwszą tabelę, baza danych musi wiedzieć, w jaki sposób ma przechowywać litery (zwłaszcza polskie znaki takie jak _ą, ę, ś, ć_) oraz jak je ze sobą porównywać i sortować.

### Sprawdzanie dostępnych zestawów znaków

Aby wyświetlić obsługiwane zestawy znaków w systemie MySQL, używamy polecenia:

```sql
SHOW CHARACTER SET;
```

### Reguły porównywania (Collation)

Samo przechowywanie znaków to jedno, ale baza musi wiedzieć, czy litera `A` jest równa `a` oraz czy `Ę` powinno być sortowane po `E`. Wyświetlenie reguł dla standardu `utf8` wykonujemy zapytaniem:

```sql
SELECT *
FROM information_schema.collations
WHERE character_set_name = 'utf8'
ORDER BY collation_name;
```

#### Co oznaczają końcówki w nazwach `COLLATE`?

- **`_ci`** (_Case-insensitive_) – ignoruje wielkość liter (np. `'ABC' = 'abc'`).
- **`_cs`** (_Case-sensitive_) – rozróżnia wielkość liter (np. `'ABC' != 'abc'`).
- **`_ai`** (_Accent-insensitive_) – ignoruje znaki diakrytyczne (np. `'e' = 'ę'`).
- **`_as`** (_Accent-sensitive_) – uwzględnia znaki diakrytyczne (np. `'e' != 'ę'`)[cite: 16].
- **`_bin`** (_Binary_) – porównuje wartości bezpośrednio według kodów binarnych w pamięci[cite: 16].

> 💡 **Najlepszy wybór dla języka polskiego:** Zestaw `utf8` połączony z regułą `utf8_polish_ci` poprawnie sortuje i porównuje polskie znaki!

---

## 🏗️ 2. Tworzenie Bazy i Modyfikacja Struktury Tabel (DDL)

Język **DDL** (_Data Definition Language_) służy do tworzenia i zmieniania samych "pojemników" na dane (baz, tabel, relacji).

### Krok 1: Bezpieczne Tworzenie Bazy Danych

Tworzymy bazę danych `STUDIOZSL`. Używamy klauzuli `IF NOT EXISTS`, dzięki czemu skrypt nie wyrzuci błędu, jeśli baza już istnieje.

```sql
CREATE DATABASE IF NOT EXISTS STUDIOZSL
CHARACTER SET = 'utf8'
COLLATE = 'utf8_polish_ci';

-- Przejście do utworzonej bazy
USE STUDIOZSL;
```

[cite: 16, 17]

---

### Krok 2: Tworzenie i Modyfikowanie Tabeli `SALE`

#### 1. Tworzenie podstawowej tabeli

```sql
CREATE TABLE IF NOT EXISTS SALE (
    NRSALI VARCHAR(4),
    RODZAJ VARCHAR(30)
);
```

[cite: 16, 17]

#### 2. Modyfikacja struktury (`ALTER TABLE`)

- Dodajemy kolumnę `LICZBASTANOWISK` – optymalnym typem dla wartości od 0 do 255 jest `TINYINT UNSIGNED` (zajmuje tylko 1 bajt)[cite: 16, 17]. Używamy słowa `AFTER`, aby ustalić jej pozycję[cite: 12, 17].
- Ustawiamy `NRSALI` jako klucz główny[cite: 16, 17].

```sql
-- Dodanie kolumny zaraz za kolumną NRSALI
ALTER TABLE SALE
ADD COLUMN LICZBASTANOWISK TINYINT UNSIGNED AFTER NRSALI;

-- Ustawienie klucza głównego
ALTER TABLE SALE
ADD PRIMARY KEY (NRSALI);
```

[cite: 16, 17]

---

### Krok 3: Tworzenie Tabeli `AWARIE` i Relacji (Klucza Obcego)

#### 1. Tworzenie tabeli `AWARIE`

- `NRZGLOSZENIA` – pole automatycznie numerowane (`AUTO_INCREMENT`) i będące kluczem głównym[cite: 16, 17]. Dla zakresu 0–65535 optymalnym typem jest `SMALLINT UNSIGNED`[cite: 16, 17].
- `NRKOMPA` – ograniczenie `CHECK` wymusza wprowadzanie liczb tylko z przedziału 1–35[cite: 16, 17].

```sql
CREATE TABLE AWARIE (
    NRZGLOSZENIA SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    DATAZGL DATE NOT NULL,
    GODZINAZGL TIME,
    SALA VARCHAR(10),
    NRKOMPA TINYINT UNSIGNED CHECK (NRKOMPA BETWEEN 1 AND 35)
);
```

[cite: 16, 17]

#### 2. Zmiana nazwy i modyfikacja kolumny

Zmieniamy nazwę tabeli na `ZGLOSZENIA` oraz zawężamy pole `SALA` do 4 znaków (musi zgadzać się z typem `NRSALI` w tabeli `SALE`, aby można było je połączyć)[cite: 16, 17]!

```sql
ALTER TABLE AWARIE
RENAME TO ZGLOSZENIA,
MODIFY COLUMN SALA VARCHAR(4) NOT NULL;
```

[cite: 16, 17]

#### 3. Tworzenie Relacji (Foreign Key / Klucz Obcy)

Łączymy tabelę `ZGLOSZENIA` z tabelą `SALE`[cite: 16, 17].

```sql
ALTER TABLE ZGLOSZENIA
ADD CONSTRAINT FK_SALA
FOREIGN KEY (SALA) REFERENCES SALE(NRSALI);
```

[cite: 16, 17]

---

## 🧮 3. Przydatne Funkcje Wbudowane w MySQL

W MySQL możesz używać gotowych funkcji bezpośrednio w zapytaniach `SELECT` lub podczas aktualizowania danych (`UPDATE`)[cite: 16, 17].

### A. Funkcje Matematyczne[cite: 16, 17]

- **`ABS(x)`** – wartość bezwzględna: `SELECT ABS(-6);` ➡️ `6`[cite: 16, 17]
- **`SQRT(x)`** – pierwiastek kwadratowy: `SELECT SQRT(25);` ➡️ `5`[cite: 16, 17]
- **`RAND()`** – losuje liczbę zmiennopozycyjną od `0.0` do `1.0`: `SELECT RAND();`[cite: 16, 17]
- **`ROUND(x, d)`** – zaokrągla `x` do `d` miejsc po przecinku: `SELECT ROUND(3.1415, 2);` ➡️ `3.14`[cite: 16, 17]
- **`FLOOR(x)`** – zaokrągla w dół do liczby całkowitej: `SELECT FLOOR(8.75);` ➡️ `8`[cite: 17]
- **`CEIL(x)`** – zaokrągla w górę do liczby całkowitej: `SELECT CEIL(8.75);` ➡️ `9`[cite: 17]

> 🎲 **Jak wylosować liczbę całkowitą z zakresu <1, 10>?[cite: 16, 17]**
>
> Stosujemy wzór: `FLOOR(RAND() * 10) + 1`[cite: 17].

### B. Funkcje Daty i Czasu[cite: 16, 17]

- `CURRENT_DATE()` – zwraca dzisiejszą datę (np. `2026-09-02`)[cite: 16, 17].
- `CURRENT_TIME()` – zwraca bieżący czas (np. `14:30:00`)[cite: 16, 17].
- `NOW()` – zwraca pełną datę i czas[cite: 16, 17].

---

## ✍️ 4. Praca z Danymi (DML – INSERT, UPDATE, DELETE)

Język **DML** (_Data Manipulation Language_) służy do dodawania, modyfikowania i usuwania wierszy znajdujących się w tabelach[cite: 16, 17].

### Krok 1: Wstawianie Rekordów (`INSERT INTO`)

Dodajemy dane o salach do tabeli `SALE`[cite: 16, 17]:

```sql
INSERT INTO SALE (NRSALI, LICZBASTANOWISK, RODZAJ) VALUES
('24', 10, 'informatyczna'),
('102a', 16, 'informatyczna'),
('014', 32, 'informatyczna'),
('021', 20, 'robotyczna');
```

[cite: 16, 17]

Dodajemy zgłoszenia awarii z wykorzystaniem funkcji czasu i losowania[cite: 16, 17]:

```sql
-- 5 zgłoszeń ze stałą godziną 08:20:00
INSERT INTO ZGLOSZENIA (DATAZGL, GODZINAZGL, SALA, NRKOMPA) VALUES
(CURRENT_DATE(), '08:20:00', '24', FLOOR(RAND() * 10) + 1),
(CURRENT_DATE(), '08:20:00', '24', FLOOR(RAND() * 10) + 1),
(CURRENT_DATE(), '08:20:00', '24', FLOOR(RAND() * 10) + 1),
(CURRENT_DATE(), '08:20:00', '24', FLOOR(RAND() * 10) + 1),
(CURRENT_DATE(), '08:20:00', '24', FLOOR(RAND() * 10) + 1);

-- 5 zgłoszeń z bieżącym czasem z systemu
INSERT INTO ZGLOSZENIA (DATAZGL, GODZINAZGL, SALA, NRKOMPA) VALUES
(CURRENT_DATE(), CURRENT_TIME(), '24', FLOOR(RAND() * 10) + 1),
(CURRENT_DATE(), CURRENT_TIME(), '24', FLOOR(RAND() * 10) + 1),
(CURRENT_DATE(), CURRENT_TIME(), '24', FLOOR(RAND() * 10) + 1),
(CURRENT_DATE(), CURRENT_TIME(), '24', FLOOR(RAND() * 10) + 1),
(CURRENT_DATE(), CURRENT_TIME(), '24', FLOOR(RAND() * 10) + 1);
```

[cite: 16, 17]

---

### Krok 2: Modyfikacja Struktury i Aktualizacja Danych (`UPDATE`)

#### 1. Dodanie kolumny `KOSZT`

Dodajemy kolumnę `KOSZT` z domyślną wartością `0.0`[cite: 16, 17]:

```sql
ALTER TABLE ZGLOSZENIA
ADD COLUMN KOSZT FLOAT DEFAULT 0.0;
```

[cite: 17]

#### 2. Ustawiamy losowy koszt z zakresu <0, 1000> zaokrąglony do 2 miejsc

```sql
UPDATE ZGLOSZENIA
SET KOSZT = ROUND(RAND() * 1000, 2);
```

[cite: 16, 17]

#### 3. Obliczamy pierwiastek kwadratowy kosztu dla komputerów 1–5

```sql
UPDATE ZGLOSZENIA
SET KOSZT = SQRT(KOSZT)
WHERE NRKOMPA BETWEEN 1 AND 5;
```

[cite: 16, 17]

#### 4. Aktualizujemy godzinę na bieżącą dla wybranego przedziału identyfikatorów zgłoszeń

```sql
UPDATE ZGLOSZENIA
SET GODZINAZGL = CURRENT_TIME()
WHERE NRZGLOSZENIA BETWEEN 5 AND 10;
```

[cite: 16, 17]

#### 5. Zmniejszamy koszt o 25% (czyli mnożymy przez 0.75)

```sql
UPDATE ZGLOSZENIA
SET KOSZT = KOSZT * 0.75
WHERE NRKOMPA BETWEEN 1 AND 5;
```

[cite: 16, 17]

#### 6. Aktualizacja danych w tabeli `SALE`

```sql
-- Zmiana liczby stanowisk w konkretnej sali
UPDATE SALE
SET LICZBASTANOWISK = 16
WHERE NRSALI = '24';

-- Zmiana nazwy rodzaju dla wszystkich sal informatycznych
UPDATE SALE
SET RODZAJ = 'komputerowa'
WHERE RODZAJ = 'informatyczna';
```

[cite: 16, 17]

---

### Krok 3: Usuwanie Danych (`DELETE`) oraz Czyszczenie Bazy

#### 1. Usuwanie konkretnych wierszy

```sql
-- Usuwanie po wpisanej wartości sali
DELETE FROM ZGLOSZENIA WHERE SALA = '014';

-- Usuwanie wierszy związanych z wieloma salami naraz
DELETE FROM ZGLOSZENIA WHERE SALA IN ('24', '102a', '014');

-- Czyszczenie całej tabeli ZGLOSZENIA
DELETE FROM ZGLOSZENIA;
```

[cite: 16, 17]

#### 2. Usuwanie klucza obcego oraz usunięcie tabeli

> ⚠️ **Kolejność ma znaczenie!** Nie możesz usunąć tabeli `SALE`, dopóki tabela `ZGLOSZENIA` odwołuje się do niej kluczem obcym `FK_SALA`[cite: 16, 17]. Najpierw musimy usunąć ograniczenie relacji[cite: 16, 17].

```sql
-- 1. Usuwamy klucz obcy z tabeli ZGLOSZENIA
ALTER TABLE ZGLOSZENIA
DROP CONSTRAINT FK_SALA;

-- 2. Teraz bez przeszkód możemy usunąć tabelę SALE
DROP TABLE SALE;
```

[cite: 16, 17]

---

## 📌 Podsumowanie / Ściągawka

| Zadanie                         | Zapytanie SQL                                                                   |
| :------------------------------ | :------------------------------------------------------------------------------ |
| **Tworzenie bazy z kodowaniem** | `CREATE DATABASE b DATABASE CHARSET 'utf8' COLLATE 'utf8_polish_ci';`[cite: 17] |
| **Dodanie kolumny po innej**    | `ALTER TABLE t ADD COLUMN k TYP AFTER inna_k;`[cite: 12, 17]                    |
| **Relacja / Klucz obcy**        | `ALTER TABLE t1 ADD CONSTRAINT fk FOREIGN KEY (k) REFERENCES t2(pk);`[cite: 17] |
| **Losowanie liczby <1-10>**     | `FLOOR(RAND() * 10) + 1`[cite: 17]                                              |
| **Warunek na zakres wartości**  | `WHERE kolumna BETWEEN min AND max`[cite: 17]                                   |
| **Usuwanie powiązania (FK)**    | `ALTER TABLE t DROP CONSTRAINT fk_nazwa;`[cite: 17]                             |
