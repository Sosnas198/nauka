> **Krok 2 z 3** | [W Kroku 1](../01_wyswietlanie_obrazow_towarow/README.md) pokazałeś miniatury. Teraz **Skrypt 2**: każda pozycja towaru jako **`<option>`** w `<select name="id">`.

---

# Kompletny przewodnik: Skrypt 2 — lista rozwijana (`value` = id, treść = nazwa)

Ta ściąga wytłumaczy Ci **od A do Z**, po co w `value` jest identyfikator oraz jak PHP w pętli wypełnia gotowy znacznik `<select>`.

---

## SEC-1: Zapytanie — `id` i `nazwa` wszystkich towarów

```sql
SELECT id, nazwa FROM towar;
```

Tu **nie** ma `LIMIT 10` — zamówić można każdy towar z tabeli, nie tylko te z galerii.

- **`id`** → atrybut **`value`** (to poleci w POST).
- **`nazwa`** → tekst widoczny na liście.

```php
$query = "SELECT id, nazwa FROM towar;";
$result = mysqli_query($conn, $query);
```

---

## SEC-2: Formularz — `name="id"` i `name="waga"`

```html
<form action="index.php" method="post">
    <select name="id" id="id" required>
        <!-- Skrypt 2 wstawia <option> -->
    </select>
    <input type="number" name="waga" id="waga" min="1" required>
    <button type="submit">Zamów</button>
</form>
```

Po kliknięciu „Zamów”:

- **`$_POST["id"]`** — wybrany towar,
- **`$_POST["waga"]`** — waga z pola liczbowego.

Skrypt 2 **tylko buduje opcje**. Liczenie i `INSERT` to Moduł 3.

---

## SEC-3: Wzorzec `<option value="id">nazwa</option>`

```php
while ($row = mysqli_fetch_array($result)) {
    echo "<option value='" . $row["id"] . "'>" . $row["nazwa"] . "</option>";
}
```

Przykład: `<option value="3">Jabłko</option>` — użytkownik widzi „Jabłko”, serwer dostaje `3`.

`<select>` i `</select>` zostają w HTML.

---

# Podsumowanie przepływu danych

```text
SELECT id, nazwa FROM towar
                 ↓
while mysqli_fetch_array
                 ↓
<option value="id">nazwa</option>
                 ↓
POST: id + waga
```

---

# Ściągawka

| **Pojęcie**          | **Co robi?**                         |
| -------------------- | ------------------------------------ |
| **`<select name="id">`** | Klucz `id` w `$_POST`.           |
| **`value`**          | Id towaru wysłane w POST.            |
| **Treść opcji**      | Nazwa towaru na ekranie.             |
| **`name="waga"`**    | Druga wartość do Skryptu 3.          |

---

### Co dalej?

Po „Zamów” **Skrypt 3** pobierze cenę, policzy wartość i zapisze zamówienie.

👉 **[Przejdź do Kroku 3: POST, obliczenia i INSERT](../03_obsluga_zamowienia_post_insert/README.md)**
