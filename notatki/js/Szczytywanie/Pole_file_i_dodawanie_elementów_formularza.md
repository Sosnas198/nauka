## 1. Wygląd i układ strony (HTML i CSS)

Na początek musimy przygotować formularz oraz style wizualne.

### A. Style CSS (`<style>`)

**CSS**

```css
.wynik {
  height: 200px;
  width: 200px;
  background-color: bisque;
  overflow: auto;
  margin-top: 10px;
  padding: 5px;
}
img {
  height: 50px;
  width: 50px;
  border-radius: 50px;
  display: block;
}
```

**Szczegółowe wytłumaczenie stylów:**

- **`.wynik`** – to klasa dla dużego pudła (kontenera `<div class="wynik">`), które będziemy tworzyć dynamicznie w JavaScript:
  - `height: 200px; width: 200px;` – nadaje sztywne wymiary $200 \times 200$ pikseli.
  - `background-color: bisque;` – ustawia jasnobżowy kolor tła.
  - `overflow: auto;` – **kluczowa właściwość!** Jeśli zawartość wewnątrz bloku będzie wyższa niż 200px, przeglądarka automatycznie doda pasek przewijania (scroll).
  - `margin-top: 10px;` – robi odstęp od elementów wyżej, żeby bloki nie sklejały się ze sobą.
  - `padding: 5px;` – robi wewnętrzny margines, dzięki czemu tekst nie dotyka krawędzi bloku.

- **`img`** – dotyczy każdego obrazka stworzonego na stronie:
  - `height: 50px; width: 50px;` – wymusza stały rozmiar $50 \times 50$ pikseli.
  - `border-radius: 50px;` – sprawia, że krawędzie obrazka są idealnie zaokrąglone (robi z niego koło).
  - `display: block;` – zmienia tryb wyświetlania z liniowego na blokowy (obrazek zachowuje się jak osobny wiersz).

### B. Formularz w HTML (`<body>`)

**HTML**

```html
podaj rozmiar czcionki <input type="number" id="rozmiar_czcionki" value="16" />
<br />
ramka
<input type="radio" name="dekoracja" id="ramka_tak" value="ramka" checked />
<br />
bez ramki
<input type="radio" name="dekoracja" id="ramka_nie" value="bez ramki" /> <br />
<input type="file" id="wybierz_plik" /> <br />

<button onclick="dodaj()">dodaj</button>
<p id="paragraf_info">Wybrales obrazek:</p>
```

**Wyjaśnienie elementów HTML:**

1. **`input type="number"`** z `id="rozmiar_czcionki"` – pole do wpisania liczby (rozmiaru czcionki). Domyślnie wpisane jest `16`.
2. **`input type="radio"`** z `id="ramka_tak"` i `id="ramka_nie"` – dwa przycisku wyboru. Mają tę samą nazwę `name="dekoracja"`, co sprawia, że tylko jeden z nich może być zaznaczony naraz. Atrybut `checked` przy `ramka_tak` oznacza, że domyślnie ramka jest włączona.
3. **`input type="file"`** z `id="wybierz_plik"` – pole pozwalające użytkownikowi wybrać plik z dysku komputera.
4. **`button onclick="dodaj()"`** – przycisk, który po kliknięciu uruchamia naszą główną funkcję JavaScript o nazwie `dodaj()`.
5. **`p id="paragraf_info"`** – paragraf z tekstem `Wybrales obrazek: `. To pod nim będziemy wstawiać nowe bloki.

## 2. Logika w JavaScript krok po kroku

Rzućmy światło na skrypt JavaScript. Przeanalizujemy każdą część kodu.

### Krok 1: Przygotowanie "uchwytów" i licznika (Góra skryptu)

**JavaScript**

```javascript
const inpRozmiar = document.getElementById("rozmiar_czcionki");
const radioRamka = document.getElementById("ramka_tak");
const inpFile = document.getElementById("wybierz_plik");
const paragraf = document.getElementById("paragraf_info");

let i = 1;
```

**Dlaczego robimy to na samej górze poza funkcją?**

- **`document.getElementById(...)`** tworzy tzw. „uchwyt” (referencję) do elementu HTML. Zamiast kazać przeglądarce szukać elementu na stronie za każdym razem, gdy klikniemy przycisk, wyszukujemy je **raz** przy załadowaniu strony. Działa to szybciej i czytelniej.
- **`let i = 1;`** – zmienna globalna przechowująca numer bloku. Zaczynamy od `1`. Ponieważ jest poza funkcją, jej wartość nie zeruje się przy kliknięciu przycisku.

### Krok 2: Walidacja i pobranie danych z pól (Początek funkcji `dodaj()`)

**JavaScript**

```javascript
function dodaj() {
    if (inpFile.files.length === 0) {
        alert("Najpierw wybierz plik graficzny!");
        return;
    }

    let rozmiar = inpRozmiar.value + 'px';
    let nazwaPliku = inpFile.files[0].name;
```

**Co tu się dokładnie dzieje?**

1. **`inpFile.files.length === 0`**: Pole typu `file` posiada właściwość `.files`, która jest listą wyboru plików. Jeśli jej długość (`length`) wynosi `0`, oznacza to, że użytkownik nie wybrał żadnego pliku.
2. **`alert(...)`** **i** **`return`**: Wyświetlamy ostrzeżenie, a słowo kluczowe `return` natychmiast przerywa działanie funkcji `dodaj()`. Dalsza część kodu się nie wykona.
3. **`inpRozmiar.value + 'px'`**: Pobieramy wartość z pola numerycznego (np. `20`) i doklejamy do niej `'px'`. Otrzymujemy tekst `'20px'`, czyli dokładnie taki format, jakiego wymaga CSS do ustawienia wielkości czcionki.
4. **`inpFile.files[0].name`**: `inpFile.files[0]` odwołuje się do pierwszego wybranego pliku z listy. Właściwość `.name` wyciąga jego nazwę jako tekst (np. `"obraz1.jpg"`).

### Krok 3: Stworzenie głównego kontenera (Pudła)

**JavaScript**

```javascript
let nowyBlok = document.createElement("div");
nowyBlok.className = "wynik";
```

**Co robimy?**

- **`document.createElement('div')`**: Tworzy w pamięci podręcznej komputera nowy, pusty znacznik `<div>`.
- **`nowyBlok.className = 'wynik'`**: Nadaje temu nowemu divowi klasę `wynik`. W tym momencie ten div otrzymuje wszystkie style CSS, które opisaliśmy wcześniej (tło `bisque`, wymiary $200 \times 200\text{px}$, paski przewijania itp.).

### Krok 4: Tworzenie zawartości bloku i składanie jej w całość

Teraz tworzymy 4 elementy wewnętrzne, które włożymy **do środka** naszego `nowyBlok`.

#### A. Numer bloku:

**JavaScript**

```javascript
let elNumer = document.createElement("p");
elNumer.innerHTML = `Blok numer: ${i}`;
nowyBlok.appendChild(elNumer);
```

- `document.createElement('p')` – tworzymy akapit dla numeru.
- `.innerHTML = ...` – wpisujemy w niego tekst z aktualną wartością zmiennej `i` (np. `"Blok numer: 1"`).
- **`nowyBlok.appendChild(elNumer)`** – **BARDZO WAŻNE!** Metoda `.appendChild()` oznacza: _„weź_ _`elNumer`_ _i wklej go jako_ **_dziecko do środka_** _pojemnika_ _`nowyBlok`\*\*”_.

#### B. Tekst z paragrafu głównego (w wybranym rozmiarze i z podkreśleniem):

**JavaScript**

```javascript
let elTekst = document.createElement("p");
elTekst.innerHTML = paragraf.innerHTML;
elTekst.style.fontSize = rozmiar;
elTekst.style.textDecoration = "underline";
nowyBlok.appendChild(elTekst);
```

- `paragraf.innerHTML` – kopiuje tekst z głównego paragrafu (`"Wybrales obrazek: "`).
- `elTekst.style.fontSize = rozmiar` – nadaje temu konkretnemu akapitowi rozmiar czcionki pobrany z formularza (np. `20px`).
- `elTekst.style.textDecoration = 'underline'` – dodaje podkreślenie tekstu.
- `nowyBlok.appendChild(elTekst)` – wrzucamy ten akapit do środka naszego głównego bloku jako drugi element.

#### C. Zdjęcie z opcjonalną ramką:

**JavaScript**

```javascript
let elImg = document.createElement("img");
elImg.src = nazwaPliku;

if (radioRamka.checked) {
  elImg.style.border = "2px dashed red";
}
nowyBlok.appendChild(elImg);
```

- `document.createElement('img')` – tworzy znacznik `<img>`.
- `elImg.src = nazwaPliku` – ustawia ścieżkę do pliku (np. `"obraz1.jpg"`).
- **`if (radioRamka.checked)`**: Właściwość `.checked` zwraca `true`, jeśli opcja "Ramka" jest zaznaczona, lub `false`, gdy nie jest. Jeśli jest zaznaczona, dodajemy styl ramki: `2px dashed red` (dwupikselowa, czerwona, kreskowana).
- `nowyBlok.appendChild(elImg)` – wkładamy obrazek do środka kontenera.

#### D. Linia pozioma na samym dole:

**JavaScript**

```javascript
let elHr = document.createElement("hr");
nowyBlok.appendChild(elHr);
```

- Tworzymy znacznik poziomej linii `<hr>` i wklejamy go na sam koniec wewnątrz kontenera.

### Krok 5: Wstawienie gotowego bloku na stronę i zwiększenie licznika

Aż do tej pory nasz `nowyBlok` wraz z całą zawartością istniał tylko w pamięci RAM komputera. Czas pokazać go użytkownikowi!

**JavaScript**

```javascript
    paragraf.after(nowyBlok);

    i++;
}
```

**Różnica między** **`.appendChild()`** **a** **`.after()`**:

1. **`paragraf.after(nowyBlok)`**:
   - Metoda `.after()` wstawia element **OBOK / ZA / POD** wskazanym elementem (jako jego brata/sąsiada na tym samym poziomie).
   - Dzięki temu nasz nowy blok ląduje bezpośrednio **pod** paragrafem `id="paragraf_info"`.
   - gdybyśmy użyli `paragraf.appendChild(nowyBlok)`, włożylibyśmy wielkiego diva $200 \times 200\text{px}$ **do środka** akapitu `<p>`, co jest błędem w HTML!

2. **`i++`**:
   - Zwiększa zmienną `i` o $1$ (`1 -> 2 -> 3...`).
   - Dzięki temu, gdy klikniemy przycisk ponowanie, kolejny generowany blok dostanie napis `"Blok numer: 2"`.

## 3. Kompletny kod – gotowy do skopiowania

Oto cały skompletowany plik, który możesz zapisać np. jako `index.html`:

**HTML**

```html
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Dynamiczne tworzenie bloków DOM</title>
    <style>
      .wynik {
        height: 200px;
        width: 200px;
        background-color: bisque;
        overflow: auto;
        margin-top: 10px;
        padding: 5px;
      }
      img {
        height: 50px;
        width: 50px;
        border-radius: 50px;
        display: block;
      }
    </style>
  </head>
  <body>
    podaj rozmiar czcionki
    <input type="number" id="rozmiar_czcionki" value="16" /> <br />
    ramka
    <input type="radio" name="dekoracja" id="ramka_tak" value="ramka" checked />
    <br />
    bez ramki
    <input type="radio" name="dekoracja" id="ramka_nie" value="bez ramki" />
    <br />
    <input type="file" id="wybierz_plik" /> <br />

    <button onclick="dodaj()">dodaj</button>
    <p id="paragraf_info">Wybrales obrazek:</p>

    <script>
      // Uchwyty do elementów na stronie
      const inpRozmiar = document.getElementById("rozmiar_czcionki");
      const radioRamka = document.getElementById("ramka_tak");
      const inpFile = document.getElementById("wybierz_plik");
      const paragraf = document.getElementById("paragraf_info");

      // Licznik bloków
      let i = 1;

      function dodaj() {
        // Walidacja - czy wybrano plik
        if (inpFile.files.length === 0) {
          alert("Najpierw wybierz plik graficzny!");
          return;
        }

        // Pobranie danych
        let rozmiar = inpRozmiar.value + "px";
        let nazwaPliku = inpFile.files[0].name;

        // Tworzenie głównego pojemnika (.wynik)
        let nowyBlok = document.createElement("div");
        nowyBlok.className = "wynik";

        // A. Numer bloku
        let elNumer = document.createElement("p");
        elNumer.innerHTML = `Blok numer: ${i}`;
        nowyBlok.appendChild(elNumer);

        // B. Tekst w wybranym rozmiarze z podkreśleniem
        let elTekst = document.createElement("p");
        elTekst.innerHTML = paragraf.innerHTML;
        elTekst.style.fontSize = rozmiar;
        elTekst.style.textDecoration = "underline";
        nowyBlok.appendChild(elTekst);

        // C. Obrazek z ewentualną ramką
        let elImg = document.createElement("img");
        elImg.src = nazwaPliku;
        if (radioRamka.checked) {
          elImg.style.border = "2px dashed red";
        }
        nowyBlok.appendChild(elImg);

        // D. Linia pozioma
        let elHr = document.createElement("hr");
        nowyBlok.appendChild(elHr);

        // Wstawienie do DOM tuż pod paragrafem
        paragraf.after(nowyBlok);

        // Zwiększenie numeru dla kolejnego bloku
        i++;
      }
    </script>
  </body>
</html>
```
