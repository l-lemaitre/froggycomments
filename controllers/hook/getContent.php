<?php
/**
 *  @author    Ludovic Lemaître <contact@llemaitre.com>
 *  @copyright 2021 Ludovic Lemaître
 *  @license   https://github.com/l-lemaitre/froggycomments  Exemple
*/

class FroggyCommentsGetContentController
{
    // On crée un constructeur pour récupérer les données des variables et méthodes de la classe principale du module
    // (voir fichier froggycomments.php ligne 135)
    public function __construct($module, $file, $path)
    {
        $this->file = $file;
        $this->module = $module;
        $this->context = Context::getContext();
        $this->_path = $path;
    }

    // On déclare la méthode processConfiguration pour gérer le traitement de la soumission du formulaire de
    // configuration
    public function processConfiguration()
    {
        // On utilise la fonction Tools::isSubmit pour savoir si le formulaire contenant le bouton
        // submit_froggycomments_form a bien était envoyé (voir fichier getContent.tpl ligne 33)
        if (Tools::isSubmit('submit_froggycomments_form')) {
            // On utilise la fonction Tools::getValue pour récupérer la valeur POST associée à la clé enable_grades
            // qu'on affecte à la variable enable_grades (voir fichier getContent.tpl lignes 13 ou 16)
            $enable_grades = Tools::getValue('enable_grades');

            $enable_comments = Tools::getValue('enable_comments');

            // On utilise la fonction Configuration::updateValue pour sauvegarder des valeurs simples dans la table de
            // configuration de PrestaShop (ps_configuration)
            Configuration::updateValue('FROGGY_GRADES', $enable_grades);
            Configuration::updateValue('FROGGY_COMMENTS', $enable_comments);

            // On utilise la variable $this->context->smarty et sa méthode assign pour assigner une variable de
            // confirmation à l'objet Smarty
            $this->context->smarty->assign('confirmation', 'ok');
        }
    }

    public function renderForm()
    {
        // On définit les champs du formulaire en créant le tableau $fields_form (voir ligne 105)
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->module->l('My Module configuration'),
                    'icon' => 'icon-wrench'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->module->l('Enable grades :'),
                        'name' => 'enable_grades',
                        'desc' => $this->module->l('Enable grades on products.'),
                        'values' => array(
                            array(
                                'id' => 'enable_grades_1',
                                'value' => 1,
                                'label' => $this->module->l('Enabled')
                            ),
                            array(
                                'id' => 'enable_grades_0',
                                'value' => 0,
                                'label' => $this->module->l('Disabled')
                            )
                        ),
                    ), array(
                        'type' => 'switch',
                        'label' => $this->module->l('Enable comments :'),
                        'name' => 'enable_comments',
                        'desc' => $this->module->l('Enable comments on products.'),
                        'values' => array(
                            array(
                                'id' => 'enable_comments_1',
                                'value' => 1,
                                'label' => $this->module->l('Enabled')
                            ),
                            array(
                            'id' => 'enable_comments_0',
                            'value' => 0,
                            'label' => $this->module->l('Disabled')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save')
                )
            ),
        );

        // On instancie la classe HelperForm
        $helper = new HelperForm();

        // On définit les options
        $helper->table = 'froggycomments';

        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');

        $helper->allow_employee_form_lang = (int)Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');

        $helper->submit_action = 'submit_froggycomments_form';

        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' .
            $this->module->name . '&tab_module=' . $this->module->tab . '&module_name=' . $this->module->name;

        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => array(
                'enable_grades' => Tools::getValue('enable_grades', Configuration::get('FROGGY_GRADES')),
                'enable_comments' => Tools::getValue('enable_comments', Configuration::get('FROGGY_COMMENTS')),
            ),
            'languages' => $this->context->controller->getLanguages()
        );

        // On génére le formulaire en utilisant la méthode renderForm qui prend en paramètre le tableau $fields_form
        // créé précédemment
        return $helper->generateForm(array($fields_form));
    }

    // On déclare la méthode run pour ajouter des options de configuration à notre module et les afficher
    public function run()
    {
        // Appel de la méthode processConfiguration
        $this->processConfiguration();

        // On utilise la méthode display pour afficher le template getContent.tpl
        $html_confirmation_message = $this->module->display($this->file, 'getContent.tpl');

        // Voir ligne 29
        $html_form = $this->renderForm();

        // On retourne le template getContent.tpl concaténé avec le résultat de la fonction renderForm
        return $html_confirmation_message . $html_form;
    }
}
