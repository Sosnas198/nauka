# 🛠️ Zadanie 1: Dynamiczne dodawanie elementów do DOM (Przewodnik od A do Z)

## 📌 Treść zadania

Utwórz pusty dokument HTML. Napisz skrypt JS, który:

- Utworzy i doda do dokumentu DOM dwa przyciski (pierwszy – `"Dodaj 10 elementów do listy"`, drugi – `"Wyczyść"`).
- Utworzy i doda do dokumentu DOM listę numerowaną (`<ol>`).
- Wykorzystując "nasłuchiwanie", zdefiniuje odpowiednio zdarzenia:
  - Przycisk pierwszy po kliknięciu powinien dodać do listy numerowanej 10 jej elementów.
  - Przycisk drugi po kliknięciu wyczyści wstawione elementy listy.

---

## 🚀 Kompletny kod programu (Gotowiec)

Zanim przejdziemy do szczegółowego tłumaczenia każdego wiersza, oto jak wygląda kompletny, działający plik HTML ze skryptem JavaScript:

```html
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Zadanie 1 - Dynamiczne elementy DOM</title>
  </head>
  <body>
    <script>
      // KROK 1: Tworzenie elementów w pamięci (RAM) przeglądarki
      const btn1 = document.createElement("button");
      const btn2 = document.createElement("button");
      const ol = document.createElement("ol");

      // KROK 2: Nadawanie treści (napisów) przyciskom
      btn1.textContent = "Dodaj 10 elementów do listy";
      btn2.textContent = "Wyczyść";

      // KROK 3: Montaż w DOM – wrzucenie elementów do sekcji <body>
      document.body.appendChild(btn1);
      document.body.appendChild(btn2);
      document.body.appendChild(ol);

      // KROK 4: Podłączanie czujników (nasłuchiwanie zdarzeń 'click')
      btn1.addEventListener("click", dodaj);
      btn2.addEventListener("click", usun);

      // KROK 5: Logika funkcji dodającej 10 elementów za pomocą pętli
      function dodaj() {
        for (let i = 1; i <= 10; i++) {
          let element = document.createElement("li");
          element.textContent = "element " + i;
          ol.appendChild(element);
        }
      }

      // KROK 6: Logika funkcji czyszczącej zawartość listy
      function usun() {
        ol.innerHTML = "";
      }
    </script>
  </body>
</html>
```

---

## 🔍 Szczegółowe tłumaczenie „dla laika” krok po kroku

### Krok 1: Produkcja klocków w pamięci

### JavaScript

```JavaScript
const btn1 = document.createElement('button');
const btn2 = document.createElement('button');
const ol = document.createElement('ol');
```

- **Co to robi?** Zanim cokolwiek pojawi się na ekranie, musimy to stworzyć „w tle”. Komenda `document.createElement()` działa jak fabryka klocków.
- Przeglądarka tworzy w pamięci podręcznej (RAM) trzy wirtualne obiekty: dwa przyciski (`button`) oraz jedną listę numerowaną (`ol` – z ang. _ordered list_).
- **Stan obecny:** Te elementy już istnieją w pamięci, ale są jeszcze całkowicie puste i niewidoczne na ekranie.

### Krok 2: Nadawanie cech (Napisy na przyciskach)

### JavaScript

```JavaScript
btn1.textContent = "Dodaj 10 elementów do listy";
btn2.textContent = "Wyczyść";
```

- **Co to robi?** Skoro przyciski są już stworzone, musimy na nich coś napisać, żeby użytkownik wiedział, do czego służą. Wykorzystujemy do tego właściwość `.textContent`. Wstrzykujemy czysty tekst do środka naszych wirtualnych przycisków, dokładnie tak, jak wymaga tego zadanie egzaminacyjne.

### Krok 3: Wrzucanie klocków na stronę (Montaż w DOM)

### JavaScript

```JavaScript
document.body.appendChild(btn1);
document.body.appendChild(btn2);
document.body.appendChild(ol);
```

- **Co to robi?** Nasz kod do tej pory działał tylko „w tle”. Czas sprawić, aby użytkownik zobaczył przyciski i listę na ekranie komputera.
- Używamy metody `.appendChild()` (czyli _dodaj jako dziecko_). Mówimy przeglądarce: _"Weź główny element strony, czyli_ _`body`\*\*, i wrzuć do niego po kolei nasz pierwszy przycisk, drugi przycisk, a pod nimi pustą jeszcze listę"_. W tym momencie strona ożywa wizualnie.

### Krok 4: Podłączanie czujników (Nasłuchiwanie zdarzeń)

### JavaScript

```JavaScript
btn1.addEventListener('click', dodaj);
btn2.addEventListener('click', usun);
```

- **Co to robi?** Przyciski są już na stronie, ale klikanie w nie jeszcze nic nie robi. Musimy postawić przy nich „strażników”, którzy zareagują na akcję użytkownika.
- Metoda `addEventListener` montuje czujnik na obiekcie.
  - Pierwszy argument (`'click'`) mówi, jakiego zachowania pilnujemy.
  - Drugi argument (`dodaj` / `usun`) wskazuje nazwę funkcji, jaką komputer ma natychmiast odpalić, gdy wykryje kliknięcie.

- ⚠️ **Pamiętaj:** Nazwy funkcji podajemy **bez nawiasów** **`()`**, aby nie uruchomiły się same od razu podczas ładowania strony!

### Krok 5: Logika funkcji dodającej elementy (Pętla `for`)

Gdy użytkownik kliknie przycisk _"Dodaj 10 elementów do listy"_, program uruchamia poniższą funkcję:

### JavaScript

```JavaScript
function dodaj() {
    for (let i = 1; i <= 10; i++) {
        let element = document.createElement('li');
        element.textContent = 'element ' + i;
        ol.appendChild(element);
    }
}
```

**Jak działa ta pętla?** Działa ona jak taśma produkcyjna w fabryce, która obraca się dokładnie **10 razy** (od `i = 1` do `i = 10`):

- **Obrót 1 (`i = 1`):** Komputer tworzy wirtualny element listy `<li>`. Ustawia mu tekst: `'element ' + 1` ➡️ `"element 1"`. Następnie za pomocą `ol.appendChild(element)` wrzuca ten element do naszej listy na stronie.
- **Obrót 2 (`i = 2`):** Komputer tworzy kolejny, zupełnie nowy element `<li>`. Ustawia tekst: `'element ' + 2` ➡️ `"element 2"`. Wrzuca go do listy. Ponieważ lista `ol` sama numeruje elementy, na ekranie pojawi się automatycznie punkt `2. element 2`.
- Proces powtarza się, aż pętla wygeneruje dziesiąty element i się zatrzyma.

### Krok 6: Logika funkcji czyszczącej

Gdy użytkownik kliknie drugi przycisk (_"Wyczyść"_), odpala się funkcja sprzątająca:

### JavaScript

```JavaScript
function usun() {
    ol.innerHTML = '';
}
```

- **Co to robi?** Właściwość `.innerHTML` odpowiada za wszystko, co znajduje się _wewnątrz_ naszej listy `<ol>`. Przypisując tam pusty ciąg znaków (dwa apostrofy `''`), błyskawicznie „wymazujemy” całą zawartość. Wszystkie wygenerowane wcześniej tagi `<li>` zostają usunięte z dokumentu, a lista znowu staje się czysta i pusta.
