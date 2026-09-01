# Projekt PHP + MySQLi: Biblioteka miejska (baza `biblioteka`)

**Słowa kluczowe:** pętla `for` (obrazy bez bazy), trzy niezależne formularze POST, `SELECT` + `UPDATE` po sobie (rezerwacja), `JOIN` + `LIMIT`, `mysqli_connect` zwracający obiekt.

Projekt uczy czterech wzorców: generowania powtarzalnych elementów w
zwykłej pętli `for` (bez zapytania do bazy), trzech osobnych list gatunków
obsługiwanych niezależnymi formularzami, rezerwacji książki jako pary
zapytań `SELECT` + `UPDATE`, oraz listy zaległych wypożyczeń ograniczonej
`LIMIT`-em. Całość w jednym pliku: `biblioteka.php`.

## Struktura projektu

```text
16_projekt_biblioteka/
├── 01_petla_grafik/               -> for: 20 obrazów bez zapytania do bazy
├── 02_lista_rozwijana_gatunkow/   -> trzy <select>, po jednym na gatunek
├── 03_rezerwacja_ksiazki/         -> POST → SELECT tytułu → UPDATE rezerwacja
├── 04_zalegle_ksiazki/            -> JOIN + LIMIT 15
└── biblioteka.php                 -> STRONA BIBLIOTEKI: wszystkie 4 moduły
```

**Styl połączenia w tym projekcie jest mieszany:** `mysqli_connect(...)`
(funkcja, jak w projektach proceduralnych) zwraca tu jednak obiekt, na
którym wywołuje się metody jak w stylu obiektowym: `$mysqli->query()`,
`$mysqli->prepare()`, `$mysqli->close()`. To działa, bo `mysqli_connect`
i `new mysqli()` dają w PHP ten sam typ obiektu — różni się tylko sposób
jego utworzenia.

---

## Ściągawka wzorców

### 1. Pętla 20 grafik (bez bazy danych)

```php
for ($i = 1; $i <= 20; $i++) {
    echo "<img src='ksiazka" . $i . ".png'>";
}
```

Zwykła pętla `for` PHP, zupełnie niezależna od bazy — nazwy plików
budowane są z licznika (`ksiazka1.png` ... `ksiazka20.png`). Dobry
przykład na to, że nie każdy powtarzalny fragment strony musi pochodzić
z zapytania SQL.

→ Pełne wytłumaczenie: [`01_petla_grafik/README.md`](./01_petla_grafik/README.md)

### 2. Trzy niezależne listy gatunków

```php
$result = $mysqli->query("SELECT id, tytul FROM ksiazki WHERE gatunek = 'liryka'");

echo "<select name='liryka'>";
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['id'] . "'>" . $row['tytul'] . "</option>";
}
echo "</select>";
// dokładnie ten sam wzorzec powtórzony dla gatunek = 'epika' i 'dramat',
// z innym name selecta i przycisku w każdej sekcji
```

To samo zapytanie i ta sama pętla powtórzone trzykrotnie z innym
gatunkiem, tak jak w projekcie medica z trzema pakietami — różnica jest
tylko w nazwie atrybutu `name`, dzięki czemu każda sekcja ma osobny
formularz i wysyła osobne dane w POST.

→ Pełne wytłumaczenie: [`02_lista_rozwijana_gatunkow/README.md`](./02_lista_rozwijana_gatunkow/README.md)

### 3. Rezerwacja książki (SELECT + UPDATE)

```php
if (isset($_POST['buttonliryka'])) {
    $id = $_POST['liryka'];

    $stmt = $mysqli->prepare("SELECT tytul FROM ksiazki WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    echo "<p>Zarezerwowano: " . $row['tytul'] . "</p>";

    $update = $mysqli->prepare("UPDATE ksiazki SET rezerwacja = 1 WHERE id = ?");
    $update->bind_param("i", $id);
    $update->execute();
}
```

Dwa oddzielne zapytania jedno po drugim: najpierw `SELECT`, żeby odczytać
tytuł do wyświetlenia w komunikacie, potem osobny `UPDATE`, który
faktycznie zapisuje rezerwację w bazie (`rezerwacja = 1`). Komunikat
pojawia się tylko w tej sekcji, której przycisk (`buttonliryka`,
`buttonepika`, `buttondramat`) został kliknięty.

→ Pełne wytłumaczenie: [`03_rezerwacja_ksiazki/README.md`](./03_rezerwacja_ksiazki/README.md)

### 4. Zaległe wypożyczenia (JOIN + LIMIT)

```php
$query = "SELECT ksiazki.tytul, wypozyczenia.termin_zwrotu
          FROM ksiazki
          JOIN wypozyczenia ON ksiazki.id = wypozyczenia.id_ksiazki
          WHERE wypozyczenia.termin_zwrotu < CURDATE()
          LIMIT 15";

$result = $mysqli->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row['tytul'] . " " . $row['termin_zwrotu'] . "</li>";
}
```

`WHERE termin_zwrotu < CURDATE()` odfiltrowuje tylko wypożyczenia z
terminem zwrotu w przeszłości, a `LIMIT 15` ogranicza listę do
piętnastu pozycji, nawet jeśli zaległości jest więcej.

→ Pełne wytłumaczenie: [`04_zalegle_ksiazki/README.md`](./04_zalegle_ksiazki/README.md)

---

## Tabela referencyjna

| Plik / moduł                  | Kluczowa funkcja                           | Do czego służy                            |
| ----------------------------- | ------------------------------------------ | ----------------------------------------- |
| Połączenie                    | `mysqli_connect()` zwraca obiekt `$mysqli` | Mieszany styl: funkcja + metody obiektowe |
| `01_petla_grafik`             | `for`                                      | 20 obrazów bez zapytania do bazy          |
| `02_lista_rozwijana_gatunkow` | trzy `WHERE gatunek = ...`                 | Trzy niezależne formularze                |
| `03_rezerwacja_ksiazki`       | `SELECT` + osobny `UPDATE`                 | Zapisanie rezerwacji w bazie              |
| `04_zalegle_ksiazki`          | `JOIN`, `LIMIT 15`                         | Lista zaległych wypożyczeń                |
