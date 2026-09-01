# Kompletny przewodnik: Pobieranie elementu wynikowego i przycisków radio z formularza

Ta ściąga wytłumaczy Ci **od A do Z**, jak JavaScript przygotowuje sobie "uchwyty" do wszystkich elementów strony, które będą potrzebne do obliczenia i wyświetlenia promocyjnej ceny strzyżenia.

---

## SEC-1: Pobranie elementu wynikowego i utworzenie zmiennej na cenę

```javascript
let wynik = document.getElementById("wynik");
let cena = 0;
```

### Jak to działa?

- **`document.getElementById("wynik")`** – wyszukuje w HTML znacznik `<p id="wynik"></p>`, czyli pusty na razie akapit, w którym na końcu wyświetlimy wyliczoną cenę promocyjną.
- **`let wynik = ...`** – zapisujemy ten element do zmiennej `wynik`, żeby móc się do niego odwołać w dalszej części funkcji (w module 03), bez konieczności ponownego wyszukiwania go w HTML.
- **`let cena = 0;`** – tworzymy zmienną `cena` i od razu nadajemy jej wartość początkową `0`. Ta zmienna posłuży w module 02 do zapisania wyliczonej ceny promocyjnej — na razie, zanim sprawdzimy, którą opcję wybrał użytkownik, ustawiamy ją na `0` jako wartość "startową".

---

## SEC-2: Pobranie wszystkich czterech przycisków radio

```javascript
const krotkie = document.getElementById('krotkie');
const srednie = document.getElementById('srednie');
const poldlugie = document.getElementById('poldlugie');
const dlugie = document.getElementById('dlugie');
```

### Jak to działa?

- W formularzu HTML mamy cztery przyciski typu radio, każdy z innym `id`, np.: `<input type="radio" name="wlosy" id="krotkie" checked>`. Wszystkie mają wspólny atrybut `name="wlosy"` — to sprawia, że są ze sobą "powiązane" i użytkownik może zaznaczyć **tylko jeden** z nich naraz (zaznaczenie innego automatycznie odznacza poprzedni).
- **`document.getElementById('krotkie')`** – wyszukuje konkretnie ten przycisk radio, który odpowiada za opcję "Krótkie" włosy, po jego unikalnym `id="krotkie"`.
- Analogicznie pobieramy pozostałe trzy przyciski: `srednie`, `poldlugie`, `dlugie` — każdy po swoim `id`.
- **`const`** – w przeciwieństwie do `let` (użytego dla `wynik` i `cena`), tutaj używamy `const`, ponieważ te zmienne **nie będą później zmieniane** — raz pobrany element HTML pozostaje ten sam przez całe działanie funkcji. Zmieniać się będzie jedynie to, **czy dany przycisk jest zaznaczony** (co sprawdzimy w module 02), a nie sama zmienna wskazująca na ten przycisk.
- Dzięki temu w kolejnym module (`02_obliczanie_ceny_promocyjnej`) będziemy mogli łatwo sprawdzić, np. `krotkie.checked`, żeby dowiedzieć się, czy użytkownik zaznaczył akurat tę opcję.

---

# Podsumowanie przepływu danych

```text
SEC-1: wynik = document.getElementById("wynik")
       cena = 0
       — Przygotowanie elementu wynikowego i zmiennej na cenę
                 ↓
SEC-2: krotkie, srednie, poldlugie, dlugie = document.getElementById(...)
       — Pobranie wszystkich czterech przycisków radio z formularza
                 ↓
       (dalej: moduł 02 — sprawdzenie, który przycisk jest zaznaczony, i wyliczenie ceny)
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Metoda**         | **Co oznacza / Co robi?**                                                             |
| -------------------------------- | -------------------------------------------------------------------------------------------- |
| **`document.getElementById()`**  | Pobiera konkretny element z dokumentu HTML po jego atrybucie `id`.                            |
| **`let`**                        | Deklaruje zmienną, której wartość **może się zmienić** w dalszej części kodu.                 |
| **`const`**                      | Deklaruje zmienną, do której **nie przypiszemy ponownie innej wartości** (stała referencja).  |
| **przyciski radio (`name` wspólny)** | Grupa przycisków, z których użytkownik może zaznaczyć tylko jeden naraz.                  |
