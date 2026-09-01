# Kompletny przewodnik: Zamykanie połączenia z bazą danych

Ta ściąga wytłumaczy Ci, dlaczego i jak na samym końcu skryptu PHP zamykamy połączenie, które otworzyliśmy w module `01_polaczenie_z_baza`.

---

## SEC-1: Zamknięcie połączenia (`$conn -> close()`)

```php
$conn -> close();
```

### Jak to działa?

- **`$conn`** – to ta sama zmienna z połączeniem, którą utworzyliśmy na samym początku (moduł `01_polaczenie_z_baza`) i której używaliśmy do wysyłania wszystkich zapytań SQL (dodawanie osoby, pobieranie listy osób).
- **`-> close()`** – wywołujemy na tym obiekcie metodę `close()`, czyli mówimy PHP: "skończyliśmy korzystać z bazy danych, możesz zamknąć to połączenie".
- Ta linijka **zwalnia zasoby serwera** — mówiąc prościej, informuje serwer bazy danych, że może "zapomnieć" o naszym połączeniu i przeznaczyć swoją moc obliczeniową na obsługę innych użytkowników/innych stron.

> **Dlaczego to robimy dopiero na końcu?** Ponieważ dopóki nie zamkniemy połączenia, cały czas mamy do niego dostęp i możemy wysyłać kolejne zapytania (tak jak w modułach 02 i 03). Zamknięcie połączenia zbyt wcześnie sprawiłoby, że kolejne zapytania (np. pobranie listy osób) zakończyłyby się błędem, bo nie mielibyśmy już z czym "rozmawiać".

> **Co, jeśli zapomnimy zamknąć połączenie?** W praktyce PHP i tak automatycznie zamyka wszystkie otwarte połączenia z bazą danych po zakończeniu wykonywania całego skryptu (czyli po wygenerowaniu całej strony). Jawne wywołanie `close()` jest jednak dobrą praktyką — pokazuje, że świadomie "sprzątamy" po sobie, zamiast liczyć na automatyczne mechanizmy.

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
