# 🍪 Ciasteczka w PHP

Ciasteczka (ang. _cookies_) brzmią tajemniczo, ale to nic innego jak małe karteczki z informacjami, które Twoja przeglądarka internetowa zapisuje na polecenie serwera. Kiedy wchodzisz na stronę, serwer może Ci taką karteczkę przypiąć do kurtki, a gdy wracasz, odczytuje ją, żeby sprawdzić, kim jesteś i co już u niego robiłeś.

Rozłóżmy te cztery zadania na czynniki pierwsze – zupełnie po amatorsku.

## Zadanie 1. Testowanie skryptów z pliku PDF

_Ponieważ nie podano dokładnej treści pliku PDF w tym konkretnym poleceniu, zazwyczaj chodzi o podstawową obsługę ciasteczek w PHP za pomocą funkcji_ **`setcookie()`**. Oto jak wygląda absolutna baza, którą warto przetestować:

### PHP

```php
<?php
// Tworzymy ciastko o nazwie "odwiedziny" i wartości "tak", które żyje przez 1 godzinę
setcookie("odwiedziny", "tak", time() + 3600);

echo "Ciasteczko zostało wysłane do Twojej przeglądarki!";
?>
```

- **Jak to działa?** Funkcja `setcookie()` musi być wywołana **zanim** przeglądarka wyświetli cokolwiek na ekranie (nawet przed zwykłym HTML-em). Pierwszy argument to nazwa, drugi to wartość, a trzeci to czas życia (aktualny czas `time()` powiększony o liczbę sekund, np. `3600` sekund czyli godzina).

## Zadanie 2. Powitanie nowego i powracającego użytkownika (Sprawdzanie ciasteczka)

Chcemy sprawdzić, czy użytkownik jest u nas po raz pierwszy, czy ma już w swojej przeglądarce nasze ciasteczko. Używamy do tego globalnej tablicy `$_COOKIE`.

### PHP

```php
<?php
// Sprawdzamy, czy ciasteczko o nazwie "byl_tutaj" w ogóle istnieje w przeglądarce użytkownika
if (isset($_COOKIE['byl_tutaj'])) {
    // Jeśli ciastko istnieje, to znaczy, że użytkownik już tu był
    echo "Witaj ponownie! Miło Cię znowu widzieć na naszej stronie.";
} else {
    // Jeśli ciasteczka NIE ma, to znaczy, że to nowa osoba.
    // Tworzymy dla niej ciasteczko, które będzie ważne przez rok (31536000 sekund)
    setcookie("byl_tutaj", "tak", time() + 31536000);

    echo "Dzień dobry! Witaj po raz pierwszy na naszej stronie!";
}
?>
```

- **Wyjaśnienie:** `isset($_COOKIE['byl_tutaj'])` sprawdza, czy "karteczka" o tej nazwie wróciła razem z użytkownikiem. Jeśli tak – witamy go ponownie. Jeśli nie – witamy go po raz pierwszy i od razu dajemy mu nową karteczkę na drogę za pomocą `setcookie()`.

## Zadanie 3. Ciasteczko na 1 minutę oraz licznik dni do urodzin

To zadanie składa się z dwóch części. Zróbmy je po kolei w prosty sposób.

### Część A: Ciastko na 1 minutę

### PHP

```php
<?php
$nazwa_ciastka = "minutowka";

// Sprawdzamy, czy formularz/strona właśnie wywołała utworzenie ciastka
// (lub tworzymy je automatycznie przy wejściu)
if (!isset($_COOKIE[$nazwa_ciastka])) {
    // Tworzymy ciastko na dokładnie 60 sekund (1 minuta)
    setcookie($nazwa_ciastka, "aktywne", time() + 60);
    echo "Ciastko zostało przed chwilą utworzone! (Ważne przez 1 minutę).<br>";
} else {
    echo "Ciastko NADAL istnieje w przeglądarce.<br>";
}

// Sprawdzenie zaraz po utworzeniu / po czasie:
if (isset($_COOKIE[$nazwa_ciastka])) {
    echo "Status: Ciastko istnieje.";
} else {
    echo "Status: Ciastko wygasło lub jeszcze nie dotarło (odśwież stronę po minucie, aby zobaczyć, że zniknęło).";
}
?>
```

### Część B: Zapamiętywanie daty urodzin i liczenie dni do urodzin

Do tego potrzebujemy formularza, w którym użytkownik wpisze datę, a potem małej matematyki dat w PHP.

### PHP

```php
<form method="POST" action="">
    Podaj swoje urodziny (np. RRRR-MM-DD): <input type="date" name="urodziny">
    <input type="submit" value="Zapisz">
</form>

<?php
// 1. Jeśli użytkownik wysłał formularz, zapisujemy datę w ciasteczku na 30 dni
if (isset($_POST['urodziny']) && !empty($_POST['urodziny'])) {
    $data_urodzin = $_POST['urodziny'];
    setcookie("data_urodzin", $data_urodzin, time() + (86400 * 30)); // 30 dni
    echo "Zapisano Twoją datę urodzin w ciasteczku!<br>";
}
// 2. Sprawdzamy, czy mamy zapisaną datę w ciasteczku
elseif (isset($_COOKIE['data_urodzin'])) {
    $data_urodzin = $_COOKIE['data_urodzin'];
    echo "Twoje zapamiętane urodziny to: $data_urodzin<br>";

    // Obliczamy ile dni zostało do urodzin w bieżącym roku
    $dzisiaj = new DateTime(); // dzisiejsza data
    $rok_biezacy = $dzisiaj->format('Y');

    // Wyciągamy miesiąc i dzień z zapamiętanej daty użytkownika
    $wyciagniete_urodziny = DateTime::createFromFormat('Y-m-d', $data_urodzin);
    $wyciagniete_urodziny->setDate($rok_biezacy, $wyciagniete_urodziny->format('m'), $wyciagniete_urodziny->format('d'));

    // Jeśli w tym roku urodziny już minęły, liczymy datę na przyszły rok
    if ($dzisiaj > $wyciagniete_urodziny) {
        $wyciagniete_urodziny->modify('+1 year');
    }

    // Liczymy różnicę dni
    $roznica = $dzisiaj->diff($wyciagniete_urodziny);
    $dni_do_urodzin = $roznica->days;

    echo "Do Twoich kolejnych urodzin zostało dokładnie: <strong>$dni_do_urodzin dni</strong>!";
} else {
    echo "Wypełnij formularz powyżej, aby zapamiętać datę urodzin.";
}
?>
```

## Zadanie 4. Formularz jednorazowy, imię, wiek i sprawdzanie 13 lat

To zadanie łączy wszystko: formularz, ciasteczka, sprawdzanie wieku oraz logikę wyświetlania tekstu w zależności od tego, czy użytkownik jest u nas po raz pierwszy, czy kolejny.

### PHP

```php
<?php
// Sprawdzamy, czy użytkownik przesłał formularz
if (isset($_POST['imie']) && isset($_POST['data_ur'])) {
    $imie = $_POST['imie'];
    $data_ur = $_POST['data_ur'];

    // Tworzymy ciasteczko z imieniem (ważne np. 1 godzinę)
    setcookie("uzytkownik_imie", $imie, time() + 3600);
    // Tworzymy ciasteczko z datą urodzenia
    setcookie("uzytkownik_data", $data_ur, time() + 3600);

    // Odświeżamy stronę (albo po prostu wyświetlamy treść poniżej),
    // żeby skrypt "zauważył" nowe ciasteczko przy kolejnym kroku
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Formularz i wiek</title></head>
<body>

<?php
// Sprawdzamy, czy ciastko z imieniem JUŻ ISTNIEJE (czyli użytkownik już kiedyś wklepał dane)
if (isset($_COOKIE['uzytkownik_imie']) && isset($_COOKIE['uzytkownik_data'])) {

    $imie = $_COOKIE['uzytkownik_imie'];
    $data_ur = $_COOKIE['uzytkownik_data'];

    // Obliczamy wiek na podstawie daty urodzenia
    $data_urodzenia_obj = new DateTime($data_ur);
    $dzisiaj = new DateTime();
    $wiek = $dzisiaj->diff($data_urodzenia_obj)->y; // wyciągamy pełne lata

    // Sprawdzamy warunek 13 lat
    if ($wiek >= 13) {
        echo "Witaj $imie, masz $wiek lat.";
    } else {
        echo "$imie nie masz ukończonych 13 lat.";
    }

} else {
    // Jeśli ciasteczek NIE MA, pokazujemy formularz po raz pierwszy
    ?>
    <form method="POST" action="">
        Podaj swoje imię: <input type="text" name="imie" required><br><br>
        Data urodzenia: <input type="date" name="data_ur" required><br><br>
        <input type="submit" value="Wyślij">
    </form>
    <?php
}
?>

</body>
</html>
```

### Jak to działa krok po kroku?

1. Kiedy wchodzisz na stronę po raz pierwszy, ciasteczek nie ma → komputer pokazuje Ci **formularz**.
2. Wpisujesz imię i datę urodzenia, klikasz „Wyślij”. Skrypt odbiera te dane i zapisuje je w **ciasteczkach** (`setcookie`).
3. Gdy odświeżysz stronę lub wrócisz na nią później, przeglądarka ma już zapisaną „karteczkę”. Skrypt to wykrywa (`isset($_COOKIE)`), oblicza Twój wiek odejmując datę urodzenia od dzisiejszego dnia, a następnie – zależnie od tego, czy masz 13 lat, czy mniej – wyświetla odpowiedni komunikat powitalny z Twoim imieniem!

# 🍪 Ciasteczka w PHP – wyjaśnienie „na chłopski rozum”

Wyobraź sobie, że przeglądarka internetowa to duży klub, a Ty jesteś ochroniarzem.

Ciastka (_cookies_) to po prostu **pieczątki na ręku**, które dajesz klientom. Dzięki tej pieczątce wiesz, kto już u Ciebie był, a kto wchodzi po raz pierwszy.

Rozłóżmy to na najprostsze czynniki:

## 1. Jak działa pieczątka? (`setcookie` i `$_COOKIE`)

- **Gdy ktoś przychodzi po raz pierwszy (brak ciastka):**

  Nie ma pieczątki na ręku. Musisz mu dać kartkę z formularzem (_„Podaj imię i datę urodzenia”_). Kiedy on to wpisze i kliknie wyślij, Ty mówisz przeglądarce: _„Zapisz mu tę pieczątkę na 1 godzinę!”_. Służy do tego funkcja `setcookie("nazwa", "wartość", czas)`.

- **Gdy ktoś wraca na stronę (ciastko już istnieje):**

  Klient przychodzi drugi raz. Jego przeglądarka automatycznie pokazuje Ci tę pieczątkę w kieszeni. PHP sprawdza to magicznym pytaniem: `if (isset($_COOKIE['nazwa']))`. Skoro pieczątkę ma, to od razu wiesz, kim jest, i nie pytasz go o dane po raz drugi – tylko od razu go witasz!

## 2. Zadanie po zadaniu – tłumaczenie „na chłopski rozum”

### Zadanie 2: Powitanie nowego i powracającego

- **Co robimy?** Sprawdzamy kieszeń użytkownika.
- **Kod w pigułce:**
  - Jeśli _ma_ ciastko (`isset`): mówimy _„Witaj ponownie!”_.
  - Jeśli _nie ma_ ciastka: dajemy mu nowe ciastko (`setcookie`) i mówimy _„Dzień dobry, witaj po raz pierwszy!”_.

### Zadanie 3: Ciastko na 1 minutę i liczenie dni do urodzin

- **Czas życia ciastka (`time() + 60`):**

  To tak, jakbyś powiedział: _„Ta pieczątka zmyje się dokładnie za 60 sekund”_. Jeśli użytkownik odświeży stronę po minucie, przeglądarka „wytrze pieczątkę” i skrypt znowu uzna go za nowego.

- **Liczenie dni do urodzin:**

  Użytkownik wpisuje datę w formularzu, a my chowamy ją w ciastku. Potem komputer bierze dzisiejszą datę z zegarka, odejmuje od niej datę urodzin i wypluwa wynik: _„Do Twoich urodzin zostało X dni!”_.

### Zadanie 4: Jednorazowy formularz, wiek i sprawdzanie 13 lat

To połączenie wszystkiego w jedną całość:

1. Wchodzisz na stronę → brak ciasteczka → wyskakuje **formularz**.
2. Wpisujesz _Ania_ i _2015-01-01_.
3. Skrypt natychmiast robi dwie rzeczy: zapisuje to w ciastkach (pieczątkach) i liczy wiek (odejmuje rok urodzenia od dzisiejszego roku).
4. Sprawdza warunek:
   - Jeśli wiek $\ge$ 13: wyświetla np. _„Witaj Ania, masz X lat.”_
   - Jeśli wiek $<$ 13: wyświetla _„Ania nie masz ukończonych 13 lat.”_

5. Gdy odświeżysz stronę, formularz już się **nie pojawi**, bo przeglądarka ma pieczątkę i od razu wyświetli gotowy komunikat o wieku!
