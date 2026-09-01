> **Krok 4 z 4** | [W poprzednim kroku](../03_pobieranie_danych_po_id/README.md) pobraliśmy profil aktora bazując na jego `$_GET['id']`. Teraz rozbudujemy naszą stronę: użyjemy tego samego ID, aby połączyć tabelę aktorów z tabelą filmów i sprawdzić, ile ról ma na koncie nasz aktor.

---

# Kompletny przewodnik: Relacje w bazie, złączenia (`JOIN`), zliczanie rekordów (`num_rows`) i wyciąganie danych (`fetch_assoc`)

Ta ściąga wytłumaczy Ci **od A do Z** logikę łączenia ze sobą tabel w bazie danych, rolę tabeli łączącej, budowanie zapytania `JOIN` z pełnymi nazwami tabel, odczytywanie informacji z obiektu `$result`, sprawdzanie liczby wyników za pomocą `$result->num_rows` oraz wyciąganie szczegółów w pętli `while ($row = $result->fetch_assoc())`.

---

## SEC-1: Dlaczego potrzebujemy relacji i co to jest tabela łącząca?

W relacyjnych bazach danych staramy się nie dublować informacji.

Wyobraź sobie sytuację w bazie kinowej:

- Jeden aktor może zagrać w **wielu filmach**.
- Jeden film może mieć w obsadzie **wielu aktorów**.

Jest to tzw. **relacja wiele-do-wielu (N:M)**.

Aby połączyć tabelę `filmy` z tabelą `aktorzy`, tworzy się trzecią, tzw. **tabelę łączącą** (np. `filmy_aktorzy`).

Przechowuje ona tylko pary numerów ID powiązanych ze sobą rekordów:

| `id_filmu`    | `id_aktora`            |
| :------------ | :--------------------- |
| **1** (Kiler) | **3** (Janusz Gajos)   |
| **2** (Psy)   | **3** (Janusz Gajos)   |
| **2** (Psy)   | **7** (Bogusław Linda) |

Gdy pytamy bazę:

> _"W jakich filmach zagrał aktor o ID = 3?"_

musimy przeszukać tę powiązaną strukturę.

---

## SEC-2: Złączenie tabel w SQL (`JOIN`) – pełne nazwy bez skrótów

Zwykłe zapytanie `SELECT` z jednej tabeli nie wystarczy.

Musimy połączyć dane z tabeli `filmy` z danymi z tabeli łączącej `filmy_aktorzy`.

Używamy pełnych nazw tabel zamiast skrótów (aliasów), aby kod był maksymalnie czytelny:

```sql
SELECT filmy.id_filmu
FROM filmy
JOIN filmy_aktorzy ON filmy.id_filmu = filmy_aktorzy.id_filmu
WHERE filmy_aktorzy.id_aktora = 3;
```

### Rozbicie zapytania na części pierwsze

- **`SELECT filmy.id_filmu`** – wybieramy kolumnę `id_filmu`. Zapis `filmy.id_filmu` wskazuje: _"weź kolumnę `id_filmu` dokładnie z tabeli `filmy`"_.
- **`FROM filmy`** – wskazujemy główną tabelę, z której pobieramy dane.
- **`JOIN filmy_aktorzy`** – dołączamy drugą tabelę (pośredniczącą).
- **`ON filmy.id_filmu = filmy_aktorzy.id_filmu`** – warunek złączenia: _"Połącz wiersze z obu tabel w tych miejscach, gdzie numerki `id_filmu` są identyczne"_.
- **`WHERE filmy_aktorzy.id_aktora = 3`** – filtr główny: _"Zostaw tylko te rekordy, gdzie w tabeli łączącej przypisany jest aktor o ID = 3"_.

---

## SEC-3: Co to jest obiekt `$result` oraz operator `->` (strzałka)?

Gdy w kodzie PHP wykonujemy zapytanie do bazy danych:

```php
$result = $conn->query($query);
```

### Czym dokładnie jest `$result`?

`$result` to **obiekt-skrzynia** (paczka z wynikami), którą serwer bazy danych odsyła do PHP:

- **Nie da się zrobić** `echo $result`, ponieważ nie jest to zwykły tekst, lecz złożona struktura danych.
- Skrzynia ta zawiera w środku: odnalezione wiersze i kolumny z bazy, licznik odnalezionych rekordów (`num_rows`) oraz wewnętrzny wskaźnik pozycji.

### Co oznacza operator `->` (strzałka)?

Strzałka `->` służy w PHP do sięgania do wnętrza obiektów (np. połączenia `$conn` lub wyniku `$result`):

#### 1. Wywoływanie akcji (metody / funkcji w obiekcie)

```php
$result->fetch_assoc()
```

→ mówisz obiektowi:

> _"Wykonaj akcję wyciągnięcia jednego wiersza"_.

#### 2. Odczytywanie informacji (właściwości / zmiennej w obiekcie)

```php
$result->num_rows
```

→ mówisz obiektowi:

> _"Daj mi wartość zapisaną pod nazwą `num_rows`"_.

---

## SEC-4: Jak działa `$result->num_rows`?

Właściwość **`$result->num_rows`** odpowiada na pytanie:

> **„Ile dokładnie wierszy trafiło do wynikowej skrzyni po wykonaniu zapytania SQL?”**

- **Przykład A:** Jeśli aktor zagrał w 5 filmach, `$result->num_rows` ma wartość **`5`**.
- **Przykład B:** Jeśli aktor nie zagrał w żadnym filmie, `$result->num_rows` ma wartość **`0`**.

> **Ważne:** `$result->num_rows` daje nam tylko podliczenie (cyfrę), ale **nie wyciąga jeszcze konkretnych danych** z wierszy.

---

## SEC-5: Dwuetapowa praca z wynikami: Podliczenie (`num_rows`) + Konkrety (`fetch_assoc`)

Zapytanie SQL pobiera z bazy paczkę dopasowanych wierszy.

W kodzie rozbijamy jej obsługę na **dwa osobne etapy**:

### Etap 1: `$result->num_rows` — Podliczenie

Pytamy paczkę, **ile** wierszy dopasował SQL.

Służy do podjęcia decyzji w `if` i wyświetlenia nagłówka (np. _"Znaleziono 3 powiązane pozycje:"_).

### Etap 2: Pętla `while ($row = $result->fetch_assoc())` — Konkrety

Pętla wykonuje się dokładnie tyle razy, ile wynosi `num_rows`.

W każdym obiegu wyciąga z paczki jeden konkretny wiersz i zamienia go na tablicę `$row`, by wyświetlić jego szczegóły.

```php
if ($result->num_rows > 0) {
    // 1. KROK PODSUMOWANIA: Wyświetlamy samą informację o liczbie
    echo "<p>Znaleziono " . $result->num_rows . " powiązanych pozycji:</p>";

    // 2. KROK KONKRETÓW: Wyciągamy każdy wiersz po kolei za pomocą fetch_assoc()
    while ($row = $result->fetch_assoc()) {
        echo "<p>ID filmu: " . $row['id_filmu'] . "</p>";
    }

} else {
    // Kod wykonywany, gdy baza zwróciła 0 wierszy
    echo "<p>Brak powiązanych pozycji w bazie.</p>";
}
```

### Analogia z życia (Kurier i paczki)

> Wyobraź sobie odbiór przesyłki od kuriera:
>
> - **`$result->num_rows`** – pytasz kuriera przy drzwiach: _"Ile paczek dla mnie masz?"_. Kurier odpowiada: _"Mam **3 paczki**"_. (To jest Twoje ogólne podliczenie).
> - **`fetch_assoc()`** **w pętli** **`while`** – otwierasz paczki po kolei: z pierwszej wyciągasz buty, z drugiej książkę, z trzeciej telefon. (To są Twoje konkrety).
>
> Oba kroki bazują na **tym samym** zapytaniu `JOIN`, które wysłałeś do bazy!

---

## SEC-6: Dlaczego robimy `aktor.php?id=` i po co 1 uniwersalny plik?

Spójrz na generowanie odnośników w pętli:

```php
echo "<a href='aktor.php?id=" . $id . "'>";
```

Nie tworzymy osobnych plików dla każdego aktora (np. `gajos.php`, `linda.php`).

Tworzymy **JEDEN UNIWERSALNY PLIK-SZABLON** o nazwie `aktor.php`.

1. W pętli generujemy linki kierujące do tego samego pliku, ale z różnym identyfikatorem w adresie URL (`?id=3`, `?id=7`).
2. Gdy użytkownik kliknie link z `id=7`, plik `aktor.php` odczytuje tę wartość z `$_GET['id']`.
3. Plik `aktor.php` odpytuje bazę o aktora o ID = 7 i dynamicznie wypełnia szablon jego danymi.

---

# Podsumowanie przepływu danych

```text
Otrzymanie parametrów z URL (aktor.php?id=3)
                 ↓
isset($_GET['id']) sprawdza obecność parametru ID
                 ↓
Przygotowanie zapytania SQL z JOIN (filmy JOIN filmy_aktorzy)
                 ↓
$result = $conn->query($query) wysyła zapytanie do bazy
                 ↓
Baza zwraca obiekt $result (paczka z wynikami oraz z licznikiem num_rows)
                 ↓
Czy $result->num_rows > 0?
   ├── TAK (np. 3) ──> 1. Wyświetl podsumowanie: "Znaleziono 3 powiązanych pozycje:"
   │                   │
   │                   └──> 2. Pętla while ($row =$result->fetch_assoc())
   │                        pobiera po kolei konkrety (film 1, film 2, film 3)
   │
   └── NIE (czyli 0) ──> Wyświetl komunikat: "Brak powiązanych pozycji w bazie."
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**   | **Co oznacza / Co robi?**                                                                        |
| ----------------------- | ------------------------------------------------------------------------------------------------ |
| **Tabela łącząca**      | Tabela pośrednicząca łącząca dwie inne tabele relacją wiele-do-wielu (np. `filmy_aktorzy`).      |
| **`JOIN`**              | Klauzula SQL łącząca wiersze z dwóch tabel na podstawie wspólnej kolumny.                        |
| **`ON`**                | Wskazuje warunek połączenia (np. `ON filmy.id_filmu = filmy_aktorzy.id_filmu`).                  |
| **`$result`**           | Obiekt-skrzynia zawierający pełny wynik zapytania oraz licznik wierszy.                          |
| **`->` (strzałka)**     | Operator służący do odczytywania danych lub wywoływania funkcji z wnętrza obiektu.               |
| **`$result->num_rows`** | Przechowuje dokładną liczbę odnalezionych wierszy (podliczenie).                                 |
| **`fetch_assoc()`**     | Pobiera z obiektu `$result` jeden wiersz i zamienia go na tablicę asocjacyjną `$row` (konkrety). |
| **`$row['kolumna']`**   | Dostęp do wartości konkretnej kolumny z wiersza utworzonego przez `fetch_assoc()`.               |
| **`aktor.php?id=X`**    | Dynamiczny odnośnik przekazujący parametr ID do uniwersalnego pliku szablonu.                    |

---

### Gratulacje!

Przeszedłeś pełny cykl życia danych w aplikacji relacyjnej: od otwarcia połączenia z serwerem, przez wyświetlanie pętli, podawanie parametrów w adresie WWW, aż do łączenia tabel za pomocą zapytań `JOIN`.

🏠 **[Wróć do głównego spisu treści (Katalog główny)](../README.md)**
