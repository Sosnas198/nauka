# 3 główne kroki manipulacji DOM

Tworzenie i dodawanie elementów na stronę odbywa się zazwyczaj w trzech etapach:

1. **Stworzenie nowego elementu** za pomocą metody `createElement`.
2. **Skonfigurowanie go** – dodanie tekstu, klas lub atrybutów.
3. **Wstrzyknięcie go** w odpowiednie miejsce na stronie przy użyciu metod takich jak `appendChild` lub `append`.

## Konfiguracja atrybutów i stylów

* **`setAttribute`** pozwala działać bezpośrednio na kodzie HTML, wpisując nazwę atrybutu jako tekst (np. `link.setAttribute('href', '[https://google.com](https://google.com)')`). Jest uniwersalne, ale ma swoje pułapki:

  * Użycie `setAttribute('class', 'aktywny')` **nadpisze wszystkie dotychczasowe klasy** elementu (np. `box` czy `cień` zostaną usunięte). Zamiast tego do klas warto stosować właściwość `classList`.
  * Użycie `setAttribute('style', 'color: red;')` usuwa wszystkie wcześniejsze style inline. Bezpieczniej stosować nowoczesny zapis bezpośredni, np. `element.style.color = 'red'`, który zmienia tylko wybraną właściwość, pozostawiając resztę naruszoną.

## Przykład: Składanie i wstrzykiwanie bloku z obrazkiem

Poniższy skrypt tworzy element `div`, wypełnia go tekstem i obrazkiem, a następnie wkleja na sam koniec strony:

### JavaScript

```JavaScript
// 1. Tworzymy główny kontener (div) i obrazek
let blok = document.createElement('div');
let img = document.createElement('img');

// 2. Konfigurujemy obrazek oraz zawartość bloku
img.src = wybrany_file; // Przypisujemy źródło pliku
blok.innerHTML = `${numeracja} <br> ${p_tekst}`; // Wrzucamy tekst z numeracją i przełamaniem linii

// 3. Składamy elementy w całość (wstrzykujemy obrazek do div'a)
blok.appendChild(img); // Obrazek ląduje wewnątrz bloku jako jego ostatnie dziecko

// 4. Wstrzykujemy gotowy blok do struktury dokumentu (na sam koniec <body>)
document.body.appendChild(blok); // Dopiero ta linijka fizycznie renderuje element na ekranie

```

* **`appendChild()`** to wbudowana metoda służąca do „doklejania” nowego elementu dziecka na sam koniec wnętrza wskazanego rodzica.
* **`document.body.appendChild(blok)`** to kluczowy moment renderowania – dopiero w tym kroku przygotowany w pamięci RAM element pojawia się fizycznie na ekranie użytkownika (wcześniej wszystko działo się „w ukryciu”).
