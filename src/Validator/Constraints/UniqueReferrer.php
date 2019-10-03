<?php


namespace Workouse\ReferralMarketingPlugin\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/** @Annotation */
class UniqueReferrer extends Constraint
{
    public $message = 'workouse_referral_marketing_plugin.form.this_user_is_registered_in_the_system';

    public function validatedBy()
    {
        return 'unique_referrer';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
