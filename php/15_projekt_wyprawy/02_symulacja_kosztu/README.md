> **Krok 2 z 3** | [Krok 1](../01_lista_rozwijana_miejsca/README.md) wysyła nazwę miejsca. Teraz **Skrypt 2**: cena z bazy i koszt dorosłych + dzieci.

---

# Kompletny przewodnik: Skrypt 2 — POST, `cena`, połowa dla dzieci

---

## SEC-1: Pola formularza i warunek POST

```html
<select name="miejsce">…</select>
<input type="number" name="dorosli" min="1">
<input type="number" name="dzieci" min="0">
<input type="date" name="termin">
<button type="submit" name="symulacja">Symulacja ceny</button>
```

Skrypt gdy są dane (kontrolka sprawdza cztery klucze):

```php
if ($_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["miejsce"], $_POST["dorosli"], $_POST["dzieci"], $_POST["termin"])) {
    // …
}
```

Możesz też: `isset($_POST["symulacja"])`.

---

## SEC-2: Cena wybranego miejsca (`prepare`)

```sql
SELECT cena FROM miejsca WHERE nazwa = ?;
```

```php
$stmt = $conn->prepare("SELECT cena FROM miejsca WHERE nazwa = ?");
$stmt->bind_param("s", $miejsce);
$stmt->execute();
```

Jeden wiersz. Kontrolka używa **`bind_result($cena)`** + **`$stmt->fetch()`**. Równoważnie: `get_result()` i `fetch_assoc()["cena"]`.

---

## SEC-3: Wzór kosztu — dzieci 50%

Arkusz: dzieci płacą **połowę** ceny.

```php
$koszt = ($cena * $dorosli) + ($cena * 0.5 * $dzieci);
```

- dorośli → `cena * liczba`
- dzieci → `cena * 0.5 * liczba`

Przykład: cena 200, 2 dorosłych, 2 dzieci → `400 + 200 = 600`.

---

## SEC-4: Wyświetlenie terminu i kwoty

```php
echo "<p>W dniu: " . $termin . "</p>";
echo "<p>" . $koszt . " złotych</p>";
```

`$termin` z `$_POST["termin"]` (typ `date` → np. `2026-08-30`). Słowo **złotych** jak w kontrolce (niekoniecznie `zł`).

Pod nagłówkiem **Koszt wycieczki** w `<aside>`.

---

👉 **[Krok 3: Bloki wycieczek](../03_bloki_wycieczek/README.md)**
