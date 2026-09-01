> **Krok 2 z 2** | [W Kroku 1](../01_tabela_pojazdow_join/README.md) masz stałą tabelę alfa. Teraz **Skrypt 2**: dwa **losowe** pojazdy i konkretne wiersze tabeli konfiguratora.

---

# Kompletny przewodnik: Skrypt 2 — `ORDER BY RAND() LIMIT 2` oraz wiersze 3–4 i 6–7

Ta ściąga wytłumaczy Ci **od A do Z** losowanie w SQL, licznik `$nr` do plików `a1.jpg` / `a2.jpg` oraz dlaczego dane pierwszego auta lądują w wierszach **3 i 4**, a drugiego w **6 i 7**.

---

## SEC-1: Zapytanie losujące dwa rekordy

```sql
SELECT marka, model, cena FROM pojazdy ORDER BY RAND() LIMIT 2;
```

- **`ORDER BY RAND()`** — MySQL ustawia wiersze w **losowej** kolejności przy każdym odświeżeniu strony.
- **`LIMIT 2`** — dokładnie dwa pojazdy (dwie konfiguracje).

To **nie** jest filtr `alfa`. Losujesz z całej tabeli `pojazdy`.

```php
$query = "SELECT marka, model, cena FROM pojazdy ORDER BY RAND() LIMIT 2;";
$result = $conn->query($query);
```

Dwa wiersze → pętla `while` wykona się **dwa razy**.

---

## SEC-2: Numeracja wierszy HTML w tabeli konfiguratora

W HTML **pierwszy** wiersz tabeli (nagłówek) jest stały:

```html
<tr>
    <th colspan="2">Konfiguracja</th>
    <th>Cena</th>
</tr>
```

To jest **wiersz 1**. PHP dopisuje dalsze `<tr>`.

Dla **każdego** wylosowanego auta kontrolka dodaje **trzy** wiersze:

| Kolejność w pętli | Co wstawia PHP        | Numer wiersza w całej tabeli |
| ----------------- | --------------------- | ---------------------------- |
| 1. obieg          | obraz `a1.jpg`        | **2**                        |
| 1. obieg          | Marka + cena          | **3** ← dane 1. rekordu      |
| 1. obieg          | Model                 | **4** ← dane 1. rekordu      |
| 2. obieg          | obraz `a2.jpg`        | **5**                        |
| 2. obieg          | Marka + cena          | **6** ← dane 2. rekordu      |
| 2. obieg          | Model                 | **7** ← dane 2. rekordu      |

Arkusz: *pierwszy rekord w wierszach 3 i 4; drugi rekord w wierszach 6 i 7* — to właśnie **Marka** i **Model** (nie obraz).

Cena jest w komórce z **`rowspan="2"`**, żeby stać obok obu etykiet Marka/Model.

---

## SEC-3: Obraz konfiguracji — `a` + numer + `.jpg`

```php
$nr = 1;

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td colspan='3'><img src='a" . $nr . ".jpg' alt='Konfiguracja " . $nr . "'></td>";
    echo "</tr>";
    // … marka, model …
    $nr++;
}
```

- Pierwszy obieg: **`a1.jpg`**
- Drugi obieg: **`a2.jpg`**

`$nr` **nie** pochodzi z bazy — to kolejność wylosowanych wierszy (1, potem 2).

---

## SEC-4: Wiersze Marka / Model i `rowspan` ceny

```php
echo "<tr>";
echo "<td>Marka</td>";
echo "<td>" . $row["marka"] . "</td>";
echo "<td rowspan='2'>" . $row["cena"] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Model</td>";
echo "<td>" . $row["model"] . "</td>";
echo "</tr>";
```

Trzy kolumny: etykieta | wartość | cena (scalona na dwa wiersze).

Nagłówek ma `colspan="2"` na „Konfiguracja”, żeby siatka się zgadzała.

---

# Podsumowanie przepływu danych

```text
SELECT marka, model, cena ORDER BY RAND() LIMIT 2
                 ↓
$nr = 1
while fetch_assoc (2 razy)
                 ↓
<tr> obraz a{$nr}.jpg
<tr> Marka | … | cena rowspan=2
<tr> Model | …
                 ↓
$nr++
```

---

# Ściągawka

| **Pojęcie**            | **Co robi?**                                           |
| ---------------------- | ------------------------------------------------------ |
| **`ORDER BY RAND()`**  | Losowa kolejność wierszy z bazy.                       |
| **`LIMIT 2`**          | Dwie konfiguracje.                                     |
| **Wiersze 3 i 4**      | Marka i model **pierwszego** wylosowanego auta.        |
| **Wiersze 6 i 7**      | Marka i model **drugiego** auta.                       |
| **`a1.jpg` / `a2.jpg`**| Grafiki w wierszach 2 i 5.                             |
| **`rowspan="2"`**      | Jedna cena obok dwóch etykiet.                         |

---

### Gratulacje!

Masz pełny cykl salonu: JOIN z ceną całkowitą oraz dwie losowe konfiguracje w ustalonej siatce wierszy.

🏠 **[Wróć do głównego spisu treści](../README.md)**
