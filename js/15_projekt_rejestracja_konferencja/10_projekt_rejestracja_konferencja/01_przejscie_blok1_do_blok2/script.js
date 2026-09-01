function showFormBlock(currentId, nextId) {
    document.getElementById(currentId).classList.remove('active');
    document.getElementById(nextId).classList.add('active');
}
document.getElementById('next1').addEventListener('click', function() {
    const imie = document.getElementById('imie').value;
    const nazwisko = document.getElementById('nazwisko').value;
    if (imie && nazwisko) {
        showFormBlock('form1', 'form2');
    }
    else {
        alert('Proszę wypełnić wszystkie pola');
    }
});
