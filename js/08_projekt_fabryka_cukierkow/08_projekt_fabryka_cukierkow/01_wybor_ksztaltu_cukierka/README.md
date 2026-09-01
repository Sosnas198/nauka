> **Krok 1 z 2** | Start projektu. Teraz **Skrypt, część 1**: odczyt numeru kształtu i wypisanie treści zamówienia.

---

# Kompletny przewodnik: Skrypt (część 1) — ustalenie treści zamówienia na podstawie numeru kształtu (`if/else if/else`)

---

## Wprowadzenie — o co chodzi w tej części zadania?

Ta część skryptu odpowiada za "przetłumaczenie" liczby wpisanej przez użytkownika na czytelny tekst zamówienia. Użytkownik wpisuje w polu tekstowym numer kształtu cukierka (zgodnie z listą widoczną po prawej stronie strony: 1 – cytryna, 2 – liść, 3 – banan), a skrypt ma wyświetlić zdanie w rodzaju „Twoje zamówienie to cukierek cytryna”. Dodatkowo, jeśli użytkownik wpisze numer spoza tej listy (np. 4, 0, albo w ogóle nic), skrypt nie powinien się "wysypać" błędem, tylko pokazać sensowną odpowiedź zastępczą: „Twoje zamówienie to cukierek inny”.

To dobry przykład prostego, ale bardzo częstego wzorca programistycznego: "przetłumacz jedną wartość wejściową na odpowiadający jej tekst", zrealizowanego za pomocą serii warunków `if / else if / else`.

---

## SEC-1: Pobranie wartości z pól formularza

```js
let ksztalt = document.getElementById('ksztalt').value;
let r = document.getElementById('r').value;
let g = document.getElementById('g').value;
let b = document.getElementById('b').value;
```

Na samym początku funkcji pobieramy zawartość **wszystkich czterech** pól formularza naraz — mimo że w tej części skryptu wykorzystamy tylko zmienną `ksztalt`, a pola `r`, `g`, `b` przydadzą się dopiero w Module 2. Takie zebranie wszystkich potrzebnych danych na samej górze funkcji to częsta i wygodna praktyka — od razu widać, jakich danych funkcja w ogóle używa, bez konieczności "szukania" kolejnych wywołań `getElementById` rozsianych po całym kodzie.

- **`document.getElementById('ksztalt').value`** — pobiera tekst wpisany w polu `<input type="number" id="ksztalt">`. Podobnie jak w poprzednich projektach, mimo że pole ma typ `number`, `.value` zawsze zwraca wartość jako tekst (string), a nie liczbę.

---

## SEC-2: Ustalenie treści zamówienia na podstawie kształtu

Arkusz: skrypt sprawdza wprowadzony numer kształtu i wypisuje tekst „Twoje zamówienie to cukierek `<nazwa>`”, gdzie `<nazwa>` zależy od wartości: 1 – „cytryna”, 2 – „liść”, 3 – „banan”, inny – „inny”.

```js
let zamowienie;
if(ksztalt == '1') {
    zamowienie = 'Twoje zamówienie to cukierek cytryna';
}
else if(ksztalt == '2') {
    zamowienie = 'Twoje zamówienie to cukierek liść';
}
else if(ksztalt == '3') {
    zamowienie = 'Twoje zamówienie to cukierek banan';
}
else {
    zamowienie = 'Twoje zamówienie to cukierek inny';
}
```

- **`let zamowienie;`** — deklarujemy zmienną `zamowienie` **bez** od razu przypisywanej wartości. Zostanie ona wypełniona dopiero wewnątrz jednego z poniższych bloków `if / else if / else` — dzięki temu, niezależnie od tego, który warunek się wykona, zmienna `zamowienie` na pewno będzie miała jakąś wartość zaraz po zakończeniu tej całej struktury warunkowej.
- **`ksztalt == '1'`** — porównujemy wartość pobraną z pola (`ksztalt`, zawsze tekst) z tekstem `'1'` (zapisanym w cudzysłowie, a nie jako liczba `1`). Użycie operatora `==` (porównanie "luźne") sprawia, że nawet gdyby ktoś porównywał tekst z liczbą, JavaScript i tak dokonałby właściwego porównania — ale tutaj obie strony są tekstami, więc porównanie jest bezpośrednie i jednoznaczne.
- Kolejne warunki (`ksztalt == '2'`, `ksztalt == '3'`) działają analogicznie, sprawdzając kolejno pozostałe dwa dopuszczalne numery kształtów.
- **`else`** — ten ostatni blok "łapie" **wszystkie pozostałe przypadki**: puste pole, liczby spoza zakresu 1–3, a nawet tekst niebędący liczbą. Niezależnie od tego, co dokładnie zawiera pole `ksztalt`, jeśli nie pasuje ono do żadnej z wcześniejszych wartości, zmiennej `zamowienie` zostaje przypisany tekst „Twoje zamówienie to cukierek inny” — dokładnie zgodnie z wymaganiem arkusza dla "innej" wartości.

---

## SEC-3: Wypisanie treści zamówienia w akapicie

```js
document.getElementById('wynik').innerHTML = zamowienie;
```

Na koniec tej części skryptu wstawiamy gotowy tekst zamówienia (zbudowany w SEC-2) do wnętrza paragrafu `<p id="wynik">`, który znajduje się bezpośrednio pod przyciskiem „Zamówienie” w kodzie HTML. Używamy tu `innerHTML` — choć w tym konkretnym przypadku tekst nie zawiera żadnych znaczników HTML, `innerHTML` działa tu równie dobrze jak `textContent`, ponieważ wstawiany tekst jest zwykłym zdaniem bez specjalnych znaków wymagających interpretacji jako HTML.

Po wykonaniu tej linijki paragraf, który początkowo zawierał tylko tekst „Twoje zamówienie”, zostaje **całkowicie zastąpiony** nową treścią, np. „Twoje zamówienie to cukierek liść”.

---

👉 **[Krok 2: Ustawienie koloru przycisku](../02_ustawienie_koloru_przycisku/README.md)**
