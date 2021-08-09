<?php
	// On inclut le fichier FroggyComment.php contenant la classe FroggyComment
	require_once(dirname(__FILE__) . "/classes/FroggyComment.php");

	/* Chapitre 1 Créer un nouveau module */
	// On définit la classe FroggyComments à qui l'on étend la classe Module de PrestaShop
	class FroggyComments extends Module {
		// On déclare la méthode constructeur en visibilité publique pour initialiser les valeurs suivantes à chaque création d'une nouvelle instance de l'objet
		public function __construct() {
			$this->name = "froggycomments"; // Nom technique
			$this->tab = "front_office_features"; // Catégorie du module
			$this->version = "0.3.0"; // Version du module
			$this->author = "Ludovic Lemaître"; // Nom de l’auteur
			$this->bootstrap = true; // Active Bootstrap
			parent::__construct(); // Appel de la méthode parent __construct
			$this->displayName = $this->l('My Module of product comments'); // Nom public
			$this->description = $this->l('With this module, your customers will be able to grade and comments your products'); // Description du module
		}

		// On crée la méthode install pour déclarer un ou plusieurs points d'accroche
		public function install() {
			// On utilise la méthode parente install avant d’utiliser registerHook
			if(!parent::install()) {
				return false;
			}

			// On exécute la requête SQL d’installation
			$sql_file = dirname(__FILE__) . "/install/install.sql";

			// On test la valeur de retour de l'appel de la fonction loadSQLFile
			if(!$this->loadSQLFile($sql_file)) {
				// Si la méthode install d’un module retourne false PrestaShop affiche automatiquement un message d’erreur pour indiquer au marchand qu’un problème est survenu
				return false;
			}

			// Installation d’un nouvel onglet d’administration (voir ligne ?? et fichier AdminFroggyCommentsController.php)
			if(!$this->installTab('AdminCatalog','AdminFroggyComments', 'Froggy Comments')) {
				return false;
			}

			// On uilise la méthode registerHook pour accrocher notre module sur les hooks (points d’accroche) suivants
			if(!$this->registerHook('displayProductTabContent') || !$this->registerHook('displayBackOfficeHeader') || !$this->registerHook('displayAdminProductsExtra') || !$this->registerHook('displayAdminCustomers') || !$this->registerHook('ModuleRoutes')) {
				return false;
			}

			// On définit les valeurs de configuration par défaut
			Configuration::updateValue('FROGGY_GRADES', '1');
			Configuration::updateValue('FROGGY_COMMENTS', '1');

			// Installation réussie
			return true;
		}

		public function uninstall() {
			// Appel la méthode de désinstallation parente
			if(!parent::uninstall()) {
				return false;
			}

			// On exécute toutes les requêtes SQL de désinstallation
			/* $sql_file = dirname(__FILE__) . "/install/uninstall.sql";
			if(!$this->loadSQLFile($sql_file)) {
				return false;
			} */

			// Désinstallation de l’onglet d’administration
			if(!$this->uninstallTab('AdminFroggyComments')) {
				return false;
			}

			// On efface les valeurs de configuration
			Configuration::deleteByName('FROGGY_GRADES');
			Configuration::deleteByName('FROGGY_COMMENTS');

			// Désinstallation réussie
			return true;
		}

		public function loadSQLFile($sql_file) {
			// Récupération du contenu du fichier SQL
			$sql_content = file_get_contents($sql_file);

			// Remplace le préfixe dans le fichier
			$sql_content = str_replace('PREFIX_', _DB_PREFIX_, $sql_content);

			// Récupère les requêtes SQL dans un tableau
			$sql_requests = preg_split('/;\s*[\r\n]+/', $sql_content);

			// Exécute chaque requête SQL
			$result = true;
			foreach($sql_requests as $request) {
				if(!empty($request)) {
					$result &= Db::getInstance()->execute(trim($request));
				}
			}

			// Retourne le résultat
			return $result;
		}

		// On ajoute la méthode installTab pour créer un nouvel onglet dans notre panneau d’administration (voir ligne ?? et fichier AdminFroggyCommentsController.php)
		public function installTab($parent, $class_name, $name) {
			// Création d’un nouvel onglet d’administration
			$tab = new Tab();
			$tab->id_parent = (int)Tab::getIdFromClassName($parent);
			$tab->name = array();

			foreach (Language::getLanguages(true) as $lang) {
				$tab->name[$lang['id_lang']] = $name;
			}

			$tab->class_name = $class_name;
			$tab->module = $this->name;
			$tab->active = 1;

			return $tab->add();
		}

		public function uninstallTab($class_name) {
			// Récupération de l’identifiant de l’onglet d’administration
			$id_tab = (int)Tab::getIdFromClassName($class_name);

			// Chargement de l’onglet
			$tab = new Tab((int)$id_tab);

			// Suppression de l’onglet
			return $tab->delete();
		}

		// On ajoute un callback sur les boutons d'action de notre module dans le panneau d’administration
		public function onClickOption($type, $href = false) {
			$confirm_reset = $this->l('Reseting this module will delete all comments from your database, are you sure you want to reset it ?');

			$reset_callback = "return froggycomments_reset('" . addslashes($confirm_reset) . "');";

			$matchType = array(
				'reset' => $reset_callback,
				'delete' => "return confirm('" . $this->l('Confirm delete?') . "')",
			);

			if(isset($matchType[$type])) {
				return $matchType[$type];
			}

			return "";
		}

		// On crée la méthode getHookController qui sera chargée d’instancier un contrôleur de hook et de retourner l’instance
		public function getHookController($hook_name) {
			// Inclusion du fichier du contrôleur
			require_once(dirname(__FILE__) . '/controllers/hook/' . $hook_name . '.php');

			// Construction dynamique du nom du contrôleur
			$controller_name = $this->name . $hook_name . 'Controller';

			// Instanciation du contrôleur
			$controller = new $controller_name($this, __FILE__, $this->_path);

			// Retourne le contrôleur
			return $controller;
		}

		// On déclare la méthode hookDisplayProductTabContent pour appeler le contrôleur displayProductTabContent.php
		public function hookDisplayProductTabContent($params) {
			$controller = $this->getHookController('displayProductTabContent');
			return $controller->run($params);
		}

		// On déclare la méthode hookDisplayBackOfficeHeader pour appeler le contrôleur displayBackOfficeHeader.php
		public function hookDisplayBackOfficeHeader($params) {
			$controller = $this->getHookController('displayBackOfficeHeader');
			return $controller->run($params);
		}

		public function hookDisplayAdminProductsExtra($params) {
			$controller = $this->getHookController('displayAdminProductsExtra');
			return $controller->run();
		}

		public function hookDisplayAdminCustomers($params) {
			$controller = $this->getHookController('displayAdminCustomers');
			return $controller->run();
		}

		public function hookModuleRoutes() {
			$controller = $this->getHookController('moduleRoutes');
			return $controller->run();
		}

		// On déclare la méthode getContent pour ajouter des options de configuration à notre module et les afficher
		public function getContent() {
			// HOTFIX pour afficher les traductions dans la page configuration (voir fichier getContent.php lignes 34 à 75)
			$this->l('My Module configuration');
			$this->l('Enable grades :');
			$this->l('Enable grades on products.');
			$this->l('Enabled');
			$this->l('Disabled');
			$this->l('Enable comments :');
			$this->l('Enable comments on products.');
			$this->l('Save');

			// On ajoute un mini-dispatcher Ajax utilisant le paramètre ajax_hook que nous avons défini dans le fichier displayAdminProductsExtra.tpl ligne 32
			$ajax_hook = Tools::getValue('ajax_hook');
			if($ajax_hook != '') {
				$ajax_method = 'hook'.ucfirst($ajax_hook);
				if(method_exists($this, $ajax_method)) {
					die($this->{$ajax_method}(array()));
				}
			}

			$controller = $this->getHookController('getContent');
			return $controller->run();
		}
	}