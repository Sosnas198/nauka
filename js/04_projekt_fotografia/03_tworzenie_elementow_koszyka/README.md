> **Krok 3 z 3** | [Krok 2](../02_obliczanie_ceny/README.md) wyliczył `totalPrice`. Teraz **Skrypt 3**: tworzenie elementów DOM i dodanie ich do koszyka.

---

# Kompletny przewodnik: Skrypt 3 — `createElement` i `appendChild` w bloku koszyka

---

## SEC-1: Kontener koszyka i wrapper pozycji

```js
const cart = document.querySelector('#prawy .skrypt')
const position = document.createElement('article')
position.className = 'pozycja'
```

- **`#prawy .skrypt`** — blok z sekcji prawej (ilustracja 4), do którego trafią kolejne pozycje zamówienia.
- Każda dodana pozycja to osobny element `<article class="pozycja">`, żeby dało się je stylować i odróżniać.

---

## SEC-2: Element DOM dla obrazu z ustaloną nazwą pliku

```js
const preview = document.createElement('img')
const previewUrl = URL.createObjectURL(selectedFile)
preview.src = previewUrl
preview.alt = selectedFile.name
preview.onload = () => URL.revokeObjectURL(previewUrl)
```

- **`URL.createObjectURL(selectedFile)`** — tworzy tymczasowy adres URL wskazujący na wybrany plik, dzięki czemu obraz można wyświetlić bez wysyłania go na serwer.
- **`selectedFile.name`** — to właśnie „ustalona nazwa pliku” z pierwszego pola edycyjnego, użyta tu jako `alt`.
- **`onload` + `revokeObjectURL`** — porządkowe zwolnienie pamięci po załadowaniu podglądu.

---

## SEC-3: Paragrafy z liczbą kopii i ceną

Arkusz: element DOM dla paragrafu z treścią „Liczba kopii: `<>`” oraz „Cena: `<>`”.

```js
const copiesInfo = document.createElement('p')
copiesInfo.textContent = `Liczba kopii: ${copies}`
const priceInfo = document.createElement('p')
priceInfo.textContent = `Cena: ${totalPrice}`
```

- Pole `<>` w pierwszym paragrafie to `copies` pobrane w Skrypcie 1.
- Pole `<>` w drugim paragrafie to `totalPrice` wyliczone w Skrypcie 2.

---

## SEC-4: Dodanie elementów do DOM

```js
position.appendChild(preview)
position.appendChild(copiesInfo)
position.appendChild(priceInfo)
cart.appendChild(position)
```

Kolejność `appendChild` odpowiada kolejności z arkusza: najpierw obraz, potem liczba kopii, na końcu cena. Cały `<article>` trafia do koszyka (`cart`) dopiero na samym końcu.

---

🏠 **[Spis treści](../README.md)**
