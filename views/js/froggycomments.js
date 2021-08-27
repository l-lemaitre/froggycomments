/* JS Document
 *  @author    Ludovic Lemaître <contact@llemaitre.com>
 *  @copyright 2021 Ludovic Lemaître
 *  @license   https://github.com/l-lemaitre/froggycomments  Exemple
*/

// On vérifie si l’attribut data-scroll existe et si il est égal à true
$(document).ready(function(){
	if($('#froggycomments-content-tab').attr('data-scroll') == 'true') {
		// On fait défiler l’écran automatiquement jusqu’à la section des commentaires
		$.scrollTo('#froggycomments-content-tab', 1200);
	}
});

// On déclenche le plug-in star-rating
$(document).ready(function() {
	$(".rating").rating();
});