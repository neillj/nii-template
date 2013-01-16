<?php
/**
 * Tailor the Magento install to your current environment.
 *
 * PHP Version 5
 *
 * @category Script
 * @package  MagentoDeployment
 * @author   Alex Rabarts <alexrabarts@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.seen-digital.co.uk
 *
 */
if (sizeof($argv) !== 2) {
    echo "Save config\nUsage: " . basename($_SERVER['SCRIPT_NAME']) .
        " environment\n\n";
    exit(0);
}

require_once dirname(__FILE__) . '/../../vendor/spyc-0.5/spyc.php';
//require_once dirname(__FILE__) . '/../../public/app/Mage.php';

$environment = $argv[1];

//Mage::init();

foreach (glob("config/environments/$environment/*.php") as $file) {
    include $file;
}