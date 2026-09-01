# Projekt PHP + MySQLi: Pogoda w Europie (baza `pogoda`)

Projekt uczy dwóch wzorców: tabeli danych złączonej JOIN-em z warunkowymi
ikonami zależnymi od wartości liczbowej, oraz agregacji SQL (`AVG`,
`ROUND`) uruchamianej dopiero po kliknięciu linku z parametrem GET. Całość
w jednym pliku: `index.php`.

## Struktura projektu

```text
04_projekt_pogoda/
├── 01_tabela_temperatur_i_ikony/  -> JOIN + tabela lipca + ikony wg °C
├── 02_srednia_temperatura_get/    -> GET month + AVG/ROUND
└── index.php                      -> STRONA POGODY: tabela + linki + średnia
```

`index.php` sam otwiera połączenie z bazą `pogoda` i sam je zamyka
(`$conn->close()`).

---

## Ściągawka wzorców

### 1. Tabela temperatur z ikonami (JOIN)

```php
$query = "SELECT miejscowosc.miasto, miejscowosc.kraj, pomiary.temperatura
          FROM miejscowosc
          JOIN pomiary ON miejscowosc.id = pomiary.id_miejscowosci
          WHERE pomiary.id_miesiac = 7";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $temp = $row['temperatura'];

    if ($temp > 30) {
        $ikona = "slonce.png";
    } elseif ($temp < 26) {
        $ikona = "deszcz.png";
    } else {
        $ikona = "chmury.png";
    }

    echo "<tr><td>" . $row['miasto'] . "</td><td>" . $row['kraj'] . "</td>";
    echo "<td>" . $temp . "°C</td><td><img src='" . $ikona . "'></td></tr>";
}
```

`JOIN` łączy miejscowość z jej pomiarem, `WHERE id_miesiac = 7` zawęża
wynik tylko do lipca. Dla każdego wiersza próg temperatury (`> 30`,
`< 26`, w innym wypadku) decyduje, który plik ikony (`slonce`, `deszcz`,
`chmury`) zostanie pokazany obok danych.

→ Pełne wytłumaczenie: [`01_tabela_temperatur_i_ikony/README.md`](./01_tabela_temperatur_i_ikony/README.md)

### 2. Średnia temperatura po kliknięciu miesiąca (GET + AVG)

```php
if (isset($_GET['month'])) {
    $month = $_GET['month'];
    $query = "SELECT ROUND(AVG(temperatura), 2) AS srednia
              FROM pomiary
              WHERE id_miesiac = $month";

    $row = $conn->query($query)->fetch_assoc();
    echo $row['srednia'] . " stopni";
}
```

Ten skrypt **nie wykonuje się w ogóle**, dopóki w adresie nie pojawi się
`?month=X` — sprawdza to `isset($_GET['month'])`. Samo liczenie średniej
dzieje się w SQL: `AVG()` liczy średnią, `ROUND(..., 2)` zaokrągla do
dwóch miejsc po przecinku, a `AS srednia` nadaje wynikowi nazwę, po której
odbiera się go w PHP.

→ Pełne wytłumaczenie: [`02_srednia_temperatura_get/README.md`](./02_srednia_temperatura_get/README.md)

---

## Tabela referencyjna

| Plik / moduł                   | Kluczowa funkcja                              | Do czego służy                         |
| ------------------------------ | --------------------------------------------- | -------------------------------------- |
| Połączenie                     | `new mysqli(..., "pogoda")`                   | Most do bazy na `index.php`            |
| `01_tabela_temperatur_i_ikony` | `JOIN`, `id_miesiac = 7`, `if / elseif` na °C | Tabela lipca z ikonami pogody          |
| `02_srednia_temperatura_get`   | `isset($_GET['month'])`, `AVG`, `ROUND`       | Średnia temperatura wybranego miesiąca |
| `index.php`                    | Moduł 01 + Moduł 02                           | Cała strona pogodowa                   |
