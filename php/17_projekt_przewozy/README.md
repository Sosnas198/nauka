# Projekt PHP + MySQLi: Firma przewozowa (baza `przewozy`)

**Słowa kluczowe:** usuwanie przez link GET (`DELETE`), przekierowanie (`header("Location")`), formularz POST + `INSERT` ze stałym ID.

Projekt uczy dwóch wzorców: usuwania rekordu klikniętym linkiem
(`?usun=ID` → `DELETE` → przekierowanie) oraz dodawania nowego zadania
formularzem, przypisanego na sztywno do jednej, konkretnej osoby. Całość
w jednym pliku: `przewozy.php`.

## Struktura projektu

```text
17_projekt_przewozy/
├── 01_lista_zadan_i_usuwanie/  -> tabela zadań + usuwanie linkiem GET
├── 02_dodawanie_zadania/       -> formularz POST + INSERT
└── przewozy.php                -> STRONA: oba moduły
```

`przewozy.php` sam otwiera i zamyka połączenie z bazą `przewozy` przez
`new mysqli(...)` → obiekt `$mysqli`.

**Kolejność w pliku ma znaczenie:** blok usuwania wykonuje się na samej
górze skryptu, przed zapytaniem o listę zadań — dzięki temu, gdy ktoś
kliknie „usuń”, tabela od razu odświeża się bez tej pozycji, bez potrzeby
osobnego przeładowania.

---

## Ściągawka wzorców

### 1. Lista zadań z usuwaniem przez link GET

```php
if (isset($_GET['usun'])) {
    $id = $_GET['usun'];

    $stmt = $mysqli->prepare("DELETE FROM zadania WHERE id_zadania = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: przewozy.php");
    exit;
}

$result = $mysqli->query("SELECT id_zadania, zadanie, data FROM zadania");

while ($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row['zadanie'] . "</td><td>" . $row['data'] . "</td>";
    echo "<td><a href='przewozy.php?usun=" . $row['id_zadania'] . "'>usuń</a></td></tr>";
}
```

Kliknięcie linku `?usun=ID` nie usuwa niczego samo z siebie — to PHP na
początku pliku sprawdza `isset($_GET['usun'])` i dopiero wtedy wykonuje
`DELETE`. `header("Location: ...")` + `exit` przekierowują z powrotem na
czystą stronę bez `?usun=...` w adresie, żeby odświeżenie strony
(F5) nie próbowało usunąć tego samego rekordu drugi raz.

→ Pełne wytłumaczenie: [`01_lista_zadan_i_usuwanie/README.md`](./01_lista_zadan_i_usuwanie/README.md)

### 2. Dodawanie zadania (formularz POST, stałe ID osoby)

```php
if (isset($_POST['dodaj'])) {
    $zadanie = $_POST['zadanie'];
    $data    = $_POST['data'];

    $stmt = $mysqli->prepare("INSERT INTO zadania (zadanie, data, id_osoby) VALUES (?, ?, 1)");
    $stmt->bind_param("ss", $zadanie, $data);
    $stmt->execute();
}
```

Nowe zadanie zawsze trafia do osoby o `id_osoby = 1` — ta wartość jest
wpisana na sztywno w zapytaniu, nie pochodzi z formularza ani z sesji
użytkownika.

→ Pełne wytłumaczenie: [`02_dodawanie_zadania/README.md`](./02_dodawanie_zadania/README.md)

---

## Tabela referencyjna

| Plik / moduł                | Kluczowa funkcja                       | Do czego służy               |
| --------------------------- | -------------------------------------- | ---------------------------- |
| Połączenie                  | `new mysqli(..., "przewozy")`          | Styl obiektowy               |
| `01_lista_zadan_i_usuwanie` | `DELETE`, `header("Location")`, `exit` | Usunięcie zadania przez link |
| `02_dodawanie_zadania`      | `INSERT` ze stałym `id_osoby = 1`      | Dodanie nowego zadania       |
