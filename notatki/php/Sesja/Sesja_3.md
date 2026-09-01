### Krok 1: Tworzenie bazy danych i import pliku SQL

1. Włącz swój serwer lokalny (np. XAMPP i uruchom moduły **Apache** oraz **MySQL**).
2. Otwórz przeglądarkę i wejdź pod adres: `http://localhost/phpmyadmin/`
3. Po lewej stronie kliknij przycisk **Nowa** (New), aby utworzyć nową bazę danych.
4. Wpisz nazwę bazy (np. `baza_samochody`) i kliknij **Utwórz**.
5. Kliknij na nowo utworzoną bazę po lewej stronie, a następnie w górnym menu wybierz zakładkę **Import**.
6. Kliknij **Wybierz plik**, wskaż swój plik z danymi (z rozszerzeniem `.sql`) i na samych dole kliknij przycisk **Wykonaj**. Dane zostaną zaimportowane.

### Krok 2: Dodanie tabeli `USER` w bazie danych

Aby użytkownicy mogli się logować, w tej samej bazie danych musimy stworzyć tabelę przechowującą ich dane.

1. W phpMyAdmin przejdź do zakładki **SQL** w swojej bazie danych.
2. Wklej poniższe zapytanie SQL i kliknij **Wykonaj**:

### SQL

```sql id="gyj3h0"
CREATE TABLE USER (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL,
    haslo VARCHAR(255) NOT NULL,
    rola VARCHAR(20) NOT NULL,
    imie_nazwisko VARCHAR(100) NOT NULL
);
```

- **Wyjaśnienie dla amatora:** Tworzymy tabelę z kolumnami: `id` (unikalny numer każdego użytkownika, rosnący automatycznie), `login` (tekst do logowania), `haslo` (hasło użytkownika), `rola` (np. `user` lub `admin`) oraz `imie_nazwisko` (pełne dane użytkownika, które wyświetlimy po zalogowaniu).

Dodajmy od razu dwóch przykładowych użytkowników (jednego zwykłego usera i jednego administratora), wklejając to zapytanie:

### SQL

```sql id="6r5v9k"
INSERT INTO USER (login, haslo, rola, imie_nazwisko) VALUES
('jan', '1234', 'user', 'Jan Kowalski'),
('admin', 'admin123', 'admin', 'Anna Nowak (Administrator)');
```

_(W rzeczywistych systemach hasła się szyfruje, ale na poziomie nauki dla początkujących możemy trzymać je w czystym tekście)._

### Krok 3: System logowania i sesje (Rozróżnienie ról)

Sesja w PHP to taki "magazyn", który pamięta, że użytkownik się zalogował i kim jest, gdy przechodzi między podstronami.

Stwórz plik `index.php` (lub `logowanie.php`), który będzie zawierał formularz logowania oraz kod obsługujący sesję:

### PHP

```php id="x4f8n2"
<?php
// Rozpoczynamy sesję na samym początku pliku!
session_start();

// Połączenie z bazą danych (zakładając lokalny serwer bez hasła do bazy)
$polaczenie = mysqli_connect("localhost", "root", "", "baza_samochody");

// Sprawdzamy, czy formularz został wysłany
if (isset($_POST['login']) && isset($_POST['haslo'])) {
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    // Szukamy użytkownika w bazie
    $zapytanie = "SELECT * FROM USER WHERE login='$login' AND haslo='$haslo'";
    nietyczne: $wynik = mysqli_query($polaczenie, $zapytanie);

    if (mysqli_num_rows($wynik) == 1) {
        $rekord = mysqli_fetch_assoc($wynik);

        // Zapisujemy dane użytkownika w sesji
        $_SESSION['zalogowany'] = true;
        $_SESSION['imie_nazwisko'] = $rekord['imie_nazwisko'];
        $_SESSION['rola'] = $rekord['rola'];

        echo "Zalogowano pomyślnie!";
    } else {
        echo "Błędny login lub hasło!";
    }
}
?>

<!-- Formularz logowania (wyświetla się tylko wtedy, gdy NIE jesteśmy zalogowani) -->
<?php if (!isset($_SESSION['zalogowany'])): ?>
    <form method="POST" action="">
        Login: <input type="text" name="login"><br><br>
        Hasło: <input type="password" name="haslo"><br><br>
        <input type="submit" value="Zaloguj się">
    </form>
<?php else: ?>
    <!-- Powitanie użytkownika -->
    <h2>Witaj, <?= $_SESSION['imie_nazwisko']; ?>!</h2>
    <p>Twoja rola to: <strong><?= $_SESSION['rola']; ?></strong></p>
    <p><a href="logout.php">Wyloguj się</a></p>
<?php endif; ?>
```

### Krok 4: Panel zwykłego użytkownika (Przeglądanie aut i filtrowanie po kolorze)

Gdy użytkownik jest zalogowany (lub w osobnym pliku panelu), dopisujemy funkcjonalność wyświetlania samochodów z tabeli `samochody` oraz listę rozwijaną z kolorami pobieranymi dynamicznie z bazy.

### PHP

```php id="1d5z8x"
<?php
session_start();
$polaczenie = mysqli_connect("localhost", "root", "", "baza_samochody");

// Sprawdzamy, czy użytkownik w ogóle ma prawo tu być
if (!isset($_SESSION['zalogowany'])) {
    die("Musisz się najpierw zalogować!");
}
?>

<h2>Panel użytkownika: Przeglądaj samochody</h2>

<!-- Formularz wyboru koloru (lista rozwijalna) -->
<form method="GET" action="">
    <label>Wybierz kolor:</label>
    <select name="kolor">
        <option value="">Wszystkie kolory</option>
        <?php
        // Pobieramy unikalne kolory z bazy danych do listy rozwijalnej
        $sql_kolory = "SELECT DISTINCT kolor FROM samochody";
        $wynik_kolory = mysqli_query($polaczenie, $sql_kolory);

        while ($k = mysqli_fetch_assoc($wynik_kolory)) {
            // Zabezpieczenie przed zaznaczeniem złej opcji po odświeżeniu
            $wybrane = (isset($_GET['kolor']) && $_GET['kolor'] == $k['kolor']) ? "selected" : "";
            echo "<option value='{$k['kolor']}' $wybrane>{$k['kolor']}</option>";
        }
        ?>
    </select>
    <input type="submit" value="Filtruj">
</form>
<br>

<?php
// Tworzymy zapytanie w zależności od tego, czy wybrano kolor
if (isset($_GET['kolor']) && $_GET['kolor'] != "") {
    $wybrany_kolor = $_GET['kolor'];
    $sql_aut = "SELECT * FROM samochody WHERE kolor = '$wybrany_kolor'";
} else {
    $sql_aut = "SELECT * FROM samochody";
}

$wynik_aut = mysqli_query($polaczenie, $sql_aut);

// Wyświetlamy tabelę z samochodami
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Marka</th><th>Model</th><th>Kolor</th></tr>";

while ($auto = mysqli_fetch_assoc($wynik_aut)) {
    echo "<tr>";
    echo "<td>" . $auto['id'] . "</td>";
    echo "<td>" . $auto['marka'] . "</td>";
    echo "<td>" . $auto['model'] . "</td>";
    echo "<td>" . $auto['kolor'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
```

### Krok 5: Panel administratora (Dodawanie i usuwanie aut)

Administrator musi widzieć to samo co zwykły użytkownik, a dodatkowo mieć możliwość dopisania nowego samochodu oraz usunięcia istniejącego.

Rozszerzmy nasz kod o uprawnienia administratora:

### PHP

```php id="m3x7qv"
<?php
// Sprawdzamy czy rola to admin
if (isset($_SESSION['rola']) && $_SESSION['rola'] == 'admin') {
    echo "<h3>Panel Administratora - zarządzanie autami</h3>";

    // 1. OBSŁUGA USUWANIA AUTA
    if (isset($_GET['usun_id'])) {
        $id_do_usuniecia = intval($_GET['usun_id']);
        mysqli_query($polaczenie, "DELETE FROM samochody WHERE id = $id_do_usuniecia");
        echo "<p style='color: green;'>Samochód został usunięty!</p>";
    }

    // 2. OBSŁUGA DODAWANIA NOWEGO AUTA
    if (isset($_POST['dodaj_auto'])) {
        $marka = $_POST['marka'];
        $model = $_POST['model'];
        $kolor = $_POST['kolor'];

        $sql_dodaj = "INSERT INTO samochody (marka, model, kolor) VALUES ('$marka', '$model', '$kolor')";
        mysqli_query($polaczenie, $sql_dodaj);
        echo "<p style='color: green;'>Dodano nowy samochód!</p>";
    }

    // Formularz dodawania auta
    echo '
    <form method="POST" action="">
        <h4>Dodaj nowe auto:</h4>
        Marka: <input type="text" name="marka" required><br>
        Model: <input type="text" name="model" required><br>
        Kolor: <input type="text" name="kolor" required><br>
        <input type="submit" name="dodaj_auto" value="Dodaj samochód">
    </form>
    <hr>
    ';
}
?>
```

#### Jak zmodyfikować tabelę samochodów, aby administrator widział kolumnę "Akcja" z linkiem do usuwania?

W pętli wyświetlającej samochody (z Kroku 4) dodaj warunek sprawdzający rolę:

### PHP

```php id="z4k1cp"
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Marka</th><th>Model</th><th>Kolor</th>";

// Jeśli zalogowany to admin, pokaż dodatkową kolumnę
if (isset($_SESSION['rola']) && $_SESSION['rola'] == 'admin') {
    echo "<th>Akcja</th>";
}
echo "</tr>";

while ($auto = mysqli_fetch_assoc($wynik_aut)) {
    echo "<tr>";
    echo "<td>" . $auto['id'] . "</td>";
    echo "<td>" . $auto['marka'] . "</td>";
    echo "<td>" . $auto['model'] . "</td>";
    echo "<td>" . $auto['kolor'] . "</td>";

    // Link do usuwania widoczny tylko dla administratora
    if (isset($_SESSION['rola']) && $_SESSION['rola'] == 'admin') {
        echo "<td><a href='?usun_id=" . $auto['id'] . "' onclick='return confirm(\"Na pewno usunąć?\")'>Usuń</a></td>";
    }

    echo "</tr>";
}
echo "</table>";
```

### 1. Baza danych i tabela `USER`

Wyobraź sobie bazę danych jak wielki elektroniczny segregator. Zanim cokolwiek wyświetlimy, musimy stworzyć miejsce na dane użytkowników.

- Tabela `USER` działa jak lista pracowników w firmie. Każdy ma swój unikalny numerek (`id`), login, hasło, oraz – co najważniejsze – **rolę** (np. `user` albo `admin`).
- To właśnie pole `rola` decyduje później o tym, czy dany użytkownik dostanie klucze do dodatkowych drzwi (panelu administratora), czy tylko do zwykłego podglądu.

### 2. Jak działają sesje i logowanie?

Standardowo strony w internecie mają pamięć złotej rybki – przechodzisz na inną podstronę i strona "zapomina", kim jesteś. **Sesja** (`session_start()`) rozwiązuje ten problem. To tak, jakbyś dostał specjalną opsikę VIP po zalogowaniu.

1. Użytkownik wpisuje login i hasło w formularzu.
2. PHP sprawdza w bazie danych (`SELECT`), czy ktoś taki w ogóle istnieje.
3. Jeśli dane się zgadzają, zapisujemy to w specjalnej "kieszeni" serwera: `$_SESSION['rola'] = 'admin'` lub `$_SESSION['imie_nazwisko'] = 'Jan Kowalski'`.
4. Dzięki temu na każdej innej podstronie serwer może zajrzeć do tej "kieszeni" i sprawdzić: _"O, to jest administrator, pokarzę mu przyciski do usuwania aut!"_.

### 3. Panel użytkownika i lista rozwijalna (Filtrowanie)

Zwykły użytkownik ma widzieć tabelę z samochodami, ale też móc filtrować je po kolorze.

- **Skąd wziąć kolory do listy rozwijalnej?** Zamiast wpisywać je ręcznie (bo przecież kolory mogą się zmieniać), pytamy bazę danych: _"Hej, pokaż mi wszystkie unikalne kolory aut"_. Służy do tego sprytne słowo **`DISTINCT`** w zapytaniu SQL (`SELECT DISTINCT kolor FROM samochody`). Dzięki temu, nawet jeśli w bazie jest 50 czerwonych aut, słowo "czerwony" pojawi się na liście rozwijalnej dokładnie raz.
- **Jak działa filtrowanie?** Kiedy użytkownik wybierze z listy np. "czerwony" i kliknie "Filtruj", przeglądarka przesyła ten wybór do skryptu. PHP modyfikuje wtedy zapytanie do bazy: zamiast pobierać wszystko (`SELECT * FROM samochody`), pyta tylko o te auta, których kolor to `czerwony` (`WHERE kolor = 'czerwony'`).

### 4. Panel administratora (Usuwanie i dodawanie)

Administrator ma pełną władzę, więc dostaje dodatkowe narzędzia:

- **Usuwanie auta:** Gdy w tabeli obok każdego samochodu generujemy link "Usuń", przypisujemy do niego unikalne ID tego auta (np. `?usun_id=5`). Kiedy admin kliknie ten link, skrypt odczytuje tę cyfrę za pomocą `$_GET['usun_id']` i wydaje bazie rozkaz: `DELETE FROM samochody WHERE id = 5`. Baza natychmiast wymazuje ten wiersz z tabeli.
- **Dodawanie auta:** To zwykły, mały formularz z polami (marka, model, kolor). Po wpisaniu danych i kliknięciu "Dodaj", skrypt PHP pakuje je do zmiennych i wysyła do bazy za pomocą polecenia `INSERT INTO samochody (...) VALUES (...)`. Nowe auto od razu ląduje w bazie i pojawia się na liście.
