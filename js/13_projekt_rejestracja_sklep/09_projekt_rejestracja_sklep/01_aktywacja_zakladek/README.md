# Kompletny przewodnik: Przełączanie zakładek formularza (jedna funkcja pomocnicza + trzy proste wywołania)

Ten przewodnik tłumaczy **od A do Z**, jak działa mechanizm przełączania trzech zakładek formularza rejestracji ("Klient", "Adres", "Kontakt") — w danym momencie widoczna jest zawsze tylko jedna z nich.

---

## 🎯 Cel skryptu

Po kliknięciu jednego z trzech przycisków zakładek, ukryć **wszystkie** bloki formularza, a następnie pokazać **tylko ten jeden**, który odpowiada klikniętemu przyciskowi.

---

## SEC-1: Funkcja pomocnicza `aktywujZakladke()` — ukryj wszystko, pokaż jedno

```javascript
function aktywujZakladke(zakladkaId) {
    document.getElementById('main1').style.display = 'none';
    document.getElementById('main2').style.display = 'none';
    document.getElementById('main3').style.display = 'none';
    document.getElementById(zakladkaId).style.display = 'block';
}
```

### Jak to działa?

- **`function aktywujZakladke(zakladkaId) { ... }`** — to jest **funkcja parametrowa**, przyjmująca jeden argument: `zakladkaId` — czyli identyfikator (`'main1'`, `'main2'` lub `'main3'`) tej **jednej** zakładki, która ma zostać pokazana.
- **`document.getElementById('main1').style.display = 'none';`** (i analogicznie dla `main2`, `main3`) — te trzy linijki **bezwarunkowo ukrywają wszystkie trzy** bloki formularza, niezależnie od tego, który z nich był wcześniej widoczny. To prosty, ale skuteczny sposób na "wyczyszczenie" stanu przed pokazaniem właściwej zakładki — zamiast sprawdzać, który blok jest aktualnie widoczny i tylko go ukrywać, po prostu ukrywamy **wszystkie**.
- **`document.getElementById(zakladkaId).style.display = 'block';`** — dopiero na końcu, korzystając z parametru `zakladkaId` przekazanego do funkcji, pokazujemy **dokładnie ten jeden** blok, który powinien być aktywny.
- Ta funkcja **sama w sobie nie jest** wywoływana bezpośrednio przez żaden przycisk — to funkcja pomocnicza (wspólna), z której korzystają trzy proste "opakowujące" funkcje opisane w SEC-2.

---

## SEC-2: Trzy proste funkcje "opakowujące" (`klient`, `adres`, `kontakt`)

```javascript
function klient() {
    aktywujZakladke('main1');
}
function adres() {
    aktywujZakladke('main2');
}
function kontakt() {
    aktywujZakladke('main3');
}
```

### Jak to działa?

- Każda z tych trzech funkcji jest **bardzo krótka** — jej jedynym zadaniem jest wywołanie funkcji pomocniczej `aktywujZakladke()` z odpowiednim identyfikatorem zakładki:
  - `klient()` woła `aktywujZakladke('main1')`,
  - `adres()` woła `aktywujZakladke('main2')`,
  - `kontakt()` woła `aktywujZakladke('main3')`.
- To właśnie te trzy funkcje są bezpośrednio podpięte pod przyciski w kodzie HTML: `<button onclick="klient()">Klient</button>`, `<button onclick="adres()">Adres</button>`, `<button onclick="kontakt()">Kontakt</button>`.
- **Dlaczego nie wywołać `aktywujZakladke()` bezpośrednio z `onclick`, np. `onclick="aktywujZakladke('main1')"`?** Obie metody działałyby technicznie tak samo, ale rozdzielenie na osobne, nazwane funkcje (`klient`, `adres`, `kontakt`) sprawia, że kod HTML jest **bardziej czytelny i opisowy** — od razu widać z nazwy funkcji, o jaką zakładkę chodzi, bez konieczności pamiętania, że np. `'main2'` odpowiada zakładce "Adres".

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**       | **Co oznacza / Co robi?**                                                                     |
| ---------------------------- | -------------------------------------------------------------------------------------------------|
| Funkcja parametrowa            | Funkcja przyjmująca argument (tu: `zakladkaId`), pozwalająca jednej funkcji obsłużyć wiele przypadków. |
| `style.display = 'none'`        | Ukrywa element — nie jest widoczny i nie zajmuje miejsca na stronie.                                |
| `style.display = 'block'`        | Pokazuje element jako blok — zajmuje normalnie miejsce na stronie.                                   |
| Funkcje "opakowujące" (wrapper) | Krótkie, proste funkcje, których jedynym zadaniem jest wywołanie innej, bardziej ogólnej funkcji z konkretnym argumentem — poprawia czytelność kodu. |
