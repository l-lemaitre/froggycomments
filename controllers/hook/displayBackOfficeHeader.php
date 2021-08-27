<?php
/**
 *  @author    Ludovic Lemaître <contact@llemaitre.com>
 *  @copyright 2021 Ludovic Lemaître
 *  @license   https://github.com/l-lemaitre/froggycomments  Exemple
*/

class FroggyCommentsDisplayBackOfficeHeaderController
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

    // On déclare la méthode run pour ajouter un callback sur les actions de module
    public function run()
    {
        // Si nous ne sommes pas dans la section des modules, nous n’incluons pas les fichiers JS
        if (Tools::getValue('controller') != 'AdminModules') {
            return "";
        }

        // Assignation à Smarty du chemin du répertoire du module froggycomments
        $this->context->smarty->assign('pc_base_dir', __PS_BASE_URI__ . 'modules/' . $this->module->name . '/');

        return $this->module->display($this->file, 'displayBackOfficeHeader.tpl');
    }
}
