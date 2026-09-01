Wyobraź sobie zmienną jako mały pojemnik w pamięci komputera, w którym możesz schować jakąś wartość – na przykład tekst, liczbę całkowitą, ułamek albo wartość logiczną. Co ważne, zawartość tego pojemnika może w każdej chwili ulec zmianie podczas wykonywania programu.

## 1. Jak zdefiniować zmienną?

W języku PHP każda nazwa zmiennej musi obowiązkowo rozpoczynać się od znaku dolara (`$`), po którym następuje jej właściwa nazwa. Standardowy wzór wygląda tak:

### PHP

```php id="0q3v8n"
$nazwa_zmiennej = "wartość zmiennej";
```

## 2. Zasady nazywania zmiennych

Tworząc własne zmienne, musisz trzymać się kilku żelaznych zasad:

- Nazwa może składać się z liter, cyfr oraz znaku podkreślenia.
- **Nie może** rozpoczynać się od cyfry.
- Nie może zawierać polskich znaków (np. ą, ę, ł) ani spacji.
- Wielkość liter ma znaczenie (zmienna `$imie` i `$Imie` to zupełnie dwie różne zmienne).

## 3. Brak deklaracji i automatyczne typy danych

W wielu innych językach programowania musisz najpierw „zapowiedzieć” (zadeklarować) zmienną, zanim jej użyjesz – w PHP nie ma takiego wymogu.

PHP jest też bardzo elastyczne pod względem typów danych – nie musisz określać, czy zmienna będzie liczbą, czy tekstem. Typ zmiennej ustala się automatycznie w momencie przypisania do niej wartości:

- Jeśli wartość zamkniesz w cudzysłowach lub apostrofach, PHP potraktuje ją jako **łańcuch znaków (tekst)**.
- Jeśli wpiszesz samą liczbę (bez cudzysłowów), PHP uzna ją za **typ liczbowy**.

### Przykłady definicji:

### PHP

```php id="q9r2sl"
<?php
$imie = "Jan";   // Tekst (string)
$rok = 2015;     // Liczba (integer)
?>
```
