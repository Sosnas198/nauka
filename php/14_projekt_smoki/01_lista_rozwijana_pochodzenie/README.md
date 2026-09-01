# Kompletny przewodnik: Skrypt 1 — unikalne pochodzenie smoków w `<select>`

Ta ściąga wytłumaczy Ci połączenie z bazą **`smoki`** oraz wypełnienie listy krajów pochodzenia.

---

## SEC-1: Połączenie — baza `smoki`

```php
$conn = new mysqli("localhost", "root", "", "smoki");
```

Na końcu strony: `$conn->close()`.

---

## SEC-2: Zapytanie `DISTINCT` + sortowanie

```sql
SELECT DISTINCT pochodzenie FROM smok ORDER BY pochodzenie;
```

- **`DISTINCT`** — każdy kraj raz.
- **`ORDER BY pochodzenie`** — alfabetycznie.

Nic z formularza — zwykłe `$conn->query()`.

```php
$sql = "SELECT DISTINCT pochodzenie FROM smok ORDER BY pochodzenie;";
$result = $conn->query($sql);
```

---

## SEC-3: Opcje — `name="baza"`

Select w HTML ma **`name="baza"`** (nie `pochodzenie`). Skrypt 2 czyta **`$_POST["baza"]`**.

```php
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row["pochodzenie"] . "'>" . $row["pochodzenie"] . "</option>";
}
```

`value` i treść to ta sama kolumna `pochodzenie`.

---

# Ściągawka

| **Pojęcie**            | **Co robi?**                    |
| ---------------------- | ------------------------------- |
| **`DISTINCT`**         | Unikalne kraje.                 |
| **`name="baza"`**      | Klucz POST dla Skryptu 2.       |

---

👉 **[Przejdź do Kroku 2: Filtr tabeli](../02_tabela_smokow_filtr/README.md)**
