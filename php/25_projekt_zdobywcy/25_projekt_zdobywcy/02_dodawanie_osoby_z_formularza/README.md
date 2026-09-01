# Kompletny przewodnik: Odbieranie danych z formularza i zapisywanie ich do bazy (INSERT)

Ta ściąga wytłumaczy Ci **od A do Z**, jak PHP sprawdza, czy formularz został wysłany, jak odbiera z niego dane oraz jak zapisuje je do bazy danych za pomocą zapytania `INSERT`.

---

## SEC-1: Sprawdzenie, czy formularz został wysłany (`$_SERVER["REQUEST_METHOD"]`)

Ten sam plik PHP wyświetla się użytkownikowi zarówno wtedy, gdy dopiero **wchodzi** on na stronę (i widzi pusty formularz), jak i wtedy, gdy **kliknął już przycisk "Dodaj"**. Musimy więc jakoś rozróżnić te dwie sytuacje, żeby nie próbować zapisywać do bazy pustych/nieistniejących danych za każdym razem, gdy ktoś wejdzie na stronę.

```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... tu wchodzimy TYLKO, jeśli formularz został wysłany metodą POST
}
```

### Jak to działa?

- **`$_SERVER`** – to specjalna, wbudowana w PHP "tablica" (zbiór informacji), która zawiera mnóstwo danych technicznych o bieżącym żądaniu strony (np. jaką metodą przeglądarka wysłała żądanie, jaki jest adres strony, itd.). Nie musimy jej sami tworzyć — PHP wypełnia ją automatycznie.
- **`$_SERVER["REQUEST_METHOD"]`** – konkretna wartość z tej tablicy, mówiąca, w jaki sposób przeglądarka poprosiła o tę stronę. Zwykle jest to `"GET"` (zwykłe wejście na stronę, np. wpisanie adresu w przeglądarce) albo `"POST"` (wysłanie danych z formularza, jeśli formularz ma `method="post"`).
- **`== "POST"`** – porównujemy wartość z tablicy do tekstu `"POST"`. Jeśli się zgadzają, to znaczy, że użytkownik faktycznie kliknął przycisk formularza (a nie po prostu wszedł na stronę).
- **Cały blok `if { ... }`** – kod w środku wykona się **tylko wtedy**, gdy formularz został wysłany. Jeśli ktoś dopiero wchodzi na stronę (metoda `GET`), ten fragment kodu jest całkowicie pomijany.

> **Skąd bierze się `"POST"`?** Z atrybutu `method="post"` w znaczniku `<form>` w pliku HTML. To on decyduje, jaką metodą przeglądarka wyśle dane po kliknięciu przycisku.

---

## SEC-2: Odczytanie poszczególnych pól z formularza (`$_POST[...]`)

Skoro już wiemy, że formularz został wysłany, musimy odczytać, **co konkretnie** wpisał w nim użytkownik.

```php
$nazwisko = $_POST['nazwisko'];
$imie = $_POST['imie'];
$funkcja = $_POST['funkcja'];
$email = $_POST['email'];
```

### Jak to działa?

- **`$_POST`** – to kolejna specjalna tablica wbudowana w PHP. W przeciwieństwie do `$_SERVER`, ona jest wypełniana danymi **wpisanymi przez użytkownika w formularzu**, ale tylko wtedy, gdy formularz wysłano metodą `POST`.
- **`$_POST['nazwisko']`** – wewnątrz nawiasów kwadratowych podajemy tzw. "klucz", czyli nazwę pola z formularza. Ta nazwa **musi dokładnie odpowiadać** atrybutowi `name="nazwisko"` z pola `<input>` w pliku HTML. Gdyby w HTML pole nazywało się inaczej (np. `name="surname"`), musielibyśmy tu napisać `$_POST['surname']`.
- Analogicznie: `$_POST['imie']` odpowiada polu `<input name="imie">`, `$_POST['funkcja']` odpowiada rozwijanej liście `<select name="funkcja">`, a `$_POST['email']` polu `<input name="email">`.
- Każdą z tych wartości zapisujemy do osobnej, "wygodniejszej" zmiennej (`$nazwisko`, `$imie`, `$funkcja`, `$email`), żeby łatwiej się nimi dalej posługiwać w kodzie.

---

## SEC-3: Zbudowanie i wysłanie zapytania `INSERT` do bazy danych

Mając już dane od użytkownika w zmiennych, możemy je zapisać na stałe do bazy danych za pomocą zapytania SQL typu `INSERT` (czyli "wstaw nowy wiersz").

```php
$sql = "INSERT INTO osoby VALUES (NULL, '$nazwisko', '$imie', '$funkcja', '$email');";
$result = $conn->query(query: $sql);
```

### Jak to działa? Rozbijmy zapytanie SQL na części

- **`$sql`** – zmienna tekstowa, w której budujemy treść zapytania SQL jako zwykły ciąg znaków (string).
- **`INSERT INTO osoby`** – polecenie SQL oznaczające "wstaw nowy wiersz do tabeli o nazwie `osoby`".
- **`VALUES (NULL, '$nazwisko', '$imie', '$funkcja', '$email')`** – lista wartości do wstawienia, w kolejności zgodnej z kolumnami tabeli w bazie danych:
  - **`NULL`** – pierwsza kolumna to zwykle automatycznie numerowane `id` (klucz główny). Wpisując `NULL`, mówimy bazie danych "sam sobie wygeneruj kolejny wolny numer" — nie musimy się o to martwić.
  - **`'$nazwisko'`, `'$imie'`, `'$funkcja'`, `'$email'`** – tutaj PHP automatycznie "wklei" aktualną zawartość tych zmiennych prosto do tekstu zapytania (to się nazywa *interpolacja zmiennych w stringu* — działa tylko wewnątrz cudzysłowów podwójnych `" "`). Muszą być otoczone apostrofami `' '`, ponieważ w SQL wartości tekstowe zawsze zapisuje się w apostrofach.
- **`$conn->query(query: $sql)`** – tutaj korzystamy z gotowego połączenia `$conn` (utworzonego w module `01_polaczenie_z_baza`) i wywołujemy na nim metodę `query()`, podając jako argument nasze zapytanie SQL. To właśnie ta linijka **faktycznie wysyła** zapytanie do serwera bazy danych i wykonuje je.
- **`$result`** – zmienna, do której trafia wynik wykonania zapytania. W przypadku `INSERT` zwykle nie potrzebujemy dalej z niej korzystać (w przeciwieństwie do zapytań `SELECT`, gdzie `$result` zawiera pobrane wiersze — zobacz moduł `03_wyswietlanie_listy_osob`).

> **Uwaga dla ciekawskich (bezpieczeństwo):** Wklejanie danych od użytkownika bezpośrednio do tekstu zapytania SQL (tak jak tutaj) w prawdziwych, produkcyjnych aplikacjach jest ryzykowne (tzw. atak SQL Injection). W profesjonalnych projektach stosuje się tzw. *zapytania przygotowane* (prepared statements). W tym projekcie edukacyjnym trzymamy się jednak dokładnie takiego zapisu, jaki został podany w rozwiązaniu zadania.

---

# Podsumowanie przepływu danych

```text
SEC-1: if ($_SERVER["REQUEST_METHOD"] == "POST")
       — Sprawdzenie, czy formularz został wysłany
                 ↓
SEC-2: $nazwisko = $_POST['nazwisko']; itd.
       — Odczytanie poszczególnych pól z formularza
                 ↓
SEC-3: $sql = "INSERT INTO osoby VALUES (...)"
       $conn->query($sql)
       — Zbudowanie i wysłanie zapytania INSERT do bazy danych
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**            | **Co oznacza / Co robi?**                                                                        |
| ---------------------------------- | -------------------------------------------------------------------------------------------------- |
| **`$_SERVER["REQUEST_METHOD"]`**  | Informuje, jaką metodą (`GET`/`POST`) wysłano żądanie strony.                                     |
| **`$_POST['nazwa_pola']`**        | Pobiera wartość konkretnego pola formularza (nazwa musi zgadzać się z atrybutem `name` w HTML).   |
| **`INSERT INTO ... VALUES (...)`** | Polecenie SQL wstawiające nowy wiersz do tabeli w bazie danych.                                    |
| **`NULL` przy id**                 | Mówi bazie danych, żeby sama nadała kolejny, wolny numer id.                                       |
| **`$conn->query($sql)`**           | Wysyła i wykonuje zapytanie SQL na aktywnym połączeniu z bazą danych.                              |
