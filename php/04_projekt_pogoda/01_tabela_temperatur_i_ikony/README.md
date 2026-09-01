# Kompletny przewodnik: Skrypt 1 — tabela temperatur, JOIN i ikony według progów °C

Ta ściąga wytłumaczy Ci **od A do Z** połączenie z bazą `pogoda`, złączenie tabel `miejscowosc` i `pomiary`, budowę wierszy HTML oraz wybór pliku graficznego na podstawie temperatury.

---

## SEC-1: Dane dostępowe i baza `pogoda`

Arkusz: **localhost**, użytkownik **root** **bez hasła**, baza **`pogoda`**. Na końcu skryptu: **`$conn->close()`**.

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pogoda";

$conn = new mysqli($host, $user, $pass, $db);
```

Skrót z kontrolki:

```php
$conn = new mysqli("localhost", "root", "", "pogoda");
```

Nazwa bazy **musi** być `pogoda`. Połączenie otwierasz **na górze** `index.php`, zamykasz **po** całym HTML.

---

## SEC-2: Zapytanie JOIN — miejscowość + pomiar z lipca

Arkusz podaje zapytanie wprost (lipiec = miesiąc o `id_miesiac = 7`):

```sql
SELECT miejscowosc.nazwa, miejscowosc.kraj, pomiary.temperatura
FROM miejscowosc
JOIN pomiary ON miejscowosc.id = pomiary.id_miejscowosc
WHERE pomiary.id_miesiac = 7;
```

- **`miejscowosc.nazwa`** — miasto (1. kolumna tabeli).
- **`miejscowosc.kraj`** — kraj (2. kolumna).
- **`pomiary.temperatura`** — temperatura (3. kolumna **oraz** warunek ikony).
- **`JOIN … ON miejscowosc.id = pomiary.id_miejscowosc`** — dopasuj pomiar do miasta.
- **`WHERE pomiary.id_miesiac = 7`** — tylko lipiec (to **nie** jest parametr GET; Skrypt 1 jest stały).

Pełne nazwy tabel (bez aliasów `m`, `p`) są czytelniejsze na egzaminie.

Wyników jest **wiele** — każdy wiersz SQL to jeden wiersz tabeli HTML.

---

## SEC-3: Nagłówek tabeli w HTML, wiersze z PHP

Część stała (Miasto, Kraj, Temperatura, Pogoda) jest w HTML **przed** skryptem. PHP dopisuje tylko **` <tr>` z danymi**.

```php
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["nazwa"] . "</td>";
    echo "<td>" . $row["kraj"] . "</td>";
    echo "<td>" . $row["temperatura"] . "</td>";
    // czwarta komórka: ikona (SEC-4)
    echo "</tr>";
}
```

| Kolumna HTML     | Pole z `$row`          |
| ---------------- | ---------------------- |
| 1. Miasto        | `$row["nazwa"]`        |
| 2. Kraj          | `$row["kraj"]`         |
| 3. Temperatura   | `$row["temperatura"]`  |
| 4. Pogoda        | obraz zależny od °C    |

Klucze tablicy pochodzą z **nazw kolumn** (lub aliasów) w `SELECT`. Tu nie ma aliasów, więc `nazwa`, `kraj`, `temperatura`.

---

## SEC-4: Trzy progi — `slonce.png`, `deszcz.png`, `chmury.png`

Arkusz (kolejność warunków ma znaczenie):

| Warunek                         | Plik           |
| ------------------------------- | -------------- |
| temperatura **powyżej 30 °C**   | `slonce.png`   |
| temperatura **poniżej 26 °C**   | `deszcz.png`   |
| **w innych przypadkach**        | `chmury.png`   |

„Inne przypadki” to zakres **od 26 do 30 włącznie** (ani `> 30`, ani `< 26`).

```php
if ($row["temperatura"] > 30) {
    echo "<td><img src='slonce.png' alt='Słońce'></td>";
} else if ($row["temperatura"] < 26) {
    echo "<td><img src='deszcz.png' alt='Deszcz'></td>";
} else {
    echo "<td><img src='chmury.png' alt='Chmury'></td>";
}
```

### Typowe błędy

- **`>= 30` zamiast `> 30`** — przy dokładnie 30 °C arkusz każe **chmury**, nie słońce.
- **`<= 26` zamiast `< 26`** — przy dokładnie 26 °C mają być **chmury**, nie deszcz.
- Ikona **w czwartej komórce** (`<td>…</td>`), nie luzem obok tabeli.
- Porównujesz **`$row["temperatura"]`**, nie stałą i nie GET.

`if` / `else if` / `else` gwarantuje **dokładnie jedną** ikonę na wiersz.

---

# Podsumowanie przepływu danych

```text
new mysqli(..., "pogoda")
                 ↓
JOIN miejscowosc + pomiary  WHERE id_miesiac = 7
                 ↓
while fetch_assoc()
                 ↓
<tr> nazwa | kraj | temperatura | ikona
                 ↓
> 30 → slonce.png
< 26 → deszcz.png
else → chmury.png
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie**                 | **Co robi?**                                           |
| --------------------------- | ------------------------------------------------------ |
| **Baza `pogoda`**           | Nazwa bazy z arkusza.                                  |
| **`JOIN` + `id_miejscowosc`** | Łączy miasto z pomiarem.                             |
| **`id_miesiac = 7`**        | Stały filtr Skryptu 1 (lipiec).                        |
| **`> 30` / `< 26` / `else`**| Progi ikon dokładnie jak w arkuszu.                    |
| **`slonce.png` itd.**       | Pliki graficzne w czwartej kolumnie.                   |

---

### Co dalej?

Tabela lipca jest gotowa. Po prawej stronie użytkownik klika miesiąc — wtedy **Skrypt 2** liczy średnią w SQL.

👉 **[Przejdź do Kroku 2: Średnia temperatura i GET](../02_srednia_temperatura_get/README.md)**
