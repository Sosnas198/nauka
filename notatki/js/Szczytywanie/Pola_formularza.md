# 1. Klasyczne pola tekstowe i wyboru

## A. Podstawowe pole tekstowe: `<input type="text">`

* **Zastosowanie:** Wprowadzanie krótkiego tekstu jednolinijkowego (np. imię, nazwisko, miasto).
* **Kluczowe atrybuty:**

  * `maxlength="ilość_znaków"` – nakłada twardy limit liczby znaków, które użytkownik może wpisać (np. `maxlength="11"` dla numeru PESEL).
  * `readonly` – pole jest widoczne, użytkownik może z niego kopiować tekst, ale **nie może go edytować**.
  * `disabled` – pole jest całkowicie wyłączone z interakcji, szare i jego wartość **nie jest wysyłana** przy zatwierdzaniu formularza.
  * `placeholder="tekst"` – szary podpowiedź wyświetlana wewnątrz pustego pola, która znika po rozpoczęciu pisania.

---

## B. Pole wieloliniowe: `<textarea>`

* **Zastosowanie:** Wprowadzanie długich wypowiedzi, uwag, treści wiadomości czy komentarzy (tekst podzielony na wiele wierszy).
* **Inna budowa:** W przeciwieństwie do pojedynczych znaczników `<input>`, `<textarea>` posiada znacznik zamykający: `<textarea></textarea>`.
* **Kluczowe atrybuty:**

  * `rows="liczba"` – określa wysokość pola w liczbie widocznych wierszy tekstu.
  * `cols="liczba"` – określa szerokość pola w liczbie widocznych kolumn (znaków).

---

## C. Lista rozwijana: `<select>` i `<select multiple>`

* **Zastosowanie:** Wybór jednej lub wielu opcji z rozwijanej listy (np. wybór kraju czy województwa).
* **Opcje:** Pojedyncze pozycje tworzymy wewnątrz za pomocą znaczników `<option value="wartość">Etykieta</option>`.
* **Warianty:**

  * `<select>` – domyślny tryb, pozwala wybrać **tylko jedną** opcję.
  * `<select multiple>` – dodanie atrybutu `multiple` umożliwia zaznaczenie **wielu pozycji naraz** (użytkownik przytrzymuje klawisz `Ctrl` lub `Cmd`).

---

## D. Pole wyboru pliku: `<input type="file">`

* **Zastosowanie:** Wybieranie plików z dysku komputera lub telefonu w celu ich przesłania na serwer (np. zdjęcie profilowe, dokument PDF).
* **Ważna cecha:** Dostaje dostęp do wbudowanej w JavaScript właściwości `.files`, która przechowuje obiekty wybranych plików.

---

## E. Ukryte pole: `<input type="hidden">`

* **Zastosowanie:** Przekazywanie niewidocznych dla użytkownika danych tekstowych w formularzu (np. ID sesji, ID produktu, unikalne tokeny zabezpieczające).
* **Działanie:** Pole to nie renderuje niczego na ekranie, ale jego atrybuty `name` i `value` są normalnie wysyłane do serwera podczas zatwierdzania formularza.

---

# 2. Pola specjalistyczne z automatyczną walidacją (HTML5)

Nowoczesne przeglądarki same sprawdzają poprawność danych w tych polach przed wysłaniem formularza.

## A. Walidacja e-maila: `<input type="email">`

* **Zastosowanie:** Pole przeznaczone do wprowadzania adresu poczty elektronicznej.
* **Automatyczna walidacja:** Przeglądarka blokuje wysłanie formularza, jeśli tekst nie pasuje do wzorca e-maila – musi zawierać znak `@`, nie może zaczynać się ani kończyć kropką itp.

---

## B. Walidacja adresu internetowego: `<input type="url">`

* **Zastosowanie:** Pole do wprowadzania adresów stron [WWW](http://WWW).
* **Automatyczna walidacja:** Wymusza na użytkowniku podanie pełnego adresu URL rozpoczynającego się od protokołu (np. `http://`, `https://` lub `ftp://`).

---

## C. Wprowadzanie liczb: `<input type="number">`

* **Zastosowanie:** Wpisywanie wyłącznie wartości numerycznych (np. wiek, ilość sztuk).
* **Kluczowe atrybuty:**

  * `min="liczba"` – minimalna dozwolona wartość.
  * `max="liczba"` – maksymalna dozwolona wartość.
  * `step="liczba"` – krok skoku wartości (np. `step="10"` powoduje, że strzałki zmieniają wartość o 10, a nie o 1).
* **Przykład:** `<input type="number" min="1" max="120" step="1">` tworzy idealne pole do wprowadzenia wieku.

---

## D. Wybór daty i godziny: `<input type="date">` oraz `<input type="time">`

* **`<input type="date">`**: Wyświetla interaktywny kalendarz umożliwiający łatwy wybór roku, miesiąca i dnia (w formacie `YYYY-MM-DD`).
* **`<input type="time">`**: Wyświetla pole ze sterownikiem do wprowadzania godziny i minut.

---

## E. Wybór koloru: `<input type="color">`

* **Zastosowanie:** Otwiera natywny próbnik/paletę kolorów systemu operacyjnego.
* **Zwracana wartość:** Przekazuje kolor w postaci ciągu znaków HEX (np. `#ff0000` dla koloru czerwonego).

---

## F. Suwak zakresu: `<input type="range">`

* **Zastosowanie:** Graficzny suwak do wyboru liczby z danego przedziału.
* **Zakres:** Domyślnie działa w przedziale od `0` do `100`, ale zasięg można modyfikować atrybutami `min` oraz `max`.

---

## G. Pole wyszukiwania: `<input type="search">`

* **Zastosowanie:** Pole tekstowe przeznaczone do budowy wyszukiwarek.
* **Zachowanie:** Niektóre przeglądarki dodają w nim mały przycisk "X" do szybkiego czyszczenia wpisanego tekstu.

---

# 3. Grupowanie elementów i obowiązkowość pól

## A. Ramki i podpisy sekcji: `<fieldset>` i `<legend>`

* **`<fieldset>`**: Otacza ramką grupę powiązanych ze sobą pól formularza (np. osobna ramka na "Dane osobowe", a osobna na "Adres dostawy").
* **`<legend>`**: Umieszcza podpis/nagłówek wcięty w górną krawędź ramki `<fieldset>`.

### Przykład użycia:

**HTML**

```html
<fieldset>
    <legend>Dane kontaktowe</legend>
    <label>E-mail: <input type="email" required></label>
</fieldset>
```

---

## B. Wymuszanie wypełnienia pola: Atrybut `required`

* **Działanie:** Dodanie atrybutu logicznego `required` do dowolnego pola (np. `<input type="email" required>`) powoduje, że przeglądarka **nie pozwoli wysłać formularza**, dopóki to pole pozostanie puste.

---

## C. Zachowanie awaryjne (Fallback)

* Jeśli starsza przeglądarka nie rozpoznaje któregoś z nowych typów (np. `type="color"` lub `type="date"`), automatycznie zamieni go na zwykłe pole tekstowe `<input type="text">`.
