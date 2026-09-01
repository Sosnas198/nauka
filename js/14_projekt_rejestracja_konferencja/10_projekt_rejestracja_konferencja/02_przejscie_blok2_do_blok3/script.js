function showFormBlock(currentId, nextId) {
    document.getElementById(currentId).classList.remove('active');
    document.getElementById(nextId).classList.add('active');
}
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
