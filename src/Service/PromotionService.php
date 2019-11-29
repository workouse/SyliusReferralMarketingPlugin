<?php

declare(strict_types=1);

namespace Workouse\SyliusReferralMarketingPlugin\Service;

use Doctrine\ORM\EntityManager;
use Sylius\Component\Core\Model\Promotion;
use Sylius\Component\Customer\Model\Customer;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Promotion\Generator\PromotionCouponGeneratorInstructionInterface;
use Sylius\Component\Promotion\Generator\PromotionCouponGeneratorInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Workouse\SyliusReferralMarketingPlugin\Entity\Reference;

class PromotionService implements PromotionInterface
{
    /** @var RepositoryInterface */
    private $promotionRuleRepository;

    /** @var PromotionCouponGeneratorInterface */
    private $couponGenerator;

    /** @var RepositoryInterface */
    private $customerRuleRepository;

    /** @var EntityManager */
    private $entityManager;

    /** @var CanonicalizerInterface */
    private $canonicalizer;

    /** @var RepositoryInterface */
    private $promotionRepository;

    /** @var string */
    private $referrerPromotionCode;

    /** @var string */
    private $inviteePromotionCode;

    public function __construct(
        RepositoryInterface $promotionRuleRepository,
        PromotionCouponGeneratorInterface $couponGenerator,
        RepositoryInterface $customerRuleRepository,
        EntityManager $entityManager,
        CanonicalizerInterface $canonicalizer,
        RepositoryInterface $promotionRepository,
        $referrerPromotionCode,
        $inviteePromotionCode
    )
    {
        $this->promotionRuleRepository = $promotionRuleRepository;
        $this->couponGenerator = $couponGenerator;
        $this->customerRuleRepository = $customerRuleRepository;
        $this->entityManager = $entityManager;
        $this->canonicalizer = $canonicalizer;
        $this->promotionRepository = $promotionRepository;
        $this->referrerPromotionCode = $referrerPromotionCode;
        $this->inviteePromotionCode = $inviteePromotionCode;
    }

    public function referrerExecute(Reference $reference)
    {
        /** @var Promotion $referrerPromotion */
        $referrerPromotion = $this->promotionRepository->findOneBy([
            'code' => $this->referrerPromotionCode,
        ]);

        if ($referrerPromotion instanceof Promotion) {
            /** @var Customer $referrer */
            $referrer = $reference->getReferrer();

            /** @var PromotionCouponGeneratorInstructionInterface $instruction */
            $instruction = new PromotionCouponGeneratorInstruction();
            $instruction->setCustomer($referrer);
            $this->couponGenerator->generate($referrerPromotion, $instruction);
        }
    }

    public function inviteeExecute(Reference $reference)
    {
        /** @var Promotion $inviteePromotion */
        $inviteePromotion = $this->promotionRepository->findOneBy([
            'code' => $this->inviteePromotionCode,
        ]);

        if ($inviteePromotion instanceof Promotion) {
            /** @var PromotionCouponGeneratorInstructionInterface $instruction */
            $instruction = new PromotionCouponGeneratorInstruction();
            $instruction->setAmount(1);
            $instruction->setCustomer($reference->getInvitee());
            $this->couponGenerator->generate($inviteePromotion, $instruction);
        }
    }

    public function inviteeUserAfterExecute(Customer $customer)
    {
        $referrer = $this->entityManager->getRepository(Reference::class)->findOneBy([
            'referrer' => $customer,
            'status' => false,
        ]);

        if ($referrer) {
            /** @var Promotion $inviteePromotion */
            $inviteePromotion = $this->promotionRepository->findOneBy([
                'code' => $this->inviteePromotionCode,
            ]);

            if ($inviteePromotion instanceof Promotion) {
                /** @var PromotionCouponGeneratorInstructionInterface $instruction */
                $instruction = new PromotionCouponGeneratorInstruction();
                $instruction->setAmount(1);
                $instruction->setCustomer($customer);
                $this->couponGenerator->generate($inviteePromotion, $instruction);
            }
            $referrer->setStatus(true);
            $this->entityManager->flush();
        }
    }
}
