# Operacje na ciągach znaków (tekście) w PHP – Poradnik dla początkujących

Praca z tekstem w PHP to codzienność. Czasami musimy ładnie sformatować treść z bazy danych, podzielić za długie linie albo zmienić wielkość liter. Spójrzmy, jakie gotowe funkcje ułatwiają nam życie!

## 1. Łamanie linii: funkcja `nl2br()`

Zwykłe przeglądarki internetowe mają to do siebie, że ignorują znaki nowego wiersza (enter) w zwykłym bloku tekstu. Zamiast tego ignorują spacje i enter, chyba że dodamy tam znaczniki HTML, takie jak `<br/>` czy `<p>`.

* Gdy tekst wczytujemy z pliku lub bazy danych, ręczne wstawianie znaczników byłoby koszmarem.
* Z pomocą przychodzi funkcja **`nl2br()`**, która automatycznie zamienia każdy niewidoczny znak nowej linii na znacznik `<br />`.

### Przykład użycia:

### PHP

```php id="j8q5qf"
<?php
$text = "Linia 1
Linia 2
Linia 3";

echo nl2br($text);
?>
```

## 2. Zawijanie tekstu: funkcja `wordwrap()`

Chcesz ograniczyć długość linii tekstu (np. do wyświetlenia w kolumnie o określonej szerokości)? Do tego służy funkcja **`wordwrap()`**. Dzieli ona ciąg znaków na mniejsze linijki.

Funkcja ta może przyjmować do 4 argumentów:

1. **Ciąg znakowy** – tekst, który chcemy sformatować (argument wymagany).
2. **Maksymalna długość linii** – np. 30 znaków.
3. **Ciąg rozdzielający** – czym rozdzielamy linie, np. `<br />`.
4. **Czwarty argument (opcjonalny** **`true`****/****`false`****)** – co zrobić, gdy w tekście pojawi się bardzo długie słowo (np. długi adres URL), które przekracza limit. Domyślnie słowo nie jest dzielone, ale podanie wartości `true` zmusi PHP do rozcięcia słowa między liniami.

### Przykład użycia:

### PHP

```php id="v7f8km"
<?php
$text = "http://moodle.zsl.poznan.pl/moodle/course/view.php?id=1174";
echo wordwrap($text, 30, "<br />", true);
?>
```

## 3. Zmiana wielkości liter

PHP posiada proste funkcje do natychmiastowej zmiany wielkości liter w tekście:

* **`strtoupper()`** – zamienia **wszystkie** litery w tekście na wielkie.
* **`strtolower()`** – zamienia **wszystkie** litery w tekście na małe.
* **`ucfirst()`** – zmienia na wielką literę tylko **pierwszą literę** całego ciągu znaków.
* **`ucwords()`** – zmienia na wielkie pierwsze litery **każdego wyrazu** w tekście.

### Przykład:

### PHP

```php id="o1k0r3"
<?php
$tekst = "ala ma kota";
echo strtoupper($tekst); // Wynik: ALA MA KOTA
echo "<br>";
echo ucwords($tekst);   // Wynik: Ala Ma Kota
?>
```

## 4. Czyszczenie tekstu: `trim()`, `ltrim()`, `rtrim()`

Często w danych od użytkowników (albo z plików) pojawiają się tzw. „białe znaki” – czyli niewidoczne spacje, tabulatory czy znaki nowej linii na początku lub końcu tekstu. Możemy się ich pozbyć za pomocą trzech funkcji:

* **`trim()`** – usuwa białe znaki **z obu stron** (z początku i z końca) ciągu.
* **`ltrim()`** – usuwa białe znaki **tylko z lewej strony** (z początku) ciągu.
* **`rtrim()`** – usuwa białe znaki **tylko z prawej strony** (z końca) ciągu.

Możesz też podać drugi, dodatkowy parametr, jeśli chcesz usunąć z tekstu konkretne litery lub znaki, a nie tylko białe spacje.

### Przykład:

### PHP

```php id="j5m9zx"
<?php
$tekst = " ala ma kota ";
echo trim($tekst); // Usunie spacje z obu stron i wyświetli: ala ma kota
?>
```
