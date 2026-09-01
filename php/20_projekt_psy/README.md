# Projekt PHP + MySQLi: Rejestracja użytkownika (baza `psy`)

**Słowa kluczowe:** `isset()` vs `empty()`, flaga logiczna (zmienna true/false), sprawdzanie unikalności loginu w pętli, `sha1()` (hashowanie hasła), `INSERT ... VALUES (NULL, ...)` z auto-increment.

Projekt uczy pełnego, wieloetapowego formularza rejestracji: sprawdzenia,
czy formularz wysłano i czy pola nie są puste, sprawdzenia zajętości
loginu przez pętlę po wszystkich istniejących loginach, porównania dwóch
haseł, a na końcu zaszyfrowania hasła i zapisania konta. Całość w jednym
pliku: `logowanie.php`.

> To jedyny projekt bez podziału na numerowane moduły — cała logika
> mieści się w jednym skrypcie, więc ten plik jest jednocześnie
> ściągawką i pełnym wytłumaczeniem (bez osobnych podfolderów `01_`, `02_`).

## Główny szkielet logiki

```text
isset (formularz wysłany?)
  → empty (pola niepuste?)
    → sprawdzenie loginu w bazie (pętla + flaga)
      → porównanie haseł
        → sha1() + INSERT
    → $conn->close()
```

---

## Ściągawka wzorców

### 1. `isset()` vs `empty()` — dwa różne pytania

```php
if (isset($_POST["login"]) && isset($_POST["haslo"]) && isset($_POST["haslo2"])) {
    if (!empty($_POST["login"]) && !empty($_POST["haslo"]) && !empty($_POST["haslo2"])) {
        $login = $_POST["login"];
        $haslo = $_POST["haslo"];
        $haslo2 = $_POST["haslo2"];
    } else {
        echo "<p>wypełnij wszystkie pola</p>";
    }
}
```

`isset()` pyta "czy pole w ogóle zostało wysłane" (chroni przed błędem
przy pierwszym wejściu na stronę, zanim ktokolwiek cokolwiek wpisał).
`empty()` pyta "czy w tym polu coś realnie jest" (łapie sytuację, gdy
formularz wysłano, ale zostawiono pole puste). Potrzebne jest jedno i
drugie — `isset()` jako pierwsza bramka, `empty()` jako druga.

### 2. Sprawdzenie zajętości loginu (pętla + flaga)

```php
$istniejelogin = false;
$result = $conn->query("SELECT login FROM uzytkownicy");

while ($row = $result->fetch_array()) {
    if ($login == $row[0]) {
        echo "<p>login występuje w bazie danych, konto nie zostało dodane</p>";
        $istniejelogin = true;
    }
}
```

Zamiast zapytania z `WHERE login = ...`, kod pobiera **wszystkie**
loginy i porównuje każdy po kolei w pętli PHP. `$istniejelogin` to flaga
(zmienna true/false) — startuje jako `false`, a pętla zmienia ją na
`true`, jeśli znajdzie dopasowanie. Reszta kodu (SEC-4, SEC-5) sprawdza
tę flagę, żeby wiedzieć, czy wolno iść dalej.

### 3. Porównanie haseł i zapis (hash + INSERT)

```php
if ($istniejelogin == false) {
    if ($haslo == $haslo2) {
        $hash = sha1($haslo);
        $conn->query("INSERT INTO uzytkownicy VALUES (NULL, '$login', '$hash')");
        echo "<p>Konto zostało dodane</p>";
    } else {
        echo "<p>hasła nie są takie same, konto nie zostało dodane</p>";
    }
}

$conn->close();
```

`sha1($haslo)` zamienia hasło na 40-znakowy ciąg — nieodwracalnie, więc
do bazy nigdy nie trafia hasło w czystej postaci. `NULL` jako pierwsza
wartość w `INSERT` mówi bazie, żeby sama wygenerowała kolejne `id`
(auto-increment). `$conn->close()` wykonuje się zawsze, niezależnie od
tego, którą ścieżką poszedł kod wcześniej — stoi poza wszystkimi `if`.

---

## Tabela referencyjna

| Funkcja / pojęcie                    | Do czego służy                                    |
| ------------------------------------ | ------------------------------------------------- |
| `isset($_POST[...])`                 | Sprawdza, czy formularz w ogóle wysłano           |
| `empty($_POST[...])`                 | Sprawdza, czy pole jest puste                     |
| flaga (`$istniejelogin`)             | Zapamiętuje wynik sprawdzenia na później w kodzie |
| `sha1($haslo)`                       | Jednokierunkowe zaszyfrowanie hasła przed zapisem |
| `INSERT INTO ... VALUES (NULL, ...)` | Dodanie rekordu z auto-increment na `id`          |
