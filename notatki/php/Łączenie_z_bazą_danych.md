# Łączenie z bazą danych MySQL i pobieranie danych w PHP – Poradnik dla początkujących

Prezentowany na obrazku skrypt PHP służy do nawiązania połączenia z bazą danych, pobrania z niej informacji oraz wyświetlenia ich na stronie internetowej.

## 1. Konfiguracja danych dostępowych do bazy

Na samym początku skryptu definiujemy cztery zmienne niezbędne do zalogowania się na serwer bazy danych:

- `$servername = "localhost";` – adres serwera bazy danych (w tym przypadku oznacza to komputer lokalny).
- `$username = "root";` – nazwa użytkownika bazy danych (domyślny login na serwerach lokalnych to najczęściej `root`).
- `$password = "";` – hasło użytkownika (w konfiguracjach testowych/lokalnych pole to jest zazwyczaj puste).
- `$data_base = "baza";` – nazwa konkretnej bazy danych, z którą chcemy się połączyć.

## 2. Tworzenie połączenia i ustawienie kodowania

PHP

```php id="x5d9qk"
$conn = new mysqli($servername, $username, $password, $data_base);
$conn->query('set charset UTF8');

```

- `$conn = new mysqli(...)` – funkcja ta tworzy nowe połączenie z bazą danych, a cały obiekt połączenia zapisujemy w zmiennej `$conn`.
- `$conn->query('set charset UTF8');` – dba o to, aby polskie znaki były poprawnie odczytywane i zapisywane (alternatywnie można zapisać to jako `$conn->set_charset('UTF8');`).

## 3. Wysłanie zapytania SQL

PHP

```php id="2ndq8c"
$query = "select * from tabela";
$result = $conn->query($query);

```

- `$query = "select * from tabela";` – tworzy zmienną tekstową zawierającą zapytanie SQL (w tym przypadku polecenie `SELECT * FROM tabela` oznacza „pobierz wszystkie kolumny i wszystkie wiersze z tabeli o nazwie `tabela`”).
- `$result = $conn->query($query);` – wysyła przygotowane zapytanie do bazy danych, a odpowiedź (wynik działania) zapisuje w zmiennej `$result`.

## 4. Sprawdzanie i wyświetlanie wyników

PHP

```php id="p0k2vz"
if ($result->num_rows == 0) {
    echo "brak danych w bazie";
} else {
    while ($tablica = $result->fetch_assoc()) {
        echo $tablica['nazwa_pola_z_tabeli'];
    }
}

```

- **Sprawdzenie liczby wierszy (\*\***`if`\***\*):** Właściwość `$result->num_rows` sprawdza, czy baza zwróciła jakiekolwiek rekordy. Jeśli jej wartość wynosi `0` (co oznacza pustą tabelę lub brak pasujących wyników), skrypt wyświetli komunikat `"brak danych w bazie"`.
- **Pobieranie danych pętlą (\*\***`while`\***\*):** Jeśli w bazie są jakieś dane, uruchamia się blok `else`. Pętla `while` kręci się tak długo, dopóki funkcja `$result->fetch_assoc()` pobiera kolejne wiersze z bazy danych i zamienia je na tablicę asocjacyjną (gdzie kluczami są nazwy kolumn z tabeli).
- **Wyświetlanie:** Instrukcja `echo $tablica['nazwa_pola_z_tabeli'];` wyciąga z aktualnie pobranego wiersza wartość konkretnego pola (kolumny) o podanej nazwie i wypisuje ją na ekranie.

## 5. Zamknięcie połączenia

PHP

```php id="q8f4wy"
$conn->close();

```

- `$conn->close();` – zamyka aktywne połączenie z bazą danych, uwalniając zasoby serwera po zakończeniu działania całego skryptu.
