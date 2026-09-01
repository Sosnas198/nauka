# Kompletny przewodnik: Skrypt 1 — generowanie 10 obrazów w pętli (`createElement`)

Ta ściąga wytłumaczy Ci **od A do Z**, jak JavaScript w pętli tworzy dziesięć znaczników `<img>`, nadaje im klasę `wzory`, ustawia dymek z numerem i wkleja je do sekcji „Wzór”.

---

## SEC-1: Po co pętla? (10 plików: `1.jpg` … `10.jpg`)

Arkusz wymaga **10 obrazów** o nazwach kolejno: `1.jpg`, `2.jpg`, … `10.jpg`.

Nie piszesz dziesięciu tagów ręcznie. Jedna pętla buduje je wszystkie:

```javascript
for (let i = 1; i <= 10; i++) {
    // ciało pętli wykona się 10 razy: i = 1, 2, 3, …, 10
}
```

### Rozbicie zapisu

- **`let i = 1`** — start od **1**, bo pierwszy plik nazywa się `1.jpg`, a nie `0.jpg`.
- **`i <= 10`** — warunek: kręć się, dopóki `i` nie przekroczy 10.
- **`i++`** — po każdym obiegu zwiększ licznik o 1.

Nazwa pliku powstaje przez **sklejenie** liczby z rozszerzeniem:

```javascript
i + ".jpg"   // przy i = 3 powstaje tekst "3.jpg"
```

---

## SEC-2: Tworzenie elementu `<img>` w pamięci (`createElement`)

W każdym obiegu pętli powstaje **nowy** znacznik obrazu:

```javascript
const obraz = document.createElement("img");
```

To ten sam mechanizm co w projekcie galerii: tag istnieje najpierw tylko w pamięci. Dopóki nie zrobisz `appendChild`, użytkownik go nie widzi.

---

## SEC-3: `src`, klasa `wzory` oraz dymek (`title`)

Arkusz:

- każdy obraz ma klasę **`wzory`**,
- po najechaniu kursorem widać **dymek z nazwą (numerem)** obrazu.

Na ilustracji wskazano `3.jpg`, a dymek zawiera **liczbę `3`** — nie tekst `3.jpg`.

```javascript
obraz.src = i + ".jpg";
obraz.className = "wzory";
obraz.title = i;
```

| Właściwość     | Co ustawia w HTML              | Po co na egzaminie                          |
| -------------- | ------------------------------ | ------------------------------------------- |
| **`.src`**     | `src="3.jpg"`                  | Ścieżka do pliku graficznego                |
| **`.className`** | `class="wzory"`              | Klasa wymagana w arkuszu (style z `styl.css`) |
| **`.title`**   | `title="3"`                    | Natywny dymek przeglądarki po najechaniu    |

### `className` a `classList.add`

- **`obraz.className = "wzory"`** — nadpisuje atrybut `class` (tak jest w kontrolce).
- **`obraz.classList.add("wzory")`** — dokleja klasę bez kasowania innych.

Przy jednym, nowym elemencie oba sposoby dają ten sam efekt. Na egzaminie oba są poprawne; kontrolka używa `className`.

### Dlaczego `title`, a nie `alt`?

- **`alt`** — tekst zastępczy, gdy grafika się nie wczyta (dostępność).
- **`title`** — podpowiedź (dymek) po najechaniu kursorem.

Arkusz mówi o dymku po najechaniu → to **`title`**.

---

## SEC-4: Wklejenie obrazu do sekcji Wzór (`appendChild`)

Obrazy mają pojawić się w trzecim bloku (`id="sekcja3"`), razem z nagłówkiem „Wzór”.

```javascript
const sekcjaWzor = document.getElementById("sekcja3");
sekcjaWzor.appendChild(obraz);
```

W kontrolce skrypt stoi **wewnątrz** `#sekcja3`, wtedy rodzicem jest aktualny skrypt:

```javascript
document.currentScript.parentElement.appendChild(obraz);
```

Oba warianty wklejają `<img>` do tej samej sekcji. W osobnym pliku `script.js` bezpieczniej celować w `getElementById("sekcja3")`.

Kolejność w DOM: obrazy pojawiają się **w miejscu skryptu** (przed `<br>` i polem `input`), jeśli skrypt jest inline w `#sekcja3`.

---

# Podsumowanie przepływu danych

```text
for i od 1 do 10
        ↓
createElement("img")
        ↓
src = i + ".jpg"
className = "wzory"
title = i          ← dymek z numerem
        ↓
appendChild do #sekcja3
        ↓
Na stronie: 10 miniatur z klasą wzory
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / metoda**           | **Co robi?**                                              |
| ------------------------------ | --------------------------------------------------------- |
| **`for (let i = 1; i <= 10)`** | Dziesięć obiegów, pliki od `1.jpg` do `10.jpg`.           |
| **`i + ".jpg"`**               | Sklejenie numeru z rozszerzeniem.                         |
| **`createElement("img")`**     | Nowy znacznik obrazu w pamięci.                           |
| **`.className = "wzory"`**     | Klasa CSS z arkusza.                                      |
| **`.title = i`**               | Dymek z numerem (dla `3.jpg` → `3`).                      |
| **`appendChild`**              | Wklejenie gotowego `<img>` do sekcji.                     |

---

### Co dalej?

Galeria wzorów jest na stronie. Teraz przyciski w `nav` mają **przełączać sekcje** po najechaniu kursorem.

👉 **[Przejdź do Kroku 2: Przełączanie sekcji i przycisków](../02_przelaczanie_sekcji_i_przyciskow/README.md)**
