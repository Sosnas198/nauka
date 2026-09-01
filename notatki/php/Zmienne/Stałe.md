Wyobraź sobie stałą jako specjalny pojemnik na dane, który jest bardzo podobny do zwykłej zmiennej, z tą kluczową różnicą, że **gdy raz przypiszesz jej wartość, nie można jej już później zmienić**. Wartość nadaje się jej wyłącznie w momencie tworzenia.

## 1. Jak zdefiniować stałą?

Do tworzenia stałych w PHP służy gotowa funkcja `define()`. Jej ogólny wzór wygląda tak:

### PHP

```php id="5q9k2m"
define("nazwa_stalej", "wartość stałej");
```

## 2. Zasady nazywania stałych

Nazwa stałej (`nazwa_stalej`) musi spełniać kilka konkretnych wymagań:

- Może składać się z liter, cyfr oraz znaku podkreślenia.
- **Nie może** zaczynać się od cyfry.
- Nie może zawierać polskich znaków ani spacji.
- Wielkość liter ma znaczenie (PHP rozróżnia małe i wielkie litery).

## 3. Przykłady definicji

Oto jak w praktyce wygląda tworzenie stałych:

### PHP

```php id="v3p7ne"
<?php
define("imie", "Jan");
define("rok", 2015);
?>
```
