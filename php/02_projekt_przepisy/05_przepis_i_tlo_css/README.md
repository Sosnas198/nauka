> **Krok 5 z 5** | [W Kroku 4](../04_lista_alergenow/README.md) wypisaliśmy alergeny. Teraz **Skrypt 4**: pole `przepis` na stronie oraz pole `plik` jako tło sekcji.

---

# Kompletny przewodnik: Skrypt 4 — treść przepisu i tło CSS (`plik`)

Ta ściąga wytłumaczy Ci **od A do Z** odczyt dwóch pól z jednego zapytania oraz **rozdzielenie ról**: jedno pole idzie do HTML w `<main>`, drugie do atrybutu `style` w `<section>`.

---

## SEC-1: Zapytanie 4 zmodyfikowane o zmienną ID

Arkusz: wyślij **zapytanie 4**, tak zmodyfikowane, że sprawdzana jest zmienna ID.

```sql
SELECT przepis, plik
FROM potrawy
WHERE idPotrawy = $id;
```

Znów jeden wiersz — jedno `fetch_assoc()`, bez `while`.

---

## SEC-2: Wyświetlenie pola `przepis`

Arkusz: wyświetl wartość pola **`przepis`** zwróconą zapytaniem.

```php
echo "<p>" . $row["przepis"] . "</p>";
```

To treść instrukcji kuchennej (tekst z bazy), nie nazwa pliku graficznego.

---

## SEC-3: Pole `plik` nie jest do `echo` w treści przepisu

Arkusz (cechy witryny / zawartość bloku sekcji):

> Pole `plik` pobrane zapytaniem w tym skrypcie powinno zostać użyte do ustawienia **tła sekcji** stylem CSS **inline**.

Zapisujesz nazwę pliku do zmiennej:

```php
$plik = $row["plik"];
```

Tej zmiennej użyjesz **później**, poza blokiem Skryptu 4 w `<main>` — w znaczniku `<section>`.

Dlatego `$plik` musi powstać **zanim** przeglądarka dojdzie do sekcji (w PHP: przed wypisaniem tego tagu).

---

## SEC-4: Inline CSS — `background-image`

Styl wpisany w atrybut `style` elementu HTML to styl **inline**.

```html
<section style="background-image: url('nazwa_z_bazy.jpg');">
```

W PHP:

```php
<section style="background-image: url('<?php echo $plik; ?>');">
```

- **`background-image`** — właściwość CSS tła.
- **`url('...')`** — ścieżka / nazwa pliku z kolumny `plik`.
- PHP wstawia wartość `$plik` w momencie generowania strony.

W kontrolce sekcja jest **obok** `<main>` (trzecia kolumna układu), a nie wewnątrz skryptu z paragrafem przepisu. Skrypt 4 i tak **pobiera** `plik`; **użycie** następuje w tagu `<section>`.

---

# Podsumowanie przepływu danych

```text
SELECT przepis, plik WHERE idPotrawy = $id
                 ↓
$row = fetch_assoc()
                 ↓
$plik = $row["plik"]          → później: style sekcji
echo $row["przepis"]          → paragraf w <main>
                 ↓
<section style="background-image: url('<?php echo $plik; ?>');">
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**        | **Co oznacza / Co robi?**                                      |
| ---------------------------- | -------------------------------------------------------------- |
| **`przepis`**                | Tekst instrukcji wyświetlany w treści strony.                  |
| **`plik`**                   | Nazwa grafiki tła — nie treść do paragrafu.                    |
| **`$plik`**                  | Zmienna PHP przekazująca nazwę pliku do HTML sekcji.           |
| **Styl inline**              | Atrybut `style="..."` bezpośrednio na znaczniku.               |
| **`background-image: url()`** | Ustawienie tła sekcji według arkusza.                         |

---

### Gratulacje!

Masz pełny cykl strony przepisu: połączenie, ID (GET lub 7), cztery skrypty SQL i tło z bazy.

🏠 **[Wróć do głównego spisu treści](../README.md)**
