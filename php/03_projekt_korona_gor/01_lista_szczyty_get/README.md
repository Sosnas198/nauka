# Kompletny przewodnik: Skrypt 1 — lista szczytów i parametr GET (`index.php`)

Ta ściąga wytłumaczy Ci **od A do Z** połączenie z bazą `korona`, zapytanie 1 posortowane po wysokości oraz budowę odnośników `szczyty.php?id=…` owiniętych w znacznik `<span>`.

---

## SEC-1: Dane dostępowe i baza `korona`

Arkusz: serwer **localhost**, użytkownik **root** **bez hasła**, baza o nazwie **`korona`**.

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "korona";
```

W kontrolce często jest skrót:

```php
$conn = new mysqli("localhost", "root", "", "korona");
```

Nazwa bazy **musi** być `korona` — nie `kino` i nie `przepisy`.

---

## SEC-2: Obiekt `$conn` i zamknięcie na końcu skryptu

```php
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Błąd połączenia z bazą: " . $conn->connect_error);
}
```

`$conn` to most do MySQL. Przez niego idą wszystkie trzy skrypty (`$conn->query(...)`).

Arkusz wymaga **jawnego** zamknięcia **na końcu** pliku (po HTML):

```php
$conn->close();
```

Każda strona (`index.php` i `szczyty.php`) otwiera **własne** połączenie i sama je zamyka.

---

## SEC-3: Zapytanie 1 — `id`, `nazwa`, sortowanie po wysokości

Arkusz podaje zapytanie 1 wprost:

```sql
SELECT id, nazwa FROM szczyty ORDER BY wysokosc DESC;
```

- **`SELECT id, nazwa`** — do linku potrzebujesz numeru (`id`) i tekstu (`nazwa`). Wysokość jest tylko kluczem sortowania, nie musisz jej wypisywać na liście.
- **`FROM szczyty`** — tabela szczytów.
- **`ORDER BY wysokosc DESC`** — od najwyższego do najniższego (`DESC` = malejąco).

```php
$query = "SELECT id, nazwa FROM szczyty ORDER BY wysokosc DESC;";
$result = $conn->query($query);
```

`$result` to paczka wielu wierszy — nie robisz na niej `echo`.

---

## SEC-4: Pętla `while` i tablica `$row`

```php
while ($row = $result->fetch_assoc()) {
    // jeden szczyt w jednym obiegu
}
```

`fetch_assoc()` zamienia wiersz na tablicę, w której klucze to nazwy kolumn:

- `$row['id']` — identyfikator szczytu,
- `$row['nazwa']` — nazwa do wyświetlenia w linku.

Gdy wiersze się skończą, `fetch_assoc()` zwraca `false` i pętla się kończy.

---

## SEC-5: `<span>`, odnośnik i metoda GET

Arkusz: każdą **nazwę** wyświetl w znaczniku **`<span>`**, tak że jest ona **odnośnikiem** do pliku **`szczyty.php`** i przekazuje metodą **GET** **id** szczytu.

```php
echo "<span><a href='szczyty.php?id=" . $row['id'] . "'>" . $row['nazwa'] . "</a></span> ";
```

Albo interpolacja (jak w kontrolce):

```php
echo "<span><a href='szczyty.php?id={$row['id']}'>{$row['nazwa']}</a></span> ";
```

### Co tu jest ważne?

| Element                 | Rola na egzaminie                                      |
| ----------------------- | ------------------------------------------------------ |
| **`<span>`**            | Wymagany opakowujący znacznik wokół nazwy / linku.     |
| **`<a href="…">`**      | Odnośnik do drugiego pliku.                            |
| **`szczyty.php`**       | Docelowy plik (nie `aktor.php` z innego projektu).     |
| **`?id=`**              | Start parametrów GET w adresie URL.                    |
| **`$row['id']`**        | Wartość przekazywana do Skryptu 3.                     |
| **`$row['nazwa']`**     | Tekst widoczny na stronie (treść linku).               |

Jeden uniwersalny plik `szczyty.php` obsługuje wszystkie szczyty — zmienia się tylko `id` w adresie.

Spacja po `</span>` (jak w kontrolce) rozdziela kolejne nazwy w linii.

---

# Podsumowanie przepływu danych

```text
new mysqli(..., "korona")
                 ↓
SELECT id, nazwa FROM szczyty ORDER BY wysokosc DESC
                 ↓
while fetch_assoc()
                 ↓
<span><a href="szczyty.php?id=…">nazwa</a></span>
                 ↓
$conn->close()
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie**                    | **Co robi?**                                              |
| ------------------------------ | --------------------------------------------------------- |
| **Baza `korona`**              | Nazwa bazy z arkusza.                                     |
| **`$conn->close()`**           | Zamknięcie połączenia na końcu skryptu.                   |
| **`ORDER BY wysokosc DESC`**   | Lista od najwyższego szczytu.                             |
| **`szczyty.php?id=X`**         | Przekazanie ID metodą GET do Skryptu 3.                   |
| **`<span>`**                   | Znacznik wymagany wokół odnośnika z nazwą.                |

---

### Co dalej?

Lista linków jest gotowa. Ten sam `$conn` wykorzystamy do **galerii 10 miniatur** na dole obu stron.

👉 **[Przejdź do Kroku 2: Galeria miniatur](../02_galeria_miniatur/README.md)**
