<?
$basePath 	= realpath(dirname(__FILE__) . '/../');
$modulePath 	= $basePath.DIRECTORY_SEPARATOR.'modules';
$runtimePath	= $basePath.DIRECTORY_SEPARATOR.'runtime';
return array(
  'config' => array(
    'components' => array(
      'fixture' => array(
        'class' => 'system.test.CDbFixtureManager',
      ),
      'assetManager' => array(
         'basePath'  => $runtimePath, 
         'baseUrl'   => $runtimePath 
      ),
      'db' => array(
         'connectionString' => 'mysql:unix_socket=/var/mysql/mysql.sock;dbname=newiconadmin_test',
         'username' => 'root',
         'password' => '',
         'tablePrefix' => '',
      ),
    ),
    'basePath'    => $basePath,
    'runtimePath' => $runtimePath,
    'modulePath'  => $modulePath,
  ),
);
