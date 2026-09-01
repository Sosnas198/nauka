## 1. Czym w ogóle jest formularz?

Wyobraź sobie zwykłą ankietę albo okienko logowania. Użytkownik wpisuje coś w pole tekstowe i kliknie przycisk „Wyślij”. W tym momencie przeglądarka pakuje te dane i wysyła je na serwer, gdzie skrypt PHP może je odebrać, przeczytać i zrobić z nimi coś pożytecznego (np. zapisać do bazy danych).

Prosty formularz w HTML wygląda tak:

HTML

```html
<form method="post">
    <input type="text" name="Imie">
    <input type="submit" value="Wyślij">
</form>

```

## 2. Co to jest atrybut `method`? (`GET` kontra `POST`)

Atrybut `method` w formularzu decyduje o tym, **w jaki sposób** dane powędrują do serwera. Masz do wyboru dwie główne metody: `GET` oraz `POST`.

### Metoda `GET` – wszystko widać na wierzchu

* Kiedy używasz metody `GET`, wpisane przez użytkownika dane pojawiają się... **bezpośrednio w pasku adresu przeglądarki (URL)**.
* Wygląda to mniej więcej tak: `[http://127.0.0.1:4001/plik.php?Imie=Jan&Nazwisko=Kowalski](http://127.0.0.1:4001/plik.php?Imie=Jan&Nazwisko=Kowalski)`.
* **Zalety:** Możesz zapisać taki adres w zakładkach, łatwo go skopiować i komuś wysłać, a przeglądarka zapamiętuje go w historii.
* **Kiedy stosować:** Do prostych, bezpiecznych zapytań (np. wyszukiwarka na stronie).

### Metoda `POST` – tajemnica handlowa

* Kiedy używasz metody `POST`, dane podróżują „pod maską” – użytkownik nie widzi ich w adresie URL.
* **Kiedy stosować:** Do rzeczy poufnych i ważnych – np. przy **logowaniu (hasła)**, rejestracji, płatnościach czy wysyłaniu plików na serwer. Nie chcesz przecież, żeby czyjeś hasło świeciło w pasku adresu przeglądarki!

## 3. Jak PHP odbiera te dane? (Superglobalne tablice `$_GET` i `$_POST`)

PHP ma wbudowane specjalne „magiczne” tablice, w których automatycznie lądują przesłane dane. Są one widoczne wszędzie w kodzie (dlatego nazywa się je *superglobalnymi*).

* Jeśli formularz miał `method="get"`, dane znajdziesz w tablicy **`$_GET`**.
* Jeśli formularz miał `method="post"`, dane znajdziesz w tablicy **`$_POST`**.

Kluczem (indeksem) w tej tablicy jest nazwa pola z formularza (`name="..."`).

### Przykład dla metody `POST`:

**HTML + PHP w jednym pliku:**

HTML

```html
<form method="post">
    <input type="text" name="Imie">
    <input type="text" name="Nazwisko">
    <input type="submit" value="Wyślij">
</form>

<?php
if (isset($_POST['Imie']) && isset($_POST['Nazwisko'])) {
    $imie = $_POST['Imie'];
    $nazwisko = $_POST['Nazwisko'];
    
    echo "Cześć " . $imie . " " . $nazwisko . "!";
}
?>

```

## 4. Do czego służy atrybut `action`?

* Domyślnie, jeśli nie wpiszesz nic w `action`, formularz po kliknięciu „Wyślij” odświeża tę samą stronę i wysyła dane do tego samego pliku.
* Za pomocą atrybutu `action="skrypt.php"` możesz wskazać **inny plik**, który ma odebrać i przetworzyć te dane.

Przykład:

HTML

```html
<form method="post" action="przetworz.php">
    <input type="text" name="Imie">
    <input type="submit" value="Wyślij">
</form>

```

## 5. Podsumowanie: Kiedy co wybierać?

* **Zasada bezpieczeństwa:**

  * Akcje **bezpieczne** (np. przeglądanie katalogu, wyszukiwanie) -> możesz stosować **`GET`**.
  * Akcje **niebezpieczne / zmieniające stan** (np. kliknięcie „Kupuję i płacę”, zmiana hasła, wpisanie numeru karty kredytowej) -> zawsze **`POST`** (nikt nie chce, żeby poufne dane zostały w historii przeglądarki).
* **Ograniczenia:** Przeglądarki mają limit długości adresu URL (stare wersje Internet Explorera miały np. limit 2048 znaków). Jeśli przesyłasz ogromne ilości danych (albo wgrywasz pliki), metoda `POST` jest jedynym słusznym wyborem.
