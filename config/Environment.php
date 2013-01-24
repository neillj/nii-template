<?php

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

/**
 * @name Environment
 * @author Marco van 't Wout | Tremani
 * @version 1.4
 *
 * =Environment-class=
 * 
 * Original sources: http://www.yiiframework.com/doc/cookbook/73/
 * 
 * Simple class used to set configuration and debugging depending on environment.
 * Using this you can predefine configurations for use in different environments,
 * like development, testing, staging and production.
 * 
 * The main config is extended to include the Yii path and debug flags.
 * There are mode_x.php files to override and extend the main config for specific implementation.
 * You can optionally use a local config to override these preset configurations, for
 * example when using multiple development instalations with different paths, db's.
 * 
 * This class was designed to have minimal impact on the default Yii generated files.
 * Minimal changes to the index/bootstrap and existing config files are needed.
 * 
 * The Environment is determined by $_SERVER[YII_ENVIRONMENT], created
 * by Apache's SetEnv directive. This can be modified in getMode()
 *
 * If you want to customize this class or its config and modes, extend it (see ExampleEnvironment.php)
 * 
 * ==Setting environment==
 * 
 * Setting environment can be done in the httpd.conf or in a .htaccess file
 * See: http://httpd.apache.org/docs/1.3/mod/mod_env.html#setenv
 * 
 * Httpd.conf example:
 * 
 * <Directory "C:\www">
 *     # Set Yii environment
 * 	   SetEnv YII_ENVIRONMENT DEVELOPMENT
 * </Directory>
 * 
 * ==Installation==
 * 
 *  # Put the yii-environment directory in `protected/extensions/`
 *  # Modify your index.php (and other bootstrap files)
 *  # Modify your main.php config file and add mode specific configs
 *  # Set your local environment
 * 
 * ===Index.php usage example:===
 * 
 * See yii-environment/example-index/ or use the following code block:
 * 
 * {{{
 * <?php
 * // set environment
 * require_once (dirname(__FILE__) . '/../protected/app/config/Environment.php');
 * // set environment - new Environment('PRODUCTION'); (override mode)
 * $env = new Environment();
 * 
 * Yii::createWebApplication($env->config)->run();
 * 
 * ===Structure of config directory===
 * 
 * Your protected/config/ directory will look like this:
 * 
 *   config/main.php                     Global configuration
 *   config/mode_development.php         Mode-specific configurations
 *   config/mode_test.php
 *   config/mode_staging.php
 *   config/mode_production.php
 *   config/local.php                    Local override for mode-specific config
 * 
 * ===Modify your config/main.php===
 * 
 * See yii-environment/example-config/ or use the following code block:
 * 
 * {{{
 * <?php
 * return array(
 *     // Set yiiPath (relative to Environment.php)
 *     'yiiPath' => realpath(dirname(__FILE__) . '/../../../yii/framework/yii.php'),
 *     'yiitPath' => realpath(dirname(__FILE__) . '/../../../yii/framework/yiit.php'),
 * 
 *     // Set YII_DEBUG and YII_TRACE_LEVEL flags
 *     'yiiDebug' => true,
 *     'yiiTraceLevel' => 0,
 *
 *     // Static function Yii::setPathOfAlias()
 *     'yiiSetPathOfAlias' => array(
 *         // uncomment the following to define a path alias
 *         //'local' => 'path/to/local-folder'
 *     ),
 * 
 *     // This is the main Web application configuration. Any writable
 *     // CWebApplication properties can be configured here.
 *     'config' => array(
 *         (...)
 * 	   ),
 * );
 * }}}
 * 
 * ===Create mode-specific config files===
 * 
 * Create config/mode_<mode>.php files for the different modes
 * These will override or merge attributes that exist in the main config.
 * Optional: also create a config/local.php file for local overrides
 * 
 * {{{
 * <?php
 * return array(
 *     // Set yiiPath (relative to Environment.php)
 *     //'yiiPath' => realpath(dirname(__FILE__) . '/../../../yii/framework/yii.php'),
 *     //'yiitPath' => realpath(dirname(__FILE__) . '/../../../yii/framework/yiit.php'),
 * 
 *     // Set YII_DEBUG and YII_TRACE_LEVEL flags
 *     'yiiDebug' => true,
 *     'yiiTraceLevel' => 0,
 *
 *     // Static function Yii::setPathOfAlias()
 *     'yiiSetPathOfAlias' => array(
 *         // uncomment the following to define a path alias
 *         //'local' => 'path/to/local-folder'
 *     ),
 * 
 *     // This is the specific Web application configuration for this mode.
 *     // Supplied config elements will be merged into the main config array.
 *     'config' => array(
 *         (...)
 * 	   ),
 * );
 * }}}
 *
 */
class Environment {
    // Environment settings (extend Environment class if you want to change these)
    const SERVER_VAR = 'YII_ENVIRONMENT'; //Apache SetEnv var
    const CONFIG_DIR = '.'; //relative to Environment.php
    // Valid modes (extend Environment class if you want to change or add to these)
    const MODE_DEVELOPMENT = 100;
    const MODE_TEST = 200;
    const MODE_STAGING = 300;
    const MODE_PRODUCTION = 400;

    // Selected mode
    private $_mode;
    // Environment Yii properties
    public $yiiPath;  // path to yii.php
    public $yiitPath; // path to yiit.php
    public $niiPath;  // path to Nii.php
    public $yiiDebug; // int
    public $yiiTraceLevel; // int
    // Environment Yii statics to run
    // @see http://www.yiiframework.com/doc/api/1.1/YiiBase#setPathOfAlias-detail
    public $yiiSetPathOfAlias = array(); // array with "$alias=>$path" elements
    // Web application config
    public $config;    // config array

    /**
     * Initilizes the Environment class with the given mode
     * @param constant $mode used to override automatically setting mode
     */

    function __construct($mode = null) {
        $this->_mode = $this->getMode($mode);
        $this->setEnvironment();

        // set debug and trace level
        // these must be defined before including the Yii class.
        defined('YII_DEBUG') or define('YII_DEBUG', $this->yiiDebug);
        defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', $this->yiiTraceLevel);


	// Establish the location of Yii
	$yiiDir = $this->locateYii();
	$this->yiiPath = "$yiiDir/yii.php";
	$this->yiitPath = "$yiiDir/yiit.php";

	// Set the Nii path
	$this->niiPath = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'newicon'.DIRECTORY_SEPARATOR.'nii'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'nii'.DIRECTORY_SEPARATOR.'Nii.php');

        // include the yii class file
	require_once $this->yiiPath; 
        $this->runYiiStatics();
    }

    /**
     * Get current environment mode depending on environment variable.
     * Override this function if you want to change this method.
     * @param string $mode
     * @return string
     */
    private function getMode($mode = null) {
        // If not manually set
        if (!isset($mode)) {
            // Return mode based on Apache server var
            if (isset($_SERVER[constant(get_class($this) . '::SERVER_VAR')]))
                $mode = $_SERVER[constant(get_class($this) . '::SERVER_VAR')];
            else
				$mode = 'PRODUCTION';
        }

        // Check if mode is valid
        if (!defined(get_class($this) . '::MODE_' . $mode))
            throw new Exception('Invalid Environment mode supplied or selected');

        return $mode;
    }

    /**
     * Sets the environment and configuration for the selected mode
     */
    private function setEnvironment() {
        // Load main config
        $fileMainConfig = dirname(__FILE__) . DIRECTORY_SEPARATOR . constant(get_class($this) . '::CONFIG_DIR') . DIRECTORY_SEPARATOR . 'main.php';
        if (!file_exists($fileMainConfig))
            throw new Exception('Cannot find main config file "' . $fileMainConfig . '".');
        $configMain = require($fileMainConfig);

        // Load specific config
        $fileSpecificConfig = dirname(__FILE__) . DIRECTORY_SEPARATOR . constant(get_class($this) . '::CONFIG_DIR') . DIRECTORY_SEPARATOR . 'mode_' . strtolower($this->_mode) . '.php';
        if (!file_exists($fileSpecificConfig))
            throw new Exception('Cannot find mode specific config file "' . $fileSpecificConfig . '".');
        $configSpecific = require($fileSpecificConfig);

        // Merge specific config into main config
        $config = self::mergeArray($configMain, $configSpecific);
		
		// turn on all error reporting in development mode
		if ($this->_mode == 'DEVELOPMENT') {
			error_reporting(-1);
		}
		
		// turn off errors in production
		if ($this->_mode == 'PRODUCTION') {
			error_reporting(0);
			ini_set("display_errors", 0);
		} 
		
        // load in local config
        $localConfFile = dirname(__FILE__) . '/local.php';
        if (file_exists($localConfFile)) {
            $localConf = require $localConfFile;
            $config['config'] = self::mergeArray($localConf, $config['config']);
        }


        // Set attributes
        $this->yiiDebug = $config['yiiDebug'];
        $this->yiiTraceLevel = $config['yiiTraceLevel'];
        $this->config = $config['config'];
        $this->config['params']['environment'] = strtolower($this->_mode);

        // Set Yii statics
        $this->yiiSetPathOfAlias = $config['yiiSetPathOfAlias'];
    }

    public function add( $configToAdd )
    {
      $this->config = self::mergeArray($this->config, $configToAdd);
    }

    /**
     * Run Yii static functions.
     * Call this function after including the Yii framework in your bootstrap file.
     */
    public function runYiiStatics() {
        // Yii::setPathOfAlias();
        foreach ($this->yiiSetPathOfAlias as $alias => $path) {
            Yii::setPathOfAlias($alias, $path);
        }
    }

    /**
     * Show current Environment class values
     */
    public function showDebug() {
        echo '<div style="position: absolute; bottom: 0; z-index: 99; height: 250px; overflow: auto; background-color: #ddd; color: #000; border: 1px solid #000; margin: 5px; padding: 5px;">
			<pre>' . htmlspecialchars(print_r($this, true)) . '</pre></div>';
    }

    /**
     * Merges two arrays into one recursively.
     * Taken from Yii's CMap::mergeArray, since php does not supply a native
     * We can not use Yii at this point.
     * function that produces the required result.
     * @see http://www.yiiframework.com/doc/api/1.1/CMap#mergeArray-detail
     * @param array $a array to be merged to
     * @param array $b array to be merged from
     * @return array the merged array (the original arrays are not changed.)
     */
    private static function mergeArray($a, $b) {
        foreach ($b as $k => $v) {
            if (is_integer($k))
                $a[] = $v;
            else if (is_array($v) && isset($a[$k]) && is_array($a[$k]))
                $a[$k] = self::mergeArray($a[$k], $v);
            else
                $a[$k] = $v;
        }
        return $a;
    }

    /**
     * Locate the yii framework
     * This can be in one of two locations
     * a) If we are using standalone nii-core, then it will be under <nii-core>/vendor/yiisoft/yii
     * b) If we are using nii-core as a dependency of another module, it will be next to it i.e. <nii-core>/../../yiisoft/yii
     */
    public function locateYii()
    {	
        $ds = DIRECTORY_SEPARATOR;
        // Local yii could be under ../vendor, relative to this file
	$localYii = dirname(__FILE__).$ds.'..'.$ds.'vendor'.$ds.'yiisoft'.$ds.'yii'.$ds.'framework'; 
	// Or else under ../../../yiisoft relative to this file
	$otherYii = dirname(__FILE__).$ds.'..'.$ds.'..'.$ds.'..'.$ds.'yiisoft'.$ds.'yii'.$ds.'framework'; 

	if( file_exists($localYii) && is_dir($localYii) )
	{
		return realpath($localYii);
	}
	return realpath($otherYii);
    }

}
