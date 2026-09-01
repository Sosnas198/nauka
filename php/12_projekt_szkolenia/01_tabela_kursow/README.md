# Kompletny przewodnik: Skrypt 1 — tabela kursów (`kod.jpg`, nazwa, cena)

Ta ściąga wytłumaczy Ci **od A do Z** połączenie z bazą `szkolenia`, sortowanie po cenie oraz budowę wiersza z obrazem, którego nazwa pliku powstaje z pola `kod`.

---

## SEC-1: Połączenie obiektowe — baza `szkolenia`

```php
$conn = new mysqli("localhost", "root", "", "szkolenia");
```

Na końcu strony:

```php
$conn->close();
```

Zapytania: `$conn->query($query)`. Wiersz: `$result->fetch_assoc()`.

---

## SEC-2: Zapytanie — `kod`, `nazwa`, `cena`, sortowanie

```sql
SELECT kod, nazwa, cena FROM kursy ORDER BY cena;
```

- **`kod`** — skrót kursu, z niego składasz nazwę pliku grafiki.
- **`nazwa`** — druga kolumna tabeli.
- **`cena`** — trzecia kolumna; **`ORDER BY cena`** — od najtańszego (domyślnie `ASC`).

Wiele kursów → pętla `while`.

---

## SEC-3: Obraz `kod` + `.jpg` i trzy komórki

Arkusz: obrazek — nazwa pliku oparta o pole **`kod`** i rozszerzenie **`.jpg`**.

Jeśli `$row["kod"]` to `JS`, plik to **`JS.jpg`**.

```php
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td><img src='" . $row["kod"] . ".jpg' alt='kurs'></td>";
    echo "<td>" . $row["nazwa"] . "</td>";
    echo "<td>" . $row["cena"] . "</td>";
    echo "</tr>";
}
```

| Kolumna HTML | Skąd dane                                      |
| ------------ | ---------------------------------------------- |
| Kurs         | `<img src="KOD.jpg" alt="kurs">`               |
| Nazwa        | `$row["nazwa"]`                                |
| Cena         | `$row["cena"]`                                 |

Nagłówki `th` (Kurs / Nazwa / Cena) są w HTML. PHP dopisuje tylko `<tr>` z danymi.

---

# Podsumowanie przepływu danych

```text
new mysqli(..., "szkolenia")
                 ↓
SELECT kod, nazwa, cena FROM kursy ORDER BY cena
                 ↓
while fetch_assoc
                 ↓
<tr> <img src="kod.jpg"> | nazwa | cena
```

---

# Ściągawka

| **Pojęcie**           | **Co robi?**                          |
| --------------------- | ------------------------------------- |
| **`ORDER BY cena`**   | Cennik od najniższej ceny.            |
| **`$row["kod"] . ".jpg"`** | Ścieżka grafiki kursu.           |
| **`alt='kurs'`**      | Tekst alternatywny z arkusza.         |

---

### Co dalej?

Tabela jest po lewej. W formularzu zbudujesz **listę rozwijaną** z nazw kursów.

👉 **[Przejdź do Kroku 2: Lista rozwijana](../02_lista_rozwijana_kursow/README.md)**
