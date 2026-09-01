W PHP do losowania liczb służą głównie dwie funkcje: `rand()` oraz jej nowsza, szybsza i bardziej losowa kuzynka `mt_rand()`. Zawsze przyjmują one dwa argumenty: początek i koniec przedziału (włącznie z tymi liczbami).

Przykład:

### PHP

```php
$liczba = mt_rand(1, 10); // wylosuje całkowitą liczbę od 1 do 10
```

## Zadanie 1: Losowanie do skutku (szukanie liczby 25)

Skrypt ma losować liczby od 0 do 50 tak długo, aż trafi na 25. Ponieważ nie wiemy, czy trafi za 2. czy za 200. razem, używamy pętli `while`, która działa dopóki warunek jest spełniony.

### PHP

```php
<?php
$proba = 0;
$wylosowana = 0;

// Pętla kręci się tak długo, aż wylosowana liczba będzie różna od 25
while ($wylosowana != 25) {
    $wylosowana = mt_rand(0, 50);
    $proba++; // Zwiększamy licznik prób o 1

    echo "Próba nr $proba: wylosowano $wylosowana<br>";
}

echo "<br><strong>Koniec! Liczbę 25 wylosowano za $proba razem.</strong>";
?>
```

## Zadanie 2: Sumowanie liczb aż do przekroczenia 100

Tutaj również używamy pętli `while`, ale warunkiem jej działania jest to, aby suma wylosowanych liczb z zakresu od 1 do 20 była mniejsza lub równa 100. Musimy też zapisać cały ciąg dodawania do zmiennej tekstowej, aby na końcu wyświetlić go w formacie `20+15+18+...+wynik`.

### PHP

```php
<?php
$suma = 0;
$wynik_tekst = "";
$pierwsza = true; // Pomocnik, żeby na początku nie dostawić plusa

while ($suma <= 100) {
    $los = mt_rand(1, 20);
    $suma += $los; // Dodajemy wylosowaną liczbę do sumy

    if ($pierwsza) {
        $wynik_tekst .= $los; // Pierwsza liczba bez plusa z przodu
        $pierwsza = false;
    } else {
        $wynik_tekst .= "+" . $los; // Kolejne liczby z plusem
    }
}

// Wyświetlamy gotowy ciąg oraz ostateczną sumę
echo $wynik_tekst . "=" . $suma;
?>
```

## Zadanie 3: Formularz, losowanie 10 liczb i stylowanie parzystych

Do tego zadania potrzebujemy formularza HTML z dwoma polami tekstowymi (początek i koniec przedziału) oraz kodu PHP, który po wysłaniu danych obsłuży je, wylosuje dokładnie 10 liczb za pomocą pętli `for`, sprawdzi czy są parzyste i odpowiednio je ostyluje.

### HTML

```html
<form method="POST" action="">
  Początek przedziału: <input type="text" name="start" /><br /><br />
  Koniec przedziału: <input type="text" name="koniec" /><br /><br />
  <input type="submit" name="wyslij" value="Losuj 10 liczb" />
</form>

<?php // Sprawdzamy, czy formularz został wysłany i pola nie są puste if
(isset($_POST['start']) && isset($_POST['koniec']) && !empty($_POST['start']) &&
!empty($_POST['koniec'])) { // Zamieniamy tekst z pól na liczby całkowite $start
= intval($_POST['start']); $koniec = intval($_POST['koniec']); echo "
<h3>Wylosowane liczby:</h3>
"; // Pętla wykonująca się dokładnie 10 razy for ($i = 0; $i < 10; $i++) {
$liczba = mt_rand($start, $koniec); // Sprawdzamy, czy liczba jest parzysta
(reszta z dzielenia przez 2 wynosi 0) if ($liczba % 2 == 0) { // Parzysta:
czerwona i pogrubiona echo "<span style="color: red; font-weight: bold;"
  >$liczba</span
>
"; } else { // Nieparzysta: zwykła echo "$liczba "; } } } ?>
```
