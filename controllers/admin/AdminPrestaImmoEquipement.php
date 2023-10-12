<?php
/**
 * Prestashop module : prestaimmo
 *
 * @author Progressio
 * @copyright  Progressio
 * @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */


require_once _PS_MODULE_DIR_ . 'prestaimmo/models/Equipements.php';



class AdminPrestaImmoEquipementController extends ModuleAdminController
{

    /* @var String html */
    private $html = '';


    public function __construct()
    {

        $this->table = 'prestaimmo_equipment';
        $this->name = 'prestaimmo_equipment';
        $this->className = 'Equipements';
        $this->identifier = 'id_equipment';
        $this->lang = false;
        $this->bootstrap = true;
//        $this->actions = array('delete','edit');

        $this->context = Context::getContext();

        parent::__construct();

        // custom confirmation message (see AdminController class)
        $this->_conf[103] = $this->l('The equipement has been validated');

        // custom error message (see AdminController class)
        $this->_error[101] = $this->l('You cannot edit an equipement');

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
            'id_equipment, date_add, label, title';

        $this->_orderBy = 'title';
        $this->_orderWay = 'ASC';

        $this->fields_list = array(
            'id_equipment' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 75,
                'filter_key' => 'a!id_equipment'
            ),
            'label' => array(
                'title' => $this->l('Label'),
                'width' => 'auto',
                'search' => true,
                'filter_key' => 'a!label'
            ),

            'title' => array(
                'title' => $this->l('Title'),
                'width' => 'auto',
                'search' => true,
                'filter_key' => 'a!title'
            ),
            'date_add' => array(
                'title' => $this->l('Date add'),
                'width' => 'auto',
                'search' => false
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
            'label' => '',
            'title' => ''
        );
        if (Tools::isSubmit('id_equipment') && (int)Tools::getValue('id_equipment')){
            $title = $this->l('Edit', [], 'Modules.PrestaImmo.Admin');
            $equipment = new Equipements((int)Tools::getValue('id_equipment'));
            $values = array(
                'label' => $equipment->label,
                'title' => $equipment->title,
                'id_equipment' => $equipment->id_equipment
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
                        'label' => $this->l('Label', [], 'Modules.PrestaImmo.Admin'),
                        'name' => 'label',
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title', [], 'Modules.PrestaImmo.Admin'),
                        'name' => 'title',
                        'required' => true,
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'name' => 'addEquipment',
                ),

            ),
        );
        if (Tools::isSubmit('id_equipment') && (int)Tools::getValue('id_equipment')) {
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
                            'name' => 'id_equipment',
                            'required' => true,
                        ),
                        array(
                            'type' => 'text',
                            'label' => $this->l('Label', [], 'Modules.PrestaImmo.Admin'),
                            'name' => 'label',
                            'required' => true,
                        ),
                        array(
                            'type' => 'text',
                            'label' => $this->l('Title', [], 'Modules.PrestaImmo.Admin'),
                            'name' => 'title',
                            'required' => true,
                        )
                    ),
                    'submit' => array(
                        'title' => $this->l('Save'),
                        'name' => 'updateEquipment',
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
                'href' => $this->context->link->getAdminLink('AdminPrestaImmoEquipement'), // Replace with your controller's link
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

            if (!Validate::isGenericName(Tools::getValue('label')) || empty(Tools::getValue('label'))) {
                $this->errors[] = Tools::displayError(
                    'Error : The "Label" is not valid'
                );
            }

            if (!Validate::isGenericName(Tools::getValue('title')) || empty(Tools::getValue('title'))) {
                $this->errors[] = Tools::displayError(
                    'Error : The "title" is not valid'
                );
            }

            return $this->errors;

    }


    public function postProcess()
    {
        if (Tools::isSubmit('addEquipment')){
            if (empty(self::postValidation())){
                $equipement = new Equipements();
                $equipement->label = Tools::getValue('label');
                $equipement->title = Tools::getValue('title');
                $equipement->save();
            }
            else return self::postValidation();
        }

        if (Tools::isSubmit('updateEquipment') && Tools::isSubmit('id_equipment')){
            if (empty(self::postValidation())){
                $equipement = new Equipements((int)Tools::getValue('id_equipment'));
                $equipement->label = Tools::getValue('label');
                $equipement->title = Tools::getValue('title');
                $equipement->update();
            }
            else return self::postValidation();
        }
        return parent::postProcess();
    }


    public function processDelete()
    {

        if (Tools::isSubmit('id_equipment') && Tools::isSubmit('deleteprestaimmo_equipment')){
                $equipement = new Equipements((int)Tools::getValue('id_equipment'));
                $equipement->delete();
        }
    }


}