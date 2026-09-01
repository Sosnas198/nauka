# KROK 1: Budowa widoku (Struktura HTML)

Tworzymy tabelę, która mieści nasze przyciski nawigacyjne, 3 małe miniaturki u góry oraz 1 duże zdjęcie na dole.

**HTML**

```html
<table>
    <tr>
        <!-- Przycisk w lewo wywołuje funkcję zmiana2() -->
        <td onclick="zmiana2()">&lt;-</td>
        
        <!-- Trzy miniaturki na górze (wszystkie mają klasę "wspolny") -->
        <td><img src="1.png" class="wspolny" alt=""></td>
        <td><img src="2.png" class="wspolny" alt=""></td>
        <td><img src="3.png" class="wspolny" alt=""></td>
        
        <!-- Przycisk w prawo wywołuje funkcję zmiana1() -->
        <td onclick="zmiana1()">-&gt;</td>
    </tr>
    <tr>
        <!-- Duże zdjęcie na dole rozciągnięte na 5 kolumn -->
        <td colspan="5">
            <img src="2.png" class="wspolny" alt="">
        </td>
    </tr>
</table>
```

---

# KROK 2: Trzy fundamenty w JavaScript

Zanim klikniemy jakikolwiek przycisk, na samym początku skryptu tworzymy trzy zmienne:

**JavaScript**

```javascript
// 1. Łapiemy wszystkie 4 obrazki na stronie z klasą "wspolny"
let wspolny = document.querySelectorAll(".wspolny");

// 2. Magazyn nazw plików na dysku (od indeksu 0 do 6)
let zdjecia = ["1.png", "2.png", "3.png", "4.png", "5.png", "6.png", "7.png"];

// 3. Wskaźnik centralny – ustawiamy początkowo na 1 (czyli plik "2.png")
let x = 1;
```

---

# KROK 3: Ruch w prawo – funkcja `zmiana1()`

Gdy klikamy strzałkę `->`, uruchamia się funkcja `zmiana1()`. Oto co dzieje się po kolei:

## Krok A: Zmiana pozycji

Przesuwamy wskaźnik o jeden krok w przód:

**JavaScript**

```javascript
x = x + 1;
```

## Krok B: Strażnik końca magazynku

Jeśli wyszliśmy poza ostatni indeks (`6`), wracamy na początek (`0`):

**JavaScript**

```javascript
if (x > 6) {
    x = 0;
}
```

## Krok C: Obliczanie sąsiadów

Wyliczamy, które zdjęcia mają znajdować się po lewej i po prawej stronie:

**JavaScript**

```javascript
let lewy = x - 1;
let srodek = x;
let prawy = x + 1;
```

## Krok D: Magiczne zapętlenie krawędzi

Zabezpieczamy sytuacje skrajne, gdy `x` wskazuje sam początek lub sam koniec:

**JavaScript**

```javascript
// Jeśli na środku stoi pierwsze zdjęcie (0), z lewej dajemy ostatnie (6)
if (x == 0) {
    lewy = 6;
}

// Jeśli na środku stoi ostatnie zdjęcie (6), z prawej dajemy pierwsze (0)
if (x == 6) {
    prawy = 0;
}
```

## Krok E: Podmiana fizyczna na ekranie

Ustawiamy nowe ścieżki plików dla odpowiednich tagów `<img>`:

**JavaScript**

```javascript
wspolny[0].src = zdjecia[lewy];   // Lewa miniaturka
wspolny[1].src = zdjecia[srodek]; // Środkowa miniaturka
wspolny[2].src = zdjecia[prawy];  // Prawa miniaturka
wspolny[3].src = zdjecia[srodek]; // Duże zdjęcie na dole
```

---

# KROK 4: Ruch w lewo – funkcja `zmiana2()`

Działa analogicznie do ruchu w prawo, ale odejmujemy pozycję i pilnujemy początku magazynku:

**JavaScript**

```javascript
function zmiana2() {
    // 1. Zamiast dodawać, odejmujemy pozycję
    x = x - 1;

    // 2. Strażnik początku magazynku (jeśli spadliśmy poniżej 0, przeskakujemy na koniec)
    if (x < 0) {
        x = 6;
    }

    // 3. Obliczenie sąsiadów
    let lewy = x - 1;
    let srodek = x;
    let prawy = x + 1;

    // 4. Zapętlenie krawędzi
    if (x == 0) {
        lewy = 6;
    }
    if (x == 6) {
        prawy = 0;
    }

    // 5. Podmiana obrazków
    wspolny[0].src = zdjecia[lewy];
    wspolny[1].src = zdjecia[srodek];
    wspolny[2].src = zdjecia[prawy];
    wspolny[3].src = zdjecia[srodek];
}
```

---

# Całość złożona w jeden plik:

**HTML**

```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Galeria zdjęć</title>
</head>
<body>

<table>
    <tr>
        <td onclick="zmiana2()">&lt;-</td>
        <td><img src="1.png" class="wspolny" alt=""></td>
        <td><img src="2.png" class="wspolny" alt=""></td>
        <td><img src="3.png" class="wspolny" alt=""></td>
        <td onclick="zmiana1()">-&gt;</td>
    </tr>
    <tr>
        <td colspan="5"><img src="2.png" class="wspolny" alt=""></td>
    </tr>
</table>

<script>
    // Fundamenty
    let wspolny = document.querySelectorAll(".wspolny");
    let zdjecia = ["1.png", "2.png", "3.png", "4.png", "5.png", "6.png", "7.png"];
    let x = 1;

    // Ruch w prawo
    function zmiana1() {
        x = x + 1;

        if (x > 6) {
            x = 0;
        }

        let lewy = x - 1;
        let srodek = x;
        let prawy = x + 1;

        if (x == 0) {
            lewy = 6;
        }
        if (x == 6) {
            prawy = 0;
        }

        wspolny[0].src = zdjecia[lewy];
        wspolny[1].src = zdjecia[srodek];
        wspolny[2].src = zdjecia[prawy];
        wspolny[3].src = zdjecia[srodek];
    }

    // Ruch w lewo
    function zmiana2() {
        x = x - 1;

        if (x < 0) {
            x = 6;
        }

        let lewy = x - 1;
        let srodek = x;
        let prawy = x + 1;

        if (x == 0) {
            lewy = 6;
        }
        if (x == 6) {
            prawy = 0;
        }

        wspolny[0].src = zdjecia[lewy];
        wspolny[1].src = zdjecia[srodek];
        wspolny[2].src = zdjecia[prawy];
        wspolny[3].src = zdjecia[srodek];
    }
</script>

</body>
</html>
```
