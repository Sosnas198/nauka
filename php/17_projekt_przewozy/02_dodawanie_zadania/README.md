> **Krok 2 z 2** | [Krok 1](../01_lista_zadan_i_usuwanie/README.md) wyświetla i usuwa zadania. Teraz **Skrypt 2**: dodawanie nowego zadania z formularza.

---

# Kompletny przewodnik: Skrypt 2 — `INSERT` zadania przypisanego do osoby o id = 1

---

## SEC-1: Odczyt danych z formularza

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $zadanie = trim($_POST['zadanie'] ?? '');
    $data = $_POST['data'] ?? '';
    if ($zadanie !== '' && $data !== '') {
        ...
    }
}
```

- **`trim(... ?? '')`** — usuwa białe znaki z treści zadania i zabezpiecza przed brakiem klucza w `$_POST`.
- Warunek `$zadanie !== '' && $data !== ''` chroni przed dodaniem pustego wiersza do bazy.

---

## SEC-2: Zapytanie 2 zmodyfikowane — `INSERT`

Arkusz: dane pobrane z formularza są wstawiane do bazy za pomocą zmodyfikowanego zapytania 2, zadanie jest przypisane do osoby o **id równym 1**.

```php
if (!$mysqli->connect_errno) {
    $stmt = $mysqli->prepare('INSERT INTO zadania VALUES (NULL, ?, ?, 1)');
    $stmt->bind_param('ss', $zadanie, $data);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
    header('Location: przewozy.php');
    exit;
}
```

- **`NULL`** na pierwszej pozycji — `id_zadania` z autoinkrementacją bazy danych.
- **`?, ?`** — kolejno `zadanie` i `data` wysłane z formularza (`bind_param('ss', ...)` — oba typu string).
- **`1`** na końcu — stały identyfikator osoby, do której przypisywane jest zadanie.
- Po dodaniu: zamknięcie połączenia i przekierowanie z powrotem na `przewozy.php`, żeby lista pokazała nową pozycję.

---

🏠 **[Spis treści](../README.md)**
