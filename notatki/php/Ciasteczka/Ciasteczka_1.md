Ciasteczka (cookies) to malutkie pliki tekstowe, które strona internetowa może zapisać na Twoim komputerze za pośrednictwem przeglądarki. Służą do przechowywania niedużych ilości danych (maksymalnie 4 KB), takich jak zapamiętanie, czy użytkownik jest zalogowany, albo jak się nazywa.

Gdy wchodzisz na jakąś stronę, Twoja przeglądarka najpierw sprawdza, czy ma w pamięci zapisane jakieś ciasteczka dla tej witryny, i jeśli tak – przesyła je z powrotem do serwera.

## 1. Jak utworzyć ciasteczko? (`setcookie`)

Do tworzenia ciasteczek w PHP służy funkcja `setcookie()`.

Może ona przyjąć nawet 6 różnych argumentów, ale **wymagany jest tylko pierwszy** (nazwa ciasteczka):

PHP

```
setcookie($nazwa, $wartosc, $koniec, $sciezka, $domena, $bezpieczne);

```

- **`$nazwa`**: unikalna nazwa ciastka (np. `'nick'`).
- **`$wartosc`**: dane, które chcesz w nim schować (np. `'Kasia'`).
- **`$koniec`**: data wygaśnięcia (ważności) ciasteczka.
- **`$sciezka`** i **`$domena`**: określają, dla jakich adresów i ścieżek ciastko jest ważne.
- **`$bezpieczne`**: jeśli ustawione, ciastko będzie wysyłane tylko przez szyfrowane połączenie (HTTPS).

W praktyce najczęściej korzysta się z trzech pierwszych argumentów.

## 2. Jak ustawić czas ważności ciasteczka?

Ciasteczka nie żyją wiecznie – musimy określić, jak długo mają zostać na dysku. Czas podajemy w formie **liczby sekund**, które upłynęły od 1 stycznia 1970 roku.

Z pomocą przychodzi funkcja `time()`, która zwraca aktualny czas w sekundach. Do tego wyniku dodajemy tyle sekund, przez ile ciastko ma działać.

- **Przykład – ciastko ważne przez 1 godzinę:**

  PHP

  ```
  setcookie('nick', 'Kasia', time() + 3600);

  ```

  _(Skąd 3600? 1 godzina = 60 minut $\times$ 60 sekund)_

## 3. Jak odczytać ciasteczko? (`$_COOKIE`)

Wszystkie zapisane ciasteczka lądują w specjalnej tablicy globalnej `$_COOKIE`. Działa ona bardzo podobnie do tablicy `$_GET`.

Aby wyświetlić wartość ciastka o nazwie `'nick'`, piszemy:

PHP

```
echo "Masz na imię " . $_COOKIE['nick'];

```

## 4. Bardzo ważne zasady bezpieczeństwa i działania

1. **Kolejność wysyłania:** Funkcję `setcookie()` musisz wywołać **zanim** na stronie pojawi się jakikolwiek kod HTML (nawet spacja czy znacznik `<html>`). Ciasteczka modyfikują tzw. nagłówki serwera, które muszą polecieć do przeglądarki jako pierwsze.
2. **Kodowanie znaków (np. base64):** Ciasteczka przechowują zwykły tekst. Jeśli chcesz przesłać tam coś skomplikowanego albo znaki specjalne, warto dane zakodować (np. za pomocą funkcji `base64_encode()`, a przy odczycie zdekodować przez `base64_decode()`).

   PHP

   ```
   setcookie('nick', base64_encode('Kasia'), time() + 3600);
   echo "Masz na imię " . base64_decode($_COOKIE['nick']);

   ```

3. **Jak skasować ciasteczko?** Żeby usunąć istniejące ciastko, wystarczy wywołać funkcję `setcookie()` z tą samą nazwą, ale ustawiając czas jego ważności na **przeszłość** (lub na `0`):

   PHP

   ```
   setcookie('wizyta', '', 0);

   ```

## 5. Praktyczne przykłady zastosowania

### Przykład A: Sprawdzanie ostatniej wizyty użytkownika

Ten skrypt sprawdza, czy użytkownik ma już zapisane ciastko `'wizyta'`. Jeśli nie – wita go jako nowego gościa i tworzy ciastko na 30 dni. Jeśli je ma – wyświetla dokładną datę i godzinę jego ostatniej wizyty.

PHP

```
setcookie('wizyta', time(), time() + 30 * 86400);

if (!isset($_COOKIE['wizyta'])) {
    echo 'Witaj, gościu.';
} else {
    echo 'Witaj, ostatni raz odwiedziłeś nas ' . date('d.m.Y, H:i', $_COOKIE['wizyta']);
}

```

### Przykład B: Jak zapisać w ciasteczku całą tablicę?

Standardowo ciasteczka przyjmują tylko tekst. Jeśli chcesz zapisać w nich całą tablicę PHP, musisz ją najpierw „spakować” funkcją `serialize()`, a przy odczycie „rozpakować” funkcją `unserialize()`.

PHP

```
// Zapis tablicy
$tablica = array('a' => 'pierwszy', 'b' => 'drugi');
setcookie('tablica', serialize($tablica), time() + 3600);

// Odczyt z zabezpieczeniem przed brakiem ciastka
if (isset($_COOKIE['tablica'])) {
    $tablica = unserialize($_COOKIE['tablica']);
} else {
    $tablica = array();
}

```

### Przykład C: Obsługa formularza i zapamiętywanie danych

Często ciasteczka łączymy z formularzami HTML, aby zapamiętać wpisane przez użytkownika imię lub nazwę. Poniższy skrypt obsługuje trzy sytuacje:

1. Użytkownik nie przesłał jeszcze formularza i nie ma ciasteczka $\rightarrow$ pokazywany jest formularz.
2. Formularz został wysłany $\rightarrow$ tworzone jest ciasteczko z wpisanymi danymi i pojawia się podziękowanie.
3. Ciasteczko już istnieje i dane zostały przesłane $\rightarrow$ strona wita użytkownika ponownie po imieniu.

PHP

```
if (!isset($_COOKIE['dane']) && !isset($_POST['nazw'])) {
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <title>Dane_user</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <form action="" method="post">
            Podaj nazwisko i imię: <br/>
            <input type="text" name="nazw" size="35">
            <p><input type="submit" value="Wyślij" name="wyslij"></p>
        </form>
    </body>
    </html>
    <?php
} else {
    if (isset($_POST['nazw'])) {
        setcookie('dane', $_POST['nazw'], time() + 60 * 60 * 24 * 365);
        echo "<p>Dziękujemy za wprowadzenie danych.</p>";
    } else {
        echo "<p>Witamy po raz kolejny! " . $_COOKIE['dane'] . "</p>";
    }
}
```
