Jasne — **bez zmieniania treści ani kodu**, tylko estetyczne uporządkowanie Markdown.

# Linijka 1: Produkcja wirtualnego tagu `<img>`

**JavaScript**

```javascript
const nowyObraz = document.createElement("img");
```

- **Co to robi:** Metoda `document.createElement('img')` tworzy w pamięci podręcznej (RAM) przeglądarki nowy, pusty element HTML — w tym przypadku tag obrazka `<img>`.
- **Stan w pamięci:** Powstaje „czysty szkielet”: `<img>`. Nie ma on jeszcze ustawionego pliku źródłowego ani nie jest dodany do struktury strony, więc użytkownik go nie widzi.

---

# Linijka 2: Wyciąganie nazwy pliku z inputu

**JavaScript**

```javascript
let nazwaZdjecia = inpPlik.files[0].name;
```

Oto jak rozbija się ten zapis na części:

- **`inpPlik`**: Odwołanie do elementu formularza w HTML typu `<input type="file">`.
- **`.files`**: Specjalna tablica (lista), w której przeglądarka przechowuje pliki wybrane przez użytkownika z dysku komputera.
- **`[0]`**: Indeks pierwszego wskazanego pliku (standardowo użytkownik wybiera jeden plik).
- **`.name`**: Właściwość wyciągająca samą nazwę pliku w postaci tekstu (np. `"zdjecie1.jpg"`).

---

# Linijka 3: Karmianie obrazka źródłem

**JavaScript**

```javascript
nowyObraz.src = nazwaZdjecia;
```

- **Co to robi:** Przypisujemy wyciągniętą nazwę pliku do właściwości `.src` naszego wirtualnego tagu.
- **Stan w pamięci:** Element w pamięci przyjmuje postać: `<img src="zdjecie1.jpg">`. Przeglądarka wie już, jaki plik ma załadować.

---

# Linijka 4: Montaż w bloku-rodzicu

**JavaScript**

```javascript
nowyBlok.appendChild(nowyObraz);
```

- **Co to robi:** Za pomocą metody `appendChild()` wkładamy gotowy tag `<img>` do środka innego kontenera (np. nowego bloku `div` o nazwie `nowyBlok`). Obrazek staje się „dzieckiem” tego kontenera i zostanie wyświetlony na stronie, gdy sam kontener trafi do drzewa DOM.

---

# ⚠️ Uwaga egzaminacyjna (Haczyk ze ścieżką plików)

Wybrany z pola `<input type="file">` plik przekazuje przeglądarce **wyłącznie swoją nazwę** (np. `1.jpg`), a nie pełną ścieżkę z dysku (np. `C:/Użytkownicy/.../1.jpg`) — wynika to z zabezpieczeń przeglądarek.

> **Wniosek:** Aby obrazek wyświetlił się poprawnie, wgrywane pliki graficzne muszą znajdować się **w tym samym folderze**, w którym zapisany jest plik `index.html`.

---

# Kompletny działający przykład (HTML + JS)

Oto jak połączyć te 4 linijki w działający skrypt:

**HTML**

```html
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Dynamiczne dodawanie obrazka</title>
    <style>
      .kontener {
        border: 2px dashed #888;
        padding: 15px;
        margin-top: 15px;
        background-color: #f5f5dc; /* Beżowy kontener */
      }
      .kontener img {
        max-width: 300px;
        display: block;
      }
    </style>
  </head>
  <body>
    <input type="file" id="inpPlik" />
    <button onclick="dodajZdjecie()">Dodaj zdjęcie do strony</button>

    <!-- Tutaj będą trafiać nowe bloki -->
    <div id="galeria"></div>

    <script>
      function dodajZdjecie() {
        const inpPlik = document.getElementById("inpPlik");

        // Sprawdzamy, czy użytkownik w ogóle wybrał plik
        if (inpPlik.files.length === 0) {
          alert("Wybierz najpierw plik!");
          return;
        }

        // 1. Tworzymy nowy blok-kontener dla obrazka
        const nowyBlok = document.createElement("div");
        nowyBlok.className = "kontener";

        // --- 4 LINIJKI Z INSTRUKCJI ---
        // Linijka 1: Produkcja wirtualnego tagu <img>
        const nowyObraz = document.createElement("img");

        // Linijka 2: Wyciąganie nazwy pliku z inputu
        let nazwaZdjecia = inpPlik.files[0].name;

        // Linijka 3: Karmienie obrazka źródłem
        nowyObraz.src = nazwaZdjecia;

        // Linijka 4: Montaż w bloku-rodzicu
        nowyBlok.appendChild(nowyObraz);
        // -------------------------------

        // Wstawienie gotowego bloku na stronę do elementu #galeria
        document.getElementById("galeria").appendChild(nowyBlok);
      }
    </script>
  </body>
</html>
```
