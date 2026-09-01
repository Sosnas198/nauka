# Kompletny przewodnik: Skrypt 1 — radio, domyślny Policjant, `<h3>` i tabela personelu

Ta ściąga wytłumaczy Ci **od A do Z** połączenie **proceduralne** MySQLi, odczyt pola radio z POST, wartość początkową „Policjant” oraz budowę tabeli HTML z wyników zapytania.

---

## SEC-1: Połączenie proceduralne (`mysqli_connect` / `mysqli_close`)

Arkusz: localhost, **root** bez hasła, baza **`zgloszenia`**. Zamknięcie: **`mysqli_close`**.

```php
$conn = mysqli_connect("localhost", "root", "", "zgloszenia");
```

To **nie** jest `new mysqli(...)`. Argumenty są te same (host, user, hasło, baza), ale wynik to identyfikator połączenia przekazywany **jako pierwszy argument** kolejnych funkcji:

```php
mysqli_query($conn, $zapytanie);
mysqli_fetch_assoc($wynik);
mysqli_close($conn);
```

| Styl obiektowy (projekty 01–05) | Styl proceduralny (ten arkusz)      |
| ------------------------------- | ----------------------------------- |
| `$conn = new mysqli(...)`       | `$conn = mysqli_connect(...)`       |
| `$conn->query($sql)`            | `mysqli_query($conn, $sql)`         |
| `$result->fetch_assoc()`        | `mysqli_fetch_assoc($result)`       |
| `$conn->close()`                | `mysqli_close($conn)`               |

---

## SEC-2: Formularz radio — `name`, `value`, `checked`

```html
<form action="index.php" method="post">
    <label>
        <input type="radio" name="personel" value="Policjant" checked>
        Policjant
    </label>
    <label>
        <input type="radio" name="personel" value="Ratownik">
        Ratownik
    </label>
    <button type="submit" name="pokaz">Pokaż</button>
</form>
```

- **`name="personel"`** (ten sam dla obu) — w POST jest **jedna** wartość: kliknięte radio.
- **`value="Policjant"` / `"Ratownik"`** — to idzie do PHP (wielka litera, jak etykieta).
- **`checked`** na pierwszym polu — **stan początkowy**: opcja policjant, zgodnie z arkuszem.
- **`method="post"`** — wybór nie pojawia się w URL.

---

## SEC-3: Domyślny `'Policjant'` i nadpisanie z POST

Arkusz: rekordy z opcją z formularza **albo w stanie początkowym z opcją policjant**.

```php
$wybranaOpcja = "Policjant";

if (isset($_POST["personel"])) {
    $wybranaOpcja = $_POST["personel"];
}
```

Przy pierwszym wejściu (GET) nie ma POST → zostaje **Policjant**. Po kliknięciu „Pokaż” nadpisujesz wartością radio.

Nagłówek **trzeciego stopnia przed tabelą**:

```php
echo "<h3>Wybrano opcję: " . $wybranaOpcja . "</h3>";
```

Dokładna treść z arkusza: **„Wybrano opcję: \<opcja\>”** (np. `Wybrano opcję: Policjant`).

---

## SEC-4: Zapytanie ze zmienną statusu

```sql
SELECT id, imie, nazwisko FROM personel WHERE status = '$statusPersonelu';
```

W bazie `status` bywa zapisany **małymi** literami (`policjant`, `ratownik`). Wartości radio mają wielką literę. Kontrolka sprowadza je do małych:

```php
$statusPersonelu = strtolower($wybranaOpcja);
$zapytanie = "SELECT id, imie, nazwisko FROM personel WHERE status = '$statusPersonelu'";
$wynik = mysqli_query($conn, $zapytanie);
```

- **`strtolower("Policjant")`** → `"policjant"` do `WHERE`.
- Na ekranie w `<h3>` zostawiasz **`$wybranaOpcja`** (z wielką literą z formularza).

Wysyłka: `mysqli_query($conn, $zapytanie)` — połączenie **pierwsze**, SQL **drugie**.

---

## SEC-5: Wiersze tabeli HTML w pętli

Nagłówki kolumn (`Id`, `Imię`, `Nazwisko`) są w HTML. PHP dopisuje **`<tr>`** z danymi:

```php
while ($wiersz = mysqli_fetch_assoc($wynik)) {
    echo "<tr>";
    echo "<td>" . $wiersz["id"] . "</td>";
    echo "<td>" . $wiersz["imie"] . "</td>";
    echo "<td>" . $wiersz["nazwisko"] . "</td>";
    echo "</tr>";
}
```

`mysqli_fetch_assoc` = odpowiednik `$result->fetch_assoc()`. Klucze: `id`, `imie`, `nazwisko`.

Zapytanie możesz wykonać **nad** tabelą (żeby wcześniej wypisać `<h3>`), a pętlę zostawić **wewnątrz** `<table>`.

---

# Podsumowanie przepływu danych

```text
mysqli_connect(..., "zgloszenia")
                 ↓
$wybranaOpcja = "Policjant"
jeśli POST personel → nadpisz
                 ↓
<h3>Wybrano opcję: …</h3>
                 ↓
WHERE status = strtolower(opcja)
                 ↓
while mysqli_fetch_assoc → <tr><td>…
```

---

# Ściągawka

| **Pojęcie**                    | **Co robi?**                                      |
| ------------------------------ | ------------------------------------------------- |
| **`mysqli_connect`**           | Otwiera połączenie (styl proceduralny).           |
| **`checked`**                  | Domyślne radio: Policjant.                        |
| **`$wybranaOpcja = "Policjant"`** | Stan początkowy bez POST.                      |
| **`strtolower`**               | Dopasowanie `value` radio do kolumny `status`.    |
| **`<h3>Wybrano opcję:`**       | Nagłówek 3. stopnia przed tabelą.                 |
| **`mysqli_fetch_assoc`**       | Jeden wiersz jako tablica asocjacyjna.            |

---

### Co dalej?

Tabela personelu jest gotowa. Po prawej: osoby, które **nie mają** zgłoszenia w `rejestr`.

👉 **[Przejdź do Kroku 2: LEFT JOIN i lista bez zgłoszeń](../02_lista_bez_zgloszen_left_join/README.md)**
