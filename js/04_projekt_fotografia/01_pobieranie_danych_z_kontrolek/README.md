> **Krok 1 z 3** | Start projektu. Teraz **Skrypt 1**: pobranie pliku, liczby kopii i rodzaju papieru z kontrolek formularza.

---

# Kompletny przewodnik: Skrypt 1 — pobieranie danych z kontrolek (`getElementById`, `querySelector`)

---

## SEC-1: Plik z pierwszego pola edycyjnego

Arkusz: nazwa pliku jest **ustalana z wartości pobranej z pierwszego pola edycyjnego** (`<input type="file">`).

```js
const fileInput = document.getElementById('obraz')
const selectedFile = fileInput.files[0]
if (!selectedFile) {
    alert('Wybierz plik z listy obrazów.')
    return
}
```

- **`fileInput.files[0]`** — pierwszy (i jedyny) wybrany plik z inputu typu `file`.
- `selectedFile.name` posłuży później jako nazwa pliku dla elementu obrazu.
- Brak pliku → komunikat i przerwanie działania funkcji (`return`).

---

## SEC-2: Liczba kopii

```js
const copiesInput = document.getElementById('kopie')
const copies = Number(copiesInput.value)
if (!copies || copies < 1) {
    alert('Podaj liczbę kopii (min. 1).')
    copiesInput.focus()
    return
}
```

- **`Number(copiesInput.value)`** — konwersja tekstu z inputu na liczbę.
- Walidacja: liczba kopii musi być **większa od 0**, w przeciwnym razie funkcja przerywa działanie i ustawia fokus na polu.

---

## SEC-3: Rodzaj papieru

```js
const paperOption = document.querySelector('input[name="papier"]:checked')
const paperType = paperOption ? paperOption.value : 'blyszczacy'
```

- **`querySelector('input[name="papier"]:checked')`** — pobiera zaznaczony przycisk radiowy spośród grupy `papier`.
- Jeśli z jakiegoś powodu żaden nie byłby zaznaczony, przyjmowana jest wartość domyślna `'blyszczacy'`.

---

👉 **[Krok 2: Obliczanie ceny](../02_obliczanie_ceny/README.md)**
