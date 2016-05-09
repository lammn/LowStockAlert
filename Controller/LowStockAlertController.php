<?php
namespace Plugin\LowStockAlert\Controller;

use Plugin\LowStockAlert\Form\Type\LowStockAlertType;
use Eccube\Application;
use Eccube\Common\Constant;
use Eccube\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception as HttpException;

/**
 * Controller for plugin low stock alert
 * @author Dung Le
 */
class LowStockAlertController extends AbstractController
{
    public function index(Application $app, Request $request)
    {
        // get entity
        $LowStockAlert = $app['eccube.plugin.low_stock_alert.repository.low_stock_alert']->findOneBy(array());
        if (is_null($LowStockAlert)) {
            $LowStockAlert = new \Plugin\LowStockAlert\Entity\LowStockAlert();
        }
        // get form
        $form = $app['form.factory']
            ->createBuilder('admin_product_low_stock_alert', $LowStockAlert)
            ->getForm();

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            // validate
            if ($form->isValid()) {
                $status = $app['eccube.plugin.low_stock_alert.repository.low_stock_alert']->save($LowStockAlert);
                if (!$status) {
                    $app->addError('admin.product_low_stock_alert.save.error', 'admin');
                } else {
                    $app->addSuccess('admin.product_low_stock_alert.save.complete', 'admin');
                }

                return $app->redirect($app->url('admin_product_low_stock_alert'));
            }
        }

        return $app->render('LowStockAlert/Resource/template/Admin/index.twig', array(
            'form' => $form->createView(),
            'LowStockAlert' => $LowStockAlert,
        ));

    }
}
