# Pobieranie i pętla po wszystkich rekordach (SELECT + while)

### Jak to działa:

1. `$conn->query($query)` – wysyła zapytanie SQL do bazy.
2. `while ($row = $result->fetch_assoc())` – pętla wykonuje się tak długo, jak długo są kolejne wiersze w bazie.
3. `$row['nazwa_kolumny']` – wyciąga wartość konkretnej kolumny dla danego wiersza.
