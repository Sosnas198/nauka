> **Krok 1 z 3** | Start projektu. Teraz **Skrypt, część 1**: pobranie liczby z pola, walidacja i przygotowanie jej do konwersji.

---

# Kompletny przewodnik: Skrypt (część 1) — walidacja danych wejściowych (`isNaN`, `Math.floor`, `Math.abs`)

---

## Wprowadzenie — o co chodzi w tej części zadania?

Zanim skrypt zacznie zamieniać liczbę dziesiętną na binarną, musi się upewnić, że w polu tekstowym faktycznie znajduje się **liczba**, a nie np. pusty tekst albo coś, co liczbą nie jest. To bardzo ważny etap każdego skryptu, który pracuje z danymi wpisanymi przez użytkownika — użytkownik może przecież zostawić pole puste, wpisać litery zamiast cyfr, albo podać liczbę ujemną lub z częścią dziesiętną, której algorytm zamiany na system binarny (w wersji z arkusza) nie obsługuje wprost.

W tym module poznasz właśnie ten "etap wstępny": pobranie wartości z pola, sprawdzenie, czy to w ogóle poprawna liczba, oraz przygotowanie jej do dalszej konwersji przez zaokrąglenie w dół i pozbycie się ewentualnego znaku minus.

---

## SEC-1: Pobranie wartości z pola i elementu wynikowego

```js
let liczbaDziesietna = document.getElementById('liczba').value;
let wynikElement = document.getElementById('wynik');
```

- **`document.getElementById('liczba').value`** — pobiera aktualną zawartość pola `<input type="number" id="liczba">`, czyli tekst wpisany przez użytkownika. Zwróć uwagę, że mimo iż pole ma typ `number`, właściwość `.value` w JavaScripcie zawsze zwraca **tekst** (string) — dlatego w dalszej części kodu trzeba go jeszcze jawnie zamienić na liczbę.
- **`wynikElement`** — odniesienie do paragrafu `<p id="wynik">`, w którym docelowo wyświetlimy albo komunikat o błędzie, albo obliczoną liczbę binarną. Zapisujemy je w osobnej zmiennej na samym początku funkcji, żeby móc się do niego łatwo odwoływać w kilku miejscach dalszego kodu, bez ponownego wywoływania `getElementById`.

---

## SEC-2: Sprawdzenie poprawności wpisanej wartości

```js
if (liczbaDziesietna === "" || isNaN(liczbaDziesietna)) {
    wynikElement.innerHTML = "Proszę wpisać poprawną liczbę!";
    return;
}
```

- **`liczbaDziesietna === ""`** — sprawdza, czy pole zostało pozostawione zupełnie puste (operator `===` to porównanie "ścisłe", sprawdzające zarówno wartość, jak i typ danych — tutaj upewniamy się, że porównujemy tekst z tekstem).
- **`isNaN(liczbaDziesietna)`** — funkcja `isNaN` (od ang. "is Not a Number") sprawdza, czy podana wartość, po próbie zamiany na liczbę, **nie jest** prawidłową liczbą. Jeśli użytkownik wpisałby np. litery, `isNaN` zwróci `true`.
- **`||`** — operator logiczny "lub": cały warunek jest prawdziwy, jeśli **którykolwiek** z dwóch powyższych przypadków zachodzi (pole puste **lub** wartość nie jest liczbą).
- Jeśli warunek jest prawdziwy, funkcja wyświetla komunikat o błędzie bezpośrednio w paragrafie wyniku (`wynikElement.innerHTML = "..."`), a następnie **natychmiast kończy działanie** instrukcją `return`. Dzięki temu żaden z kolejnych kroków (zamiana na binarny, grupowanie) w ogóle się nie wykona dla niepoprawnych danych — funkcja po prostu "wychodzi" wcześniej.

---

## SEC-3: Przygotowanie liczby do konwersji

```js
let liczba = Math.floor(Math.abs(Number(liczbaDziesietna)));
```

Ta linijka wygląda na skomplikowaną, ale w rzeczywistości to trzy proste operacje wykonane jedna po drugiej, od środka na zewnątrz — czytajmy ją "od wewnątrz":

- **`Number(liczbaDziesietna)`** — zamienia tekst pobrany z pola (np. `"537"`) na rzeczywistą wartość liczbową (`537`). Dopiero od tego momentu możemy wykonywać na tej wartości operacje matematyczne, takie jak dzielenie czy reszta z dzielenia.
- **`Math.abs(...)`** — funkcja zwracająca **wartość bezwzględną** liczby, czyli "usuwająca" ewentualny znak minus (np. `Math.abs(-5)` da `5`, a `Math.abs(5)` również da `5`). Dzięki temu, nawet jeśli użytkownik wpisze liczbę ujemną, skrypt i tak przeliczy ją tak, jakby była dodatnia — algorytm zamiany na system binarny z arkusza (K1–K6) zakłada bowiem pracę na liczbach nieujemnych.
- **`Math.floor(...)`** — funkcja zaokrąglająca **w dół** do najbliższej liczby całkowitej (np. `Math.floor(3.9)` da `3`). Dzięki temu, jeśli użytkownik wpisze liczbę z częścią dziesiętną (np. `12.75`), skrypt "obetnie" tę część ułamkową i będzie pracował dalej na liczbie całkowitej — dokładnie tego wymaga algorytm z pseudokodu, operujący na dzieleniu całkowitym i reszcie z dzielenia.

Wynik tych trzech operacji zapisujemy w nowej zmiennej `liczba` — to właśnie ona będzie "zużywana" krok po kroku w pętli algorytmu zamiany na system binarny, opisanej w kolejnym module.

---

👉 **[Krok 2: Zamiana na system binarny](../02_zamiana_na_binarny/README.md)**
