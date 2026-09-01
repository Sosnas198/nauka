Kiedy tworzysz formularz, użytkownicy mogą wpisać tam absolutnie wszystko – albo nie wpisać nic i od razu kliknąć przycisk „Wyślij”. Zamiast doprowadzać skrypt do błędów, warto zabezpieczyć kod, sprawdzając, czy dane naprawdę do nas dotarły i czy nie są puste.

## 1. Funkcja `isset()` – czy zmienna w ogóle istnieje?

Zanim spróbujesz odczytać dane z tablicy `$_POST` lub `$_GET`, upewnij się, że użytkownik faktycznie kliknął przycisk i przesłał te dane. Służy do tego funkcja **`isset()`**.

- Zwraca `true`, jeśli zmienna została ustawiona (istnieje).
- Zwraca `false`, jeśli zmienna jeszcze nie istnieje (np. strona dopiero się załadowała i nikt nic nie wysłał).

### Przykład sprawdzenia istnienia zmiennych:

### PHP

```php
<?php
// Sprawdzamy, czy zmienne z formularza zostały ustawione
if (isset($_POST['imie']) && isset($_POST['nazwisko']))
{
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    echo $imie . " " . $nazwisko;
}
?>
```

- **Ważna uwaga:** Ten prosty zapis sprawdza tylko, czy zmienne istnieją. Nie chroni on jednak przed sytuacją, w której użytkownik zostawi pola **puste** i wyśle puste wartości.

## 2. Funkcja `empty()` – czy pole nie jest puste?

Aby upewnić się, że użytkownik coś wpisał (a nie wysłał pustego pola), możesz posłużyć się funkcją **`empty()`**.

- Sprawdza ona, czy zmienna jest pusta.
- Jeśli jest pusta, zwraca `true`. Dlatego w warunkach często używamy przed nią wykrzyknika `!` (który oznacza zaprzeczenie – czyli „nie jest pusta”).

### Przykład zabezpieczenia z `isset()` i `empty()`:

### PHP

```php
<?php
if (isset($_POST['imie']) && isset($_POST['nazwisko'])
    && !empty($_POST['imie']) && !empty($_POST['nazwisko']))
{
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    echo $imie . " " . $nazwisko;
}
?>
```

## 3. Sprawdzanie wartości `NULL`

Alternatywnym sposobem na upewnienie się, że pole nie jest puste, jest bezpośrednie porównanie jego wartości z `null` (czyli „brak wartości”).

### Przykład sprawdzenia z `!= null`:

### PHP

```php
<?php
if (isset($_POST['imie']) && $_POST['imie'] != null
    && isset($_POST['nazwisko']) && $_POST['nazwisko'] != null)
{
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    echo $imie . " " . $nazwisko;
}
?>
```
