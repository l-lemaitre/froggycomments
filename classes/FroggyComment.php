<?php
	/* Chapitre 5 FrontController, ObjectModel et Override */
	class FroggyComment extends ObjectModel {
		// On crée une variable publique pour chaque champ de la table relative à l’objet
		public $id_froggy_comment;
		public $id_product;
		public $firstname;
		public $lastname;
		public $email;
		public $grade;
		public $comment;
		public $date_add;

		/**
		* @see ObjectModel::$definition
		*/

		// On écrit le tableau de définitions
		public static $definition = array(
			'table' => 'froggy_comment',
			'primary' => 'id_froggy_comment',
			'multilang' => false,
			'fields' => array(
				'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
				'firstname' => array('type' => self::TYPE_STRING, 'validate' => 'isNameNotempty', 'size' => 20, 'required' => true),
				'lastname' => array('type' => self::TYPE_STRING, 'validate' => 'isNameNotempty', 'size' => 20, 'required' => true),
				'email' => array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true),
				'grade' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
				'comment' => array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'required' => true),
				'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false, 'required' => true)
			)
		);

		// On crée la méthode statique getProductNbComments pour récupérer le nombre de commentaires du produit (voir fichier comments.php ligne 36)
		public static function getProductNbComments($id_product) {
			$nb_comments = Db::getInstance()->getValue('SELECT COUNT(`id_product`) FROM `' . _DB_PREFIX_ . 'froggy_comment` WHERE `id_product` = ' . (int)$id_product);

			return $nb_comments;
		}

		// On récupére les commentaires du produit (voir fichiers froggycomments.php ligne 186 et comments.php ligne 60)
		public static function getProductComments($id_product, $limit_start, $limit_end = false) {
			$limit = (int)$limit_start;

			if($limit_end) {
				$limit = (int)$limit_start . ',' . (int)$limit_end;
			}

			$comments = Db::getInstance()->executeS('SELECT * FROM `' . _DB_PREFIX_ . 'froggy_comment` WHERE `id_product` = ' . (int)$id_product . ' ORDER BY `date_add` DESC LIMIT ' . $limit);

			return $comments;
		}

		// Voir fichier displayAdminCustomers.php ligne 16
	    public static function getCustomerNbComments($email) {
	        $nb_comments = Db::getInstance()->getValue('SELECT COUNT(`id_product`) FROM `' . _DB_PREFIX_ . 'froggy_comment` WHERE `email` = \'' . pSQL($email) . '\'');

	        return $nb_comments;
	    }

		// Voir fichier displayAdminCustomers.php ligne 34
	    public static function getCustomerComments($email, $limit_start, $limit_end = false) {
	        $limit = (int)$limit_start;

	        if($limit_end) {
	            $limit = (int)$limit_start . ',' . (int)$limit_end;
	        }

	        $comments = Db::getInstance()->executeS('SELECT pc.*, pl.`name` as product_name FROM `' . _DB_PREFIX_ . 'froggy_comment` pc LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (
					pl.`id_product` = pc.`id_product` AND
					pl.`id_lang` = ' . (int)Context::getContext()->language->id . '
				)
				WHERE pc.`email` = \'' . pSQL($email) . '\' ORDER BY pc.`date_add` DESC LIMIT ' . $limit);

	        return $comments;
	    }

		// Voir fichier displayAdminProductsExtra.php ligne 52
	    public static function getCustomerMail($email) {
	        $customerMail = Db::getInstance()->getValue('SELECT `email` FROM `' . _DB_PREFIX_ . 'customer` WHERE `email` = \'' . pSQL($email) . '\'');

	        return $customerMail;
	    }

		// Voir fichier displayAdminProductsExtra.php ligne 54
		public static function getCustomerId($email) {
	        $customerId = Db::getInstance()->getValue('SELECT `id_customer` FROM `' . _DB_PREFIX_ . 'customer` WHERE `email` = \'' . pSQL($email) . '\'');

	        return $customerId;
		}

		// On récupére la moyenne des notes et le nombre de commentaires des produits (voir fichier Search.php ligne 24)
		public static function getInfosOnProductsList($id_product_list) {
			$grades_comments = Db::getInstance()->executeS('SELECT `id_product`, AVG(`grade`) as grade_avg, count(`id_froggy_comment`) as nb_comments FROM `' . _DB_PREFIX_ . 'froggy_comment` WHERE `id_product` IN (' . implode(',', $id_product_list) . ') GROUP BY `id_product`');

			return $grades_comments;
		}

		// On crée une variable $product_name dans la classe FroggyComment (de type ObjectModel)
		public $product_name;

		// On crée une méthode pour récupérer le nom du produit
		public function loadProductName() {
			$product = new Product($this->id_product, true, Context::getContext()->cookie->id_lang);

			$this->product_name = $product->name;
		}
	}