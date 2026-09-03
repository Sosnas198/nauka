Dodajmy kolumnę `email`, która może przechowywać tekst do 100 znaków:

```sql
ALTER TABLE Pracownicy
ADD email VARCHAR(100);
```

Gdy dana kolumna nie jest już potrzebna i chcesz pozbyć się jej ze struktury:

```sql
ALTER TABLE nazwa_tabeli
DROP COLUMN nazwa_kolumny;
```

Usuwamy nieużywaną kolumnę `numer_stacjonarny`:

```sql
ALTER TABLE Pracownicy
DROP COLUMN numer_stacjonarny;
```

Co zrobić, gdy pole miało za mały rozmiar lub niewłaściwy typ? (np. `VARCHAR(20)` okazał się za krótki dla nazwisk).

```sql
ALTER TABLE Pracownicy
MODIFY COLUMN nazwisko VARCHAR(100);
```

Klucz obcy łączy ze sobą dwie tabele (np. przypisuje Pracownika do Działu).

```sql
ALTER TABLE Pracownicy
ADD CONSTRAINT fk_pracownik_dzial
FOREIGN KEY (id_dzialu) REFERENCES Dzialy(id);
```

Zapewnia, że w kolumnie nie powtórzą się dwie takie same wartości (np. dwa takie same numery PESEL lub maile):

```sql
ALTER TABLE Pracownicy
ADD CONSTRAINT uq_pracownik_pesel UNIQUE (pesel);
```

Służą do pilnowania logicznych reguł (np. wiek nie może być ujemny, a pensja musi być większa niż minimalna):

```sql
ALTER TABLE Pracownicy
ADD CONSTRAINT chk_wiek CHECK (wiek >= 18);
```

Asekuracyjnie usuwamy tabelę `OSOBA`, jeśli istniała wcześniej, i tworzymy nową z tylko jedną kolumną (`ID`):

```sql
DROP TABLE IF EXISTS OSOBA;

CREATE TABLE OSOBA (
    ID TINYINT PRIMARY KEY
);
```

Chcemy dodać imię, nazwisko oraz adres

```sql
ALTER TABLE OSOBA
    ADD COLUMN Imie VARCHAR(35),
    ADD COLUMN Nazwisko VARCHAR(55),
    ADD COLUMN Adresik VARCHAR(100) AFTER Imie;
```

Jeśli musimy zmienić sposób identyfikacji rekordów, możemy usunąć klucz główny:

```sql
ALTER TABLE OSOBA
    DROP PRIMARY KEY;
```

Zmieńmy go na zwykły `INT` i przywróćmy klucz główny, a jednocześnie usuńmy kolumnę `Nazwisko`

```sql
ALTER TABLE OSOBA
    MODIFY COLUMN ID INT PRIMARY KEY,
    DROP COLUMN Nazwisko;
```

Zmieńmy nazwę kolumny z `Adresik` na `Adres`, zwiększmy jej rozmiar do `VARCHAR(120)` i przesuńmy ją na **sam początek tabeli**

```sql
ALTER TABLE OSOBA
    CHANGE COLUMN Adresik Adres VARCHAR(120) FIRST;
```

Na koniec zmieńmy nazwę całej tabeli z `OSOBA` na `PERSON`"

```sql
ALTER TABLE OSOBA
    RENAME TO PERSON;
```

Tworzymy bazę danych `STUDIOZSL`. Używamy klauzuli `IF NOT EXISTS`, dzięki czemu skrypt nie wyrzuci błędu, jeśli baza już istnieje.

```sql
CREATE DATABASE IF NOT EXISTS STUDIOZSL
CHARACTER SET = 'utf8'
COLLATE = 'utf8_polish_ci';
```

Tworzenie podstawowej tabeli

```sql
CREATE TABLE IF NOT EXISTS SALE (
    NRSALI VARCHAR(4),
    RODZAJ VARCHAR(30)
);
```

Tworzenie tabeli `AWARIE`:

```sql
CREATE TABLE AWARIE (
    NRZGLOSZENIA SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    DATAZGL DATE NOT NULL,
    GODZINAZGL TIME,
    SALA VARCHAR(10),
    NRKOMPA TINYINT UNSIGNED CHECK (NRKOMPA BETWEEN 1 AND 35)
);
```

Zmieniamy nazwę tabeli na `ZGLOSZENIA` oraz zawężamy pole `SALA` do 4 znaków (musi zgadzać się z typem `NRSALI` w tabeli `SALE`, aby można było je połączyć)

```sql
ALTER TABLE AWARIE
RENAME TO ZGLOSZENIA,
MODIFY COLUMN SALA VARCHAR(4) NOT NULL;
```

Łączymy tabelę `ZGLOSZENIA` z tabelą `SALE`:

```sql
ALTER TABLE ZGLOSZENIA
ADD CONSTRAINT FK_SALA
FOREIGN KEY (SALA) REFERENCES SALE(NRSALI);
```
