let postepWartosc = 0;
function aktualizujPostep() {
    if (postepWartosc < 100) {
        postepWartosc += 12;
        if (postepWartosc > 100) {
            postepWartosc = 100;
        }
        document.querySelector('#postep > div').style.width = postepWartosc + '%';
    }
}
document.querySelectorAll('input[type="text"], input[type="date"], input[type="number"], input[type="tel"]').forEach(function (input) {
    input.addEventListener('blur', aktualizujPostep);
});
