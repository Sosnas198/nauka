# Bazy danych i SQL od zera — na przykładzie systemu hotelowego

> Ten dokument tłumaczy krok po kroku, jak działa baza danych, na podstawie
> przykładowego zadania „Firma Hotelowa" (tabele HOTEL, ROOM, BOOKING, GUEST).
> Poziom: **totalny początkujący**. Każde polecenie SQL rozłożone jest na
> czynniki pierwsze — nie musisz znać żadnych wcześniejszych pojęć.

---

## 1. Czym w ogóle jest baza danych?

Wyobraź sobie recepcję hotelową, która zamiast segregatorów papierowych
trzyma wszystko w komputerze: listę hoteli, listę pokoi, listę gości i listę
rezerwacji. Baza danych to właśnie taki elektroniczny „magazyn" informacji,
zorganizowany w **tabele** — coś jak arkusze Excela, ale połączone ze sobą
logicznie i pilnujące, żeby dane się nie posypały (np. żeby nie dało się
zarezerwować pokoju, który nie istnieje).

**MySQL** to program (silnik bazodanowy), który przechowuje i obsługuje takie
tabele. **phpMyAdmin** (widoczny na zrzutach ekranu w Twoim zadaniu) to
strona internetowa, która pozwala klikać po tej bazie myszką zamiast pisać
wszystko ręcznie — ale pod spodem i tak wykonują się te same komendy SQL,
które omówimy niżej.

**SQL** (Structured Query Language) to język, w którym „rozmawiamy" z bazą
danych. Nie jest to język programowania w stylu Python/Java — to raczej
zestaw poleceń typu: „stwórz mi tabelę", „dodaj wiersz", „pokaż mi dane",
„zmień to", „usuń tamto".

Cztery podstawowe operacje na danych mają nawet swój skrót: **CRUD**

- **C**reate (INSERT) – dodawanie danych
- **R**ead (SELECT) – odczyt danych
- **U**pdate (UPDATE) – zmiana danych
- **D**elete (DELETE) – usuwanie danych

Do tego dochodzą polecenia, które nie dotyczą samych danych, tylko
**struktury** bazy (czyli tabel) — to tzw. **DDL** (Data Definition
Language): `CREATE TABLE`, `DROP TABLE` itd.

---

## 2. Projekt bazy — dlaczego są aż 4 tabele?

Zanim przejdziemy do kodu, warto zrozumieć **po co** rozbito dane na cztery
osobne tabele, zamiast trzymać wszystko w jednej wielkiej tabeli.

| Tabela  | Co przechowuje                                    |
| ------- | ------------------------------------------------- |
| HOTEL   | Dane samych hoteli (numer, nazwa, adres)          |
| ROOM    | Pokoje należące do konkretnego hotelu             |
| GUEST   | Dane gości (klientów)                             |
| BOOKING | Rezerwacje — łączy hotel, pokój i gościa w czasie |

Gdybyśmy trzymali wszystko w jednej tabeli, dane hotelu (nazwa, adres)
musiałyby się powtarzać przy każdej rezerwacji tego hotelu — to marnotrawstwo
miejsca i prosta droga do błędów (np. raz wpiszesz „Poznan", raz „Poznań").
Dlatego dzielimy dane na logiczne kawałki i **łączymy je numerami ID**
(Hotel_No, Room_No, Guest_No). To jest właśnie sedno tzw. **relacyjnych baz
danych** — tabele są ze sobą powiązane (zrelacjonowane) przez wspólne
kolumny-identyfikatory.

Na zrzucie z Twojego pliku (punkt 3) widać dokładnie te cztery tabele i ich
kolumny — to jest tzw. **schemat bazy danych** (diagram ERD, Entity
Relationship Diagram). Pogrubione/podkreślone pola z ikonką klucza to
**klucze główne** — o nich zaraz.

---

## 3. Tworzenie bazy danych

```sql
CREATE DATABASE IF NOT EXISTS FIRMA_HOTELOWA CHARSET utf8;
```

Rozbijmy to na części:

- `CREATE DATABASE` — „stwórz nową bazę danych" (czyli nowy, pusty
  „kontener" na tabele).
- `IF NOT EXISTS` — bardzo ważny dodatek: „ale tylko jeśli taka baza jeszcze
  nie istnieje". Bez tego, uruchomienie polecenia drugi raz zwróciłoby błąd
  („baza już istnieje!"). Dzięki `IF NOT EXISTS` możesz bezpiecznie
  uruchomić skrypt wielokrotnie.
- `FIRMA_HOTELOWA` — nazwa, jaką nadajemy naszej bazie.
- `CHARSET utf8` — mówi bazie, jakiego „alfabetu" ma używać do przechowywania
  tekstu. UTF-8 obsługuje polskie znaki (ą, ę, ż...) oraz praktycznie
  wszystkie inne języki świata. Bez tego mogłyby się psuć polskie znaki w
  adresach, np. „Warszawa" mogłoby zamienić się w krzaczki.

---

## 4. Tworzenie tabel — `CREATE TABLE`

Ogólny szablon wygląda tak:

```sql
CREATE TABLE IF NOT EXISTS nazwa_tabeli (
    nazwa_kolumny  typ_danych  [dodatkowe_reguły],
    nazwa_kolumny2 typ_danych  [dodatkowe_reguły],
    ...
);
```

Zanim przejdziemy do konkretnych tabel z zadania, musisz poznać kilka
pojęć, które pojawiają się w każdej z nich.

### 4.1. Typy danych — czym się różnią?

W zadaniu pojawia się kilka typów liczbowych i tekstowych. To częsty punkt,
w którym początkujący się gubią, więc rozłóżmy to na czynniki pierwsze.

**Typy tekstowe:**

- `VARCHAR(20)` — tekst o zmiennej długości, maksymalnie 20 znaków. Liczba w
  nawiasie to limit, nie sztywna długość (w przeciwieństwie do `CHAR`, który
  zawsze rezerwuje tyle samo miejsca). `VARCHAR(50)` na adres pozwala na
  dłuższe teksty niż `VARCHAR(20)` na nazwę.

**Typy liczb całkowitych (im „większy" typ, tym więcej liczb pomieści, ale
też więcej miejsca zajmuje w pamięci):**

- `TINYINT` — bardzo mała liczba całkowita (zakres ok. -128 do 127, a z
  `UNSIGNED` czyli „bez znaku [minus]" — 0 do 255). Świetny na numer hotelu,
  bo raczej nie będziemy mieli 300 hoteli.
- `SMALLINT` — trochę większy zakres (bez znaku: 0 do 65535). Użyty na numer
  pokoju czy gościa.
- `MEDIUMINT` — jeszcze większy zakres (bez znaku: do ok. 16 milionów).
  Użyty przy `Book_No` (numer rezerwacji), bo rezerwacji z czasem może być
  naprawdę dużo.
- `UNSIGNED` — dopisek, który mówi „ta liczba nigdy nie będzie ujemna".
  Numer hotelu, pokoju czy gościa nigdy nie jest liczbą ujemną, więc ma to
  sens — i dodatkowo podwaja zakres dodatnich liczb, bo nie trzeba już
  „marnować" połowy zakresu na liczby ujemne.

  💡 **Wskazówka praktyczna:** dobór `TINYINT` / `SMALLINT` / `MEDIUMINT` to
  kwestia optymalizacji — projektant bazy przewiduje, ile maksymalnie
  rekordów będzie w tabeli, i dobiera najmniejszy typ, który to pomieści.
  Ucząc się, możesz na start zawsze używać `INT`, jeśli nie chcesz się na
  razie tym przejmować — działanie będzie identyczne, tylko baza zajmie
  odrobinę więcej miejsca na dysku.

**Typ na pieniądze:**

- `DECIMAL(6,2)` — liczba z dokładnie określoną liczbą miejsc po przecinku.
  `6` to łączna liczba cyfr, `2` to liczba cyfr po przecinku — czyli mieści
  liczby od `-9999.99` do `9999.99`. Do cen **nigdy** nie używa się typów
  zmiennoprzecinkowych typu `FLOAT`, bo te potrafią wprowadzać drobne błędy
  zaokrągleń (np. 100.00 zapisane jako 99.999999...), co przy pieniądzach
  jest niedopuszczalne. `DECIMAL` jest zawsze dokładny.

**Typ na wybór z listy:**

- `ENUM('S', 'D', 'F')` — kolumna, która może przyjąć **tylko** jedną z
  podanych wartości — tu: S (Single/pojedynczy), D (Double/podwójny), F
  (Family/rodzinny). Jeśli ktoś spróbuje wstawić np. `'X'`, baza to odrzuci.
  To wygodny sposób na wymuszenie „listy rozwijanej" na poziomie bazy
  danych, bez potrzeby tworzenia osobnej tabeli ze słownikiem typów pokoi.

**Typ na datę:**

- `DATE` — przechowuje samą datę w formacie `RRRR-MM-DD` (np. `2015-05-01`),
  bez godziny. Jeśli potrzebowalibyśmy też godziny, użylibyśmy `DATETIME`.

### 4.2. Reguły dołączane do kolumn

- `NOT NULL` — kolumna **musi** mieć jakąś wartość, nie może zostać pusta.
  W zadaniu: nazwa hotelu, adres hotelu, numery w rezerwacji, nazwisko
  gościa — te pola są obowiązkowe.
  Odwrotnością jest **brak** tego słowa — wtedy kolumna może zostać `NULL`
  (czyli „brak wartości", co jest czymś innym niż pusty tekst `''` albo
  zero!). Właśnie dlatego goście „Stone" i „Czerkaski" mogli mieć `null`
  jako adres — pole `Address` w tabeli `Guest` nie ma `NOT NULL`.
- `UNIQUE` — wartości w tej kolumnie muszą być unikatowe w całej tabeli, czyli
  żadne dwa wiersze nie mogą mieć tej samej wartości. W zadaniu: nazwa
  hotelu (`Name`) jest `UNIQUE` — nie może być dwóch hoteli o identycznej
  nazwie.
- `PRIMARY KEY` — **klucz główny**. To najważniejsza reguła w całej tabeli:
  wskazuje kolumnę (lub kolumny), która **jednoznacznie identyfikuje** każdy
  wiersz. Klucz główny automatycznie jest unikatowy i nie może być `NULL`.
  Myśl o nim jak o numerze PESEL — nie ma dwóch osób z tym samym numerem, i
  każda osoba musi go mieć.
- `AUTO_INCREMENT` — mówi bazie „sama nadawaj kolejne numery przy każdym
  nowym wierszu (1, 2, 3, 4...)". Używamy tego przy `Book_No` w tabeli
  `BOOKING`, bo nie chcemy ręcznie wymyślać numeru rezerwacji za każdym
  razem — baza zrobi to sama.

### 4.3. Klucz prosty vs. klucz złożony (composite key)

Spójrzmy na dwie tabele z zadania:

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

Tutaj klucz główny składa się z **dwóch** kolumn naraz — to tzw. **klucz
złożony**. Dlaczego? Bo samo `Room_No` = 1 nie jest unikatowe — w hotelu
„Grosvenor" jest pokój nr 1, ale w hotelu „Merkury" też jest pokój nr 1
(zobacz dane w punkcie 4 zadania: `1,1,D,100.00` i `1,2,S,100.00` — pierwsza
kolumna to numer pokoju, druga to numer hotelu). Dopiero **para** (numer
pokoju + numer hotelu) jest unikatowa — to jest właśnie sens klucza
złożonego: żadne dwa wiersze nie mogą mieć **jednocześnie** tego samego
`Room_No` i tego samego `Hotel_No`.

To jednocześnie pokazuje, jak `Hotel_No` w tabeli `ROOM` pełni rolę
„łącznika" do tabeli `HOTEL` — mówiąc fachowo, jest to tzw. **klucz obcy**
(foreign key), nawet jeśli w tym konkretnym zadaniu nie zdefiniowano go
formalnie słowem `FOREIGN KEY` (co dałoby dodatkowe zabezpieczenie: baza
sama pilnowałaby, żeby nie dało się dodać pokoju do nieistniejącego hotelu).
Warto to zapamiętać jako możliwe rozszerzenie tego zadania na przyszłość.

### 4.4. Tabela BOOKING — najbardziej złożona

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

To jest tabela, która **łączy** trzy inne tabele: mówi „ten gość zarezerwował
ten pokój w tym hotelu, w takim a takim terminie". `Book_No` jest kluczem
głównym z automatyczną numeracją — nie musisz go samodzielnie wpisywać przy
`INSERT`, baza sama go nada.

---

## 5. Wstawianie danych — `INSERT INTO`

```sql
INSERT INTO hotel VALUES
(1, 'Grosvenor Hotel', 'London'),
(2, 'Merkury Hotel', 'Poznan'),
(3, 'NovoTel', 'Poznan');
```

- `INSERT INTO nazwa_tabeli` — „wstaw nowy wiersz do tej tabeli".
- `VALUES (...)` — lista wartości, **w takiej samej kolejności**, w jakiej
  zdefiniowano kolumny przy `CREATE TABLE` (tu: Hotel_No, Name, Address).
- Można wstawić od razu kilka wierszy, oddzielając je przecinkami — dokładnie
  tak, jak wyżej.

Bezpieczniejszy wariant, jawnie wskazujący nazwy kolumn (przydatny, gdy nie
chcemy podawać wszystkich kolumn albo boimy się pomyłki w kolejności):

```sql
INSERT INTO BOOKING (Hotel_No, Room_No, Guest_No, Date_From, Date_To)
VALUES ('Merkury', 2, 'Schmit', '2015-05-01', '2015-05-03');
```

⚠️ **Uwaga dydaktyczna:** w Twoim pliku z rozwiązaniem to zapytanie wstawia
tekst `'Merkury'` i `'Schmit'` zamiast liczbowych identyfikatorów (`Hotel_No`
i `Guest_No` są przecież typu liczbowego, np. `tinyint`/`SMALLINT`). To
zadziała tylko dlatego, że MySQL w pewnych trybach „na siłę" konwertuje tekst
na liczbę (zwykle na `0`, jeśli tekst nie wygląda jak liczba) — czyli **nie**
zapisze się tam naprawdę numer hotelu Merkury ani numer gościa Schmit, tylko
prawdopodobnie same zera. Poprawnie powinno to wyglądać tak:

```sql
INSERT INTO BOOKING (Hotel_No, Room_No, Guest_No, Date_From, Date_To)
VALUES (2, 2, 3, '2015-05-01', '2015-05-03');
-- 2 = numer hotelu Merkury, 2 = numer pokoju, 3 = numer gościa Schmit
```

To bardzo częsty błąd początkujących — warto zawsze sprawdzać, czy typ
wstawianej wartości pasuje do typu kolumny.

### Import danych z pliku CSV

W zadaniu poleca się przygotować dane do tabeli `ROOM` w pliku `.csv`
(czyli zwykłym pliku tekstowym, gdzie wartości są oddzielone przecinkami,
np. `1,1,D,100.00`) i zaimportować go przez phpMyAdmin (zakładka „Importuj").
To po prostu szybszy sposób na wstawienie wielu wierszy naraz, zamiast
pisania ośmiu osobnych poleceń `INSERT INTO`. Efekt końcowy w bazie jest
identyczny, jakbyś ręcznie wpisał te 8 rekordów przez `INSERT INTO room
VALUES (...)`.

---

## 6. Odczyt danych — `SELECT`

```sql
SELECT * FROM guest;
```

- `SELECT` — „pokaż mi dane".
- `*` — gwiazdka oznacza „wszystkie kolumny". Można też wypisać konkretne,
  np. `SELECT Name, Address FROM guest;`, jeśli nie potrzebujesz wszystkiego.
- `FROM guest` — z której tabeli mamy pobrać dane.

To polecenie zwraca **wszystkie** wiersze tabeli `guest` — dokładnie to
widać na zrzucie ekranu w punkcie 5 zadania: pięciu gości z ich imionami i
adresami (w tym dwa `null` tam, gdzie adresu nie podano).

Gdybyś chciał pokazać tylko gości z konkretnego miasta, dodałbyś warunek:

```sql
SELECT * FROM guest WHERE Address LIKE '%Warszawa%';
```

(`WHERE` filtruje wiersze, `LIKE '%...%'` szuka fragmentu tekstu w
środku — o tym więcej w sekcji o `UPDATE`/`DELETE` poniżej, bo tam `WHERE`
jest kluczowe).

---

## 7. Aktualizacja danych — `UPDATE`

To polecenie **zmienia** już istniejące dane (nie dodaje nowych wierszy).
Ma zawsze ten sam szkielet:

```sql
UPDATE nazwa_tabeli
SET kolumna = nowa_wartość
WHERE warunek;
```

**Bardzo ważne:** klauzula `WHERE` mówi, **które** wiersze mają zostać
zmienione. Jeśli ją pominiesz, `UPDATE` zmieni wartość we **wszystkich**
wierszach tabeli — to jeden z najniebezpieczniejszych błędów w SQL, bo nie
ma cofnięcia (undo) po wykonaniu zapytania!

Przykład z zadania:

```sql
UPDATE room
SET room.PRICE = room.PRICE / 2
WHERE HOTEL_NO = 1;
```

Co się tu dzieje:

- `SET room.PRICE = room.PRICE / 2` — nowa cena to **stara cena podzielona
  przez 2**. Zwróć uwagę: po prawej stronie `=` możesz odwoływać się do
  aktualnej wartości tej samej kolumny — baza najpierw czyta starą wartość,
  potem liczy nową.
- `WHERE HOTEL_NO = 1` — ale robimy to **tylko** dla pokoi należących do
  hotelu nr 1 (czyli Grosvenor — zgodnie z danymi z punktu 4: `1, Grosvenor
Hotel, London`). Pokoje pozostałych hoteli zostają nietknięte.

Drugi przykład — zmiana daty rezerwacji pana Schmidta:

```sql
UPDATE booking
SET date_from = '2015-05-08', date_to = '2015-05-10'
WHERE GUEST_NO = 3
  AND date_from = '2015-05-01'
  AND date_to = '2015-05-03';
```

- `SET date_from = ..., date_to = ...` — tym razem zmieniamy **dwie**
  kolumny naraz, oddzielając je przecinkiem.
- `WHERE GUEST_NO = 3 AND date_from = '2015-05-01' AND date_to =
'2015-05-03'` — trzy warunki połączone słowem `AND` (czyli „i", wszystkie
  muszą być spełnione naraz). Dlaczego aż trzy warunki, skoro `GUEST_NO = 3`
  mogłoby wystarczyć? Bo w bardziej rozbudowanej bazie ten sam gość mógłby
  mieć **kilka** różnych rezerwacji — dodatkowe warunki na daty precyzują,
  że chcemy zmienić dokładnie **tę jedną, konkretną** rezerwację, a nie
  wszystkie rezerwacje pana Schmidta naraz.

  Trzecia poprawka z zadania (cena pokoju nr 1 w hotelu Merkury na 80.00)
  wyglądałaby analogicznie:

  ```sql
  UPDATE room
  SET PRICE = 80.00
  WHERE HOTEL_NO = 2 AND ROOM_NO = 1;
  ```

---

## 8. Usuwanie danych — `DELETE`

Podobnie jak przy `UPDATE`, tu też **kluczowe** jest `WHERE` — bez niego
`DELETE FROM tabela;` skasuje **wszystkie** wiersze tabeli!

```sql
DELETE FROM room WHERE room.HOTEL_NO = 2 AND room.ROOM_NO = 4;
```

„Usuń z tabeli `room` ten wiersz (a właściwie te wiersze, choć tu wychodzi
dokładnie jeden), gdzie numer hotelu to 2, a numer pokoju to 4" — czyli
dokładnie ten punkt z zadania: „usunąć dane pokoju 4 z hotelu Merkury".

```sql
DELETE FROM guest WHERE guest.GUEST_NO = 5;
```

Usuwa gościa o numerze 5 (Czerkaski) — cała kolumna warunku odwołuje się
tu do klucza głównego, więc mamy pewność, że usuniemy dokładnie jeden,
konkretny wiersz.

Żeby usunąć **wszystkie** rezerwacje (ale zostawić samą tabelę, pustą, gotową
na nowe dane), robimy to świadomie, bez `WHERE`:

```sql
DELETE FROM booking;
```

To różni się od kolejnego punktu — usunięcia całej tabeli — w bardzo istotny
sposób, patrz niżej.

---

## 9. Usuwanie całej tabeli — `DROP TABLE`

```sql
DROP TABLE booking;
```

To **zupełnie inna operacja** niż `DELETE`:

|                                 | `DELETE FROM booking;`   | `DROP TABLE booking;`                            |
| ------------------------------- | ------------------------ | ------------------------------------------------ |
| Co usuwa                        | tylko **wiersze** (dane) | całą **tabelę** — strukturę i dane               |
| Czy tabela nadal istnieje potem | tak, jest pusta          | nie, trzeba ją stworzyć na nowo (`CREATE TABLE`) |
| Kolumny, klucze, typy danych    | zostają bez zmian        | znikają razem z tabelą                           |

Innymi słowy: `DELETE` to jak wyrzucenie wszystkich kartek z segregatora
(segregator zostaje), a `DROP TABLE` to zniszczenie samego segregatora.

---

## 10. Podsumowanie — ściąga najważniejszych poleceń

| Polecenie                  | Do czego służy                 | Przykład z zadania                                          |
| -------------------------- | ------------------------------ | ----------------------------------------------------------- |
| `CREATE DATABASE`          | tworzy nową bazę danych        | `CREATE DATABASE IF NOT EXISTS FIRMA_HOTELOWA...`           |
| `CREATE TABLE`             | tworzy nową tabelę (strukturę) | `CREATE TABLE IF NOT EXISTS HOTEL (...)`                    |
| `INSERT INTO`              | dodaje nowe wiersze danych     | `INSERT INTO hotel VALUES (1, 'Grosvenor Hotel', 'London')` |
| `SELECT`                   | odczytuje/wyświetla dane       | `SELECT * FROM guest;`                                      |
| `UPDATE ... SET ... WHERE` | zmienia istniejące dane        | `UPDATE room SET PRICE = PRICE/2 WHERE HOTEL_NO=1;`         |
| `DELETE FROM ... WHERE`    | usuwa wiersze danych           | `DELETE FROM guest WHERE GUEST_NO=5;`                       |
| `DROP TABLE`               | usuwa całą tabelę              | `DROP TABLE booking;`                                       |

### Najważniejsze pojęcia do zapamiętania

- **Klucz główny (PRIMARY KEY)** — jednoznacznie identyfikuje wiersz;
  może być prosty (1 kolumna) lub złożony (kilka kolumn razem).
- **Klucz obcy** — kolumna, która odwołuje się do klucza głównego innej
  tabeli i łączy ze sobą tabele (np. `Hotel_No` w `ROOM` wskazuje na
  `Hotel_No` w `HOTEL`).
- **NOT NULL** — pole obowiązkowe. **UNIQUE** — wartości nie mogą się
  powtarzać. **AUTO_INCREMENT** — baza sama numeruje kolejne wiersze.
- **`WHERE` w `UPDATE`/`DELETE` to bezpiecznik** — jego brak = operacja na
  całej tabeli naraz. Zawsze sprawdzaj warunek `WHERE`, zanim wciśniesz
  „wykonaj", zwłaszcza przy `DELETE`.
- **Relacyjna baza danych** = wiele małych, powiązanych tabel zamiast jednej
  wielkiej — mniej powtórzeń danych, mniej błędów, łatwiejsze utrzymanie.

### Typowe błędy początkujących (na bazie tego zadania)

1. Wpisywanie tekstu tam, gdzie kolumna oczekuje liczby (patrz uwaga przy
   `INSERT INTO BOOKING` z wartością `'Merkury'` zamiast numeru hotelu).
2. Zapomnienie o `WHERE` przy `UPDATE`/`DELETE` — ryzyko nadpisania/skasowania
   całej tabeli.
3. Mylenie `DELETE` (kasuje dane) z `DROP TABLE` (kasuje całą tabelę).
4. Niepilnowanie kolejności wartości w `INSERT INTO tabela VALUES (...)` bez
   podania nazw kolumn — łatwo pomylić kolejność i wstawić dane w złe pola.

---

_Ten dokument powstał jako materiał edukacyjny na bazie zadania z tworzenia
bazy danych „Firma Hotelowa" — nie jest kopią treści zadania, tylko jego
wyjaśnieniem krok po kroku, tak by można było zrozumieć logikę i samodzielnie
rozwiązać podobne zadania w przyszłości._
