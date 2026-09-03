# 🚀 Kompletny Przewodnik po SQL: Od Podstaw do Dobrych Praktyk Projektowych

Cześć! W tym opracowaniu nauczysz się, jak projektować bazy danych, tworzyć tabele, przeliczać statystyki oraz jak optymalizować strukturę danych. Przejdziemy krok po kroku przez podstawy tworzenia struktury (DDL), manipulacji danymi (DML) oraz zaawansowanych zapytań (DQL).

## 1. Tworzenie Bazy i Tabeli – Co oznaczają poszczególne typy?

Zanim cokolwiek przeanalizujemy, musimy zbudować "pojemnik" na nasze dane. W języku SQL służą do tego komendy z grupy **DDL (Data Definition Language)**.

### Tworzenie bazy danych

SQL

```sql id="n1f8q2"
CREATE DATABASE M2013PPZ6;
```

> **Wyjaśnienie:** Polecenie `CREATE DATABASE` tworzy nową, pustą przestrzeń w systemie zarządzania bazą danych (np. MySQL/MariaDB), w której będziemy przechowywać nasze tabele.

### Tworzenie pierwszej struktury tabeli (`FUNDUSZE`)

Plik z danymi zawiera datę oraz ceny 12 funduszy inwestycyjnych. Tworzymy tabelę w tzw. **podejściu horyzontalnym (szerokim)** – każdy fundusz ma własną kolumnę:

PDF+ 1

SQL

```sql id="p4k7m3"
CREATE TABLE FUNDUSZE (
    DATA DATE,
    F1 DECIMAL(4,2),
    F2 DECIMAL(4,2),
    F3 DECIMAL(4,2),
    F4 DECIMAL(4,2),
    F5 DECIMAL(4,2),
    F6 DECIMAL(4,2),
    F7 DECIMAL(4,2),
    F8 DECIMAL(4,2),
    F9 DECIMAL(4,2),
    F10 DECIMAL(4,2),
    F11 DECIMAL(4,2),
    F12 DECIMAL(4,2)
);
```

#### 💡 Wyjaśnienie typów danych (Poziom Amator):

1. **`DATE`**: Przechowuje datę w standardowym formacie `YYYY-MM-DD` (np. `2008-01-02`).

   PDF+ 1

2. **`DECIMAL(4,2)`**: Typ stałopozycyjny służący do precyzyjnego zapisywania liczb zmiennoprzecinkowych (np. pieniędzy).

   PDF+ 1
   - Pierwsza cyfra **`4`** to tzw. _precyzja_ (ang. _precision_) – całkowita maksymalna liczba cyfr (przed i po przecinku razem).

     PDF+ 1

   - Druga cyfra **`2`** to tzw. _skala_ (ang. _scale_) – ile z tych cyfr znajduje się **po** przecinku.

     PDF+ 1

   - _Przykład:_ `DECIMAL(4,2)` zmieści wartości od `-99.99` do `99.99` (np. `50.90`).

     TXT

## 2. Podstawy Analizy Czasowej i Aggregacji (Akapit Praktyczny)

W SQL bardzo często musimy liczyć średnie, wartości maksymalne/minimalne czy zliczać wiersze. Do tego służą **funkcje agregujące**: `AVG()`, `SUM()`, `MIN()`, `MAX()`, `COUNT()`.

### a) Średnie wartości z podanego zakresu dat

**Zadanie:** Oblicz średnią cenę dla każdego funduszu z pierwszej połowy 2008 roku (od 1 stycznia do 30 czerwca) i zaokrąglij do 2 miejsc po przecinku.

PDF+ 1

SQL

```sql id="v6t2r9"
SELECT
    ROUND(AVG(F1), 2) AS Srednia_F1,
    ROUND(AVG(F2), 2) AS Srednia_F2,
    ROUND(AVG(F3), 2) AS Srednia_F3,
    ROUND(AVG(F4), 2) AS Srednia_F4,
    ROUND(AVG(F5), 2) AS Srednia_F5,
    ROUND(AVG(F6), 2) AS Srednia_F6,
    ROUND(AVG(F7), 2) AS Srednia_F7,
    ROUND(AVG(F8), 2) AS Srednia_F8,
    ROUND(AVG(F9), 2) AS Srednia_F9,
    ROUND(AVG(F10), 2) AS Srednia_F10,
    ROUND(AVG(F11), 2) AS Srednia_F11,
    ROUND(AVG(F12), 2) AS Srednia_F12
FROM FUNDUSZE
WHERE DATA BETWEEN '2008-01-01' AND '2008-06-30';
```

#### 🧠 Jak to działa?

- **`AVG(kolumna)`**: Sumuje wartości w podanej kolumnie i dzieli przez ich liczbę.

- **`ROUND(wartość, 2)`**: Zaokrągla wynik do wskazanego miejsca po przecinku (w tym przypadku 2).

  PDF+ 1

- **`WHERE DATA BETWEEN '2008-01-01' AND '2008-06-30'`**: Filtruje wiersze. Warunek `BETWEEN` obejmuje zarówno datę początkową, jak i końcową (jest równoważny `DATA >= '2008-01-01' AND DATA <= '2008-06-30'`).

- ⚠️ **Uwaga dla amatora:** Pamiętaj, aby wartości tekstowe i daty zawsze ujmować w apostrofy `'...'`!

### b) Filtrowanie wielowarunkowe (`AND`)

**Zadanie:** Policz, w ilu dniach ceny **wszystkich** 12 funduszy były wyższe niż 33 zł.

PDF+ 1

SQL

```sql id="c8x5w1"
SELECT COUNT(*) AS Liczba_dni
FROM FUNDUSZE
WHERE F1 > 33 AND F2 > 33 AND F3 > 33 AND F4 > 33
  AND F5 > 33 AND F6 > 33 AND F7 > 33 AND F8 > 33
  AND F9 > 33 AND F10 > 33 AND F11 > 33 AND F12 > 33;
```

- **`COUNT(*)`**: Zlicza liczbę wierszy spełniających warunki logiczne wymienione w klauzuli `WHERE`.
- Operatory **`AND`** wymuszają, że **każdy** z warunków musi być prawdziwy równocześnie.

### c) Najczęstsza wartość (Moda/Dominanta)

**Zadanie:** Zdecyduj, która cena dla funduszu `F1` pojawiała się najczęściej i ile razy.

PDF+ 1

SQL

```sql id="j3m9q7"
SELECT F1, COUNT(*) AS Liczba_wystapien
FROM FUNDUSZE
GROUP BY F1
ORDER BY Liczba_wystapien DESC, F1 ASC
LIMIT 1;
```

#### 🧠 Co tu się dzieje krok po kroku?

1. **`GROUP BY F1`**: Dzieli dane na "woreczki", gdzie w każdym woreczku są wiersze o tej samej cenie `F1`.
2. **`COUNT(*)`**: Zlicza, ile elementów trafia do każdego woreczka.
3. **`ORDER BY Liczba_wystapien DESC`**: Sortuje wyniki od największej liczby wystąpień do najmniejszej (`DESC` = malejąco).
4. **`F1 ASC`**: Jeśli dwa wyniki mają tę samą liczbę wystąpień, wybiera mniejszą wycenę (`ASC` = rosnąco).
5. **`LIMIT 1`**: Wyciąga tylko pierwszy (najwyższy) rekord ze posortowanej listy.

### d) Minima i Maksima dla wielu kolumn jednocześnie

SQL

```sql id="r5u1k8"
SELECT
    MIN(F1), MAX(F1), MIN(F2), MAX(F2),
    MIN(F3), MAX(F3), MIN(F4), MAX(F4),
    MIN(F5), MAX(F5), MIN(F6), MAX(F6),
    MIN(F7), MAX(F7), MIN(F8), MAX(F8),
    MIN(F9), MAX(F9), MIN(F10), MAX(F10),
    MIN(F11), MAX(F11), MIN(F12), MAX(F12)
FROM FUNDUSZE;
```

- `MIN()` zwraca najniższą, a `MAX()` najwyższą wartość odnotowaną w danej kolumnie.

  PDF+ 1

### e) Agregacja według miesięcy (Grupowanie danych)

**Zadanie:** Dla funduszu `F12` wyznacz średnią cenę dla każdego miesiąca w roku.

PDF+ 1

SQL

```sql id="b7n4s2"
SELECT
    YEAR(DATA) AS Rok,
    MONTH(DATA) AS Miesiac,
    ROUND(AVG(F12), 2) AS Srednia
FROM FUNDUSZE
GROUP BY YEAR(DATA), MONTH(DATA)
ORDER BY Rok, Miesiac;
```

- Funkcje **`YEAR(DATA)`** i **`MONTH(DATA)`** wyciągają sam rok i sam miesiąc z pola typu `DATE`.
- Klauzula **`GROUP BY YEAR(DATA), MONTH(DATA)`** instruuje bazę danych: _"Oblicz funkcję_ _`AVG()`_ _oddzielnie dla każdego unikalnego miesiąca"_.

  PDF

### f) Porównywanie kolumn w tym samym wierszu

**Zadanie:** Policz dni, w których fundusz `F4` był wyceniany wyżej niż `F6`.

PDF+ 1

SQL

```sql id="q2e6m9"
SELECT COUNT(*) AS Liczba_dni
FROM FUNDUSZE
WHERE F4 > F6;
```

- W SQL możesz prostym warunkiem porównywać ze sobą dwie kolumny z tego samego wiersza!

### g) Wartości unikalne (`DISTINCT`)

**Zadanie:** Ile było **różnych** wycen funduszu `F3` w marcu 2008 roku?

PDF+ 1

SQL

```sql id="w8k3p5"
SELECT COUNT(DISTINCT F3) AS Rozne_wyceny
FROM FUNDUSZE
WHERE DATA BETWEEN '2008-03-01' AND '2008-03-31';
```

- Słowo kluczowe **`DISTINCT`** eliminuje powtórki. Jeśli w marcu cena `40.00` wystąpiła 5 razy, `COUNT(DISTINCT F3)` policzy ją tylko raz.

  PDF

### h) Operacje logiczne i ograniczenia czasowe

SQL

```sql id="f4z7n1"
SELECT COUNT(*) AS Liczba_dni
FROM FUNDUSZE
WHERE DATA BETWEEN '2008-04-05' AND '2008-05-07'
  AND F10 <= F11;
```

### i) Wyrażenia arytmetyczne i sortowanie po sumie

**Zadanie:** Wskazanie dnia z najwyższą sumaryczną wartością pierwszych trzech funduszy (`F1 + F2 + F3`).

PDF+ 1

SQL

```sql id="k9d2h6"
SELECT
    DATA,
    (F1 + F2 + F3) AS Suma
FROM FUNDUSZE
ORDER BY Suma DESC, DATA ASC
LIMIT 1;
```

- SQL pozwala wykonywać działania matematyczne bezpośrednio w zapytaniu!

  PDF

- `ORDER BY Suma DESC, DATA ASC`: Jeśli dwa dni mają identyczną najwyższą sumę, wygrywa ten z wcześniejszą datą (`DATA ASC`).

  PDF+ 1

### j) Łączenie warunków – Sumowanie warunkowe

SQL

```sql id="m6x1v8"
SELECT SUM(F12) AS Suma_F12
FROM FUNDUSZE
WHERE DATA BETWEEN '2008-07-10' AND '2008-07-25'
  AND F12 >= 39;
```

- **`SUM()`** zlicza łączną wartość, a warunki po `WHERE` wykluczają dni, w których cena spadła poniżej 39 zł.

  PDF+ 1

## 3. Przełom w Projektowaniu Baz: Tabela Płaska vs Tabela Relacyjna (`UNION ALL`)

Spójrzmy na punkty **k**, **l** oraz **m** z przesłanego pliku. To jest najważniejsza lekcja architektoniczna!

PDF+ 1

### Tworzenie nowej, lepszej tabeli (`FUNDUSZE_2`)

Zamiast 12 kolumn dla każdego funduszu z osobna, twórzmy tabelę **pionową (długą)**:

PDF+ 1

SQL

```sql id="t3r8y4"
CREATE TABLE FUNDUSZE_2 (
    DATA DATE,
    WARTOSC_JEDNOSTKI DECIMAL(6,2),
    FUNDUSZ INT
);
```

### Przepisywanie danych z tabeli do tabeli przy użyciu `UNION ALL`

Przekształcamy (unpivotujemy) dane z tabeli `FUNDUSZE` do tabeli `FUNDUSZE_2` za pomocą operatora `UNION ALL`:

PDF

SQL

```sql id="p7m2c9"
INSERT INTO FUNDUSZE_2 (DATA, WARTOSC_JEDNOSTKI, FUNDUSZ)
SELECT DATA, F1, 1 FROM FUNDUSZE
UNION ALL SELECT DATA, F2, 2 FROM FUNDUSZE
UNION ALL SELECT DATA, F3, 3 FROM FUNDUSZE
UNION ALL SELECT DATA, F4, 4 FROM FUNDUSZE
UNION ALL SELECT DATA, F5, 5 FROM FUNDUSZE
UNION ALL SELECT DATA, F6, 6 FROM FUNDUSZE
UNION ALL SELECT DATA, F7, 7 FROM FUNDUSZE
UNION ALL SELECT DATA, F8, 8 FROM FUNDUSZE
UNION ALL SELECT DATA, F9, 9 FROM FUNDUSZE
UNION ALL SELECT DATA, F10, 10 FROM FUNDUSZE
UNION ALL SELECT DATA, F11, 11 FROM FUNDUSZE
UNION ALL SELECT DATA, F12, 12 FROM FUNDUSZE;
```

#### 💡 Czym jest `UNION ALL`?

Operator **`UNION ALL`** bierze wyniki kilku osobnych zapytań `SELECT` i łączy je w jedną długa listę, doklejając dane jeden pod drugim.

### 🧠 Dlaczego nowa struktura (`FUNDUSZE_2`) jest znacznie lepsza?

W punkcie **m** pytanie brzmi: _"Czy zapytania przy takiej formie tabeli są łatwiejsze?"_ Odpowiedź brzmi: **Zdecydowanie TAK!**

PDF+ 1

Porównajmy te dwa projekty:

| CechaStara struktura (`FUNDUSZE`)Nowa struktura (`FUNDUSZE_2`) |                                         |                                            |
| -------------------------------------------------------------- | --------------------------------------- | ------------------------------------------ |
| **Podejście**                                                  | Szeroka tabela (Horyzontalna)           | Długa tabela (Wertykalna / Znormalizowana) |
| **Dodanie funduszu F13**                                       | Wymaga modyfikacji bazy (`ALTER TABLE`) | Wystarczy wstawić nowy wiersz z numerem 13 |
| **Obliczenie Min/Max dla funduszy**                            |                                         |                                            |

Trzeba ręcznie pisać `MIN(F1), MAX(F1), MIN(F2)...` (długie zapytania)

PDF

| Proste zapytanie: `GROUP BY FUNDUSZ` |     |
| ------------------------------------ | --- |
| **Elastyczność filtrowania**         |     |

Skomplikowane warunki dla 12 osobnych kolumn

PDF

|     |
| --- |

Dynamiczne i proste filtry `WHERE FUNDUSZ = X`

PDF

#### Przykład – Zadanie (d) w nowej tabeli `FUNDUSZE_2`:

Zamiast pisać gigantyczne zapytanie z 24 funkcjami (`MIN(F1), MAX(F1)...`), w nowej tabeli piszemy zaledwie **kilka linijek**:

PDF

SQL

```sql id="u5q1e7"
SELECT
    FUNDUSZ,
    MIN(WARTOSC_JEDNOSTKI) AS Najnizsza,
    MAX(WARTOSC_JEDNOSTKI) AS Najwyzsza
FROM FUNDUSZE_2
GROUP BY FUNDUSZ;
```

Baza danych sama pogrupuje dane według numeru funduszu i wyświetli minima oraz maksima dla wszystkich funduszy naraz!

## 🎯 Podsumowanie Słowniczka SQL dla Początkującego

1. **`CREATE TABLE`** **/** **`CREATE DATABASE`**: Narzędzia do budowania struktury danych.

   PDF+ 1

2. **`SELECT ... FROM`**: Wyciąganie i wyświetlanie danych.

3. **`WHERE`**: Filtrowanie danych na poziomie pojedynczych wierszy.

4. **`GROUP BY`**: Agregowanie (grupowanie) wierszy o tych samych cechach (np. według miesiąca lub ID funduszu).

   PDF

5. **`ORDER BY ... ASC/DESC`**: Sortowanie wyników rosnąco (`ASC`) lub malejąco (`DESC`).

   PDF

6. **`LIMIT N`**: Ograniczenie liczby zwracanych wierszy do N.

7. **`UNION ALL`**: Łączenie wyników wielu zapytań w jedną długą listę.
