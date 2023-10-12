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



class EquipementsProducts extends ObjectModel
{
    public $id_product_equipment;
    public $id_equipment;
    public $id_product;

    /** @var bool EquipmentsProducts status */
    public $active = true;

    public $date_add;

    /*
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'prestaimmo_product_equipment',
        'primary' => 'id_product_equipment',
        'multilang' => false,
        'fields' => array(
            'id_equipment' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'date_add' => array('type' => self::TYPE_DATE, 'valide' => 'isDate', 'required' => true),
        ),
    );

    public function __construct($id = null)
    {
        $this->module = Module::getInstanceByName('prestaimmo');
        parent::__construct($id);

        $this->context = Context::getContext();
    }

    /**
     *
     * @param int $id_equipment
     *
     * @return EquipementsProducts Object
     */
    public static function getByEquipmentId($id_equipment)
    {
        $sql =
            'SELECT *
            FROM '._DB_PREFIX_.'prestaimmo_product_equipment
            WHERE id_equipment = '.(int)$id_equipment;

        $equimentProducts = Db::getInstance()->executeS($sql);

        if (!$equimentProducts) {
            return false;
        }

        return $equimentProducts;
    }


    /**
     *
     * @param int $id_product
     *
     * @return EquipementsProducts Object
     */
    public static function getByProductId($id_product)
    {
        $sql =
            'SELECT *
            FROM '._DB_PREFIX_.'prestaimmo_product_equipment
            WHERE id_product = '.(int)$id_product;

        $productEquiments = Db::getInstance()->executeS($sql);

        if (!$productEquiments) {
            return false;
        }

        return $productEquiments;
    }

    /**
     * @param int $id_product_equipment
     *
     * @return EquipementsProducts  Object
     */
    public static function getById($id_product_equipment)
    {
        $sql =
            'SELECT id_product_equipment 
            FROM '._DB_PREFIX_.'prestaimmo_product_equipment 
            WHERE id_product_equipment  = '.(int)$id_product_equipment ;

        $id_product_equipment  = Db::getInstance()->getValue($sql);

        if (!$id_product_equipment ) {
            return false;
        }
        return new EquipementsProducts($id_product_equipment);
    }


    /**
     * getAllEqupmentsProducts
     *
     * Check all equipments products
     */
    public static function getAllEqupmentsProducts()
    {
        $sql = 'SELECT * FROM '._DB_PREFIX_.'prestaimmo_product_equipment ';

        $equpmentsProducts  = Db::getInstance()->getValue($sql);

        if (!$equpmentsProducts ) {
            return false;
        }
        return $equpmentsProducts;
    }

    /**
     * createEquipmentsProducts
     *
     * Create Equipments Products
     *
     * @param mixed $id_equipment
     * @param mixed $id_product
     *
     * @return EquipmentsProducts Object
     */
    public static function createEquipmentsProducts(
        $id_equipment,
        $id_product
    ) {

        $now = new DateTime();
        $equipmentsProducts = new EquipmentsProducts();
        $equipmentsProducts->id_equipment = $id_equipment;
        $equipmentsProducts->id_product = $id_product;
        $equipmentsProducts->date_add = $now->format('Y-m-d H:i:s');
        $equipmentsProducts->save();

        return $equipmentsProducts->id_product_equipment;
    }

    /**
     * updateEquipmentsProducts
     *
     * Update Equipments Products
     *
     * @param mixed $id_product_equipment
     * @param mixed $id_equipment
     * @param mixed $id_product
     *
     * @return EquipmentsProducts Object
     */
    public static function updateEquipmentsProducts(
        $id_product_equipment,
        $id_equipment,
        $id_product
    ) {
        $equipmentsProducts = new EquipmentsProducts($id_product_equipment);
        $equipmentsProducts->id_equipment = $id_equipment;
        $equipmentsProducts->id_product = $id_product;
        $equipmentsProducts->update();
        return $equipmentsProducts;
    }

    /**
     * delete
     *
     *
     * @return bool
     */
    public function delete()
    {
        return  Db::getInstance()->delete('prestaimmo_product_equipment', 'id_product_equipment = '.$this->id_product_equipment);
    }

    /**
     * deleteEquipmentsProducts
     *
     * Delete all equipments products
     *
     * @return bool
     */
    public static function deleteById($id)
    {
        $sql =
            'DELETE FROM `'._DB_PREFIX_.'prestaimmo_product_equipment`
            WHERE id_product_equipment =' .$id;

        return Db::getInstance()->execute($sql);
    }

    /**
     * deleteEquipment
     *
     * Delete equipment in  product
     *
     * @return bool
     */
    public static function deleteEquipment($id_product_equipment = null, $id_equipment, $id_product)
    {
        $deleted = false;
        $sql = 'DELETE FROM `'._DB_PREFIX_.'prestaimmo_product_equipment`
            WHERE ';
        if (!null){
            $sql .=
                ' id_product_equipment =' .$id_product_equipment;


        } else {
            $sql .= ' id_product =' .$id_product;
            $sql .= ' AND id_equipment = '.(int)$id_equipment;
        }
        $deleted = Db::getInstance()->execute($sql);
        return $deleted;
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