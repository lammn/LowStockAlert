<?php
namespace Plugin\LowStockAlert;

use Eccube\Event\RenderEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\CssSelector\CssSelector;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Event of plugin Low Stock Alert
 * @author Dung Le
 * @param FilterResponseEvent $event
 */
class Event
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Front-end: product detail render event
     * @param FilterResponseEvent $event
     */
    public function onRenderProductsDetailBefore(FilterResponseEvent $event)
    {
        if ($event->getRequest()->getMethod() === 'GET') {
            $app = $this->app;

            // product
            $id = $app['request']->attributes->get('id');
            $Product = $app['eccube.repository.product']->find($id);
            
            // low stock number
            $LowStockAlert = $app['eccube.plugin.low_stock_alert.repository.low_stock_alert']->findOneBy(array());
            
            if (is_null($LowStockAlert)) {
                $LowStockAlert = new \Plugin\LowStockAlert\Entity\LowStockAlert();
            }

            $low_stock_number = $LowStockAlert->getId();
            // check stock for each product class
            foreach ($Product->getProductClasses() as $key => $ProductClass) {
                $classId = $ProductClass->getId();
                // array low stock output
                $lowStocks[$classId] = false;
                if ($ProductClass->getStockUnlimited() === 0) {
                    if ($ProductClass->getStock() < $low_stock_number) {
                        $lowStocks[$classId] = true;
                    }
                }
            }

            // template
            $twig = $app->renderView(
                'LowStockAlert/Resource/template/default/low_stock_alert.twig',
                array(
                    'LowStockAlert' => $LowStockAlert,
                    'low_stocks'    => $lowStocks,
                    'Product'       => $Product,
                )
            );

            // show view
            $response = $event->getResponse();
            $html = $response->getContent();
            $crawler = new Crawler($html);
            $oldElement = $crawler->filter('#item_detail_area .extra-form');
            $oldHtml = $oldElement->html();
            $oldHtml = html_entity_decode($oldHtml, ENT_NOQUOTES, 'UTF-8');

            $newHtml = $oldHtml.$twig;
            $html = $this->getHtml($crawler);
            $html = str_replace($oldHtml, $newHtml, $html);

            $response->setContent($html);
            $event->setResponse($response);
        }
    }

    /**
     * html decode
     *
     * @param Crawler $crawler
     * @return string
     */
    private function getHtml(Crawler $crawler)
    {
        $html = '';
        foreach ($crawler as $domElement) {
            $domElement->ownerDocument->formatOutput = true;
            $html .= $domElement->ownerDocument->saveHTML();
        }
        return html_entity_decode($html, ENT_NOQUOTES, 'UTF-8');
    }
}
