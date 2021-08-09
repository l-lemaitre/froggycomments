<?php
	/* Chapitre 5 FrontController, ObjectModel et Override */
	class FroggyCommentsCommentsModuleFrontController extends ModuleFrontController {

		// On crée une variable public
		public $product;

		public function initContent() {
			parent::initContent();

			// On affiche le template list.tpl
			$this->setTemplate('list.tpl');

			// On récupére les paramètres id_product et module_action dans des variables (voir fichier displayProductTabContent.tpl lignes 16 et 17)
			$module_action = Tools::getValue('module_action');
			$id_product = (int)Tools::getValue('id_product');

			// On créer un tableau $actions_list contenant toutes les actions possibles et les callbacks associés
			$actions_list = array('list' => 'initList');

			// Si le paramètre id_product est valide et si l’action existe en nous basant sur le tableau $actions_list
			if($id_product > 0 && isset($actions_list[$module_action])) {
				// On initialise la variable public product avec une instance du produit affiché (Voir ligne 6)
				$this->product = new Product((int)$id_product, false, $this->context->cookie->id_lang);

				// On appelle l'action dynamiquement
				$this->$actions_list[$module_action]();
			}
		}

		protected function initList() {
	        // On appelle la méthode statique getProductNbComments de la classe FroggyComment pour récupérer le nombre de commentaires du produit (voir fichier FroggyComment.php ligne 44)
	        $nb_comments = FroggyComment::getProductNbComments($this->product->id);

			// La variable nb_per_page correspond à la valeur du nombre de lignes à afficher
			$nb_per_page = 5; //10

			// On calcul le nombre de pages total
			$nb_pages = ceil($nb_comments / $nb_per_page);

			$page = 1;

			// et on récupére la page sur laquelle se trouve le visiteur
			if(Tools::getValue('page') != '') {
				$page = (int)Tools::getValue('page');
			}

			// La variable limit_start définit à partir de quelle ligne commence la sélection de la page courante. Par défaut si $page = 1 alors $limit_start = 0, si $page = 2 alors $limit_start = (2-1)*5 = 5
			$limit_start = ($page - 1) * $nb_per_page;

			$limit_end = $nb_per_page;

			// Voir fichier FroggyComment.php ligne 51
	        $comments = FroggyComment::getProductComments($this->product->id, $limit_start, $limit_end);

			// On assigne à Smarty les commentaires et l’objet Product
			$this->context->smarty->assign('comments', $comments);
			$this->context->smarty->assign('product', $this->product);

			// On assigne à Smarty la page sur laquelle se trouve le visiteur ainsi que le nombre de pages total
			$this->context->smarty->assign('page', $page);
			$this->context->smarty->assign('nb_pages', $nb_pages);

			$this->setTemplate('list.tpl');
		}

		public function setMedia() {
			parent::setMedia();

			// On stocke le chemin du module dans une variable
			$this->path = __PS_BASE_URI__.'modules/froggycomments/';

			$this->context->controller->addCSS($this->path.'views/css/star-rating.css', 'all');
			$this->context->controller->addJS($this->path.'views/js/star-rating.js');
			$this->context->controller->addCSS($this->path.'views/css/froggycomments.css', 'all');
			$this->context->controller->addJS($this->path.'views/js/froggycomments.js');
		}
	}