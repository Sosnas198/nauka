> **Krok 2 z 3** | [W Kroku 1](../01_filtrowanie_personelu_radio/README.md) filtrowaliśmy personel. Teraz **Skrypt 2**: kto **nie ma** żadnego wiersza w tabeli `rejestr`.

---

# Kompletny przewodnik: Skrypt 2 — `LEFT JOIN` i `WHERE … IS NULL`

Ta ściąga wytłumaczy Ci **od A do Z**, dlaczego zwykły `JOIN` tu nie wystarczy oraz jak znaleźć rekordy **bez** pary w drugiej tabeli.

---

## SEC-1: Po co `LEFT JOIN`, a nie zwykły `JOIN`?

**`JOIN` (INNER)** zostawia tylko wiersze, które **mają** dopasowanie po obu stronach. Osoba bez zgłoszenia **zniknęłaby** z wyniku.

**`LEFT JOIN`** bierze **wszystkich** z lewej tabeli (`personel`) i dokleja dane z prawej (`rejestr`), gdy się da. Gdy nie ma zgłoszenia, kolumny z `rejestr` są **`NULL`**.

Szukamy właśnie tych „pustych” dopasowań.

---

## SEC-2: Zapytanie z arkusza

```sql
SELECT personel.id, personel.nazwisko
FROM personel
LEFT JOIN rejestr ON personel.id = rejestr.id_personel
WHERE id_personel IS NULL;
```

- **`ON personel.id = rejestr.id_personel`** — warunek złączenia.
- **`WHERE id_personel IS NULL`** — w `rejestr` nie znaleziono wiersza (osoba bez zgłoszenia).
- Porównanie z `NULL` to **`IS NULL`**, nie `= NULL`.

W PHP:

```php
$zapytanie = "SELECT personel.id, personel.nazwisko
              FROM personel
              LEFT JOIN rejestr ON personel.id = rejestr.id_personel
              WHERE id_personel IS NULL";
$wynik = mysqli_query($conn, $zapytanie);
```

---

## SEC-3: Lista numerowana `<ol><li>`

Arkusz: wszystkie zwrócone wiersze jako elementy listy numerowanej.

```php
echo "<ol>";
while ($wiersz = mysqli_fetch_assoc($wynik)) {
    echo "<li>" . $wiersz["id"] . " " . $wiersz["nazwisko"] . "</li>";
}
echo "</ol>";
```

Kontrolka wypisuje **id i nazwisko** w jednym `<li>` (spacja w środku). To te osoby, których `id` wpiszesz w formularz Skryptu 3.

Po udanym INSERT ta osoba **znika** z listy przy następnym generowaniu strony — pod warunkiem, że INSERT wykonał się **wcześniej** (Moduł 3).

---

# Podsumowanie przepływu danych

```text
personel  LEFT JOIN  rejestr
                 ↓
wiersze, gdzie rejestr.id_personel IS NULL
                 ↓
<ol>
  <li>id nazwisko</li>
  …
</ol>
```

---

# Ściągawka

| **Pojęcie**             | **Co robi?**                                           |
| ----------------------- | ------------------------------------------------------ |
| **`LEFT JOIN`**         | Zachowuje wszystkich z lewej tabeli.                   |
| **`IS NULL`**           | Wybiera wiersze bez dopasowania po prawej.             |
| **`<ol>`**              | Lista numerowana.                                      |
| **`id` + `nazwisko`**   | Treść pozycji (do wpisania w pole number).             |

---

### Co dalej?

Listę osób bez zgłoszeń uzupełni **INSERT** uruchamiany na górze pliku.

👉 **[Przejdź do Kroku 3: INSERT i CURDATE()](../03_dodawanie_zgloszenia_insert/README.md)**
