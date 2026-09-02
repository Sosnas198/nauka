# Bazy danych i SQL — kurs od podstaw

> Materiał przygotowany na podstawie Twoich zadań (tabela `Uczniowie` oraz `Towary`/`Hurtownie` w bazie `Sklepik`). Zamiast powtarzać gotowe komendy, wyjaśniamy **dlaczego** działają tak, a nie inaczej — żebyś w przyszłości sam(a) potrafił(a) napisać podobne zapytanie od zera.

---

## 1. Czym w ogóle jest baza danych

Baza danych to uporządkowany magazyn informacji, podzielony na **tabele**. Tabela wygląda jak arkusz w Excelu:

- **kolumny (pola)** — określają, jaki rodzaj informacji przechowujemy (np. imię, cena, klasa),
- **wiersze (rekordy)** — to pojedyncze "rzeczy" opisane tymi kolumnami (np. jeden uczeń, jeden towar).

Przykład z Twojego zadania — tabela `Uczniowie`:

| NrUcznia | Imie | Nazwisko | Uwagi | Klasa |
|---|---|---|---|---|
| 1 | Jan | Kwiatkowski | NULL | 1B1T |
| 2 | Anna | Kowalska | NULL | 2B2T |

Językiem, którym "rozmawiamy" z bazą danych (tworzymy tabele, dodajemy, zmieniamy, usuwamy i wyszukujemy dane), jest **SQL** (Structured Query Language). To nie jest język programowania w stylu Pythona — to język **poleceń** wydawanych bazie danych: mówisz *co* ma się stać, a silnik bazy (np. MySQL) sam decyduje *jak* to zrobić.

Każde polecenie SQL kończymy średnikiem `;` — to jak kropka na końcu zdania, sygnał "koniec polecenia".

---

## 2. Tworzenie tabeli — `CREATE TABLE`

To pierwsza rzecz, którą robisz z nową tabelą — definiujesz jej "szkielet": jakie kolumny będzie miała i jakiego typu dane w nich przechowujemy.

```sql
CREATE TABLE IF NOT EXISTS Uczniowie (
    NrUcznia INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
    Imie VARCHAR(20),
    Nazwisko VARCHAR(20) NOT NULL,
    Uwagi VARCHAR(40),
    Klasa VARCHAR(4) NOT NULL
);
```

Rozbijmy to na czynniki pierwsze, bo w tej jednej komendzie jest naprawdę dużo informacji.

### 2.1. `IF NOT EXISTS`

Bez tego dopisku, jeśli spróbujesz utworzyć tabelę, która już istnieje, MySQL zwróci błąd i przerwie działanie. `IF NOT EXISTS` mówi: "utwórz tę tabelę, ale **tylko jeśli jeszcze jej nie ma** — jeśli już istnieje, po prostu nic nie rób, nie zgłaszaj błędu". To bardzo przydatne zabezpieczenie, gdy uruchamiasz skrypt kilka razy z rzędu (np. testując coś) — nie wywali Ci się cały skrypt na drugiej linijce.

### 2.2. Typy danych

Każda kolumna musi mieć zadeklarowany typ — to informacja dla bazy, ile miejsca zarezerwować i jakie operacje mają sens:

| Typ | Co przechowuje | Przykład |
|---|---|---|
| `INT` | liczba całkowita | 1, 2, 100 |
| `VARCHAR(n)` | tekst o zmiennej długości, max `n` znaków | `VARCHAR(20)` → max 20 znaków |
| `DECIMAL(m,d)` | liczba stałoprzecinkowa: `m` cyfr łącznie, `d` po przecinku | `DECIMAL(6,2)` → np. 1234.56 |

`VARCHAR` (variable character) w przeciwieństwie do `CHAR` nie marnuje miejsca — jeśli zadeklarujesz `VARCHAR(20)`, a wpiszesz "Jan" (3 znaki), baza nie zajmuje pełnych 20 znaków, tylko tyle ile potrzeba plus odrobinę na zapis długości.

**Dlaczego cena to `DECIMAL`, a nie zwykła liczba zmiennoprzecinkowa (`FLOAT`)?** Bo `FLOAT`/`DOUBLE` przechowują liczby w sposób przybliżony (to kwestia tego, jak komputery reprezentują ułamki w systemie binarnym) — przy pieniądzach to prosta droga do sytuacji, gdzie 10.10 zł + 0.10 zł nagle nie daje równo 10.20 zł. `DECIMAL(6,2)` gwarantuje dokładność co do grosza: 6 cyfr w sumie, z czego 2 po przecinku, czyli zakres od `-9999.99` do `9999.99`.

### 2.3. `UNSIGNED`

`INT UNSIGNED` oznacza liczbę **bez znaku**, czyli tylko nieujemną (0, 1, 2, 3...). Ma to sens dla numeru ucznia — numer ucznia nigdy nie będzie ujemny, więc od razu blokujemy taką możliwość i "za darmo" dostajemy większy zakres liczb dodatnich (bo nie trzeba rezerwować miejsca na znak minus).

### 2.4. `PRIMARY KEY` (klucz główny)

To jedna z najważniejszych koncepcji w bazach danych. Klucz główny to kolumna (lub zestaw kolumn), która **jednoznacznie identyfikuje** każdy wiersz — czyli nie mogą istnieć dwa wiersze z tą samą wartością tego pola, i pole to nigdy nie może być puste (`NULL`).

W tabeli `Uczniowie` kluczem głównym jest `NrUcznia`. Dlaczego nie np. `Nazwisko`? Bo dwóch uczniów może mieć to samo nazwisko — a numer ucznia zawsze jest unikalny, z definicji. Klucz główny to swego rodzaju "dowód osobisty" wiersza — niepowtarzalny identyfikator, po którym baza (i Ty) zawsze bez pomyłki odnajdzie właściwy rekord.

### 2.5. `AUTO_INCREMENT`

Mówi bazie: "sama licz kolejne wartości tej kolumny — nie musisz mi ich podawać przy dodawaniu nowego wiersza". Pierwszy wstawiony wiersz dostanie 1, drugi 2, i tak dalej, automatycznie. Dzięki temu nie musisz ręcznie pilnować, jaki numer jest "wolny" — a jednocześnie masz gwarancję, że nigdy się nie powtórzy.

### 2.6. `NOT NULL` vs pole opcjonalne

`NULL` w SQL nie znaczy "zero" ani "pusty tekst" — znaczy **"brak wartości / nie wiadomo"**. To ważne rozróżnienie konceptualne.

- `Nazwisko VARCHAR(20) NOT NULL` — to pole **musi** zostać wypełnione. Próba wstawienia wiersza bez nazwiska zakończy się błędem.
- `Uwagi VARCHAR(40)` (bez `NOT NULL`) — to pole jest opcjonalne. Jeśli uczeń nie ma żadnych uwag, wstawiamy tam `NULL` — czyli informację "nie dotyczy / brak danych", a nie pusty string `''` (to są dwie różne rzeczy!).

W Twoich danych widać to dokładnie: uczniowie bez specjalnych uwag mają `NULL` w kolumnie `Uwagi`, a Andrzej ma tam realny tekst `'Powtarza klasę'`.

---

## 3. Relacje między tabelami — `FOREIGN KEY` (klucz obcy)

To koncepcja, która pojawia się w zadaniu ze sklepem: masz dwie tabele, `Towary` i `Hurtownie`, i towar "należy" do jakiejś hurtowni.

```sql
CREATE TABLE IF NOT EXISTS Hurtownie (
    nazwa VARCHAR(30) PRIMARY KEY,
    adres VARCHAR(60),
    telefon VARCHAR(15)
);

CREATE TABLE IF NOT EXISTS Towary (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nazwa VARCHAR(30),
    cena DECIMAL(6,2) DEFAULT 0.0 CHECK (cena <= 1000),
    hurtownia VARCHAR(30),
    FOREIGN KEY (hurtownia) REFERENCES Hurtownie(nazwa)
);
```

### Po co to?

Zamiast w każdym wierszu tabeli `Towary` wpisywać ręcznie pełny adres i telefon hurtowni (co się powtarzałoby przy każdym towarze z tej samej hurtowni — i przy zmianie telefonu trzeba by poprawiać dziesiątki wierszy), trzymamy dane hurtowni **raz**, w osobnej tabeli. W tabeli `Towary` wpisujemy tylko `nazwa` hurtowni jako "wskaźnik" do właściwego wiersza w `Hurtownie`.

`FOREIGN KEY (hurtownia) REFERENCES Hurtownie(nazwa)` to właśnie deklaracja tego powiązania — mówi bazie: "wartość w kolumnie `hurtownia` tabeli `Towary` musi odpowiadać jakiejś istniejącej wartości w kolumnie `nazwa` tabeli `Hurtownie`". Dzięki temu baza sama pilnuje spójności danych — nie pozwoli Ci dodać towaru z hurtownią, która nie istnieje w tabeli `Hurtownie` (literówka w nazwie hurtowni zostanie odrzucona), i domyślnie nie pozwoli usunąć hurtowni, dopóki są przypisane do niej towary.

To jest właśnie sedno "relacyjnych" baz danych (stąd nazwa: relational database) — dane w różnych tabelach są ze sobą powiązane (są w *relacji*), zamiast być zduplikowane wszędzie.

---

## 4. Ograniczenia (constraints) — pilnowanie jakości danych

### 4.1. `DEFAULT`

`DEFAULT 0.0` mówi: jeśli przy wstawianiu nowego towaru nie podasz ceny, baza sama wpisze `0.0`. To wygodne zabezpieczenie przed brakującymi danymi.

### 4.2. `CHECK`

`CHECK (cena <= 1000)` to warunek, który baza sprawdza **przy każdej próbie zapisu**. Jeśli spróbujesz wstawić lub zaktualizować towar z ceną 1500, baza odrzuci tę operację. To pilnowanie reguł biznesowych na poziomie samej bazy danych — nawet jeśli ktoś ominie Twoją aplikację i wpisze dane wprost do bazy, reguła i tak zadziała.

---

## 5. Dodawanie danych — `INSERT INTO`

```sql
INSERT INTO Uczniowie (NrUcznia, Imie, Nazwisko, Uwagi, Klasa)
VALUES
    (1, 'Jan', 'Kwiatkowski', NULL, '1B1T'),
    (2, 'Anna', 'Kowalska', NULL, '2B2T'),
    (3, 'Andrzej', 'Kowacz', 'Powtarza klasę', '2B2T');
```

Struktura jest zawsze taka sama: **nazwa tabeli → lista kolumn w nawiasie → słowo `VALUES` → lista wartości w nawiasach, w tej samej kolejności co kolumny**.

Kilka rzeczy wartych zapamiętania:
- Wartości tekstowe zawsze w apostrofach: `'Jan'`. Liczby — bez apostrofów: `1`.
- `NULL` piszemy bez apostrofów — to nie jest tekst "NULL", to specjalne słowo kluczowe oznaczające brak wartości.
- Jednym poleceniem `INSERT` można wstawić **wiele wierszy naraz** — wystarczy oddzielić kolejne krotki przecinkami, dokładnie jak w przykładzie z 5 uczniami.
- Skoro `NrUcznia` ma `AUTO_INCREMENT`, technicznie mogłabyś/mógłbyś pominąć tę kolumnę w ogóle i pozwolić bazie samej ją wyliczyć — tutaj podano ją jawnie, bo akurat te konkretne numery były częścią zadania.

---

## 6. Odczyt danych — `SELECT`

```sql
SELECT * FROM Uczniowie;
```

To najczęściej używane polecenie w SQL. Gwiazdka `*` oznacza "wszystkie kolumny". Gdybyś chciał(a) tylko imiona i nazwiska:

```sql
SELECT Imie, Nazwisko FROM Uczniowie;
```

A gdybyś chciał(a) tylko uczniów z konkretnej klasy — dochodzi `WHERE`, czyli warunek filtrujący:

```sql
SELECT * FROM Uczniowie WHERE Klasa = '2B2T';
```

`SELECT` nigdy nie zmienia danych w tabeli — tylko je odczytuje i pokazuje. To najbezpieczniejsze polecenie w całym SQL-u.

---

## 7. Filtrowanie warunkami złożonymi — `WHERE`, `AND`, `OR`

Z Twojego zadania (usuwanie dwóch konkretnych uczniów naraz):

```sql
DELETE FROM Uczniowie
WHERE (Imie = 'Monika' AND Nazwisko = 'Dobrowska')
   OR (Imie = 'Jan' AND Nazwisko = 'Kwiatkowski');
```

To warto sobie przeczytać jak zdanie po polsku: *"usuń wiersz, jeśli (imię to Monika I nazwisko to Dobrowska) LUB (imię to Jan I nazwisko to Kwiatkowski)"*.

- `AND` — **oba** warunki muszą być prawdziwe naraz (dlatego łączymy imię z nazwiskiem — samo imię "Jan" mogłoby pasować do kogoś innego).
- `OR` — wystarczy, że **jeden** z warunków (w tym wypadku jedna z dwóch osób) jest prawdziwy.
- Nawiasy `(...)` grupują warunki dokładnie tak jak w matematyce — bez nich SQL mógłby policzyć kolejność inaczej niż zamierzałeś/zamierzałaś, i np. usunąć zupełnie inne wiersze.

**Bardzo ważna uwaga bezpieczeństwa:** `DELETE` (i `UPDATE`) bez klauzuli `WHERE` działa na **wszystkich** wierszach tabeli naraz. `DELETE FROM Uczniowie;` bez warunku wyczyściłoby całą tabelę. Zawsze warto najpierw sprawdzić warunek przez `SELECT` z tym samym `WHERE`, zanim odpalisz `DELETE`/`UPDATE` — żeby zobaczyć, których wierszy to faktycznie dotknie.

---

## 8. Zmiana istniejących danych — `UPDATE`

```sql
UPDATE Uczniowie SET Klasa = '3B2T' WHERE Klasa = '2B2T';
```

Schemat: **`UPDATE` nazwa_tabeli → `SET` kolumna = nowa_wartość → `WHERE` które wiersze**.

To polecenie mówi: "we wszystkich wierszach, gdzie `Klasa` to obecnie `'2B2T'`, zmień wartość tej kolumny na `'3B2T'`". Efekt: cały rocznik "awansuje" do kolejnej klasy jednym poleceniem, zamiast edytować każdego ucznia z osobna.

Można zmieniać kilka kolumn naraz, oddzielając przecinkami:

```sql
UPDATE Towary SET cena = 4.5 WHERE id = 1;
UPDATE Towary SET cena = 6.0 WHERE id = 5;
```

A obniżka cen o 10% dla **wszystkich** towarów (bez `WHERE` — bo tu celowo chcemy objąć całą tabelę) to ładny przykład użycia wyrażenia arytmetycznego wprost w `SET`:

```sql
UPDATE Towary SET cena = cena * 0.9;
```

Czyli: "nowa cena = stara cena razy 0,9" (czyli 90% starej ceny — 10% mniej). Baza odczytuje bieżącą wartość z każdego wiersza, przelicza i zapisuje z powrotem.

---

## 9. Usuwanie danych — `DELETE` vs `TRUNCATE`

W zadaniu pojawiają się oba polecenia i to nieprzypadkowo — różnią się bardziej, niż mogłoby się wydawać:

| | `DELETE FROM tabela WHERE ...` | `TRUNCATE TABLE tabela` |
|---|---|---|
| Co usuwa | wybrane wiersze (można filtrować) | **wszystkie** wiersze, bez wyjątku |
| Warunek `WHERE` | tak, można go użyć | nie — nie da się go zastosować |
| Licznik `AUTO_INCREMENT` | zostaje tam, gdzie był | resetuje się do zera |
| Szybkość | wolniejsze (usuwa wiersz po wierszu) | znacznie szybsze (czyści całą tabelę hurtowo) |

Praktyczna konsekwencja resetu licznika: jeśli po `DELETE` dodasz nowego ucznia, dostanie kolejny wolny numer (np. 6, jeśli ostatni miał 5). Jeśli zamiast tego zrobisz `TRUNCATE`, a potem dodasz ucznia — dostanie numer 1, bo licznik `AUTO_INCREMENT` wystartował od nowa.

`TRUNCATE` to dobre narzędzie, gdy chcesz **całkowicie wyzerować** tabelę (np. po testach), a `DELETE` z `WHERE` — gdy chcesz precyzyjnie usunąć konkretne rekordy, zachowując resztę.

---

## 10. Zmiana struktury już istniejącej tabeli — `ALTER TABLE`

Czasem tabela już istnieje z danymi, a Ty chcesz zmienić jej budowę — np. rozbić jedno pole `adres` na cztery osobne: `miasto`, `kod`, `ulica`, `numer`.

```sql
ALTER TABLE Hurtownie
    DROP COLUMN adres,
    ADD COLUMN miasto VARCHAR(30),
    ADD COLUMN kod VARCHAR(6),
    ADD COLUMN ulica VARCHAR(30),
    ADD COLUMN numer VARCHAR(10);
```

`ALTER TABLE` to "chirurgia" na już istniejącej tabeli — w przeciwieństwie do `CREATE TABLE` (który definiuje ją od zera), tutaj modyfikujesz strukturę, która może już zawierać dane. Stąd trzeba być tu ostrożnym: `DROP COLUMN adres` bezpowrotnie usuwa całą kolumnę razem z danymi w niej zapisanymi u każdego wiersza. Dlatego w zadaniu jest wyraźne zastrzeżenie: *napisz to polecenie, ale go nie wykonuj* — bo to nieodwracalna operacja, dobra do przemyślenia, zanim się ją faktycznie odpali na prawdziwych danych.

---

## 11. Podgląd struktury tabeli — `DESCRIBE` / `SHOW COLUMNS`

Żeby zobaczyć, jakie kolumny ma tabela (bez oglądania jej zawartości), używa się:

```sql
DESCRIBE Hurtownie;
-- albo równoważnie:
SHOW COLUMNS FROM Hurtownie;
```

Wynik pokazuje nazwę każdej kolumny, jej typ, czy dopuszcza `NULL`, czy jest kluczem, wartość domyślną itd. To trochę jak podgląd "instrukcji budowy" tabeli, przydatny zwłaszcza gdy wracasz do cudzej (albo swojej sprzed miesiąca) bazy i nie pamiętasz dokładnie, co tam jest.

---

## 12. Ściąga — wszystko w pigułce

| Polecenie | Do czego służy | Zmienia dane? |
|---|---|---|
| `CREATE TABLE` | tworzy nową tabelę (definiuje kolumny, typy, klucze) | nie (tylko struktura) |
| `ALTER TABLE` | zmienia strukturę istniejącej tabeli | struktura, czasem dane |
| `INSERT INTO ... VALUES` | dodaje nowe wiersze | tak — dodaje |
| `SELECT` | odczytuje dane | nie |
| `UPDATE ... SET ... WHERE` | zmienia wartości w istniejących wierszach | tak — modyfikuje |
| `DELETE FROM ... WHERE` | usuwa wybrane wiersze | tak — usuwa |
| `TRUNCATE TABLE` | usuwa wszystkie wiersze i resetuje licznik | tak — czyści całość |
| `DESCRIBE` / `SHOW COLUMNS` | pokazuje strukturę tabeli | nie |

### Kluczowe pojęcia do zapamiętania na pamięć

- **Klucz główny (`PRIMARY KEY`)** — unikalny identyfikator wiersza, nigdy `NULL`, nigdy się nie powtarza.
- **Klucz obcy (`FOREIGN KEY`)** — łącznik do klucza głównego innej tabeli; tak budujemy relacje między tabelami.
- **`NULL`** — "brak wartości", coś zupełnie innego niż zero czy pusty tekst.
- **`WHERE`** — filtr; bez niego `UPDATE`/`DELETE` działają na całej tabeli.
- **`CHECK` i `DEFAULT`** — reguły pilnowane przez samą bazę, niezależnie od tego, co robi aplikacja.

---

## 13. Co dalej — z czym warto poćwiczyć

Na bazie tego, co już umiesz, naturalnym kolejnym krokiem byłoby:
- łączenie danych z dwóch tabel jednym zapytaniem (`JOIN`) — np. wyświetlenie towaru razem z adresem jego hurtowni,
- sortowanie wyników (`ORDER BY`),
- grupowanie i agregowanie danych (`GROUP BY`, `COUNT`, `SUM`, `AVG`) — np. "ile towarów ma każda hurtownia" albo "średnia cena towarów".

Daj znać, jeśli chcesz, żebym rozszerzył ten plik o te tematy — mogę dopisać kolejny rozdział w tym samym stylu.