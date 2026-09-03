# 🎓 Od Amatora do Mastera SQL: Projekt Uczelnia

W tym przewodniku przejdziemy przez pełen proces tworzenia bazy danych od zera: utworzymy bazę, zdefiniujemy tabele z ograniczeniami, zaimportujemy dane z pliku tekstowego, powiążemy tabele relacją oraz wykonamy profesjonalne zapytania analityczne i modyfikujące.

## 🏗️ KROK 1: Tworzenie Bazy i Podstawowych Tabel (DDL)

Struktury baz danych tworzymy za pomocą języka **DDL** (_Data Definition Language_).

### 1. Utworzenie Bazy Danych

Zaczynamy od stworzenia "pojemnika" na nasze tabele:

SQL

```sql id="k4m8p2"
CREATE DATABASE UCZELNIA;
```

### 2. Tworzenie Tabeli `OCENY` – Typy Danych i Ograniczenia

Musimy stworzyć tabelę do przechowywania ocen studentów.

SQL

```sql id="r7n3q5"
CREATE TABLE OCENY (
    Student VARCHAR(100),
    Wynik TINYINT UNSIGNED CHECK (Wynik <= 100),
    Id_grupy CHAR(1)
);
```

#### 💡 Wyjaśnienie typów i ograniczeń dla Amatora:

- **`VARCHAR(100)`**: Zmiennodługościowy ciąg znaków (tekst) o maksymalnej długości 100 znaków. Idealny do przechowywania imion i nazwisk.
- **`TINYINT UNSIGNED`**:
  - `TINYINT` to bardzo mała liczba całkowita (zajmuje tylko 1 bajt pamięci).
  - `UNSIGNED` oznacza "bez znaku" (tylko wartości dodatnie i zero). Zamiast zakresu od -128 do 127, zyskujemy zakres **od 0 do 255**.

- **`CHECK (Wynik <= 100)`**: Warunek kontrolny (_constraint_). Baza danych odrzuci próbę wpisania wyniku większego niż 100 (np. 105).
- **`CHAR(1)`**: Stałodługościowe pole tekstowe dokładnie na 1 znak. Różni się od `VARCHAR` tym, że baza zawsze rezerwuje pamięć na dokładnie 1 znak (np. 'A', 'B', 'C').

## 🛠️ KROK 2: Modyfikacja Tabeli za pomocą `ALTER TABLE`

Często po utworzeniu tabeli musimy zmienić jej reguły lub dodać klucze. Do tego służy komenda `ALTER TABLE`.

SQL

```sql id="t6v2m9"
-- Dodanie klucza głównego (Primary Key)
ALTER TABLE OCENY ADD PRIMARY KEY (Student);

-- Modyfikacja kolumny: ustawienie pola jako obowiązkowego (NOT NULL)
ALTER TABLE OCENY MODIFY Wynik TINYINT UNSIGNED NOT NULL CHECK (Wynik <= 100);
```

#### 🧠 Co to oznacza?

1. **`PRIMARY KEY (Student)`**: Unikalny identyfikator wiersza. Oznacza to, że nazwy studentów nie mogą się powtarzać, ani być puste (`NULL`).
2. **`NOT NULL`**: Pole `Wynik` staje się **obowiązkowe** – przy dodawaniu studenta baza nie pozwoli zostawić tego pola pustego.

## 📐 KROK 3: Tworzenie Tabeli Słownikowej `GRUPY` z Wartościami Domyślnymi

Tworzymy drugą tabelę, w której będziemy przechowywać listę grup oraz liczbę przypisanych studentów:

SQL

```sql id="p1x5c8"
CREATE TABLE GRUPY (
    ID_grupy CHAR(1),
    liczba_studentow TINYINT UNSIGNED DEFAULT NULL,
    PRIMARY KEY (ID_grupy)
);
```

#### 💡 Kluczowe pojęcie: `DEFAULT NULL`

- **`DEFAULT NULL`**: Jeśli podczas dodawania nowej grupy nie podamy liczby studentów, baza danych automatycznie wpisze tam wartość `NULL` (czyli "brak danych / jeszcze nie obliczono").

## 📥 KROK 4: Zasilanie Bazy Danymi (DML & Import)

Dane do bazy wprowadzamy za pomocą masowego importu lub zapytań **DML** (_Data Manipulation Language_).

### 1. Masowy Import z pliku tekstowego (`LOAD DATA INFILE`)

Zamiast ręcznie wpisywać 250 wierszy, importujemy je bezpośrednio z pliku `oceny.txt`:

SQL

```sql id="y9q4n7"
LOAD DATA INFILE 'oceny.txt'
INTO TABLE OCENY
FIELDS TERMINATED BY '\t'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
```

- **`FIELDS TERMINATED BY '\t'`**: Informuje bazę, że kolumny w pliku są rozdzielone tabulatorem (`\t`).
- **`LINES TERMINATED BY '\n'`**: Każdy nowy wiersz w pliku kończy się znakiem nowej linii (`\n`).
- **`IGNORE 1 LINES`**: Pomija pierwszy wiersz pliku (nagłówek: _Student, Wynik, Id_grupy_).

### 2. Ręczne wstawianie wierszy (`INSERT INTO`)

Wstawiamy do tabeli `GRUPY` litery oznaczające grupy od A do I:

SQL

```sql id="m3k7z1"
INSERT INTO GRUPY (ID_grupy)
VALUES ('A'), ('B'), ('C'), ('D'), ('E'), ('F'), ('G'), ('H'), ('I');
```

- Zauważ, że podajemy tylko `ID_grupy`. Kolumna `liczba_studentow` automatycznie przyjmie wartość `NULL` zgodnie z naszym ustawieniem `DEFAULT NULL`!

## 🔗 KROK 5: Relacje i Klucze Obce (`FOREIGN KEY`)

Aby baza danych pilnowała spójności (żeby student nie mógł zostać przypisany do grupy, która nie istnieje w tabeli `GRUPY`), łączymy obie tabele **kluczem obcym**:

SQL

```sql id="v8r2q6"
ALTER TABLE OCENY
ADD CONSTRAINT FK_1
FOREIGN KEY (Id_grupy) REFERENCES GRUPY (ID_grupy);
```

#### 🧩 Wyjaśnienie mechanizmu:

- **`CONSTRAINT FK_1`**: Nadaje własną nazwę ograniczeniu (`FK_1`), co ułatwia zarządzanie nim w przyszłości.
- **`FOREIGN KEY (Id_grupy)`**: Pole `Id_grupy` z tabeli `OCENY` staje się "wskaźnikiem".
- **`REFERENCES GRUPY (ID_grupy)`**: Wskazuje na rodzica – pole `ID_grupy` w tabeli `GRUPY`. Od teraz baza danych zablokuje próbę przypisania studentowi grupy, której nie ma w tabeli `GRUPY`.

## 📊 KROK 6: Zaawansowana Analiza Danych (Zapytania SQL)

Prchodzimy do języka **DQL** (_Data Query Language_) – czyli wyciągania i analizowania informacji.

### a) Najczęstszy wynik (Moda / Dominanta)

**Pytanie:** Podaj liczbę punktów, którą studenci uzyskiwali najczęściej, oraz liczbę jej wystąpień.

SQL

```sql id="c5w9p3"
SELECT Wynik, COUNT(*) AS Liczba_Wystapien
FROM OCENY
GROUP BY Wynik
ORDER BY Liczba_Wystapien DESC
LIMIT 1;
```

- **`COUNT(*)`**: Zlicza liczbę wierszy w poszczególnych grupach.
- **`ORDER BY ... DESC`**: Sortuje od wyniku występującego najczęściej do najrzadszego.
- **`LIMIT 1`**: Wyciąga tylko sam szczyt podium (jeden rekord).

### b) Liczebność studentów w grupach

**Pytanie:** Utwórz zestawienie liczebności każdej z grup.

SQL

```sql id="n2f6x8"
SELECT Id_grupy, COUNT(*) AS Liczba_Studentow
FROM OCENY
GROUP BY Id_grupy
ORDER BY Id_grupy ASC;
```

### c) Aktualizacja danych na podstawie zliczania (`UPDATE` + `JOIN`)

**Pytanie:** Zaktualizuj tabelę `GRUPY` wartościami przeliczonymi z tabeli `OCENY`.

SQL

```sql id="q7m4r1"
UPDATE GRUPY G
JOIN (
    SELECT Id_grupy, COUNT(*) AS policzeni
    FROM OCENY
    GROUP BY Id_grupy
) O ON G.ID_grupy = O.Id_grupy
SET G.liczba_studentow = O.policzeni;
```

#### 🧠 Jak to działa krok po kroku?

1. W nawiasie tworzymy tymczasową podtabelę `O`, która zlicza studentów dla każdej grupy.
2. Łączymy (`JOIN`) naszą główną tabelę `GRUPY G` z tą tymczasową podtabelą `O` po identyfikatorach grup.
3. Instrukcją `SET` przepisujemy obliczone wartości do kolumny `liczba_studentow`.

### d) Statystyki grupowe: Średnia i Minimum

**Pytanie:** Podaj średnią (zaokrągloną do 2 miejsc) oraz najmniejszą liczbę punktów w każdej z grup.

SQL

```sql id="h8v3k5"
SELECT
    Id_grupy,
    ROUND(AVG(Wynik), 2) AS Srednia_Wynik,
    MIN(Wynik) AS Najmniejszy_Wynik
FROM OCENY
GROUP BY Id_grupy
ORDER BY Id_grupy ASC;
```

- **`ROUND(AVG(Wynik), 2)`**: `AVG` wylicza średnią, a `ROUND(..., 2)` zaokrągla ją do dwóch miejsc po przecinku.

### e) Łączenie wyników filtrowanych za pomocą `UNION ALL`

**Pytanie:** Wypisz liczbę studentów, którzy otrzymali ocenę 6 (90-100 pkt) oraz ocenę 5 (80-89 pkt).

SQL

```sql id="s1p6y4"
SELECT 'Ocena 6' AS Ocena, COUNT(*) AS Liczba_Studentow
FROM OCENY
WHERE Wynik BETWEEN 90 AND 100

UNION ALL

SELECT 'Ocena 5' AS Ocena, COUNT(*)
FROM OCENY
WHERE Wynik BETWEEN 80 AND 89;
```

- **`BETWEEN X AND Y`**: Filtruje zakłady włącznie z wartościami skrajnymi (np. od 90 do 100).
- **`UNION ALL`**: Skleja wyniki dwóch niezależnych zapytań w jedną czytelną tabelę.

### f) Filtrowanie złożone (`IN`) i ograniczenie wyników (`LIMIT`)

**Pytanie:** Wypisz maksymalnie 10 studentów z grup C oraz D, którzy otrzymali ocenę celującą (90-100 pkt), posortowanych malejąco po nazwie.

SQL

```sql id="z4n8c2"
SELECT Student, Wynik, Id_grupy
FROM OCENY
WHERE Id_grupy IN ('C', 'D')
  AND Wynik BETWEEN 90 AND 100
ORDER BY Student DESC
LIMIT 10;
```

- **`Id_grupy IN ('C', 'D')`**: Znacznie elegantszy odpowiednik warunku `(Id_grupy = 'C' OR Id_grupy = 'D')`.

### g) Liczenie wartości unikalnych (`COUNT(DISTINCT)`)

**Pytanie:** Policz ile **różnych** grup reprezentują studenci.

SQL

```sql id="j5q9m3"
SELECT COUNT(DISTINCT Id_grupy) AS Liczba_Roznych_Grup
FROM OCENY;
```

- **`DISTINCT`**: Eliminacja powtórek. Zamiast liczyć 250 wierszy, baza policzy tylko unikalne nazwy grup.

### h) Filtrowanie po agregacji (`HAVING`) – Najważniejsza pułapka SQL!

**Pytanie:** Wypisz grupy reprezentowane przez co najmniej 25 studentów.

SQL

```sql id="x2v7k4"
SELECT Id_grupy, COUNT(*) AS Liczba_Studentow
FROM OCENY
GROUP BY Id_grupy
HAVING COUNT(*) >= 25
ORDER BY Liczba_Studentow DESC;
```

#### ⚠️ Pamiętaj! Jaka jest różnica między `WHERE` a `HAVING`?

- **`WHERE`**: Filtruje wiersze **PRZED** ich zgrupowaniem (np. wyklucza konkretnych studentów).
- **`HAVING`**: Filtruje wyniki **PO** zgrupowaniu (używamy go, gdy chcemy postawić warunek na funkcji agregującej, np. `COUNT(*) >= 25`).

### i) Usuwanie danych (`DELETE`)

**Pytanie:** Usuń z tabeli `GRUPY` wiersze dotyczące grup H oraz I.

SQL

```sql id="b6r1t9"
DELETE FROM GRUPY
WHERE ID_grupy IN ('H', 'I');
```

### j) Analiza ocen niedostatecznych

**Pytanie:** Podaj liczbę studentów z każdej grupy, którzy nie zdali egzaminu (uzyskali 0-40 pkt).

SQL

```sql id="w3m8p5"
SELECT Id_grupy, COUNT(*) AS Liczba_Niedostatecznych
FROM OCENY
WHERE Wynik BETWEEN 0 AND 40
GROUP BY Id_grupy
ORDER BY Id_grupy ASC;
```

## 💡 Podsumowanie Dobrego Projektanta Baz Danych

1. **Zawsze określaj precyzyjne typy:** Używaj `TINYINT` zamiast domyślnego `INT` dla małych liczb – oszczędzasz pamięć operacyjną i dyskową.
2. **Dbaj o spójność danych:** Używaj kluczy obcych (`FOREIGN KEY`) oraz ograniczeń (`CHECK`), aby baza sama broniła się przed błędnymi danymi (np. wynikiem 150 pkt).
3. **Pamiętaj o kolejności wykonywania SQL:** `WHERE` (przed grupą) $\rightarrow$ `GROUP BY` $\rightarrow$ `HAVING` (po grupie) $\rightarrow$ `ORDER BY` $\rightarrow$ `LIMIT`.
