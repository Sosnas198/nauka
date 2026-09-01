# Praktyczny przykład obsługi sesji w PHP – Krok po kroku dla początkujących

Ten poradnik pokazuje na żywym przykładzie, jak połączyć teorię sesji w praktyce za pomocą dwóch plików: `logowanie.php` oraz `tajne.php`.

## 1. Pierwszy plik: `logowanie.php`

Ten plik odpowiada za wyświetlanie formularza logowania, sprawdzanie wpisanych danych oraz obsługę wylogowywania.

PHP

```php
<?php
session_start();

// Sprawdzanie, czy użytkownik kliknął przycisk "wyloguj"
if (isset($_GET['akcja']) && $_GET['akcja'] == 'wyloguj') {
    unset($_SESSION['zalogowany']); // Rozłączenie/usunięcie sesji
}

// Sprawdzanie, czy podano poprawny login i hasło ("admin" i "admin")
if (isset($_POST['login']) && isset($_POST['pass']) && $_POST['login'] == "admin" && $_POST['pass'] == "admin") {
    $_SESSION['zalogowany'] = 1; // Ustawienie zmiennej sesyjnej po udanym zalogowaniu
}

// Jeśli użytkownik nie jest zalogowany, pokazywanych jest formularz
if (!isset($_SESSION['zalogowany'])) {
    ?>
    <!DOCTYPE HTML>
    <html lang="pl">
    <head>
        <meta charset="utf-8" />
        <title>Tytuł strony</title>
    </head>
    <body>
        <form method="post">
            Login: <input type="text" name="login"><br/>
            Hasło: <input type="password" name="pass"><br/>
            <input type="submit" value="Zaloguj">
        </form>
    </body>
    </html>
    <?php
} else {
    // Jeśli użytkownik jest zalogowany, wyświetlamy powitanie i link do wylogowania
    echo "Witaj na stronie<br/>";
    echo "<a href='logowanie.php?akcja=wyloguj'>wyloguj</a>"; // Link wylogowujący z wykorzystaniem metody GET
}
?>

```

## 2. Drugi plik: `tajne.php`

Ten plik udowadnia, że sesja „pamięta” użytkownika także na innych podstronach witryny. Sprawdza on, czy zmienna sesyjna z pierwszego pliku nadal istnieje.

PHP

```php
<?php
session_start();

// Sprawdzanie, czy ustawiono zmienną sesyjną (tak samo jak w pliku logowanie.php)
if (isset($_SESSION['zalogowany'])) {
    echo "Jest dostęp :)";
} else {
    echo "Brak dostępu :(";
}
?>

```

## 3. Jak przetestować to samodzielnie na komputerze?

- Umieść oba pliki (`logowanie.php` oraz `tajne.php`) na swoim serwerze lokalnym (`localhost`).
- Otwórz oba pliki w dwóch osobnych kartach przeglądarki.
- W karcie z plikiem `logowanie.php` wpisz w formularzu login: `admin` i hasło: `admin`, a następnie wyślij formularz.
- Przejdź do karty z plikiem `tajne.php` i odśwież stronę – zobaczysz informację o przyznaniu dostępu.
- Wróć do karty logowania, kliknij link wylogowujący, a następnie odśwież kartę z plikiem `tajne.php` ponownie, aby zobaczyć komunikat o braku dostępu.
