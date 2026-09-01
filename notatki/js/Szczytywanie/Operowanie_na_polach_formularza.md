# Kompleksowe omówienie aplikacji do nauki dodawania

Poniżej znajduje się pełny kod HTML z wbudowanym JavaScriptem oraz szczegółowe omówienie każdego fragmentu kodu – linia po linii.

## 1. Pełny kod źródłowy (HTML + JS)

**HTML**

```html
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Nauka dodawania dla dzieci</title>
  </head>
  <body>
    <div class="kontener">
      <p id="dodaj"></p>
      <label for="suma">Podaj wynik: </label>
      <input type="number" id="suma" />
      <button id="btn-sprawdz">Sprawdź</button>
      <p id="wynik"></p>
    </div>

    <script>
      // KROK 1: Uchwyty do elementów DOM (wyszukiwanie elementów na stronie)
      const pDzialanie = document.getElementById("dodaj");
      const inpSumaUsera = document.getElementById("suma");
      const btnSprawdz = document.getElementById("btn-sprawdz");
      const pWynik = document.getElementById("wynik");

      // KROK 2: Zmienne globalne przechowujące aktualnie wylosowane liczby
      let liczba1 = 0;
      let liczba2 = 0;

      // KROK 3: Funkcja, która losuje nowe działanie i resetuje stan pól
      function generujNoweDzialanie() {
        // Nadpisujemy zmienne globalne NOWYMI liczbami z zakresu 1-10
        liczba1 = Math.floor(Math.random() * 10 + 1);
        liczba2 = Math.floor(Math.random() * 10 + 1);

        // Pokazujemy dziecku nowe działanie na ekranie
        pDzialanie.textContent = `${liczba1} + ${liczba2} = `;

        // Czyszczenie pola odpowiedzi i reset koloru tła do białego
        inpSumaUsera.value = "";
        inpSumaUsera.style.backgroundColor = "white";
        pWynik.textContent = "";
      }

      // KROK 4: Funkcja sprawdzająca odpowiedź wpisaną przez dziecko
      function sprawdzWynik() {
        // Pobieramy wartość z inputu i zamieniamy tekst na prawdziwą liczbę
        let odpowiedzDziecka = Number(inpSumaUsera.value);

        // Obliczamy poprawny wynik matematyczny
        let poprawnyWynik = liczba1 + liczba2;

        // Instrukcja warunkowa sprawdzająca poprawność
        if (odpowiedzDziecka === poprawnyWynik) {
          // Odpowiedź poprawna -> tło zielone
          inpSumaUsera.style.backgroundColor = "green";
          pWynik.textContent =
            "Brawo! To poprawny wynik. Kliknij pole tekstowe, aby wylosować kolejne zadanie.";
        } else {
          // Odpowiedź błędna -> tło czerwone
          inpSumaUsera.style.backgroundColor = "red";
          pWynik.textContent = `Niestety to błąd. Prawidłowy wynik to: ${poprawnyWynik}. Kliknij pole tekstowe, aby wylosować kolejne zadanie.`;
        }
      }

      // KROK 5: Podpięcie zdarzeń (Events)
      // 1. Wygenerowanie pierwszego działania po wczytaniu strony
      generujNoweDzialanie();

      // 2. Sprawdzenie wyniku po kliknięciu przycisku "Sprawdź"
      btnSprawdz.addEventListener("click", sprawdzWynik);

      // 3. Po kliknięciu w pole wyniku (focus) tło wraca do białego i losuje się nowe działanie
      inpSumaUsera.addEventListener("focus", generujNoweDzialanie);
    </script>
  </body>
</html>
```

## 2. Wyjaśnienie struktury HTML krok po kroku

Formularz składa się z prostej struktury zamkniętej w kontenerze `<div class="kontener">`:

- **`<p id="dodaj"></p>`** – pusty akapit, w którym skrypt JavaScript będzie wyświetlał wylosowane działanie (np. `4 + 7 = `).
- **`<label for="suma">Podaj wynik: </label>`** – etykieta opisująca pole do wpisywania odpowiedzi.
  - **Dlaczego używamy** **`for="suma"`\*\***?\*\* Łączy ona etykietę z polem `<input id="suma">`. Dzięki temu kliknięcie w tekst "Podaj wynik:" automatycznie aktywuje i przenosi kursor do pola tekstowego.

- **`<input type="number" id="suma">`** – pole wprowadzania, do którego dziecko wpisuje odpowiedź. Parametr `type="number"` wymusza klawiaturę numeryczną na urządzeniach mobilnych i zapobiega wpisywaniu liter.
- **`<button id="btn-sprawdz">Sprawdź</button>`** – przycisk wyzwalający sprawdzenie odpowiedzi.
- **`<p id="wynik"></p>`** – akapit, w którym pojawia się komunikat zwrotny ("Brawo!" lub "Niestety to błąd...").

## 3. Wyjaśnienie logiki JavaScript krok po kroku

### Krok 1: Tworzenie "uchwytów" do elementów strony (DOM)

**JavaScript**

```javascript
const pDzialanie = document.getElementById("dodaj");
const inpSumaUsera = document.getElementById("suma");
const btnSprawdz = document.getElementById("btn-sprawdz");
const pWynik = document.getElementById("wynik");
```

- Metoda `document.getElementById('id_elementu')` wyszukuje dany element w kodzie HTML i przypisuje go do stałej w JavaScript.
- Tworzenie stałych na samej górze kodu pozwala manipulować elementami strony w dowolnym momencie bez konieczności ponownego ich wyszukiwania przez przeglądarkę.

### Krok 2: Zmienne globalne dla wylosowanych liczb

**JavaScript**

```javascript
let liczba1 = 0;
let liczba2 = 0;
```

- Zmienne deklarujemy poza funkcjami za pomocą `let`, aby były **globalne** (dostępne z poziomu każdej funkcji w skrypcie).
- W `liczba1` i `liczba2` przechowujemy aktualnie wylosowane składniki sumy.

### Krok 3: Generowanie nowego działania i losowanie liczb

**JavaScript**

```javascript
function generujNoweDzialanie() {
  liczba1 = Math.floor(Math.random() * 10 + 1);
  liczba2 = Math.floor(Math.random() * 10 + 1);

  pDzialanie.textContent = `${liczba1} + ${liczba2} = `;

  inpSumaUsera.value = "";
  inpSumaUsera.style.backgroundColor = "white";
  pWynik.textContent = "";
}
```

#### Jak działa wzór na losowanie liczby od 1 do 10?

1. **`Math.random()`** – generuje losową liczbę zmiennoprzecinkową z przedziału $[0, 1)$ (np. `0.7341`).
2. **`Math.random() * 10`** – przeskalowuje przedział na $[0, 10)$ (np. `7.341`).
3. **`Math.random() * 10 + 1`** – przesuwa cały zakres na $[1, 11)$ (np. `8.341`).
4. **`Math.floor(...)`** – zaokrągla wartość zawsze w dół do najbliższej liczby całkowitej. Dzięki temu otrzymujemy dokładnie jedną z liczb całkowitych z zakresu **od 1 do 10**.

#### Czyszczenie i przygotowanie interfejsu:

- `pDzialanie.textContent = ...` – używa tzw. _template literals_ (odwróconych apostrofów ` `` `), aby łatwo wstawić wylosowane zmienne do tekstu.
- `inpSumaUsera.value = ""` – czyści pole wpisywania odpowiedzi.
- `inpSumaUsera.style.backgroundColor = "white"` – przywraca białe tło pola tekstowego.
- `pWynik.textContent = ""` – usuwa poprzednie komunikaty diagnostyczne.

### Krok 4: Sprawdzanie wyniku

**JavaScript**

```javascript
function sprawdzWynik() {
  let odpowiedzDziecka = Number(inpSumaUsera.value);
  let poprawnyWynik = liczba1 + liczba2;

  if (odpowiedzDziecka === poprawnyWynik) {
    inpSumaUsera.style.backgroundColor = "green";
    pWynik.textContent =
      "Brawo! To poprawny wynik. Kliknij pole tekstowe, aby wylosować kolejne zadanie.";
  } else {
    inpSumaUsera.style.backgroundColor = "red";
    pWynik.textContent = `Niestety to błąd. Prawidłowy wynik to: ${poprawnyWynik}. Kliknij pole tekstowe, aby wylosować kolejne zadanie.`;
  }
}
```

1. **`Number(inpSumaUsera.value)`** – domyślnie wartość z pola tekstowego `<input>` pobierana jest jako tekst (łańcuch znaków / String). Funkcja `Number()` przekształca tekst na liczbę, co pozwala na jej prawidłowe porównanie.
2. **Instrukcja warunkowa** **`if...else`**:
   - Operator ścisłej równości `===` sprawdza, czy wpisana odpowiedź jest identyczna z wyliczoną sumą (`poprawnyWynik`).
   - Jeśli odpowiedź jest poprawna: zmieniamy kolor tła polu na zielony (`style.backgroundColor = 'green'`) i wyświetlamy pochwałę.
   - Jeśli odpowiedź jest błędna: zmiana tła na czerwony (`style.backgroundColor = 'red'`) i podanie prawidłowej odpowiedzi.

### Krok 5: Reakcja na zdarzenia (Events) i pojęcie `focus`

**JavaScript**

```javascript
generujNoweDzialanie();
btnSprawdz.addEventListener("click", sprawdzWynik);
inpSumaUsera.addEventListener("focus", generujNoweDzialanie);
```

1. **`generujNoweDzialanie()`** – pierwsze wywołanie funkcji natychmiast po załadowaniu strony, dzięki czemu dziecko od razu widzi pierwsze zadanie do rozwiązania.
2. **`addEventListener('click', sprawdzWynik)`** – nasłuchuje kliknięcia w przycisk "Sprawdź". Gdy kliknięcie nastąpi, wywoływana jest funkcja `sprawdzWynik`.
3. **`addEventListener('focus', generujNoweDzialanie)`** – nasłuchuje zdarzenia `focus` na polu wpisywania sumy.

#### Co to jest zdarzenie `focus`?

Zdarzenie **`focus`** (skupienie uwagi / aktywacja) następuje w momencie, gdy dany element formularza staje się aktywny – np. gdy dziecko kliknie myszką w pole tekstowe, dotknie go na ekranie dotykowym lub przejdzie do niego klawiszem Tab.

W naszym przypadku, po sprawdzeniu odpowiedzi (gdy tło pola jest zielone lub czerwone), ponowne kliknięcie w to pole przez dziecko wywołuje zdarzenie `focus`, które natychmiast resetuje kolory i losuje **kolejne działanie**.
