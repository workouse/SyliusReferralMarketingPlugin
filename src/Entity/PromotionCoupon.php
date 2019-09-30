<?php


namespace Eres\SyliusReferralMarketingPlugin\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Sylius\Component\Core\Model\PromotionCoupon as BasePromotionCoupon;
use Sylius\Component\Customer\Model\Customer;

/**
 * @Entity
 * @Table(name="sylius_promotion_coupon")
 */
class PromotionCoupon extends BasePromotionCoupon
{
    /**
     * @ManyToOne("Sylius\Component\Customer\Model\CustomerInterface")
     * @JoinColumn(name="customer_id", referencedColumnName="id")
     */
    protected $customer;

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

}
