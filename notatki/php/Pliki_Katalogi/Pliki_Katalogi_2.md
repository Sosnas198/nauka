### Zadanie 1. Operacje na plikach i folderach (krok po kroku)

W PHP mamy gotowe, wbudowane "funkcje-detektywy", które potrafią sprawdzić, co dzieje się na naszym dysku. Poniżej znajduje się kompletny plik PHP z rozwiązaniem wszystkich 6 podpunktów. Każda linijka jest dokładnie wyjaśniona.

### PHP

```php
<?php
// 1. Czy plik tekstowy istnieje?
// Funkcja file_exists() sprawdza, czy podany plik fizycznie znajduje się na dysku.
// Zwraca true (tak) lub false (nie).
$nazwa_pliku = "notatka.txt";
if (file_exists($nazwa_pliku)) {
    echo "1. Plik $nazwa_pliku ISTNIEJE.<br>";
} else {
    echo "1. Plik $nazwa_pliku NIE ISTNIEJE.<br>";
}


// 2. Czy folder istnieje?
// Funkcja is_dir() sprawdza, czy podana ścieżka to istniejący folder (katalog).
$nazwa_folderu = "zdjecia";
if (is_dir($nazwa_folderu)) {
    echo "2. Folder $nazwa_folderu ISTNIEJE.<br>";
} else {
    echo "2. Folder $nazwa_folderu NIE ISTNIEJE.<br>";
}


// 3. Czy podany ciąg jest plikiem?
// Funkcja is_file() sprawdza, czy wskazana ścieżka na pewno jest plikiem (a nie np. folderem).
$sciezka = "notatka.txt";
if (is_file($sciezka)) {
    echo "3. To jest zwykły plik.<br>";
} else {
    echo "3. To NIE jest plik.<br>";
}


// 4. Sprawdź rozmiar pliku graficznego.
// Funkcja filesize() podaje rozmiar pliku w bajtach.
// Aby zamienić bajty na kilobajty (KB), dzielimy wynik przez 1024.
$obrazek = "zdjecie.png";
if (file_exists($obrazek)) {
    $rozmiar_w_bajtach = filesize($obrazek);
    $rozmiar_w_kb = $rozmiar_w_bajtach / 1024;
    echo "4. Rozmiar pliku $obrazek to: $rozmiar_w_kb KB (bajtów: $rozmiar_w_bajtach).<br>";
    // Porównanie z właściwościami w systemie operacyjnym (np. Windows):
    // Klikając prawym przyciskiem myszy -> Właściwości, zobaczysz dokładnie tę samą wartość w bajtach!
}


// 5. Utwórz nowy plik tekstowy. Co się stanie, gdy już istnieje?
// Używamy funkcji fopen z parametrem "w" (write - zapis).
// CO SIĘ STANIE, GDY PLIK JUŻ ISTNIEJE? PHP bez ostrzeżenia wyczyści jego stary zawartość i nadpisze go od nowa!
$nowy_plik = fopen("testowy.txt", "w");
fwrite($nowy_plik, "Przykładowy tekst w pliku.");
fclose($nowy_plik);
echo "5. Utworzono (lub nadpisano) plik testowy.txt.<br>";


// 6. Usuń plik utworzony w pkt. 5.
// Funkcja unlink() służy do fizycznego kasowania plików z dysku.
if (file_exists("testowy.txt")) {
    unlink("testowy.txt");
    echo "6. Plik testowy.txt został pomyślnie usunięty.<br>";
}
?>
```

### Zadanie 2. Wyświetlanie zawartości pliku `dane.txt` po swojemu

**Krok 1:** Tworzysz na komputerze zwykły plik tekstowy o nazwie `dane.txt` i wpisujesz w nim swoje imię i nazwisko (np. _Jan Kowalski_). Zapisujesz plik w tym samym folderze, w którym masz skrypt PHP.

**Krok 2:** Piszesz poniższy skrypt PHP, który odczytuje ten plik i ubiera go w czerwony styl czcionki Arial za pomocą kodu HTML.

### PHP

```php
<?php
// Sprawdzamy czy plik istnieje, żeby uniknąć błędów
if (file_exists("dane.txt")) {
    // Pobieramy całą zawartość pliku do zmiennej tekstowej
    $zawartosc = file_get_contents("dane.txt");

    // Wyświetlamy tekst w przeglądarce, zamykając go w znaczniku HTML ze stylami CSS
    echo "<span style='font-family: Arial; color: red; font-size: 24px;'>" . $zawartosc . "</span>";
} else {
    echo "Plik dane.txt nie został znaleziony!";
}
?>
```

### Zadanie 3. Zapisywanie liczb parzystych i podzielnych przez 3 do pliku

Szukamy liczb od 1 do 1000, które dzielą się jednocześnie przez 2 (są parzyste) i przez 3. Zapisujemy je w pliku, a potem odczytamy.

### PHP

```php
<?php
$nazwa = "wyniki_zad3.txt";

// 1. Zapisujemy liczby do pliku
// Otwieramy plik do zapisu ("w")
$plik = fopen($nazwa, "w");

for ($i = 1; $i <= 1000; $i++) {
    // Sprawdzamy czy reszta z dzielenia przez 2 to 0 ORAZ reszta z dzielenia przez 3 to 0
    if ($i % 2 == 0 && $i % 3 == 0) {
        // Zapisujemy liczbę do pliku i dodajemy znak nowej linii (\n), żeby każda była w osobnym wierszu
        fwrite($plik, $i . "\n");
    }
}
fclose($plik); // Zamykamy plik po zapisaniu

// 2. Odczytujemy zawartość pliku i pokazujemy w przeglądarce
echo "<h3>Zawartość pliku z liczbami podzielnymi przez 2 i 3:</h3>";

if (file_exists($nazwa)) {
    // file_get_contents pobiera cały tekst z pliku naraz
    $tekst = file_get_contents($nazwa);

    // nl2br zamienia zwykłe entery z pliku tekstowego na znaczniki <br> zrozumiałe dla przeglądarki
    echo nl2br($tekst);
}
?>
```

### Zadanie 4. Odczytanie 4 liczb z pliku i posortowanie ich malejąco

Załóżmy, że w pliku `cztery_liczby.txt` masz zapisane w czterech osobnych linijkach np. takie liczby: `12`, `55`, `3`, `89`.

### PHP

```php
<?php
$nazwa = "cztery_liczby.txt";

// Załóżmy na chwilę, że plik nie istnieje – stwórzmy go programowo, żebyś mógł od razu przetestować:
file_put_contents($nazwa, "12\n55\n3\n89");

// Funkcja file() w PHP robi coś magicznego: odczytuje plik linijka po linijce i automatycznie wrzuca każdą linijkę do nowej komórki tablicy!
$tablica_liczb = file($nazwa, FILE_IGNORE_NEW_LINES);

// Sortujemy tablicę w kolejności MALEJĄCEJ (od największej do najmniejszej) za pomocą rsort()
rsort($tablica_liczb);

echo "<h3>Liczby w kolejności malejącej:</h3>";

// Wyświetlamy posortowane liczby za pomocą pętli foreach
foreach ($tablica_liczb as $liczba) {
    echo $liczba . "<br>";
}
?>
```

### Zadanie 5. 10 losowych liczb, zapis do pliku i znalezienie największej

Tworzymy 10 losowych liczb z przedziału 0-100, zapisujemy je w pliku, a potem otwieramy plik, szukamy największej wartości i ją wyświetlamy.

### PHP

```php
<?php
$nazwa = "losowe.txt";

// 1. Tworzymy plik i zapisujemy w nim 10 losowych liczb
$plik = fopen($nazwa, "w");

for ($i = 0; $i < 10; $i++) {
    $losowa = mt_rand(0, 100); // Losujemy liczbę od 0 do 100
    fwrite($plik, $losowa . "\n"); // Zapisujemy w nowej linii
}
fclose($plik);

// 2. Odczytujemy liczby z pliku z powrotem do tablicy
$wczytane_liczby = file($nazwa, FILE_IGNORE_NEW_LINES);

// 3. Szukamy największej liczby w tablicy za pomocą wbudowanej funkcji max()
$najwieksza = max($wczytane_liczby);

// 4. Wyświetlamy użytkownikowi co wylosowano i jaka jest największa
echo "<h3>Wylosowane liczby zapisane w pliku:</h3>";
echo implode(", ", $wczytane_liczby); // Łączymy ładnie przecinkami do wyświetlenia

echo "<h3>Największa wylosowana liczba to: <span style='color: blue;'>" . $najwieksza . "</span></h3>";
?>
```

# Obsługa plików w PHP

Obsługa plików w PHP może na początku brzmieć groźnie, ale w rzeczywistości to tak, jakbyś programowo robił to, co robisz na co dzień w folderach komputera. Rozłóżmy to na proste części.

## 1. Jak PHP sprawdza, co leży na dysku? (Zadanie 1)

Wyobraź sobie, że Twój skrypt staje się detektywem w folderze:

- **`file_exists("plik.txt")`** – pyta: „Czy ten plik w ogóle fizycznie leży w folderze?”. Zwraca `true` (tak) lub `false` (nie).
- **`is_dir("folder")`** – sprawdza, czy to, co wskazujesz, to na pewno teczka (katalog), a nie zwykły plik.
- **`is_file("plik.txt")`** – sprawdza dokładnie odwrotnie: czy to na pewno plik tekstowy, a nie folder.
- **`filesize("obrazek.png")`** – „waży” plik. Ponieważ dostajesz wynik w bajtach, dzielimy go przez 1024, żeby zamienić na kilobajty (KB) – dokładnie taką samą wartość zobaczysz we właściwościach pliku w systemie Windows.
- **Tworzenie i kasowanie (`fopen` z opcją `"w"` oraz `unlink`):** Kiedy otwierasz plik z literką `"w"` (write), PHP bierze czystą kartkę i ją tworzy. Ale uwaga: jeśli plik o tej nazwie już istniał, PHP bez ostrzeżenia wyczyści jego starą zawartość i nadpisze ją od nowa! Z kolei funkcja **`unlink()`** to po prostu cyfrowy przycisk „skasuj plik z dysku”.

## 2. Czytanie i stylowanie tekstu z pliku (Zadanie 2)

Masz plik `dane.txt` z imieniem i nazwiskiem. PHP otwiera go funkcją `file_get_contents()`, która zaciąga całą zawartość pliku naraz – tak, jakbyś zaznaczył cały tekst myszką i skopiował do schowka.

Żeby nie był nudny, owijamy go w prosty znacznik HTML z kolorem i czcionką (`<span style="color: red; font-family: Arial;">`), dzięki czemu przeglądarka wyświetli go dokładnie tak, jak chcesz.

## 3. Pętle, zapisywanie i szukanie rekordów (Zadania 3 i 5)

- **Zadanie 3 (Liczby podzielne przez 2 i 3):** Pętla `for` sprawdza po kolei każdą liczbę od 1 do 1000. Znak `%` (reszta z dzielenia) sprawdza, czy liczba dzieli się bez reszty przez 2 i przez 3 (`$i % 2 == 0 && $i % 3 == 0`). Jeśli pasuje, dopisujemy ją do pliku za pomocą `fwrite()` i wstawiamy znak nowej linii (`\n`), żeby każda lądowała w osobnym wierszu.
- **Zadanie 5 (Losowanie i szukanie największej):** Losujemy 10 liczb funkcją `mt_rand()` i zapisujemy je w pliku. Żeby potem łatwo z nimi pracować, używamy genialnej funkcji **`file()`**, która bierze plik linijka po linijce i automatycznie wrzuca każdą do osobnej szufladki w tablicy. Na koniec funkcja **`max()`** zagląda do tej tablicy i od razu wyciąga z niej najwyższą wartość.

## 4. Układanie liczb od największej do najmniejszej (Zadanie 4)

Kiedy odczytujesz z pliku kilka linijek tekstu (np. cztery zapisane liczby), masz je w zwykłej tablicy. Komputer sam z siebie nie wie, co jest mniejsze, a co większe.

Używasz więc funkcji **`rsort()`**, która bierze tę tablicę i układa jej elementy w porządku **malejącym** (od największego do najmniejszego). Potem wystarczy wyświetlić je po kolei za pomocą pętli `foreach`.
