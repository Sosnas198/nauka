# Kompletny przewodnik: Skrypt 1 — wykonawcy według liczby pracowników (POST + `prepare`)

Ta ściąga wytłumaczy Ci **od A do Z** połączenie z bazą `remonty`, warunek „co najmniej N pracowników” oraz cykl **prepared statement**.

---

## SEC-1: Połączenie obiektowe — baza `remonty`

```php
$conn = new mysqli("localhost", "root", "", "remonty");
```

Na końcu pliku: **`$conn->close()`**.

---

## SEC-2: Kiedy uruchomić skrypt?

Formularz:

```html
<form action="zlecenia.php" method="post">
    <input type="number" name="pracownikow" id="pracownikow">
    <button type="submit">Szukaj firm</button>
</form>
```

Skrypt **tylko** po wysłaniu tego formularza i gdy pole nie jest puste:

```php
if ($_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST["pracownikow"])
    && $_POST["pracownikow"] !== "") {
    // wyszukiwanie
}
```

**`!== ''`** — odrzuca puste pole (użytkownik kliknął Szukaj bez liczby). Nie myl z drugim formularzem (tam nie ma `pracownikow`).

---

## SEC-3: Zapytanie z placeholderem `?`

```sql
SELECT nazwa_firmy, liczba_pracownikow
FROM wykonawcy
WHERE liczba_pracownikow >= ?;
```

**`>=`** — „co najmniej” tylu pracowników, ile wpisano.

Znak **`?`** to miejsce na wartość z PHP. **Nie** wklejasz `$_POST` w cudzysłowy SQL.

---

## SEC-4: `prepare`, `bind_param`, `execute`, `get_result`

```php
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_POST["pracownikow"]);
$stmt->execute();
$result = $stmt->get_result();
```

| Krok                 | Co robi?                                                    |
| -------------------- | ----------------------------------------------------------- |
| **`prepare`**        | Kompiluje SQL z `?`.                                        |
| **`bind_param("i", $n)`** | `"i"` = integer; podstawia liczbę z POST pod `?`.      |
| **`execute`**        | Wysyła zapytanie do bazy.                                   |
| **`get_result`**     | Wynik jak po `$conn->query()` — dalej `fetch_assoc()`.      |
| **`$stmt->close()`** | Zamyka to konkretne przygotowane zapytanie.                 |

---

## SEC-5: Lista wyników

```php
echo "<ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row["nazwa_firmy"] . ", " . $row["liczba_pracownikow"] . " pracowników</li>";
}
echo "</ul>";
```

Przykład: `AlfaBud, 12 pracowników` — nazwa, przecinek, liczba, słowo „pracowników”.

---

# Podsumowanie przepływu danych

```text
POST pracownikow = 5
                 ↓
prepare: WHERE liczba_pracownikow >= ?
bind_param("i", 5)
                 ↓
while fetch_assoc
                 ↓
<li>nazwa_firmy, N pracowników</li>
```

---

# Ściągawka

| **Pojęcie**        | **Co robi?**                         |
| ------------------ | ------------------------------------ |
| **`>= ?`**         | Co najmniej N osób w firmie.         |
| **`"i"`**          | Parametr całkowity.                  |
| **`get_result()`** | Pętla `fetch_assoc` jak przy query.  |

---

### Co dalej?

Po prawej (środek strony) wypełnisz **miasta** w selectcie.

👉 **[Przejdź do Kroku 2: Lista miast](../02_lista_miast/README.md)**
