// sélection des boutons supprimer

let btnDelete = Array.from( document.querySelectorAll('table .btn-danger'));
console.log(btnDelete);
// sélection du bouton de confirmation de la fenêtre modale
let btnConfirmModal = document.querySelector('.modal-confirm');


// parcourir les boutons supprimer et ajouter un évènement clic

btnDelete.forEach(value => value.addEventListener('click', clickBtnDelete))



function clickBtnDelete(e){
    let href = e.target.getAttribute('href');

// définir l'attribut href du bouton de confirmation de la fenêtre modale
btnConfirmModal.setAttribute('href', href);


}