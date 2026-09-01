> **Krok 3 z 3** | [Krok 2](../02_walidacja_liczby_rat/README.md) upewnił się, że liczba rat jest poprawna. Teraz **Skrypt (część 3)**: obliczenie wysokości raty i wyświetlenie pełnego wyniku.

---

# Kompletny przewodnik: Skrypt (część 3) — obliczenie raty i pełny komunikat (`toFixed`)

---

## Wprowadzenie — o co chodzi w tej części zadania?

To ostatni etap całego skryptu — mamy już zarówno poprawną kwotę całkowitą (Moduł 1), jak i poprawną liczbę rat (sprawdzoną w Module 2), więc możemy w końcu policzyć, ile wynosi **jedna** rata, i wyświetlić kompletny komunikat, zawierający wszystkie cztery elementy wymagane przez arkusz: miasto, koszt całkowity, liczbę rat i wysokość jednej raty.

---

## SEC-1: Obliczenie wysokości jednej raty

Arkusz: skrypt oblicza koszt jednej raty na podstawie kwoty całkowitej — dla uproszczenia kwota całkowita jest dzielona przez podaną liczbę rat.

```js
const rata = (kwotaCalkowita / liczbaRat).toFixed(2);
```

- **`kwotaCalkowita / liczbaRat`** — zwykłe dzielenie: kwota całkowita za wybrane kursy (Moduł 1) podzielona przez liczbę rat wpisaną przez użytkownika (Moduł 1, zweryfikowana w Module 2). To dokładnie to uproszczenie, o którym mówi arkusz — nie uwzględniamy tu żadnych odsetek czy dodatkowych opłat, tylko czysty podział kwoty na równe części.
- **`.toFixed(2)`** — metoda wywoływana na liczbie, zaokrąglająca ją do podanej liczby miejsc po przecinku (tutaj: dwóch) i zwracająca wynik jako **tekst** (a nie liczbę). Jest to szczególnie ważne przy operacjach na pieniądzach — dzielenie np. `8000 / 3` dałoby wynik `2666.6666666666665` (z wieloma, niewygodnymi cyframi po przecinku), a `.toFixed(2)` "przycina" go do sensownej, finansowej postaci: `"2666.67"`.
- Wynik zapisujemy w zmiennej `rata` — to właśnie ta wartość trafi do finalnego komunikatu w SEC-2.

---

## SEC-2: Zbudowanie i wyświetlenie pełnego komunikatu

Arkusz: skrypt wyświetla pod przyciskiem w paragrafie treść „Kurs odbędzie się w `<miasto>`. Koszt całkowity: `<kwota>` zł. Płacisz `<liczba_rat>` rat po `<rata>` zł”.

```js
wynik.textContent = `Kurs odbędzie się w ${miasto}. Koszt całkowity: ${kwotaCalkowita} zł. Płacisz ${liczbaRat} rat po ${rata} zł`;
```

Podobnie jak w innych projektach, korzystamy tutaj z szablonu literału (backticki `` ` ``), żeby wygodnie "wstrzyknąć" wartości czterech różnych zmiennych bezpośrednio w tekst komunikatu:

- **`${miasto}`** — wybrane miasto z listy rozwijanej (pobrane w Module 1, SEC-1).
- **`${kwotaCalkowita}`** — obliczona suma cen wybranych kursów (Moduł 1, SEC-3).
- **`${liczbaRat}`** — liczba rat wpisana przez użytkownika, już sprawdzona jako poprawna w Module 2.
- **`${rata}`** — wysokość jednej raty, obliczona w SEC-1 powyżej.

Efektem końcowym jest kompletny komunikat, w pełni zgodny z formatem wymaganym przez arkusz, np. „Kurs odbędzie się w Katowice. Koszt całkowity: 8000 zł. Płacisz 4 rat po 2000.00 zł” — dla przypadku, gdy użytkownik zaznaczył obydwa kursy i podał 4 raty w mieście Katowice.

Warto na koniec zauważyć, jak cały skrypt, rozłożony na trzy moduły, prowadzi użytkownika przez coraz pełniejsze informacje: od komunikatu o braku wybranego kursu (Moduł 1), przez częściowy wynik bez raty (Moduł 2), aż do tego pełnego, kompletnego komunikatu — w zależności od tego, jak dużo poprawnych danych faktycznie podał.

---

🏠 **[Spis treści](../README.md)**
