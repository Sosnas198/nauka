## 1. Zliczanie elementów: `count()` oraz `sizeof()`

Chcesz wiedzieć, ile elementów znajduje się w tablicy? Służy do tego funkcja **`count()`**.

* Funkcja przyjmuje tablicę jako parametr i zwraca całkowitą liczbę jej elementów.
* Funkcja **`sizeof()`** działa dokładnie tak samo – jest po prostu aliasem (zamiennikiem) dla `count()`.

### Przykład użycia:

### PHP

```php
<?php
$tab = array("Wpis 0", "Wpis 1", "Wpis 2");
$n = count($tab);
echo $n; // Wynik: 3
?>
```

## 2. Sortowanie tablic

Sortowanie pozwala uporządkować elementy tablicy rosnąco lub malejąco. W zależności od rodzaju tablicy (indeksowana czy asocjacyjna), wybieramy odpowiednią funkcję.

### Tablice indeksowalne (zwykłe):

* **`sort()`** – sortuje elementy rosnąco (od najmniejszego do największego).
* **`rsort()`** – sortuje elementy malejąco (od największego do najmniejszego).

### Tablice asocjacyjne (z kluczami tekstowymi):

* **`asort()`** – sortuje tablicę według **zawartości (wartości)** rosnąco.
* **`arsort()`** – sortuje tablicę według **zawartości (wartości)** malejąco.
* **`ksort()`** – sortuje tablicę według **kluczy** rosnąco.
* **`krsort()`** – sortuje tablicę według **kluczy** malejąco.

### Przykład działania funkcji `sort()`:

### PHP

```php
<?php
$tab = array(1, 34, 2, 56, -9);

// Wyświetlamy przed sortowaniem
foreach ($tab as $liczby) {
    echo $liczby . " "; // Wynik: 1 34 2 56 -9
}

sort($tab);
echo "<br /><br />";

// Wyświetlamy po sortowaniu
foreach ($tab as $liczby) {
    echo $liczby . " "; // Wynik: -9 1 2 34 56
}
?>
```

## 3. Zamiana tekstu na tablicę: `str_split()`

Funkcja **`str_split()`** bierze zwykły ciąg znaków (tekst) i dzieli go na pojedyncze litery, tworząc z nich tablicę.

### Przykład użycia:

### PHP

```php
<?php
$tekst = "algorytm";
$tab = str_split($tekst);
print_r($tab);
?>
```

* **Wynik:** Każda litera słowa „algorytm” staje się osobnym elementem tablicy o indeksach od 0 do 7.

## 4. Wyszukiwanie w tablicy: `array_search()`

Szukasz konkretnej wartości w tablicy? Funkcja **`array_search()`** przeszukuje tablicę i w razie sukcesu zwraca **klucz (indeks)** znalezionego elementu.

* Funkcja przyjmuje dwa argumenty: **szukaną wartość** oraz **przeszukiwaną tablicę**.
* Jeśli elementu nie ma, funkcja zwraca `false`.

### Przykład 1 (szukanie koloru):

### PHP

```php
<?php
$tab = array("a" => "red", "b" => "green", "c" => "blue");
echo array_search("blue", $tab); 
// Wynik: c (ponieważ "blue" kryje się pod kluczem "c")
?>
```

### Przykład 2 (bezpieczne sprawdzenie z operatorem `!==`):

Operator `!==` sprawdza nie tylko wartość, ale też **ten sam typ danych** (co jest ważne, bo klucz o indeksie `0` mógłby być mylnie uznany za `false` przy zwykłym porównaniu).

### PHP

```php
<?php
$tab = array(100, 101, 102, 103);
$klucz = array_search(103, $tab);

if ($klucz !== false) {
    echo "Jest podany element";
} else {
    echo "Brak elementu";
}
?>
```
