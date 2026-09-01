# Pliki Cookie („ciasteczka”) w PHP – Poradnik dla początkujących

Pliki cookie (czyli popularne ciasteczka) to niewielkie pliki zapisywane na komputerze osoby odwiedzającej stronę internetową. Twórca strony używa ich po to, aby zapamiętać wybrane przez siebie parametry i informacje.

## 1. Jak ustawić ciasteczko? (`setcookie`)

Do tworzenia ciasteczek służy funkcja `setcookie`. Jej pełna składnia wygląda następująco:

PHP

```php id="x7q2km"
setcookie(nazwa, wartość, data_ważności, ścieżka, domena, bezpieczne, jedynie_http);

```

### Omówienie najważniejszych argumentów:

* **Nazwa ciasteczka**: jednoznaczne oznaczenie komórki w tablicy `$_COOKIE`, pod którym będzie przechowywana jego wartość.
* **Wartość ciasteczka**: dane, które chcesz zapisać (np. imię `"Janusz"`).
* **Data ważności**: określa, jak długo ciasteczko będzie aktywne na dysku. Liczymy ją za pomocą funkcji `time()` (czyli aktualnego czasu w sekundach, które upłynęły od 1 stycznia 1970 roku), dodając do niej określoną liczbę sekund.

  * *Przykład na 30 dni ważności:* `time() + 60 * 60 * 24 * 30` (60 sekund $\times$ 60 minut $\times$ 24 godziny $\times$ 30 dni).
* **Zasięg ciasteczka**: określa miejsce na stronie (ścieżkę), z którego będzie do niego dostęp.
* **Domena**: jeśli chcesz, aby ciasteczko działało na wszystkich subdomenach (np. `technikinformatyk.pl`), odpowiednio ją konfigurujesz.
* **Bezpieczne (secure)**: ustawienie na `TRUE` oznacza, że ciasteczko może być przesyłane wyłącznie przez bezpieczny protokół HTTPS (domyślnie jest to `FALSE`).
* **Jedynie_http (httponly)**: ustawienie na `TRUE` ogranicza transmisję ciasteczka tylko do protokołu HTTP.

Przykładowe wywołanie funkcji:

PHP

```php id="d4z8wp"
setcookie($nazwa_ciasteczka, $wartosc_ciasteczka, $waznosc_ciasteczka, $zasieg_ciasteczka);

```

## 2. Jak odczytać ciasteczko?

Aby sprawdzić, czy ciasteczko zostało ustawione oraz odczytać jego wartość, korzystamy z instrukcji warunkowej oraz tablicy `$_COOKIE`:

PHP

```php id="m9v3ka"
if (isset($_COOKIE[$nazwa_ciasteczka])) {
    echo "Ciasteczko o nazwie " . $nazwa_ciasteczka . " zostało ustawione <br>";
    echo "Wartość ciasteczka: " . $_COOKIE[$nazwa_ciasteczka];
} else {
    echo "Ciasteczko o nazwie " . $nazwa_ciasteczka . " nie zostało ustawione!";
}

```

## 3. Jak usunąć ciasteczko?

Żeby skasować istniejące ciasteczko, musisz wywołać funkcję `setcookie` dokładnie z takimi samymi parametrami, z jakimi było tworzone, ale **nadając mu datę ważności z przeszłości** (np. odejmując godziny lub sekundy od aktualnego czasu `time()`):

PHP

```php id="p6n1rt"
$nazwa_ciasteczka = "imie";
$wartosc_ciasteczka = "Janusz";
$waznosc_ciasteczka = time() - 3600; // czas z przeszłości (minus godzina)
$zasieg_ciasteczka = "/";

setcookie($nazwa_ciasteczka, $wartosc_ciasteczka, $waznosc_ciasteczka, $zasieg_ciasteczka);
```
