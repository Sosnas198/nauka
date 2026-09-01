> **Krok 2 z 4** | [Poprzednio](../01_polaczenie_z_baza/README.md) nawiązaliśmy połączenie z serwerem i uzyskaliśmy zmienną `$conn`. Teraz wykorzystamy ten most, aby wysłać pierwsze zapytanie SQL, wyciągnąć wszystkich aktorów i zbudować dla każdego z nich unikalny link.

---

# Kompletny przewodnik: Pobieranie i wyświetlanie listy wszystkich rekordów (`SELECT + while`)

Ta ściąga wytłumaczy Ci **od A do Z** logikę pobierania wielu wierszy z bazy danych, działanie pętli `while`, odczytywanie danych z tablicy asocjacyjnej oraz automatyczne generowanie dynamicznych linków HTML.

---

## SEC-1: Zapytanie SQL po wiele rekordów i sortowanie (`ORDER BY`)

### Zapytanie SQL (SQL Query)

Gdy chcemy pobrać całą listę elementów (np. wszystkich aktorów), nie stosujemy klauzuli `WHERE id = ...`. Używamy zapytania, które wybiera wszystkie wiersze z tabeli.

**Przykład:**

```sql
SELECT * FROM aktorzy ORDER BY nazwisko ASC, imie ASC;
```

### Rozbijmy je na części

- **`SELECT *`** – gwiazdka (`*`) oznacza: _"Pobierz dane ze wszystkich kolumn"_.
- **`FROM aktorzy`** – informuje bazę, z jakiej tabeli czerpiemy dane.
- **`ORDER BY nazwisko ASC, imie ASC`** – sortowanie wyników:
  - `ORDER BY` – _"posortuj według..."_,
  - `nazwisko ASC` – sortuj po nazwisku rosnąco (od A do Z),
  - `, imie ASC` – jeśli nazwiska są takie same, posortuj dodatkowo po imieniu od A do Z.

---

## SEC-2: Wykonanie zapytania i czym NAPRAWDĘ jest obiekt `$result`?

W kodzie PHP wysyłamy zapytanie do bazy za pomocą linijki:

```php
$result = $conn->query($query);
```

### Czym dokładnie jest `$result`?

`$result` to specjalny **obiekt wyników** (w PHP ma typ `mysqli_result`). Wyobraź sobie, że `$result` to **zamknięta skrzynia z dokumentami** albo **kursor (wskaźnik)** stojący na samej górze tabeli wyników w pamięci serwera.

### Dlaczego NIE MOŻNA zrobić `echo $result`?

Jeśli spróbujesz napisać:

```php
echo $result;
```

PHP wyrzuci błąd:

> _Object of class mysqli_result could not be converted to string_

Dlaczego?

Bo `$result` to nie jest tekst! To złożona struktura danych, która zawiera w środku:

- Informację, ile wierszy znaleziono (`$result->num_rows`).
- Dane wszystkich pobranych wierszy i kolumn.
- **Wskaźnik poziomu**, który wie, który wiersz z kolei będziemy teraz czytać.

Aby wyciągnąć z tej "skrzyni" konkretny tekst, musimy użyć dedykowanej funkcji otwierającej wiersze – `fetch_assoc()`.

---

## SEC-3: Jak działa pętla `while` z funkcją `fetch_assoc()`?

```php
while ($row = $result->fetch_assoc()) {
    // kod wykonujący się dla każdego wiersza
}
```

### Co to znaczy, że `fetch_assoc()` "tworzy tablicę na podstawie atrybutów z bazy"?

Dokładnie tak! Baza danych przechowuje informacje w tabeli (kolumny = atrybuty, np. `imie`, `nazwisko`, `plik_awatara`).

Gdy wywołujesz `$result->fetch_assoc()`:

1. Funkcja spogląda na **jeden wiersz** z bazy.
2. Bierze **nazwy kolumn (atrybutów)** z Twojej tabeli w bazie i zamienia je na **klucze (etykiety)** tablicy PHP.
3. Bierze **wartości** z tego wiersza i wkłada je pod te klucze.

Z surowego wiersza z bazy danych powstaje w pamięci PHP gotowa tablica `$row`:

```php
// Tak w środku wygląda zmienna $row utworzona przez fetch_assoc():
$row = [
    'id_aktora' => 3,              // klucz 'id_aktora' pochodzi z nazwy kolumny w MySQL
    'imie' => 'Janusz',            // klucz 'imie' pochodzi z nazwy kolumny w MySQL
    'nazwisko' => 'Gajos',         // klucz 'nazwisko' pochodzi z nazwy kolumny w MySQL
    'plik_awatara' => 'gajos.jpg'  // klucz 'plik_awatara' pochodzi z nazwy kolumny w MySQL
];
```

### Przebieg pętli krok po kroku

1. **Pierwszy obieg:** `fetch_assoc()` pobiera wiersz 1 → tworzy `$row` dla 1. aktora → pętla wykonuje kod HTML dla 1. aktora.
2. **Drugi obieg:** `fetch_assoc()` automatycznie przesuwa wskaźnik w `$result` na wiersz 2 → nadpisuje zmienną `$row` danymi 2. aktora → pętla generuje HTML dla 2. aktora.
3. **Gdy brak wierszy:** `fetch_assoc()` zwraca `false` → pętla `while(false)` kończy działanie.

---

## SEC-4: Odczytywanie danych – czym są klucze w tablicy `$row`?

Klucz to po prostu nazwa w nawiasie kwadratowym `$row['NAZWA_KOLUMNY']`.

```php
$id       = $row['id_aktora'];     // wyciąga wartość z kolumny id_aktora
$imie     = $row['imie'];          // wyciąga wartość z kolumny imie
$nazwisko = $row['nazwisko'];      // wyciąga wartość z kolumny nazwisko
$avatar   = $row['plik_awatara'];  // wyciąga wartość z kolumny plik_awatara
```

- Jeśli w bazie kolumna nazywa się `id_aktora`, piszesz `$row['id_aktora']`.
- Jeśli w bazie kolumna nazywa się `cena_produktu`, pisałbyś `$row['cena_produktu']`.

---

## SEC-5: Dlaczego robimy `aktor.php?id=` i po co nam 1 uniwersalny plik?

Spójrz na tę linijkę z pętli:

```php
echo "<a href='aktor.php?id=" . $id . "'>";
```

### Czy musisz tworzyć osobny plik dla każdego aktora (np. `gajos.php`, `lindberg.php`)?

**NIE! I to jest cała magia programowania w PHP!**

Zamiast tworzyć 100 osobnych plików HTML/PHP dla 100 różnych aktorów, tworzysz **JEDEN UNIWERSALNY PLIK-SZABLON** o nazwie `aktor.php`.

### Jak to działa w praktyce?

1. Na liście wszystkich aktorów pętla generuje linki do tego samego pliku, ale z różnym ID:
   - Dla Gajosa: `<a href='aktor.php?id=3'>`
   - Dla Lindy: `<a href='aktor.php?id=7'>`
   - Dla Stuhra: `<a href='aktor.php?id=12'>`

2. Gdy użytkownik kliknie w link z ID = 7, otwiera się plik `aktor.php`.

3. Plik `aktor.php` odczytuje z adresu `$_GET['id']` (czyli `7`), pyta bazę:

   _"Daj mi dane aktora o ID = 7"_

   i dynamicznie uzupełnia swój szablon danymi Lindy!

Dzięki temu 1 plik PHP obsłuży nawet milion aktorów z bazy danych.

---

# Podsumowanie przepływu danych

```text
Zapytanie SQL (SELECT * FROM aktorzy)
                 ↓
$conn->query($query) wysyła rozkaz do bazy
                 ↓
Baza zwraca obiekt $result (skrzynia / wskaźnik danych)
                 ↓
Start pętli: while ($row = $result->fetch_assoc())
                 ↓
┌────────────────────────────────────────────────────────────────────────┐
│ 1. fetch_assoc() bierze wiersz i tworzy tablicę $row po nazwach kolumn │
│ 2. Odczytujesz wartości przez $row['nazwa_kolumny']                   │
│ 3. Generujesz kartę HTML z linkiem do uniwersalnego pliku:             │
│    aktor.php?id=3, aktor.php?id=7, itp.                               │
└────────────────────────────────────────────────────────────────────────┘
                 ↓
Czy są kolejne wiersze w $result?
   ├── TAK ──> Powtórz obieg pętli
   └── NIE ──> Koniec pętli
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**    | **Co oznacza / Co robi?**                                                                              |
| ------------------------ | ------------------------------------------------------------------------------------------------------ |
| **`$result`**            | Obiekt-wskaźnik zawierający całą surową paczkę z wynikami z bazy. Nie da się go wypisać przez `echo`.  |
| **`fetch_assoc()`**      | Funkcja wyciągająca 1 wiersz ze skrzyni `$result` i budująca z niego tablicę `$row`.                   |
| **`$row`**               | Tablica asocjacyjna reprezentująca jeden konkretny wiersz z bazy w danej chwili.                       |
| **Klucze `$row['...']`** | Nazwy kolumn wyciągnięte dokładnie z Twojej tabeli w bazie danych (np. `imie`, `nazwisko`).            |
| **`aktor.php?id=X`**     | Uniwersalny plik (szablon), który przyjmuje numer ID w adresie URL i wyświetla dane właściwego aktora. |

### Co dalej?

Udało nam się wyświetlić listę z wygenerowanymi linkami (np. `aktor.php?id=3`). Teraz musimy stworzyć ten docelowy plik `aktor.php`, który odbierze numer `3` z adresu URL i wyświetli odpowiednią osobę.

👉 **[Przejdź do Kroku 3: Odbieranie ID z adresu URL](../03_pobieranie_danych_po_id/README.md)**
