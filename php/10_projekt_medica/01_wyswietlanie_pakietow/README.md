# Kompletny przewodnik: Skrypt 1 — pakiety abonamentowe (`h3` i `p`)

Ta ściąga wytłumaczy Ci **od A do Z** połączenie obiektowe z bazą `medica` oraz wypisanie każdego pakietu jako nagłówka z ceną i akapitu z opisem.

---

## SEC-1: Połączenie obiektowe — baza `medica`

```php
$conn = new mysqli("localhost", "root", "", "medica");
```

Na końcu pliku:

```php
$conn->close();
```

Host **localhost**, użytkownik **root**, puste hasło, baza **`medica`**. Zapytania: `$conn->query($query)`. Wiersz: `$result->fetch_assoc()`.

---

## SEC-2: Zapytanie — `nazwa`, `cena`, `opis`

```sql
SELECT nazwa, cena, opis FROM abonamenty;
```

Bez `WHERE` i bez `JOIN` — wszystkie pakiety z jednej tabeli. Wiele wierszy → pętla `while`.

```php
$query = "SELECT nazwa, cena, opis FROM abonamenty;";
$result = $conn->query($query);
```

Klucze: `$row["nazwa"]`, `$row["cena"]`, `$row["opis"]`.

---

## SEC-3: Nagłówek trzeciego stopnia i paragraf

Arkusz: **nagłówek trzeciego stopnia** z nazwą pakietu **i ceną** oraz **paragraf z opisem**.

```php
while ($row = $result->fetch_assoc()) {
    echo "<h3>" . $row["nazwa"] . " - " . $row["cena"] . " zł</h3>";
    echo "<p>" . $row["opis"] . "</p>";
}
```

- **`<h3>`** — nie `h2` (ten jest przy sekcjach Standardowy / Premium / Dziecko).
- Myślnik i **` zł`** po cenie — jak w kontrolce.
- **`<p>`** — sam opis, bez ceny.

Blok stoi w **`<article>`**. PHP nie otwiera `article` — tylko dokleja `h3` i `p`.

---

# Podsumowanie przepływu danych

```text
new mysqli(..., "medica")
                 ↓
SELECT nazwa, cena, opis FROM abonamenty
                 ↓
while fetch_assoc
                 ↓
<h3>nazwa - cena zł</h3>
<p>opis</p>
```

---

# Ściągawka

| **Pojęcie**         | **Co robi?**                         |
| ------------------- | ------------------------------------ |
| **Baza `medica`**   | Nazwa bazy z arkusza.                |
| **`<h3>`**          | Nazwa pakietu i cena.                |
| **`<p>`**           | Opis pakietu.                        |
| **`fetch_assoc`**   | Jeden wiersz po nazwach kolumn.      |

---

### Co dalej?

Opisy pakietów są w artykule. W `<main>` wypiszesz **cechy** każdego abonamentu przez `JOIN`.

👉 **[Przejdź do Kroku 2: Cechy abonamentu (JOIN)](../02_generowanie_cech_abonamentu/README.md)**
