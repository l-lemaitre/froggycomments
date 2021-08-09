<?php
	/* Chapitre 6 Admin Controllers et hooks */
	// On ajoute un sous-onglet géré par notre module dans l’administration des produits
	class FroggyCommentsDisplayAdminProductsExtraController {
		public function __construct($module, $file, $path) {
			$this->file = $file;
			$this->module = $module;
			$this->context = Context::getContext();
			$this->_path = $path;
		}

		public function run() {
			// Récupération du nombre de commentaires
			$id_product = (int)Tools::getValue('id_product');
			$nb_comments = FroggyComment::getProductNbComments((int)$id_product);

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
			$comments = FroggyComment::getProductComments((int)$id_product, (int)$limit_start, (int)$limit_end);

			// Construction du lien Ajax
			$ajax_action_url = $this->context->link->getAdminLink('AdminModules', true);
			$ajax_action_url = str_replace('index.php', 'ajax-tab.php', $ajax_action_url);

			// On construit le lien pour les actions standard (telles que view, edit et delete)
			$action_url = $this->context->link->getAdminLink('AdminFroggyComments', true);

            // On déclare la variable customersMail
            $customersMail = "";

            $admin_customer_link = "";

            // On parcourt le tableau $comments et la valeur de l'élément courant est copié dans $comment
            foreach($comments as $comment):
				// On récupére l'adresse e-mail des clients qui ont postés un ou plusieurs commentaires parmi les résultats affichés (voir fichier FroggyComment.php ligne 79)
				$getCustomerMail = FroggyComment::getCustomerMail($comment["email"]);

				// Voir fichier FroggyComment.php ligne 86
				$getCustomerId = FroggyComment::getCustomerId($comment["email"]);

				// Si la chaîne de caractères retournée par la fonction getCustomerMail existe,
            	if($getCustomerMail) {
            		// on affecte sa valeur à la variable customerMail,
            		$customerMail = $getCustomerMail;

            		$customerId = $getCustomerId;
            	}

            	else {
            		// sinon on affecte à la variable customerMail la valeur "notFound"
            		$customerMail = "notFound";

            		$customerId = 0;
            	}

                // On affecte à la variable customersMail sa propre valeur concaténée à l'adresse e-mail du client et la chaîne de caractères ", " comme séparateur	(voir fichier displayAdminProductsExtra.tpl ligne 20)
                $customersMail = $customersMail . $customerMail . ", ";

                $admin_customer_link = $admin_customer_link . $this->context->link->getAdminLink('AdminCustomers').'&viewcustomer&id_customer='.(int)$customerId . ", ";
            endforeach;

            // On récupère la valeur de la variable customersMail en enlevant la chaîne de caractères ", " à la fin,
            $customersMail = substr($customersMail, 0, -2);

            $$admin_customer_link = substr($admin_customer_link, 0, -2);

            // puis avec la fonction explode on crée un tableau en utilisant la chaîne de caractères ", " comme séparateur et la variable customersMail comme chaîne initiale
            $customersMail = explode(", ", $customersMail);

            $admin_customer_link = explode(", ", $admin_customer_link);

			// Assignation à Smarty des commentaires et de l’objet Product
			$this->context->smarty->assign('page', $page);
			$this->context->smarty->assign('nb_pages', $nb_pages);
			$this->context->smarty->assign('comments', $comments);
			$this->context->smarty->assign('pc_base_dir', __PS_BASE_URI__ . 'modules/' . $this->module->name . '/');

			$this->context->smarty->assign('action_url', $action_url);
			$this->context->smarty->assign('ajax_action_url', $ajax_action_url);

			$this->context->smarty->assign('customersMail', $customersMail);
			$this->context->smarty->assign('admin_customer_link', $admin_customer_link);

			return $this->module->display($this->file, 'displayAdminProductsExtra.tpl');
		}
	}