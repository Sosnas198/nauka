# Kompletny przewodnik: Skrypt 1 — 10 najtańszych opon i ikona sezonu

Ta ściąga wytłumaczy Ci **od A do Z** nagłówek `Refresh`, zapytanie posortowane po cenie, wybór pliku `lato.png` / `zima.png` / `uniwer.png` oraz blok `<div class="opona">` z nagłówkami `<h4>` i `<h3>`.

---

## SEC-1: `header("Refresh: 10;")` — przed HTML

Arkusz: strona odświeża się **co 10 sekund**.

```php
header("Refresh: 10;");
```

To funkcja PHP wysyłająca nagłówek HTTP do przeglądarki. **Musi** wystąpić **zanim** pojawi się jakikolwiek HTML (nawet spacja przed `<?php`). Dlatego stoi na **samym początku** `index.php`, razem z połączeniem.

`10` to sekundy. Po odświeżeniu ponownie wykonają się wszystkie skrypty (w tym losowe zamówienie).

---

## SEC-2: Połączenie — baza `opony`

```php
$conn = new mysqli("localhost", "root", "", "opony");
```

Na końcu: `$conn->close();`

---

## SEC-3: Zapytanie — 10 najtańszych

```sql
SELECT nr_kat, producent, model, sezon, cena FROM opony ORDER BY cena LIMIT 10;
```

- **`ORDER BY cena`** — rosnąco (najtańsze pierwsze); `ASC` jest domyślne.
- **`LIMIT 10`** — tylko dziesięć rekordów.
- **`sezon`** — potrzebny do wyboru obrazka, niekoniecznie do wypisania w `h4`/`h3`.

Wiele wierszy → `while`.

---

## SEC-4: Obraz zależny od sezonu

Arkusz: dobierz **`lato.png`**, **`zima.png`** albo **`uniwer.png`**.

```php
if ($row["sezon"] == "lato") {
    $plikSezonu = "lato.png";
} else if ($row["sezon"] == "zima") {
    $plikSezonu = "zima.png";
} else {
    $plikSezonu = "uniwer.png";
}
```

Trzecia gałąź (`else`) łapie sezon uniwersalny / wielosezonowy i każdą inną wartość z bazy.

Jeśli w Twojej bazie są kody (`L`, `Z`, `U`) albo słowa `letnia` / `zimowa`, porównujesz **dokładnie to, co jest w kolumnie `sezon`**. Logika arkusza zostaje ta sama: trzy pliki, dwa `if` + `else`.

---

## SEC-5: Blok `.opona`, `<h4>` i `<h3>`

Każdy rekord to osobny kontener:

```php
echo "<div class='opona'>";
echo "<img src='" . $plikSezonu . "' alt='" . $row["sezon"] . "'>";
echo "<h4>" . $row["producent"] . " " . $row["model"] . "</h4>";
echo "<h3>" . $row["cena"] . " zł</h3>";
echo "</div>";
```

| Element              | Treść                                      |
| -------------------- | ------------------------------------------ |
| **`class="opona"`**  | Klasa z arkusza (styl z `styl.css`).       |
| **`<h4>`**           | Producent i model.                         |
| **`<h3>`**           | Cena.                                      |

Nie myl z `<h2>` z Skryptów 2 i 3.

---

# Podsumowanie przepływu danych

```text
header("Refresh: 10;")
                 ↓
SELECT … ORDER BY cena LIMIT 10
                 ↓
while fetch_assoc
                 ↓
lato / zima / else → plik PNG
                 ↓
<div class="opona"> img + h4 + h3
```

---

# Ściągawka

| **Pojęcie**                 | **Co robi?**                              |
| --------------------------- | ----------------------------------------- |
| **`header("Refresh: 10")`** | Odświeżenie co 10 s (przed HTML).         |
| **`ORDER BY cena LIMIT 10`**| Dziesięć najtańszych.                     |
| **`lato.png` / `zima.png` / `uniwer.png`** | Ikona sezonu.              |
| **`div.opona`**             | Jeden kafelek opony.                      |
| **`h4` / `h3`**             | Model i cena.                             |

---

### Co dalej?

Lista najtańszych jest z boku. Na górze głównej kolumny **opona dnia**.

👉 **[Przejdź do Kroku 2: Opona dnia](../02_opona_dnia/README.md)**
