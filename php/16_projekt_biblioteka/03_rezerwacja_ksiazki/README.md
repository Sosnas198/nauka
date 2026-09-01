> **Krok 3 z 4** | [Krok 2](../02_lista_rozwijana_gatunkow/README.md) wysyła `id`. Teraz **Skrypt 3**: tytuł z bazy, paragraf i `UPDATE rezerwacja = 1`.

---

# Kompletny przewodnik: Skrypt 3 — POST, zapytanie 5 i zapytanie 4 (`UPDATE`)

---

## SEC-1: Tylko „właściwa” sekcja

Każdy formularz ma **inny** przycisk (`buttonliryka`, `buttonepika`, `buttondramat`).

```php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["buttonliryka"], $_POST["liryka"])) {
    $bookId = $_POST["liryka"];
    // SELECT + echo + UPDATE
}
```

Kod **stoi pod formularzem Liryki**. Analogiczny blok pod Epiką sprawdza `buttonepika`. Dzięki temu paragraf **nie** wyleci we wszystkich trzech sekcjach naraz.

---

## SEC-2: Zapytanie 5 — tytuł po `id`

```sql
SELECT tytul FROM ksiazka WHERE id = ?;
```

```php
$stmt = $mysqli->prepare("SELECT tytul FROM ksiazka WHERE id = ?");
$stmt->bind_param("i", $bookId);
$stmt->execute();
$stmt->bind_result($title);
$stmt->fetch();
$stmt->close();
```

**`"i"`** — id całkowite. Jeden wiersz: `fetch()`, nie pętla `while`.

---

## SEC-3: Paragraf rezerwacji

```php
echo "<p>Książka " . $title . " została zarezerwowana</p>";
```

Dokładna forma z arkusza: **Książka \<tytuł\> została zarezerwowana**.

---

## SEC-4: Zapytanie 4 — `UPDATE rezerwacja = 1`

```sql
UPDATE ksiazka SET rezerwacja = 1 WHERE id = ?;
```

```php
$update = $mysqli->prepare("UPDATE ksiazka SET rezerwacja = 1 WHERE id = ?");
$update->bind_param("i", $bookId);
$update->execute();
$update->close();
```

To **nie** jest `SELECT`. Ustawia flagę rezerwacji dla tej książki. Ten sam `$bookId` co w zapytaniu 5.

Kolejność w arkuszu: najpierw pokaż tytuł, potem `UPDATE` (albo odwrotnie — oba muszą użyć id z formularza).

---

👉 **[Krok 4: Zaległe](../04_zalegle_ksiazki/README.md)**
