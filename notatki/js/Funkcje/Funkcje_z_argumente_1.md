# Połączona wersja

Oto połączona wersja: proste, łopatologiczne tłumaczenie "dla amatora" bezpośrednio połączone z gotowymi blokami kodu w formacie Markdown, żeby wszystko było w jednym miejscu.

## 1. Wybór koloru tła (Funkcja z argumentem)

**Jak to działa po ludzku:**

To uniwersalny robot na posyłkach. Zamiast pisać osobną funkcję dla każdego koloru, dajesz jej w nawiasie paczkę (`x`). Kiedy klikasz przycisk, przeglądarka podmienia `x` na konkretny kolor (np. `'indigo'`) i od razu zmienia tło.

**Kod:**

### HTML

```HTML
<button onclick="kolor('indigo')">indigo</button>
<button onclick="kolor('steelblue')">steelblue</button>
<button onclick="kolor('olive')">olive</button>
```

### JavaScript

```JavaScript
function kolor(x){
    let prawy_blok = document.querySelector('#prawy');
    prawy_blok.style.backgroundColor = x; // x to nasza zmienna-kameleon / paczka
}
```

## 2. Wybór koloru czcionki (Zdarzenie `onchange` bez argumentu)

**Jak to działa po ludzku:**

Używasz listy rozwijanej (`<select>`). Ta funkcja nie potrzebuje paczki z zewnątrz, bo po uruchomieniu sama idzie do elementu `#lista`, sprawdza, co wybrał użytkownik (właściwość `.value`), i maluje tekst na wybranym kolor. Zdarzenie `onchange` odpala się dokładnie w momencie, gdy zmieniasz opcję na liście.

**Kod:**

### HTML

```HTML
<select id="lista" onchange="lista()">
    <option value="white">white</option>
    <option value="tan">tan</option>
    <option value="bisque">bisque</option>
    <option value="plum">plum</option>
</select>
```

### JavaScript

```JavaScript
function lista(){
    let prawy_blok = document.querySelector('#prawy');
    let lista = document.querySelector('#lista');
    prawy_blok.style.color = lista.value;
}
```

## 3. Rozmiar czcionki (Zdarzenie `onblur`)

**Jak to działa po ludzku:**

Wpisujesz w pole tekstowe np. `150%`. Funkcja nie zadziała od razu, gdy piszesz – dopiero kiedy klikniesz *gdziekolwiek indziej* poza polem (tracisz tzw. focus, czyli następuje zdarzenie `onblur`). Wtedy skrypt pobiera wpisaną wartość i powiększa tekst.

**Kod:**

### HTML

```HTML
<input type="text" id="rozmiar" value="100%" onblur="zmienRozmiar()">
```

### JavaScript

```JavaScript
function zmienRozmiar(){
    let prawy_blok = document.querySelector('#prawy');
    let rozmiar = document.querySelector('#rozmiar').value;
    prawy_blok.style.fontSize = rozmiar;
}
```

## 4. Włączenie / Wyłączenie ramki (Checkbox i instrukcja warunkowa)

**Jak to działa po ludzku:**

Checkbox działa zero-jedynkowo (zaznaczony/odznaczony, czyli `true` lub `false`). Instrukcja warunkowa `if` sprawdza: jeśli ptaszek jest zaznaczony (`checkbox.checked`), to dorzucamy obrazkowi ramkę. Jeśli nie – usuwamy ją (`"none"`).

**Kod:**

### HTML

```HTML
<input type="checkbox" id="ramka" onclick="ZmianaRamki()" checked> rysuj ramke
```

### JavaScript

```JavaScript
function ZmianaRamki() {
    // 1. Łapiemy obrazek znajdujący się wewnątrz bloku #prawy
    let obrazek = document.querySelector('#prawy img');
    // 2. Łapiemy nasz checkbox
    let checkbox = document.querySelector('#ramka');
    
    // 3. Sprawdzamy stan checkboxa instrukcją warunkową
    if (checkbox.checked) {
        // Jeśli ptaszek jest zaznaczony -> dodajemy ramkę
        obrazek.style.border = "2px solid black";
    } else {
        // Jeśli ptaszek został odznaczony -> usuwamy ramkę
        obrazek.style.border = "none";
    }
}
```

## 5. Pętla z warunkiem omijania elementów (`i != x`)

**Jak to działa po ludzku:**

Kiedy robisz akcję masową na wielu elementach, ale chcesz **ominąć** ten jeden, który właśnie kliknąłeś, z pomocą przychodzi pętla `for` połączona z warunkiem `if (i != x)`. Działa to jak ochroniarz w klubie: zmienia kolor wszystkim wokół, ale tej jednej klikniętej osobie daje spokój.

**Kod:**

### JavaScript

```JavaScript
for (let i = 0; i < kolor.length; i++) {
    if (i != x) { // OCHRONA: Pętlo, omiń kliknięty element!
        kolor[i].style.backgroundColor = "blue";
    }
}
```
