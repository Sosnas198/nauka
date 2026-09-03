# 🛒 Kompleksowy Kurs SQL dla Początkujących: Od Tworzenia Bazy po Zarządzanie Zamówieniami

W tym poradniku nauczysz się projektować i obsługiwać bazy danych od absolutnych podstaw. Krok po kroku zbudujemy system obsługi sklepu internetowego z klientami, zamówieniami i produktami.

---

## 📚 Spis Treści

1. [Podstawowe pojęcia i typy danych](#1-podstawowe-pojęcia-i-typy-danych)
2. [Etap 1: Tworzenie Bazy Danych i Tabel (DDL)](#etap-1-tworzenie-bazy-danych-i-tabel-ddl)
3. [Etap 2: Modyfikacja Struktury i Więzów (ALTER TABLE)](#etap-2-modyfikacja-struktury-i-więzów-alter-table)
4. [Etap 3: Wstawianie i Import Danych (DML & LOAD DATA)](#etap-3-wstawianie-i-import-danych-dml--load-data)
5. [Etap 4: Aktualizacja, Dodawanie i Usuwanie Danych](#etap-4-aktualizacja-dodawanie-i-usuwanie-danych)
6. [Etap 5: Rozbudowa Struktury i Typ `ENUM`](#etap-5-rozbudowa-struktury-i-typ-enum)
7. [Ściągawka z Komend (Cheatsheet)](#ściągawka-z-komend-cheatsheet)

---

## 1. Podstawowe pojęcia i typy danych

Zanim przejdziemy do kodu, poznaj kluczowe pojęcia:

- **DDL (_Data Definition Language_)** – język do definiowania struktury bazy (np. tworzenie tabel, zmiana kolumn).
- **DML (_Data Manipulation Language_)** – język do pracy z danymi wewnątrz tabel (np. dodawanie, zmiana lub usuwanie wierszy).
- **Primary Key (Klucz Główny / PK)** – unikalny identyfikator danego wiersza (np. unikalny numer klienta `customerID`). Nie może się powtarzać i nie może być pusty (`NULL`).
- **Foreign Key (Klucz Obcy / FK)** – kolumna, która łączy jedną tabelę z inną (np. wskazuje, który klient z tabeli `Customer` złożył dane zamówienie w tabeli `order`).
- **CHECK** – warunek sprawdzający spójność wprowadzanych danych (np. ilość produktów musi być z przedziału 1-99).

---

## Etap 1: Tworzenie Bazy Danych i Tabel (DDL)

### Krok 1: Tworzenie Bazy z Polskimi Znakami

Tworzymy bazę danych o nazwie `FIRMA`. Aby uniknąć problemów z polskimi literami (ą, ę, ś, ć), ustawiamy kodowanie `utf8mb4` oraz porównywanie ciągów znaków (collation) dostosowane do języka polskiego.

```sql
CREATE DATABASE FIRMA
CHARACTER SET utf8mb4
COLLATE utf8mb4_polish_ci;

-- Przejście do pracy na utworzonej bazie
USE FIRMA;
```

### Krok 2: Tworzenie Tabel Struktury Sklepu

Tworzymy cztery powiązane ze sobą tabele:

1. **`Customer`** – klienci sklepu.
2. **`order`** – nagłówki zamówień (kto i kiedy złożył zamówienie).
3. **`item`** – katalog dostępnych produktów.
4. **`OrderItem`** – pozycja na zamówieniu (łącznik łączący zamówienie z produktami i ich ilością).

```sql
-- 1. Tabela Klientów
CREATE TABLE Customer (
    customerID INT UNSIGNED,
    customerName VARCHAR(35) NOT NULL,
    customerAddress VARCHAR(100)
);

-- 2. Tabela Zamówień
CREATE TABLE `order` (
    orderID INT UNSIGNED PRIMARY KEY,
    orderDate DATE NOT NULL,
    customerID INT UNSIGNED NOT NULL
);

-- 3. Tabela Produktów
CREATE TABLE item (
    itemID INT UNSIGNED PRIMARY KEY,
    itemName VARCHAR(100) UNIQUE
);

-- 4. Tabela Pozycji Zamówienia (z ograniczeniem CHECK)
CREATE TABLE OrderItem (
    orderID INT UNSIGNED,
    itemID INT UNSIGNED,
    itemQuantity INT UNSIGNED CHECK (itemQuantity >= 1 AND itemQuantity < 100),
    PRIMARY KEY (orderID, itemID)
);
```

> 💡 **Dlaczego `PRIMARY KEY (orderID, itemID)`?**
>
> Jest to tzw. **klucz złożony**. Zapobiega sytuacji, w której ten sam produkt zostanie dodany dwukrotnie do tego samego zamówienia jako osobny wiersz.

---

## Etap 2: Modyfikacja Struktury i Więzów (`ALTER TABLE`)

Często zdarza się, że zapomnimy ustawić klucz główny lub obcy podczas tworzenia tabeli. Z pomocą przychodzi polecenie `ALTER TABLE`.

### Dodanie Klucza Głównego i Klucza Obcego

W tabeli `Customer` brakuje klucza głównego, a w tabeli `order` nie ma relacji łączącej ją z klientem. Naprawiamy to poniższym kodem:

```sql
-- Dodanie Klucza Głównego do tabeli Customer
ALTER TABLE Customer
ADD PRIMARY KEY (customerID);

-- Dodanie Klucza Obcego powiązanego z tabelą Customer
ALTER TABLE `order`
ADD CONSTRAINT FK_Customer_Order
FOREIGN KEY (customerID) REFERENCES Customer (customerID);
```

---

## Etap 3: Wstawianie i Import Danych (DML & LOAD DATA)

### A. Ręczne Dodawanie Wierszy (`INSERT INTO`)

Wstawiamy 5 klientów do bazy danych. Jeśli klient nie podał adresu, używamy wartości `NULL`:

```sql
INSERT INTO Customer VALUES
(1, 'Jankowski', NULL),
(2, 'Sobisiak', 'ul. Warzywna 4 Kraków'),
(3, 'Szulc', 'os. Zielone 45/1 Wrocław'),
(4, 'Matusiak', 'ul. Czytelna 85/3 Warszawa'),
(5, 'Turkot', 'ul. Długa 81/1 Warszawa');
```

### B. Import Danych z Pliku Tekstowego (`LOAD DATA INFILE`)

Zamiast wpisywać setki produktów ręcznie, możemy je masowo zaimportować z pliku tekstowego (np. `ITEMS.txt` lub z pliku CSV):

```sql
LOAD DATA INFILE 'ITEMS.txt'
INTO TABLE item
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES;
```

- **`FIELDS TERMINATED BY ','`** – kolumny w pliku są rozdzielone przecinkiem.
- **`ENCLOSED BY '"'`** – wartości tekstowe mogą być ujęte w cudzysłów.
- **`LINES TERMINATED BY '\r\n'`** – każdy nowy wiersz oznacza nowy rekord (standard systemu Windows).
- **`IGNORE 1 LINES`** – pomija pierwszy nagłówkowy wiersz pliku (np. `ITEMID,ITEMNAME`).

### C. Wstawianie Zamówień i Pozycji Zamówienia

```sql
-- Wstawienie zamówień
INSERT INTO `order` VALUES
(1, '2020-11-20', 2),
(2, '2020-11-25', 5),
(3, '2020-12-04', 4),
(4, '2020-12-06', 5);

-- Wstawienie szczegółów zamówień (jaki produkt i w jakiej ilości)
INSERT INTO OrderItem (orderID, itemID, itemQuantity) VALUES
(1, 2, 5),
(2, 6, 1),
(3, 8, 2),
(4, 3, 2);
```

---

## Etap 4: Aktualizacja, Dodawanie i Usuwanie Danych

Praca z istniejącymi danymi obejmuje operacje `INSERT`, `UPDATE` oraz `DELETE`.

### 1. Dodanie Nowego Produktu

```sql
INSERT INTO item (itemID, itemName)
VALUES (15, 'Wieczne pióro');
```

### 2. Aktualizacja Danych (`UPDATE`)

Klient 'Jankowski' dostarczył swój brakujący adres. Uzupełniamy go w bazie:

```sql
UPDATE Customer
SET customerAddress = 'ul. Wolności 4, Przemyśl'
WHERE customerName = 'Jankowski';
```

Poprawiamy też błędną nazwę towaru:

```sql
UPDATE item
SET itemName = 'Zarowka LEDowa'
WHERE itemName = 'Zarowka LED';
```

> ⚠️ **Uwaga:** Zawsze pamiętaj o klauzuli `WHERE` przy poleceniu `UPDATE` lub `DELETE`! Jeśli jej zapomnisz, zmienisz lub usuniesz dane ze **wszystkich** wierszy w tabeli!

### 3. Usuwanie Danych (`DELETE`)

Usuwamy pozycję zamówienia o ID towaru równym `3`:

```sql
DELETE FROM OrderItem
WHERE itemID = 3;
```

---

## Etap 5: Rozbudowa Struktury i Typ `ENUM`

Rozbudujemy bazę o śledzenie statusów zamówienia. Idealnie nadaje się do tego typ **`ENUM`**, który wymusza wybór wartości z wcześniej zdefiniowanej listy.

### Krok 1: Dodanie Kolumny ze Statusem Zamówienia

Dodajemy do tabeli `order` nową kolumnę `orderStatus` z domyślną wartością `'zlozone'`:

```sql
ALTER TABLE `order`
ADD COLUMN orderStatus ENUM('zlozone', 'w realizacji', 'zrealizowane', 'odwolane')
DEFAULT 'zlozone';
```

### Krok 2: Masowa Aktualizacja Statusów na Podstawie Daty

Automatycznie oznaczamy stare zamówienia (złożone przed grudniem 2020 r.) jako zrealizowane, a nowsze jako będące w realizacji:

```sql
-- Zamówienia sprzed 1 grudnia 2020 r. ustawiamy jako zrealizowane
UPDATE `order`
SET orderStatus = 'zrealizowane'
WHERE orderDate < '2020-12-01';

-- Zamówienia po 1 grudnia 2020 r. ustawiamy jako w realizacji
UPDATE `order`
SET orderStatus = 'w realizacji'
WHERE orderDate >= '2020-12-01';
```

---

## 📑 Ściągawka z Komend (Cheatsheet)

| **Polecenie SQL**                                       | **Opis działania**                                             |
| ------------------------------------------------------- | -------------------------------------------------------------- |
| **`CREATE DATABASE nazwa;`**                            | Tworzy nową bazę danych.                                       |
| **`CREATE TABLE nazwa (...);`**                         | Tworzy nową tabelę z kolumnami.                                |
| **`ALTER TABLE t ADD PRIMARY KEY (k);`**                | Dodaje klucz główny do istniejącej tabeli.                     |
| **`ALTER TABLE t ADD CONSTRAINT ... FOREIGN KEY ...;`** | Tworzy relację między dwoma tabelami.                          |
| **`INSERT INTO t VALUES (...);`**                       | Dodaje nowy wiersz z danymi.                                   |
| **`UPDATE t SET k = 'wartość' WHERE ...;`**             | Modyfikuje istniejące wartości na podstawie warunku.           |
| **`DELETE FROM t WHERE ...;`**                          | Usuwa wybrane wiersze z tabeli.                                |
| **`LOAD DATA INFILE ... INTO TABLE t;`**                | Szybki import dużej ilości danych z pliku płaskiego[cite: 14]. |
