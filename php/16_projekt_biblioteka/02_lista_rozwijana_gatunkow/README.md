> **Krok 2 z 4** | [Krok 1](../01_petla_grafik/README.md) to pętla w headerze. Teraz **Skrypt 2**: trzy listy — liryka, epika, dramat.

---

# Kompletny przewodnik: Skrypt 2 — `<option value="id">tytuł</option>` wg gatunku

---

## SEC-1: Zapytanie 1 — `id` i `tytul` z filtrem gatunku

```sql
SELECT id, tytul FROM ksiazka WHERE gatunek = "liryka";
```

Dla innych sekcji zmieniasz **tylko** literał: `"epika"`, `"dramat"` (małe litery jak w bazie).

```php
$result = $mysqli->query('SELECT id, tytul FROM ksiazka WHERE gatunek = "liryka"');
```

Tu wystarczy `query()` — gatunek jest stały w kodzie, nie z POST.

---

## SEC-2: `value` = id, treść = tytuł

```php
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row["id"] . "'>" . $row["tytul"] . "</option>";
}
```

Formularz wysyła **numer id**, nie tytuł. Skrypt 3 szuka książki po `id`.

---

## SEC-3: Trzy sekcje, trzy `name`

| Sekcja HTML   | `gatunek`  | `name` selecta | `name` przycisku   |
| ------------- | ---------- | -------------- | ------------------ |
| `#pierwszy`   | liryka     | `liryka`       | `buttonliryka`     |
| `#drugi`      | epika      | `epika`        | `buttonepika`      |
| `#trzeci`     | dramat     | `dramat`       | `buttondramat`     |

Powielasz ten sam skrypt i zmieniasz gatunek + nazwy pól. `action="biblioteka.php"`.

---

👉 **[Krok 3: Rezerwacja](../03_rezerwacja_ksiazki/README.md)**
