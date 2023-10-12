<?php
/**
 * Prestashop module : prestaimmo
 *
 * @author Progressio
 * @copyright  Progressio
 * @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */


class AdminPrestaImmoLocationController extends ModuleAdminController
{
    /* @var Bool Is PS version >= 1.7 ? */
    private $isSeven;

    /* @var String html */
    private $html = '';

    private $manual_invoice;

    const ADMIN_STEPS_CONTROLLER = 'AdminPrestaImmoEquipementService';

    public function __construct()
    {
        $this->table = 'prestaimmo_location';
        $this->name = 'prestaimmo_location';
        $this->className = 'Locations';
        $this->identifier = 'id_location';
        $this->lang = false;
        $this->bootstrap = true;
//        $this->actions = array('delete','edit');

        $this->context = Context::getContext();

        parent::__construct();

        // custom confirmation message (see AdminController class)
        $this->_conf[103] = $this->l('The Service has been validated');

        // custom error message (see AdminController class)
        $this->_error[101] = $this->l('You cannot edit an service');  

        // custom confirmation message (see AdminController class)
        /* $this->_conf[103] = $this->l('The invoice has been validated');

        // custom error message (see AdminController class)
        $this->_error[101] = $this->l('You cannot edit an manual invoice management');

        $this->_select =
            'id_prestaimmo id, date_add, reference, total';

        $this->_orderBy = 'date_add';
        $this->_orderWay = 'DESC';

        $this->fields_list = array(
            'id' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 25
            ),
            'reference' => array(
                'title' => $this->l('Reference'),
                'width' => 'auto',
                'search' => true
            ),
            'date_add' => array(
                'title' => $this->l('Date add'),
                'width' => 'auto',
                'filter_key' => 'a!date_add'
            ),
            'total' => array(
                'title' => $this->l('Total'),
                'width' => 'auto',
                'search' => true
            ),
        ); */
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);

        $this->addJqueryPlugin(array('autocomplete'));

        $this->addCSS(__PS_BASE_URI__ . 'modules/prestaimmo/views/css/prestaimmo_admin.css');
        $this->addJS(__PS_BASE_URI__ . 'modules/prestaimmo/views/js/custom.js');
    }



    public function renderList()
    {
        $html = "";
        //$this->addRowAction('viewstep');
        $this->addRowAction('viewstep');
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->fields_list = array(
            'id_location' => array(
                'title' => $this->l('ID')
            ),
            'id_product' => array(
                'title' => $this->l('Product'),
                'callback' => 'getProductName'
            ),
            /*'active' => array(
                'title' => $this->l('Active'),
                'active' => 'status'
            )*/
        );
       /* $this->context->smarty->assign(array(
            'configurator_tools_link' => $this->context->link->getAdminLink('AdminConfiguratorTools')
            ///'need_tools_update' => DMTools::needToolsUpdate()
        ));

       /* $output = $this->context->smarty->fetch(
            _PS_MODULE_DIR_ . 'configurator/views/templates/admin/need_tools_update.tpl'
        );*/

        //return $output . parent::renderList();

       // return parent::renderList().$html;
       return parent::renderList();
    }

    public function displayEditLink($token, $id_prestaimmo)
    {
        
    }


    public function displayDuplicateLink($token, $id_prestaimmo)
    {
        
    }

    public function renderForm()
    {
        if (!($this->loadObject(true))) {
            return;
        }

        $this->display = Validate::isLoadedObject($this->object) ? 'edit' : 'add';
        $title = Validate::isLoadedObject($this->object)
            ? $this->l('Edit a Product')
            : $this->l('Add a new configurator for a specific product');

        $hint = 'Commencez à saisir les premières lettres du nom du produit';
        $hint .= ' puis sélectionnez le produit dans le menu déroulant.';

        $this->fields_form = array(
            'legend' => array(
                'title' => $title
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Search a product to configure'),
                    'hint' => $this->l($hint),
                    'required' => true,
                    'name' => 'product_name_location',
                    'col' => '2',

                ),
                array(
                    'type' => 'hidden',
                    'label' => $this->l('getAllProdutByName'),
                    'name' => 'getAllProdutByName',
                    'class' => 'getAllProdutByName',
                    'desc' => $this->l('Enter your value here.'),
                    'default_value' => json_encode($this->getAllProdutByName())
                )
            ),
            'submit' => array(
                'title' => $this->l('Save')
            )
        );
        /*
        if (Shop::isFeatureActive()) {
            $sql = 'SELECT id_attribute_group, id_shop FROM ' . _DB_PREFIX_ . 'attribute_group_shop';
            $associations = array();
            foreach (Db::getInstance()->executeS($sql) as $row) {
                $associations[$row['id_attribute_group']][] = $row['id_shop'];
            }

            $this->fields_form['input'][] = array(
                'type' => 'shop',
                'label' => $this->l('Shop association'),
                'name' => 'checkBoxShopAsso',
                'values' => Shop::getTree()
            );
        } else {
            $associations = array();
        }

        $this->fields_form['shop_associations'] = Tools::jsonEncode($associations);*/


        $parent = parent::renderForm();
        $this->addJqueryPlugin(array('autocomplete', 'fancybox', 'typewatch'));
        return $parent;        
    }

    public function getProductName($echo, $row)
    {
        $echo = true; // Validator
        $product = new Product((int)$row['id_product'], false, $this->context->language->id);
        return Tools::htmlentitiesUTF8($product->name);
    }

    private function postValidation()
    {
        
        if (!Validate::isGenericName(Tools::getValue('product_name_location')) || empty(Tools::getValue('product_name_location'))) {
            $this->errors[] = Tools::displayError(
                'Error : The "product_name_location" is not valid'
            );
        }

        /*if (!Validate::isGenericName(Tools::getValue('title')) || empty(Tools::getValue('title'))) {
            $this->errors[] = Tools::displayError(
                'Error : The "title" is not valid'
            );
        }*/

        return $this->errors;
    }

    private function uploadFiles($id_prestaimmo)
    {
        
    }

    function saveprestaimmoContent()
    {
        
    }

    function updateprestaimmoContent()
    {
        
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitAddprestaimmo_location') && Tools::getValue("product_name_location")){
            if (empty(self::postValidation())){
                $name_product = Tools::getValue("product_name_location");
                $id_product = $this->getProdutByNameForId($name_product);
                $price = $this->getProdutByNameForPrice($id_product);
                $location =  new Locations();
                if(isset($id_product) && !empty($id_product)){
                    //echo "test"; exit();
                    $location->id_product = $id_product;
                    $location->price = $price;
                    $location->save();
                }
            }
        }

        /*if (Tools::isSubmit('updateEquipment') && Tools::isSubmit('id_equipment')){
            if (empty(self::postValidation())){
                $equipement = new Equipements((int)Tools::getValue('id_equipment'));
                $equipement->label = Tools::getValue('label');
                $equipement->title = Tools::getValue('title');
                $equipement->update();
            }
            else return self::postValidation();
        }*/
        return parent::postProcess();
    }



    public function processView($id_prestaimmo)
    {
        
    }

    public function processDuplicate($id_prestaimmo)
    {
       
    }

    public function deleteprestaimmoContent($id_manualinvoicecontent_content,$id_manualinvoicecontent)
    {
       
    }

    public function deleteprestaimmo($id_manualinvoicecontent)
    {
        
    }

    public function processDelete()
    {

        if (Tools::isSubmit('id_location') && Tools::isSubmit('deleteprestaimmo_location')){
                $loaction = new Locations((int)Tools::getValue('id_location'));
                $loaction->delete();
        }
    }


    public function getAllProdutByName(){
        $productNames = [];
        $sql = 'SELECT `name` FROM `' . _DB_PREFIX_ . 'product_lang` WHERE `id_lang` = ' . (int)Context::getContext()->language->id;
        $result = Db::getInstance()->executeS($sql);
        if ($result && is_array($result)) {
            foreach ($result as $row) {
                $productNames[] = $row['name'];
            }
        }
        return  $productNames;
    }

    public function getProdutByNameForId($param){
        $sql = 'SELECT `id_product` FROM `' . _DB_PREFIX_ . 'product_lang` WHERE `id_lang` = ' . (int)Context::getContext()->language->id . ' AND `name`=\''.$param.'\'';
        $result = Db::getInstance()->executeS($sql);
        $productId =  $result[0]['id_product'];
        return  $productId;
    }

    public function getProdutByNameForPrice($id_product){
        $sql = 'SELECT `price` FROM `' . _DB_PREFIX_ . 'product` WHERE `id_product`='.$id_product;
        $result = Db::getInstance()->executeS($sql);
        $price =  $result[0]['price'];
        return  $price;
    }

    public function displayViewstepLink($token = null, $id = null, $name = null)
    {
        $tpl = $this->createTemplate('helpers/list/list_action_view.tpl');
        if (!array_key_exists('ViewStep', self::$cache_lang)) {
            self::$cache_lang['ViewStep'] = $this->l('edit equipment or service');
        }

        $name = self::$cache_lang['ViewStep']; // Validator

        $tpl->assign(array(
            // Use dispatcher cause we need to set a id_configurator in params
            'href' => Dispatcher::getInstance()->createUrl(
                self::ADMIN_STEPS_CONTROLLER,
                $this->context->language->id,
                array(
                    'id_location' => (int)$id,
                    'token' => Tools::getAdminTokenLite(self::ADMIN_STEPS_CONTROLLER)
                ),
                false
            ),
            'action' => $name,
            'id' => $id,
            'token' => $token
        ));

        return $tpl->fetch();
        /*$test = "test";
        return $test;*/
    }
}