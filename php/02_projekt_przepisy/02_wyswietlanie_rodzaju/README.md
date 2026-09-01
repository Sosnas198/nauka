> **Krok 2 z 5** | [Poprzednio](../01_polaczenie_z_baza_i_id/README.md) nawiązaliśmy połączenie i ustaliliśmy `$id`. Teraz wykonamy **Skrypt 1**: zapytanie 2 zmodyfikowane o warunek ID oraz wyświetlenie pola `rodzaj`.

---

# Kompletny przewodnik: Skrypt 1 — rodzaj potrawy (`JOIN` z tabelą `rodzaje`)

Ta ściąga wytłumaczy Ci **od A do Z** złączenie tabel `potrawy` i `rodzaje`, filtrowanie po ID oraz odczyt **jednego** pola z wyniku.

---

## SEC-1: Po co JOIN? Kolumna `rodzaj` nie leży w tabeli `potrawy`

W tabeli `potrawy` jest zwykle klucz obcy, np. `idRodzaje`, a **nazwa rodzaju** (np. „Deser”, „Danie główne”) siedzi w osobnej tabeli `rodzaje`.

Bez `JOIN` nie masz tekstu do wyświetlenia — masz tylko numer.

Relacja: **wiele potraw → jeden rodzaj** (N:1).

---

## SEC-2: Zapytanie 2 zmodyfikowane o zmienną ID

Arkusz: wyślij do bazy **zapytanie 2**, tak zmodyfikowane, że sprawdzana jest zmienna ID.

Typowa postać (zgodna z kontrolką):

```sql
SELECT potrawy.nazwa, rodzaje.rodzaj
FROM potrawy
JOIN rodzaje ON potrawy.idRodzaje = rodzaje.idRodzaje
WHERE potrawy.idPotrawy = $id;
```

### Rozbicie na części

- **`SELECT potrawy.nazwa, rodzaje.rodzaj`** — bierzemy kolumny z dwóch tabel; na stronie potrzebujemy przede wszystkim `rodzaj`.
- **`FROM potrawy`** — tabela główna (konkretna potrawa).
- **`JOIN rodzaje ON potrawy.idRodzaje = rodzaje.idRodzaje`** — dopasuj wiersz rodzaju po kluczu obcym.
- **`WHERE potrawy.idPotrawy = $id`** — **modyfikacja z arkusza**: tylko rekord o naszym ID (GET albo 7).

Pełne nazwy tabel (`potrawy.idPotrawy`) bez aliasów (`p`, `r`) są czytelniejsze na egzaminie.

---

## SEC-3: Wykonanie zapytania i pojedynczy `fetch_assoc()`

```php
$result = $conn->query($query);
$row = $result->fetch_assoc();
```

Dla jednego ID wraca **co najwyżej jeden wiersz** (jedna potrawa = jeden rodzaj). Nie potrzebujesz pętli `while`.

`$row['rodzaj']` to wartość kolumny `rodzaj` z tabeli `rodzaje`.

---

## SEC-4: Co ma się pojawić na stronie?

Arkusz: **wyświetl wartość zwróconą polem `rodzaj`**.

W układzie witryny (kontrolka) jest to nagłówek pierwszego stopnia:

```php
echo "<h1>" . $row["rodzaj"] . "</h1>";
```

To ten tekst, który użytkownik widzi nad nazwą konkretnej potrawy.

---

# Podsumowanie przepływu danych

```text
$id (z GET albo 7)
                 ↓
SELECT ... JOIN rodzaje ... WHERE idPotrawy = $id
                 ↓
$conn->query($query) → $result
                 ↓
$row = $result->fetch_assoc()
                 ↓
echo pole rodzaj (np. w <h1>)
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**     | **Co oznacza / Co robi?**                                      |
| ------------------------- | -------------------------------------------------------------- |
| **`JOIN rodzaje`**        | Dokleja nazwę rodzaju do wiersza potrawy.                      |
| **`idRodzaje`**           | Klucz łączący `potrawy` z `rodzaje`.                           |
| **`WHERE idPotrawy = $id`** | Filtr Skryptu 1 według zmiennej ID.                          |
| **`$row["rodzaj"]`**      | Tekst rodzaju do wyświetlenia.                                 |

---

### Co dalej?

Mamy rodzaj. Teraz **Skrypt 2**: nazwa, trudność słownie i kalorie.

👉 **[Przejdź do Kroku 3: Dane potrawy i trudność](../03_dane_potrawy_i_trudnosc/README.md)**
