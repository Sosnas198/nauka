# Kompletny przewodnik: Skrypt 1 — obrazy towarów (`LIMIT 10`, `src` i `alt`)

Ta ściąga wytłumaczy Ci **od A do Z** połączenie proceduralne z bazą `bazar`, zapytanie o 10 towarów oraz budowę znaczników `<img>` z kolumn `plik` i `nazwa`.

---

## SEC-1: Połączenie — baza `bazar` i `mysqli_fetch_array`

```php
$conn = mysqli_connect("localhost", "root", "", "bazar");
```

Na końcu strony:

```php
mysqli_close($conn);
```

Odczyt wiersza według arkusza / kontrolki:

```php
$row = mysqli_fetch_array($result);
```

**`mysqli_fetch_array`** zwraca tablicę z kluczami **numerycznymi i nazwanymi**. i tak piszesz `$row['plik']`, `$row['nazwa']` (jak przy `fetch_assoc`). Na egzaminie użyj tej funkcji, której wymaga tabela / wzorzec.

---

## SEC-2: Zapytanie — `nazwa`, `plik`, maksymalnie 10 rekordów

```sql
SELECT nazwa, plik FROM towar LIMIT 10;
```

- **`plik`** — nazwa grafiki (np. `jablko.jpg`) → atrybut **`src`**.
- **`nazwa`** — nazwa owocu / warzywa → atrybut **`alt`**.
- **`LIMIT 10`** — ograniczenie po stronie SQL, nie pętla `for` w PHP.

```php
$query = "SELECT nazwa, plik FROM towar LIMIT 10;";
$result = mysqli_query($conn, $query);
```

---

## SEC-3: Pętla i znacznik `<img>`

Wiele wierszy → `while`. Każdy rekord to jeden obraz:

```php
while ($row = mysqli_fetch_array($result)) {
    echo "<img src='" . $row["plik"] . "' alt='" . $row["nazwa"] . "'>";
}
```

| Atrybut   | Kolumna z bazy    | Rola                         |
| --------- | ----------------- | ---------------------------- |
| **`src`** | `$row["plik"]`    | Który plik wczytać.          |
| **`alt`** | `$row["nazwa"]`   | Tekst alternatywny (owoc).   |

W kontrolce bywa dodatkowo `height="150px"` (wymiar z CSS / arkusza graficznego).

Blok HTML to zwykle **`<nav>`** — skrypt tylko dopisuje obrazki, nie tworzy całego dokumentu.

---

# Podsumowanie przepływu danych

```text
mysqli_connect(..., "bazar")
                 ↓
SELECT nazwa, plik FROM towar LIMIT 10
                 ↓
while mysqli_fetch_array
                 ↓
<img src="plik" alt="nazwa">
```

---

# Ściągawka

| **Pojęcie**              | **Co robi?**                              |
| ------------------------ | ----------------------------------------- |
| **Baza `bazar`**         | Nazwa bazy z arkusza.                     |
| **`LIMIT 10`**           | Co najwyżej 10 towarów.                   |
| **`$row["plik"]`**       | Wartość `src`.                            |
| **`$row["nazwa"]`**      | Wartość `alt`.                            |
| **`mysqli_fetch_array`** | Kolejny wiersz wyniku.                    |

---

### Co dalej?

Galeria jest w nawigacji. W formularzu zbudujemy **listę rozwijaną** ze wszystkich towarów.

👉 **[Przejdź do Kroku 2: Lista rozwijana](../02_generowanie_listy_rozwijanej/README.md)**
