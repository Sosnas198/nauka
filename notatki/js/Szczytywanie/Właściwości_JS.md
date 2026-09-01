# 1. Fundament: Jak przeglądarka widzi stronę?

Teoria **sczytywania danych** (odczytu lub pobierania) opiera się na jednej zasadzie: **Przeglądarka internetowa jest tłumaczem.**

- **Plik HTML to tylko tekst:** Dla komputera plik HTML jest zwykłym plikiem tekstowym na dysku.
- **Tworzenie drzewa DOM:** Przeglądarka czyta ten plik i zamienia każdy tag (`<div>`, `<input>`, `<p>`) na wielki, wielopoziomowy obiekt w pamięci operacyjnej (RAM) – **drzewo DOM (Document Object Model)**.
- **Sczytywanie w czasie rzeczywistym:** Sczytywanie to proces, w którym za pomocą JavaScriptu pytasz żywy obiekt w pamięci RAM: _„Hej, co ty tam aktualnie w sobie masz?”_.

> **Przykład:** Jeśli użytkownik wpisze w puste pole `<input id="user-input">` słowo `"Kot"`, przeglądarka natychmiast aktualizuje obiekt w pamięci RAM. Wywołanie `document.querySelector('#user-input').value` zwróci `"Kot"`, ponieważ JavaScript pyta o aktualny stan aplikacji w czasie rzeczywistym, a nie czyta plik z dysku.

---

# 2. Wielki podział: Typy danych i właściwości do ich sczytywania

Przeglądarka dzieli elementy i sposoby przechowywania danych na kategorie:

## A. Dane wewnątrz struktury (Wnętrze tagu)

Dotyczy elementów strukturalnych/prezentacyjnych (`<div>`, `<p>`, `<span>`, `<h1>`, `<ul>`).

- **Cel:** Budowanie struktury i wyświetlanie treści. Mają w sobie "zamknięte" inne tagi lub tekst.
- **Sposób odczytu:** Właściwości operujące na wnętrzu elementu:
  - `.innerText` – sczytuje czysty tekst (z pominięciem tagów HTML).
  - `.innerHTML` – sczytuje lub podmienia wnętrze razem z kodem HTML (interpretuje tagi, np. `<b>`).

**HTML**

```html id="e6b2w4"
<p>To jest zawartość wewnętrzna</p>
```

## B. Dane wewnątrz metadanych (Atrybuty i stan interaktywny)

Dotyczy elementów formularzy i interaktywnych (`<input>`, `<textarea>`, `<select>`, `<img>`).

- **Cel:** Służą jako "pudełka", do których użytkownik wrzuca dane w locie, albo przechowują ścieżki/cechy w atrybutach. Nie mają tradycyjnego „wnętrza” (tagu zamykającego).
- **Sposób odczytu:**
  - `.value` – przechowuje aktualny tekst wpisany do `<input>`, `<textarea>` lub wybraną opcję z `<select>`.
  - `.checked` – właściwość logiczna (`true` / `false`) dla checkboxów i radio buttonów (mówi, czy element jest zaznaczony).
  - `.getAttribute('src')` / `.getAttribute('href')` – odczytuje ogólne atrybuty wpisane w ciało znacznika.

**HTML**

```html id="8k0b1j"
<input value="To jest atrybut" /> <img src="obrazek.jpg" />
```

---

# 3. Metody vs Właściwości

- **Metody to funkcje:** Akcje, które coś robią i posiadają nawiasy `()`, np. `.getAttribute()`, `.setAttribute()`, `.addEventListener()`.
- **Właściwości to zmienne:** Zmienne przypisane do każdego elementu w pamięci przeglądarki. Reprezentują aktualne cechy, stany lub zawartość obiektu HTML, np. `.value`, `.id`, `.className`.

---

# 4. Właściwości wyglądu (`.style`)

Właściwość `.style` sama w sobie jest obiektem zawierającym setki pod-elementów odpowiadających stylom CSS.

- **Teoria mapowania (camelCase):** Wszystkie właściwości CSS, które w klasycznym arkuszu stylów mają myślnik (np. `background-color`, `margin-top`), w obiekcie DOM są mapowane na zapis typu **camelCase**:

**JavaScript**

```javascript id="9g1q4z"
blok.style.backgroundColor = "blue";
blok.style.marginTop = "20px";
```

---

# 5. Dodawanie klas i ID do elementów HTML

Istnieje kilka sposobów na zarządzanie identyfikatorami i klasami w zależności od tego, czy chcesz zmodyfikować istniejące nazwy, czy całkowicie je zastąpić.

## 1. Dodawanie klasy przez `.classList.add()` (Metoda zalecana)

Obiekt `classList` to wbudowane narzędzie do bezpiecznego zarządzania klasami. Metoda `.add()` dopisuje nową klasę, **nie ruszając tych, które już były na elemencie**.

**JavaScript**

```javascript id="1r6m0q"
const blok = document.querySelector("#moj-blok");

// Bezpieczne dodanie jednej klasy
blok.classList.add("aktywny");

// Dodanie kilku klas naraz
blok.classList.add("klasa1", "klasa2", "klasa3");
```

- **Efekt:** Jeśli element miał wcześniej `class="box cien"`, po wykonaniu kodu będzie miał `class="box cien aktywny"`.

## 2. Dodawanie klasy przez całkowitą podmianę (`.className`)

Właściwość `.className` traktuje cały atrybut `class` jako zwykły ciąg znaków (string). Przypisanie tam wartości **kasuje wszystkie dotychczasowe klasy** i wstawia tylko nową.

**JavaScript**

```javascript id="tq3yfd"
const blok = document.querySelector("#moj-blok");

// Ustawienie klasy (wyczyści dotychczasowe klasy tego elementu!)
blok.className = "nowa-klasa";
```

- **Kiedy używać?** Gdy chcesz zrobić szybki "reset" wyglądu elementu i nadana mu ma być zupełnie nowa zestawienie klas od zera.

## 3. Dodawanie ID do elementu (`.id`)

Element w HTML może mieć tylko **jedno unikalne ID**, dlatego przypisanie polega na bezpośrednim odwołaniu się do właściwości `.id`.

**JavaScript**

```javascript id="1l8xmw"
// 1. Tworzenie nowego elementu w pamięci
const nowyParagraf = document.createElement("p");

// 2. Nadanie unikalnego ID
nowyParagraf.id = "unikalny-id-paragrafu";

// 3. Ustawienie tekstu i dodanie do strony
nowyParagraf.innerText = "Jestem nowym paragrafem z ID!";
document.body.appendChild(nowyParagraf);
```

- **Efekt w kodzie strony:** `<p id="unikalny-id-paragrafu">Jestem nowym paragrafem z ID!</p>`

## 4. Alternatywa uniwersalna: `setAttribute()`

Uniwersalne narzędzie działające bezpośrednio na atrybutach HTML:

**JavaScript**

```javascript id="b2i5vq"
const blok = document.querySelector("div");

// Dodanie lub zmiana ID
blok.setAttribute("id", "glowny-kontener");

// Dodanie KLASY (uwaga: również nadpisuje stare klasy!)
blok.setAttribute("class", "czerwone-tlo");
```
