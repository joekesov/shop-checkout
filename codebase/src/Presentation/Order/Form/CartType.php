<?php


namespace App\Presentation\Order\Form;

use App\Entity\Order;
use App\Presentation\Order\Form\EventListener\ClearCartListener;
use App\Presentation\Order\Form\EventListener\RemoveCartItemListener;
use App\Presentation\Order\Form\EventListener\CheckoutCartListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    private $checkoutCartListener;

    public function __construct(CheckoutCartListener $checkoutCartListener)
    {
        $this->checkoutCartListener = $checkoutCartListener;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderItems', CollectionType::class, [
                'entry_type' => CartItemType::class
            ])
            ->add('save', SubmitType::class)
            ->add('clear', SubmitType::class)
            ->add('checkout', SubmitType::class);

        $builder->addEventSubscriber(new RemoveCartItemListener());
        $builder->addEventSubscriber(new ClearCartListener());
        $builder->addEventSubscriber($this->checkoutCartListener);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'csrf_protection' => false,
        ]);
    }
}