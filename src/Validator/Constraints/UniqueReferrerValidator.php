<?php

declare(strict_types=1);

namespace Workouse\SyliusReferralMarketingPlugin\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Sylius\Component\Customer\Model\Customer;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Workouse\SyliusReferralMarketingPlugin\Entity\Reference;

class UniqueReferrerValidator extends ConstraintValidator
{
    /** @var EntityManager */
    private $em;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(EntityManager $em, TranslatorInterface $translator)
    {
        $this->em = $em;
        $this->translator = $translator;
    }

    /**
     * @param Reference $object
     * @param UniqueReferrer $constraint
     */
    public function validate($object, Constraint $constraint)
    {
        $referrer = $this->em->getRepository(Customer::class)->findOneBy([
            'email' => $object->getReferrer(),
        ]);

        if ($referrer) {
            $this->context->buildViolation($this->translator->trans($constraint->message))
                ->atPath('referrer')
                ->addViolation();
        }
    }
}
