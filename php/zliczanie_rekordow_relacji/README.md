# Sprawdzanie liczby wyników ($result->num_rows) i JOIN

### Jak to działa:

1. Zapytanie `JOIN` łączy tabele (np. filmy z aktorami po tabeli łączącej).
2. `$result->num_rows` Zwraca liczbę znalezionych wierszy w bazie.
3. Konstrukcja `if ($result->num_rows > 0)` pozwala wyświetlić inny komunikat, gdy znaleziono rekordy, a inny, gdy lista jest pusta.
