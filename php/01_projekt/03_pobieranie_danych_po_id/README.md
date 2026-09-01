> **Krok 3 z 4** | [W Kroku 2](../02_pobieranie_listy_rekordow/README.md) wygenerowaliśmy linki postaci `aktor.php?id=X`. W tym module dowiemy się, jak za pomocą wbudowanych narzędzi PHP odczytać to, co ktoś kliknął, i wyciągnąć z bazy dokładnie ten jeden, konkretny profil.

---

# Kompletny przewodnik: Od kliknięcia w link do pobrania rekordu z bazy

Ta ściąga wytłumaczy Ci **od A do Z** całą logikę połączenia między dwoma plikami HTML/PHP, działanie adresu URL, zmiennej `$_GET` oraz komunikację z bazą danych.

---

## SEC-1: Co to jest URL, znak `?` i parametr w adresie?

**URL (Uniform Resource Locator):** To po prostu pełny adres strony internetowej, np. `https://mojastrona.pl/aktor.php`.

**Znak zapytania (`?`):** Działa jak „drzwi” do przekazywania informacji w linku. Wszystko, co znajduje się **przed** znakiem `?`, to ścieżka do pliku na serwerze (`aktor.php`). Wszystko, co znajduje się **po** znaku `?`, to dodatkowe dane przesyłane do tego pliku.

**Parametr URL:** To para `klucz=wartość`.

W linku `aktor.php?id=3`:

- `id` to **nazwa parametru** (klucz),
- `3` to **wartość parametru**.

Można przekazać kilka parametrów, łącząc je znakiem `&`, np.:

```text
aktor.php?id=3&kolor=czerwony
```

---

## SEC-2: Jak połączyć ze sobą dwa pliki? (O co chodzi z `a href`?)

Wyobraź sobie, że masz dwa pliki w swoim projekcie:

1. `index.php` — Lista wszystkich aktorów.
2. `aktor.php` — Profil jednego, wybranego aktora.

**Jak plik `index.php` mówi plikowi `aktor.php`, kogo ma wyświetlić?**

Właśnie za pomocą odnośnika `<a href="...">` z dołączonym parametrem po znaku `?`!

W pliku `index.php` generujesz taki kod HTML:

```html
<!-- Ktoś klika w ten link na stronie index.php -->
<a href="aktor.php?id=3">Zobacz profil Janusza Gajosa</a>
```

Gdy użytkownik kliknie ten link, przeglądarka przejdzie do pliku `aktor.php` i przekaże mu w adresie informację `id=3`.

---

## SEC-3: Metoda GET, tablica `$_GET` oraz `isset()`

### Czym różni się „pobieranie danych z serwera” od „metody GET”?

**Metoda GET** to po prostu sposób przesyłania instrukcji do serwera otwarcie, bezpośrednio w pasku adresu URL. Serwer odczytuje ten adres i wie, jakie konkretnie dane ma dla Ciebie przygotować.

### Co to jest tablica w PHP i co to jest tablica `$_GET`?

**Tablica (Array):** To „szufladkowa” zmienna, która mieści w sobie wiele wartości naraz. Przykład:

```php
$owoce = [
    "jabłko",
    "banan",
    "gruszka"
];
```

Możemy odwołać się do poszczególnych elementów:

```php
$owoce[0];
$owoce[1];
$owoce[2];
```

### Co to jest `$_GET`?

`$_GET` to specjalna, wbudowana w PHP **superglobalna tablica**. PHP tworzy ją automatycznie przy każdym wczytaniu strony i wkłada do niej wszystko, co znajdzie w adresie URL po znaku `?`.

Jeśli adres to:

```text
aktor.php?id=3
```

to PHP automatycznie tworzy w tle wpis:

```php
$_GET['id'] = 3;
```

Zapis:

```php
$id = $_GET['id'];
```

oznacza: **„Weź wartość przypisaną do `id` ze schowka URL i zapisz ją do mojej własnej zmiennej `$id`”.**

### Co robi `if (isset($_GET['id']))`?

Słowo `isset` oznacza **„is set”**, czyli „czy istnieje / czy jest ustawione”.

Gdyby ktoś wszedł na stronę wpisując sam adres `aktor.php` (bez `?id=3`), a Ty od razu spróbowałbyś odczytać `$_GET['id']`, PHP wyrzuci błąd:

```text
Undefined array key "id"
```

Dlatego zawsze najpierw pytamy: **„Czy w adresie URL w ogóle znajduje się parametr `id`?”**

Jeśli tak – wykonujemy kod. Jeśli nie – wyświetlamy komunikat **„Brak ID”**.

---

## SEC-4: Zapytanie do bazy SQL i linijka `$conn->query($query)`

### Zapytanie do bazy (SQL Query)

Zapytanie do bazy to rozkaz napisany w języku SQL, wysyłany do bazy MySQL.

Przykład:

```sql
SELECT imie, nazwisko FROM aktorzy WHERE id_aktora = 3;
```

**`SELECT`** – komenda „pobierz”.

**`imie, nazwisko`** – które konkretnie kolumny z tabeli nas interesują.

**`FROM aktorzy`** – z jakiej tabeli.

**`WHERE id_aktora = 3`** – filtr, czyli „tylko ten jeden wiersz, gdzie kolumna `id_aktora` ma wartość 3”.

### `$result = $conn->query($query);`

- `$conn` – otwarte wcześniej połączenie z bazą danych,
- `->query(...)` – funkcja wysyłająca zapytanie SQL do bazy,
- `$query` – zmienna zawierająca nasze zapytanie SQL,
- `$result` – surowa „paczka z wynikami”, którą baza odsyła z powrotem.

To jeszcze nie są tekstowe dane PHP!

---

## SEC-5: Zmienna `$row`, tablica asocjacyjna oraz `fetch_assoc()`

### Co to jest `fetch_assoc()`?

Ta funkcja bierze paczkę od bazy (`$result`), otwiera ją i wyciąga z niej **jeden wiersz (rekord)** danych, zamieniając go na wygodną dla PHP **tablicę asocjacyjną**.

### Co to jest tablica asocjacyjna i klucze kolumn?

W zwykłej tablicy elementy numeruje się od zera:

```php
$tablica[0];
$tablica[1];
```

W tablicy asocjacyjnej zamiast numerów używa się nazw (etykiet).

`fetch_assoc()` tworzy tablicę, w której kluczami są dokładne nazwy kolumn z Twojej bazy danych.

Wyobraź sobie zmienną `$row` po wywołaniu `fetch_assoc()`:

```php
$row = [
    'imie' => 'Janusz',
    'nazwisko' => 'Gajos',
    'plik_awatara' => 'gajos.jpg'
];
```

Dzięki temu, pisząc:

```php
$row['imie']
```

sięgasz dokładnie do wartości z kolumny `imie` z bazy danych.

---

## SEC-6: Dlaczego NIE używamy pętli `while`, a po co używa się jej gdzie indziej?

### Kiedy używamy `while`?

Gdy zapytanie pobiera **WIELE rekordów**, np. całą listę 50 aktorów.

Wtedy możemy użyć:

```php
while ($row = $result->fetch_assoc()) {
    // ...
}
```

Pętla wykonuje się tak długo, aż wyciągnie po kolei każdy wiersz z paczki. Gdy wiersze się skończą, `fetch_assoc()` zwraca `false` i pętla się zatrzymuje.

### Dlaczego TUTAJ nie używamy `while`?

Ponieważ szukamy po **unikalnym ID**:

```sql
WHERE id_aktora = $id
```

Z bazy może wrócić co najwyżej **jeden jedyny wiersz**. Nie potrzebujemy pętli do otwarcia jednej paczki. Wywołujemy:

```php
$row = $result->fetch_assoc();
```

dokładnie raz.

---

## SEC-7: Co sprawdza `if ($result->num_rows > 0)`?

`num_rows` to właściwość paczki z wynikami (`$result`), która mówi:

> „Ile wierszy z bazy spełniło warunki Twojego zapytania?”

Jeśli w bazie jest aktor o ID = 3, to:

```php
$result->num_rows
```

będzie wynosiło:

```text
1
```

Jeśli ktoś wpisze w URL:

```text
aktor.php?id=99999
```

(a takiego aktora nie ma), zapytanie SQL się uda, ale baza zwróci **0 wierszy**.

Wtedy:

```php
$result->num_rows
```

wyniesie:

```text
0
```

Warunek:

```php
if ($result->num_rows > 0)
```

zabezpiecza nas więc przed próbą wyciągnięcia danych (`fetch_assoc()`) z pustego wyniku.

---

## Cała logika w jednym miejscu

```text
index.php
   ↓
kliknięcie w link
   ↓
aktor.php?id=3
   ↓
$_GET['id'] = 3
   ↓
$id = $_GET['id']
   ↓
zapytanie SQL
   ↓
$conn->query($query)
   ↓
$result
   ↓
$result->num_rows
   ↓
$result->fetch_assoc()
   ↓
$row
   ↓
$row['imie'], $row['nazwisko'], itd.
```

### Najważniejsze rzeczy do zapamiętania

| Element             | Co robi?                                      |
| ------------------- | --------------------------------------------- |
| `?`                 | Rozpoczyna parametry w URL                    |
| `id=3`              | Przekazuje parametr `id` o wartości `3`       |
| `$_GET`             | Przechowuje dane przekazane w URL metodą GET  |
| `$_GET['id']`       | Pobiera wartość parametru `id`                |
| `isset()`           | Sprawdza, czy dana wartość istnieje           |
| `$conn`             | Połączenie z bazą danych                      |
| `$conn->query()`    | Wysyła zapytanie SQL do bazy                  |
| `$result`           | Zawiera wynik zapytania                       |
| `$result->num_rows` | Informuje, ile rekordów znaleziono            |
| `fetch_assoc()`     | Pobiera jeden rekord jako tablicę asocjacyjną |
| `$row`              | Przechowuje pobrany rekord                    |
| `$row['imie']`      | Pobiera wartość kolumny `imie`                |
| `while`             | Przydatne przy pobieraniu wielu rekordów      |

> **Ważne:** przy prawdziwym kodzie PHP nie należy bezpośrednio wstawiać wartości z `$_GET` do zapytania SQL. Należy używać **prepared statements**, aby zabezpieczyć kod przed SQL Injection.

### Co dalej?

Mamy już na ekranie podstawowe dane jednego, klikniętego aktora (np. imię i nazwisko). Ale prawdziwe aplikacje rzadko trzymają wszystko w jednej tabeli. Co jeśli chcemy pokazać jeszcze listę wszystkich filmów, w których ta osoba zagrała?

👉 **[Przejdź do Kroku 4: Relacje JOIN i zliczanie wyników](../04_zliczanie_rekordow_relacji/README.md)** _(upewnij się, że nazwa folderu w linku zgadza się z rzeczywistą)_
