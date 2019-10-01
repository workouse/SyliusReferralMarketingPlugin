<?php


namespace Eres\SyliusReferralMarketingPlugin\Entity;

use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Sylius\Component\Customer\Model\Customer;

trait PromotionCouponTrait
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
