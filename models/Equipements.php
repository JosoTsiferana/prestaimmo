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



class Equipements extends ObjectModel
{
    public $id_equipment;
    public $label;
    public $title;
    public $date_add;

    /*
     * @see ObjectModel::$definition
     */
     public static $definition = array(
        'table' => 'prestaimmo_equipment',
        'primary' => 'id_equipment',
        'multilang' => false,
        'fields' => array(
            'label' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'title' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
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
     * Get prestaimmo equipment by id
     *
     * @param int $id_equipment
     *
     * @return Equipements Object
     */
    public static function getById($id_equipment)
    {
        $sql =
            'SELECT id_equipment
            FROM '._DB_PREFIX_.'prestaimmo_equipment
            WHERE id_equipment = '.(int)$id_equipment;

        $id_equipment = Db::getInstance()->getValue($sql);

        if (!$id_equipment) {
            return false;
        }

        return new Equipements($id_equipment);
    }

    /**
     * getAllPrestaImmoEquipments
     *
     * Check all equipments
     */
    public static function getAll()
    {
        $sql = 'SELECT *  FROM '._DB_PREFIX_.'prestaimmo_equipment';
        $equipments = Db::getInstance()->executeS($sql);
        return $equipments;
    }

    /**
     * createEquipments
     *
     * Create Equipments
     *
     *
     * @param mixed $label
     * @param mixed $title
     *
     * @return Equipments Object
     */
    public static function createEquipments($label, $title) {

        $now = new DateTime();
        $equipment = new Equipements();
        $equipment->label = $label;
        $equipment->title = $title;
        $equipment->date_add = $now->format('Y-m-d H:i:s');
        $equipment->save();
        return $equipment->id_equipment;
    }

    /**
     * updateEquipments
     *
     * Update Equipments
     *
     *
     * @param mixed $label
     * @param mixed $title
     *
     * @return Equipments Object
     */
    public static function updateEquipments($id_equipment,$label, $title ) {

        $equipment = new Equipements($id_equipment);
        $equipment->label = $label;
        $equipment->title = $title;
        $equipment->update();
        return $equipment;
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