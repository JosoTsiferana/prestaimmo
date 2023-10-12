<?php
/**
 * Prestashop module : prestaimmo
 *
 * @author Progressio
 * @copyright  Progressio
 * @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}



class OrderLocation extends ObjectModel
{
    /* public $id_prestaimmo_content;
    public $id_prestaimmo;
    public $designation;
    public $description;
    public $price_unite;
    public $quantity;
    public $unit;
    public $total;
    public $date_add; */

    /*
     * @see ObjectModel::$definition
     */
    /* public static $definition = array(
        'table' => 'prestaimmo_content',
        'primary' => 'id_prestaimmo_content',
        'multilang' => false,
        'fields' => array(
            'id_prestaimmo' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'designation' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'description' => array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml'),
            'price_unit' => array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'quantity' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'unit' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'total' => array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'date_add' => array('type' => self::TYPE_DATE, 'valide' => 'isDate', 'required' => true),
        ),
    ); */

    public function __construct($id = null)
    {
       /*  $this->module = Module::getInstanceByName('prestaimmo');
        parent::__construct($id);

        $this->context = Context::getContext(); */

    }



    /**
     * getMimeType
     *
     * get file mime type string
     *
     * @param string $file
     *
     * @return string Mime type
     */
    public function getMimeType($file)
    {
        // our list of mime types
        $mime_types = array(
            'pdf'   => 'application/pdf',
            'docx'  => 'application/msword',
            'doc'   => 'application/msword',
            'xls'   => 'application/vnd.ms-excel',
            'ppt'   => 'application/vnd.ms-powerpoint',
            'gif'   => 'image/gif',
            'png'   => 'image/png',
            'txt'   => 'text/plain',
            'jpe'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'jpg'   => 'image/jpeg'
        );

        $exten = explode('.', $file);
        $extension = Tools::strtolower(end($exten));

        return $mime_types[$extension];
    }
}