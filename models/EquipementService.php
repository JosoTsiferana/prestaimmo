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



class EquipementService extends ObjectModel
{
    public $id_product;
    public $id_service;
    public $id_equipement;

    /*
     * @see ObjectModel::$definition
     */
     public static $definition = array(
        'table' => 'prestaimmo_product_service_equipement',
        'multilang' => false,
        'fields' => array(
            'id_product' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'id_service' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'id_equipement' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
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
     * Get prestaimmo EquipementService by id
     *
     * @param int $id_product
     *
     * @return EquipementService Object
     */
    public static function getById($id_product)
    {
        $sql =
            'SELECT id_product
            FROM '._DB_PREFIX_.'prestaimmo_product_service_equipement
            WHERE id_product = '.(int)$id_product;

        $id_product = Db::getInstance()->getValue($sql);

        if (!$id_product) {
            return false;
        }

        return new EquipementService($id_product);
    }

    /**
     * getAllPrestaImmoEquipementService
     *
     * Check all EquipementService
     */
    public static function getAll()
    {
        $sql = 'SELECT *  FROM '._DB_PREFIX_.'prestaimmo_product_service_equipement';
        $equipementService = Db::getInstance()->executeS($sql);
        return $equipementService;
    }

    /**
     * createEquipementService
     *
     * Create EquipementService
     *
     *
     * @param mixed $label
     * @param mixed $title
     *
     * @return EquipementService Object
     */
    public static function createEquipementService($id_product, $id_service,$id_equipement) {
        $equipementService = new EquipementService();
        $equipementService->id_product = $id_product;
        $equipementService->id_service = $id_service;
        $equipementService->id_equipement = $id_equipement;
        $equipementService->save();
        return $equipementService->id_product;
    }

    /**
     * updateEquipementService
     *
     * Update EquipementService
     *
     *
     * @param mixed $label
     * @param mixed $title
     *
     * @return EquipementService Object
     */
    public static function updateEquipementService($id_product, $id_service,$id_equipement) {

        $equipementService = new EquipementService($id_product);
        $equipementService->id_equipement = $id_equipement;
        $equipementService->id_service = $id_service;
        $equipementService->update();
        return $equipementService;
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