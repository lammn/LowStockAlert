<?php

namespace Plugin\LowStockAlert;

use Eccube\Plugin\AbstractPluginManager;

/**
 * Plugin manager
 * @author Dung Le
 */
class PluginManager extends AbstractPluginManager
{
    public function __construct()
    {
    }

    public function install($config, $app)
    {
        $this->migrationSchema($app, __DIR__ . '/Migration', $config['code']);
    }

    public function uninstall($config, $app)
    {
        $this->migrationSchema($app, __DIR__ . '/Migration', $config['code'], 0);
    }

    public function enable($config, $app)
    {

    }

    public function disable($config, $app)
    {

    }

    public function update($config, $app)
    {

    }

}
