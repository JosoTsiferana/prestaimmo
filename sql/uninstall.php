<?php
/**
 * Prestashop module : Manualinvoicemanagement
 *
 * @author Progressio
 * @copyright  Progressio
 * @license Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 */

 $sql = array();
$sql[] = 'SET foreign_key_checks = 0;';
$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'prestaimmo_equipment`;';
$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'prestaimmo_product_equipment`;';

$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'prestaimmo_service`;';

$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'prestaimmo_location`;';

$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'prestaimmo_resa`;';

$sql[] = 'SET foreign_key_checks = 1;';

foreach ($sql as $s) {
    if (!Db::getInstance()->execute($s)) {
        return false;
    }
}