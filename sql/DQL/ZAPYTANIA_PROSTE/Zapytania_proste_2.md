# 📚 Kurs SQL & Relacyjnych Baz Danych (Poziom Podstawowy)

Witaj w poradniku poświęconym relacyjnym bazom danych! Nauczysz się tu tworzyć bazy danych, definiować tabele, modyfikować ich strukturę, relacjonować dane oraz pisać zaawansowane zapytania `SELECT` i `INSERT`.

## 1. Tworzenie i Wybór Bazy Danych

Aby rozpocząć pracę w MySQL/MariaDB, musimy najpierw stworzyć kontener na nasze tabele, czyli **bazę danych**.

SQL

```sql
CREATE DATABASE Rekrutacja;
USE Rekrutacja;
```

### 💡 Wyjaśnienie od podstaw:

- `CREATE DATABASE Rekrutacja;` – instrukcja tworzy nową, pustą bazę danych o nazwie `Rekrutacja`.
- `USE Rekrutacja;` – informuje serwer, że wszystkie kolejne zapytania mają być wykonywane właśnie w tej bazie (wybiera ją jako bieżącą).

## 2. Tworzenie Tabel i Ograniczenia (DDL – Data Definition Language)

Projektujemy strukturę trzech tabel: `Kandydaci`, `Zgloszenia` oraz `Informatycy`.

### a) Tabela `Kandydaci`

SQL

```sql
CREATE TABLE Kandydaci (
    idosoby CHAR(4) PRIMARY KEY,
    imie VARCHAR(20),
    nazwisko VARCHAR(40),
    matematyka TINYINT UNSIGNED CHECK (matematyka >= 0 AND matematyka <= 100),
    informatyka TINYINT UNSIGNED CHECK (informatyka >= 0 AND informatyka <= 100),
    fizyka TINYINT UNSIGNED CHECK (fizyka >= 0 AND fizyka <= 100),
    jezykobcy TINYINT UNSIGNED CHECK (jezykobcy >= 0 AND jezykobcy <= 100),
    plec ENUM('m', 'k')
);
```

### b) Tabela `Zgloszenia`

SQL

```sql
CREATE TABLE Zgloszenia (
    kierunek VARCHAR(20),
    idosoby CHAR(4),
    FOREIGN KEY (idosoby) REFERENCES Kandydaci(idosoby)
);
```

### c) Tabela `Informatycy`

SQL

```sql
CREATE TABLE Informatycy (
    idosoby CHAR(4) PRIMARY KEY,
    punkty SMALLINT UNSIGNED CHECK (punkty >= 0 AND punkty <= 1000)
);
```

### 🔍 Wyjaśnienie pojęć i typów danych dla amatora:

1. **Typy danych:**
   - `CHAR(4)` – ciąg znaków o **stałej** długości (zawsze dokładnie 4 znaki, np. `'k001'`). Idealny do identyfikatorów.
   - `VARCHAR(n)` – ciąg znaków o **zmiennej** długości (maksymalnie $n$ znaków, np. `VARCHAR(20)`). Oszczędza pamięć.
   - `TINYINT UNSIGNED` – bardzo mała liczba całkowita (od 0 do 255). Modyfikator `UNSIGNED` oznacza brak liczb ujemnych.
   - `SMALLINT UNSIGNED` – mała liczba całkowita bez znaku (od 0 do 65 535).
   - `ENUM('m', 'k')` – typ wyliczeniowy. Kolumna może przyjąć **wyłącznie** wartości podane w nawiasie (tu: `'m'` dla mężczyzny, `'k'` dla kobiety).

2. **Klucze i Ograniczenia (Constraints):**
   - `PRIMARY KEY` (Klucz Główny) – unikalny identyfikator wiersza. Uniemożliwia powielanie tych samych wartości oraz wprowadzanie pustych wartości (`NULL`).
   - `FOREIGN KEY` (Klucz Obcy) – wiąże tabelę z inną tabelą. Zapewnia **spójność relacyjną** – nie da się dodać zgłoszenia dla osoby, która nie istnieje w tabeli `Kandydaci`.
   - `CHECK (...)` – warunek sprawdzający wprowadzane dane. Jeśli spróbujesz wpisać `105` punktów z matematyki, baza danych zgłosi błąd i odrzuci rekord.

## 3. Modyfikacja Struktury Tabeli (`ALTER TABLE`)

Często po zaimportowaniu danych okazuje się, że musimy rozbudować tabelę o automatycznie numerowany identyfikator.

SQL

```sql
ALTER TABLE Zgloszenia
ADD COLUMN idzgloszenia INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
```

### 💡 Szczegółowe wyjaśnienie:

- `ALTER TABLE Zgloszenia` – wydaje rozkaz modyfikacji struktury tabeli `Zgloszenia`.
- `ADD COLUMN idzgloszenia ...` – dodaje nową kolumnę `idzgloszenia`.
- `AUTO_INCREMENT` – nakazuje bazie automatycznie generować unikalny numer (1, 2, 3...) dla każdego nowego wiersza.
- `FIRST` – umieszcza nowo utworzoną kolumnę na samym początku tabeli (jako pierwszą od lewej).

## 4. Zapytania Pobierające Dane (DQL – Data Query Language)

Poniżej znajduje się kompletny zestaw pytań i odpowiedzi wraz z analizą operacji SQL.

### a) Filtrowanie i sortowanie proste

**Zadanie:** Wyświetl nazwiska oraz punkty z matematyki osób, które uzyskały więcej niż 50 pkt, sortując rosnąco.

SQL

```sql
SELECT
    nazwisko,
    matematyka AS punkty
FROM Kandydaci
WHERE matematyka > 50
ORDER BY matematyka ASC;
```

- `AS punkty` – alias (tymczasowa nazwa kolumny w wyniku zapytania).
- `WHERE matematyka > 50` – filtruje wiersze.
- `ORDER BY ... ASC` – sortuje wynik rosnąco (`ASC` = _ascending_).

### b) Wyciąganie unikalnych wartości (`DISTINCT`)

**Zadanie:** Wyświetl wszystkie różne kierunki studiów, posortowane alfabetycznie.

SQL

```sql
SELECT DISTINCT
    kierunek AS `Kierunek studiów`
FROM Zgloszenia
ORDER BY kierunek ASC;
```

- `DISTINCT` – usuwa powtórzenia z wyników (zamiast setek powtórzonych wpisów otrzymamy tylko unikalną listę kierunków).

### c) Manipulacja tekstem i limitowanie wyników

**Zadanie:** Wyświetl imiona i nazwiska kandydujących kobiet (max 20 wyników), sortując po nazwisku malejąco, a nazwiska wypisz wielkimi literami.

SQL

```sql
SELECT
    imie,
    UPPER(nazwisko) AS nazwisko
FROM Kandydaci
WHERE plec = 'k'
ORDER BY nazwisko DESC
LIMIT 20;
```

- `UPPER(nazwisko)` – funkcja zamieniająca tekst na WIELKIE LITERY.
- `ORDER BY ... DESC` – sortowanie malejące (`DESC` = _descending_).
- `LIMIT 20` – ogranicza wyświetlanie do maksymalnie 20 wierszy.

### d) Operacje arytmetyczne na kolumnach

**Zadanie:** Wyświetl nazwisko, imię oraz sumę wszystkich punktów, sortując malejąco po sumie.

SQL

```sql
SELECT
    nazwisko,
    imie,
    (matematyka + informatyka + fizyka + jezykobcy) AS suma_punktow
FROM Kandydaci
ORDER BY suma_punktow DESC;
```

- SQL pozwala na wykonywanie tradycyjnych działań matematycznych na wartościach pobieranych z kolumn wiersza.

### e) Dopasowanie wzorców tekstowych (`LIKE` i Wildcards)

**Zadanie:** Wyświetl punkty z informatyki i nazwiska kobiet, których nazwisko zaczyna się na literę 'W' lub 'S'.

SQL

```sql
SELECT
    nazwisko,
    informatyka AS punkty
FROM Kandydaci
WHERE plec = 'k'
  AND (nazwisko LIKE 'W%' OR nazwisko LIKE 'S%');
```

#### 🛠️ Jak działa `%` w `LIKE`:

- `%` (tzw. wildcard) oznacza **dowolną liczbę dowolnych znaków** (w tym 0 znaków).
- `'W%'` – oznacza: "zaczyna się od litery W, a dalej może być cokolwiek".
- **Uwaga na nawiasy:** Stosuj nawiasy `(...)` łącząc `AND` z operatorami `OR`, aby zachować prawidłową kolejność logiczną!

### f) Systemowe funkcje informacyjne

**Zadanie:** Wykonaj zapytanie `SELECT VERSION(), USER(), DATABASE();`.

SQL

```sql
SELECT VERSION(), USER(), DATABASE();
```

- `VERSION()` – zwraca dokładną wersję i silnik serwera baz danych (np. `10.4.32-MariaDB`).
- `USER()` – zwraca login i host aktualnie połączonego użytkownika (np. `root@localhost`).
- `DATABASE()` – zwraca nazwę aktualnie używanej bazy (w tym przypadku `rekrutacja`).

### g) Łączenie tabel (`JOIN`)

**Zadanie:** Wyświetl nazwiska i imiona kandydatów, którzy zgłosili się na kierunek `informatyka`.

SQL

```sql
SELECT
    Kandydaci.nazwisko,
    Kandydaci.imie
FROM Kandydaci
JOIN Zgloszenia ON Kandydaci.idosoby = Zgloszenia.idosoby
WHERE Zgloszenia.kierunek = 'informatyka';
```

### 🔗 Jak działa `JOIN`?

Dane o osobie (imię, nazwisko) znajdują się w tabeli `Kandydaci`, a dane o kierunku w tabeli `Zgloszenia`. Złączenie `JOIN ... ON` pozwala „skleić” wiersze z obu tabel na podstawie wspólnego identyfikatora `idosoby`.

### h) Precyzyjne dopasowanie długości tekstu (`_`)

**Zadanie:** Wyświetl nazwiska oraz sumę punktów z matematyki i języka obcego dla kandydatów, których nazwisko ma **dokładnie 6 znaków**.

SQL

```sql
SELECT
    nazwisko,
    (matematyka + jezykobcy) AS suma_punktow
FROM Kandydaci
WHERE nazwisko LIKE '______'
ORDER BY suma_punktow ASC;
```

- `_` (podkreślenie) odpowiada **dokładnie jednemu dowolnemu znakowi**.
- Sześć znaków `______` oznacza, że filtrujemy wyłącznie nazwiska dokładnie 6-literowe (np. `Kowal`, `Wrobel`).

### i) Zgłoszenia konkretnego kandydata

**Zadanie:** Wyświetl wszystkie kierunki, na które zgłosił się kandydat o ID `k083`.

SQL

```sql
SELECT
    kierunek
FROM Zgloszenia
WHERE idosoby = 'k083';
```

### j) Zaawansowane filtrowanie z wielu tabel

**Zadanie:** Wyświetl kandydatki na informatykę, które zgromadziły $\ge 40$ pkt z matematyki oraz $\ge 50$ z fizyki, posortowane rosnąco po nazwisku.

SQL

```sql
SELECT DISTINCT
    Kandydaci.imie,
    Kandydaci.nazwisko
FROM Kandydaci
JOIN Zgloszenia ON Kandydaci.idosoby = Zgloszenia.idosoby
WHERE Zgloszenia.kierunek = 'informatyka'
  AND Kandydaci.plec = 'k'
  AND Kandydaci.matematyka >= 40
  AND Kandydaci.fizyka >= 50
ORDER BY Kandydaci.nazwisko ASC;
```

## 5. Zasilanie Tabeli Wynikami Zapytania (`INSERT INTO ... SELECT`)

Częstym zadaniem jest wyselekcjonowanie grupy najlepszych rekordów i zapisanie ich w osobnej tabeli.

**Zadanie:** Wprowadź do tabeli `Informatycy` 8 osób z najlepszym skumulowanym wynikiem z **informatyki, fizyki i matematyki**.

SQL

```sql
INSERT INTO Informatycy (idosoby, punkty)
SELECT
    idosoby,
    (matematyka + informatyka + fizyka) AS suma
FROM Kandydaci
ORDER BY suma DESC
LIMIT 8;
```

### 💡 Jak to działa?

Zamiast ręcznie podawać wartości `VALUES (...)`, SQL pozwala użyć wyniku zapytania `SELECT` jako źródła danych do wstawienia przez `INSERT INTO`. Zapytanie oblicza sumę punktów ze wskazanych trzech przedmiotów, sortuje kandydatów malejąco i wybiera pierwszych 8 osób (`LIMIT 8`).
