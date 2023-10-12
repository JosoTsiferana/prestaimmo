<?php
/**
 * Prestashop module : prestaimmo
 *
 * @author Progressio
 * @copyright  Progressio
 * @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */

 require_once _PS_MODULE_DIR_ . 'prestaimmo/models/Services.php';

class AdminPrestaImmoServiceController extends ModuleAdminController
{

    /* @var String html */
    private $html = '';


    public function __construct()
    {

        $this->table = 'prestaimmo_service';
        $this->name = 'prestaimmo_service';
        $this->className = 'Services';
        $this->identifier = 'id_service';
        $this->lang = false;
        $this->bootstrap = true;
//        $this->actions = array('delete','edit');

        $this->context = Context::getContext();

        parent::__construct();

        // custom confirmation message (see AdminController class)
        $this->_conf[103] = $this->l('The service has been validated');

        // custom error message (see AdminController class)
        $this->_error[101] = $this->l('You cannot edit an service');


    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);

        $this->addCSS(__PS_BASE_URI__ . 'modules/prestaimmo/views/css/prestaimmo_admin.css');
    }



    public function renderList()
    {

        $html = "";

//        $this->addRowAction('View');
        $this->addRowAction('Edit');
        $this->addRowAction('Delete');

        $this->_select =
            'id_service, title, price';

        $this->_orderBy = 'title';
        $this->_orderWay = 'ASC';

        $this->fields_list = array(
            'id_service' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 75,
                'filter_key' => 'a!id_service'
            ),
            'title' => array(
                'title' => $this->l('Title'),
                'width' => 'auto',
                'search' => true,
                'filter_key' => 'a!title'
            ),

            'price' => array(
                'title' => $this->l('Price'),
                'width' => 'auto',
                'search' => true,
                'filter_key' => 'a!price'
            )
        );

        return parent::renderList();
    }



    public function initPageHeaderToolbar()
    {
        parent::initPageHeaderToolbar();
    }


    public function renderForm()
    {
        if (!($obj = $this->loadObject(true)))
            return;

        $title = $this->l('Add', [], 'Modules.PrestaImmo.Admin');
        $values = array(
            'title' => '',
            'price' => ''
        );
        if (Tools::isSubmit('id_service') && (int)Tools::getValue('id_service')){
            $title = $this->l('Edit', [], 'Modules.PrestaImmo.Admin');
            $service = new Services((int)Tools::getValue('id_service'));
            $values = array(
                'title' => $service->title,
                'price' => $service->price,
                'id_service' => $service->id_service
            );
        }

        $fieldsForm = array(
            'form' => array(
                'legend' => array(
                    'title' => $title,
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title', [], 'Modules.PrestaImmo.Admin'),
                        'name' => 'title',
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Price', [], 'Modules.PrestaImmo.Admin'),
                        'name' => 'price',
                        'required' => true,
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'name' => 'addService',
                ),

            ),
        );
        if (Tools::isSubmit('id_service') && (int)Tools::getValue('id_service')) {
            $fieldsForm = array(
                'form' => array(
                    'legend' => array(
                        'title' => $title,
                        'icon' => 'icon-cogs',
                    ),
                    'input' => array(
                        array(
                            'type' => 'hidden',
                            'label' => $this->l('Id', [], 'Modules.PrestaImmo.Admin'),
                            'name' => 'id_service',
                            'required' => true,
                        ),
                        array(
                            'type' => 'text',
                            'label' => $this->l('title', [], 'Modules.PrestaImmo.Admin'),
                            'name' => 'title',
                            'required' => true,
                        ),
                        array(
                            'type' => 'text',
                            'label' => $this->l('price', [], 'Modules.PrestaImmo.Admin'),
                            'name' => 'price',
                            'required' => true,
                        )
                    ),
                    'submit' => array(
                        'title' => $this->l('Save'),
                        'name' => 'updateService',
                    ),

                ),
            );
        }


        $helper = new HelperForm();
        $helper->module = $this;
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = $this->token;
        $helper->toolbar_btn = array(
            'back' => array(
                'href' => $this->context->link->getAdminLink('AdminPrestaImmoService'), // Replace with your controller's link
                'desc' => $this->l('Back to List'),
                'icon' => 'process-icon-back',
            ),
        );
        $helper->tpl_vars = array(
            'fields_value' => $values,
        );
//        parent::renderForm();
        return $helper->generateForm(array($fieldsForm));
    }



    private function postValidation()
    {

            if (!Validate::isGenericName(Tools::getValue('title')) || empty(Tools::getValue('title'))) {
                $this->errors[] = Tools::displayError(
                    'Error : The "Label" is not valid'
                );
            }

            if (!Validate::isGenericName(Tools::getValue('price')) || empty(Tools::getValue('price'))) {
                $this->errors[] = Tools::displayError(
                    'Error : The "title" is not valid'
                );
            }

            return $this->errors;

    }


    public function postProcess()
    {
        if (Tools::isSubmit('addService')){
            if (empty(self::postValidation())){
                $service = new Services();
                $service->title = Tools::getValue('title');
                $service->price = Tools::getValue('price');
                $service->save();
            }
            else return self::postValidation();
        }

        if (Tools::isSubmit('updateService') && Tools::isSubmit('id_service')){
            if (empty(self::postValidation())){
                $service = new Services((int)Tools::getValue('id_service'));
                $service->title = Tools::getValue('title');
                $service->price = Tools::getValue('price');
                $service->update();
            }
            else return self::postValidation();
        }
        return parent::postProcess();
    }


    public function processDelete()
    {

        if (Tools::isSubmit('id_service') && Tools::isSubmit('deleteprestaimmo_service')){
                $service = new Services((int)Tools::getValue('id_service'));
                $service->delete();
        }
    }

}