# Kompletny przewodnik: Łączenie się z bazą danych w PHP (obiektowe mysqli)

Ta ściąga wytłumaczy Ci **od A do Z**, jak PHP otwiera połączenie z serwerem bazy danych MySQL, zanim wykona jakiekolwiek zapytanie SQL.

---

## SEC-1: Otwarcie połączenia z bazą (`new mysqli(...)`)

```php
<?php
$conn = new mysqli(hostname: "localhost", username: "root", password: "", database: "wykaz");
```

### Jak to działa?

- **`new mysqli(...)`** – tworzy nowy obiekt reprezentujący połączenie z serwerem MySQL.
- **`hostname: "localhost"`** – serwer bazy danych znajduje się na tym samym komputerze, co strona.
- **`username: "root"`**, **`password: ""`** – logujemy się jako domyślny użytkownik administracyjny, bez hasła (typowe w środowisku do nauki).
- **`database: "wykaz"`** – nazwa bazy danych używanej w tym projekcie. To w niej znajdują się tabele `miasta` i `wojewodztwa`, których użyjemy w kolejnym module do wyszukiwania.
- **`$conn`** – zmienna przechowująca gotowe połączenie, używana w każdym kolejnym module, w którym trzeba wysłać zapytanie SQL.

> **Ważna uwaga o kolejności w tym projekcie:** W oryginalnym kodzie to połączenie jest otwierane **dopiero wewnątrz** warunku `if (isset($_POST['szukaj']))` (czyli dopiero wtedy, gdy formularz faktycznie wysłano) — a nie na samym początku pliku, tak jak w poprzednich projektach. To rozsądne podejście: po co łączyć się z bazą danych, skoro użytkownik jeszcze nic nie wyszukuje?

---

# Podsumowanie przepływu danych

```text
SEC-1: new mysqli("localhost", "root", "", "wykaz")
       — Otwarcie połączenia z serwerem bazy danych
                 ↓
       $conn
       — Gotowy "pilot" do sterowania bazą, używany w module 03 (zapytanie SQL)
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**     | **Co oznacza / Co robi?**                                                                 |
| -------------------------- | ------------------------------------------------------------------------------------------ |
| **`new mysqli(...)`**      | Tworzy nowy obiekt połączenia z bazą danych MySQL.                                          |
| **hostname**                | Adres serwera bazy danych (`"localhost"` = ten sam komputer).                              |
| **username / password**     | Dane logowania do bazy danych.                                                             |
| **database**                | Nazwa konkretnej bazy danych, z którą pracujemy (tu: `wykaz`).                              |
| **`$conn`**                 | Zmienna przechowująca gotowe połączenie — używana we wszystkich kolejnych zapytaniach SQL. |
