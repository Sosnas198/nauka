# Kompletny przewodnik: Zamykanie połączenia z bazą danych

Ta ściąga wytłumaczy Ci, dlaczego i jak na samym końcu skryptu PHP zamykamy połączenie, które otworzyliśmy w module `01_polaczenie_z_baza`.

---

## SEC-1: Zamknięcie połączenia (`$conn -> close()`)

```php
$conn -> close();
```

### Jak to działa?

- **`$conn`** – to ta sama zmienna z połączeniem, którą utworzyliśmy na samym początku (moduł `01_polaczenie_z_baza`) i której używaliśmy do wysyłania wszystkich zapytań SQL (wyszukiwanie zamówień wg dat oraz wyświetlanie wszystkich zamówień).
- **`-> close()`** – wywołujemy na tym obiekcie metodę `close()`, czyli mówimy PHP: "skończyliśmy korzystać z bazy danych, możesz zamknąć to połączenie".
- Ta linijka zwalnia zasoby serwera bazy danych, informując go, że może "zapomnieć" o naszym połączeniu.

> **Dlaczego to robimy dopiero na końcu?** Ponieważ dopóki nie zamkniemy połączenia, cały czas mamy do niego dostęp i możemy wysyłać kolejne zapytania (tak jak w modułach 02 i 03 — niezależnie od tego, którą gałąź `if`/`else` wykonał skrypt). Zamknięcie połączenia zbyt wcześnie sprawiłoby, że kolejne zapytania zakończyłyby się błędem.

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
