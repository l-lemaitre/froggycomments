<?php
/**
 *  @author    Ludovic Lemaître <contact@llemaitre.com>
 *  @copyright 2021 Ludovic Lemaître
 *  @license   https://github.com/l-lemaitre/froggycomments  Exemple
*/

class FroggyCommentsModuleRoutesController
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

    // On déclare la méthode run pour réecrire l'url permettant au visiteur d’accéder à la page contenant tout les
    // commentaires d'un produit en maintenant la compatibilité avec l’option des URL simplifiées
    public function run()
    {
        return array(
            'module-froggycomments-comments' => array(
                'controller' => 'comments',
                'rule' => 'product-comments{/:module_action}{/:product_rewrite}{/:id_product}/page{/:page}',
                'keywords' => array(
                    'module_action' => array('regexp' => '[\w]+', 'param' => 'module_action'),
                    'product_rewrite' => array('regexp' => '[\w-_]+', 'param' => 'product_rewrite'),
                    'id_product' => array('regexp' => '[\d]+', 'param' => 'id_product'),
                    'page' => array('regexp' => '[\d]+', 'param' => 'page')
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'froggycomments',
                    'controller' => 'comments'
                )
            )
        );
    }
}
