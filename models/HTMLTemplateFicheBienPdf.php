<?php
/**
 * Prestashop module : prestaimmo
 *
 * @author Progressio
 * @copyright  Progressio
 * @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */

class HTMLTemplateFicheBienPdf extends HTMLTemplate
{
    public $prestaimmo;
    public $context;
    private $isSeven;

    public function __construct($manualinvoice, $smarty)
    {
        $this->module = Module::getInstanceByName('prestaimmo');

        $this->prestaimmo = $manualinvoice;
        $this->smarty = $smarty;

        $this->context = Context::getContext();
        $this->shop = new Shop(Context::getContext()->shop->id);
        $this->isSeven = Tools::version_compare(_PS_VERSION_, '1.7', '>=') ? true : false;
    }

    public function getContent()
    {
        $max_prod_page = 13;
        $max_prod_first_page = 8;

        $manualinvoice_contents = array();
        if ($this->prestaimmo->id_prestaimmo)
            $manualinvoice_contents = ManualInvoice::getManualInvoiceContentById($this->prestaimmo->id_prestaimmo);
        $manualinvoice_count = count($manualinvoice_contents);
        $this->smarty->assign(array(
            'manualinvoice' => $this->prestaimmo,
            'manualinvoice_contents' => $manualinvoice_contents,
            'manualinvoice_count' => $manualinvoice_count,
            'maxProdFirstPage' => $max_prod_first_page,
            'maxProdPage' => $max_prod_page,
        ));

        return $this->smarty->fetch($this->prestaimmoGetTemplate('manual-invoice'));
    }

    public function getHeader()
    {
        $this->assignCommonHeaderData();

        $datetime = new DateTime($this->prestaimmo->date_add);
        $year = $datetime->format('y');
        $month = $datetime->format('m');
        $prestaimmo_number = str_pad($this->prestaimmo->id_prestaimmo, 4, '0', STR_PAD_LEFT);

        $this->smarty->assign(array(
            'header' => $this->module->l('Manual Invoice', 'htmltemplatemanualinvoicepdf'),
            'title' => 'MIC'.$year.$month.'-'.$prestaimmo_number,
            'date' => Tools::displayDate($this->prestaimmo->date_add),
        ));

        return $this->smarty->fetch($this->getTemplate('header'));
    }

    public function getFooter()
    {
        $shop_address = $this->getShopAddress();

        $this->smarty->assign(array(
            'shop_address' => $shop_address,
            'shop_fax' => Configuration::get(
                'PS_SHOP_FAX',
                null,
                null,
                (int)$this->context->shop->id
            ),
            'shop_phone' => Configuration::get(
                'PS_SHOP_PHONE',
                null,
                null,
                (int)$this->context->shop->id
            ),
            'shop_details' => Configuration::get(
                'PS_SHOP_DETAILS',
                null,
                null,
                (int)$this->context->shop->id
            ),
            'free_text' => Configuration::get(
                'PS_INVOICE_FREE_TEXT',
                (int)Context::getContext()->language->id,
                null,
                (int)$this->context->shop->id
            )
        ));

        return $this->smarty->fetch(
            $this->prestaimmoGetTemplate('footer')
        );
    }

    public function getFilename()
    {
        $datetime = new DateTime($this->prestaimmo->date_add);
        $year = $datetime->format('y');
        $month = $datetime->format('m');

        $prestaimmo_number = str_pad($this->prestaimmo->id, 4, '0', STR_PAD_LEFT);

        return 'MIC'.$year.$month.'-'.$prestaimmo_number.'.pdf';
    }

    

    /**
     * If the template is not present in the theme directory, it will return the default template
     * in prestaimmo/views/templates/front/pdf/ directory
     *
     * @param $template_name
     *
     * @return string
     */
    protected function prestaimmoGetTemplate($template_name)
    {
        $template = false;
        $default_template = rtrim(_PS_MODULE_DIR_, DIRECTORY_SEPARATOR)
        .DIRECTORY_SEPARATOR
        .'prestaimmo/views/templates/front/pdf'
        .DIRECTORY_SEPARATOR
        .$template_name
        .'.tpl';

        if ($this->isSeven) {
            $overridden_template = _PS_ALL_THEMES_DIR_
            .$this->shop->theme->getName()
            .DIRECTORY_SEPARATOR
            .'modules/prestaimmo/views/templates/front/pdf'
            .DIRECTORY_SEPARATOR
            .$template_name
            .'.tpl';
        } else {
            $overridden_template = _PS_ALL_THEMES_DIR_
            .$this->shop->getTheme()
            .DIRECTORY_SEPARATOR
            .'modules/prestaimmo/views/templates/front/pdf'
            .DIRECTORY_SEPARATOR
            .$template_name
            .'.tpl';
        }

        if (file_exists($overridden_template)) {
            $template = $overridden_template;
        } elseif (file_exists($default_template)) {
            $template = $default_template;
        }

        return $template;
    }
}