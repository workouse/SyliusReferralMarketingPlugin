<?php


namespace Workouse\ReferralMarketingPlugin\Form\Type\Rule;

use Symfony\Component\Form\AbstractType;

class CustomerConfigurationType extends AbstractType
{
    public function getBlockPrefix()
    {
        return 'eres_sylius_referral_marketing_plugin_promotion_rule_customer_configuration';
    }
}
