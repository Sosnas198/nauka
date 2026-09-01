> **Krok 1 z 2** | Start projektu. Teraz **Skrypt 1**: tabela zadań i usuwanie rekordu przez odnośnik.

---

# Kompletny przewodnik: Skrypt 1 — tabela zadań, `DELETE` przez `$_GET['usun']`

---

## SEC-1: Usuwanie zadania (zapytanie 3 zmodyfikowane)

Arkusz: trzecia kolumna zawiera odnośnik **Usuń**, dotyczący `id_zadania` wiersza, w którym się znajduje.

```php
if (isset($_GET['usun'])) {
    $stmt = $mysqli->prepare('DELETE FROM zadania WHERE id_zadania = ?');
    $stmt->bind_param('i', $_GET['usun']);
    $stmt->execute();
    $stmt->close();
    header('Location: przewozy.php');
    exit;
}
```

- Odnośnik `?usun=ID` w linku przekazuje **`id_zadania`** metodą GET.
- **`prepare` + `bind_param('i', ...)`** — przygotowane zapytanie z parametrem typu `integer`.
- **`header('Location: ...')` + `exit`** — przekierowanie z powrotem do strony po usunięciu, żeby uniknąć ponownego usunięcia przy odświeżeniu.

Ten blok musi wykonać się **przed** wypisaniem tabeli, żeby lista była już aktualna.

---

## SEC-2: Zapytanie 1 — lista zadań

```php
$result = $mysqli->query('SELECT id_zadania, zadanie, data FROM zadania');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['zadanie'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars($row['data'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td><a href="?usun=' . (int)$row['id_zadania'] . '">Usuń</a></td>';
        echo '</tr>';
    }
    $result->free();
}
```

- Kolumna 1: **zadanie**, kolumna 2: **data** — zwrócone bezpośrednio z zapytania 1.
- Kolumna 3: odnośnik **Usuń**, którego `href` zawiera `id_zadania` **właśnie tego** wiersza — dzięki `(int)$row['id_zadania']`.
- `htmlspecialchars(...)` zabezpiecza przed wstrzyknięciem HTML w treści komórek.

---

👉 **[Krok 2: Dodawanie zadania](../02_dodawanie_zadania/README.md)**
