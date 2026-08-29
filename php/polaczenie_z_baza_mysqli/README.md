# Podstawowe połączenie z bazą MySQLi

### Jak to działa:
1. Obiekt `$conn = new mysqli(...)` tworzy połączenie z bazą danych (host, użytkownik, hasło, nazwa bazy).
2. Na końcu pliku zamykamy połączenie za pomocą `$conn->close()`.