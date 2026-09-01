Czasami musimy połączyć wszystkie elementy tablicy w jeden długi ciąg tekstowy, albo zrobić dokładnie na odwrót – pociąć jeden wielki tekst na kawałki i wrzucić je do tablicy. Do tych zadań służą dwie genialne funkcje: `implode()` oraz `explode()`.

## 1. Łączenie tablicy w tekst: funkcja `implode()`

Funkcja **`implode()`** bierze całą tablicę i skleja jej elementy w jeden wspólny ciąg znaków, rozdzielając je wybranym przez Ciebie znakiem (lub np. spacją).

Przyjmuje 2 główne parametry:

1. **Znak rozdzielający** (czyli czym skleić elementy, np. przecinkiem, myślnikiem albo niczym).
2. **Tablica**, którą chcemy skleić.

### Przykłady użycia:

### PHP

```php id="8s3l0a"
<?php
$tab = array("wpis 0", "wpis 1", "wpis 2");

// Sklejanie bez separatora (elementy złączą się bezpośrednio)
echo implode($tab); // Wynik: wpis 0wpis 1wpis 2

// Sklejanie za pomocą pustego ciągu (dokładnie to samo)
echo implode("", $tab); // Wynik: wpis 0wpis 1wpis 2

// Sklejanie za pomocą myślnika
echo implode("-", $tab); // Wynik: wpis 0-wpis 1-wpis 2

// Sklejanie za pomocą małpy
echo implode("@", $tab); // Wynik: wpis 0@wpis 1@wpis 2
?>
```

## 2. Dzielenie tekstu na tablicę: funkcja `explode()`

Funkcja **`explode()`** robi dokładnie odwrotną rzecz niż `implode()` – bierze zwykły ciąg znaków (np. całą linijkę tekstu) i dzieli go na mniejsze części, tworząc z nich nową tablicę.

Przyjmuje dwa obowiązkowe parametry (oraz jeden opcjonalny):

1. **Znak (lub ciąg) rozdzielający** – czyli punkt, w którym tekst ma być „cięty” (np. średnik, przecinek czy spacja).
2. **Tekst (ciąg znaków)**, który chcemy pociąć.
3. *(Opcjonalnie)* **Maksymalna liczba pól** – jeśli podasz tę liczbę, a tekstów do podziału będzie więcej, ostatnie pole w tablicy zgarnie całą resztę tekstu bez dalszego cięcia.

### Przykład użycia:

### PHP

```php id="c7p3xn"
<?php
$dane = "02/01/2017;10:23:33;Pracownia Aplikacji;192.168.1.1";

// Tniemy tekst w miejscach, gdzie pojawi się średnik ";"
$tablica = explode(";", $dane);

echo "<pre>";
print_r($tablica);
echo "</pre>";
?>
```

* **Wynik:** Otrzymujemy tablicę, w której każda część tekstu (data, godzina, nazwa i adres IP) trafia do osobnej komórki z indeksem od `0` do `3`.
