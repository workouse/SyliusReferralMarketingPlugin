<?php

declare(strict_types=1);

namespace Workouse\SyliusReferralMarketingPlugin\Controller;

use Sylius\Component\Core\Model\Customer;
use Sylius\Component\Core\Model\ShopUser;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Workouse\SyliusReferralMarketingPlugin\Entity\Reference;
use Workouse\SyliusReferralMarketingPlugin\Event\ReferenceEvent;
use Workouse\SyliusReferralMarketingPlugin\Form\Type\ReferenceType;
use Workouse\SyliusReferralMarketingPlugin\Service\TransparentPixelResponse;

class ReferenceController extends AbstractController
{
    /** @var CanonicalizerInterface */
    private $canonicalizer;

    /** @var GeneratorInterface */
    private $tokenGenerator;

    public function __construct(CanonicalizerInterface $canonicalizer, GeneratorInterface $tokenGenerator)
    {
        $this->canonicalizer = $canonicalizer;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function indexAction(): Response
    {
        /** @var ShopUser $user */
        $user = $this->getUser();
        /** @var Customer $customer */
        $customer = $user->getCustomer();

        $references = $this->getDoctrine()->getRepository(Reference::class)->findBy([
            'invitee' => $customer,
        ]);

        return $this->render('@WorkouseSyliusReferralMarketingPlugin/shop/index.html.twig', [
            'references' => $references,
        ]);
    }

    public function newAction(Request $request): Response
    {
        /** @var ShopUser $user */
        $user = $this->getUser();
        $reference = new Reference();
        $reference->setInvitee($user->getCustomer());

        $form = $this->createForm(ReferenceType::class, $reference);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reference = $form->getData();

            $em = $this->getDoctrine()->getManager();
            /** @var FactoryInterface $customerFactory */
            $customerFactory = $this->get('sylius.factory.customer');
            /** @var Customer $customer */
            $customer = $customerFactory->createNew();
            $customer->setEmail($reference->getReferrer());
            $customer->setEmailCanonical($this->canonicalizer->canonicalize($reference->getReferrer()));
            $em->persist($customer);
            $em->flush();

            $reference->setReferrer($customer);
            $reference->setHash($this->tokenGenerator->generate());
            $em->persist($reference);

            $em->flush();

            /** @var SenderInterface $emailSender */
            $emailSender = $this->get('sylius.email_sender');
            $emailSender->send('reference_invite', [$reference->getReferrer()->getEmail()], [
                'name' => $reference->getReferrerName(),
                'email' => $reference->getReferrer()->getEmail(),
                'hash' => $reference->getHash(),
                'user' => $reference->getInvitee(),
            ]);

            $event = new ReferenceEvent($reference);
            /** @var TraceableEventDispatcher $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch($event, ReferenceEvent::INVITEE_POST);

            /** @var FlashBagInterface $flashBag */
            $flashBag = $request->getSession()->getBag('flashes');
            $flashBag->add('success', 'workouse_referral_marketing_plugin.referrer.added');

            return $this->redirectToRoute('workouse_referral_marketing_index');
        }

        return $this->render('@WorkouseSyliusReferralMarketingPlugin/shop/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function checkAction($hash, $_format)
    {
        /** @var Reference $referrer */
        $referrer = $this->getDoctrine()->getRepository(Reference::class)->findOneBy([
            'hash' => $hash,
            'status' => false,
        ]);

        if ($referrer instanceof Reference) {
            $referrer->setStatus(true);
            $this->getDoctrine()->getManager()->flush();

            $event = new ReferenceEvent($referrer);
            /** @var TraceableEventDispatcher $dispatcher */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch($event, ReferenceEvent::REFERRER_POST);
        }

        return new TransparentPixelResponse($_format);
    }
}
