# Kompletny przewodnik: Łączenie się z bazą danych w PHP (obiektowe mysqli)

Ta ściąga wytłumaczy Ci **od A do Z**, jak PHP otwiera połączenie z serwerem bazy danych MySQL, zanim wykona jakiekolwiek zapytanie SQL.

---

## SEC-1: Otwarcie połączenia z bazą (`new mysqli(...)`)

Zanim wyślemy do bazy jakiekolwiek zapytanie (czyli np. "pobierz mi wszystkie osoby" albo "dodaj nową osobę"), PHP musi najpierw "zadzwonić" do serwera bazy danych i się z nim połączyć. Dopiero po udanym połączeniu można cokolwiek robić.

```php
<?php
$conn = new mysqli(hostname: "localhost", username: "root", password: "", database: "zdobywcy");
```

### Jak to działa? Rozbijmy to na czynniki pierwsze

- **`<?php ... `** – to jest znacznik otwierający kod PHP. Wszystko po nim, aż do zamknięcia `?>` (albo do końca pliku), jest traktowane przez serwer jako kod PHP, a nie zwykły tekst HTML.
- **`new mysqli(...)`** – słowo `new` oznacza "stwórz nowy obiekt". `mysqli` to gotowa, wbudowana w PHP "klasa" (czyli szablon), która potrafi rozmawiać z bazą danych MySQL. Tworząc `new mysqli(...)`, dostajemy gotowy "pilot" do sterowania bazą danych.
- **`hostname: "localhost"`** – mówimy PHP, *gdzie* znajduje się serwer bazy danych. `"localhost"` oznacza "na tym samym komputerze, na którym działa strona" (czyli np. na Twoim komputerze podczas nauki w XAMPP/WAMP).
- **`username: "root"`** – to nazwa użytkownika bazy danych, na którego konto się logujemy. `"root"` to domyślny, "główny" użytkownik administracyjny w MySQL, który ma dostęp do wszystkiego.
- **`password: ""`** – to hasło do tego użytkownika. Puste cudzysłowia `""` oznaczają "brak hasła" — tak jest domyślnie skonfigurowane w środowiskach do nauki (na serwerze produkcyjnym/prawdziwej stronie internetowej hasło **zawsze** powinno być ustawione).
- **`database: "zdobywcy"`** – to nazwa konkretnej bazy danych (jakby "szuflady" w całym systemie MySQL), z którą chcemy pracować. Jeden serwer MySQL może mieć wiele baz danych — tutaj wskazujemy, że interesuje nas akurat baza o nazwie `zdobywcy`.
- **Nazwane argumenty (`hostname:`, `username:`...)** – to nowoczesna składnia PHP (tzw. *named arguments*), która pozwala podpisać każdy parametr z osobna, zamiast pamiętać, w jakiej kolejności trzeba je wypisać. Dzięki temu kod jest bardziej czytelny — od razu widać, co jest czym.
- **`$conn`** – to zmienna, w której zapisujemy gotowe połączenie. Nazwa `$conn` to skrót od angielskiego słowa *connection* (połączenie). Od teraz, w każdym miejscu kodu, gdzie chcemy "porozmawiać" z bazą danych, będziemy używać właśnie tej zmiennej `$conn`.

> **Ważna uwaga:** Jeśli dane logowania (host, użytkownik, hasło, nazwa bazy) są błędne albo serwer bazy danych jest wyłączony, to połączenie się nie uda i PHP zgłosi błąd. W tym module zakładamy, że dane są poprawne (są zgodne z wymaganiami zadania: `localhost`, `root`, brak hasła, baza `zdobywcy`).

---

# Podsumowanie przepływu danych

```text
SEC-1: new mysqli("localhost", "root", "", "zdobywcy")
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
| **database**                | Nazwa konkretnej bazy danych, z którą pracujemy.                                            |
| **`$conn`**                 | Zmienna przechowująca gotowe połączenie — używana we wszystkich kolejnych zapytaniach SQL. |
