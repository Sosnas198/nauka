# Bazy Danych i SQL

## Podręcznik dla Początkujących

> Łatwe wyjaśnienia, życiowe analogie oraz rozbite na części proste komendy SQL

---

# 1. Wyobraź sobie bazę danych: Analogie z życia codziennego

Zanim dotkniemy jakiejkolwiek linijki kodu, musimy zrozumieć, czym w ogóle jest baza danych i dlaczego używamy jej zamiast tradycyjnego pliku w Excelu.

## Życiowa analogia: Baza danych jak doskonale zorganizowana apteka

Wyobraź sobie wielką aptekę.

Gdyby farmaceuta trzymał wszystkie informacje o lekach, pacjentach, receptach i dostawcach na jednej ogromnej kartce papieru, szybko powstałby chaos.

Zamiast tego apteka używa **szuflad i segregatorów**. Jeden segregator zawiera listę leków, drugi listę producentów, a trzeci historię sprzedaży.

Co najważniejsze – te segregatory są ze sobą powiązane (np. przy leku jest napisane ID producenta, zamiast przepisywać całe dane firmy za każdym razem).

To jest właśnie **Relacyjna Baza Danych**.

## Dlaczego nie po prostu Excel / Arkusz?

Excel jest świetny dla jednej osoby.

Ale baza danych pozwala tysiącom użytkowników naraz przeglądać i edytować dane, pilnuje, aby nikt nie wpisał litery w miejscu przeznaczonym na cenę, oraz potrafi błyskawicznie przeszukiwać miliony rekordów.

---

# 2. Anatomia Tabeli – Jak przechowywane są dane?

Podstawową jednostką w bazie danych jest **Tabela**.

Spójrzmy na dane z Twojego pliku leki.txt przedstawione w czytelny sposób:

## Szczegółowe rozłożenie tabeli na czynniki pierwsze

### Wiersz (Rekord)

Każda pojedyncza poziomka linijka. Reprezentuje jeden konkretny obiekt – np. wiersz nr 5 opisuje wyłącznie Aspirynę.

| IDLEKU (Klucz Główny) | PRODUCENT             | NAZWAMIEDZYNARODOWA        | NAZWAPREPARATU | REFUNDACJA (%) | JEDNOSTKACHOROBOWA |
| --------------------- | --------------------- | -------------------------- | -------------- | -------------- | ------------------ |
| 1                     | Solvay Pharmaceutical | Betahistine dihydrochlorid | Betaserc       | 30             | NULL               |
| 2                     | Sandoz                | Cefadroxil                 | Biodroxil      | 50             | NULL               |
| 3                     | Servier               | Fusafungine                | Bioparox       | 0              | NULL               |
| 4                     | Hasco                 | Paracetamolum              | Paracetamol    | 0              | NULL               |
| 5                     | Bayer                 | Kwas acetylosalicylowy     | Aspirin        | 0              | NULL               |

### Kolumna (Pole)

Pionowy podział. Definiuje pojedynczą cechę obiektu (np. tylko cenę, tylko producenta).

Wszystkie wpisy w kolumnie muszą być tego samego typu.

### Klucz Główny (Primary Key - PK)

Zauważ kolumnę IDLEKU.

Każdy lek ma swój unikalny numer (1, 2, 3...). To niezwykle ważne!

Nazwa preparatu mogłaby się powtórzyć lub zmienić, ale ID jednoznacznie identyfikuje konkretny wiersz.

### Wartość NULL (Brak danych)

W kolumnie JEDNOSTKACHOROBOWA widnieje napis NULL.

Co to znaczy?

NULL nie oznacza zera, ani pustego tekstu ("")!

NULL oznacza: "Tu jeszcze nic nie wpisano / dane są nieznane".

To tak, jakby w formularzu papierowym pozostawić puste pole do późniejszego uzupełnienia.

---

# 3. SQL – Język Rozmowy z Baza Danych

SQL (skrót od Structured Query Language) to język, za pomocą którego wydajemy komendy bazie danych.

Nie musimy pisać skomplikowanych programów – SQL składa się z prostych anglojęzycznych poleceń, takich jak "STWÓRZ", "WYBIERZ", "WSTAW", "ZMIEŃ".

---

# 4. Tworzenie Tabeli – Komenda `CREATE TABLE`

Zanim wstawimy pierwsze leki, musimy wybudować "pudełko" i określić, co i w jakim formacie będziemy w nim trzymać.

## Dokładne wyjaśnienie słowo po słowie

### `CREATE TABLE LEKI (...)`

Mówimy bazie: "Stwórz nową tabelę i nazwij ją LEKI".

W nawiasie wymieniamy wszystkie kolumny.

### `IDLEKU INT PRIMARY KEY`

Tworzymy kolumnę o nazwie IDLEKU.

Typ INT (od angielskiego Integer) oznacza, że będą tu wpisywane wyłącznie liczby całkowite (np. 1, 2, 3).

Słowa PRIMARY KEY określają tę kolumnę jako identyfikator główny.

### `PRODUCENT VARCHAR(100) NOT NULL`

VARCHAR(100) oznacza tekst o maksymalnej długości 100 znaków.

Dopisek NOT NULL to zakaz – baza nie pozwoli zapisać leku, jeśli nie podasz jego producenta!

### `REFUNDACJA INT DEFAULT 0`

Refundacja jest liczbą (procentem).

DEFAULT 0 oznacza automatyczną regułę: jeśli podczas dodawania leku pominiemy refundację, baza sama wstawi tam cyfrę 0.

## Zapytanie SQL: Tworzenie struktury tabeli LEKI

```sql
CREATE TABLE LEKI (
IDLEKU INT PRIMARY KEY,
PRODUCENT VARCHAR(100) NOT NULL,
NAZWAMIEDZYNARODOWA VARCHAR(150),
NAZWAPREPARATU VARCHAR(100) NOT NULL,
REFUNDACJA INT DEFAULT 0,
JEDNOSTKACHOROBOWA VARCHAR(100)
);

```

---

# 5. Wstawianie Danych – Komenda `INSERT INTO`

Mamy już pustą tabelę. Czas napełnić ją rekordami z Twojego pliku źródłowego.

## Jak to działa?

Komenda INSERT INTO LEKI wskazuje, do jakiej tabeli dokładamy wiersz.

Pierwszy nawias określa kolejność kolumn, a sekcja VALUES (...) zawiera konkretne wartości.

Zauważ, że tekst zawsze piszemy w pojedynczych cudzysłowach (np. 'Bayer'), a liczby podajemy bez cudzysłowów (30, 0).

## Zapytanie SQL: Dodawanie nowych wierszy

```sql
-- Przykład 1: Wstawiamy pełny rekord (wszystkie dane)
INSERT INTO LEKI (IDLEKU, PRODUCENT, NAZWAMIEDZYNARODOWA, NAZWAPREPARATU, REFUNDACJA,
JEDNOSTKACHOROBOWA)
VALUES (1, 'Solvay Pharmaceutical', 'Betahistine dihydrochlorid', 'Betaserc', 30, NULL);
-- Przykład 2: Wstawiamy dane z pominięciem ostatniej kolumny
INSERT INTO LEKI (IDLEKU, PRODUCENT, NAZWAMIEDZYNARODOWA, NAZWAPREPARATU, REFUNDACJA)
VALUES (5, 'Bayer', 'Kwas acetylosalicylowy', 'Aspirin', 0);

```

---

# 6. Pobieranie i Filtrowanie Danych – Komenda `SELECT`

To najważniejsza komenda w SQL.

Służy do "odpytywania" bazy i wyciągania z niej potrzebnych informacji.

## Lekcja 6.1: Pobranie wszystkiego vs Wybór kolumn

## Lekcja 6.2: Filtrowanie warunkowe – Klauzula `WHERE`

Rzadko chcemy oglądać całą bazę naraz.

Najczęściej szukamy konkretnych rzeczy za pomocą słowa WHERE (co po angielsku oznacza "gdzie / pod warunkiem że").

## Lekcja 6.3: Jak szukać wartości pustych (`NULL`)?

Chcemy sprawdzić, które leki w naszej bazie nie mają jeszcze przypisanej jednostki chorobowej.

## Zapytanie SQL: Podstawowe SELECT

```sql
-- Wariant A: Pobierz WSZYSTKIE kolumny i wiersze (gwiazdka * oznacza "wszystko")
SELECT * FROM LEKI;
-- Wariant B: Wybierz tylko wybrane kolumny (bardziej eleganckie i szybsze)
SELECT NAZWAPREPARATU, PRODUCENT, REFUNDACJA FROM LEKI;

```

## Zapytanie SQL: Filtrowanie za pomocą WHERE

```sql
-- Zapytanie 1: Pokaż tylko leki, które są refundowane (refundacja większa niż 0%)
SELECT NAZWAPREPARATU, REFUNDACJA
FROM LEKI
WHERE REFUNDACJA > 0;
-- Zapytanie 2: Znajdź leki wyprodukowane przez firmę Bayer
SELECT NAZWAPREPARATU
FROM LEKI
WHERE PRODUCENT = 'Bayer';

```

## Dlaczego zapytanie z `= NULL` nie działa?

W logice baz danych NULL to niewiadoma.

Czy nieznana wartość jest równa innej nieznanej wartości?

Baza odpowiada: "Nie wiem".

Dlatego do sprawdzania braku danych używamy wyłącznie komendy IS NULL (lub IS NOT NULL).

---

# 7. Edycja Danych – Komenda `UPDATE`

Co zrobić, gdy musimy zaktualizować informacje?

Np. uzupełnić brakującą jednostkę chorobową dla leku Betaserc (który ma IDLEKU = 1)?

## NAJWIĘKSZA PUŁAPKA W SQL — Uważaj!

Zwróć uwagę na klauzulę WHERE IDLEKU = 1.

Mówi ona bazie: "Zmień jednostkę chorobową TYLKO w wierszu numer 1".

Jeśli zapomnisz napisać klauzuli WHERE i wpiszesz po prostu UPDATE LEKI SET JEDNOSTKACHOROBOWA = 'Zawroty głowy';, baza bez ostrzeżenia ustawi tę wartość dla **WSZYSTKICH LEKÓW W BAZIE!**

---

# 8. Modyfikacja Struktury – Komenda `ALTER TABLE`

## Zadanie z pliku

Plik z Twojego zadania odnosi się do polecenia ALTER TABLE.

Służy ono do zmieniania budowy tabeli, która już istnieje (np. kiedy do gotowej tabeli chcemy dodać nową kolumnę z datą ważności leku).

### `ALTER TABLE LEKI`

"Zmień strukturę istniejącej tabeli LEKI".

### `ADD CENA`

"Dodaj do niej nową kolumnę o nazwie CENA".

### `DECIMAL(10, 2)`

Typ danych idealny do pieniędzy!

Oznacza liczbę, która ma maksymalnie 10 cyfr, z czego dokładnie 2 po przecinku (np. 45.99).
