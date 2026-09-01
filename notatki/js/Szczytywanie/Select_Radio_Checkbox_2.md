# Bardzo szczegółowe omówienie kodu kalkulatora kosztu wesela

Aplikacja służy do dynamicznego wyliczania kosztu organizacji wesela na podstawie liczby gości, obecności poprawin oraz wyboru koloru, w jakim ma zostać wyświetlony wynik.

---

## 1. Pełny kod aplikacji (HTML + JavaScript)

**HTML**

```html
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Kalkulator kosztu wesela</title>
  </head>
  <body>
    <!-- KROK 1: Tworzenie struktury formularza -->
    <form id="formularz-weselny">
      Ilość gości:
      <input type="number" id="ilosc_gosci" value="0" /><br /><br />

      Kolor wyniku:
      <select id="kolor_wyniku">
        <option value="black">Czarny</option>
        <option value="red">Czerwony</option>
        <option value="green">Zielony</option>
        <option value="blue">Niebieski</option></select
      ><br /><br />

      Poprawiny: <input type="checkbox" id="poprawiny" /><br /><br />
    </form>

    <!-- Miejsce do wyświetlania wyniku -->
    <p id="wynik">Koszt wesela: 0 zł</p>

    <!-- KROK 2: Logika aplikacji w języku JavaScript -->
    <script>
      // 1. Tworzenie stałych uchwytów do elementów z drzewa DOM
      const inpGosci = document.getElementById("ilosc_gosci");
      const selectKolor = document.getElementById("kolor_wyniku");
      const chkPoprawiny = document.getElementById("poprawiny");
      const elWynik = document.getElementById("wynik");

      // 2. Główna funkcja wykonująca obliczenia
      function oblicz() {
        // Pobranie wpisanej liczby gości i konwersja ze tekstu na liczbę
        let goscie = Number(inpGosci.value);

        // Wyliczenie kwoty bazowej (100 zł za osobę)
        let koszt = goscie * 100;

        // Sprawdzenie, czy pole checkbox jest zaznaczone
        if (chkPoprawiny.checked) {
          koszt = koszt * 1.3; // Zwiększenie kosztu o 30% za poprawiny
        }

        // Pobranie wybranego koloru z atrybutu value listy rozwijalnej
        let wybranyKolor = selectKolor.value;

        // Wstrzyknięcie tekstu do paragrafu i zmiana jego koloru w CSS
        elWynik.innerHTML = `Koszt wesela: ${koszt} zł`;
        elWynik.style.color = wybranyKolor;
      }

      // 3. Podpięcie nasłuchiwania zdarzeń (Events)
      inpGosci.addEventListener("input", oblicz);
      selectKolor.addEventListener("input", oblicz);
      chkPoprawiny.addEventListener("input", oblicz);
    </script>
  </body>
</html>
```

---

## 2. Bardzo szczegółowa analiza kodu HTML (Linia po linii)

### Formularz i pola wprowadzania danych

- **`<form id="formularz-weselny">`** – znacznik grupujący elementy formularza. Identyfikator `id` pozwala odwoływać się do niego w kodzie.

- **`<input type="number" id="ilosc_gosci" value="0">`**:
  - `type="number"` – wymusza wprowadzanie wartości cyfrowych. Blokuje możliwość wpisania liter oraz dodaje wygodne strzałki góra/dół do zmiany wartości.
  - `id="ilosc_gosci"` – unikalny identyfikator, po którym JavaScript odnajdzie to pole w pamięci komputera.
  - `value="0"` – początkowa, domyślna wartość w polu wynosząca `0`.

- **`<select id="kolor_wyniku">`** – tworzy rozwijaną listę wyboru.
  - **`<option value="black">Czarny</option>`**:
    - Treść widoczna dla człowieka: `"Czarny"` (wyświetla się na ekranie).
    - Treść widoczna dla komputera: `value="black"` (to tę wartość odczyta JavaScript). Dzięki temu rozdzielamy warstwę językową (dla użytkownika) od technicznej (poprawna nazwa koloru w CSS).

- **`<input type="checkbox" id="poprawiny">`** – przełącznik wielokrotnego wyboru. Nie posiada domyślnie atrybutu `checked`, więc przy załadowaniu strony jest odznaczony (`false`).

- **`<p id="wynik">Koszt wesela: 0 zł</p>`** – element prezentacyjny (paragraf), w którym po uruchomieniu skryptu będzie dynamicznie nadpisywana treść oraz zmiana koloru czcionki.

---

## 3. Szczegółowa analiza skryptu JavaScript (Działanie i mechanizmy)

### Część I: Przechwytywanie elementów DOM (Uchwyty)

**JavaScript**

```javascript
const inpGosci = document.getElementById("ilosc_gosci");
const selectKolor = document.getElementById("kolor_wyniku");
const chkPoprawiny = document.getElementById("poprawiny");
const elWynik = document.getElementById("wynik");
```

- **Jak to działa w RAM?** Przeglądarka tworzy z dokumentu HTML obiektowe drzewo DOM. Metoda `document.getElementById()` przeszukuje to drzewo w pamięci RAM i zwraca bezpośredni odnośnik do danego obiektu.

- **Słowo kluczowe** **`const`**: Używamy stałych (`const`), ponieważ połączenie (uchwyt) z elementem HTML nie zmieni się w trakcie działania programu (pole na stronie cały czas istnieje w tym samym miejscu).

---

### Część II: Wnętrze funkcji obliczeniowej `oblicz()`

**JavaScript**

```javascript
let goscie = Number(inpGosci.value);
```

1. **`inpGosci.value`** – sczytuje to, co użytkownik wpisał w polu gości. **Ważne:** Przeglądarka domyślnie zwraca każdą wartość z pole `<input>` jako **ciąg znaków / tekst (String)**, np. `"15"`.
2. **`Number(...)`** – funkcja rzutująca (konwertująca) tekst `"15"` na prawdziwą liczbę matematyczną `15`. Gdybyśmy tego nie zrobili, późniejsze mnożenie mogłoby prowadzić do błędów typów.

**JavaScript**

```javascript
let koszt = goscie * 100;
```

Wyliczamy kwotę podstawową. Zgodnie z treścią zadania koszt za jedną osobę wynosi $100\text{ zł}$. Wynik zapisujemy do zmiennej `koszt` zadeklarowanej za pomocą `let`, ponieważ jej wartość może ulec zmianie w kolejnych krokach.

**JavaScript**

```javascript
if (chkPoprawiny.checked) {
  koszt = koszt * 1.3;
}
```

1. **Właściwość** **`.checked`** – dla elementów typu `checkbox` właściwość ta przybiera wartość logiczną:
   - `true` – jeśli pole jest zaznaczone (ptaszek jest obecny).
   - `false` – jeśli pole jest puste.

2. **Warunek** **`if (...)`** – wykonuje kod wewnątrz klamry `{}` tylko wtedy, gdy wyrażenie w nawiasie ma wartość `true` (czyli gdy pole jest zaznaczone).

3. **Matematyka podwyżki o $30%$**:
   - Kwota bazowa to $100%$, czyli $1.0$.
   - Dodanie $30%$ poprawin daje razem $130%$, czyli $1.30$.
   - Zamiast pisać dłuższą formułę `koszt = koszt + (koszt * 0.3)`, wystarczy pomnożyć sumę bazową przez `1.30`.

**JavaScript**

```javascript
let wybranyKolor = selectKolor.value;
```

1. Właściwość `.value` wyciąga z elementu `<select>` wartość z atrybutu `value` obecnie zaznaczonej opcji `<option>`.
2. Jeśli użytkownik wybrał z listy pozycję „Czerwony”, `selectKolor.value` zwróci wartość `"red"`.

**JavaScript**

```javascript
elWynik.innerHTML = `Koszt wesela: ${koszt} zł`;
elWynik.style.color = wybranyKolor;
```

1. **`elWynik.innerHTML = ...`**:
   - Podmienia całe wnętrze paragrafu `<p id="wynik">`.
   - Zastosowano tzw. _Template Literals_ (zapis w odwróconych apostrofach ` `` `). Pozwala on na łatwe wstrzykiwanie zmiennych za pomocą składni `${nazwa_zmiennej}`.

2. **`elWynik.style.color = wybranyKolor`**:
   - Odwołanie do właściwości `.style` pozwala modyfikować style CSS danego elementu wprost z poziomu JavaScriptu.
   - `color` odpowiada za kolor czcionki. Przeglądarka zamienia ten zapis na żywo na kod CSS: `color: red;` (lub inny wybrany kolor).

---

### Część III: Reakcja na zdarzenia (Automatyzacja bez przycisku)

**JavaScript**

```javascript
inpGosci.addEventListener("input", oblicz);
selectKolor.addEventListener("input", oblicz);
chkPoprawiny.addEventListener("input", oblicz);
```

1. **Metoda** **`.addEventListener(typZdarzenia, funkcja)`** – ustawia "nasłuchiwanie" określonej akcji użytkownika na danym elemencie.

2. **Dlaczego zdarzenie** **`'input'`\*\***?\*\*
   - Zdarzenie `'input'` odpala się **natychmiast** po jakiejkolwiek modyfikacji wartości pola – przy wpisaniu cyfry z klawiatury, kliknięciu strzałki zmiany liczby, kliknięciu w checkbox czy wybraniu innej opcji z listy rozwijalnej.

3. **Brak nawiasów** **`()`** **przy nazwie funkcji**:
   - Zauważ, że piszemy `oblicz`, a nie `oblicz()`.
   - Przekazujemy **nazwę funkcji jako przepis**, który przeglądarka ma uruchomić dopiero w momencie wykrycia zdarzenia. Gdybyśmy wpisali `oblicz()`, funkcja wykonałaby się tylko raz podczas ładowania strony, a potem przestałaby działać.
