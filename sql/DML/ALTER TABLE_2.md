# 🐘 Kurs SQL: Język DDL i Modyfikacja Tabel (`ALTER TABLE`)

Witaj w poradniku dotyczącym modyfikowania struktury bazy danych!

W SQL polecenia dzielimy na kilka grup. Jedną z najważniejszych jest **DDL** (_Data Definition Language_ – Język Definiowania Danych). Służy on do tworzenia, zmieniania i usuwania samych **konstrukcji** (tabel, baz danych, indeksów), a nie samych wpisów w tabeli.

Głównym bohaterem tej lekcji jest komenda **`ALTER TABLE`**.

---

## 💡 1. Co to jest `ALTER TABLE` i kiedy go używamy?

Wyobraź sobie, że tabela w bazie danych to nagłówki kolumn w arkuszu Excela:

- **`CREATE TABLE`** – tworzy nowy, pusty arkusz z wybranymi kolumnami.
- **`ALTER TABLE`** – dodaje nowe kolumny, usuwa niepotrzebne, zmienia nazwy lub modyfikuje typy danych w istniejącym już arkuszu.
- **`DROP TABLE`** – wyrzuca cały arkusz do kosza.

> ⚠️ **Pamiętaj:** `ALTER TABLE` zmienia **strukturę (szablon)** tabeli. Jeśli chcesz zmienić imię konkretnego pracownika w wierszu, używasz komendy `UPDATE` (DDL nie służy do zmiany samych danych).

---

## 🛠️ 2. Przegląd najważniejszych możliwości `ALTER TABLE`

Za pomocą `ALTER TABLE` w MySQL możesz wykonać m.in.:

1. **Dodawać i usuwać kolumny** (`ADD COLUMN`, `DROP COLUMN`).
2. **Zmieniać nazwy kolumn i tabel** (`CHANGE COLUMN`, `RENAME TO`).
3. **Modyfikować typy danych i pozycję kolumn** (`MODIFY COLUMN`, `FIRST`, `AFTER`).
4. **Zarządzać kluczami i ograniczeniami** (`ADD PRIMARY KEY`, `DROP PRIMARY KEY`, `ADD FOREIGN KEY`).

---

## 🧠 3. Kluczowe słowa w MySQL, które warto znać

W systemie MySQL występują bardzo przydatne słowa kluczowe, które pozwalają sterować kolejnością kolumn:

- **`FIRST`** – umieszcza nową/modyfikowaną kolumnę na samym początku tabeli (jako pierwszą).
- **`AFTER nazwa_kolumny`** – umieszcza kolumnę bezpośrednio za wskazaną kolumną.

Różnica między **`MODIFY`** a **`CHANGE`**:

- **`MODIFY COLUMN`** – używasz, gdy chcesz zmienić **tylko typ danych lub pozycję** kolumny (nazwa pozostaje bez zmian).
- **`CHANGE COLUMN`** – używasz, gdy chcesz **zmienić nazwę kolumny** (i przy okazji możesz zmienić też jej typ oraz pozycję).

---

## 🧪 4. Praktyczne Ćwiczenie Krok po Kroku

Przeprowadźmy pełną symulację na bazie danych MySQL. Krok po kroku zobaczymy, jak zmienia się struktura tabeli.

### Krok 1: Przygotowanie środowiska i utworzenie tabeli

Najpierw tworzymy nową bazę danych i podłączamy się do niej:

```sql
CREATE DATABASE BAZA1;
USE BAZA1;
```

Asekuracyjnie usuwamy tabelę `OSOBA`, jeśli istniała wcześniej, i tworzymy nową z tylko jedną kolumną (`ID`):

```sql
DROP TABLE IF EXISTS OSOBA;

CREATE TABLE OSOBA (
    ID TINYINT PRIMARY KEY
);
```

> 🔍 **Sprawdzenie struktury:**
> Aby zobaczyć obecne kolumny i ich typy, wpisujemy[cite: 12]:

```sql
DESCRIBE OSOBA;
```

---

### Krok 2: Dodawanie kilku kolumn jednocześnie (`ADD COLUMN`)

Chcemy dodać imię, nazwisko oraz adres[cite: 12].

Zauważ, że możemy połączyć kilka operacji po jednym `ALTER TABLE`, rozdzielając je przecinkami[cite: 12]!

```sql
ALTER TABLE OSOBA
    ADD COLUMN Imie VARCHAR(35),
    ADD COLUMN Nazwisko VARCHAR(55),
    ADD COLUMN Adresik VARCHAR(100) AFTER Imie;
```

**Co tu się stało?**

- Dodano kolumny `Imie` i `Nazwisko`[cite: 12].
- Kolumna `Adresik` została wstawiona **bezpośrednio po** kolumnie `Imie` dzięki użyciu `AFTER Imie`[cite: 12].

---

### Krok 3: Usuwanie Klucza Głównodowodzącego (`DROP PRIMARY KEY`)

Jeśli musimy zmienić sposób identyfikacji rekordów, możemy usunąć klucz główny[cite: 12]:

```sql
ALTER TABLE OSOBA
    DROP PRIMARY KEY;
```

---

### Krok 4: Zmiana typu kolumny i usuwanie kolumny (`MODIFY` + `DROP`)

Typ `TINYINT` dla pola `ID` mieści tylko liczby od -128 do 127.

Zmieńmy go na zwykły `INT` i przywróćmy klucz główny, a jednocześnie usuńmy kolumnę `Nazwisko`[cite: 12]:

```sql
ALTER TABLE OSOBA
    MODIFY COLUMN ID INT PRIMARY KEY,
    DROP COLUMN Nazwisko;
```

---

### Krok 5: Zmiana nazwy kolumny oraz przestawienie na początek (`CHANGE ... FIRST`)

Zmieńmy nazwę kolumny z `Adresik` na `Adres`, zwiększmy jej rozmiar do `VARCHAR(120)` i przesuńmy ją na **sam początek tabeli**[cite: 12]:

```sql
ALTER TABLE OSOBA
    CHANGE COLUMN Adresik Adres VARCHAR(120) FIRST;
```

> ⚠️ **Ważne przy `CHANGE COLUMN`:** Musisz podać starą nazwę, nową nazwę ORAZ nowy typ danych (nawet jeśli typ się nie zmienia)[cite: 12].

---

### Krok 6: Zmiana nazwy całej tabeli (`RENAME TO`)

Na koniec zmieńmy nazwę całej tabeli z `OSOBA` na `PERSON`[cite: 12]:

```sql
ALTER TABLE OSOBA
    RENAME TO PERSON;
```

---

### Krok 7: Weryfikacja końcowa

Wyświetlmy listę tabel i nową strukturę tabeli `PERSON`[cite: 12]:

```sql
SHOW TABLES;
DESCRIBE PERSON;
```

> **Uwaga:** Polecenie `DESCRIBE OSOBA;` zwróci błąd, ponieważ tabela pod starą nazwą już nie istnieje!

[cite: 12]

---

## 📑 5. Szybka Ściągawka (Cheatsheet)

| **Operacja**                    | **Komenda SQL**                                        | **Co robi?**                                        |
| ------------------------------- | ------------------------------------------------------ | --------------------------------------------------- |
| **Dodanie kolumny na końcu**    | `ALTER TABLE t ADD COLUMN k VARCHAR(50);`              | Dodaje nową kolumnę `k` [cite: 12]                  |
| **Dodanie kolumny na początku** | `ALTER TABLE t ADD COLUMN k INT FIRST;`                | Dodaje kolumnę `k` jako pierwszą w tabeli[cite: 12] |
| **Usunięcie kolumny**           | `ALTER TABLE t DROP COLUMN k;`                         | Trwale usuwa kolumnę `k` [cite: 12]                 |
| **Zmiana typu kolumny**         | `ALTER TABLE t MODIFY COLUMN k INT;`                   | Zmienia typ danych kolumny `k` na `INT` [cite: 12]  |
| **Zmiana nazwy kolumny**        | `ALTER TABLE t CHANGE COLUMN stara nowa VARCHAR(100);` | Zmienia nazwę kolumny i jej typ[cite: 12]           |
| **Zmiana nazwy tabeli**         | `ALTER TABLE stara_tabela RENAME TO nowa_tabela;`      | Zmienia nazwę tabeli[cite: 12]                      |
| **Usunięcie klucza głównego**   | `ALTER TABLE t DROP PRIMARY KEY;`                      | Usuwa ograniczenie klucza głównego[cite: 12]        |
