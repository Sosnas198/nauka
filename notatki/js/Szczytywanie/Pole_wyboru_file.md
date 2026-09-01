# Obsługa pola wyboru pliku (`<input type="file">`) w JavaScript oraz tworzenie dynamicznych elementów

Oto wyczerpujące, krok po kroku wyjaśnienie obsługi pola wyboru pliku (`<input type="file">`) w JavaScript oraz tworzenia dynamicznych elementów na stronie HTML na podstawie załączonego materiału.

---

# Pełny kod HTML i JavaScript

Zanim przejdziemy do teorii, zobaczmy kompletny kod realizujący dodawanie obrazka ze wskazanego pliku:

## HTML

```html id="p7w3qk"
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Wybor pliku</title>
  </head>
  <body>
    <input type="file" id="plik" />
    <button onclick="dodajObrazek()">Wyświetl obrazek</button>

    <div id="blok"></div>

    <script>
      function dodajObrazek() {
        // 1. Wyszukanie pola file i bloku docelowego
        let file = document.querySelector('input[type="file"]');
        let blok = document.querySelector("#blok");

        // 2. Pobranie czystej nazwy wybranego pliku z właściwości .files
        let wybrany_file = file.files[0].name;

        // 3. Dynamiczne utworzenie nowego znacznika <img>
        let img = document.createElement("img");

        // 4. Przypisanie ścieżki (nazwy pliku) do atrybutu src obrazka
        img.src = wybrany_file;

        // 5. Wstawienie utworzonego obrazka wewnątrz bloku <div>
        blok.appendChild(img);
      }
    </script>
  </body>
</html>
```

---

# Wyjaśnienie każdej linii kodu i ważnych konceptów

## 1. Budowa pola `<input type="file">`

- **`<input>`** to podstawowy znacznik formularzy HTML.
- **`type="file"`** informuje przeglądarkę, że pole ma służyć do otwierania okna wyboru pliku z dysku komputera.
- **`name=""`** jest nazwą używaną przy tradycyjnym wysyłaniu formularzy do serwera (np. w PHP).
- **`id=""`** służy do unikalnego identyfikowania elementu i pobierania go w JavaScript za pomocą `querySelector` lub `getElementById`.

---

## 2. Kwestia bezpiecznego dostępu do pliku – Dlaczego NIE używamy `.value`?

Jeśli spróbujesz pobrać wartość pola typu `file` standardowym sposobem:

**JavaScript**

```javascript id="w7a9nc"
let nazwa = file.value;
```

Przeglądarka ze względów bezpieczeństwa zwróci ciąg znaków z tzw. **sztuczną ścieżką (fakepath)**:

**Plaintext**

```text
"C:\fakepath\obrazek.jpg"
```

Przeglądarka specjalnie ukrywa przed skryptem JavaScript prawdziwą ścieżkę na dysku użytkownika (np. czy plik był w folderze `Moje Dokumenty`, czy `Pobrane`), aby dbać o jego prywatność.

---

## 3. Jak prawidłowo odczytywać plik? (`.files[0].name`)

Domyślnie dla pól plikowych JavaScript tworzy specjalną strukturę tablicową zwaną **`FileList`**:

**JavaScript**

```javascript id="3mxz0v"
let wybrany_file = file.files[0].name;
```

Rozbicie tej linijki na kroki:

1. **`file`** – zmienna ze wskazanym polem `<input type="file">`.
2. **`.files`** – dostęp do wbudowanej szufladki (kolekcji `FileList`), w której przeglądarka umieszcza wybrane pliki.
3. **`[0]`** – ponieważ lista jest numerowana od zera, `[0]` oznacza **pierwszy wyznaczony plik**.
4. **`.name`** – wchodzi w obiekt pierwszego pliku i wyciąga wyłącznie jego **oryginalną, czystą nazwę wraz z rozszerzeniem** (np. `"zdjecie.jpg"`), pomijając przedrostek `C:\fakepath\`.

---

# 4. Tworzenie i dodawanie elementów do drzewa DOM

## `document.createElement('img')`

- Tworzy w pamięci podręcznej przeglądarki nowy, "pusty" element HTML o podanym znaczniku (w tym wypadku znacznik `<img>`).
- Element ten na tym etapie istnieje tylko w pamięci RAM – **nie jest jeszcze widoczny na stronie**.

## `img.src = wybrany_file`

- Ustawia właściwość `src` (źródło pliku graficznego) tworzonego obrazka na nazwę pliku pobraną z suwaka/pola `file`.

## `blok.appendChild(img)`

- Metoda **`appendChild()`** (z ang. _dołącz dziecko_) bierze przygotowany element (dziecko) i wstawia go na sam koniec wnętrza wybranego wcześniej kontenera Rodzica (w tym wypadku wewnątrz bloku `<div id="blok">`).
- Dopiero po wykonaniu tej linijki nowo utworzony obrazek pojawia się na ekranie komputera.
