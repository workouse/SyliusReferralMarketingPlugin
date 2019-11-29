<?php

declare(strict_types=1);

namespace Tests\Workouse\SyliusReferralMarketingPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManager;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\Workouse\SyliusReferralMarketingPlugin\Behat\Page\Shop\ReferenceCheckPage;
use Tests\Workouse\SyliusReferralMarketingPlugin\Behat\Page\Shop\ReferenceIndexPage;
use Tests\Workouse\SyliusReferralMarketingPlugin\Behat\Page\Shop\ReferenceNewPage;
use Webmozart\Assert\Assert;
use Workouse\SyliusReferralMarketingPlugin\Entity\Reference;

final class ReferenceContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var CurrentPageResolverInterface */
    private $currentPageResolver;

    /** @var NotificationCheckerInterface */
    private $notificationChecker;

    /** @var ReferenceNewPage */
    private $createPage;

    /** @var ReferenceIndexPage */
    private $indexPage;

    /** @var ReferenceCheckPage */
    private $checkPage;

    /** @var EntityManager */
    private $entityManager;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        ReferenceNewPage $referenceNewPage,
        ReferenceIndexPage $referenceIndexPage,
        ReferenceCheckPage $referenceCheckPage,
        EntityManager $entityManager
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->createPage = $referenceNewPage;
        $this->indexPage = $referenceIndexPage;
        $this->checkPage = $referenceCheckPage;
        $this->entityManager = $entityManager;
    }

    /**
     * @When I go to the create referrer
     */
    public function iGoToTheCreateReferrer(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I fill the Referrer Name with :referrer_name
     */
    public function iFillTheReferrerNameWith(string $referrerName): void
    {
        $this->resolveCurrentPage()->fillReferrerName($referrerName);

        $this->sharedStorage->set('referrer_name', $referrerName);
    }

    /**
     * @When I fill the Referrer Email with :referrer_email
     */
    public function iFillTheReferrerEmailWith(string $referrerEmail): void
    {
        $this->resolveCurrentPage()->fillReferrerEmail($referrerEmail);

        $this->sharedStorage->set('referrer_email', $referrerEmail);
    }

    /**
     * @When I add it
     * @When I try to add it
     */
    public function iAddIt(): void
    {
        $this->resolveCurrentPage()->create();
    }

    /**
     * @Then I should be notified that the referral has been created
     */
    public function iShouldBeNotifiedThatNewReferralWasCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Reference has been successfully added.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that there is already an existing referral with provided email
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingReferralWithEmail(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            'This user is registered in the system',
            false
        ));
    }

    /**
     * @Then I should be notified that there is already an existing in customer referral with provided email
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingInCustomerReferralWithEmail(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            'This user is registered in the system',
            false
        ));
    }

    /**
     * @Then I should be notified that :fields fields cannot be blank
     */
    public function iShouldBeNotifiedThatFieldsCannotBeBlank(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                '%s cannot be blank.',
                trim($field)
            )));
        }
    }

    /**
     * @Given there is an existing referral with :email email
     */
    public function thereIsAnExistingPageWithCode(string $email): void
    {
        $this->iGoToTheCreateReferrer();
        $this->iFillTheReferrerNameWith($email);
        $this->iFillTheReferrerEmailWith($email);
        $this->iAddIt();
    }

    /**
     * @When I go to the referrer list
     */
    public function iOpenInviteeMail()
    {
        $this->indexPage->open();
    }

    /**
     * @When I should be referral status :status
     */
    public function foo($status)
    {
        Assert::same($this->indexPage->getStatus(), $status);
    }

    /**
     * @When I go to the referrer check
     */
    public function bar()
    {
        $this->checkPage->open([
            'hash' => $this->entityManager->getRepository(Reference::class)->findAll()[0]->getHash(),
        ]);
    }

    private function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->createPage,
        ]);
    }
}
