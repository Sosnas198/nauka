# Kompletny przewodnik: Czyszczenie formularza po kliknięciu przycisku "Czyść"

Ta ściąga wytłumaczy Ci **od A do Z**, jak działa druga funkcja w tym projekcie — `czysc()` — która nie była wprost opisana w treści zadania, ale jest częścią przesłanego, gotowego kodu i odpowiada za wyczyszczenie formularza po kliknięciu przycisku `<button type="reset" onclick="czysc()">Czyść</button>`.

> **Uwaga:** Ten moduł jest dodatkiem względem głównych wymagań zadania (które opisywały tylko działanie przycisku "Wyślij") — dołączono go, ponieważ znajduje się w przesłanym pliku `skrypt.js` i jest częścią kompletnego, działającego rozwiązania.

---

## SEC-1: Wyczyszczenie pól tekstowych (`.value = ""`)

```javascript
document.getElementById("imie").value = "";
document.getElementById("nazwisko").value = "";
document.getElementById("email").value = "";
```

### Jak to działa?

- W module 01 uczyliśmy się, jak **odczytać** wartość pola formularza przez `.value`. Tutaj robimy coś odwrotnego: **ustawiamy** `.value` na nową wartość — konkretnie na pusty tekst `""`.
- **`document.getElementById("imie").value = "";`** – wyszukuje pole `id="imie"` i czyści je, wstawiając w jego miejsce pusty tekst. Dla użytkownika wygląda to tak, jakby pole formularza nagle "opróżniło się" ze wszystkiego, co wcześniej wpisał.
- Dokładnie tak samo czyścimy pola `nazwisko` i `email`.
- Ta linijka **nie tworzy** żadnej nowej zmiennej — od razu, w jednej instrukcji, wyszukujemy element i modyfikujemy jego właściwość `.value`.

---

## SEC-2: Przywrócenie domyślnej wartości listy rozwijanej

```javascript
document.getElementById("zgloszenie").value = "naprawa komputerów";
```

### Jak to działa?

- Lista rozwijana `<select id="zgloszenie">` nie ma pola tekstowego do "opróżnienia" — zawsze musi mieć **jakąś** wybraną opcję. Dlatego zamiast ustawiać `.value` na pusty tekst, ustawiamy go z powrotem na wartość **pierwszej, domyślnej opcji** z listy: `"naprawa komputerów"` (dokładnie tę samą, która jest pierwsza w kolejności w znaczniku `<select>` w pliku HTML).
- Dzięki temu po kliknięciu "Czyść" formularz wraca do swojego stanu początkowego — pola tekstowe są puste, a lista rozwijana ponownie pokazuje pierwszą opcję.

> **Ciekawostka:** Przycisk "Czyść" ma w HTML atrybut `type="reset"`, który **sam w sobie** potrafiłby wyczyścić formularz bez żadnego JavaScriptu — to wbudowana funkcja przeglądarki dla formularzy. Mimo to w tym projekcie dodatkowo podpięto własną funkcję `czysc()` przez `onclick`, żeby mieć **pełną kontrolę** nad tym, co dokładnie się czyści (np. gdyby formularz miał więcej pól, których nie chcielibyśmy resetować).

---

# Podsumowanie przepływu danych

```text
SEC-1: document.getElementById("imie"/"nazwisko"/"email").value = ""
       — Wyczyszczenie trzech pól tekstowych formularza
                 ↓
SEC-2: document.getElementById("zgloszenie").value = "naprawa komputerów"
       — Przywrócenie domyślnej, pierwszej opcji na liście rozwijanej
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Metoda**              | **Co oznacza / Co robi?**                                                        |
| ------------------------------------- | -------------------------------------------------------------------------------------- |
| **`element.value = "nowa_wartosc"`**   | Ustawia nową wartość pola formularza (w odróżnieniu od samego odczytu `.value`).       |
| **`type="reset"` (przycisk)**          | Wbudowany w przeglądarkę mechanizm czyszczenia formularza, tu dodatkowo wspomagany własną funkcją. |
