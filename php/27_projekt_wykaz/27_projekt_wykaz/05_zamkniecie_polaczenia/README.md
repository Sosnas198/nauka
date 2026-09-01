# Kompletny przewodnik: Zamykanie połączenia z bazą danych

Ta ściąga wytłumaczy Ci, dlaczego i jak na samym końcu skryptu PHP zamykamy połączenie, które otworzyliśmy w module `02_polaczenie_z_baza`.

---

## SEC-1: Zamknięcie połączenia (`$conn -> close()`)

```php
$conn -> close();
```

### Jak to działa?

- **`$conn`** – to ta sama zmienna z połączeniem, którą utworzyliśmy w module `02_polaczenie_z_baza` i której użyliśmy do wysłania zapytania SQL w module `03_zapytanie_i_naglowek_tabeli`.
- **`-> close()`** – wywołujemy na tym obiekcie metodę `close()`, mówiąc PHP: "skończyliśmy korzystać z bazy danych, możesz zamknąć to połączenie".
- Ta linijka zwalnia zasoby serwera bazy danych.

> **Ważne w tym projekcie:** Ponieważ całe wyszukiwanie (moduły 02–05) wykonuje się tylko wewnątrz warunku `if (isset($_POST['szukaj']))` z modułu 01, to zamknięcie połączenia również następuje **tylko wtedy**, gdy formularz faktycznie wysłano. Jeśli użytkownik dopiero wszedł na stronę i nic nie wyszukał, połączenie z bazą nigdy nie zostało otwarte — więc nie ma też czego zamykać.

---

# Podsumowanie przepływu danych

```text
SEC-1: $conn -> close();
       — Zamknięcie połączenia z bazą danych po zakończeniu wszystkich operacji
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**   | **Co oznacza / Co robi?**                                              |
| -------------------------- | -------------------------------------------------------------------------- |
| **`$conn -> close()`**     | Zamyka aktywne połączenie z serwerem bazy danych i zwalnia jego zasoby.    |
