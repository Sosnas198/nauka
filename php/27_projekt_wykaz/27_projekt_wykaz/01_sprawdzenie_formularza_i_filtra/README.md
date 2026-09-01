# Kompletny przewodnik: Sprawdzenie formularza i wyświetlenie wpisanego filtra wyszukiwania

Ta ściąga wytłumaczy Ci **od A do Z**, jak PHP sprawdza, czy użytkownik kliknął przycisk wyszukiwania, jak odczytuje wpisaną frazę oraz jak wyświetla ją z powrotem na stronie jako informację, czego dotyczy wyszukiwanie.

---

## SEC-1: Sprawdzenie, czy formularz wyszukiwania został wysłany (`isset($_POST['szukaj'])`)

```php
if (isset($_POST['szukaj'])) {
    // ... tu wchodzimy TYLKO, jeśli kliknięto przycisk "Szukaj"
}
```

### Jak to działa?

- W formularzu HTML przycisk wygląda tak: `<input type="submit" value="Szukaj" id="szukaj" name="szukaj">`. Kluczowy jest atrybut **`name="szukaj"`** — dzięki niemu, gdy użytkownik kliknie ten przycisk, w tablicy `$_POST` pojawi się klucz `'szukaj'`.
- **`isset(...)`** – wbudowana w PHP funkcja sprawdzająca, czy dana wartość istnieje (nie jest `null`). Zwraca `true` albo `false`.
- **`isset($_POST['szukaj'])`** – oznacza więc: *"czy przycisk 'Szukaj' został kliknięty?"*. Jeśli użytkownik dopiero wszedł na stronę i niczego nie wpisał ani nie kliknął, ten warunek jest fałszywy i cała reszta kodu (odczyt miasta, połączenie z bazą, wyszukiwanie) jest całkowicie pomijana — strona pokaże wtedy tylko sam formularz, bez wyników.

---

## SEC-2: Odczytanie wpisanej frazy z formularza (`$_POST['miasto']`)

```php
$miasto = $_POST['miasto'];
```

### Jak to działa?

- **`$_POST['miasto']`** – pobiera wartość pola `<input type="text" name="miasto" id="miasto">`, czyli dokładnie to, co użytkownik wpisał w polu tekstowym (np. `"Wro"`, jeśli szuka miast zaczynających się na "Wro").
- Zapisujemy tę wartość do zmiennej `$miasto`, żeby móc się nią dalej posłużyć — zarówno do wyświetlenia (SEC-3), jak i (w kolejnym module) do zbudowania zapytania SQL.

---

## SEC-3: Wyświetlenie wpisanego filtra na stronie (`echo "<p>$miasto</p>"`)

```php
echo "<p>$miasto</p>";
```

### Jak to działa?

- **`echo`** – polecenie PHP wypisujące podany tekst na stronę, dokładnie w tym miejscu kodu, w którym się znajduje (czyli tutaj: wewnątrz `<div id="prawy">`, pod nagłówkiem "Wyniki wyszukiwania miast...").
- **`"<p>$miasto</p>"`** – budujemy fragment kodu HTML: akapit `<p>`, wewnątrz którego PHP automatycznie podmienia `$miasto` na jego aktualną wartość (to mechanizm zwany *interpolacją zmiennych w stringu* — działa wewnątrz cudzysłowów podwójnych `" "`). Jeśli użytkownik wpisał `"Wro"`, na stronie pojawi się dosłownie `<p>Wro</p>`.
- Dzięki temu użytkownik od razu widzi na stronie, **jaką frazę właśnie wyszukuje** — to swego rodzaju potwierdzenie/przypomnienie zastosowanego filtra, zanim jeszcze zobaczy właściwe wyniki wyszukiwania (które pojawią się w kolejnych modułach).

---

# Podsumowanie przepływu danych

```text
SEC-1: if (isset($_POST['szukaj']))
       — Sprawdzenie, czy kliknięto przycisk "Szukaj"
                 ↓
SEC-2: $miasto = $_POST['miasto'];
       — Odczytanie wpisanej frazy z pola tekstowego formularza
                 ↓
SEC-3: echo "<p>$miasto</p>";
       — Wyświetlenie wpisanej frazy jako informacji o zastosowanym filtrze
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**              | **Co oznacza / Co robi?**                                                       |
| ------------------------------------- | ------------------------------------------------------------------------------------ |
| **`isset($_POST['nazwa_przycisku'])`** | Sprawdza, czy formularz z danym, nazwanym przyciskiem został wysłany.                |
| **`$_POST['nazwa_pola']`**            | Pobiera wartość konkretnego pola formularza wpisaną przez użytkownika.               |
| **interpolacja zmiennych w stringu**  | Automatyczna podmiana `$zmienna` na jej wartość wewnątrz cudzysłowów podwójnych `" "`.|
| **`echo`**                            | Wypisuje podany tekst (tu: fragment HTML z wartością zmiennej) na stronę.            |
