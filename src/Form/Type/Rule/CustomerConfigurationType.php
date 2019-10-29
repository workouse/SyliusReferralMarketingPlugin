<?php

declare(strict_types=1);

namespace Workouse\ReferralMarketingPlugin\Form\Type\Rule;

use Symfony\Component\Form\AbstractType;

class CustomerConfigurationType extends AbstractType
{
    public function getBlockPrefix()
    {
        return 'workouse_referral_marketing_plugin_promotion_rule_customer_configuration';
    }
}
