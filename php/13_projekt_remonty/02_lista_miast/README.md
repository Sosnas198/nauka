> **Krok 2 z 3** | [W Kroku 1](../01_wyszukiwanie_wykonawcow/README.md) filtrujesz firmy. Teraz **Skrypt 2**: unikalne miasta klientów w `<select>` — **zawsze**, bez POST.

---

# Kompletny przewodnik: Skrypt 2 — `DISTINCT miasto` i opcje listy rozwijanej

Ta ściąga wytłumaczy Ci **od A do Z**, po co `DISTINCT` oraz jak wypełnić `name="miasto"` nazwami z tabeli `klienci`.

---

## SEC-1: Zapytanie — unikalne miasta alfabetycznie

```sql
SELECT DISTINCT miasto FROM klienci ORDER BY miasto;
```

- **`DISTINCT`** — każde miasto **raz** (wielu klientów z Krakowa → jedna opcja).
- **`ORDER BY miasto`** — A → Z.

Tu zwykłe **`$conn->query()`** wystarczy: nic nie pochodzi z formularza.

```php
$queryMiasta = "SELECT DISTINCT miasto FROM klienci ORDER BY miasto;";
$resultMiasta = $conn->query($queryMiasta);
```

---

## SEC-2: `<option value="miasto">miasto</option>`

```php
while ($row = $resultMiasta->fetch_assoc()) {
    echo "<option value='" . $row["miasto"] . "'>" . $row["miasto"] . "</option>";
}
```

I `value`, i treść to **`$row["miasto"]`**. Select ma `name="miasto"` — Skrypt 3 odczyta `$_POST["miasto"]`.

---

# Podsumowanie przepływu danych

```text
SELECT DISTINCT miasto FROM klienci ORDER BY miasto
                 ↓
while fetch_assoc
                 ↓
<option value="Kraków">Kraków</option>
```

---

# Ściągawka

| **Pojęcie**         | **Co robi?**                    |
| ------------------- | ------------------------------- |
| **`DISTINCT`**      | Bez powtórzeń miasta.           |
| **`name="miasto"`** | Klucz POST dla Skryptu 3.       |

---

### Co dalej?

Radio „malowanie / gipsowanie” + miasto → **Skrypt 3**.

👉 **[Przejdź do Kroku 3: Klienci po mieście i usłudze](../03_wyszukiwanie_klientow/README.md)**
