// JS Document

 /* On saccroche à l’événement de clic concernant les éléments HTML qui ont la classe CSS comments-pagination-link correspondants aux 
 liens de pagination (Voir fichiers displayAdminProductsExtra.tpl ligne 32 et froggycomments.php ligne 203) */
$(document).ready(function() {
	$('.comments-pagination-link').click(function() {
		// Récupération du lien Ajax à partir de l’attribut href
		var url = $(this).attr('href');

		// Lancement de la requête Ajax
		$.ajax({
			url: url,
		}).done(function(data) {
			// On place le contenu récupéré dans la balise div dont l’identifiant est product-tab-content-ModuleFroggycomments
			$('#product-tab-content-ModuleFroggycomments').html(data);
		});

		// Retourne false pour désactiver le lien de redirection par défaut
		return false;
	});
});