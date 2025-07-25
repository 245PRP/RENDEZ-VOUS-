// 1. Afficher la date du jour en français
function afficherDate() {
    const date = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const dateStr = date.toLocaleDateString('fr-FR', options)
                    .replace(/^./, str => str.toUpperCase()); // Première lettre en majuscule
    document.getElementById('date').textContent = dateStr;
}
afficherDate(); // Appel initial


// 2. Gestion du clic sur les liens du sidebar : changer la classe active
document.querySelectorAll('.sidebar .items a').forEach(link => {
    link.addEventListener('click', function(e) {
        // Retirer la classe 'active' de tous les liens du sidebar
        document.querySelectorAll('.sidebar .items a').forEach(a => {
            a.classList.remove('active');
        });
        // Ajouter la classe 'active' au lien cliqué
        this.classList.add('active');
    });
});


// 3. Gestion du clic sur les "Actions Rapides" : changer la classe active
document.querySelectorAll('.action-rapide__title .les-actions, .action-rapide__title .les-actions1').forEach(action => {
    action.addEventListener('click', function(e) {
        // Retirer la classe 'active' de toutes les actions
        document.querySelectorAll('.action-rapide__title .les-actions, .action-rapide__title .les-actions1')
                .forEach(a => a.classList.remove('active'));
        // Ajouter la classe 'active' à l'élément cliqué
        this.classList.add('active');
    });
});


// 4. Fonctionnalité de recherche : filtrer les rendez-vous par nom
document.querySelector('.search').addEventListener('input', function() {
    const filter = this.value.toLowerCase().trim();
    const items = document.querySelectorAll('.rendezvous .ro-body1, .rendezvous .ro-body2, .rendezvous .ro-body3, .rendezvous .ro-body4');

    items.forEach(item => {
        const nom = item.querySelector('.nom span').textContent.toLowerCase();
        if (nom.includes(filter)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
});