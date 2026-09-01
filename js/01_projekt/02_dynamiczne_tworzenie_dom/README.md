# Kompletny przewodnik: Dynamiczne tworzenie i wstawianie elementów HTML (DOM) w JS

Ta ściąga wytłumaczy Ci **od A do Z** jak JavaScript potrafi w locie (już po załadowaniu strony) tworzyć nowe tagi HTML, uzupełniać je o atrybuty i przyklejać do ekranu bez odświeżania przeglądarki.

---

## SEC-1: Tworzenie szkieletu elementu w pamięci (`document.createElement`)

Zazwyczaj piszesz kod HTML na stałe w pliku. JavaScript daje jednak możliwość wyczarowania nowego tagu wirtualnie, zanim jeszcze pojawi się on na ekranie.

```javascript id="u4u7n2"
const nowyObraz = document.createElement("img");
```

### Jak to działa?

- **`document`** – odnosi się do całej struktury dokumentu HTML otwartego w przeglądarce.
- **`createElement("img")`** – wydaje polecenie systemowe: _"Stwórz w pamięci RAM komputera pusty znacznik `<img>`, ale trzymaj go na razie w ukryciu"_.
- **`const nowyObraz`** – tworzy zmienną, która staje się naszym wirtualnym placem budowy, na którym będziemy operować.

---

## SEC-2: Konfiguracja atrybutów i stylów (`src`, `alt`, `classList.add`)

Pusty tag `<img>` nie wie, co ma wyświetlić. Musimy go wyposażyć w atrybuty dokładnie tak, jakbyśmy pisali je ręcznie w pliku HTML.

```javascript id="s4y9xk"
const sciezkaObrazka = "smok.png";
nowyObraz.src = sciezkaObrazka;
nowyObraz.alt = sciezkaObrazka;
nowyObraz.classList.add("miniatury");
```

### Wyjaśnienie zapisu krok po kroku

1. **`const sciezkaObrazka = "smok.png"`** – definiujemy zmienną z nazwą pliku (którą w realnym projekcie pobraliśmy wcześniej z inputa).
2. **`nowyObraz.src = sciezkaObrazka`** – przypisuje plik graficzny do atrybutu źródłowego `src`. W pamięci komputera powstaje w tym momencie odpowiednik `<img src="smok.png">`.
3. **`nowyObraz.alt = sciezkaObrazka`** – ustawia tekst alternatywny (`alt`), dbając o standardy i dostępność strony.
4. **`nowyObraz.classList.add("miniatury")`** – dokleja do elementu klasę CSS, dzięki czemu styl z arkusza (np. ramki czy wymiary) automatycznie zacznie go dotyczyć.

> **Ważna uwaga:** W tym momencie element wciąż istnieje **tylko w pamięci RAM**. Użytkownik go jeszcze nie widzi na ekranie!

---

## SEC-3: Wklejanie elementu do drzewa dokumentu (`appendChild`)

Żeby użytkownik mógł zobaczyć nasz obrazek, musimy go fizycznie "przyczepić" do struktury strony jako dziecko wybranego elementu-rodzica.

```javascript id="9q8xva"
const galeria = document.querySelector("section");
galeria.appendChild(nowyObraz);
```

### Jak to działa?

- **`document.querySelector("section")`** – wyszukujemy na stronie znacznik `<section>`, który ma działać jak kontener (półka) na nasze obrazki.
- **`.appendChild(nowyObraz)`** – metoda ta bierze nasz przygotowany w pamięci element i wkleja go na sam koniec wnętrza wybranej sekcji. Od tej ułamka sekundy staje się on integralną częścią strony i renderuje się na ekranie.

---

# Podsumowanie przepływu danych

```text id="l9j9es"
SEC-1: const nowyObraz = document.createElement("img") — Stworzenie pustego tagu w pamięci
                 ↓
SEC-2: Ustawienie atrybutów i klasy (.src, .alt, .classList.add)
                 ↓
SEC-3: Zlokalizowanie rodzica (const galeria = document.querySelector("section"))
                 ↓
SEC-3: galeria.appendChild(nowyObraz) — Fizyczne wklejenie i wyświetlenie na stronie
```

---

# Ściągawka z najważniejszych pojęć DOM

| **Pojęcie / Metoda**           | **Co oznacza / Co robi?**                                                    |
| ------------------------------ | ---------------------------------------------------------------------------- |
| **`document.createElement()`** | Tworzy nowy, niewidoczny tag HTML w pamięci operacyjnej przeglądarki.        |
| **`.src`**                     | Odpowiada za atrybut źródłowy pliku (np. ścieżkę do obrazka).                |
| **`.alt`**                     | Ustawia tekst alternatywny wyświetlany w razie problemów z grafiką.          |
| **`.classList.add()`**         | Dodaje wybraną klasę CSS do obiektu bez ryzyka nadpisania innych klas.       |
| **`document.querySelector()`** | Wyszukuje pierwszy pasujący element na stronie przy użyciu selektorów CSS.   |
| **`.appendChild()`**           | Przenosi element z pamięci i wkleja go na koniec wnętrza wskazanego rodzica. |
