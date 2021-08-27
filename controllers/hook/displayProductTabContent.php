<?php
/**
 *  @author    Ludovic Lemaître <contact@llemaitre.com>
 *  @copyright 2021 Ludovic Lemaître
 *  @license   https://github.com/l-lemaitre/froggycomments  Exemple
*/

class FroggyCommentsDisplayProductTabContentController
{
    // On crée un constructeur pour récupérer les données des variables et méthodes de la classe principale du module
    // (voir fichier froggycomments.php ligne 121)
    public function __construct($module, $file, $path)
    {
        $this->file = $file;
        $this->module = $module;
        $this->context = Context::getContext();
        $this->_path = $path;
    }

    // On déclare la méthode processProductTabContent pour stocker les notes et les commentaires dans la bdd
    public function processProductTabContent()
    {
        // Voir fichier displayProductTabContent.tpl ligne 40
        if (Tools::isSubmit('froggy_pc_submit_comment')) {
            // On récupère la variable GET correspondant à l'id du produit
            $id_product = Tools::getValue('id_product');

            // On récupère la variable POST correspondant au prénom de l'utilisateur
            $firstname = Tools::getValue('firstname');

            $lastname = Tools::getValue('lastname');
            $email = Tools::getValue('email');
            $grade = Tools::getValue('grade');
            $comment = Tools::getValue('comment');

            // On vérifie la validité des champs avant l’insertion du commentaire dans la base de données
            if (!Validate::isName($firstname) || !Validate::isName($lastname) || !Validate::isEmail($email)) {
                $this->context->smarty->assign('new_comment_posted', 'error');
                return false;
            }

            // On utilise l’ObjectModel FroggyComment pour insérer les données dans la bdd (voir fichier
            // FroggyComment.php lignes 5 à 41)
            $FroggyComment = new FroggyComment();
            $FroggyComment->id_product = (int)$id_product;
            $FroggyComment->firstname = $firstname;
            $FroggyComment->lastname = $lastname;
            $FroggyComment->email = $email;
            $FroggyComment->grade = (int)$grade;
            $FroggyComment->comment = nl2br($comment);
            $FroggyComment->add();

            // On assigne la variable new_comment_posted à Smarty pour créer une alerte quand un commentaire est posté
            $this->context->smarty->assign('new_comment_posted', 'true');
        }
    }

    // On déclare la méthode assignProductTabContent pour afficher sur la page produit les commentaires laissés par les
    // clients
    public function assignProductTabContent()
    {
        // On inclut les fichiers CSS et JS
        $this->context->controller->addCSS($this->_path . 'views/css/froggycomments.css', 'all');
        $this->context->controller->addJS($this->_path . 'views/js/froggycomments.js');

        // On inclut les fichiers CSS et JS du plug-in star-rating
        $this->context->controller->addCSS($this->_path . 'views/css/star-rating.css', 'all');
        $this->context->controller->addJS($this->_path . 'views/js/star-rating.js');

        $enable_grades = Configuration::get('FROGGY_GRADES');
        $enable_comments = Configuration::get('FROGGY_COMMENTS');

        $id_product = Tools::getValue('id_product');

        // Voir fichier FroggyComment.php ligne 51
        //$comments = FroggyComment::getProductComments($id_product, 3);

        // On initialise la variable public product avec une instance du produit affiché (Voir ligne 190, 263 et dans le
        // fichier displayProductTabContent.tpl ligne 17)
        $product = new Product((int)$id_product, false, $this->context->cookie->id_lang);

        // Voir fichier FroggyComment.php ligne 51
        $comments = FroggyComment::getProductComments($product->id, 3);

        $this->context->smarty->assign('enable_grades', $enable_grades);
        $this->context->smarty->assign('enable_comments', $enable_comments);
        $this->context->smarty->assign('product', $product);
        $this->context->smarty->assign('comments', $comments);
    }

    // On déclare la méthode run pour afficher notre module sur la fiche produit
    public function run()
    {
        $this->processProductTabContent();
        $this->assignProductTabContent();

        return $this->module->display($this->file, 'displayProductTabContent.tpl');
    }
}
