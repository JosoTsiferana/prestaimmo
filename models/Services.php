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



class Services extends ObjectModel
{
    public $id_service;
    public $title;
    public $price;
    public $changeable;
    public $date_add;

    /*
     * @see ObjectModel::$definition
     */
     public static $definition = array(
        'table' => 'prestaimmo_service',
        'primary' => 'id_service',
        'multilang' => false,
        'fields' => array(
            'title' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'price' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'changeable' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );

    public function __construct($id = null)
    {
         $this->module = Module::getInstanceByName('prestaimmo');

        parent::__construct($id);

        $this->context = Context::getContext();
    }

    /**
     * getById
     *
     * Get prestaimmo servicez by id
     *
     * @param int $id_service
     *
     * @return Services Object
     */
    public static function getById($id_service)
    {
        $sql =
            'SELECT id_service
            FROM '._DB_PREFIX_.'prestaimmo_service
            WHERE id_service = '.(int)$id_service;

        $id_service = Db::getInstance()->getValue($sql);
        if (!$id_service) {
            return false;
        }

        return new Services($id_service);
    }

    /**
     * getAllPrestaImmoServices
     *
     * Check all Services
     */
    public static function getAll()
    {
        $sql = 'SELECT *  FROM '._DB_PREFIX_.'prestaimmo_service';
        $Services = Db::getInstance()->executeS($sql);
        return $Services;
    }

    /**
     * createServices
     *
     * Create Services
     *
     *
     * @param mixed $title
     * @param mixed $price
     *
     * @return Services Object
     */
    public static function createServices($title, $price ,$changeable) {

        $now = new DateTime();
        $service = new Services();
        $service->title = $title;
        $service->price = $price;
        $service->changeable = $changeable;
        $service->date_add = $now->format('Y-m-d H:i:s');
        $service->save();
        return $service->id_service;
    }

    /**
     * updateServices
     *
     * Update Services
     *
     *
     * @param mixed $label
     * @param mixed $title
     *
     * @return Services Object
     */
    public static function updateServices($id_service,$title, $price,$changeable ) {

        $service = new Services($id_service);
        $service->title = $title;
        $service->price = $price;
        $service->changeable = $changeable;
        $service->update();
        return $service;
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