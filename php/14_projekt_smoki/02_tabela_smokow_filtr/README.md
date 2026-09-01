> **Krok 2 z 3** | [W Kroku 1](../01_lista_rozwijana_pochodzenie/README.md) select wysyła kraj. Teraz **Skrypt 2**: tabela smoków z tego kraju.

---

# Kompletny przewodnik: Skrypt 2 — filtr `WHERE pochodzenie = ?` (POST + `prepare`)

---

## SEC-1: Tylko po „Szukaj”

```php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["baza"])) {
    $pochodzenie = $_POST["baza"];
    // prepare …
}
```

Bez POST tabela ma tylko nagłówki (`Nazwa`, `Długość`, `Szerokość`).

---

## SEC-2: Zapytanie z placeholderem

```sql
SELECT nazwa, dlugosc, szerokosc FROM smok WHERE pochodzenie = ?;
```

Kolumny w bazie: **`dlugosc`**, **`szerokosc`** (bez polskich znaków).

---

## SEC-3: Prepared statement

```php
$stmt = $conn->prepare("SELECT nazwa, dlugosc, szerokosc FROM smok WHERE pochodzenie = ?");
$stmt->bind_param("s", $pochodzenie);
$stmt->execute();
$result = $stmt->get_result();
```

**`"s"`** — string (nazwa kraju).

---

## SEC-4: Wiersze tabeli

```php
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["nazwa"] . "</td>";
    echo "<td>" . $row["dlugosc"] . "</td>";
    echo "<td>" . $row["szerokosc"] . "</td>";
    echo "</tr>";
}
$stmt->close();
```

PHP dopisuje `<tr>` wewnątrz gotowego `<table>`.

---

👉 **[Przejdź do Kroku 3: Nawigacja JS](../03_interaktywna_nawigacja_js/README.md)**
