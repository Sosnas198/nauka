> **Krok 3 z 3** | [W Kroku 2](../02_lista_bez_zgloszen_left_join/README.md) widać osoby bez zgłoszeń. Teraz **Skrypt 3**: dopisanie wiersza do `rejestr` — **na początku** dokumentu, przed SELECT-ami.

---

# Kompletny przewodnik: Skrypt 3 — `INSERT INTO`, `CURDATE()` i `input type="number"`

Ta ściąga wytłumaczy Ci **od A do Z** zapis nowego zgłoszenia, datę z MySQL oraz dlaczego ten skrypt stoi **nad** zapytaniami odczytującymi.

---

## SEC-1: Kolejność w pliku — INSERT przed SELECT

Arkusz: skrypt umieszczany jest **na początku dokumentu przed zapytaniami odczytującymi**.

Typowy układ `index.php`:

1. `mysqli_connect`
2. **Skrypt 3** (ewentualny `INSERT`)
3. HTML + Skrypt 1 (`SELECT` personel)
4. Skrypt 2 (`SELECT` LEFT JOIN)
5. `mysqli_close`

Gdy użytkownik wyśle formularz „Dodaj zgłoszenie”, najpierw baza **dostaje nowy wiersz**, a dopiero potem Skrypt 2 **czyta** listę. Osoba z listy „bez zgłoszeń” znika od razu na tej samej odpowiedzi serwera.

Gdyby INSERT był na dole strony, Skrypt 2 wykonałby się jeszcze na starych danych.

---

## SEC-2: Warunek `isset` — tylko po kliknięciu przycisku

Arkusz: jeżeli wysłano dane z formularza (`isset($_POST['dodaj_zgloszenie'])`).

```php
if (isset($_POST["dodaj_zgloszenie"]) && isset($_POST["osoba_id"])) {
    $idPersonelu = $_POST["osoba_id"];
    // INSERT
}
```

- **`name="dodaj_zgloszenie"`** na przycisku — po kliknięciu klucz ląduje w POST.
- **`osoba_id`** — `name` pola liczbowego. Drugi `isset` chroni przed pustym POST (kontrolka sprawdza oba).

Przycisk „Pokaż” (radio) **nie** ma tej nazwy — wtedy INSERT się **nie** wykona.

---

## SEC-3: Pole `input type="number"` i zmienna `$idPersonelu`

```html
<form action="index.php" method="post">
    <label for="osoba_id">Wybierz id osoby z listy: </label>
    <input type="number" id="osoba_id" name="osoba_id" min="1" required>
    <button type="submit" name="dodaj_zgloszenie">Dodaj zgłoszenie</button>
</form>
```

Użytkownik wpisuje **id z listy** Skryptu 2. PHP bierze tę liczbę:

```php
$idPersonelu = $_POST["osoba_id"];
```

To wartość wstawiana w miejsce id personelu w `INSERT`.

---

## SEC-4: Zapytanie `INSERT INTO rejestr` i `CURDATE()`

```sql
INSERT INTO rejestr VALUES (NULL, CURDATE(), $idPersonelu, 14);
```

| Fragment            | Znaczenie                                                                 |
| ------------------- | ------------------------------------------------------------------------- |
| **`NULL`**          | Auto increment — baza sama nadaje `id` zgłoszenia.                        |
| **`CURDATE()`**     | Funkcja **MySQL**: dzisiejsza data (nie PHP `date()`).                    |
| **`$idPersonelu`**  | Id z formularza — kolumna powiązania z `personel`.                        |
| **`14`**            | Stała z arkusza (np. id typu wydarzenia) — **nie** z pola formularza.     |

```php
$zapytanieDodaj = "INSERT INTO rejestr VALUES (NULL, CURDATE(), $idPersonelu, 14)";
mysqli_query($conn, $zapytanieDodaj);
```

To zapytanie **niczego nie wyświetla** — nie ma `echo` wyniku. Skutek widać w Skrypcie 2 (krótsza lista).

`INSERT` nie używa `fetch_assoc` — nie ma wierszy do odczytu, tylko zapis.

---

# Podsumowanie przepływu danych

```text
POST: dodaj_zgloszenie + osoba_id
                 ↓
na POCZĄTKU pliku (przed SELECT)
                 ↓
INSERT INTO rejestr VALUES (NULL, CURDATE(), id, 14)
                 ↓
później Skrypt 2: ta osoba już NIE ma id_personel IS NULL
```

---

# Ściągawka

| **Pojęcie**                         | **Co robi?**                                      |
| ----------------------------------- | ------------------------------------------------- |
| **INSERT przed SELECT**             | Lista „bez zgłoszeń” od razu aktualna.            |
| **`isset($_POST['dodaj_zgloszenie'])`** | Strażnik: tylko ten formularz.                |
| **`type="number"` / `osoba_id`**    | Id personelu z listy.                             |
| **`CURDATE()`**                     | Data zgłoszenia po stronie MySQL.                 |
| **`VALUES (NULL, …, 14)`**          | Nowy wiersz: AI, data, id osoby, stała 14.        |

---

### Gratulacje!

Masz pełny cykl: filtr radio, osoby bez relacji oraz dopisywanie zgłoszenia na początku skryptu.

🏠 **[Wróć do głównego spisu treści](../README.md)**
