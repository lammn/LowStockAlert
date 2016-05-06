<?php
namespace Plugin\LowStockAlert\Tests\Form\Type\Admin;

use Plugin\LowStockAlert\Tests\Form\Type\Admin\LowStockAlertType;

/**
* Plugin type test
* @author Dung Le
*/
class LowStockAlertTypeTest extends \Eccube\Tests\Form\Type\AbstractTypeTestCase
{
    /** @var \Symfony\Component\Form\FormInterface */
    protected $form;

    /** @var array form data */
    protected $formData = array(
        'id' => 5,
    );

    public function setUp()
    {
        parent::setUp();

        // CSRF token remove
        $this->form = $this->app['form.factory']
            ->createBuilder('admin_product_low_stock_alert', null, array(
                'csrf_protection' => false,
            ))
            ->getForm();
    }

    public function testValidData()
    {
        $this->form->submit($this->formData);

        $this->assertTrue($this->form->isValid());
    }

    public function testInvalidId_NotBlank()
    {
        $this->formData['id'] = '';
        $this->form->submit($this->formData);

        $this->assertFalse($this->form->isValid());
    }

    public function testInvalidId_NotNumber()
    {
        $this->formData['id'] = 'aaaa';
        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInvalidId_MaxLengthInvalid()
    {
        $str = str_repeat('S', $this->app['config']['int_len']) . 'S';

        $this->formData['id'] = $str;
        $this->form->submit($this->formData);

        $this->assertFalse($this->form->isValid());
    }

    public function testInvalidid_MaxLengthValid()
    {
        $id = str_repeat('1', $this->app['config']['int_len']);

        $this->formData['id'] = $id;
        $this->form->submit($this->formData);

        $this->assertTrue($this->form->isValid());
    }
}
