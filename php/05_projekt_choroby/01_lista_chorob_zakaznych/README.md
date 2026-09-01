# Kompletny przewodnik: Skrypt 1 — choroby zakaźne na liście numerowanej (`<ol>`)

Ta ściąga wytłumaczy Ci **od A do Z** połączenie z bazą `choroby`, filtr `zakazna = 'T'`, sortowanie alfabetyczne oraz wstawianie pozycji do istniejącej listy HTML.

---

## SEC-1: Dane dostępowe i baza `choroby`

Arkusz: **localhost**, **root** bez hasła, baza **`choroby`**. Na końcu pliku: **`$conn->close()`**.

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "choroby";

$conn = new mysqli($host, $user, $pass, $db);
```

Skrót z kontrolki:

```php
$conn = new mysqli("localhost", "root", "", "choroby");
```

Połączenie otwierasz na górze `zdrowie.php`, zamykasz po HTML. Z tego samego `$conn` korzystają wszystkie trzy skrypty.

---

## SEC-2: Zapytanie — tylko zakaźne, alfabetycznie

```sql
SELECT nazwa FROM choroby WHERE zakazna = 'T' ORDER BY nazwa ASC;
```

- **`SELECT nazwa`** — na liście potrzebujesz wyłącznie nazwy (bez `id`).
- **`WHERE zakazna = 'T'`** — w bazie zakaźność jest zwykle flagą `'T'` / `'N'` (tak / nie). Cudzysłów wokół `T` jest obowiązkowy: to **tekst**, nie liczba.
- **`ORDER BY nazwa ASC`** — od A do Z.

To nie jest `JOIN`. Jedna tabela, wiele wierszy.

---

## SEC-3: Gotowe `<ol>` w HTML, PHP dopisuje tylko `<li>`

W arkuszu znacznik **`<ol>`** (lista uporządkowana / numerowana) stoi w HTML. Skrypt **nie** powinien ponownie wypisywać `<ol>` i `</ol>` — tylko kolejne **`<li>`**.

```php
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row["nazwa"] . "</li>";
}
```

Przeglądarka sama nada numery 1, 2, 3… bo rodzicem jest `<ol>`, nie `<ul>`.

`$row["nazwa"]` — klucz zgadza się z kolumną z `SELECT`.

---

## SEC-4: Pętla `while` — jedna choroba na jeden `<li>`

Wyników jest wiele, więc `while ($row = $result->fetch_assoc())`. Gdy wiersze się skończą, `fetch_assoc()` zwraca `false`.

Nie filtrujesz w PHP (`if ($row['zakazna'] == 'T')`) — filtr jest już w SQL.

---

# Podsumowanie przepływu danych

```text
new mysqli(..., "choroby")
                 ↓
SELECT nazwa WHERE zakazna = 'T' ORDER BY nazwa ASC
                 ↓
while fetch_assoc()
                 ↓
echo <li>nazwa</li>   wewnątrz <ol>
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie**              | **Co robi?**                                      |
| ------------------------ | ------------------------------------------------- |
| **Baza `choroby`**       | Nazwa bazy z arkusza.                             |
| **`zakazna = 'T'`**      | Filtr chorób zakaźnych (litera, w cudzysłowie).   |
| **`ORDER BY nazwa ASC`** | Kolejność alfabetyczna.                           |
| **`<ol>`**               | Lista numerowana (otwarta w HTML).                |
| **`<li>`**               | Jedna pozycja generowana w pętli.                 |

---

### Co dalej?

Lewa kolumna jest gotowa. Po prawej zbudujemy **listę rozwijaną** ze wszystkimi chorobami.

👉 **[Przejdź do Kroku 2: Dynamiczny znacznik select](../02_rozwijana_lista_select/README.md)**
