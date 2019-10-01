<?php


namespace Workouse\ReferralMarketingPlugin\Promotion\Checker\Rule;

use Sylius\Component\Promotion\Checker\Rule\RuleCheckerInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;
use Symfony\Component\Security\Core\Security;

class CustomerRuleChecker implements RuleCheckerInterface
{
    const TYPE = 'customer';

    /** @var Security */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function isEligible(PromotionSubjectInterface $subject, array $configuration): bool
    {
        return $subject->getPromotionCoupon()->getCustomer() ? $subject->getPromotionCoupon()->getCustomer() === $this->security->getUser()->getCustomer() : true;
    }
}
