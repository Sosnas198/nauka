> **Krok 2 z 3** | [W Kroku 1](../01_tabela_kursow/README.md) masz cennik. Teraz **Skrypt 2**: nazwy kursów jako **`<option>`** w formularzu zapisów.

---

# Kompletny przewodnik: Skrypt 2 — lista rozwijana z nazw kursów

Ta ściąga wytłumaczy Ci **od A do Z** zapytanie tylko o `nazwa` oraz wypełnienie `<select name="kurs">`.

---

## SEC-1: Zapytanie — same nazwy

```sql
SELECT nazwa FROM kursy;
```

Tu **nie** potrzebujesz `kod` ani `cena`. W `value` i w treści opcji jest **nazwa** (tak jest w kontrolce).

```php
$query = "SELECT nazwa FROM kursy;";
$result = $conn->query($query);
```

---

## SEC-2: Formularz POST — pola zapisów

```html
<form action="index.php" method="post">
    <input type="text" name="imie" id="imie">
    <input type="text" name="nazwisko" id="nazwisko">
    <input type="number" name="wiek" id="wiek">
    <select name="kurs" id="kurs">
        <!-- Skrypt 2: option -->
    </select>
    <button type="submit">Dodaj dane</button>
</form>
```

Po wysłaniu: `$_POST["imie"]`, `$_POST["nazwisko"]`, `$_POST["wiek"]`, `$_POST["kurs"]`.

Skrypt 2 **tylko buduje opcje**. Zapis do bazy to Moduł 3.

---

## SEC-3: `<option value="nazwa">nazwa</option>`

```php
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row["nazwa"] . "'>" . $row["nazwa"] . "</option>";
}
```

I `value`, i tekst widoczny to **`$row["nazwa"]`**. `<select>` zostaje w HTML.

---

# Podsumowanie przepływu danych

```text
SELECT nazwa FROM kursy
                 ↓
while fetch_assoc
                 ↓
<option value="nazwa">nazwa</option>
                 ↓
POST: imie, nazwisko, wiek, kurs
```

---

# Ściągawka

| **Pojęcie**            | **Co robi?**                      |
| ---------------------- | --------------------------------- |
| **`SELECT nazwa`**     | Lista etykiet kursów.             |
| **`name="kurs"`**      | Klucz w `$_POST["kurs"]`.         |
| **`value` = nazwa**    | W tym arkuszu nie id, tylko nazwa.|

---

### Co dalej?

Po „Dodaj dane” **Skrypt 3** sprawdzi puste pola i wstawi uczestnika.

👉 **[Przejdź do Kroku 3: POST, walidacja i INSERT](../03_obsluga_formularza_post/README.md)**
