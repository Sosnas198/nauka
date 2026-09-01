> **Krok 4 z 4** | [Krok 3](../03_rezerwacja_ksiazki/README.md) rezerwuje jedną książkę. Teraz **Skrypt 4**: lista zaległych wypożyczeń.

---

# Kompletny przewodnik: Skrypt 4 — `JOIN`, sortowanie daty, `LIMIT 15`

---

## SEC-1: Zapytanie 2 — książka + wypożyczenie

```sql
SELECT tytul, id_cz, data_odd
FROM ksiazka
JOIN wypozyczenia ON id = id_ks
ORDER BY data_odd
LIMIT 15;
```

- **`ON id = id_ks`** — `ksiazka.id` = `wypozyczenia.id_ks`.
- **`id_cz`** — id czytelnika.
- **`data_odd`** — data oddania.
- **`ORDER BY data_odd`** — od najstarszej / najwcześniejszej daty (domyślnie ASC).
- **`LIMIT 15`** — maksymalnie 15 pozycji.

```php
$result = $mysqli->query("SELECT tytul, id_cz, data_odd FROM ksiazka JOIN wypozyczenia ON id = id_ks ORDER BY data_odd LIMIT 15");
```

---

## SEC-2: Element listy — trzy pola ze spacją

Arkusz: tytuł, id czytelnika i data oddania **oddzielone spacją**.

```php
echo "<ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row["tytul"] . " " . $row["id_cz"] . " " . $row["data_odd"] . "</li>";
}
echo "</ul>";
```

`<ul>` jest w HTML sekcji „Zaległe książki”. PHP wstawia tylko `<li>`.

Przykład: `Pan Tadeusz 7 2024-01-15`.

---

🏠 **[Spis treści](../README.md)**
