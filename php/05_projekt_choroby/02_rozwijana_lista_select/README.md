> **Krok 2 z 3** | [W Kroku 1](../01_lista_chorob_zakaznych/README.md) wypełniliśmy `<ol>`. Teraz **Skrypt 2**: każda choroba jako **`<option>`** w liście rozwijanej.

---

# Kompletny przewodnik: Skrypt 2 — wypełnianie `<select>` parami `id` + `nazwa`

Ta ściąga wytłumaczy Ci **od A do Z**, po co w `value` jest identyfikator, a na ekranie nazwa, oraz jak PHP w pętli dokleja opcje do gotowego znacznika `<select>`.

---

## SEC-1: Zapytanie — `id` i `nazwa` wszystkich chorób

```sql
SELECT id, nazwa FROM choroby;
```

Tu **nie** ma `WHERE zakazna = 'T'`. Lista rozwijana ma zawierać **wszystkie** choroby z tabeli, nie tylko zakaźne.

Potrzebujesz **dwóch** kolumn:

- **`id`** — trafi do atrybutu `value` (to wyśle formularz),
- **`nazwa`** — tekst widoczny dla użytkownika.

---

## SEC-2: Formularz POST i znaczenie `name="choroba"`

W HTML:

```html
<form action="zdrowie.php" method="post">
    <select name="choroba" id="choroba">
        <!-- tu Skrypt 2 wstawia <option> -->
    </select>
    <button type="submit" name="sprawdz">Sprawdź</button>
</form>
```

- **`method="post"`** — dane **nie** widać w pasku adresu (inaczej niż `?month=` w projekcie pogody).
- **`name="choroba"`** — po wysłaniu PHP odczyta wybór jako **`$_POST["choroba"]`**.
- **`name="sprawdz"`** na przycisku — Skrypt 3 sprawdzi `isset($_POST["sprawdz"])`.

Skrypt 2 **tylko buduje opcje**. Nie obsługuje jeszcze POST.

---

## SEC-3: Wzorzec `<option value="id">nazwa</option>`

Arkusz: identyfikator w atrybucie wartości, nazwa jako **treść** opcji.

```php
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row["id"] . "'>" . $row["nazwa"] . "</option>";
}
```

Przykład wygenerowanego HTML:

```html
<option value="4">Grypa</option>
```

Użytkownik widzi „Grypa”. Do serwera idzie **`4`**. Skrypt 3 filtruje objawy po tym `id`, a nie po nazwie tekstowej (nazwy mogłyby się powtarzać lub zawierać apostrofy).

Znaczniki `<select>` i `</select>` zostają w HTML — PHP wstawia wyłącznie `<option>`.

---

## SEC-4: Pętla `while` — jedna opcja na rekord

```php
$query = "SELECT id, nazwa FROM choroby;";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row["id"] . "'>" . $row["nazwa"] . "</option>";
}
```

Klucze: `$row["id"]`, `$row["nazwa"]` — dokładnie nazwy kolumn z `SELECT`.

---

# Podsumowanie przepływu danych

```text
SELECT id, nazwa FROM choroby
                 ↓
while fetch_assoc()
                 ↓
<option value="id">nazwa</option>
                 ↓
Użytkownik wybiera pozycję
                 ↓
POST: $_POST["choroba"] = id
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie**             | **Co robi?**                                           |
| ----------------------- | ------------------------------------------------------ |
| **`<select>`**          | Lista rozwijana (otwarta w HTML).                      |
| **`<option>`**          | Jedna pozycja z bazy.                                  |
| **`value`**             | Wartość wysłana w POST (tu: `id`).                     |
| **Treść opcji**         | To, co widać (tu: `nazwa`).                            |
| **`name="choroba"`**    | Klucz w tablicy `$_POST`.                              |

---

### Co dalej?

Po kliknięciu „Sprawdź” **Skrypt 3** pobierze objawy wybranej choroby przez tabelę łączącą.

👉 **[Przejdź do Kroku 3: POST i JOIN objawów](../03_objawy_choroby_post_join/README.md)**
