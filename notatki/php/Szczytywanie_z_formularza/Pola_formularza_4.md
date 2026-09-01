# Odbieranie danych z pól formularza w PHP – Poradnik dla początkujących

Chcesz dowiedzieć się, jak wysłać coś przez formularz na stronie i odebrać to w PHP? Zobaczmy, jak działa to krok po kroku!

## 1. Jak zbudować formularz w HTML?

Każdy formularz musi być zamknięty w ramkach znacznika `<form>` oraz `</form>`.

### HTML

```html
<form method="metoda" action="akcja">
    <input type="text" name="nazwa_pola" placeholder="opis_pola"><br><br>
    <input type="submit" name="przycisk" value="Kliknij">
</form>
```

* **`method`**: Określa metodę przesyłania danych (np. `GET` lub `POST` – wielkość liter nie ma znaczenia).
* **`action`**: Określa, co ma się stać po kliknięciu przycisku. Jeśli zostawisz to pole puste, po wysłaniu formularza zostaniesz na tej samej stronie i od razu zobaczysz wynik działania skryptu.
* **`name`**: To najważniejszy atrybut w każdym polu formularza. To właśnie nazwa z tego atrybutu posłuży Ci w PHP do odczytania wpisanej wartości.

## 2. Jak odebrać dane w PHP?

Gdy użytkownik wypełni pola i kliknie przycisk, PHP odbiera dane za pomocą specjalnych tablic globalnych w zależności od wybranej metody (`$_GET` lub `$_POST`):

### PHP

```php
$zmienna = $_METODA['nazwa_pola'];
```

## 3. Kompletny przykład (HTML + PHP w jednym pliku)

Ten prosty przykład pokazuje formularz z dwoma polami tekstowymi oraz kod PHP, który natychmiast odczytuje wpisane przez Ciebie wartości i wypisuje je na ekranie.

### HTML

```html
<html>
<head>
    <title>Formularz</title>
</head>
<body>

    <form method="GET" action="">
        <input type="text" name="pole1" placeholder="Pole1"><br><br>
        <input type="text" name="pole2" placeholder="Pole2"><br><br>
        <input type="submit" name="przycisk" value="Kliknij">
    </form>

    <?php
    // Odbieramy dane przesłane metodą GET
    $pole1 = $_GET['pole1'];
    $pole2 = $_GET['pole2'];

    // Wyświetlamy pobrane wartości na stronie
    echo "Wpisałeś wartości: " . $pole1 . " i " . $pole2;
    ?>

</body>
</html>
```
