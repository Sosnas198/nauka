# Kompletny przewodnik: Skrypt 1 — miejsca wycieczek w `<select>`

---

## SEC-1: Połączenie — baza `wyprawy`

```php
$conn = new mysqli("localhost", "root", "", "wyprawy");
```

Na końcu: `$conn->close()`.

---

## SEC-2: Zapytanie — nazwy alfabetycznie

```sql
SELECT nazwa FROM miejsca ORDER BY nazwa;
```

Tylko kolumna **`nazwa`**. Sortowanie A→Z. Zwykłe `$conn->query()` (brak danych z formularza).

```php
$query = $conn->query("SELECT nazwa FROM miejsca ORDER BY nazwa");
```

Kontrolka bywa z `$query->num_rows > 0` przed pętlą — na egzaminie wystarczy `while ($row = $query->fetch_assoc())`.

---

## SEC-3: `name="miejsce"` i opcje

```php
while ($row = $query->fetch_assoc()) {
    echo "<option value='" . $row["nazwa"] . "'>" . $row["nazwa"] . "</option>";
}
```

Skrypt 2 odczyta **`$_POST["miejsce"]`** i porówna z kolumną `nazwa` w SQL.

---

👉 **[Krok 2: Symulacja kosztu](../02_symulacja_kosztu/README.md)**
