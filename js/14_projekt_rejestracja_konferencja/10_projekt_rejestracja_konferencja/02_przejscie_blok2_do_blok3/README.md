# Kompletny przewodnik: Drugie przejście między kartami formularza (ten sam wzorzec, inne pola)

Ten przewodnik tłumaczy **od A do Z**, jak przycisk "Następna karta" w drugim bloku formularza sprawdza pola e-mail i telefon, i dopiero wtedy przełącza widoczną kartę na trzecią.

---

## 🎯 Cel skryptu

Po kliknięciu przycisku `next2`, sprawdzić, czy pola "e-mail" i "telefon" są wypełnione. Jeśli tak — ukryć blok 2 i pokazać blok 3. Jeśli nie — wyświetlić ostrzeżenie.

> ℹ️ **Uwaga:** Ten submoduł korzysta z **tej samej** funkcji pomocniczej `showFormBlock()`, którą opisano szczegółowo w submodule 1 (`01_przejscie_blok1_do_blok2`) — w pełnym pliku `skrypt.js` funkcja ta jest zdefiniowana **tylko raz** i współdzielona przez oba przejścia.

---

## SEC-1: Nasłuchiwacz kliknięcia przycisku `next2` z walidacją pól

```javascript
document.getElementById('next2').addEventListener('click', function() {
    const email = document.getElementById('email').value;
    const telefon = document.getElementById('telefon').value;
    if (email && telefon) {
        showFormBlock('form2', 'form3');
    }
    else {
        alert('Proszę wypełnić wszystkie pola');
    }
});
```

### Jak to działa?

- Struktura tego kodu jest **niemal identyczna** jak w submodule 1 — to celowy zabieg autora skryptu, żeby zachować spójny, przewidywalny wzorzec dla każdego przejścia między kartami formularza.
- **`document.getElementById('next2').addEventListener('click', function() { ... })`** — podpinamy nasłuchiwacz kliknięcia do przycisku o `id="next2"` (przycisk "Następna karta" w **drugim** bloku, dotyczącym danych kontaktowych).
- **`const email = document.getElementById('email').value;`** (i analogicznie `telefon`) — odczytujemy wartości pól e-mail i telefonu z drugiej karty formularza.
- **`if (email && telefon) { ... }`** — dokładnie ta sama technika sprawdzania "czy pole nie jest puste" co w submodule 1: jeśli obie zmienne są niepustym tekstem (czyli wartością *truthy*), warunek jest spełniony.
- **`showFormBlock('form2', 'form3');`** — wywołujemy tę samą funkcję pomocniczą co poprzednio, ale z **innymi argumentami**: tym razem ukrywamy `form2` (kartę drugą) i pokazujemy `form3` (kartę trzecią, z hasłami).
- Jeśli którekolwiek pole jest puste — dokładnie tak samo jak w submodule 1, wyświetlane jest okienko `alert('Proszę wypełnić wszystkie pola');`.

---

## 💡 Dlaczego warto zauważyć powtarzalność tego wzorca?

Porównując submoduł 1 i submoduł 2, widać wyraźnie **ten sam szkielet kodu**, powtórzony dla różnych par pól i różnych kart:

```text
document.getElementById('nazwaPrzycisku').addEventListener('click', function() {
    const pole1 = document.getElementById('id_pola_1').value;
    const pole2 = document.getElementById('id_pola_2').value;
    if (pole1 && pole2) {
        showFormBlock('aktualna_karta', 'nastepna_karta');
    }
    else {
        alert('Proszę wypełnić wszystkie pola');
    }
});
```

To bardzo przydatny wzorzec do zapamiętania przy tworzeniu **wieloetapowych formularzy** (tzw. *multi-step forms*) — za każdym razem powtarzamy tę samą logikę: *odczytaj pola bieżącej karty → sprawdź, czy są wypełnione → jeśli tak, przełącz kartę (przez wspólną funkcję pomocniczą) → jeśli nie, ostrzeż użytkownika*.

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**       | **Co oznacza / Co robi?**                                                                     |
| ----------------------------- | ------------------------------------------------------------------------------------------------|
| Współdzielona funkcja pomocnicza | Jedna funkcja (`showFormBlock`) wywoływana z różnymi argumentami w wielu miejscach kodu, zamiast pisania osobnej logiki za każdym razem. |
| Powtarzalny wzorzec walidacji | Ten sam szkielet kodu (odczyt pól → sprawdzenie → przełączenie lub ostrzeżenie) zastosowany konsekwentnie dla każdego przejścia między kartami. |
| `if (zmienna1 && zmienna2)`     | Sprawdza, czy obie zmienne mają niepustą (prawdziwą/*truthy*) wartość.                             |
