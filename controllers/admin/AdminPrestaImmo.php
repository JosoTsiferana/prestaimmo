<?php
/**
 * Prestashop module : prestaimmo
 *
 * @author Progressio
 * @copyright  Progressio
 * @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */

/* require_once _PS_MODULE_DIR_ . 'prestaimmo/models/ManualInvoice.php';
require_once _PS_MODULE_DIR_ . 'prestaimmo/models/ManualInvoiceContent.php'; */

class AdminPrestaImmoController extends ModuleAdminController
{
    /* @var Bool Is PS version >= 1.7 ? */
    private $isSeven;

    /* @var String html */
    private $html = '';

    private $manual_invoice;

    public function __construct()
    {
        $this->table = 'prestaimmo';
        $this->name = 'prestaimmo';
        $this->className = 'PrestaImmo';
        $this->lang = false;
        $this->deleted = false;
        $this->colorOnBackground = false;
        $this->bootstrap = true;

        $this->context = Context::getContext();



        parent::__construct();

        /* // custom confirmation message (see AdminController class)
        $this->_conf[103] = $this->l('The invoice has been validated');

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
    }



    public function renderList()
    {

        $html = "";

        // ManualInvoice::getAllManualInvoice();

        /* $this->addRowAction('View');
        $this->addRowAction('Edit');
        $this->addRowAction('Delete');
        $this->context->smarty->assign(array(
              'dirimg' => __PS_BASE_URI__.'modules/'.$this->name.'/views/img/',
        )); */



        /*$html = $this->context->smarty->fetch(
            _PS_MODULE_DIR_.'prestaimmo/views/templates/admin/faq.tpl'
        );*/

        return parent::renderList().$html;
    }

    public function displayEditLink($token, $id_prestaimmo)
    {
        /* $this->context->smarty->assign(array(
            'href' => self::$currentIndex
            .'&'
            .$this->identifier
            .'='
            .$id_prestaimmo
            .'&updateprestaimmo&token='
            .($token ? $token : $this->token),
            'confirm' => null,
            'action' => $this->l('Edit')
        ));

        return $this->context->smarty->fetch(
            _PS_MODULE_DIR_.'prestaimmo/views/templates/admin/helpers/lists/list_action_edit.tpl'
        ); */
    }


    public function displayDuplicateLink($token, $id_prestaimmo)
    {
        /* $this->context->smarty->assign(array(
            'href' => self::$currentIndex
            .'&'
            .$this->identifier
            .'='
            .$id_prestaimmo
            .'&duplicate&token='
            .($token ? $token : $this->token),
            'confirm' => $this->l('Are you sure you want to duplicate this quotation ?'),
            'action' => $this->l('Duplicate')
        ));

        return $this->context->smarty->fetch(
            _PS_MODULE_DIR_.'prestaimmo/views/templates/admin/helpers/lists/list_action_validate.tpl'
        ); */
    }

    public function renderForm()
    {
        /* if (!($prestaimmo = $this->loadObject(true))) {
            return;
        }

        $prestaimmo_contents = array();
        $this->context->smarty->assign(array(
            'hrefCancel' => self::$currentIndex.'&token='.$this->token,
            'prestaimmo_token' => $this->token,
            'currency_sign' => $this->context->currency->sign,
            'ajax_url' => $this->context->link->getAdminLink('AdminManualInvoice')
        ));

        if(_PS_VERSION_ >= '1.7'){
              $this->addJS( _PS_ROOT_DIR_ . 'js/tiny_mce/tiny_mce.js');
          $this->addJS(_PS_ROOT_DIR_ . 'js/admin/tinymce.inc.js');
        }

        if(_PS_VERSION_ >= '1.7'){
            $this->addJS(_MODULE_DIR_ . $this->name . '/views/js/admin.js');
        }
        else{
            $this->addJS(_MODULE_DIR_ . $this->name . '/views/js/admin16.js');
        }

        $this->addJqueryUI(array(
            'ui.core',
            'ui.widget'
        ));
        $this->addjQueryPlugin(array(
            'select2',
            'validate'
        ));

        $this->addJS(array(

            _PS_JS_DIR_.'tiny_mce/tiny_mce.js',
            _PS_JS_DIR_.'admin/tinymce.inc.js',
//            _PS_JS_DIR_.'tiny_mce/tinymce.min.js',
            _PS_JS_DIR_.'jquery/ui/jquery.ui.progressbar.min.js',
            _PS_JS_DIR_.'vendor/spin.js',
            _PS_JS_DIR_.'vendor/ladda.js'
        ));
        $this->addJS(_PS_JS_DIR_.'jquery/plugins/select2/select2_locale_'.$this->context->language->iso_code.'.js');
        $this->addJS(_PS_JS_DIR_.'jquery/plugins/validate/localization/messages_'.$this->context->language->iso_code.'.js');

        $this->addCSS(array(
            _PS_JS_DIR_.'jquery/plugins/timepicker/jquery-ui-timepicker-addon.css'
        ));
        $this->addCss(_MODULE_DIR_ . $this->name . '/views/css/prestaimmo_admin.css');

        if (Tools::isSubmit('updateprestaimmo') && Tools::getValue('id_prestaimmo')){
            $manualinvoice = Tools::getValue('id_prestaimmo');
            $manualinvoice_class = new ManualInvoice((int)$manualinvoice);
            $this->manual_invoice = $manualinvoice_class;
            $this->context->smarty->assign(array(
                'manualinvoice' => $manualinvoice_class,
            ));
            $prestaimmo_contents = ManualInvoiceContent::getByManuelInvoiceId($manualinvoice);
            $this->context->smarty->assign(array(
                'prestaimmo_content' => $prestaimmo_contents,
                'href' => self::$currentIndex.'&editprestaimmocontent&token='.$this->token,
                'hrefInfo' => self::$currentIndex.'&editprestaimmoInfoClient&token='.$this->token,
                'href_delete' => self::$currentIndex.'&token='.$this->token,
                'hrefCancel' => self::$currentIndex.'&token='.$this->token,
                'prestaimmo_token' => $this->token,
                'currency_sign' => $this->context->currency->sign,
                'ajax_url' => $this->context->link->getAdminLink('AdminManualInvoice')
            ));
        }
        elseif (Tools::isSubmit('addprestaimmo') && Tools::getValue('addprestaimmo_id')){
            $manualinvoice = Tools::getValue('addprestaimmo');
            $manualinvoice_class = new ManualInvoice((int)$manualinvoice);
            $this->manual_invoice = $manualinvoice_class;
            $this->context->smarty->assign(array(
                'manualinvoice' => $manualinvoice_class,
            ));
            $this->context->smarty->assign(array(
                'href' => self::$currentIndex.'&addprestaimmocontent&token='.$this->token,
                'hrefInfo' => self::$currentIndex.'&editprestaimmoInfoClient&token='.$this->token,
                'hrefCancel' => self::$currentIndex.'&token='.$this->token,
                'prestaimmo_token' => $this->token,
                'currency_sign' => $this->context->currency->sign,
            ));
        } else {
            $manualinvoice = new ManualInvoice();
            $manualinvoice_class = $manualinvoice->createManualInvoice();
           Tools::redirectAdmin( self::$currentIndex .'&' .$this->identifier .'=' .$manualinvoice_class->id_prestaimmo .'&updateprestaimmo&token=' .$this->token);
        }

        return $this->context->smarty->fetch(
            _PS_MODULE_DIR_.$this->name.'/views/templates/admin/form.tpl'
        ); */
    }


    private function postValidation()
    {
        /* if (Tools::isSubmit('submitAddprestaimmo')) {
                if (!Validate::isGenericName(Tools::getValue('designation'))) {
                    $this->errors[] = Tools::displayError(
                        'Error : The "Designation" is not valid'
                    );
                }

                if (!Validate::isCleanHtml(Tools::getValue('description'))) {
                    $this->errors[] = Tools::displayError(
                        'Error : The "Description" is not valid'
                    );
                }
        } */
    }

    private function uploadFiles($id_prestaimmo)
    {
        /* $count = count($_FILES['fileprestaimmo']['name']);
        $upload_dir = _PS_MODULE_DIR_.'prestaimmo/uploads';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755);
        }

        $upload_dir .= DIRECTORY_SEPARATOR.$id_prestaimmo;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755);
        }

        for ($i = 0; $i < $count; $i++) {
            $file = $_FILES['fileprestaimmo']['name'][$i];
            if (isset($_FILES['fileprestaimmo']['error'][$i])) {
                move_uploaded_file(
                    $_FILES['fileprestaimmo']['tmp_name'][$i],
                    $upload_dir.DIRECTORY_SEPARATOR.$file
                );
            }
        } */
    }

    function saveprestaimmoContent()
    {
        /* if (Tools::isSubmit('submitAddprestaimmoContent')) {

            $id_prestaimmo = Tools::getValue('id_manualinvoice');
            $designation = Tools::getValue('designation');
            $description = Tools::getValue('description');
            $price_unit = Tools::getValue('price');
            $quantity = Tools::getValue('quantity');
            $unit = Tools::getValue('unit');
            $total = Tools::getValue('total');

            $prestaimmocontent = ManualInvoiceContent::createManualInvoiceContent(
                $id_prestaimmo,
                $designation,
                $description,
                $price_unit,
                $quantity,
                $unit,
                $total
            );
            $manual_invoice  = new ManualInvoice($id_prestaimmo);
            $manual_invoice->total = ManualInvoiceContent::getSumByManuelInvoiceId((int) $id_prestaimmo);
            $manual_invoice->update();
            return $id_prestaimmo;
        } */
    }

    function updateprestaimmoContent()
    {
        /* if (Tools::isSubmit('submitAddprestaimmoContent') && Tools::isSubmit('id_content') && Tools::isSubmit('edit_content')) {
            $id_prestaimmo = Tools::getValue('id_manualinvoice');
            $id_prestaimmo_content = (int)Tools::getValue('id_content');
            $designation = Tools::getValue('designation');
            $description = Tools::getValue('description');
            $price_unit = Tools::getValue('price');
            $quantity = Tools::getValue('quantity');
            $unit = Tools::getValue('unit');
            $total = Tools::getValue('total');

            $prestaimmocontent = new ManualInvoiceContent($id_prestaimmo_content);
            $prestaimmocontent->designation = $designation;
            $prestaimmocontent->description = $description;
            $prestaimmocontent->quantity = $quantity;
            $prestaimmocontent->unit = $unit;
            $prestaimmocontent->total = $total;
            $prestaimmocontent->price_unit = $price_unit;
            $prestaimmocontent->update();

            $manual_invoice  = new ManualInvoice($id_prestaimmo);
            $manual_invoice->total = ManualInvoiceContent::getSumByManuelInvoiceId((int) $id_prestaimmo);
            $manual_invoice->update();
            return $id_prestaimmo;
        } */
    }

    public function postProcess()
    {
        /* if (Tools::isSubmit('prestaimmoBtnSubmitInfoClient')) {
            $infoclient = Tools::getValue('infoCustomer');
            $id_manualinvoice = (int)Tools::getValue('id_manualinvoice');
            $manualinvoice = new ManualInvoice($id_manualinvoice);
            $manualinvoice->infoCustomer = $infoclient;
            $manualinvoice->update();
            Tools::redirectAdmin( self::$currentIndex .'&' .$this->identifier .'=' . $id_manualinvoice .'&updateprestaimmo&token=' .$this->token);
        }
        elseif (Tools::isSubmit('id_manualinvoice') && Tools::isSubmit('delete_manualinvoicecontent') ) {
            $id_manualinvoice = (int)Tools::getValue('id_manualinvoice');
            $id_manualinvoice_content = (int)Tools::getValue('delete_manualinvoicecontent');
            $this->deleteprestaimmoContent($id_manualinvoice_content, $id_manualinvoice);
            Tools::redirectAdmin( self::$currentIndex .'&' .$this->identifier .'=' . $id_manualinvoice .'&updateprestaimmo&token=' .$this->token);
        }
        elseif (Tools::isSubmit('submitAddprestaimmoContent')) {

            $this->postValidation();
            if (!count($this->errors)) {
                if (!Tools::getValue('edit_content') && !Tools::getValue('edit_content')){
                    $id_manualinvoice = $this->saveprestaimmoContent();
                }
                elseif (Tools::isSubmit('id_content') && Tools::isSubmit('edit_content')) {
                    $id_manualinvoice = $this->updateprestaimmoContent();
                }
                Tools::redirectAdmin( self::$currentIndex .'&' .$this->identifier .'=' .$id_manualinvoice .'&updateprestaimmo&token=' .$this->token);
            }
        }
        elseif (Tools::isSubmit('deleteprestaimmo') && Tools::isSubmit('id_prestaimmo')) {
                $id_manualinvoice = (int)Tools::getValue('id_prestaimmo');
                self::deleteprestaimmo($id_manualinvoice);
                Tools::redirectAdmin( self::$currentIndex .'&token=' .$this->token);

        }


        if (Tools::isSubmit('view'.$this->table)) {
            $this->processView(Tools::getValue('id_prestaimmo'));
        } */

        return parent::postProcess();
    }



    public function processView($id_prestaimmo)
    {
        /* $prestaimmo = new ManualInvoice($id_prestaimmo);

        if (!Validate::isLoadedObject($prestaimmo)) {
            $this->errors[] = Tools::displayError(
                'Error : An error occured while loading the manual invoice management'
            );
        }
        $prestaimmo->renderPdf(true); */
    }

    public function processDuplicate($id_prestaimmo)
    {
        // $prestaimmo = new ManualInvoice($id_prestaimmo);
    }

    public function deleteprestaimmoContent($id_manualinvoicecontent_content,$id_manualinvoicecontent)
    {
        /* $prestaimmo_content = new ManualInvoiceContent((int)$id_manualinvoicecontent_content);
        $prestaimmo_content->delete();
        $manual_invoice  = new ManualInvoice((int)$id_manualinvoicecontent);
        $manual_invoice->total = ManualInvoiceContent::getSumByManuelInvoiceId((int) $id_manualinvoicecontent);
        $manual_invoice->update();
        return $manual_invoice->id_manualinvoicecontent; */
    }

    public function deleteprestaimmo($id_manualinvoicecontent)
    {
        /* $manual_invoice  = new ManualInvoice((int)$id_manualinvoicecontent);
        $manual_invoice_content  = ManualInvoice::getManualInvoiceContentById((int)$id_manualinvoicecontent);

        if ($manual_invoice_content){
            foreach($manual_invoice_content as $mic) {
                $prestaimmo_content = new ManualInvoiceContent((int)$mic['id_manualinvoicecontent_content']);
                $prestaimmo_content->delete();
            }
        }


        return $manual_invoice->delete(); */
    }

    public function processDelete()
    {
        /* $prestaimmo = new ManualInvoice(Tools::getValue('id_prestaimmo'));
        return $prestaimmo->delete(); */
    }


}