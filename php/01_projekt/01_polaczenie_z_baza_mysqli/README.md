# Kompletny przewodnik: Nawiązanie i zamknięcie połączenia z bazą MySQLi

Ta ściąga wytłumaczy Ci **od A do Z** logikę łączenia PHP z bazą MySQL, czym są parametry dostępowe, jak działa obiekt połączenia `$conn`, jak obsługiwać błędy oraz dlaczego i kiedy zamykamy połączenie.

---

## SEC-1: Co to są dane dostępowe do bazy i po co zmienne?

Zanim PHP połączy się z bazą danych, musi wiedzieć **gdzie** się udać i **jakich kluczy** użyć do wejścia.

W tym celu definiujemy 4 podstawowe zmienne:

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kino";
```

### Wyjaśnienie parametrów krok po kroku

- **`$host` (`localhost`):** Adres serwera bazy danych. `localhost` oznacza _"baza danych znajduje się na tym samym komputerze/serwerze, na którym działa PHP"_.
- **`$user` (`root`):** Nazwa użytkownika bazy danych. `root` to domyślne konto administratora w środowiskach lokalnych (np. XAMPP).
- **`$pass` (`""`):** Hasło użytkownika. W domyślnej instalacji XAMPP konto `root` nie ma hasła, dlatego wpisujemy pusty ciąg znaków (`""`).
- **`$db` (`kino`):** Dokładna nazwa konkretnej bazy danych, z którą chcemy pracować (baza utworzona np. w phpMyAdmin).

---

## SEC-2: Tworzenie obiektu połączenia – linijka `new mysqli(...)`

Sercem komunikacji z bazą danych jest utworzenie tzw. **obiektu połączenia**:

```php
$conn = new mysqli($host, $user, $pass, $db);
```

### Co tu się dokładnie dzieje?

1. **`new mysqli(...)`** – słowo kluczowe `new` tworzy nowy obiekt klasy `mysqli`. Przekazujemy mu w nawiasie 4 argumenty w ściśle określonej kolejności: `(host, użytkownik, hasło, baza)`.
2. **`$conn`** – zmienna (skrót od _connection_), która staje się naszym **mostem / połączeniem** między kodem PHP a serwerem MySQL.

> **Pamiętaj:** Zmienna `$conn` będzie Ci potrzebna w każdym kolejnym kroku aplikacji – to przez nią wysyłasz zapytania SQL (`$conn->query(...)`) oraz zamykasz połączenie.

---

## SEC-3: Obsługa błędów połączenia (`connect_error`)

W realnym świecie połączenie z bazą może się nie udać (np. złe hasło, błędna nazwa bazy, wyłączony serwer MySQL).

Dlatego **zawsze** warto sprawdzić, czy połączenie zakończyło się sukcesem.

```php
if ($conn->connect_error) {
    die("Błąd połączenia z bazą: " . $conn->connect_error);
}
```

### Jak to działa?

- **`$conn->connect_error`** – jeśli wystąpił jakikolwiek błąd podczas łączenia, ta właściwość zawiera tekst z opisem tego błędu (np. _Access denied_ albo _Unknown database_). Jeśli połączenie się udało, jest pusta (`null`).
- **`if ($conn->connect_error)`** – sprawdzamy: _"Czy wystąpił jakiś błąd połączenia?"_.
- **`die(...)`** – funkcja, która wyświetla komunikat o błędzie i **natychmiast zatrzymuje wykonywanie całego skryptu PHP**. Dzięki temu kod nie próbuje wykonywać dalszych zapytań na niedziałającym połączeniu.

---

## SEC-4: Praca z bazą danych i kod strony

Po poprawnym nawiązaniu połączenia zmienna `$conn` jest gotowa do użycia.

To w tym miejscu wykonujemy zapytania SQL lub dołączamy inne pliki.

```php
// TUTAJ WYKONUJEMY ZAPYTANIA SQL, NP.:
// $result = $conn->query("SELECT * FROM aktorzy");
// ... wyświetlanie danych w HTML ...
```

Zmienna `$conn` przekazywana jest do zapytań `$conn->query()`, dzięki czemu PHP wie, do której konkretnie bazy ma wysłać rozkaz SQL.

---

## SEC-5: Zamykanie połączenia (`$conn->close()`)

Na samym końcu skryptu PHP należy poprawnie zamknąć otwarte połączenie:

```php
$conn->close();
```

### Po co zamykamy połączenie?

- **Oszczędność zasobów:** Każde otwarte połączenie zużywa pamięć RAM serwera i limit dostępnych połączeń MySQL.
- **Czystość kodu:** Gdy skrypt PHP kończy pracę, zwalniamy zasoby, informując serwer MySQL, że nie będziemy już wysyłać żadnych zapytań.
- **Co jeśli zapomnisz?** PHP automatycznie zamyka połączenia po zakończeniu wykonywania skryptu, ale **dobrą praktyką programistyczną** (i wymogiem na egzaminach INF.03/EE.09) jest jawne wywoływanie `$conn->close()`.

---

# Podsumowanie przepływu danych

```text
Zdefiniowanie danych ($host,$user, $pass,$db)
                 ↓
$conn = new mysqli(...) — Tworzenie mostu do MySQL
                 ↓
Czy wystąpił błąd ($conn->connect_error)?
   ├── TAK ──> die() — Zatrzymanie skryptu i błąd
   └── NIE ──> Połączenie udane!
                 ↓
Wykonywanie zapytań SQL ($conn->query(...))
                 ↓
Zakończenie pracy skryptu
                 ↓
$conn->close() — Zamknięcie połączenia z bazą
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**      | **Co oznacza / Co robi?**                                     |
| -------------------------- | ------------------------------------------------------------- |
| **`localhost`**            | Domyślny adres serwera lokalnego (Twojego komputera).         |
| **`root`**                 | Domyślny użytkownik-administrator w MySQL (np. w XAMPP).      |
| **`new mysqli()`**         | Tworzy nowy obiekt połączenia z bazą MySQL.                   |
| **`$conn`**                | Zmienna reprezentująca aktywne połączenie z bazą.             |
| **`$conn->connect_error`** | Przechowuje informację o błędzie połączenia (jeśli wystąpił). |
| **`die()`**                | Wypisuje komunikat i natychmiast przerywa działanie programu. |
| **`$conn->close()`**       | Zamyka aktywne połączenie z bazą danych i zwalnia zasoby.     |

---

### Co dalej?

Mamy już aktywne połączenie (zmienna `$conn`). Teraz możemy je wykorzystać, aby pobrać z bazy pierwsze dane i wyświetlić je na ekranie.

👉 **[Przejdź do Kroku 2: Pobieranie listy rekordów i generowanie linków](../02_pobieranie_listy_rekordow/README.md)**
