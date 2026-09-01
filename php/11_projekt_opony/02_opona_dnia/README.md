> **Krok 2 z 3** | [W Kroku 1](../01_lista_opon_sezony/README.md) masz 10 najtańszych opon. Teraz **Skrypt 2**: jedna, stała **opona dnia** (`nr_kat = 9`).

---

# Kompletny przewodnik: Skrypt 2 — opona dnia w nagłówkach `<h2>`

Ta ściąga wytłumaczy Ci **od A do Z** filtr po numerze katalogowym oraz trzy nagłówki drugiego stopnia w sekcji `#gora`.

---

## SEC-1: Zapytanie — `WHERE nr_kat = 9`

```sql
SELECT producent, model, sezon, cena FROM opony WHERE nr_kat = 9;
```

To **nie** jest `RAND()` i **nie** jest `LIMIT 10`. Arkusz wskazuje konkretny numer katalogowy **9**.

Jeden wiersz (unikalny `nr_kat`) → **jedno** `fetch_assoc()`, bez `while`.

```php
$result = $conn->query($query);
$row = $result->fetch_assoc();
```

---

## SEC-2: Trzy nagłówki drugiego stopnia

Arkusz: model, sezon oraz cena w nagłówkach **`<h2>`** (nie `h3`/`h4` z kafelków).

Kontrolka:

```php
echo "<h2>" . $row["producent"] . " model " . $row["model"] . "</h2>";
echo "<h2>Sezon: " . $row["sezon"] . "</h2>";
echo "<h2>Cena: " . $row["cena"] . " PLN</h2>";
```

W HTML sekcji jest już stałe `<h2>Opona dnia</h2>` oraz obraz `opona.png`. Skrypt **dopisuje** kolejne `h2` z danymi z bazy.

Słowo **`PLN`** przy cenie opony dnia; na kafelkach Skryptu 1 często jest **`zł`**. Trzymaj się formy z arkusza / kontrolki.

---

# Podsumowanie przepływu danych

```text
SELECT … FROM opony WHERE nr_kat = 9
                 ↓
jedno fetch_assoc()
                 ↓
<h2>producent model …</h2>
<h2>Sezon: …</h2>
<h2>Cena: … PLN</h2>
```

---

# Ściągawka

| **Pojęcie**          | **Co robi?**                          |
| -------------------- | ------------------------------------- |
| **`nr_kat = 9`**     | Stała opona dnia z arkusza.           |
| **Jedno `fetch_assoc`** | Nie pętla — jeden rekord.          |
| **`<h2>`**           | Nagłówek 2. stopnia (trzy linie).     |

---

### Co dalej?

Na dole strony **losowe zamówienie** z wartością `ilość * cena`.

👉 **[Przejdź do Kroku 3: Zamówienie opon](../03_zamowienie_opon/README.md)**
