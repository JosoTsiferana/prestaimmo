<?php
/**
 * Prestashop module : PrestaImmo
 *
 * @author Progressio
 * @copyright  Progressio
 * @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */

 $sql = array();
 /**
  * table for equipment */
$sql[] =
    'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'prestaimmo_equipment` (
        `id_equipment` int(10) NOT NULL AUTO_INCREMENT,
        `label` varchar(250) NOT NULL,
        `title` varchar(250) NOT NULL,
        `date_add` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id_equipment`)
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

$sql[] =
    'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'prestaimmo_product_equipment` (
        `id_equipment` int(10) UNSIGNED NOT NULL,
        `id_product` int(10) UNSIGNED NOT NULL,
        `active` tinyint UNSIGNED NOT NULL DEFAULT 0,
        `date_add` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id_equipment`, `id_product`)
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';


/**
 * table for Service
 */
$sql[] =
    'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'prestaimmo_service` (
        `id_service` int(10) NOT NULL AUTO_INCREMENT,
        `title` varchar(250) NOT NULL,
        `price` varchar(250) NOT NULL,
        `date_add` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id_service`)
    ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';


/**
 * table for Location
 */
$sql[] =
'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'prestaimmo_location` (
    `id_location` int(10) NOT NULL AUTO_INCREMENT,
    `id_product` varchar(250) NOT NULL,
    `price` varchar(250) NULL,
    `date_add` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_location`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

$sql[] =
'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'prestaimmo_product_service_equipement` (
    `id_product` int(10) UNSIGNED NOT NULL,
    `id_service` int(10) UNSIGNED NOT NULL,
    `id_equipement` tinyint UNSIGNED NOT NULL DEFAULT 0
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';



foreach ($sql as $s) {
    if (!Db::getInstance()->execute($s)) {
        return false;
    }
}