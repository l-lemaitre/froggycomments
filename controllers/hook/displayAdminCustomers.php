<?php
	/* Chapitre 6 Admin Controllers et hooks */
	// On ajoute un sous-onglet géré par notre module dans l’administration des produits
	class FroggyCommentsDisplayAdminCustomersController {
		public function __construct($module, $file, $path) {
			$this->file = $file;
			$this->module = $module;
			$this->context = Context::getContext();
			$this->_path = $path;
		}

		public function run() {
			// Récupération du nombre de commentaires
			$id_customer = (int)Tools::getValue('id_customer');
        	$customer = new Customer($id_customer);
			$nb_comments = FroggyComment::getCustomerNbComments($customer->email);

			// Initialisation
			$page = 1;

			$nb_per_page = 5; //20

			$nb_pages = ceil($nb_comments / $nb_per_page);

			if(Tools::getIsset('page') && (int)Tools::getValue('page') > 0) {
				$page = (int)Tools::getValue('page');
			}

			$limit_start = ($page - 1) * $nb_per_page;

			$limit_end = $nb_per_page;

			// Récupération des commentaires
			$comments = FroggyComment::getCustomerComments($customer->email, (int)$limit_start, (int)$limit_end);

			// On utilise la fonction getAdminLink pour fournit la base de l’URL du produit (voir dichier displayAdminCustomers.tpl ligne 22)
        	$admin_product_link = $this->context->link->getAdminLink('AdminProducts', true);

			// Assignation à Smarty des commentaires
			$this->context->smarty->assign('page', $page);
			$this->context->smarty->assign('nb_pages', $nb_pages);
			$this->context->smarty->assign('comments', $comments);

        	$this->context->smarty->assign('admin_product_link', $admin_product_link);

			return $this->module->display($this->file, 'displayAdminCustomers.tpl');
		}
	}