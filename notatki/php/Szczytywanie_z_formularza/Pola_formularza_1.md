# Pola i elementy formularzy w HTML – Poradnik dla początkujących

Formularz HTML to narzędzie służące do zbierania danych od użytkownika, które najczęściej są wysyłane na serwer w celu ich dalszego przetworzenia.

## 1. Baza formularza: znacznik `<form>`

Każdy formularz zamykamy w głównym znaczniku:

### HTML

```html
<form action="akcja" method="metoda">
  <!-- tutaj wrzucamy elementy formularza -->
</form>
```

Może on przyjąć dwa ważne atrybuty:

- **`action`** – wskazuje miejsce, dokąd mają powędrować dane (np. nazwa pliku PHP, do którego wysyłamy dane, albo adres e-mail, np. `mailto:adres@domena.pl`).

- **`method`** – określa sposób wysyłania danych:
  - `method="GET"` – dołącza dane bezpośrednio do adresu URL w postaci par nazwa/wartość.

  - `method="POST"` – ukrywa dane w treści żądania HTTP, dzięki czemu nie widać ich w pasku adresu.

## 2. Podstawowe elementy (pola) formularza

Do tworzenia pól w formularzu używamy najczęściej znacznika `<input>` z odpowiednio dobranym atrybutem `type=""`.

- **Pole tekstowe** – do wpisywania zwykłego tekstu:

  ### HTML

  ```html
  <input
    type="text"
    name="imie"
    required
    minlength="2"
    maxlength="20"
    placeholder="Wpisz imię"
  />
  ```

- **Pole numeryczne** – do wpisywania cyfr i liczb:

  ### HTML

  ```html
  <input
    type="number"
    name="wiek"
    min="1"
    max="100"
    step="1"
    placeholder="Wiek"
  />
  ```

- **Pole hasła** – wpisywane znaki są automatycznie zamieniane na kropki lub gwiazdki:

  ### HTML

  ```html
  <input type="password" name="haslo" required placeholder="Hasło" />
  ```

- **Pole opcji (Radio)** – pozwala wybrać **tylko jedną** opcję z grupy:

  ### HTML

  ```html
  <input type="radio" name="plec" value="K" checked /> Kobieta
  <input type="radio" name="plec" value="Mężczyzna" /> Mężczyzna
  ```

- **Pole wyboru (Checkbox)** – pozwala zaznaczyć **wiele** niezależnych opcji:

  ### HTML

  ```html
  <input type="checkbox" name="zgoda" value="tak" checked /> Akceptuję regulamin
  ```

- **Pole pliku** – pozwala użytkownikowi wybrać plik z dysku:

  ### HTML

  ```html
  <input type="file" name="zdjecie" accept="image/png, image/jpeg" />
  ```

- **Pole ukryte (Hidden)** – niewidoczne dla użytkownika, służy do przesyłania ukrytych danych w tle:

  ### HTML

  ```html
  <input type="hidden" name="id_uzytkownika" value="123" />
  ```

- **Pole e-mail** – wymusza wpisanie poprawnego adresu e-mail:

  ### HTML

  ```html
  <input type="email" name="email" placeholder="twoj@email.pl" required />
  ```

- **Pole daty** – otwiera kalendarz do wyboru daty:

  ### HTML

  ```html
  <input
    type="date"
    name="data"
    value="2025-02-22"
    min="2025-01-01"
    max="2025-12-31"
  />
  ```

- **Pole czasu** – do wyboru godziny:

  ### HTML

  ```html
  <input
    type="time"
    name="godzina"
    min="09:00"
    max="18:00"
    value="12:00"
    required
  />
  ```

- **Pole koloru** – otwiera paletę barw:

  ### HTML

  ```html
  <input type="color" name="kolor" value="#e66465" />
  ```

- **Pole suwak (Range)** – suwak do wyboru wartości z zakresu:

  ### HTML

  ```html
  <input type="range" name="poziom" min="0" max="100" value="50" />
  ```

## 3. Listy i większe pola tekstowe

- **Lista rozwijalna (`<select>`)** – menu z opcjami do wyboru:

  ### HTML

  ```html
  <select name="miasto">
    <option value="1">Warszawa</option>
    <option value="2" selected>Kraków</option>
    <option value="3">Poznań</option>
  </select>
  ```

- **Większe pole tekstowe (`<textarea>`)** – idealne na dłuższe wiadomości czy komentarze:

  ### HTML

  ```html
  <textarea
    name="wiadomosc"
    cols="30"
    rows="5"
    placeholder="Napisz coś..."
    required
  ></textarea>
  ```

## 4. Przyciski w formularzu

- **`input type="submit"`** – główny przycisk wysyłający dane formularza do serwera (używany najczęściej w skryptach PHP):

  ### HTML

  ```html
  <input type="submit" name="wyslij" value="Send" />
  ```

- **`input type="button"`** – zwykły przycisk (zazwyczaj oprogramowany własnymi skryptami JavaScript):

  ### HTML

  ```html
  <input type="button" name="przycisk" value="kliknij" />
  ```

- **Znacznik** **`<button>`** – uniwersalny przycisk tekstowy:

  ### HTML

  ```html
  <button name="info">informacja</button>
  ```

- **`input type="reset"`** – przycisk czyszczący wszystkie pola formularza (działa prawidłowo tylko wtedy, gdy jest użyty wewnątrz znacznika `<form>`):

  ### HTML

  ```html
  <input type="reset" value="Reset" />
  ```

## 5. Przydatne atrybuty i znaczniki pomocnicze

- **Atrybut** **`readonly`** – dodany do pola sprawia, że użytkownik może je przeczytać, ale **nie może go edytować**.

- **Grupowanie elementów (`<fieldset>` i `<legend>`)** – służy do logicznego grupowania powiązanych elementów i rysuje wokół nich estetyczną ramkę z podpisem:

  ### HTML

  ```html
  <fieldset>
    <legend>Wybierz z listy</legend>
    <input type="radio" name="nazwa" value="K" /> Kobieta<br />
    <input type="radio" name="nazwa" value="S" /> Mężczyzna<br />
  </fieldset>
  ```

- **Etykieta elementu (`<label>`)** – definiuje czytelny opis dla pola. Można ją powiązać z polem na dwa sposoby:
  1. Przez zagnieżdżenie pola wewnątrz `label`:

     ### HTML

     ```html
     <label>
       Czy lubisz owoce
       <input type="checkbox" name="owoc" />
     </label>
     ```

  2. Przez atrybut `for` w `label`, który musi być dokładnie taki sam jak atrybut `id` w polu formularza:

     ### HTML

     ```html
     <label for="owoc">Czy lubisz owoce</label>
     <input type="checkbox" id="owoc" name="owoc" />
     ```
