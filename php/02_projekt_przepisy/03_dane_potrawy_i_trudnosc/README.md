> **Krok 3 z 5** | [W Kroku 2](../02_wyswietlanie_rodzaju/README.md) wyświetliliśmy rodzaj. Teraz **Skrypt 2**: zapytanie 1 z filtrem ID oraz mapowanie liczby `trudnosc` na tekst.

---

# Kompletny przewodnik: Skrypt 2 — nazwa, trudność i kalorie

Ta ściąga wytłumaczy Ci **od A do Z** odczyt trzech kolumn z tabeli `potrawy` oraz zamianę kodu trudności (1, 2, 3) na słowa wymagane w arkuszu.

---

## SEC-1: Zapytanie 1 zmodyfikowane o zmienną ID

Arkusz: wyślij **zapytanie 1**, tak zmodyfikowane, że sprawdzana jest zmienna ID.

```sql
SELECT nazwa, trudnosc, kalorie
FROM potrawy
WHERE idPotrawy = $id;
```

Tu nie potrzebujesz `JOIN` — wszystkie trzy pola są w tabeli `potrawy`.

---

## SEC-2: Nagłówek drugiego stopnia z nazwą potrawy

Arkusz: wyświetl **nagłówek drugiego stopnia** z nazwą potrawy.

W HTML nagłówek drugiego stopnia to `<h2>`:

```php
echo "<h2>" . $row["nazwa"] . "</h2>";
```

To nie jest `<h1>` (ten został użyty przy rodzaju w Skrypcie 1).

---

## SEC-3: Mapowanie `trudnosc` na tekst

W bazie `trudnosc` to liczba. Na stronie ma być słowo:

| Wartość w bazie | Tekst na stronie |
| --------------- | ---------------- |
| `1`             | `łatwe`          |
| `2`             | `średnie`        |
| `3`             | `trudne`         |

```php
if ($row["trudnosc"] == 1) {
    $trudnosc = "łatwe";
} else if ($row["trudnosc"] == 2) {
    $trudnosc = "średnie";
} else if ($row["trudnosc"] == 3) {
    $trudnosc = "trudne";
}
```

Porównanie `==` wystarczy (GET i kolumny bywają stringami `"1"`). Nie wypisujesz surowej cyfry z bazy.

---

## SEC-4: Paragraf według wzoru z arkusza

Dokładna treść:

```text
Trudność: <trudnosc>, Kalorie: <kalorie>
```

Przykład: `Trudność: średnie, Kalorie: 450`

```php
echo "<p>Trudność: " . $trudnosc . ", Kalorie: " . $row["kalorie"] . "</p>";
```

Zwróć uwagę na spacje i przecinek — tak jest w arkuszu.

---

# Podsumowanie przepływu danych

```text
SELECT nazwa, trudnosc, kalorie WHERE idPotrawy = $id
                 ↓
$row = fetch_assoc()
                 ↓
<h2> ← $row["nazwa"]
                 ↓
1 → łatwe | 2 → średnie | 3 → trudne
                 ↓
<p>Trudność: ..., Kalorie: ...</p>
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element** | **Co oznacza / Co robi?**                         |
| --------------------- | ------------------------------------------------- |
| **`<h2>`**            | Nagłówek drugiego stopnia z nazwą potrawy.        |
| **`trudnosc`**        | Liczba 1–3 w bazie, nie tekst.                    |
| **`łatwe / średnie / trudne`** | Jedyna dozwolona forma na stronie.     |
| **`$row["kalorie"]`** | Wartość kalorii wstawiana do paragrafu.           |

---

### Co dalej?

**Skrypt 3**: lista alergenów (wiele wierszy, pętla `while`).

👉 **[Przejdź do Kroku 4: Lista alergenów](../04_lista_alergenow/README.md)**
