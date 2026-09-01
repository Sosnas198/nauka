> **Krok 3 z 3** | [Krok 2](../02_zamiana_na_binarny/README.md) obliczył pełny zapis binarny. Teraz **Skrypt (część 3)**: podział na czteroznakowe grupy i wyświetlenie wyniku.

---

# Kompletny przewodnik: Skrypt (część 3) — grupowanie co 4 cyfry i wyświetlenie wyniku (`substring`, indeks dolny)

---

## Wprowadzenie — o co chodzi w tej części zadania?

Sama liczba binarna, obliczona w poprzednim module, to na razie jeden długi ciąg zer i jedynek — np. dla liczby 537 byłoby to `1000011001`. Taki zapis jest poprawny, ale trudny do odczytania "na oko". Dlatego arkusz wymaga, żeby liczbę binarną **podzielić spacjami na grupy po 4 cyfry, licząc od prawej strony** — dokładnie tak, jak dzielimy długie liczby dziesiętne spacjami co trzy cyfry, żeby łatwiej je odczytać (np. `1 000 000` zamiast `1000000`).

Ten moduł pokazuje, jak taki podział na grupy jest zrealizowany w pętli, a na końcu — jak wynik trafia do widocznej części strony, razem z wymaganym oznaczeniem systemu liczbowego w indeksie dolnym.

---

## SEC-1: Pętla grupująca cyfry co 4 znaki od prawej strony

Arkusz: liczba binarna jest rozdzielona spacją na części (co cztery cyfry, począwszy od prawej strony).

```js
let binarnyGrupowany = "";
for (let i = binarny.length; i > 0; i -= 4) {
    let start = Math.max(i - 4, 0);
    let grupa = binarny.substring(start, i);
    binarnyGrupowany = grupa + (binarnyGrupowany ? " " + binarnyGrupowany : "");
}
```

To najbardziej "techniczny" fragment całego skryptu, więc rozłóżmy go bardzo dokładnie, krok po kroku, na przykładzie liczby binarnej `"1000011001"` (czyli 537 w systemie dziesiętnym, 10 znaków długości).

- **`let binarnyGrupowany = ""`** — podobnie jak przy budowaniu samej liczby binarnej w poprzednim module, zaczynamy od pustego tekstu, do którego będziemy dokładać kolejne grupy cyfr.
- **`for (let i = binarny.length; i > 0; i -= 4)`** — pętla `for` z licznikiem `i`, który **zaczyna się od końca** napisu (`binarny.length`, czyli dla naszego przykładu `10`) i **maleje o 4** przy każdym obiegu (`i -= 4`), aż zejdzie do zera lub poniżej. Dzięki temu pętla "porusza się" po napisie od prawej strony do lewej, dokładnie w takich skokach, jakich potrzebujemy do podziału na czteroznakowe grupy.
- **`let start = Math.max(i - 4, 0)`** — dla każdego obiegu pętli obliczamy początek aktualnej grupy: cztery znaki przed `i`. Funkcja `Math.max(i - 4, 0)` zabezpiecza przed sytuacją, w której `i - 4` wyszłoby poniżej zera (co mogłoby się zdarzyć w **ostatnim** obiegu pętli, gdy zostało mniej niż 4 znaki do przetworzenia) — w takim wypadku po prostu bierzemy `0`, czyli sam początek napisu.
- **`let grupa = binarny.substring(start, i)`** — metoda `substring(start, i)` wycina fragment tekstu `binarny`, zaczynając od indeksu `start` (włącznie), a kończąc tuż przed indeksem `i` (czyli `i` jest wyłączone z wyniku). To właśnie ta metoda faktycznie "wykrawa" kolejną czteroznakową (lub krótszą, dla pierwszej grupy) porcję cyfr.
- **`binarnyGrupowany = grupa + (binarnyGrupowany ? " " + binarnyGrupowany : "")`** — to najbardziej "sprytna" linijka tego fragmentu. Doklejamy nowo wyciętą grupę **z przodu** dotychczasowego wyniku `binarnyGrupowany` (dokładnie tak samo jak przy budowaniu samej liczby binarnej w poprzednim module — nowe fragmenty zawsze trafiają na początek, bo przetwarzamy napis od końca). Warunek `binarnyGrupowany ? " " + binarnyGrupowany : ""` sprawdza, czy `binarnyGrupowany` nie jest jeszcze pusty:
  - Jeśli **jest** pusty (pierwszy obieg pętli, czyli najbardziej "prawa" grupa cyfr) — nie dodajemy żadnej spacji, tylko czystą grupę.
  - Jeśli **nie jest** pusty (kolejne obiegi) — przed doklejeniem nowej grupy dodajemy spację, żeby oddzielić ją od grup już zebranych po prawej stronie.

Prześledźmy to na naszym przykładzie `"1000011001"` (10 znaków):

| Obieg | `i` | `start` | `grupa` (`substring(start, i)`) | `binarnyGrupowany` po obiegu |
| ----- | --- | ------- | -------------------------------- | ------------------------------ |
| 1 | 10 | 6 | `"1001"` | `"1001"` |
| 2 | 6 | 2 | `"0001"` | `"0001 1001"` |
| 3 | 2 | 0 | `"10"` | `"10 0001 1001"` |

Widzimy, że pętla zawsze "obcina" najpierw ostatnie 4 znaki, potem kolejne 4 przed nimi, a na końcu to, co zostało (tu: tylko 2 znaki) — i za każdym razem doklejane jest to na **początek** wyniku, ze spacją jako separatorem.

---

## SEC-2: Wyświetlenie wyniku z oznaczeniem systemu binarnego

Arkusz: liczba binarna zakończona jest oznaczeniem kodu w postaci tekstu „(2)”, zapisanym w indeksie dolnym.

```js
wynikElement.innerHTML = binarnyGrupowany + ' <sub>(2)</sub>';
```

- **`wynikElement.innerHTML = ...`** — ustawiamy zawartość paragrafu wynikowego (`wynikElement`, pobranego jeszcze w Module 1) na gotowy, sformatowany tekst. Używamy tu `innerHTML` (a nie np. `textContent`), ponieważ chcemy, żeby przeglądarka **zinterpretowała** znacznik `<sub>` jako prawdziwy element HTML, a nie wyświetliła go jako zwykły, widoczny tekst.
- **`binarnyGrupowany + ' <sub>(2)</sub>'`** — łączymy pogrupowaną liczbę binarną (wynik z SEC-1) z dodatkowym fragmentem tekstu: spacją, a następnie znacznikiem `<sub>(2)</sub>`. Znacznik `<sub>` (od ang. *subscript*) sprawia, że tekst `(2)` zostanie wyświetlony jako indeks dolny — czyli mniejszy i lekko obniżony względem reszty tekstu, dokładnie tak, jak zapisuje się podstawę systemu liczbowego w matematyce (np. `1000011001₍₂₎`).

Dla naszego przykładu (liczba 537) ostateczny wynik wyświetlony na stronie to: `10 0001 1001 (2)`, gdzie fragment `(2)` jest wyświetlony w indeksie dolnym — dokładnie zgodnie z ilustracją 5 z treści zadania.

---

🏠 **[Spis treści](../README.md)**
