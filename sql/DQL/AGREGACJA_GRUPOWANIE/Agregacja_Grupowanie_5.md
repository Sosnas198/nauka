Oto kompletny Przewodnik Praktyczny stworzony na podstawie udostępnionych materiałów systemów rekrutacji uczelnianej. Plik został podzielony na **część teoretyczną** (wyjaśnienie fundamentów dla osób początkujących) oraz **część warsztatową** (rozwiązania zadań rekrutacyjnych wraz z analizą powszechnych błędów syntaktycznych).

PDF+ 4

# 🎓 Podręcznik SQL: Bazy Danych i Systemy Rekrutacji (`Kandydaci`)

W tym opracowaniu przejdziemy przez proces projektowania bazy danych, definiowania poprawnych typów kolumn, tworzenia relacji klucza obcego oraz tworzenia zapytań analitycznych.

PDF+ 2

## 1. Architektura i Błędy w Typach Danych

Przed przystąpieniem do pisania zapytań należy przeanalizować strukturę dwóch powiązanych ze sobą tabel: `kandydaci` oraz `zgloszenia`.

PDF+ 2

```
┌────────────────────────────────────────┐       ┌───────────────────────────────────────┐
│              KANDYDACI                 │       │              ZGLOSZENIA               │
├────────────────────────────────────────┤       ├───────────────────────────────────────┤
│ 🔑 idosoby     : CHAR(4)               │ ◄───┐ │ 🔑 idzgloszenia : INT UNSIGNED AUTO_INC│
│    imie        : VARCHAR(20)           │     │ ├───────────────────────────────────────┤
│    nazwisko    : VARCHAR(40)           │     └─┼─ 🔗 idosoby     : CHAR(4)             │
│    matematyka  : TINYINT UNSIGNED      │       │    kierunek    : VARCHAR(20)          │
│    informatyka : TINYINT UNSIGNED      │       └───────────────────────────────────────┘
│    fizyka      : TINYINT UNSIGNED      │
│    jezykobcy   : TINYINT UNSIGNED      │
│    plec        : ENUM('k', 'm')        │
└────────────────────────────────────────┘

```

### 💡 Wyjaśnienie typów danych dla początkujących:

1. **`CHAR(4)`** **vs** **`VARCHAR(20)`**:
   - **`CHAR(4)`**: Stała długość znaków. Używana, gdy każdy kod ma dokładnie taką samą długość (np. `k001`, `k002`). Baza danych przetwarza ten typ szybciej.

     PDF+ 2

   - **`VARCHAR(20)`**: Zmienna długość znaków. Jeśli imię to "Jan" (3 litery), baza przeznaczy na nie tylko 3 znaki miejsca. Maximum w tym wypadku to 20.

     PDF+ 4

2. **`TINYINT UNSIGNED`**:
   - **`TINYINT`** to mała liczba całkowita zajmująca zaledwie 1 bajt.

     PDF+ 1

   - Modyfikator **`UNSIGNED`** usuwa obsługę liczb ujemnych. Zamiast zakresu −128…127, uzyskujemy zakres 0…255. Jest to optymalny typ dla punktów z matur (0…100).

     PDF+ 4

3. **`ENUM('k', 'm')`**:
   - Typ wyliczeniowy. Wymusza wpisanie wyłącznie jednej z określonych w nawiasie wartości. Zapobiega wprowadzaniu błędnych danych.

     PDF+ 4

4. **Relacje i Klucze (\*\***`PRIMARY KEY`\***\*,** **`FOREIGN KEY`\*\***)\*\*:
   - **`PRIMARY KEY`** **(Klucz Główny)**: Unikalny identyfikator każdego wiersza w tabeli (np. `idosoby` w `kandydaci`).

     PDF+ 1

   - **`FOREIGN KEY`** **(Klucz Obcy)**: Kolumna łącząca zgłoszenie z konkretną osobą. Gwarantuje spójność danych (tzw. integralność referencyjną) — nie można dodać zgłoszenia dla osoby, która nie istnieje w tabeli `kandydaci`.

     SQL+ 2

## 2. Tworzenie Bazy Danych i Tabel (Skrypt DDL)

Aby utworzyć strukturę zdefiniowaną w systemie rekrutacji, wykonuje się poniższy kod:

PDF+ 1

SQL

```sql id="c8x2mv"
CREATE DATABASE Kandydaci;
USE Kandydaci;

-- Tabela Kandydaci
CREATE TABLE kandydaci (
  idosoby CHAR(4) NOT NULL,
  imie VARCHAR(20) NOT NULL,
  nazwisko VARCHAR(40) NOT NULL,
  matematyka TINYINT(3) UNSIGNED DEFAULT NULL,
  informatyka TINYINT(3) UNSIGNED DEFAULT NULL,
  fizyka TINYINT(3) UNSIGNED DEFAULT NULL,
  jezykobcy TINYINT(3) UNSIGNED DEFAULT NULL,
  plec ENUM('k','m') DEFAULT NULL,
  PRIMARY KEY (idosoby)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- Tabela Zgloszenia
CREATE TABLE zgloszenia (
  idzgloszenia INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  kierunek VARCHAR(20) DEFAULT NULL,
  idosoby CHAR(4) NOT NULL,
  PRIMARY KEY (idzgloszenia),
  FOREIGN KEY (idosoby) REFERENCES kandydaci(idosoby)
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

```

## 3. Zestawienie Zadań Rekrutacyjnych z Analizą Poprawności

Poniżej znajduje się omówienie zadań rekrutacyjnych. Zwróć uwagę na zestawienie: **Błędne zapytanie** (częsty błąd syntaktyczny pojawiający się w materiałach roboczych) vs **Poprawne zapytanie SQL**.

PDF+ 2

### Zadanie A: Sumowanie pól i filtrowanie

> Wypisz osoby, które uzyskały 400 punktów rekrutacyjnych (suma z 4 przedmiotów). Wynik przedstaw w postaci listy zawierającej imiona i nazwiska, uporządkowanej alfabetycznie według nazwisk.
>
> PDF+ 1

❌ **Błędne zapytanie (Brak operatorów dodawania):**

SQL

```sql id="f4n7pz"
SELECT imie, nazwisko FROM kandydaci WHERE matematyka informatyka fizyka jezykobcy = 400 ORDER BY nazwisko;

```

Główny błąd: Baza danych traktuje spacje między kolumnami jako błąd składniowy. Baza musi dostatnio wiedzieć, że ma te wartości zsumować.

PDF

✅ **Poprawne zapytanie SQL:**

```sql id="k5r8mx"
SELECT imie, nazwisko
FROM kandydaci
WHERE (matematyka + informatyka + fizyka + jezykobcy) = 400
ORDER BY nazwisko ASC;

```

### Zadanie B: Zliczanie i grupowanie (`GROUP BY` + `COUNT`)

> Utwórz zestawienie, w którym podasz, ile jest zgłoszeń na poszczególne kierunki studiów. Rezultat posortuj malejąco względem liczby zgłoszeń.
>
> PDF+ 1

❌ **Częsty błąd:**

```sql id="n3w6qt"
SELECT kierunek, COUNT(*) AS liczba_zgloszen FROM zgłoszenia GROUP BY kierunek ORDER BY liczba_zgłoszeń DESC;

```

Główny błąd: Użycie polskiej litery `ł` w nazwie aliasu sortowania (`liczba_zgłoszen` vs `liczba_zgloszen`). Staraj się używać wyłącznie angielskich znaków w nazwach kolumn i aliasów.

PDF

✅ **Poprawne zapytanie SQL:**

```sql id="v7m2kc"
SELECT kierunek, COUNT(*) AS liczba_zgloszen
FROM zgloszenia
GROUP BY kierunek
ORDER BY liczba_zgloszen DESC;

```

### Zadanie C: Funkcje agregujące i zaokrąglanie (`AVG` + `ROUND`)

> Podaj średnią liczbę punktów z matematyki oraz z informatyki uzyskanych przez wszystkich kandydatów. Wynik zaokrąglij do dwóch miejsc po przecinku.
>
> PDF+ 1

❌ **Błędne zapytanie (Błędne nawiasowanie):**

```sql id="s9x4nr"
SELECT ROUND (AVG matematyka , 2) AS srednia_matematyka, ROUND AVG(informatyka), 2) AS srednia_informatyka FROM kandydaci;

```

Główny błąd: Brak nawiasów wokół argumentów funkcji `AVG`. Prawidłowa struktura to: `ROUND(AVG(kolumna), miejsca_po_przecinku)`.

PDF

✅ **Poprawne zapytanie SQL:**

```sql id="p6k3vw"
SELECT
    ROUND(AVG(matematyka), 2) AS srednia_matematyka,
    ROUND(AVG(informatyka), 2) AS srednia_informatyka
FROM kandydaci;

```

### Zadanie D: Minimum i Maksimum z warunkiem (`MIN`, `MAX`, `WHERE`)

> Wypisz najmniejszą i największą liczbę punktów z języka obcego uzyskanych przez kandydatki.
>
> PDF+ 1

❌ **Błędne zapytanie:**

```sql id="q8m5tz"
SELECT MIN(jezykobcy AS najmniej_punktow, MAX jezykobcy) AS najwiecej punktow FROM kandydaci WHERE plec = 'k';

```

Główny błąd: Domknięcie aliasu `AS` wewnątrz nawiasu `MIN(...)` oraz spacja w nazwie aliasu `najwiecej punktow` bez użycia grawisów lub cudzysłowu.

PDF

✅ **Poprawne zapytanie SQL:**

```sql id="x2v7pk"
SELECT
    MIN(jezykobcy) AS najmniej_punktow,
    MAX(jezykobcy) AS najwiecej_punktow
FROM kandydaci
WHERE plec = 'k';

```

### Zadanie E: Grupowanie według płci

> Podaj ile jest wśród kandydatów kobiet a ilu mężczyzn (wykorzystaj grupowanie i zliczanie).
>
> PDF+ 1

✅ **Poprawne zapytanie SQL:**

```sql id="m4q9xs"
SELECT plec, COUNT(*) AS liczba_osob
FROM kandydaci
GROUP BY plec;

```

### Zadanie F: Sumowanie zagregowane (`SUM`)

> Policz łączną sumę punktów z matematyki uzyskanych przez kandydatki oraz przez kandydatów zależnie od płci.
>
> PDF+ 1

✅ **Poprawne zapytanie SQL:**

```sql id="t6w3kn"
SELECT plec, SUM(matematyka) AS suma_matematyka
FROM kandydaci
GROUP BY plec;

```

### Zadanie G: Porównywanie dwóch kolumn w jednym wierszu

> Wypisz tych kandydatów, którzy uzyskali większą liczbę punktów z matematyki niż z języka obcego.
>
> PDF+ 1

❌ **Błędne zapytanie:**

```sql id="r5n8jy"
SELECT imie, nazwisko, matematyka, jezykobcy FROM kandydaci WHERE matematyka jezykobcy ORDER BY nazwisko, imie;

```

Główny błąd: Brak operatora porównania `>` w sekcji `WHERE`.

PDF

✅ **Poprawne zapytanie SQL:**

```sql id="z3k6mp"
SELECT imie, nazwisko, matematyka, jezykobcy
FROM kandydaci
WHERE matematyka > jezykobcy
ORDER BY nazwisko ASC, imie ASC;

```

### Zadanie H: Wiele agregacji w jednym zapytaniu

> Podaj średnią, minimalną i maksymalną liczbę punktów uzyskanych z matematyki oraz języka obcego uzyskaną przez kandydatów zależnie od płci.
>
> PDF+ 1

❌ **Błędne zapytanie:**

```sql id="y7q2vx"
SELECT plec, ROUND AVG (matematyka), 2), MIN(matematyka), MAX (matematyka), ROUND (AVG jezykobcy), 2), MIN (jezykobcy), MAX (jezykobcy) FROM kandydaci GROUP BY plec;

```

✅ **Poprawne zapytanie SQL:**

```sql id="b9m4rk"
SELECT
    plec,
    ROUND(AVG(matematyka), 2) AS srednia_mat,
    MIN(matematyka) AS min_mat,
    MAX(matematyka) AS max_mat,
    ROUND(AVG(jezykobcy), 2) AS srednia_jez,
    MIN(jezykobcy) AS min_jez,
    MAX(jezykobcy) AS max_jez
FROM kandydaci
GROUP BY plec;

```

### Zadanie I: Dopasowywanie wzorców tekstowych (`LIKE`)

> Podaj liczbę kandydatów (obojga płci), których nazwisko rozpoczyna się na literkę 'K'.
>
> PDF+ 1

✅ **Poprawne zapytanie SQL:**

```sql id="w6p3nz"
SELECT COUNT(*) AS liczba_kandydatow
FROM kandydaci
WHERE nazwisko LIKE 'K%';

```

- **`LIKE 'K%'`**: Znak `%` działa jak wielokarta (wildcard) — oznacza "dowolny ciąg znaków o dowolnej długości". Zapytanie znajdzie zarówno "Kowalski", "Krol", jak i "K".

  PDF

## 4. Ściągawka Zapamiętywawcza dla Bazy `Kandydaci`

| OperacjaKod / SkładniaDo czego służy? |                        |     |
| ------------------------------------- | ---------------------- | --- |
| **Sumowanie kolumn wiersza**          | `(col1 + col2 + col3)` |     |

Obliczanie łącznego wyniku jednego kandydata.

PDF+ 1

svg

[image](https://drive-thirdparty.googleusercontent.com/32/type/application/pdf)

PDF

roz.pdf

[image](https://drive-thirdparty.googleusercontent.com/32/type/application/pdf)

PDF

Treść.pdf

| **Zliczanie wierszy** | `COUNT(*)` |     |
| --------------------- | ---------- | --- |

Policzenie liczby zgłoszeń lub kandydatów.

PDF

| **Wartość średnia** | `AVG(kolumna)` |     |
| ------------------- | -------------- | --- |

Wyznaczenie średniego wyniku z egzaminu.

PDF

| **Zaokrąglanie** | `ROUND(wartość, 2)` |     |
| ---------------- | ------------------- | --- |

Obcięcie wyniku do 2 miejsc po przecinku.

PDF

| **Szukanie tekstu** | `WHERE kolumna LIKE 'A%'` |     |
| ------------------- | ------------------------- | --- |

Filtrowanie tekstów zaczynających się na literę A.

PDF

| **Grupowanie** | `GROUP BY pole` |     |
| -------------- | --------------- | --- |

Podział danych na podgrupy (np. wg płci, wg kierunku).

PDF
