## 1. Jak działa sesja?

* Wszystkie kluczowe dane sesji są przechowywane **po stronie serwera**, więc użytkownik nie ma do nich bezpośredniego dostępu i nie może ich zmienić.
* Jedyne, co trafia na komputer użytkownika, to małe ciasteczko sesyjne.
* Ciasteczko to zawiera tylko jedną rzecz: losowy numer ID, który jednoznacznie identyfikuje danego użytkownika w systemie.
* Przy każdym odświeżeniu strony przeglądarka odsyła to ciasteczko do serwera, dzięki czemu serwer wie, z kim ma do czynienia.

## 2. Startujemy z sesją (`session_start`)

Każdy plik PHP, który korzysta z sesji, musi na samym początku zawierać funkcję startową:

PHP

```php
<?php
session_start();

```

* Funkcja `session_start()` nie przyjmuje żadnych parametrów.
* To ona wysyła do użytkownika unikalny numer ID sesji, który nie zmienia się przez cały czas trwania wizyty.
* Domyślnie sesja wygasa po około 15 minutach nieaktywności.

## 3. Sprawdzanie, czy użytkownik jest zalogowany (`$_SESSION`)

Do obsługi sesji służy specjalna tablica globalna `$_SESSION` (działa podobnie do znanych z formularzy tablic `$_GET` czy `$_POST`).

Możemy sprawdzić za jej pomocą, czy zmienna sesyjna o nazwie np. `zalogowany` w ogóle istnieje:

PHP

```php
if (!isset($_SESSION['zalogowany'])) {
    // Jeśli użytkownik NIE jest zalogowany – pokazujemy formularz logowania
} else {
    // Jeśli JEST zalogowany – wyświetlamy poufną treść
    echo "Witaj na stronie<br/>";
}

```

Funkcja `isset()` sprawdza po prostu, czy dana zmienna została wcześniej utworzona.

## 4. Obsługa logowania (Sprawdzanie danych)

Formularz logowania powinien pojawiać się tylko wtedy, gdy użytkownik nie jest jeszcze zalogowany. Gdy wyśle dane przez formularz metodą POST, musimy je sprawdzić:

PHP

```php
if (isset($_POST['login']) && isset($_POST['pass']) && $_POST['login'] == "admin" && $_POST['pass'] == "admin") {
    $_SESSION['zalogowany'] = 1; // Ustawiamy zmienną sesyjną, co oznacza udane logowanie
}

```

* Jeśli podany login i hasło to `"admin"`, skrypt tworzy zmienną sesyjną `$_SESSION['zalogowany']` i przypisuje jej dowolną wartość (np. `1`). Od tego momentu system wie, że użytkownik jest zalogowany.

## 5. Jak zrobić wylogowanie?

Aby umożliwić użytkownikowi wylogowanie się, dodajemy specjalny link przekazujący akcję metodą GET:

PHP

```php
echo "<a href='logowanie.php?akcja=wyloguj'>wyloguj</a>";

```

Na samym początku pliku (zaraz po `session_start()`) dodajemy instrukcję, która wyłapuje to kliknięcie i kasuje zmienną sesyjną za pomocą funkcji `unset()`:

PHP

```php
if (isset($_GET['akcja']) && $_GET['akcja'] == 'wyloguj') {
    unset($_SESSION['zalogowany']); // Usuwa zmienną sesyjną, czyli wylogowuje użytkownika
}

```

## 6. Ochrona stron (Dostęp tylko dla zalogowanych)

Dzięki temu, że sesja działa na serwerze, możesz zabezpieczyć dowolną podstronę swojej witryny. Jeśli umieścisz poniższy kod w nowym pliku PHP, dostęp do niego będą mieli wyłącznie użytkownicy, którzy wcześniej poprawnie się zalogowali:

PHP

```php
<?php
session_start();

if (isset($_SESSION['zalogowany'])) {
    echo "Jest dostęp :)";
} else {
    echo "Brak dostępu!";
}
```
