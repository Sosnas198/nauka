# Kompletny przewodnik: Łączenie się z bazą danych w PHP (obiektowe mysqli)

Ta ściąga wytłumaczy Ci **od A do Z**, jak PHP otwiera połączenie z serwerem bazy danych MySQL, zanim wykona jakiekolwiek zapytanie SQL.

---

## SEC-1: Otwarcie połączenia z bazą (`new mysqli(...)`)

```php
<?php
$conn = new mysqli(hostname: "localhost", username: "root", password: "", database: "mieszalnia");
```

### Jak to działa? Rozbijmy to na czynniki pierwsze

- **`new mysqli(...)`** – słowo `new` oznacza "stwórz nowy obiekt". `mysqli` to gotowa, wbudowana w PHP "klasa" (czyli szablon), która potrafi rozmawiać z bazą danych MySQL.
- **`hostname: "localhost"`** – mówimy PHP, *gdzie* znajduje się serwer bazy danych. `"localhost"` oznacza "na tym samym komputerze, na którym działa strona".
- **`username: "root"`** – nazwa użytkownika bazy danych, na którego konto się logujemy. `"root"` to domyślny, administracyjny użytkownik w MySQL.
- **`password: ""`** – hasło do tego użytkownika. Puste cudzysłowia `""` oznaczają "brak hasła" — typowe ustawienie w środowiskach do nauki.
- **`database: "mieszalnia"`** – nazwa konkretnej bazy danych, z którą pracujemy w tym projekcie. To w niej znajdują się tabele `klienci` i `zamowienia`, których będziemy używać w kolejnych modułach.
- **Nazwane argumenty (`hostname:`, `username:`...)** – nowoczesna składnia PHP (*named arguments*), która pozwala podpisać każdy parametr z osobna, zamiast pamiętać kolejność.
- **`$conn`** – zmienna, w której zapisujemy gotowe połączenie (skrót od *connection*). Używamy jej w każdym kolejnym module, gdzie potrzebujemy "porozmawiać" z bazą.

---

# Podsumowanie przepływu danych

```text
SEC-1: new mysqli("localhost", "root", "", "mieszalnia")
       — Otwarcie połączenia z serwerem bazy danych
                 ↓
       $conn
       — Gotowy "pilot" do sterowania bazą, używany we wszystkich kolejnych modułach
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**     | **Co oznacza / Co robi?**                                                                 |
| -------------------------- | ------------------------------------------------------------------------------------------ |
| **`new mysqli(...)`**      | Tworzy nowy obiekt połączenia z bazą danych MySQL.                                          |
| **hostname**                | Adres serwera bazy danych (`"localhost"` = ten sam komputer).                              |
| **username / password**     | Dane logowania do bazy danych.                                                             |
| **database**                | Nazwa konkretnej bazy danych, z którą pracujemy (tu: `mieszalnia`).                         |
| **`$conn`**                 | Zmienna przechowująca gotowe połączenie — używana we wszystkich kolejnych zapytaniach SQL. |
