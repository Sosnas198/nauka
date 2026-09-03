# 🏗️ Kurs SQL: Tworzenie Tabel i ich Struktura (`CREATE TABLE`)

## 💡 Czym jest tabela w bazie danych?

Wyobraź sobie **arkusz w Excelu**:

- **kolumny** – mówią, jaki rodzaj informacji przechowujemy (np. imię, cena, klasa),
- **wiersze** – to pojedyncze "rzeczy" opisane tymi kolumnami (np. jeden uczeń, jeden towar).

Przykład – tabela `Uczniowie`:

| NrUcznia | Imie | Nazwisko    | Uwagi | Klasa |
| -------- | ---- | ----------- | ----- | ----- |
| 1        | Jan  | Kwiatkowski | NULL  | 1B1T  |
| 2        | Anna | Kowalska    | NULL  | 2B2T  |

Z bazą danych "rozmawiamy" poleceniami **SQL** (Structured Query Language). To nie jest język programowania jak Python – to język **poleceń**: mówisz bazie _co_ ma się stać, a ona sama decyduje _jak_ to zrobić. Każde polecenie kończymy średnikiem `;` – to jak kropka na końcu zdania, sygnał "koniec polecenia".

---

## 🧱 Tworzenie tabeli — `CREATE TABLE`

To pierwsza rzecz, którą robisz z nową tabelą — definiujesz jej "szkielet": jakie kolumny będzie miała i jakiego typu dane w nich siedzą.

```sql
CREATE TABLE IF NOT EXISTS Uczniowie (
    NrUcznia INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
    Imie VARCHAR(20),
    Nazwisko VARCHAR(20) NOT NULL,
    Uwagi VARCHAR(40),
    Klasa VARCHAR(4) NOT NULL
);
```

Rozbijmy to zdanie po zdaniu, bo w tej jednej komendzie jest naprawdę dużo informacji.

### ✅ `IF NOT EXISTS`

Bez tego dopisku, próba utworzenia tabeli, która już istnieje, kończy się błędem i przerywa działanie skryptu. `IF NOT EXISTS` mówi: "stwórz tę tabelę, ale **tylko jeśli jeszcze jej nie ma** – jeśli już istnieje, nic nie rób, nie zgłaszaj błędu".

> ⚠️ **Przydatne, gdy:** uruchamiasz ten sam skrypt kilka razy z rzędu (np. testując coś) – bez tego dopisku skrypt wywali się na drugim uruchomieniu.

---

## 📦 Typy danych

Każda kolumna musi mieć zadeklarowany typ – to informacja dla bazy, ile miejsca zarezerwować i jakie operacje mają sens.

| Typ            | Co przechowuje                                              | Przykład                       |
| -------------- | ----------------------------------------------------------- | ------------------------------ |
| `INT`          | liczba całkowita                                            | `1`, `2`, `100`                |
| `VARCHAR(n)`   | tekst o zmiennej długości, max `n` znaków                   | `VARCHAR(20)` → max 20 znaków  |
| `DECIMAL(m,d)` | liczba stałoprzecinkowa: `m` cyfr łącznie, `d` po przecinku | `DECIMAL(6,2)` → np. `1234.56` |
| `DATE`         | data (rok-miesiąc-dzień)                                    | `2026-09-03`                   |
| `TEXT`         | długi tekst bez limitu znaków jak przy `VARCHAR`            | opis, komentarz, artykuł       |

**Wyjaśnienie dla ciebie:**

- `VARCHAR` (variable character) w przeciwieństwie do `CHAR` nie marnuje miejsca – jeśli zadeklarujesz `VARCHAR(20)`, a wpiszesz `"Jan"` (3 znaki), baza nie zajmuje pełnych 20 znaków, tylko tyle ile faktycznie potrzeba.
- **Dlaczego cena to `DECIMAL`, a nie `FLOAT`?** `FLOAT`/`DOUBLE` przechowują liczby w sposób przybliżony (to kwestia tego, jak komputery reprezentują ułamki w systemie binarnym) – przy pieniądzach to prosta droga do sytuacji, gdzie `10.10 zł + 0.10 zł` nagle nie daje równo `10.20 zł`. `DECIMAL(6,2)` gwarantuje dokładność co do grosza: 6 cyfr w sumie, z czego 2 po przecinku, czyli zakres od `-9999.99` do `9999.99`.

---

## 🔢 `UNSIGNED` — liczby bez znaku

```sql
NrUcznia INT UNSIGNED
```

**Co to robi:** ogranicza liczbę tylko do wartości nieujemnych (0, 1, 2, 3...).

**Po co:** numer ucznia nigdy nie będzie ujemny, więc od razu blokujemy taką możliwość i "za darmo" dostajemy większy zakres liczb dodatnich (bo baza nie musi rezerwować miejsca na znak minus).

---

## 🔑 `PRIMARY KEY` — klucz główny

To jedna z najważniejszych koncepcji w bazach danych.

**Co to robi:** klucz główny to kolumna, która **jednoznacznie identyfikuje** każdy wiersz w tabeli – jak dowód osobisty. To oznacza dwie rzeczy naraz:

- nie mogą istnieć dwa wiersze z tą samą wartością tego pola,
- pole to nigdy nie może być puste (`NULL`).

W tabeli `Uczniowie` kluczem głównym jest `NrUcznia`.

**Dlaczego nie np. `Nazwisko`?** Bo dwóch uczniów może mieć to samo nazwisko – a numer ucznia zawsze jest unikalny, z definicji. Dzięki kluczowi głównemu baza (i Ty) zawsze bez pomyłki odnajdzie właściwy rekord.

---

## 🔁 `AUTO_INCREMENT` — automatyczne numerowanie

```sql
NrUcznia INT UNSIGNED PRIMARY KEY AUTO_INCREMENT
```

**Co to robi:** mówi bazie "sama licz kolejne wartości tej kolumny – nie musisz mi ich podawać przy dodawaniu nowego wiersza". Pierwszy wstawiony wiersz dostanie `1`, drugi `2`, i tak dalej, automatycznie.

**Po co:** nie musisz ręcznie pilnować, jaki numer jest "wolny", a jednocześnie masz gwarancję, że nigdy się nie powtórzy.

---

## ❓ `NULL` i `NOT NULL` — brak wartości vs pole obowiązkowe

`NULL` w SQL **nie znaczy** "zero" ani "pusty tekst" – znaczy **"brak wartości / nie wiadomo"**. To ważne rozróżnienie konceptualne, bo `NULL` to zupełnie inna rzecz niż pusty string `''`.

```sql
Nazwisko VARCHAR(20) NOT NULL,
Uwagi VARCHAR(40)
```

- `Nazwisko ... NOT NULL` – to pole **musi** zostać wypełnione. Próba wstawienia wiersza bez nazwiska zakończy się błędem.
- `Uwagi` (bez `NOT NULL`) – to pole jest opcjonalne. Jeśli uczeń nie ma żadnych uwag, wstawiamy tam `NULL` – informację "nie dotyczy", a nie pusty tekst.

> ⚠️ **W praktyce:** uczeń bez specjalnych uwag ma `NULL` w kolumnie `Uwagi`, a uczeń, który np. powtarza klasę, ma tam realny tekst `'Powtarza klasę'`.

---

## 🔒 `UNIQUE` — brak powtórzeń

Czasem chcesz, żeby jakaś wartość nigdy się nie powtórzyła, ale **nie** jest to klucz główny tabeli (bo kluczy głównych może być tylko jeden na tabelę).

```sql
CREATE TABLE Uczniowie (
    NrUcznia INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    Nazwisko VARCHAR(20) NOT NULL,
    Email VARCHAR(50) UNIQUE
);
```

**Co to robi:** baza pilnuje, żeby w kolumnie `Email` nie pojawiły się dwie takie same wartości. Próba wstawienia drugiego ucznia z identycznym e-mailem zakończy się błędem.

**Po co:** każdy uczeń ma inny e-mail – `UNIQUE` gwarantuje to na poziomie samej bazy, niezależnie od tego, co zrobi aplikacja.

---

## 🔗 Relacje między tabelami — `FOREIGN KEY` (klucz obcy)

Wyobraź sobie sklep: masz dwie tabele, `Towary` i `Hurtownie`, i każdy towar "należy" do jakiejś hurtowni.

```sql
CREATE TABLE IF NOT EXISTS Hurtownie (
    nazwa VARCHAR(30) PRIMARY KEY,
    adres VARCHAR(60),
    telefon VARCHAR(15)
);

CREATE TABLE IF NOT EXISTS Towary (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nazwa VARCHAR(30),
    cena DECIMAL(6,2) DEFAULT 0.0,
    hurtownia VARCHAR(30),
    FOREIGN KEY (hurtownia) REFERENCES Hurtownie(nazwa)
);
```

**Po co to?**

Zamiast w każdym wierszu tabeli `Towary` wpisywać ręcznie pełny adres i telefon hurtowni (co powtarzałoby się przy każdym towarze z tej samej hurtowni – a przy zmianie telefonu trzeba by poprawiać dziesiątki wierszy), trzymamy dane hurtowni **raz**, w osobnej tabeli. W tabeli `Towary` wpisujemy tylko `nazwa` hurtowni jako "wskaźnik" do właściwego wiersza w `Hurtownie`.

**Co to robi:** `FOREIGN KEY (hurtownia) REFERENCES Hurtownie(nazwa)` mówi bazie: "wartość w kolumnie `hurtownia` tabeli `Towary` musi odpowiadać jakiejś istniejącej wartości w kolumnie `nazwa` tabeli `Hurtownie`".

Dzięki temu baza sama pilnuje spójności danych:

- nie pozwoli dodać towaru z hurtownią, która nie istnieje w tabeli `Hurtownie` (literówka w nazwie zostanie odrzucona),
- domyślnie nie pozwoli usunąć hurtowni, dopóki są przypisane do niej towary.

To jest właśnie sedno "relacyjnych" baz danych (stąd nazwa: _relational database_) – dane w różnych tabelach są ze sobą powiązane, zamiast być zduplikowane wszędzie.

---

## ✋ Ograniczenia (constraints) — pilnowanie jakości danych

Poza `PRIMARY KEY`, `NOT NULL`, `UNIQUE` i `FOREIGN KEY` (opisanymi wyżej) są jeszcze dwa bardzo przydatne "strażniki" danych.

### `DEFAULT` — wartość domyślna

```sql
cena DECIMAL(6,2) DEFAULT 0.0
```

**Co to robi:** jeśli przy wstawianiu nowego towaru nie podasz ceny, baza sama wpisze `0.0`.

**Po co:** to wygodne zabezpieczenie przed brakującymi danymi – kolumna nigdy nie zostaje "przypadkowo" pusta.

### `CHECK` — warunek logiczny

```sql
ALTER TABLE Towary
ADD CONSTRAINT chk_cena CHECK (cena <= 1000);
```

**Co to robi:** to warunek, który baza sprawdza **przy każdej próbie zapisu**. Jeśli spróbujesz wstawić lub zaktualizować towar z ceną `1500`, baza odrzuci tę operację.

**Po co:** pilnowanie reguł biznesowych na poziomie samej bazy danych – nawet jeśli ktoś ominie Twoją aplikację i wpisze dane wprost do bazy, reguła i tak zadziała.

---
