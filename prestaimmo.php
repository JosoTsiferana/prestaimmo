<?php
/**
 * Prestashop module : Manualinvoicemanagement
 *
 * @author Progressio
 * @copyright  Progressio
 * @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once(_PS_MODULE_DIR_.'prestaimmo/models/Equipements.php');
require_once(_PS_MODULE_DIR_.'prestaimmo/models/Services.php');
require_once(_PS_MODULE_DIR_.'prestaimmo/models/Locations.php');

class PrestaImmo extends Module
{
    private $html = '';
    private $postErrors = array();

    public function __construct()
    {
        $this->name = 'prestaimmo';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Progressio';
        $this->module_key = '202309a165c4489bcc64253b1c1cd98926a8a4a';
        $this->need_instance = 1;
        $this->errors = array();
        $this->bootstrap = true;

        $this->ps_versions_compliancy = array(
            'min' => '1.6.0.0',
            'max' => _PS_VERSION_
        );

        parent::__construct();

        $this->displayName = $this->l('Module Immobilier');
        $this->description = $this->l('This module manage a product immo.');
        $this->confirmUninstall = $this->l('Are you sure you want to delete these details?');

    }

   /* public function install()
    {
        // Create Manualinvoicemanagement Table
        
        include(dirname(__FILE__).'/sql/install.php');

        return parent::install()
            && $this->installModuleTab()
            && $this->registerHook('displayAdminProductsExtra')
            && $this->registerHook('actionAdminUpdate')
            && $this->registerHook('actionProductSave')
            && $this->registerHook('displayBackOfficeHeader');

    }*/

    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');
        if (!parent::install() ||
            !$this->installModuleTab() ||
            !$this->registerHook('displayAdminProductsExtra')||
            !$this->registerHook('displayBackOfficeHeader')||
            !$this->registerHook('actionProductSave')
        ) {
            return false;
        }

        return true;
    }


    public function uninstall()
    {
        // Drop Manualinvoicemanagement Table
         include(dirname(__FILE__).'/sql/uninstall.php');

        return parent::uninstall()
            && $this->uninstallModuleTab()
            && $this->unregisterHook('displayAdminProductsExtra')
            && $this->unregisterHook('displayBackOfficeHeader')
            && $this->unregisterHook('actionProductSave');
    }

    private function installModuleTab()
    {
        $tab = new Tab();
        $tab->module = $this->name;
        $tab->active = 1;
        $tab->class_name = 'AdminPrestaImmo';
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminCatalog');
        $tab->position = Tab::getNewLastPosition($tab->id_parent);

        foreach (Language::getLanguages(false) as $lang) {
            if ($lang['iso_code'] == "fr") {
                $tab->name[(int)$lang['id_lang']] = 'Immo';
            } else {
                $tab->name[(int)$lang['id_lang']] = 'Immo settings';
            }
        }
        $addTab = $tab->add();

        $tab1 = new Tab();
        $tab1->module = $this->name;
        $tab1->active = 1;
        $tab1->class_name = 'AdminPrestaImmoEquipement';
        $tab1->id_parent = (int)Tab::getIdFromClassName('AdminPrestaImmo');
        $tab1->position = Tab::getNewLastPosition($tab1->id_parent);

        foreach (Language::getLanguages(false) as $lang) {
            if ($lang['iso_code'] == "fr") {
                $tab1->name[(int)$lang['id_lang']] = 'Equipement';
            } else {
                $tab1->name[(int)$lang['id_lang']] = 'Equipment';
            }
        }
        $tab1->add();
        
        
        $tab2 = new Tab();
        $tab2->module = $this->name;
        $tab2->active = 1;
        $tab2->class_name = 'AdminPrestaImmoLocation';
        $tab2->id_parent = (int)Tab::getIdFromClassName('AdminPrestaImmo');
        $tab2->position = Tab::getNewLastPosition($tab2->id_parent);

        foreach (Language::getLanguages(false) as $lang) {
            if ($lang['iso_code'] == "fr") {
                $tab2->name[(int)$lang['id_lang']] = 'Location';
            } else {
                $tab2->name[(int)$lang['id_lang']] = 'Location';
            }
        }
        $tab2->add();

        $tab3 = new Tab();
        $tab3->module = $this->name;
        $tab3->active = 1;
        $tab3->class_name = 'AdminPrestaImmoService';
        $tab3->id_parent = (int)Tab::getIdFromClassName('AdminPrestaImmo');
        $tab3->position = Tab::getNewLastPosition($tab3->id_parent);

        foreach (Language::getLanguages(false) as $lang) {
            if ($lang['iso_code'] == "fr") {
                $tab3->name[(int)$lang['id_lang']] = 'Service';
            } else {
                $tab3->name[(int)$lang['id_lang']] = 'Service';
            }
        }
        $tab3->add();

        return true;
    }

    private function uninstallModuleTab()
    {
        
        $tab1 = new Tab((int)Tab::getIdFromClassName('AdminPrestaImmoEquipement'));
        $tab1->delete();
        $tab2 = new Tab((int)Tab::getIdFromClassName('AdminPrestaImmoLocation'));
        $tab2->delete();
        $tab3 = new Tab((int)Tab::getIdFromClassName('AdminPrestaImmoService'));
        $tab3->delete();
        $tab3 = new Tab((int)Tab::getIdFromClassName('AdminPrestaImmoEquipementService'));
        $tab3->delete();

        $tab = new Tab((int)Tab::getIdFromClassName('AdminPrestaImmo'));

        return $tab->delete();
    }

    /**
     * Dies and echoes output value
     *
     * @param string|null $value
     * @param string|null $controller
     * @param string|null $method
     */
    private function ajaxDie($value = null, $controller = null, $method = null)
    {
        if ($controller === null) {
            $controller = get_class($this);
        }

        if ($method === null) {
            $bt = debug_backtrace();
            $method = $bt[1]['function'];
        }

        Hook::exec('actionBeforeAjaxDie', array('controller' => $controller, 'method' => $method, 'value' => $value));
        Hook::exec('actionBeforeAjaxDie'.$controller.$method, array('value' => $value));

        // PS 1.7
        Hook::exec('actionAjaxDie'.$controller.$method.'Before', array('value' => $value));

        die($value);
    }



    public function postValidation()
    {
        if (Tools::isSubmit('btnSubmit')) {
        }
    }

    public function postProcess()
    {
        if (Tools::isSubmit('btnSubmit')) {
            // update switch fields
        }

        $this->html .= $this->displayConfirmation($this->l('Settings updated'));
    }

    /*public function getContent()
    {
        $this->html = '';

        if (Tools::isSubmit('btnSubmit')) {
            $this->postValidation();

            if (!count($this->postErrors)) {
                $this->postProcess();
            } else {
                foreach ($this->postErrors as $err) {
                    $this->html .= $this->displayError($err);
                }
            }
        }
//        $this->html .= $this->renderForm();
        $this->html .= $this->display(__FILE__, 'views/templates/admin/help.tpl');

        return $this->html;
    }*/

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Manual Invoice configuration'),
                    'icon' => 'icon-list-alt'
                ),
                'input' => array(
                    /*array(
                        'type' => 'switch',
                        'label' => $this->l('Send an e-mail to customer'),
                        'desc' => $this->l('Send an email to the customer with the quotation as PDF in attachment'),
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
                        'name' => 'ma'
                    ),*/

                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $languages = Language::getLanguages(true);
        foreach ($languages as &$language) {
            $language['is_default'] = (bool)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
        }

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->submit_action = 'btnSubmit';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) .'&configure=' . $this->name .'&tab_module=' .$this->tab .'&module_name='. $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $languages,
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        return array();
    }

    public function hookDisplayAdminProductsExtra($params)
    {
        //if (DMTools::getVersionMajor() >= 17) {
       /* $this->addCSS(__PS_BASE_URI__ . 'modules/prestaimmo/views/css/prestaimmo_admin.css');
        $this->addJS(__PS_BASE_URI__ . 'modules/prestaimmo/views/js/custom.js');*/
        $id_product = (int)$params['id_product'];
        
        $product = new Product($id_product, false, Context::getContext()->language->id);

        $equiment = new Equipements();
        $equiments = $equiment->getAll();
        $service = new Services();
        $services = $service->getAll();
       // $configurators = Db::getInstance()->executeS($query);
       // } else {
          //  $id_product = (int)Tools::getValue('id_product');
        //}
       /* $product = new Product($id_product, false, Context::getContext()->language->id);
        if (!ConfiguratorModel::isConfiguratedProduct((int)$product->id)) {
            if (Validate::isLoadedObject($product)) {
                $configurator = ConfiguratorModel::getByIdProduct((int)$product->id);
                if (!Validate::isLoadedObject($configurator)) {
                    $configurator = false;
                }
                $this->smarty->assign(array('configurator' => $configurator));
            } else {
                $product = false;
            }

            $configurators = array();
           /* if (!Validate::isLoadedObject($configurator)) {
                $query = new DbQuery();
                $query->select('c.id_configurator, p.name')
                    ->from('configurator', 'c')
                    ->leftJoin('product_lang', 'p', 'c.id_product = p.id_product')
                    ->where('p.id_lang = ' . (int)$this->context->language->id)
                    ->where('p.id_shop = ' . (int)$this->context->shop->id);
                $configurators = Db::getInstance()->executeS($query);
            }

            // CONFIGURATOR HOOK
            $HOOK_CONFIGURATOR_DISPLAY_ADMIN_PRODUCTS_EXTRA = Hook::exec('configuratorDisplayAdminProductsExtra', array(
                'configurator' => $configurator,
                'product' => $product
            ));

            */

           /* $this->smarty->assign(array(
                'configurators' => $configurators,
                'product' => $product,
                'cancel_link' => AdminProductsController::$currentIndex
                    . '&token=' . Tools::getAdminTokenLite('AdminProducts'),
                // Used for tabs
                'productTabs' => (Validate::isLoadedObject($configurator))
                    ? ConfiguratorStepTabModel::getTabsByIdConfigurator($configurator->id)
                    : array(),
                'default_form_language' => (int)$this->context->language->id,
                'languages' => Language::getLanguages(),
                'languages_json' => Tools::jsonEncode(Language::getLanguages()),
                'HOOK_CONFIGURATOR_DISPLAY_ADMIN_PRODUCTS_EXTRA' => $HOOK_CONFIGURATOR_DISPLAY_ADMIN_PRODUCTS_EXTRA
            ));

          /*  if (DMTools::getVersionMajor() >= 17) {
                return $this->display(__FILE__, 'product-extra_17.tpl');
            } else {
                return $this->display(__FILE__, 'product-extra.tpl');
            }*/
      /* } else {
            $configuratorCartDetailModel = ConfiguratorCartDetailModel::getByIdProduct((int)$product->id);
            $this->smarty->assign(array(
                'product' => $product,
                'details' => $configuratorCartDetailModel->getDetailFormated(false, true)
            ));*/
           // return $this->display(__FILE__, 'product-extra-prestaimmo.tpl');
            $this->smarty->assign(array(
                'product' => $product,
                'equipments' => $equiments,
                'services' => $services,
                'semaine' => $this->liste_semaines("s",52)
            ));
            return $this->display(__FILE__,'product-extra-prestaimmo.tpl');
       // }
    }

    public function hookActionAdminUpdate($params)
    {
       
        // Traitement à effectuer lorsqu'une mise à jour administrative est effectuée
        // Vous pouvez accéder aux données mises à jour via $params
        // Exemple : $updatedObject = $params['object'];
    }
    /**
    * @param type : m = mercredi au mercredi ; s = samedi au samedi
    * @param nb_semaines : nombre de semaines à afficher dans la liste
    */
    function liste_semaines($type, $nb_semaines)
    {
        $tmp = '';
        if($type == 'm' || $type == 's')
        {
            $jour = ($type == 'm') ? 3 : 6; // Mercredi (jour = 3) ou Samedi (jour = 6)
            $jour_courant = date('N');
            if($jour_courant < $jour)
            {
                $jour_depart = date('d') + ($jour - $jour_courant);
            }
            elseif($jour_courant > $jour)
            {
                $jour_depart = date('d') - ($jour_courant - $jour);
            }
            else
            {
                $jour_depart = date('d');
            }


            $tmp .='<div id="divTarifSpe">'; //pour faire une boucle en JS sur les tarifs spé.
            $tmp .= '<table class="immo-weeklist">';
            for($i = 0; $i < $nb_semaines; $i++)
            {
                $datedeb = date('Y-m-d',mktime(0, 0, 0, date('m'), $jour_depart + ($i*7), date('Y')));
                $datefin = date('Y-m-d',mktime(0, 0, 0, date('m'), $jour_depart + (($i+1)*7), date('Y')));
                $datedebfr = $this->date_fr_en_clair(date('d/m/Y',mktime(0, 0, 0, date('m'), $jour_depart + ($i*7), date('Y'))));
                $datefinfr = $this->date_fr_en_clair(date('d/m/Y',mktime(0, 0, 0, date('m'), $jour_depart + (($i+1)*7), date('Y'))));
                $dateresa = $datedeb.';'.$datefin;
                $nomchamptarif = $type.$datedeb.$datefin;
               
                $tarif_spe = (isset($tarifs_specifiques[$dateresa])) ? $tarifs_specifiques[$dateresa] : '';               
                $tmp .= '<tr><td><label for="'.$dateresa.'"> '.$this->l('From').' '.$datedebfr.' '.$this->l('at').' '.$datefinfr.'</label></td>';
                $tmp .= '<td><input type="checkbox" name="resa[]" value="'.$dateresa.'" id="'.$dateresa.'" /></td></tr>';
                
            }
            $tmp .= '</table>';
            //beta
            $tmp .='</div>';
        }
        return $tmp;
    }


    /*** //BETA// ***/
    /**
    * Reçoit une date au format "2/09/06/2009" et la transforme en "mardi 9 juin 2009"
    */
    function date_fr_en_clair($date_fr) {
        // Définir la localisation en français
        $timestamp = strtotime(str_replace('/', '-', $date_fr)); // Remplace "/" par "-" pour un format valide

        if ($timestamp === false) {
            return 'Date invalide';
        }
        setlocale(LC_TIME, 'fr_FR.UTF-8');
    
        // Formater la date en texte en français
        $date_en_clair = strftime('%A %e %B %Y', $timestamp);
    
        return $date_en_clair;
    }
    

    public function hookDisplayBackOfficeHeader(){
        $this->context->controller->addJs($this->_path .'/views/js/custom.js');
        $this->context->controller->addCss($this->_path . '/views/css/prestaimmo_admin.css');
    }


    public function hookActionProductSave($params)
    {
        // Code à exécuter lorsque le produit est sauvegardé.
        // Vous pouvez accéder aux données du produit avec $params.
        $productId = (int)$params['id_product'];
        var_dump($params);
        exit();
    }
   
}