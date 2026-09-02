# 🚀 Masterclass SQL: Złączenia Tabel (JOINs) i Agregacja Danych

Witaj w kolejnym module nauki SQL! Tym razem wchodzimy na wyższy poziom pracy z relacyjnymi bazami danych. Nauczysz się, jak sprawnie **łączyć dane z wielu tabel** (od podstawowych `INNER JOIN` po zaawansowane `FULL OUTER JOIN`) oraz jak filtrować zgrupowane wyniki.

## 📚 TEORIA: Przewodnik po Złączeniach Tabel (JOIN)

W relacyjnych bazach danych dane są podzielone na mniejsze, powiązane ze sobą tabele (np. klienci w jednej, zamówienia w drugiej). Aby stworzyć jeden spójny raport, musimy te tabele ze sobą **połączyć**.

Oto wizualny przegląd głównych typów złączeń:

```text
[ Tabela A ]  <--- Klucz łączący (np. ID) --->  [ Tabela B ]
```

### 1. `INNER JOIN` (Złączenie wewnętrzne)

Zwraca **tylko te wiersze**, które mają dopasowanie w **obu** tabelach. Jeśli klient nie złożył zamówienia, nie pojawi się w wyniku.

### 2. `LEFT (OUTER) JOIN` (Złączenie lewostronne)

Zwraca **wszystkie wiersze z lewej tabeli** oraz dopasowane wiersze z prawej. Jeśli po prawej stronie brak dopasowania, baza wstawi wartości `NULL`. Idealne do szukania np. "klientów bez zamówień".

### 3. `RIGHT (OUTER) JOIN` (Złączenie prawostronne)

Zwraca **wszystkie wiersze z prawej tabeli** oraz dopasowane z lewej. Używane, gdy priorytetem są dane z drugiej tabeli (np. wszystkie zamówienia, nawet te bez przypisanego klienta).

### 4. `FULL OUTER JOIN` (Złączenie pełne)

Zwraca **wszystkie wiersze z obu tabel**. Jeśli brak dopasowania w którejkolwiek ze stron, wstawiane są wartości `NULL`.

> ⚠️ **Uwaga (Silnik MySQL / MariaDB):** MySQL **nie obsługuje** składni `FULL OUTER JOIN` bezpośrednio! Aby uzyskać ten sam efekt, łączymy wynik `LEFT JOIN` oraz `RIGHT JOIN` za pomocą operatora `UNION`.

### 5. `CROSS JOIN` (Iloczyn kartezjański)

Łączy **każdy wiersz z pierwszej tabeli z każdym wierszem z drugiej**. Wynik to kombinacja $N \times M$ wierszy.

### 6. `NATURAL JOIN` (Złączenie naturalne)

Automatycznie łączy tabele po kolumnach, które **nazywają się dokładnie tak samo** w obu tabelach. Używaj ostrożnie, bo łatwo o pomyłkę przy zmianie nazewnictwa!

## 🏗️ KROK 1: Tworzenie i Przygotowanie Tabel

Poniższy kod tworzy strukturę bazy danych i uzupełnia ją danymi testowymi:

SQL

```sql
CREATE DATABASE IF NOT EXISTS SELECT_8;
USE SELECT_8;

-- Tabela z krajami
CREATE TABLE IF NOT EXISTS countries (
  Id INT(2) AUTO_INCREMENT PRIMARY KEY,
  CITY VARCHAR(50) NOT NULL,
  COUNTRY VARCHAR(50) NOT NULL
);

-- Tabela z klientami
CREATE TABLE IF NOT EXISTS persons (
  P_Id INT(11) PRIMARY KEY,
  LastName VARCHAR(30) NOT NULL,
  FirstName VARCHAR(20) NOT NULL,
  Address VARCHAR(50) NOT NULL,
  City VARCHAR(50) NOT NULL
);

-- Tabela z zamówieniami
CREATE TABLE IF NOT EXISTS orders (
  O_ID INT(11) PRIMARY KEY,
  OrderNo INT(10) UNSIGNED NOT NULL,
  P_Id INT(11) NULL
);
```

## 📊 KROK 2: Grupowanie i Filtrowanie (`GROUP BY` & `HAVING`)

### Zadanie B1: Liczba miast w krajach z warunkiem na grupę

**Pytanie:** Wypisz liczbę miast z każdego kraju, uwzględnij tylko kraje z co najmniej 3 miastami.

SQL

```sql
SELECT COUNTRY, COUNT(CITY) AS LiczbaMiast
FROM countries
GROUP BY COUNTRY
HAVING COUNT(CITY) >= 3;
```

- **Dlaczego** **`HAVING`** **a nie** **`WHERE`\*\***?\*\* Warunek dotyczy wartości zagregowanej (`COUNT(CITY)`). `WHERE` działa przed pogrupowaniem wierszy, a `HAVING` po.

### Zadanie B2: Wyszukiwanie tekstu ze wzorcem (`LIKE`)

**Pytanie:** Wypisz nazwisko i adres klientów o imionach kończących się na `'en'`.

SQL

```sql
SELECT LastName, Address
FROM persons
WHERE FirstName LIKE '%en';
```

- **`%en`**: Symbol `%` oznacza "dowolny ciąg znaków". Wpisanie `%en` dopasuje m.in. imiona _Sven_ czy _Ben_.

### Zadanie B3: Sortowanie wyników (`ORDER BY`)

**Pytanie:** Wypisz zamówienia sortując je po `P_Id` malejąco.

SQL

```sql
SELECT O_ID, OrderNo, P_Id
FROM orders
ORDER BY P_Id DESC;
```

### Zadanie B4: Zliczanie klientów w miastach

**Pytanie:** Wypisz liczbę klientów w zależności od miejscowości, w której mieszkają.

SQL

```sql
SELECT City, COUNT(P_Id) AS LiczbaKlientow
FROM persons
GROUP BY City;
```

## 🔗 KROK 3: Praktyka ze Złączeniami Tabel (JOIN)

### Zadanie C1: Pobieranie unikalnych nazwisk klientów na podstawie zamówień

**Pytanie:** Wypisz nazwiska klientów, którzy złożyli zamówienia o numerach większych niż 30000.

SQL

```sql
SELECT DISTINCT p.LastName
FROM persons p
INNER JOIN orders o ON p.P_Id = o.P_Id
WHERE o.OrderNo > 30000;
```

- **`DISTINCT`**: Zapobiega duplikatom – jeśli klient złożył 3 takie zamówienia, jego nazwisko pojawi się tylko raz.
- **Aliasy (\*\***`p`\***\*,** **`o`\*\***)\*\*: Krótkie nazwy zastępcze dla tabel, ułatwiające pisanie czytelnego kodu.

### Zadanie C2: Łączenie trzech tabel (Relacja pośrednia)

**Pytanie:** Wypisz liczbę klientów w zależności od kraju, w którym mieszkają.

SQL

```sql
SELECT c.COUNTRY, COUNT(p.P_Id) AS LiczbaKlientow
FROM persons p
INNER JOIN countries c ON p.City = c.CITY
GROUP BY c.COUNTRY;
```

- Tabela `persons` nie ma kolumny `COUNTRY`, więc łączymy ją z tabelą `countries` po wspólnym polu `City` / `CITY`.

### Zadanie C3: Iloczyn Kartezjański (`CROSS JOIN`)

**Pytanie:** Wyświetl iloczyn kartezjański tabel `orders` oraz `persons`.

SQL

```sql
SELECT *
FROM orders
CROSS JOIN persons;
```

### Zadanie C4: Podstawowe złączenie `INNER JOIN` ze sortowaniem

**Pytanie:** Wyświetl imiona i nazwiska klientów oraz numery ich zamówień, posortowane alfabetycznie według nazwisk.

SQL

```sql
SELECT p.FirstName, p.LastName, o.OrderNo
FROM persons p
INNER JOIN orders o ON p.P_Id = o.P_Id
ORDER BY p.LastName ASC;
```

### Zadanie C5: Szukanie "brakujących" powiązań (`LEFT JOIN` + `NULL`)

**Pytanie:** Wyświetl imię i nazwisko klientów, którzy **nie złożyli żadnego zamówienia**.

SQL

```sql
SELECT p.FirstName, p.LastName
FROM persons p
LEFT JOIN orders o ON p.P_Id = o.P_Id
WHERE o.O_ID IS NULL;
```

#### 🧠 Jak działa ten trik?

1. `LEFT JOIN` pobiera **wszystkich** klientów z tabeli `persons`.
2. Dla klientów, którzy nie mają zamówienia w `orders`, baza uzupełnia pola z tabeli `orders` wartością `NULL`.
3. Warunek `WHERE o.O_ID IS NULL` odrzuca klientów z zamówieniami i zostawia wyłącznie tych bez nich!

### Zadanie C6: Wszystkie dane z prawej tabeli (`RIGHT JOIN`)

**Pytanie:** Wypisz wszystkie zamówienia oraz ewentualne dane zamawiającego.

SQL

```sql
SELECT o.OrderNo, p.FirstName, p.LastName
FROM persons p
RIGHT JOIN orders o ON p.P_Id = o.P_Id
ORDER BY p.LastName ASC;
```

- Jeśli w bazie znajduje się zamówienie ze złym/nieistniejącym `P_Id`, i tak zostanie wyświetlone (z `NULL` w polach imienia/nazwiska).

### Zadanie C7: Pełne złączenie zewnętrze w MySQL (`FULL OUTER JOIN` via `UNION`)

**Pytanie:** Wyświetl wszystkie zamówienia oraz wszystkich klientów, łącząc pasujące rekordy.

SQL

```sql
(
    SELECT o.OrderNo, p.LastName, p.FirstName
    FROM persons p
    LEFT JOIN orders o ON p.P_Id = o.P_Id
)
UNION
(
    SELECT o.OrderNo, p.LastName, p.FirstName
    FROM persons p
    RIGHT JOIN orders o ON p.P_Id = o.P_Id
)
ORDER BY LastName ASC;
```

- Baza pobierze sumę lewostronną, sumę prawostronną i połączy je bez duplikatów za pomocą `UNION`.

### Zadanie C8 & C9: Wielokrotne złączenia `INNER JOIN`

**Pytanie:** Wypisz w jednej tabeli zestawienie: `OrderNo`, `LastName`, `City`, `COUNTRY`.

SQL

```sql
SELECT o.OrderNo, p.LastName, p.City, c.COUNTRY
FROM orders o
INNER JOIN persons p ON o.P_Id = p.P_Id
INNER JOIN countries c ON p.City = c.CITY;
```

- Łączymy trzy tabele w łańcuch: `orders` $\rightarrow$ `persons` (po `P_Id`) oraz `persons` $\rightarrow$ `countries` (po `City`).

### Zadanie C10: Złączenie naturalne (`NATURAL JOIN`)

**Pytanie:** Zapisz operację złączenia naturalnego tabel `persons` i `countries`.

SQL

```sql
SELECT *
FROM persons
NATURAL JOIN countries;
```

- **Uwaga:** Aby `NATURAL JOIN` zadziałało poprawnie między tymi tabelami, obie musiałyby posiadać dokładnie tak samo nazwaną kolumnę reprezentującą miasto (np. `City` w obu tabelach).

## 📝 Ściągawka dla Programisty SQL

| **Składnia**     | **Do czego służy?** | **Co jeśli brak dopasowania?** |
| ---------------- | ------------------- | ------------------------------ |
| **`INNER JOIN`** |                     |                                |

Część wspólna obu tabel.

|     |
| --- |

Rekord jest odrzucany z wyniku.

| **`LEFT JOIN`** |     |
| --------------- | --- |

Wszystko z tabeli A + dopasowane z B.

|     |
| --- |

Pola tabeli B przyjmują wartość `NULL`.

| **`RIGHT JOIN`** |     |
| ---------------- | --- |

Wszystko z tabeli B + dopasowane z A.

|     |
| --- |

Pola tabeli A przyjmują wartość `NULL`.

| **`UNION`** |     |
| ----------- | --- |

Łączy wyniki 2 zapytań usuwając duplikaty.

| —            |     |
| ------------ | --- |
| **`HAVING`** |     |

Filtruje grupy po funkcjach agregujących (`COUNT`, `SUM`).

| —   |
| --- |
