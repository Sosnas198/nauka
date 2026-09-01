# Selekcja elementów DOM w JavaScript

Wyjaśniamy każdą metodę krok po kroku: jak działa, co dokładnie zwraca, czym różnią się nowoczesne metody od klasycznych oraz jak na nich iterować.

---

## Dlaczego selekcja w DOM jest ważna?

Selektory to punkt startowy w JavaScript. Aby zmienić kolor, pobrać tekst z pola, dodać klasę czy obsłużyć kliknięcie przycisku, musisz **najpierw znaleźć ten element w drzewie DOM**.

---

# 1. Nowoczesne metody selekcji (Rekomendowane)

Nowoczesne metody używają **dokładnie takich samych selektorów jak CSS** (np. `#id`, `.klasa`, `div > p`).

## A. `document.querySelector('selektor')`

- **Jak działa:** Przeszukuje dokument HTML **od góry do dołu** i zwraca **pierwszy pojedynczy element**, który pasuje do podanego selektora CSS.
- **Co zwraca:**
  - Pobiera pojedynczy obiekt elementu HTML.
  - Jeżeli na stronie **nie ma** elementu pasującego do selektora, zwraca wartość **`null`**.

- **Kiedy stosować:** Gdy wiesz, że na stronie jest tylko jeden taki element (np. unikalne nagłówek, formularz) lub interesuje Cię wyłącznie pierwszy pasujący z brzegu.

### Przykłady kodu:

```javascript
// 1. Szukanie po ID - PAMIĘTAJ O HASHTAGU #
const naglowek = document.querySelector("#glowny-tytul");

// 2. Szukanie po klasie - PAMIĘTAJ O KROPCE .
const pierwszyPrzycisk = document.querySelector(".btn-primary");

// 3. Szukanie zaawansowane (zagnieżdżone)
const linkWMenu = document.querySelector("nav ul li a");
```

---

## B. `document.querySelectorAll('selektor')`

- **Jak działa:** Przeszukuje cały dokument HTML i znajduje **wszystkie** elementy spełniające podany selektor CSS.
- **Co zwraca:** Zwraca kolekcję zwaną **`NodeList`** (listę węzłów).

### Cechy `NodeList`:

- Jest to obiekt **tablicopodobny** (_Array-like object_).
- Posiada właściwość **`.length`** (mówi, ile elementów znaleziono).
- Elementy są indeksowane **od zera** (`[0]`, `[1]`, `[2]`).
- Pozwala na bezpośrednie użycie pętli **`.forEach()`** oraz klasycznej pętli **`for`**.
- **Jest stała (nie-żywa / statyczna):** Wykonuje "zdjęcie" dokumentu w danym momencie. Jeśli później dodasz nowy element do HTML, ta lista automatycznie się nie powiększy.

### Przykład kodu:

```javascript
const przyciski = document.querySelectorAll(".btn");

// Przeglądanie za pomocą metody .forEach()
przyciski.forEach(function (przycisk) {
  przycisk.style.backgroundColor = "blue";
});
```

---

# 2. Klasyczne metody strukturalne (Starsze)

Przed wprowadzeniem `querySelector` używano metod szukających po konkretnych właściwościach HTML. Są one nieco szybsze pod kątem wydajności, ale mniej elastyczne.

## A. `document.getElementById('nazwa_id')`

- **Jak działa:** Szuka elementu po jego unikalnym atrybucie `id=""`.
- **Ważna różnica:** **Nie podajesz tutaj hashtaga `#`** – wpisujesz samą czystą nazwę identyfikatora!
- **Co zwraca:** Zwraca dokładnie **jeden element** lub **`null`**.

### Przykład kodu:

```javascript
// Odpowiednik document.querySelector('#sekcja-1')
const sekcja = document.getElementById("sekcja-1");
```

---

## B. `document.getElementsByClassName('nazwa_klasy')`

- **Jak działa:** Szuka wszystkich elementów posiadających daną klasę w atrybucie `class=""`.
- **Ważna różnica:** **Nie podajesz tutaj kropki `.`** – wpisujesz samą surową nazwę klasy!
- **Co zwraca:** Zwraca kolekcję zwaną **`HTMLCollection`**.

### Kluczowy haczyk (`Żywa kolekcja`):

- `HTMLCollection` to tzw. **żywa kolekcja** (_live collection_). Jeśli po jej pobraniu skrypt doda do strony nowy element z tą klasą, kolekcja w pamięci **automatycznie się powiększy**.
- **Brak `.forEach()`**: `HTMLCollection` **NIE posiada** wbudowanej metody `.forEach()`. Próba wywołania `.forEach()` na `HTMLCollection` wyrzuci błąd!

### Przykład kodu:

```javascript
const pudelka = document.getElementsByClassName("box");
```

---

## C. `document.getElementsByTagName('nazwa_znacznika')`

- **Jak działa:** Szuka wszystkich elementów danego typu po nazwie znacznika HTML (np. wszystkich obrazków `<img>`, paragrafów `<p>` czy znaczników `<input>`).
- **Co zwraca:** Podobnie jak przy klasach – żywą kolekcję **`HTMLCollection`**.

### Przykład kodu:

```javascript
const wszystkieObrazki = document.getElementsByTagName("img");
```

---

# 3. Jak przechodzić pętlą po `NodeList` oraz `HTMLCollection`?

Klasyczna pętla `for` (z licznikiem `i`) to uniwersalne narzędzie, które **działa bezproblemowo na obu typach kolekcji**: zarówno na `NodeList` (z `querySelectorAll`), jak i na `HTMLCollection` (z `getElementsByClassName`).

Gwarantuje to fakt, że obie struktury są **obiektami tablicopodobnymi** (_Array-like objects_):

1. Posiadają właściwość **`.length`** (wiedzą, ile elementów jest w środku).
2. Ich elementy są indeksowane **od zera** (`[0]`, `[1]`, `[2]`...).

### Porównanie działania pętli `for` w kodzie:

```javascript
// 1. Pobieramy elementy dwoma różnymi sposobami:
const kolekcjaNowa = document.querySelectorAll(".box"); // Zwraca NodeList
const kolekcjaStara = document.getElementsByClassName("box"); // Zwraca HTMLCollection

// 2. Pętla dla NodeList (działa idealnie):
for (let i = 0; i < kolekcjaNowa.length; i++) {
  kolekcjaNowa[i].style.color = "blue";
}

// 3. Pętla dla HTMLCollection (działa DOKŁADNIE tak samo!):
for (let i = 0; i < kolekcjaStara.length; i++) {
  kolekcjaStara[i].style.color = "red";
}
```

---

# Szybka ściągawka / Podsumowanie

| **Metoda**                   | **Co przyjmuje jako argument?**    | **Co zwraca?**       | **Czy jest "żywa"?** | **Czy ma `.forEach()`?** |
| ---------------------------- | ---------------------------------- | -------------------- | -------------------- | ------------------------ |
| **`querySelector`**          | Selektor CSS (np. `#id`, `.klasa`) | 1 element lub `null` | Nie dotyczy          | Nie dotyczy              |
| **`querySelectorAll`**       | Selektor CSS (np. `.klasa`, `div`) | `NodeList`           | **Nie** (statyczna)  | **TAK**                  |
| **`getElementById`**         | Surową nazwę ID (bez `#`)          | 1 element lub `null` | Nie dotyczy          | Nie dotyczy              |
| **`getElementsByClassName`** | Surową nazwę klasy (bez `.`)       | `HTMLCollection`     | **TAK** (żywa)       | **NIE**                  |
| **`getElementsByTagName`**   | Nazwę znacznika (np. `'img'`)      | `HTMLCollection`     | **TAK** (żywa)       |                          |
