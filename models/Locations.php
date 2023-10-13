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



class Locations extends ObjectModel
{
    public $id_location;
    public $id_product;
    public $price;
    public $date_add;

    /*
     * @see ObjectModel::$definition
     */
     public static $definition = array(
        'table' => 'prestaimmo_location',
        'primary' => 'id_location',
        'multilang' => false,
        'fields' => array(
            'id_product' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'week_available' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'id_service' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'id_equipement' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
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
     * Get prestaimmo location by id
     *
     * @param int $id_location
     *
     * @return Locations Object
     */
    public static function getById($id_location)
    {
        $sql =
            'SELECT id_location
            FROM '._DB_PREFIX_.'prestaimmo_location
            WHERE id_location = '.(int)$id_location;

        $id_location = Db::getInstance()->getValue($sql);

        if (!$id_location) {
            return false;
        }

        return new Locations($id_location);
    }

    /**
     * getAllPrestaImmoLocations
     *
     * Check all locations
     */
    public static function getAll()
    {
        $sql = 'SELECT *  FROM '._DB_PREFIX_.'prestaimmo_location';
        $locations = Db::getInstance()->executeS($sql);
        return $locations;
    }

    /**
     * createLocations
     *
     * Create Locations
     *
     *
     * @param mixed $label
     * @param mixed $title
     *
     * @return Locations Object
     */
    public static function createLocations($id_product, $week_available,$id_service,$id_equipement) {

        $now = new DateTime();
        $location = new Locations();
        $location->id_product = $id_product;
        $location->week_available = $week_available;
        $location->id_service = $id_service;
        $location->id_equipement = $id_equipement;
        $location->date_add = $now->format('Y-m-d H:i:s');
        $location->save();
        return $location->id_location;
    }

    /**
     * updateLocations
     *
     * Update Locations
     *
     *
     * @param mixed $label
     * @param mixed $title
     *
     * @return Locations Object
     */
    public static function updateLocations($id_location,$id_product,  $week_available,$id_service,$id_equipement ) {

        $location = new Locations($id_location);
        $location->id_product = $id_product;
        $location->week_available = $week_available;
        $location->id_service = $id_service;
        $location->id_equipement = $id_equipement;
        $location->update();
        return $location;
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