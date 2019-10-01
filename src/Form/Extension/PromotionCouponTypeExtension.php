<?php


namespace Workouse\ReferralMarketingPlugin\Form\Extension;

use Sylius\Bundle\PromotionBundle\Form\Type\PromotionCouponType;
use Sylius\Component\Customer\Model\Customer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class PromotionCouponTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer', EntityType::class, [
                'label' => 'eres_sylius_referral_marketing_plugin.form.promotion_coupon.customer',
                'class' => Customer::class,
                'choice_label' => function (Customer $customer) {
                    return $customer->getEmail() . ' - ' . $customer->getFirstName() . ' ' . $customer->getLastName();
                },
                'placeholder' => 'eres_sylius_referral_marketing_plugin.form.promotion_coupon.please_choose'
            ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [PromotionCouponType::class];
    }
}
