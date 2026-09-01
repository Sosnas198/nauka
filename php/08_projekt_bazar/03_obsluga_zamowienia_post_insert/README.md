> **Krok 3 z 3** | [W Kroku 2](../02_generowanie_listy_rozwijanej/README.md) formularz wysyła `id` i `waga`. Teraz **Skrypt 3**: cena z bazy, wartość zamówienia i `INSERT INTO zamowienie`.

---

# Kompletny przewodnik: Skrypt 3 — POST, `cena * waga` oraz `INSERT`

Ta ściąga wytłumaczy Ci **od A do Z** strażnik `isset`, odczyt ceny jednego towaru, komunikat podsumowania i zapis wiersza w tabeli `zamowienie`.

---

## SEC-1: Skrypt tylko po wysłaniu formularza (`$_POST`)

Arkusz: wykonywany po wysłaniu danych z formularza.

```php
if (isset($_POST["waga"], $_POST["id"])) {
    $id = $_POST["id"];
    $waga = $_POST["waga"];
    // dalej SELECT, echo, INSERT
}
```

**`isset($_POST["waga"], $_POST["id"])`** — oba klucze muszą istnieć (skrót zamiast dwóch `isset` połączonych `&&`).

Przy pierwszym wejściu na stronę (GET) **nie** liczysz i **nie** wstawiasz rekordu.

W kontrolce dodatkowo `(int)` i sprawdzenie `$id > 0 && $waga > 0` — na egzaminie wystarczy `isset` + odczyt, jeśli arkusz nie każe walidacji.

---

## SEC-2: Pobranie ceny (oraz nazwy i rodzaju) z tabeli `towar`

Potrzebujesz **ceny** tego `id`, które przyszło z listy:

```sql
SELECT nazwa, rodzaj, cena FROM towar WHERE id = $id;
```

Jeden towar → **jedno** `mysqli_fetch_array`, bez `while`.

```php
$query = "SELECT nazwa, rodzaj, cena FROM towar WHERE id = $id;";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

$nazwa = $row["nazwa"];
$rodzaj = $row["rodzaj"];
$cena = $row["cena"];
```

---

## SEC-3: Wartość zamówienia — `cena * waga`

```php
$wartosc = $row["cena"] * $waga;
```

To mnożenie w **PHP**, nie funkcja SQL `AVG`. Waga jest z formularza, cena z bazy.

Komunikat (rodzaj, nazwa, kwota):

```php
echo "<p>" . $rodzaj . " " . $nazwa . " " . $wartosc . " zł</p>";
```

Przykład: `owoc Jabłko 12 zł`.

---

## SEC-4: `INSERT INTO zamowienie`

Arkusz: wstaw rekord instrukcją `INSERT INTO`.

Typowa postać z kontrolki:

```sql
INSERT INTO zamowienie VALUES (NULL, $id, 2, $waga);
```

| Fragment     | Znaczenie                                              |
| ------------ | ------------------------------------------------------ |
| **`NULL`**   | Auto increment — id zamówienia nadaje baza.            |
| **`$id`**    | Id towaru z `<select>`.                                |
| **`2`**      | Stała z arkusza (np. id stoiska / klienta) — nie z POST. |
| **`$waga`**  | Waga z inputa.                                         |

```php
$insertQuery = "INSERT INTO zamowienie VALUES (NULL, $id, 2, $waga);";
mysqli_query($conn, $insertQuery);
```

`INSERT` nic nie wyświetla — na ekranie widać tylko paragraf z wartością. Kolejność w kontrolce: **najpierw echo podsumowania, potem INSERT** (albo odwrotnie — oba są poprawne, byle oba się wykonały po udanym SELECT).

Ten skrypt stoi **w HTML pod formularzem** (wynik ma się pokazać na stronie). Nie musisz go dawać na samą górę pliku jak INSERT w projekcie zgłoszeń — tu lista towarów nie zależy od nowych zamówień.

---

# Podsumowanie przepływu danych

```text
POST: id, waga
                 ↓
isset → TAK
                 ↓
SELECT nazwa, rodzaj, cena WHERE id = …
                 ↓
wartosc = cena * waga
                 ↓
<p>rodzaj nazwa wartosc zł</p>
                 ↓
INSERT INTO zamowienie VALUES (NULL, id, 2, waga)
```

---

# Ściągawka

| **Pojęcie**                    | **Co robi?**                                |
| ------------------------------ | ------------------------------------------- |
| **`isset($_POST["id"], …)`**   | Skrypt tylko po „Zamów”.                    |
| **`cena * waga`**              | Wartość do wypisania.                       |
| **`$row["rodzaj"]`**           | Część komunikatu (owoc / warzywo).          |
| **`INSERT … NULL, $id, 2, $waga`** | Nowy wiersz w `zamowienie`.             |

---

### Gratulacje!

Masz pełny cykl bazaru: galeria, select oraz zamówienie z zapisem do bazy.

🏠 **[Wróć do głównego spisu treści](../README.md)**
