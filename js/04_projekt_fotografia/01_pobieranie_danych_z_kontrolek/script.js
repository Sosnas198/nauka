// UNIWERSALNY WZORZEC: Skrypt 1 — pobieranie danych z kontrolek formularza
// -----------------------------------------------------------------------------

// --- KROK 1: Plik obrazu z pierwszego pola edycyjnego ---
// [ZOBACZ W README: SEC-1]
const fileInput = document.getElementById('obraz')
const selectedFile = fileInput.files[0]
if (!selectedFile) {
    alert('Wybierz plik z listy obrazów.')
    return
}

// --- KROK 2: Liczba kopii ---
// [ZOBACZ W README: SEC-2]
const copiesInput = document.getElementById('kopie')
const copies = Number(copiesInput.value)
if (!copies || copies < 1) {
    alert('Podaj liczbę kopii (min. 1).')
    copiesInput.focus()
    return
}

// --- KROK 3: Rodzaj papieru ---
// [ZOBACZ W README: SEC-3]
const paperOption = document.querySelector('input[name="papier"]:checked')
const paperType = paperOption ? paperOption.value : 'blyszczacy'
