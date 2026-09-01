# Projekt PHP + MySQLi proceduralne: Zgłoszenia wydarzeń (baza `zgloszenia`)

**Słowa kluczowe:** styl proceduralny (`mysqli_query`), przyciski radio + POST, `LEFT JOIN ... IS NULL`, `INSERT`, `CURDATE()`, kolejność wykonania kodu w pliku.

Projekt uczy trzech wzorców w stylu **proceduralnym** (`mysqli_query($conn, $sql)`
zamiast `$conn->query($sql)`): filtrowania przez radio + POST, listy braków
przez `LEFT JOIN ... IS NULL` oraz `INSERT`-a, którego **kolejność w pliku
ma znaczenie**. Całość w jednym pliku: `index.php`.

## Struktura projektu

```text
06_projekt_zgloszenia/
├── 01_filtrowanie_personelu_radio/     -> radio + POST, tabela personelu
├── 02_lista_bez_zgloszen_left_join/    -> LEFT JOIN ... IS NULL
├── 03_dodawanie_zgloszenia_insert/     -> INSERT + CURDATE()
└── index.php                           -> STRONA: INSERT → filtr → lista braków
```

`index.php` łączy się z bazą `zgloszenia` funkcją `mysqli_connect` i zamyka
połączenie `mysqli_close($conn)` — to jedyny projekt w API proceduralnym,
nie obiektowym.

**Kolejność w `index.php` jest odwrotna niż numeracja folderów: moduł 3
(INSERT) wykonuje się pierwszy**, dopiero potem moduł 1 i 2 — żeby świeżo
dodane zgłoszenie od razu zniknęło z listy „bez zgłoszeń”.

---

## Ściągawka wzorców

### 1. Filtr personelu przez radio + POST

```php
$status = isset($_POST['status']) ? $_POST['status'] : "Policjant";

$query = "SELECT id, imie, nazwisko FROM personel WHERE status = '$status'";
$result = mysqli_query($conn, $query);

echo "<h3>Wybrano opcję: " . $status . "</h3>";
echo "<table>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>" . $row['imie'] . "</td><td>" . $row['nazwisko'] . "</td></tr>";
}
echo "</table>";
```

Bez wysłanego formularza `$status` przyjmuje domyślnie `"Policjant"`.
Funkcje proceduralne (`mysqli_query`, `mysqli_fetch_assoc`) przyjmują
`$conn` jako pierwszy argument — to jedyna różnica względem stylu
obiektowego z innych projektów, logika jest identyczna.

→ Pełne wytłumaczenie: [`01_filtrowanie_personelu_radio/README.md`](./01_filtrowanie_personelu_radio/README.md)

### 2. Lista osób bez zgłoszeń (`LEFT JOIN ... IS NULL`)

```php
$query = "SELECT personel.id, personel.nazwisko
          FROM personel
          LEFT JOIN rejestr ON personel.id = rejestr.id_personel
          WHERE rejestr.id_personel IS NULL";

$result = mysqli_query($conn, $query);

echo "<ol>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<li>" . $row['id'] . " " . $row['nazwisko'] . "</li>";
}
echo "</ol>";
```

Zwykły `JOIN` pokazałby tylko osoby, które **mają** dopasowany wiersz w
`rejestr`. `LEFT JOIN` zachowuje też osoby bez dopasowania (wtedy kolumny
z `rejestr` są `NULL`), a `WHERE ... IS NULL` odwraca to na "pokaż tylko
tych bez dopasowania" — czyli osoby bez żadnego zgłoszenia.

→ Pełne wytłumaczenie: [`02_lista_bez_zgloszen_left_join/README.md`](./02_lista_bez_zgloszen_left_join/README.md)

### 3. Dodanie zgłoszenia (`INSERT` + `CURDATE()`)

```php
if (isset($_POST['dodaj_zgloszenie'])) {
    $id = $_POST['id_personel'];

    $query = "INSERT INTO rejestr (data, id_personel, id_wydarzenia)
              VALUES (CURDATE(), $id, 14)";

    mysqli_query($conn, $query);
}
```

`CURDATE()` to funkcja SQL, która wstawia bieżącą datę serwera bazy —
nie trzeba jej liczyć w PHP. Ten blok musi wykonać się **przed** zapytaniem
z modułu 2, bo dopiero po `INSERT` osoba faktycznie ma wiersz w `rejestr`
i przestaje pojawiać się na liście „bez zgłoszeń”.

→ Pełne wytłumaczenie: [`03_dodawanie_zgloszenia_insert/README.md`](./03_dodawanie_zgloszenia_insert/README.md)

---

## Tabela referencyjna

| Plik / moduł                      | Kluczowa funkcja                     | Do czego służy                    |
| --------------------------------- | ------------------------------------ | --------------------------------- |
| Połączenie                        | `mysqli_connect`, `mysqli_close`     | Styl proceduralny (nie obiektowy) |
| `01_filtrowanie_personelu_radio`  | radio + POST, domyślny `"Policjant"` | Filtr personelu w tabeli          |
| `02_lista_bez_zgloszen_left_join` | `LEFT JOIN ... IS NULL`              | Osoby bez powiązanego zgłoszenia  |
| `03_dodawanie_zgloszenia_insert`  | `INSERT`, `CURDATE()`                | Dodanie nowego zgłoszenia         |
| `index.php`                       | Kolejność: moduł 03 → 01 → 02        | Cała strona z arkusza             |
