# Czym są tablice w PHP? – Poradnik dla początkujących

Wyobraź sobie tablicę jako uporządkowaną listę, która działa jak zbiór pojemników na dane. Zamiast tworzyć osobną zmienną na każdą informację, wrzucasz je do jednego wspólnego „pudełka”. Elementami tablicy mogą być liczby, łańcuchy tekstowe, a nawet inne tablice (wtedy mówimy o tablicach wielowymiarowych).

## 1. Jak zadeklarować zwykłą tablicę?

Najprostszym sposobem na stworzenie tablicy jest użycie słowa kluczowego `array`. Poszczególne elementy oddzielamy od siebie przecinkami.

### PHP

```php
<?php
$imiona = array('Marcin', 'Daniel', 'Magda', 'Paulina');
?>
```

- W tym przykładzie wszystkie elementy to teksty, ale nic nie stoi na przeszkodzie, aby w jednej tablicy wymieszać różne typy danych (np. teksty i liczby).

## 2. Jak działają indeksy (numery w tablicy)?

Każdy element w tablicy jest automatycznie rozpoznawany przez swój unikalny numer, czyli **indeks** (lub klucz).

- Jeśli nie podasz indeksu ręcznie, PHP nada go samoczynnie, numerując elementy **od zera** (pierwszy element ma indeks `0`, drugi `1` itd.).
- Możesz tworzyć tablicę, dopisując kolejne elementy za pomocą pustych nawiasów kwadratowych `[]`:

### PHP

```php
<?php
$imiona[] = 'Marcin'; // dostaje indeks 0
$imiona[] = 'Daniel'; // dostaje indeks 1
$imiona[] = 'Magda';  // dostaje indeks 2
$imiona[] = 'Paulina';// dostaje indeks 3
?>
```

## 3. Ręczne ustawianie indeksów

Indeksy wcale nie muszą zaczynać się od zera ani lecieć po kolei – możesz je w pełni kontrolować.

### PHP

```php
<?php
$imiona[100] = 'Marcin';
$imiona[101] = 'Daniel';
$imiona[200] = 'Magda';
$imiona[105] = 'Paulina';
$imiona[] = 'Aneta';
?>
```

- Co się stanie w ostatniej linijce, gdzie dodaliśmy element bez podawania indeksu (`$imiona[] = 'Aneta'`)? PHP automatycznie sprawdzi najwyższy dotychczasowy indeks (w tym przypadku `200`) i przypisze nowemu elementowi kolejny wolny numer, czyli `201`.
- Możesz też nadawać własne indeksy bezpośrednio w konstrukcji `array()` za pomocą operatora `=>`:

  ### PHP

  ```php
  $imiona = array('Marcin', 100=>'Daniel', 200=>'Magda', 'Paulina');
  ```

  _(W tym zapisie Marcin dostanie indeks_ _`0`\*\*, Daniel_ _`100`\*\*, Magda_ _`200`\*\*, a Paulina kolejny wolny numer po 200, czyli_ _`201`\*\*)_.

## 4. Tablice asocjacyjne (tekstowe klucze)

Czasami numery (indeksy) wcale nie są nam potrzebne i wolelibyśmy opisywać elementy słowami. Do tego służą **tablice asocjacyjne**, w których kluczem jest ciąg znaków (tekst).

Deklarujemy je na kilka sposobów:

### PHP

```php
<?php
// Sposób 1: za pomocą array() i strzałek =>
$jezyk = array('pl' => 'polski', 'de' => 'niemiecki');

// Sposób 2: przypisując wartości do tekstowych kluczy w nawiasach
$dane['imię'] = 'Jan';
$dane['nazwisko'] = 'Kowalski';
$dane['ulica'] = 'Lipowa';
?>
```
