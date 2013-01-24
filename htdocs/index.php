<?php
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'Environment.php';

// set environment * new Environment('PRODUCTION'); (override mode)
$env = new Environment();
require_once $env->yiiPath; 
require_once $env->niiPath; 

Yii::createApplication('Nii',$env->config)->setup()->run();

/**
 * debug print functionn
 * TODO: move into a generic function file
 * @param mixed $debugObj
 */
function dp($debugObj) {
    echo '<pre>' . CHtml::encode(print_r($debugObj, true)) . '</pre>';
}
