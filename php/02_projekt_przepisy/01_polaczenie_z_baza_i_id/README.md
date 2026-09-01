# Kompletny przewodnik: Połączenie z bazą `przepisy` i inicjacja zmiennej ID

Ta ściąga wytłumaczy Ci **od A do Z** logikę łączenia PHP z bazą MySQL według wymagań arkusza oraz sposób ustalenia zmiennej ID: z adresu URL albo wartością domyślną **7**.

---

## SEC-1: Dane dostępowe wymagane w arkuszu

Zanim PHP połączy się z bazą, musi znać host, użytkownika, hasło i nazwę bazy.

W tym projekcie arkusza obowiązują **stałe** wartości:

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "przepisy";
```

### Wyjaśnienie parametrów

- **`$host` (`localhost`):** Serwer bazy działa na tym samym komputerze co PHP (XAMPP / lokalny MySQL).
- **`$user` (`root`):** Domyślny administrator w środowisku egzaminacyjnym.
- **`$pass` (`""`):** Konto `root` **bez hasła**.
- **`$db` (`przepisy`):** Nazwa bazy z arkusza — nie `kino` i nie inna baza z poprzedniego projektu.

---

## SEC-2: Tworzenie obiektu połączenia – `new mysqli(...)`

```php
$conn = new mysqli($host, $user, $pass, $db);
```

1. **`new mysqli(...)`** tworzy obiekt klasy `mysqli` w kolejności: host, użytkownik, hasło, baza.
2. **`$conn`** to most między PHP a MySQL. Przez ten obiekt wysyłasz zapytania (`$conn->query(...)`) i zamykasz połączenie.

Możesz też zapisać to w jednej linii, jak w kontrolce egzaminacyjnej:

```php
$conn = new mysqli("localhost", "root", "", "przepisy");
```

Oba warianty są poprawne. Wersja ze zmiennymi jest czytelniejsza do nauki.

---

## SEC-3: Obsługa błędów połączenia (`connect_error`)

```php
if ($conn->connect_error) {
    die("Błąd połączenia z bazą: " . $conn->connect_error);
}
```

- **`$conn->connect_error`** — opis błędu albo pusta wartość, gdy połączenie się udało.
- **`die(...)`** — wypisuje komunikat i **natychmiast kończy** skrypt, żeby nie iść dalej bez bazy.

Na egzaminie bywa pomijane; w kodzie edukacyjnym warto je zostawić.

---

## SEC-4: Zmienna ID — GET albo wartość 7

Arkusz mówi wprost:

> Jeśli do strony została przesłana wartość metodą GET, zmienna jest inicjowana tą wartością.  
> W przeciwnym wypadku zmienna jest inicjowana wartością **7**.

Linki w menu wyglądają tak: `przepisy.php?id=1`, `przepisy.php?id=7` itd. Parametr nazywa się **`id`**.

```php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = 7;
}
```

### Dlaczego nie wystarczy samo `isset` bez `else`?

Kontrolka często opakowuje **każdy** skrypt w `if (isset($_GET["id"]))`. Wtedy **bez parametru w URL nic się nie wyświetla**.

Arkusz wymaga inaczej: strona ma działać zawsze — przy braku GET pokazujemy potrawę o **ID = 7** (w bazie: Jagnięcina).

### Co robi `isset($_GET["id"])`?

Sprawdza, czy w adresie po znaku `?` jest para `id=...`.

- Wejście na `przepisy.php?id=3` → `$id = 3` (Sałatka).
- Wejście na `przepisy.php` → `$id = 7`.

Zmienna `$id` jest potem wstawiana do `WHERE ... = $id` we **wszystkich czterech** skryptach.

---

## SEC-5: Praca z bazą i zamknięcie połączenia

Po ustaleniu `$conn` i `$id` wykonujesz zapytania SQL.

Na **końcu** skryptu (po całym HTML) zamykasz połączenie:

```php
$conn->close();
```

Arkusz wymaga jawnego zamknięcia. PHP i tak zamyka połączenie po zakończeniu skryptu, ale na INF.03 / EE.09 oczekuje się `$conn->close()`.

---

# Podsumowanie przepływu danych

```text
$host, $user, $pass, $db = przepisy
                 ↓
$conn = new mysqli(...)
                 ↓
Czy $conn->connect_error?
   ├── TAK ──> die()
   └── NIE ──> idź dalej
                 ↓
Czy isset($_GET["id"])?
   ├── TAK ──> $id = $_GET["id"]
   └── NIE ──> $id = 7
                 ↓
Skrypty 1–4 używają $conn i $id
                 ↓
$conn->close()
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**      | **Co oznacza / Co robi?**                                      |
| -------------------------- | -------------------------------------------------------------- |
| **`przepisy`**             | Nazwa bazy wymagana w arkuszu.                                 |
| **`new mysqli()`**         | Tworzy obiekt połączenia.                                      |
| **`$conn`**                | Aktywne połączenie z MySQL.                                    |
| **`$_GET["id"]`**          | Wartość parametru `id` z paska adresu.                         |
| **`$id = 7`**              | Wartość domyślna, gdy GET nie został przesłany.                |
| **`$conn->close()`**       | Zamyka połączenie na końcu skryptu.                            |

---

### Co dalej?

Mamy `$conn` oraz `$id`. Teraz pobierzemy **rodzaj** potrawy (Skrypt 1).

👉 **[Przejdź do Kroku 2: Wyświetlanie rodzaju potrawy](../02_wyswietlanie_rodzaju/README.md)**
