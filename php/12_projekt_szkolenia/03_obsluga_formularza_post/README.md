> **Krok 3 z 3** | [W Kroku 2](../02_lista_rozwijana_kursow/README.md) select wysyła nazwę kursu. Teraz **Skrypt 3**: czy pola są puste, `INSERT` do `uczestnicy` i komunikaty.

---

# Kompletny przewodnik: Skrypt 3 — POST, `empty()` oraz `INSERT INTO uczestnicy`

Ta ściąga wytłumaczy Ci **od A do Z** wykrycie wysłania formularza, walidację czterech pól, zapis uczestnika i dwa komunikaty z arkusza.

---

## SEC-1: Czy formularz został wysłany?

Najczęściej na egzaminie:

```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // walidacja i INSERT
}
```

Albo: `if (isset($_POST["imie"]))` — po kliknięciu przycisku pola lądują w POST.

Przy zwykłym wejściu na stronę (GET) **nie** wstawiasz rekordu i **nie** pokazujesz komunikatu sukcesu.

---

## SEC-2: Walidacja — `empty()` na wszystkich polach

Arkusz: sprawdź, czy pola zostały **uzupełnione**.

```php
if (empty($_POST["imie"]) || empty($_POST["nazwisko"]) || empty($_POST["wiek"]) || empty($_POST["kurs"])) {
    echo "<p>Wprowadź wszystkie dane</p>";
} else {
    // INSERT i komunikat sukcesu
}
```

**`empty()`** jest prawdą przy braku klucza, pustym stringu `""` i `"0"`. Operator **`||`** — wystarczy **jedno** puste pole.

Komunikat przy błędzie (dokładna treść z kontrolki): **`Wprowadź wszystkie dane`**.

---

## SEC-3: `INSERT` do tabeli `uczestnicy`

Po udanej walidacji odczytujesz POST i wstawiasz wiersz.

Wersja egzaminacyjna (`query`):

```php
$imie = $_POST["imie"];
$nazwisko = $_POST["nazwisko"];
$wiek = $_POST["wiek"];

$query = "INSERT INTO uczestnicy (imie, nazwisko, wiek) VALUES ('$imie', '$nazwisko', $wiek);";
$conn->query($query);
```

Kontrolka bywa z **prepared statement** (`prepare`, `bind_param("ssi", …)`). Arkusz dopuszcza zwykłe SQL **albo** instrukcje przygotowane. Na INF.03 zwykle wystarczy `$conn->query($query)`.

W kontrolce do `uczestnicy` idą **imie, nazwisko, wiek** — **bez** nazwy kursu z selecta (select służy do walidacji „czy wybrano kurs”, niekoniecznie do kolumny w INSERT). Stosuj się do struktury tabeli z arkusza, jeśli tam jest też kolumna kursu.

---

## SEC-4: Komunikat o dodaniu

```php
echo "<p>Dane uczestnika " . $imie . " " . $nazwisko . " zostały dodane</p>";
```

Przykład: `Dane uczestnika Anna Kowalska zostały dodane`.

Ten tekst pokaż **tylko** w gałęzi `else` (gdy wszystkie pola są wypełnione).

---

# Podsumowanie przepływu danych

```text
REQUEST_METHOD == POST?
                 ↓
któreś pole empty?
   TAK → <p>Wprowadź wszystkie dane</p>
   NIE → INSERT INTO uczestnicy (imie, nazwisko, wiek)
         → <p>Dane uczestnika X Y zostały dodane</p>
```

---

# Ściągawka

| **Pojęcie**                         | **Co robi?**                              |
| ----------------------------------- | ----------------------------------------- |
| **`$_SERVER["REQUEST_METHOD"]`**    | Czy to wysyłka formularza (POST).         |
| **`empty()`**                       | Czy pole nieuzupełnione.                  |
| **`INSERT INTO uczestnicy`**        | Nowy wiersz uczestnika.                   |
| **„Wprowadź wszystkie dane”**       | Komunikat błędu.                          |
| **„Dane uczestnika … zostały dodane”** | Komunikat sukcesu.                     |

---

### Gratulacje!

Masz pełny cykl zapisów: cennik, select oraz walidowany INSERT.

🏠 **[Wróć do głównego spisu treści](../README.md)**
