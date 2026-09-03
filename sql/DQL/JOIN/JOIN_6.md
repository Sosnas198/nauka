# 🏦 Masterclass SQL: System Bankowy `select9`

### Łączenie Tabel, Analiza Finansowa i Operacje na Zbiorach

W tym module przeanalizujesz system bankowy obsługujący klientów, ich lokaty oraz oferty bankowe. Nauczysz się, jak prawidłowo modelować struktury relacyjne, dołączać do siebie dane bez gubienia informacji oraz pisać złożone kwerendy analityczne.

## 🏗️ KROK 1: Projektowanie i Budowa Bazy Danych (DDL)

Zanim wyciągniemy jakiekolwiek dane, spójrzmy na strukturę bazy danych. Mamy tu do czynienia z relacją **jeden-do-wielu** ($1:N$):

- Jednemu klientowi odpowiadać może **wiele** lokat.
- Jedna oferta bankowa może być wykorzystana w **wielu** lokatach.

SQL

```sql id="a7f3kq"
CREATE DATABASE IF NOT EXISTS SELECT9;
USE SELECT9;

-- 1. Tabela KLIENCI
CREATE TABLE KLIENCI (
    ID_K INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    NAZWISKO VARCHAR(40) DEFAULT NULL,
    IMIE VARCHAR(30) DEFAULT NULL,
    MIASTO VARCHAR(30) DEFAULT NULL,
    PRIMARY KEY (ID_K)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabela Słownikowa OFERTY (ogólna)
CREATE TABLE OFERTY (
    ID_O INT(11) NOT NULL AUTO_INCREMENT,
    BANK VARCHAR(20) NOT NULL,
    OPROCENTOWANIE DECIMAL(2,1) NOT NULL, -- Zakres np. 3.5%
    DLUGOSC VARCHAR(6) NOT NULL,          -- np. '1M-C', '12M-C'
    KWOTAMIN INT(10) UNSIGNED DEFAULT NULL CHECK (KWOTAMIN <= 1000000),
    KWOTAMAX INT(10) UNSIGNED DEFAULT NULL CHECK (KWOTAMAX <= 1000000),
    PRIMARY KEY (ID_O)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabela Operacyjna LOKATY (z Kluczami Obcymi)
CREATE TABLE LOKATY (
    ID_L INT(11) NOT NULL AUTO_INCREMENT,
    ID_K INT(10) UNSIGNED NOT NULL,
    OFERTA INT(11) DEFAULT NULL,
    KWOTA INT(10) UNSIGNED DEFAULT NULL,
    STATUS VARCHAR(25) DEFAULT NULL,
    PRIMARY KEY (ID_L)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dodanie więzów integralności (Klucze Obce / Foreign Keys)
ALTER TABLE LOKATY
    ADD CONSTRAINT FK_Lokaty_Klienci FOREIGN KEY (ID_K) REFERENCES KLIENCI(ID_K),
    ADD CONSTRAINT FK_Lokaty_Oferty FOREIGN KEY (OFERTA) REFERENCES OFERTY(ID_O);

```

#### 💡 Dlaczego użyliśmy `DECIMAL(2,1)`?

W polach finansowych (np. oprocentowanie lokat) **nie stosujemy** typów zmiennoprzecinkowych `FLOAT` ani `DOUBLE`, ponieważ powodują one błędy zaokrągleń. Typ `DECIMAL(2,1)` oznacza: przechowuj dokładnie 2 cyfry, z czego **1 po przecinku** (np. `3.5`).

## 📊 KROK 2: Analiza Danych i Zapytania SQL (DQL)

Każde zadanie rozłożymy na techniki SQL, z których korzysta: **Złączenia (\*\***`JOIN`\***\*)**, **Agregacja (\*\***`COUNT`\***\*,** **`SUM`\*\***)**, **Grupowanie (\***\*`GROUP BY`\*\***)** oraz **Filtrowanie (\***\*`WHERE`** **vs** **`HAVING`\*\***)\*\*.

### Zadanie A: Pobieżne złączenie tabel (`JOIN`)

**Polecenie:** Dla każdej z założonych lokat (`LOKATY`) wyświetl jej oprocentowanie oraz okres trwania (wykorzystując tabelę `OFERTY`).

SQL

```sql id="m4z8pt"
SELECT
    l.ID_L,
    o.OPROCENTOWANIE,
    o.DLUGOSC
FROM LOKATY l
JOIN OFERTY o ON l.OFERTA = o.ID_O;

```

- **Użyte techniki:** `INNER JOIN` (złączenie wewnętrzne). Baza danych dopasowuje identyfikator oferty z lokaty (`l.OFERTA`) do klucza głównego oferty (`o.ID_O`).

### Zadanie B: Sumowanie zbiorów bez powtórzeń (`UNION`)

**Polecenie:** Wyświetl łącznie wszystkie oferty lokat z obu tabel (`OFERTY1` oraz `OFERTY2`), usuwając oferty dublujące się.

SQL

```sql id="r2n6vc"
SELECT BANK, OPROCENTOWANIE, DLUGOSC, KWOTAMIN, KWOTAMAX FROM OFERTY1
UNION
SELECT BANK, OPROCENTOWANIE, DLUGOSC, KWOTAMIN, KWOTAMAX FROM OFERTY2;

```

- **Użyte techniki:** Operacja `UNION`. Łączy wiersze z obu tabel i automatycznie usuwa nakładające się rekordy. Pomijamy pole `ID_O`, ponieważ unikalne identyfikatory z dwóch osobnych tabel mogłyby zaburzyć wykrywanie duplikatów w treści ofert.

### Zadanie C: Zachowywanie pustych powiązań (`LEFT JOIN`)

**Polecenie:** Dla każdego klienta z tabeli `KLIENCI` wyświetl numery posiadanych lokat. Jeżeli klient nie posiada lokaty, wypisz `NULL`.

SQL

```sql id="q9k3fd"
SELECT
    k.ID_K,
    k.IMIE,
    k.NAZWISKO,
    l.ID_L
FROM KLIENCI k
LEFT JOIN LOKATY l ON k.ID_K = l.ID_K;

```

- **Użyte techniki:** `LEFT JOIN` (złączenie lewostronne). Pobiera wszystkich klientów z tabeli po lewej stronie (`KLIENCI`). Jeśli dany klient nie założył lokaty, w kolumnie `ID_L` wpisywana jest wartość `NULL`.

### Zadanie D & E: Liczenie według stanów (`GROUP BY` + `COUNT`)

**Polecenie:** Policz liczbę aktualnie założonych lokat w zależności od ich statusu (`ODNAWIALNA`, `KONCZACA`).

SQL

```sql id="v5x1nm"
SELECT
    STATUS,
    COUNT(*) AS LICZBA_LOKAT
FROM LOKATY
GROUP BY STATUS;

```

- **Użyte techniki:** Agregacja `COUNT(*)` oraz grupowanie `GROUP BY STATUS`. Baza dzieli lokaty na pakiety według wartości w kolumnie `STATUS` i zlicza wiersze w każdej paczce.

### Zadanie F: Szukanie lidera (`SUM` + `ORDER BY` + `LIMIT`)

**Polecenie:** Wyświetl nazwisko klienta, którego łączna suma założonych lokat jest kwotowo największa.

SQL

```sql id="c8j4zs"
SELECT
    k.ID_K,
    k.NAZWISKO,
    SUM(l.KWOTA) AS SUMA_LOKAT
FROM KLIENCI k
JOIN LOKATY l ON k.ID_K = l.ID_K
GROUP BY k.ID_K, k.NAZWISKO
ORDER BY SUMA_LOKAT DESC
LIMIT 1;

```

- **Użyte techniki:** `JOIN`, agregacja `SUM(KWOTA)`, grupowanie `GROUP BY`, sortowanie malejące `ORDER BY ... DESC` oraz ograniczenie wyników `LIMIT 1`.
- **Dlaczego grupujemy po** **`ID_K`** **i** **`NAZWISKO`\*\***?\*\* Dobra praktyka SQL wymaga, aby wszystkie niewyagregowane kolumny z `SELECT` znajdowały się w klauzuli `GROUP BY` (dzięki temu unikamy błędów przy powtarzających się nazwiskach).

### Zadanie G: Agregacja ofert z dołączeniem lewostronnym

**Polecenie:** Wypisz liczbę założonych lokat oraz łączną sumę kwot tych lokat dla każdej z oferowanych lokat z tabeli `OFERTY2`.

SQL

```sql id="p7w2la"
SELECT
    o.ID_O,
    o.BANK,
    COUNT(l.ID_L) AS LICZBA_LOKAT,
    IFNULL(SUM(l.KWOTA), 0) AS SUMA_KWOT
FROM OFERTY2 o
LEFT JOIN LOKATY l ON o.ID_O = l.OFERTA
GROUP BY o.ID_O, o.BANK;

```

- **Użyte techniki:** `LEFT JOIN` (aby uwzględnić również te oferty, których nikt nie kupił), `COUNT(l.ID_L)` (zlicza tylko niepuste lokaty) oraz `SUM(l.KWOTA)`.

### Zadanie H: Filtrowanie grup po wartości wyliczonej (`HAVING`)

**Polecenie:** Wypisz dane klientów, którzy mają lokaty założone na łączną sumę większą niż 50 000 zł.

SQL

```sql id="t6b9xr"
SELECT
    k.ID_K,
    k.IMIE,
    k.NAZWISKO,
    SUM(l.KWOTA) AS SUMA_LOKAT
FROM KLIENCI k
JOIN LOKATY l ON k.ID_K = l.ID_K
GROUP BY k.ID_K, k.IMIE, k.NAZWISKO
HAVING SUM(l.KWOTA) > 50000;

```

- **Użyte techniki:** `JOIN`, `SUM()`, `GROUP BY` oraz `HAVING`.
- **Zapamiętaj:** Nie możesz użyć `WHERE SUM(l.KWOTA) > 50000`, ponieważ przed wyliczeniem sumy baza danych nie wie, ile wynoszą łączny depozyt klienta! Do odrzucania całych wyliczonych grup służy wyłącznie słowo kluczowe `HAVING`.

### Zadanie I: Odrzucanie tekstu wzorcem (`WHERE` z `NOT LIKE`)

**Polecenie:** Wypisz łączną kwotę założonych lokat w zależności od miasta klienta, pomijając miasta rozpoczynające się na literę 'K'.

SQL

```sql id="n3d7kf"
SELECT
    k.MIASTO,
    SUM(l.KWOTA) AS SUMA_LOKAT
FROM KLIENCI k
JOIN LOKATY l ON k.ID_K = l.ID_K
WHERE k.MIASTO NOT LIKE 'K%'
GROUP BY k.MIASTO;

```

- **Użyte techniki:** `JOIN`, filtrowanie wierszy przed grupowaniem (`WHERE k.MIASTO NOT LIKE 'K%'`), `GROUP BY` oraz `SUM()`.

### Zadanie J: Ukrywanie małych grup (`HAVING COUNT`)

**Polecenie:** Podaj liczbę oferowanych lokat z tabeli `OFERTY2` dla każdego z banków, pomijając banki oferujące mniej niż 2 lokaty.

SQL

```sql id="z1m5hq"
SELECT
    BANK,
    COUNT(*) AS LICZBA_OFFERT
FROM OFERTY2
GROUP BY BANK
HAVING COUNT(*) >= 2;

```

- **Użyte techniki:** Grupowanie `GROUP BY BANK`, zliczanie `COUNT(*)` oraz filtrowanie grup `HAVING COUNT(*) >= 2`.

### Zadanie K: Znajdowanie części wspólnej z pominięciem kluczy (`INTERSECT` / `JOIN`)

**Polecenie:** Wypisz oferty wspólne dla tabel `OFERTY1` oraz `OFERTY2` (pomiń w porównaniu pole `ID_O`).

SQL

```sql id="f4q8ym"
SELECT
    o1.BANK,
    o1.OPROCENTOWANIE,
    o1.DLUGOSC,
    o1.KWOTAMIN,
    o1.KWOTAMAX
FROM OFERTY1 o1
JOIN OFERTY2 o2 ON o1.BANK = o2.BANK
               AND o1.OPROCENTOWANIE = o2.OPROCENTOWANIE
               AND o1.DLUGOSC = o2.DLUGOSC;

```

- **Użyte techniki:** `JOIN` na wielu kolumnach (Symulacja logicznego `INTERSECT`). Zamiast łączyć po kluczach głównych, łączymy po cechach oferty (bank, oprocentowanie, długość).

### Zadanie L: Filtrowanie warunkowe ze wskaźnikami braku danych

**Polecenie:** Dla każdej z lokat wypisz nazwę banku, w którym została założona – uwzględnij tylko oferty obecne w `OFERTY1`. Jeśli dana lokata pochodzi z tabeli `OFERTY2`, w miejscu banku wyświetl `NULL`.

SQL

```sql id="b6s2nd"
SELECT
    l.ID_L,
    o1.BANK
FROM LOKATY l
LEFT JOIN OFERTY1 o1 ON l.OFERTA = o1.ID_O;

```

- **Użyte techniki:** `LEFT JOIN` z tabelą `OFERTY1`. Jeśli identyfikator `l.OFERTA` wskazuje na ofertę z tabeli `OFERTY2` (np. ID 8 lub 9), to baza danych nie znajdzie go w tabeli `OFERTY1` i automatycznie zwróci wartość `NULL` w polu `o1.BANK`.

## 🛠️ Zestawienie Szybkich Reguł SQL

| **Problem / Potrzeba**                                | **Rozwiązanie SQL** |
| ----------------------------------------------------- | ------------------- |
| Chcę połączyć dane z dwóch tabel według powiązania ID |                     |

Użyj `JOIN` (`INNER JOIN`).

| Chcę pokazać wszystkie rekordy z lewej tabeli, nawet bez dopasowania |     |
| -------------------------------------------------------------------- | --- |

Użyj `LEFT JOIN`.

| Chcę zsumować lub policzyć dane w podgrupach |     |
| -------------------------------------------- | --- |

Użyj `GROUP BY` oraz `SUM()` / `COUNT()`.

| Chcę przefiltrować wiersze **przed** zsumowaniem |     |
| ------------------------------------------------ | --- |

Użyj klauzuli `WHERE`.

| Chcę przefiltrować grupy **po** wyliczeniu sumy lub średniej |     |
| ------------------------------------------------------------ | --- |

Użyj klauzuli `HAVING`.

| Chcę połączyć wyniki dwóch zapytań usuwając powtórki |     |
| ---------------------------------------------------- | --- |

Użyj operatora `UNION`.
