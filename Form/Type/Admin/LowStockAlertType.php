<?php
namespace Plugin\LowStockAlert\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Eccube\Form\DataTransformer;

/**
 * Form tyoe for admin manage
 * @author Dung Le
 */
class LowStockAlertType extends AbstractType
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
    * {@inheritdoc}
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $config = $this->app['config'];
        // builder form
        $builder
            ->add('id', 'text', array(
                'required'      => true,
                'label'         => 'Low Stock Alert Number',
                'constraints'   => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array('max' => $config['int_len'])),
                    new Assert\Regex(array(
                        'pattern' => "/^[1-9]+[0-9]*$/u",
                    ))
                ),
            ))
            ->addEventSubscriber(new \Eccube\Event\FormEventSubscriber());
        ;
    }

    /**
    * {@inheritdoc}
    */
    public function getName()
    {
        return 'admin_product_low_stock_alert';
    }
}
