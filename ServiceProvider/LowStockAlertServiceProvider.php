<?php
namespace Plugin\LowStockAlert\ServiceProvider;

use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;

/**
 * Plugin service provider
 * @author Dung Le
 */
class LowStockAlertServiceProvider implements ServiceProviderInterface
{
    /**
     * Register function for plugin
     */
    public function register(BaseApplication $app)
    {
        // orm entity register
        $app['eccube.plugin.low_stock_alert.repository.low_stock_alert'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\LowStockAlert\Entity\LowStockAlert');
        });

        // router controller
        $app->match('/' . $app["config"]["admin_route"] . '/product/low_stock_alert/', '\\Plugin\\LowStockAlert\\Controller\\LowStockAlertController::index')
            ->bind('admin_product_low_stock_alert');

        // form type
        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $types[] = new \Plugin\LowStockAlert\Form\Type\Admin\LowStockAlertType($app);
            return $types;
        }));

        // language
        $app['translator'] = $app->share($app->extend('translator', function ($translator, \Silex\Application $app) {
            $translator->addLoader('yaml', new \Symfony\Component\Translation\Loader\YamlFileLoader());

            $file = __DIR__ . '/../Resource/locale/message.' . $app['locale'] . '.yml';
            if (file_exists($file)) {
                $translator->addResource('yaml', $file, $app['locale']);
            }

            return $translator;
        }));

        // menu bar register
        $app['config'] = $app->share($app->extend('config', function ($config) {
            $addNavi['id'] = 'product_low_stock_alert';
            $addNavi['name'] = 'Low Stock Alert';
            $addNavi['url'] = 'admin_product_low_stock_alert';
            $nav = $config['nav'];
            foreach ($nav as $key => $val) {
                if ('product' == $val['id']) {
                    $nav[$key]['child'][] = $addNavi;
                }
            }
            $config['nav'] = $nav;
            return $config;
        }));
    }

    public function boot(BaseApplication $app)
    {
    }
}