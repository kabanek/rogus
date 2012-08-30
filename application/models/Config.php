<?php

class Application_Model_Config extends Zend_Db_Table {
	protected $_name = 'config';

	protected static $_configs = NULL;

	/**
	 * pobiera wartość konfiguracji o $code kluczu
	 * @param string $code
	 * @return string
	 */
	public function getConfig($code) {
		if (is_null(self::$_configs)) {
			$configTable = new Application_Model_Config;
			$configs = $configTable->fetchAll();

			foreach ($configs as $config) {
				self::$_configs[$config['code']] = $config['value'];
			}
		}

		return isset(self::$_configs[$code]) ? self::$_configs[$code] : NULL;
	}
}
