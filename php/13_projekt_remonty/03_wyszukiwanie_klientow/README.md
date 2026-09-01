> **Krok 3 z 3** | [W Kroku 2](../02_lista_miast/README.md) select ma miasta. Teraz **Skrypt 3**: miasto + rodzaj usługi, `JOIN`, wyniki **imię - cena**.

---

# Kompletny przewodnik: Skrypt 3 — `JOIN` zleceń, dwa parametry `?`, lista z myślnikiem

Ta ściąga wytłumaczy Ci **od A do Z** drugi formularz (select + radio), złączenie `klienci` i `zlecenia` oraz format `<li>imie - cena</li>`.

---

## SEC-1: Formularz — miasto i radio usługi

```html
<form action="zlecenia.php" method="post">
    <select name="miasto" id="miasto">…</select>
    <input type="radio" name="usluga" value="malowanie" checked>
    <input type="radio" name="usluga" value="gipsowanie">
    <button type="submit">Szukaj klientów</button>
</form>
```

- **`name="usluga"`** — w POST jest **jedna** wartość: `malowanie` albo `gipsowanie`.
- **`checked`** na malowaniu — stan początkowy.

Skrypt gdy są oba klucze:

```php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["miasto"], $_POST["usluga"])) {
    // prepare …
}
```

Formularz „Szukaj firm” tych pól nie wysyła — Skrypt 3 się wtedy **nie** wykona.

---

## SEC-2: Zapytanie — `JOIN USING(id_klienta)`

```sql
SELECT imie, cena
FROM klienci
JOIN zlecenia USING (id_klienta)
WHERE miasto = ? AND rodzaj = ?;
```

- **`USING (id_klienta)`** — skrót: obie tabele mają kolumnę `id_klienta` (to samo co `ON klienci.id_klienta = zlecenia.id_klienta`).
- **`miasto`** — z tabeli `klienci` (select).
- **`rodzaj`** — z tabeli `zlecenia` (radio: malowanie / gipsowanie).

Dwa placeholdery `?` → dwa parametry tekstowe.

---

## SEC-3: `bind_param("ss", …)`

```php
$stmt = $conn->prepare($queryZlecenia);
$stmt->bind_param("ss", $_POST["miasto"], $_POST["usluga"]);
$stmt->execute();
$resultZlecenia = $stmt->get_result();
```

**`"ss"`** — string, string (kolejność jak `?` w SQL: najpierw miasto, potem rodzaj).

Potem `fetch_assoc` i `$stmt->close()`.

---

## SEC-4: Lista z separatorem myślnika

Arkusz: imię i cena **oddzielone myślnikiem**.

```php
echo "<ul>";
while ($row = $resultZlecenia->fetch_assoc()) {
    echo "<li>" . $row["imie"] . " - " . $row["cena"] . "</li>";
}
echo "</ul>";
```

Przykład: `Anna - 1200` — spacje wokół `-` jak w kontrolce.

To **lista punktowana** (`<ul>`), nie numerowana.

---

# Podsumowanie przepływu danych

```text
POST miasto=Kraków, usluga=malowanie
                 ↓
JOIN klienci + zlecenia
WHERE miasto = ? AND rodzaj = ?
bind_param("ss", …)
                 ↓
<li>imie - cena</li>
```

---

# Ściągawka

| **Pojęcie**              | **Co robi?**                              |
| ------------------------ | ----------------------------------------- |
| **`name="usluga"`**      | Radio: malowanie lub gipsowanie.          |
| **`USING (id_klienta)`** | JOIN po wspólnym kluczu.                  |
| **`"ss"`**               | Dwa parametry tekstowe.                   |
| **`imie - cena`**        | Format pozycji listy z arkusza.           |

---

### Gratulacje!

Masz pełny cykl remontów: firmy po liczbie pracowników, miasta w selectcie oraz klienci po mieście i usłudze.

🏠 **[Wróć do głównego spisu treści](../README.md)**
