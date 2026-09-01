Funkcja to spakowany w jedno miejsce ciąg instrukcji (blok kodu), który możesz uruchamiać wielokrotnie w różnych miejscach swojego programu. Wywołuje się ją podając jej nazwę oraz listę argumentów, a po zakończeniu działania funkcja często zwraca określoną wartość.

W PHP wyróżniamy dwa rodzaje funkcji:

- **Funkcje wbudowane** – gotowe funkcje dostarczone bezpośrednio z językiem PHP.
- **Funkcje zdefiniowane przez programistę** – takie, które piszesz samodzielnie od zera.

## 1. Jak stworzyć własną funkcję?

Definiowanie funkcji zaczynamy od słowa kluczowego `function`, po którym wpisujemy jej nazwę, nawiasy okrągłe na argumenty oraz nawiasy klamrowe z właściwym kodem:

PHP

```php
function nazwa($argument1, $argument2) {
    // instrukcje do wykonania
}

```

- **Zasady pisania nazw:** Nazwę funkcji tworzy się według takich samych zasad jak nazwy zwykłych zmiennych (powinna też odzwierciedlać to, co funkcja robi). Pamiętaj jednak, że **nazwa funkcji nie może zaczynać się od znaku dolara (\*\***`$`\***\*)**!
- **Argumenty:** Jeśli funkcja ma przyjmować dane, wpisujesz je w nawiasach okrągłych jako listę zmiennych rozdzielonych przecinkami. Jeśli funkcja nie potrzebuje żadnych argumentów, zostawiasz nawiasy całkowicie puste.

## 2. Przykłady funkcji

### Przykład 1: Funkcja bez argumentów

Ta funkcja po prostu wyświetla na ekranie obrazek kota za każdym razem, gdy ją wywołasz.

PHP

```php
function kotek() {
    echo "<img src=\"img\kot.jpg\" />";
}

echo "<b>Zdjęcie kota </b><br>";
kotek(); // Wywołanie funkcji

```

### Przykład 2: Funkcja z argumentami

Ta funkcja przyjmuje dwie zmienne, dodaje je do siebie i od razu wypisuje wynik na stronie.

PHP

```php
function dodaj($a, $b) {
    $c = $a + $b;
    echo "$a+$b=$c";
}

$a = 15;
$b = 12;
dodaj($a, $b); // Uruchomienie funkcji z podanymi zmiennymi

```

## 3. Zwracanie wartości z funkcji (`return`)

Często nie chcesz, aby funkcja od razu wyświetlała wynik na ekranie, ale wolałabyś przesłać go z powrotem do głównego programu, aby użyć go w dalszych obliczeniach. Służy do tego słowo kluczowe `return`.

> _Ciekawostka:_ Jeśli użyjesz słowa `return` wewnątrz funkcji bez żadnego argumentu, spowoduje to po prostu natychmiastowe przerwanie jej działania.

### Przykład użycia `return`:

PHP

```php
function suma($a, $b) {
    $c = $a + $b;
    return $c; // Zwracamy wynik na zewnątrz funkcji
}

$a = 15;
$b = 12;
$suma = suma($a, $b); // Przypisujemy zwróconą wartość do zmiennej

echo "Wynik to: " . $suma;
```
