<?php


namespace Eres\SyliusReferralMarketingPlugin\Service;

use Doctrine\ORM\EntityManager;
use Eres\SyliusReferralMarketingPlugin\Entity\Reference;
use Sylius\Component\Customer\Model\Customer;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Promotion\Generator\PromotionCouponGeneratorInstructionInterface;
use Sylius\Component\Promotion\Generator\PromotionCouponGeneratorInterface;
use Sylius\Component\Promotion\Model\PromotionRuleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;

class PromotionService implements PromotionInterface
{
    /** @var PromotionRuleInterface */
    private $promotionRuleRepository;

    /** @var PromotionCouponGeneratorInterface */
    private $couponGenerator;

    /** @var CustomerInterface */
    private $customerRuleRepository;

    /** @var EntityManager */
    private $entityManager;

    /** @var CanonicalizerInterface */
    private $canonicalizer;

    /** @var \Sylius\Component\Core\Model\PromotionInterface */
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

    public function execute(Reference $reference)
    {
        $inviteePromotion = $this->promotionRepository->findOneBy([
            'code' => $this->inviteePromotionCode
        ]);

        if ($inviteePromotion) {
            /** @var PromotionCouponGeneratorInstructionInterface $instruction */
            $instruction = new PromotionCouponGeneratorInstruction();
            $instruction->setAmount(1);
            $instruction->setCustomer($reference->getInvitee());
            $this->couponGenerator->generate($inviteePromotion, $instruction);
        }

        $referrerPromotion = $this->promotionRepository->findOneBy([
            'code' => $this->referrerPromotionCode
        ]);

        if ($referrerPromotion) {
            $customer = new Customer();
            $customer->setEmail($reference->getReferrerEmail());
            $customer->setEmailCanonical($this->canonicalizer->canonicalize($reference->getReferrerEmail()));
            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            /** @var PromotionCouponGeneratorInstructionInterface $instruction */
            $instruction = new PromotionCouponGeneratorInstruction();
            $instruction->setCustomer($this->customerRuleRepository->findOneBy([
                'id' => $customer->getId()
            ]));
            $this->couponGenerator->generate($referrerPromotion, $instruction);
        }

    }

    public function createHash($inviteeEmail, $referrerEmail)
    {
        return sha1(uniqid() . '-' . $inviteeEmail . '-' . $referrerEmail);
    }

}
