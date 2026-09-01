## 1. Zwykłe pola tekstowe (`<input type="text">`) vs. Pola wyboru (`radio` / `checkbox`)

Różnica w działaniu atrybutu `value` dla tych dwóch grup:

### A. Pole tekstowe (`<input type="text">`)

- **Jak działa:** Służy jako puste „pudełko”, do którego użytkownik może wpisać dowolny tekst z klawiatury.
- **Brak statycznego `value`:** Nie wpisujemy atrybutu `value="..."` na sztywno w HTML, ponieważ nie da się z góry przewidzieć treści wpisywanej przez użytkownika.
- **Dinamizm w RAM:** Wartość `.value` tworzy się i zmienia w pamięci przeglądarki w momencie, gdy użytkownik wciska klawisze na klawiaturze.

### B. Pola wyboru (`radio` oraz `checkbox`)

- **Jak działają:** Użytkownik nie wpisuje tu własnego tekstu, lecz jedynie wybiera przygotowaną opcję poprzez kliknięcie myszką lub dotknięcie ekranu.
- **Wymagany atrybut `value` na sztywno:** Programista musi wyznaczyć ukrytą wartość techniczną `value="..."` dla każdego pola. Dzięki temu po kliknięciu przeglądarka wie, jaką wartość przekazać do skryptu JavaScript.

## 2. Lista rozwijana (`<select>`)

Lista rozwijana umożliwia wybór **dokładnie jednej opcji z zamkniętego zbioru**.

### Kod HTML:

**HTML**

```html
<label for="auto">Wybierz samochód:</label>
<select id="auto">
  <option value="audi">Audi</option>
  <option value="bmw">BMW</option>
  <option value="volvo">Volvo</option>
</select>
<p id="wynik-auto">Wybrałeś: audi</p>
```

### Szczegółowa analiza komponentów:

1. **`<select id="auto">`**:
   - Główny kontener reprezentujący całą listę.
   - Atrybut `id="auto"` służy do łatwego pobrania całego menu w JavaScript za pomocą `document.getElementById('auto')`.

2. **`<option value="...">`**:
   - Pojedyncza pozycja na liście.
   - **Atrybut `value="audi"`:** Ukryta wartość techniczna przeznaczona dla JavaScriptu (zaleca się używanie małych liter, bez spacji i polskich znaków).
   - **Tekst między tagami (`Audi`):** Etykieta widoczna dla użytkownika na ekranie.

3. **`<label for="auto">`**:
   - Etykieta opisowa związana z polem o `id="auto"`. Poprawia dostępność formularza.

### Odczyt wartości w JavaScript:

Lista rozwijana zwraca tylko jedną wartość naraz, dlatego wystarczy odwołać się do właściwości `.value` samego elementu `<select>`:

**JavaScript**

```javascript
// Pobranie uchwytu do elementu select
var lista = document.getElementById("auto");

// Pobranie i wyświetlenie aktualnie wybranej wartości
document.write(lista.value);
```

## 3. Pole wyboru (`<input type="checkbox">`)

Stosowane w sytuacjach wielokrotnego wyboru, gdzie użytkownik może niezależnie zaznaczyć **zero, jedną lub wiele opcji**.

### Kod HTML:

**HTML**

```html
<p>Wybierz dodatki do pizzy (możesz wiele):</p>

<input type="checkbox" id="dodatek-ser" value="ser" />
<label for="dodatek-ser">Dodatkowy ser</label><br />

<input type="checkbox" id="dodatek-szynka" value="szynka" />
<label for="dodatek-szynka">Szynka</label><br />

<input type="checkbox" id="dodatek-pieczarki" value="pieczarki" />
<label for="dodatek-pieczarki">Pieczarki</label>

<p id="wynik-pizza">Wybrane dodatki: brak</p>
```

### Szczegółowa analiza komponentów:

1. **Każdy `checkbox` ma własne, unikalne `id`** (np. `dodatek-ser`, `dodatek-szynka`), co umożliwia niezależne pobieranie ich stanu.
2. **`value="..."`:** Określa, jaka wartość zostanie zwrócona, jeśli dane pole zostanie zaznaczone.

### Odczyt wartości w JavaScript:

Ze względu na możliwość zaznaczenia wielu pól, każde z nich musimy sprawdzić osobno za pomocą właściwości logicznej `.checked`:

**JavaScript**

```javascript
// 1. Pobranie poszczególnych pól do zmiennych
var ser = document.getElementById("dodatek-ser");
var szynka = document.getElementById("dodatek-szynka");

// 2. Weryfikacja stanu każdego pola za pomocą instrukcji warunkowych
if (ser.checked) {
  // Wykona się tylko wtedy, gdy ser.checked === true
  document.write(ser.value);
}

if (szynka.checked) {
  // Wykona się tylko wtedy, gdy szynka.checked === true
  document.write(szynka.value);
}
```

## 4. Pole opcji (`<input type="radio">`)

Służy do wyboru **wyłącznie jednej opcji ze wskazanego zbioru**. Zaznaczenie jednego pola typu `radio` powoduje automatyczne odznaczenie pozostałych w tej samej grupie.

### Kod HTML:

**HTML**

```html
<p>Wybierz metodę płatności:</p>

<input type="radio" id="platnosc-karta" name="platnosc" value="karta" checked />
<label for="platnosc-karta">Karta płatnicza</label><br />

<input type="radio" id="platnosc-blik" name="platnosc" value="blik" />
<label for="platnosc-blik">BLIK</label><br />

<input type="radio" id="platnosc-przelew" name="platnosc" value="przelew" />
<label for="platnosc-przelew">Przelew bankowy</label>

<p id="wynik-platnosc">Wybrana metoda: karta</p>
```

### Szczegółowa analiza komponentów:

1. **Atrybut `name="platnosc"` (Kluczowy):**
   - Wszystkie przyciski `radio` należące do tej samej grupy **muszą mieć identyczny atrybut `name`**.
   - To atrybut `name` informuje przeglądarkę, że pola tworzą razem jedną grupę i ma odznaczać inne po kliknięciu w dowolne z nich.

2. **Atrybut `checked`:**
   - Dopisanie słowa `checked` do jednego z przycisków sprawia, że jest on domyślnie zaznaczony zaraz po wczytaniu strony.

### Odczyt wartości w JavaScript:

Grupy `radio` nie pobiera się po `id`, lecz po wspólnej nazwie za pomocą `document.getElementsByName('nazwa_grupy')`. Metoda ta zwraca tablicę / kolekcję wszystkich pól o podanej nazwie.

**JavaScript**

```javascript
// 1. Pobranie wszystkich przycisków należących do grupy "platnosc"
var opcje = document.getElementsByName("platnosc");

// 2. Przejście pętlą for przez całą kolekcję w celu znalezienia zaznaczonego pola
for (var i = 0; i < opcje.length; i++) {
  // Sprawdzamy, który element z kolei w grupie ma właściwość checked równe true
  if (opcje[i].checked) {
    // Wyświetlamy wartość z atrybutu value zaznaczonego pola
    document.write(opcje[i].value);
  }
}
```

## Podsumowanie zestawieniowe

```text
+------------------+-----------------------+------------------------------------+--------------------------+
| Typ elementu     | Dopuszczalny wybór    | Pobieranie z DOM                   | Sprawdzana właściwość    |
+------------------+-----------------------+------------------------------------+--------------------------+
| <select>         | Jedna opcja           | document.getElementById('id')      | .value                   |
| <input checkbox> | Wiele opcji niezależnie| document.getElementById('id')      | .checked oraz .value     |
| <input radio>    | Wykluczający (jedna)  | document.getElementsByName('name') | Pętla + .checked i .value|
+------------------+-----------------------+------------------------------------+--------------------------+
```
