PHP pozwala na łatwe zarządzanie plikami na serwerze: możesz je sprawdzać, tworzyć, otwierać, czytać oraz zapisywać w nich dane.

## 1. Sprawdzanie i podstawowe operacje na plikach

* **`file_exists('nazwa_pliku')`**: Sprawdza, czy wskazany plik lub katalog w ogóle istnieje. Zwraca wartość `true`, jeśli istnieje, lub `false`, jeśli go nie ma.
* **`is_file('nazwa_pliku')`**: Weryfikuje, czy podany element jest plikiem (zwraca `true` lub `false`).
* **`filesize('nazwa_pliku')`**: Zwraca rozmiar pliku podany w bajtach (jako liczba całkowita / integer).
* **`touch('nazwa_pliku')`**: Tworzy nowy, pusty plik. Jeśli plik już istnieje, jego zawartość nie zostanie zmieniona – zaktualizowana zostanie jedynie data modyfikacji.
* **`unlink('nazwa_pliku')`**: Służy do usuwania istniejących plików. Zwraca `true` po udanym skasowaniu lub `false` w przypadku niepowodzenia.

## 2. Otwieranie i zamykanie pliku (`fopen` oraz `fclose`)

Zanim zaczniesz cokolwiek czytać z pliku lub do niego zapisywać, musisz go najpierw **otworzyć i przypisać do zmiennej** (w poniższych przykładach będzie to zmienna `$plik`). Po skończonej pracy plik należy zamknąć.

PHP

```php id="4n0j2s"
$plik = fopen('plik.txt', 'r'); // Otwarcie pliku
// ... Twoje operacje na pliku ...
fclose($plik); // Zamknięcie pliku

```

### Tryby otwierania pliku (drugi argument `fopen`):

* **`r`**: Otwiera plik **tylko do odczytu**.
* **`r+`**: Otwiera plik do odczytu i zapisu (dane dopisywane są na początku).
* **`w`**: Otwiera plik **tylko do zapisu**. Uwaga: jeśli plik już istnieje, jego zawartość zostanie **całkowicie skasowana**; jeśli nie istnieje, PHP spróbuje go utworzyć.
* **`w+`**: Otwiera plik do odczytu i zapisu (kasuje dotychczasową zawartość lub tworzy nowy plik).
* **`a`**: Otwiera plik **do dopisywania danych**. Nowe informacje będą zawsze doklejaane **na samym końcu** pliku.
* **`a+`**: Otwiera plik do odczytu i dopisywania danych na końcu.

> *Uwaga:* Funkcja `fopen` zwraca `false`, jeśli otworzenie pliku się nie powiodło.

## 3. Odczytywanie zawartości pliku

W PHP masz do dyspozycji kilka funkcji służących do wyciągania danych z plików:

### Odczyt wiersz po wierszu (`fgets` i `feof`)

* **`fgets($plik, liczba_znaków)`**: Odczytuje pojedynczy wiersz tekstu (do określonej liczby znaków).
* **`feof($plik)`**: Sprawdza, czy program dotarł już do **konca pliku** (zwraca `true`, gdy to nastąpi). Bardzo często łączy się ją w pętli z funkcją `fgets`:

PHP

```php id="8e6w3q"
if ($plik = fopen('plik.txt', 'r')) {
    while (!feof($plik)) {
        $tresc = fgets($plik, 100);
        echo $tresc . '<br/>';
    }
    fclose($plik);
} else {
    echo 'Nie można otworzyć pliku';
}

```

### Odczyt po jednym znaku (`fgetc`)

* **`fgetc($plik)`**: Pobiera z pliku dokładnie jeden znak, a wskaźnik przesuwa się o jeden krok dalej. Gdy dojdzie do końca pliku, zwraca `false`.

### Odczyt bloków danych (`fread`)

* **`fread($plik, liczba_znaków)`**: Pozwala odczytać określoną liczbę znaków jako jeden blok.
* Jeśli chcesz odczytać **cały plik na raz**, możesz połączyć `fread` z funkcją `filesize()`:

  PHP

  ```php id="y8h2ma"
  $plik = fopen('plik.txt', 'r');
  $tresc = fread($plik, filesize('plik.txt'));
  echo $tresc;
  fclose($plik);

  ```

### Odczyt do tablicy (`file`)

* **`file('nazwa_pliku')`**: Odczytuje całą zawartość pliku i wrzuca ją bezpośrednio do tablicy – każda linijka tekstu staje się osobną komórką tablicy.

## 4. Zapisywanie do pliku

Do zapisywania danych służą funkcje **`fwrite()`** lub jej alias **`fputs()`**.

* Pierwszym argumentem funkcji jest zmienna przechowująca otwarty plik (`$plik`), a drugim tekst, który chcesz dopisać.
* Funkcja zwraca `false`, jeśli zapis się nie powiódł.

### Przykład bezpiecznego dopisywania tekstu do pliku:

PHP

```php id="5x7r1c"
$tekst = 'To jest tekst do wpisania';

// Otwieramy plik w trybie 'a' (dopisywanie na końcu)
if ($plik = fopen('plik.txt', 'a')) {
    if (fwrite($plik, $tekst) == false) {
        echo 'Zapis do pliku nie powiódł się';
    } else {
        echo 'Zapisano: ' . $tekst;
    }
    fclose($plik);
} else {
    echo 'Zapis do pliku nie powiódł się';
}
```
