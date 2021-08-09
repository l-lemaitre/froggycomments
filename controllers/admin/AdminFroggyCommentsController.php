<?php
	/* Chapitre 6 Admin Controllers et hooks */
	// On crée le contrôleur AdminFroggyCommentsController qui étend la classe ModuleAdminController pour lister les commentaires dans notre AdminController
	class AdminFroggyCommentsController extends ModuleAdminController {
		public function __construct() {
			// Définition des variables
			$this->table = "froggy_comment";
			$this->className = "FroggyComment";
			$this->fields_list = array(
				'id_froggy_comment' => array('title' => $this->l('ID'), 'align' => 'center',
				'width' => 25),
				'product_name' => array('title' => $this->l('Product'),'width' => 100, 'filter_key' => 'pl!name'),
				'firstname' => array('title' => $this->l('Firstname'), 'width' => 120),
				'lastname' => array('title' => $this->l('Lastname'), 'width' => 140),
				'email' => array('title' => $this->l('email'), 'width' => 150),
				'grade_display' => array('title' => $this->l('Grade'), 'align' => 'right', 'width' => 80, 'filter_key' => 'a!grade'),
				'comment' => array('title' => $this->l('Comment'), 'search' => false),
				'date_add' => array('title' => $this->l('Date add'), 'type' => 'date'),
			);

			// Définition des champs du formulaire
			$this->context = Context::getContext();

			$this->context->controller = $this;

			$this->fields_form = array(
				'legend' => array(
					'title' => $this->l('Add / Edit Comment'),
					'image' => '../img/admin/contact.gif'
				),
				'input' => array(
					array('type' => 'text', 'label' => $this->l('Firstname'), 'name' => 'firstname', 'size' => 30, 'required' => true),
					array('type' => 'text', 'label' => $this->l('Lastname'), 'name' => 'lastname', 'size' => 30, 'required' => true),
					array('type' => 'text', 'label' => $this->l('email'), 'name' => 'email', 'size' => 30, 'required' => true),
					array('type' => 'select', 'label' => $this->l('Product'), 'name' => 'id_product', 'required' => true, 'default_value' => 1, 'options' => array('query' => Product::getProducts($this->context->cookie->id_lang, 0, 1000, 'name', 'ASC'), 'id' => 'id_product', 'name' => 'name')),
					array('type' => 'text', 'label' => $this->l('Grade'), 'name' => 'grade', 'size' => 30, 'required' => true, 'desc' => $this->l('Grade must be between 1 and 5')),
					array('type' => 'textarea', 'label' => $this->l('Comment'), 'name' => 'comment', 'cols' => 50, 'rows' => 5, 'required' => false)
				),
				'submit' => array('title' => $this->l('Save'))
			);

			// Activation de Bootstrap
			$this->bootstrap = true;

			// Appel de la méthode parente du constructeur
			parent::__construct();

			// On effectue la requête suivante pour récupérer le nom du produit et améliorer l’affichage de la note. Alias de la classe AdminController = a, alias de la table product_lang = pl
			$this->_select = "pl.`name` as product_name, CONCAT(a.`grade`, '/5') as grade_display";
			$this->_join = 'LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pl.`id_product` = a.`id_product` AND pl.`id_lang` = '.(int)$this->context->language->id.')';

			// On utilise la méthode addRowAction pour effectuer les actions lire, modifier et effacer
			$this->addRowAction('view');
			$this->addRowAction('edit');
			$this->addRowAction('delete');

			// On définit la variable bulk_actions qui contient un tableau des différentes actions disponibles
			$this->bulk_actions = array(
				'delete' => array(
					'text' => $this->l('Delete selected'),
					'confirm' => $this->l('Would you like to delete the selected items ?')
				),
				'showVar' => array(
					'text' => $this->l('Variable display'),
					'confirm' => $this->l('Are you sure ?')
				)
			);

			// On définit la variable meta_title pour afficher le nom de la section dans l'onglet du navigateur
			$this->meta_title = $this->l('Comments on products');

			// On vérifie si la clé viewfroggy_comment existe dans les variables $_POST ou $_GET en utilisant la méthode Tools::getIsset pour afficher dans le titre l’identifiant du commentaire
			if(Tools::getIsset('viewfroggy_comment')) {
				$this->meta_title = $this->l('Comment') . ' #' . Tools::getValue('id_froggy_comment');
			}

			// On affiche le titre de la page dans la barre d’outils
			$this->toolbar_title[] = $this->meta_title;
		}

		// On crée la méthode protégée processBulkMyAction pour stocker les identifiants des objets sélectionnés dans la variable $this->boxes
		protected function processBulkshowVar() {
			Tools::dieObject($this->boxes);
		}

		// On override la méthode renderView pour retourner notre propre template pour cette vue (voir fichier view.tpl)
		public function renderView() {
			$tpl = $this->context->smarty->createTemplate(dirname(__FILE__).'/../../views/templates/admin/view.tpl');

			// On assigne l’ObjectModel froggycomment à Smarty pour afficher les détails du commentaire sélectionné
			$tpl->assign('froggycomment', $this->object);

			// On appelle la méthode loadProductName pour remplir la variable $product_name (voir fichier FroggyComment.php lignes 71 à 78)
			$this->object->loadProductName();

			$this->page_header_toolbar_btn;

			// Construction du lien de suppression
			$admin_delete_link = $this->context->link->getAdminLink('AdminFroggyComments') . '&deletefroggy_comment&id_froggy_comment=' . (int)$this->object->id;

			// Ajout du bouton de suppression dans la barre d’outils
			$this->page_header_toolbar_btn['delete'] = array(
				'href' => $admin_delete_link,
				'desc' => $this->l('Delete it'),
				'icon' => 'process-icon-delete',
				'js' => "return confirm('".$this->l('Are you sure you want to delete it ?')."');",
			);

			// Construction du lien d’administration du produit
			$admin_product_link = $this->context->link->getAdminLink('AdminProducts').'&updateproduct&id_product='.(int)$this->object->id_product.'&key_tab=ModuleFroggycomments';

			// Si l’auteur est connu comme étant un client, nous construisons le lien d’administration du client
			$admin_customer_link = "";
			$customers = Customer::getCustomersByEmail($this->object->email);
			if(isset($customers[0]['id_customer'])) {
				$admin_customer_link = $this->context->link->getAdminLink('AdminCustomers').'&viewcustomer&id_customer='.(int)$customers[0]['id_customer'];
			}

			$tpl->assign('admin_product_link', $admin_product_link);
			$tpl->assign('admin_customer_link', $admin_customer_link);

			return $tpl->fetch();
		}
	}