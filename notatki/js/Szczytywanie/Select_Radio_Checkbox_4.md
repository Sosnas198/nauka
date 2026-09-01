# Zadanie 1: Kosmetyka – Sumowanie zaznaczonych usług (Checkbox)

W tym zadaniu użytkownik może zaznaczyć kilka usług naraz (pilling, maska, masaż, regulacja brwi). Zamiast tworzyć osobne zmienne dla każdego pola, używamy `querySelectorAll`.

---

## Sposób 1: Sprawdzanie stanu `.checked` wewnątrz pętli `for` (Podejście klasyczne)

Pobieramy wszystkie pola `input` typu `checkbox`. W pętli sprawdzamy warunkiem `if (opcja[i].checked)`, które z nich zostały zaznaczone, i sumujemy ich wartości `value`.

### HTML

```html id="a3c5hx"
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kosmetyka - Cena wizyty</title>
</head>
<body>

    <h2>Sprawdź cenę swojej wizyty</h2>
    <input type="checkbox" id="pilling" value="45"> Piling <br>
    <input type="checkbox" id="maska" value="30"> Maska <br>
    <input type="checkbox" id="masaz" value="20"> Masaż twarzy <br>
    <input type="checkbox" id="brew" value="5"> Regulacja brwi <br>

    <button onclick="sprawdz()">Sprawdź cenę</button>
    <header id="wynik"></header>

    <script>
        function sprawdz() {
            let wynik = document.querySelector('#wynik');
            // Pobieramy wszystkie elementy <input type="checkbox"> jako listę (NodeList)
            let opcja = document.querySelectorAll('input[type="checkbox"]');
            
            let cena = 0; // Zmienna do zliczania sumy

            // Iterujemy po wszystkich pobranych checkboxach
            for (let i = 0; i < opcja.length; i++) {
                // Sprawdzamy, czy dany checkbox jest zaznaczony
                if (opcja[i].checked) {
                    // Zamieniamy tekst z atrybutu value na liczbę i dodajemy do sumy
                    cena += parseInt(opcja[i].value);
                }
            }

            // Wyświetlamy wynik na stronie
            wynik.innerHTML = "Cena zabiegów: " + cena + " zł";
        }
    </script>

</body>
</html>
```

---

## Sposób 2: Użycie pseudo-klasy `:checked` w selektorze (Podejście zoptymalizowane)

Dzięki dopisaniu pseudo-klasy `:checked` do selektora CSS (`input[type="checkbox"]:checked`), JavaScript od razu pobiera **wyłącznie te pola, które zostały zaznaczone**. Pętla `for` nie musi już sprawdzać żadnego warunku `if`.

### JavaScript

```javascript id="r8f2lz"
function sprawdz() {
    let wynik = document.querySelector('#wynik');
    // Pobieramy TYLKO te checkboxy, które są w tym momencie zaznaczone
    let opcja = document.querySelectorAll('input[type="checkbox"]:checked');
    
    let cena = 0;

    // Przechodzimy po liście, w której znajdują się wyłącznie zaznaczone elementy
    for (let i = 0; i < opcja.length; i++) {
        cena += parseInt(opcja[i].value);
    }

    wynik.innerHTML = "Cena zabiegów: " + cena + " zł";
}
```

---

# Zadanie 2: Fryzjer – Wybór długości włosów (Radio Button)

W przypadku pól typu `radio` użytkownik może wybrać w danej grupie **tylko jedną opcję** (wszystkie mają tę samą wartość atrybutu `name="wlosy"`).

### HTML

```html id="c9b7mt"
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Fryzjer - Promocja</title>
</head>
<body>

    <h3>Dziś promocja na strzyżenie włosów</h3>
    <input type="radio" name="wlosy" id="krotkie" value="25"> Krótkie <br>
    <input type="radio" name="wlosy" id="srednie" value="30"> Średnie <br>
    <input type="radio" name="wlosy" id="poldlugie" value="40"> Półdługie <br>
    <input type="radio" name="wlosy" id="dlugie" value="50"> Długie <br>

    <button onclick="sprawdz()">Odkryj promocję</button>
    <header id="wynik"></header>

    <script>
        function sprawdz() {
            let wynik = document.querySelector('#wynik');
            let opcja = document.querySelectorAll('input[name="wlosy"]');
            let opcja_konkretna = 0;

            // Szukamy jedynego zaznaczonego pola typu radio
            for (let i = 0; i < opcja.length; i++) {
                if (opcja[i].checked) {
                    opcja_konkretna = parseInt(opcja[i].value);
                }
            }

            // Wyświetlenie wyniku zgodnie ze wzorem z arkusza egzamacyjnego
            wynik.innerHTML = "Cena strzyżenia: " + opcja_konkretna + " zł";
        }
    </script>

</body>
</html>
```

---

# Tłumaczenie pojęć i teorii z pliku PDF

## 1. Jak działa `document.querySelectorAll()`?

* **`document`**: Obiekt reprezentujący cały dokument HTML.
* **`querySelectorAll('selektor')`**: Pobiera z dokumentu **wszystkie** elementy spełniające podany selektor CSS i zapisuje je w postaci listy elementów (tzw. `NodeList` - tablicopodobna struktura danych).
* Odwołanie do konkretnego elementu z listy następuje po indeksie numerowanym od zera, np. `opcja[0]`, `opcja[1]`.

---

## 2. Selektory atrybutów i Pseudo-klasy w JS/CSS

* **Selektor atrybutu** **`[atrybut="wartość"]`**: Pozwala precyzyjnie wybrać elementy HTML po ich atrybutach.

  * Zapis `input[type="checkbox"]` wskazuje wyłącznie pola wyboru (pomijając np. przyciski czy pola tekstowe).
  * Zapis `input[name="wlosy"]` wybiera tylko pola typu `radio` przynależne do grupy o nazwie `wlosy`.

* **Pseudo-klasa** **`:checked`**: Określa dynamiczny stan elementu (czy jest w danej chwili zaznaczony przez użytkownika). Możemy jej użyć w selektorze `input:checked`.

---

## 3. Dlaczego stosuje się `parseInt()` przy zliczaniu wartości?

Atrybut `value` w elementach HTML zawsze zwraca wartość typu tekstowego (`String`).

* Gdybyśmy użyli zapisu: `cena += opcja[i].value` dla wartości `"45"` i `"30"`, JavaScript dokonałby **konkatenacji** (łączenia ciągów tekstowych) i otrzymałby wynik **`"04530"`**.
* Funkcja `parseInt(opcja[i].value)` konwertuje tekst na liczbę całkowitą (`Number`), pozwalając na wykonywanie właściwego dodawania matematycznego: **`0 + 45 + 30 = 75`**.

---

## 4. Właściwość `.length` dla ciągów znaków i dla tablic

* **Dla tekstu (`String`)**: Zwraca liczbę wszystkich znaków w tekście (np. `"kot".length` zwraca `3`, a `"Ala ma kota".length` zwraca `11` ze spacjami).
* **Dla tablicy / NodeList**: Zwraca ogólną liczbę elementów znajdujących się w tablicy (np. dla 4 checkboxów `opcja.length` zwraca `4`). Pozwala to pętli `for` wykonać się dokładnie tyle razy, ile elementów znajduje się na stronie.
