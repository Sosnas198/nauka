# Pobieranie jednego rekordu z adresu URL ($\_GET['id'])

### Jak to działa:

1. `isset($_GET['id'])` – sprawdza, czy w adresie URL przekazano parametr (np. `aktor.php?id=5`).
2. Wysyłamy zapytanie SQL z warunkiem `WHERE id = $id`.
3. `$result->fetch_assoc()` wywołujemy **tylko raz** (bez pętli `while`), bo spodziewamy się dokładnie jednego rekordu.
