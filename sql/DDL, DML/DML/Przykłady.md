Tworzenie bazy danych

```sql
CREATE DATABASE IF NOT EXISTS FIRMA_HOTELOWA CHARSET utf8;
```

Tworzenie tabeli

```sql
CREATE TABLE IF NOT EXISTS HOTEL (
    Hotel_No tinyint unsigned,
    Name varchar(20) not null UNIQUE,
    Address varchar(50) not null,
    PRIMARY KEY (Hotel_No)
);
```

Tutaj klucz główny to **jedna** kolumna: `Hotel_No`. Każdy hotel ma swój
unikalny numer i to wystarczy, żeby go jednoznacznie zidentyfikować.

```sql
CREATE TABLE IF NOT EXISTS ROOM (
    Room_No SMALLINT unsigned,
    Hotel_No tinyint unsigned,
    Type enum('S', 'D', 'F'),
    Price decimal(6, 2),
    PRIMARY KEY (Room_No, Hotel_No)
);
```

Tabela BOOKING — najbardziej złożona

```sql
CREATE TABLE IF NOT EXISTS BOOKING (
    Book_No mediumint PRIMARY KEY AUTO_INCREMENT,
    Hotel_No tinyint not null,
    Room_No SMALLINT not null,
    Guest_No SMALLINT not null,
    Date_From date,
    Date_To date
);
```

Wstawianie danych — `INSERT INTO`

```sql
INSERT INTO hotel VALUES
(1, 'Grosvenor Hotel', 'London'),
(2, 'Merkury Hotel', 'Poznan'),
(3, 'NovoTel', 'Poznan');
```

Bezpieczniejszy wariant, jawnie wskazujący nazwy kolumn (przydatny, gdy nie
chcemy podawać wszystkich kolumn albo boimy się pomyłki w kolejności):

```sql
INSERT INTO BOOKING (Hotel_No, Room_No, Guest_No, Date_From, Date_To)
VALUES ('Merkury', 2, 'Schmit', '2015-05-01', '2015-05-03');
```

To bardzo częsty błąd początkujących — warto zawsze sprawdzać, czy typ
wstawianej wartości pasuje do typu kolumny.

```sql
INSERT INTO BOOKING (Hotel_No, Room_No, Guest_No, Date_From, Date_To)
VALUES (2, 2, 3, '2015-05-01', '2015-05-03');
-- 2 = numer hotelu Merkury, 2 = numer pokoju, 3 = numer gościa Schmit
```

Aktualizacja danych — `UPDATE`

```sql
UPDATE nazwa_tabeli
SET kolumna = nowa_wartość
WHERE warunek;
```

**Bardzo ważne:** klauzula `WHERE` mówi, **które** wiersze mają zostać
zmienione. Jeśli ją pominiesz, `UPDATE` zmieni wartość we **wszystkich**
wierszach tabeli — to jeden z najniebezpieczniejszych błędów w SQL, bo nie
ma cofnięcia (undo) po wykonaniu zapytania!

```sql
UPDATE room
SET room.PRICE = room.PRICE / 2
WHERE HOTEL_NO = 1;
```

```sql
UPDATE booking
SET date_from = '2015-05-08', date_to = '2015-05-10'
WHERE GUEST_NO = 3
  AND date_from = '2015-05-01'
  AND date_to = '2015-05-03';
```

```sql
UPDATE room
SET PRICE = 80.00
WHERE HOTEL_NO = 2 AND ROOM_NO = 1;
```

Podobnie jak przy `UPDATE`, tu też **kluczowe** jest `WHERE` — bez niego
`DELETE FROM tabela;` skasuje **wszystkie** wiersze tabeli!

```sql
DELETE FROM room WHERE room.HOTEL_NO = 2 AND room.ROOM_NO = 4;
```

```sql
DELETE FROM guest WHERE guest.GUEST_NO = 5;
```

Żeby usunąć **wszystkie** rezerwacje (ale zostawić samą tabelę, pustą, gotową
na nowe dane), robimy to świadomie, bez `WHERE`:

```sql
DELETE FROM booking;
```

Usuwanie całej tabeli — `DROP TABLE`

```sql
DROP TABLE booking;
```
