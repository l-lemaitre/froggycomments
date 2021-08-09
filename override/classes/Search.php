<?php
	/* Chapitre 5 FrontController, ObjectModel et Override */
	class Search extends SearchCore {
		// On crée la méthode statique find pour overrider la méthode getProducts de la classe /classes/Search.php afin d’afficher la note et le nombre de commentaires sur la liste produits lorsque le visiteur effectue une recherche
		public static function find($id_lang, $expr, $page_number = 1, $page_size = 1, $order_by = 'position', $order_way = 'desc', $ajax = false, $use_cookie = true, Context $context = null) {
			// Appel de la méthode parente
			$find = parent::find($id_lang, $expr, $page_number, $page_size, $order_by, $order_way, $ajax, $use_cookie, $context);

			// On vérifie que la variable $find contient bien des produits et que le module froggycomments est bien installé
			if(isset($find['result']) && !empty($find['result']) && Module::isInstalled('froggycomments')) {
				// Liste les ID produits
				$products = $find['result'];

				$id_product_list = array();

				foreach($products as $p) {
					$id_product_list[] = (int)$p['id_product'];
				}

		        // Voir fichier FroggyComment.php ligne 64
		        $grades_comments = FroggyComment::getInfosOnProductsList($id_product_list);

				// Association des notes et du nombre de commentaires à chaque produit
				foreach($products as $kp => $p) {
					foreach($grades_comments as $gc) {
						if($gc['id_product'] == $p['id_product']) {
							$products[$kp]['froggycomments']['grade_avg'] = round($gc['grade_avg']);
							$products[$kp]['froggycomments']['nb_comments'] = $gc['nb_comments'];
						}
					}
				}

				$find['result'] = $products;
			}

			// Retourne la liste des produits
			return $find;
		}
	}