# Kompletny przewodnik: Wybór zdjęcia po kliknięciu miniatury (`indexOf`)

Ta ściąga wytłumaczy Ci **od A do Z**, jak JavaScript ustala, które zdjęcie ma stać się aktywne, gdy użytkownik kliknie bezpośrednio na jedną z pięciu miniatur — a nie na przycisk "next"/"prev".

---

## SEC-1: Ustalenie indeksu klikniętego zdjęcia (`changeImage`, `indexOf`)

```javascript
function changeImage(imageName) {
    currentImageIndex = imageArray.indexOf(imageName);
    updateImage();
}
```

### Jak to działa?

- **`function changeImage(imageName) { ... }`** – ta funkcja, podobnie jak `widocznosc(id)` z poprzedniego projektu, przyjmuje **parametr** — tutaj `imageName`, czyli nazwę pliku klikniętej miniatury.
- Spójrz na HTML: każda miniatura ma swój `onclick`, np. `<img src="3.jpg" class="miniatura" onclick="changeImage('3.jpg')">`. Kliknięcie tej konkretnej miniatury wywołuje `changeImage('3.jpg')`, przekazując tekst `'3.jpg'` jako wartość `imageName`.
- **`imageArray.indexOf(imageName)`** – **`indexOf(...)`** to metoda wbudowana w każdą tablicę, która **przeszukuje ją** w poszukiwaniu podanej wartości i zwraca **indeks (numer pozycji)**, na którym ta wartość się znajduje. Jeśli np. `imageName` to `'3.jpg'`, a tablica `imageArray` to `['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg']`, to `indexOf('3.jpg')` zwróci `2` (bo `'3.jpg'` jest na trzeciej pozycji, czyli pod indeksem `2` — liczonym od zera).
- **`currentImageIndex = ...`** – wynik działania `indexOf` zapisujemy z powrotem do naszej globalnej zmiennej `currentImageIndex` (tej samej z modułu 01). Od tego momentu program "wie", że to właśnie kliknięte zdjęcie jest teraz aktywne.
- **`updateImage();`** – tak jak w poprzednim module, na końcu wywołujemy funkcję odświeżającą wyświetlany obraz (moduł 04), żeby efekt kliknięcia miniatury faktycznie było widać na dużym zdjęciu.

> **Dlaczego to jest sprytne rozwiązanie?** Zamiast np. sprawdzać po kolei pięcioma warunkami `if`, które zdjęcie zostało kliknięte (`if (imageName === '1.jpg') ... else if (imageName === '2.jpg') ...`), metoda `indexOf()` robi to **automatycznie, w jednej linijce**, niezależnie od tego, ile zdjęć znajduje się w tablicy `imageArray`. Gdyby galeria miała np. 20 zdjęć zamiast 5, ten kod działałby dokładnie tak samo, bez żadnych zmian.

> **To jest też trzecia funkcja z wymagań zadania:** *"Po kliknięciu na miniaturę, aktywnym zdjęciem staje się to kliknięte"*. Razem z `prevImage()` i `nextImage()` z modułu 02, to właśnie te trzy funkcje (`prevImage`, `nextImage`, `changeImage`) odpowiadają za **trzy sposoby nawigacji** wspomniane w treści zadania — a wspólna dla nich wszystkich jest funkcja pomocnicza `updateImage()` z modułu 04, która faktycznie pokazuje wynik na ekranie.

---

# Podsumowanie przepływu danych

```text
SEC-1: changeImage(imageName)
       currentImageIndex = imageArray.indexOf(imageName)
       updateImage()
       — Odnalezienie indeksu klikniętej miniatury i ustawienie jej jako aktywnej
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Metoda**    | **Co oznacza / Co robi?**                                                       |
| ---------------------------- | ---------------------------------------------------------------------------------- |
| **parametr funkcji**          | Zmienna, której wartość jest przekazywana z zewnątrz, w momencie wywołania funkcji. |
| **`array.indexOf(wartosc)`**  | Zwraca indeks (pozycję) pierwszego wystąpienia podanej wartości w tablicy.          |
