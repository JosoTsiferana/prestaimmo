<?php
/**
 * Prestashop module : prestaimmo
 *
 * @author Progressio
 * @copyright  Progressio
 * @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */


class AdminPrestaImmoEquipementServiceController extends ModuleAdminController
{
    /* @var Bool Is PS version >= 1.7 ? */
    private $isSeven;

    /* @var String html */
    private $html = '';

    private $manual_invoice;
    
    public function __construct()
    {
        $this->table = 'prestaimmo_product_service_equipement';
        $this->name = 'prestaimmo_product_service_equipement';
        $this->className = 'EquipementService';
        $this->identifier = 'id_product';
        $this->lang = false;
        $this->bootstrap = true;
//        $this->actions = array('delete','edit');

        $this->context = Context::getContext();

        parent::__construct();

        // custom confirmation message (see AdminController class)
        $this->_conf[103] = $this->l('The Service has been validated');

        // custom error message (see AdminController class)
        $this->_error[101] = $this->l('You cannot edit an service');  

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
                'equipments' => $equiments,
                'services' => $services
            ));
            return $this->display(__FILE__,'product-extra-prestaimmo.tpl');
    }

    public function initProcess()
    {
        parent::initProcess();

        // Download
        if (Tools::get('id_location')) {
            echo "test";
        }

        // Uniquement dans le cas d'une modification
        /*if (!Tools::isSubmit('submitAddconfigurator_step')
            && !Tools::isSubmit('submitAddconfigurator_stepAndStay')
            && $this->display === 'edit'
            && $this->loadObject()
        ) {
            // Process setting previous steps and options
            $this->processGetPreviousSteps();
        }*/
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
        $this->addRowAction('edit');

       /* $this->fields_list = array(
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
            )
        );*/
        /*$this->context->smarty->assign(array(
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

        /**
     * Override to set id_configurator
     */
    public function initToolbar()
    {
        parent::initToolbar();
        if (isset($this->toolbar_btn['new'])) {
            //$this->toolbar_btn['new']['href'] .= '&id_configurator='.$this->_id_configurator;
        }
    }
       /**
     * Override to set id_configurator
     */
    public function displayEditLink($token = null, $id = null, $name = null)
    {
        $tpl = $this->createTemplate('helpers/list/list_action_edit.tpl');
        if (!array_key_exists('Edit', self::$cache_lang)) {
            self::$cache_lang['Edit'] = $this->l('Edit', 'Helper');
        }

        // Validator
        $name = self::$cache_lang['Edit'];

        $tpl->assign(array(
            'href' => self::$currentIndex
                . '&' . $this->identifier . '=' . $id
                . '&update' . $this->table
                . '&token=' . ($token != null ? $token : $this->token),
            //.'&id_configurator='.$this->_id_configurator,
            'action' => $name,
            'id' => $id
        ));

        return $tpl->fetch();
    }


      /**
     * Override to set id_configurator
     */
    public function displayDeleteLink($token = null, $id = null, $name = null)
    {
        $tpl = $this->createTemplate('helpers/list/list_action_delete.tpl');

        if (!array_key_exists('Delete', self::$cache_lang)) {
            self::$cache_lang['Delete'] = $this->l('Delete', 'Helper');
        }

        if (!array_key_exists('DeleteItem', self::$cache_lang)) {
            self::$cache_lang['DeleteItem'] = $this->l('Delete selected item?', 'Helper', true, false);
        }

        if (!array_key_exists('Name', self::$cache_lang)) {
            self::$cache_lang['Name'] = $this->l('Name:', 'Helper', true, false);
        }

        if (!is_null($name)) {
            $name = addcslashes('\n\n' . self::$cache_lang['Name'] . ' ' . $name, '\'');
        }

        $data = array(
            $this->identifier => $id,
            'href' => self::$currentIndex
                . '&' . $this->identifier . '=' . $id
                . '&delete' . $this->table
                . '&token=' . ($token != null ? $token : $this->token),
            //.'&id_configurator='.$this->_id_configurator,
            'action' => self::$cache_lang['Delete'],
        );

        if ($this->specificConfirmDelete !== false) {
            $data['confirm'] = !is_null($this->specificConfirmDelete)
                ? '\r' . $this->specificConfirmDelete
                : Tools::safeOutput(self::$cache_lang['DeleteItem'] . $name);
        }

        $tpl->assign(array_merge($this->tpl_delete_link_vars, $data));

        return $tpl->fetch();
    }


    public function displayDuplicateLink($token, $id_prestaimmo)
    {
        
    }

    public function renderForm()
    {
        
    }


    private function postValidation()
    {

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
    }
}