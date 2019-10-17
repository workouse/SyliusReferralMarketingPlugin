<?php


namespace Workouse\ReferralMarketingPlugin\Controller;

use Workouse\ReferralMarketingPlugin\Entity\Reference;
use Workouse\ReferralMarketingPlugin\Event\ReferenceEvent;
use Workouse\ReferralMarketingPlugin\Form\Type\ReferenceType;
use Workouse\ReferralMarketingPlugin\Service\TransparentPixelResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ReferenceController extends AbstractController
{
    public function indexAction(): Response
    {
        $references = $this->getDoctrine()->getRepository(Reference::class)->findBy([
            'invitee' => $this->getUser()->getCustomer()
        ]);

        return $this->render('@WorkouseReferralMarketingPlugin/shop/index.html.twig', [
            'references' => $references
        ]);
    }

    public function newAction(Request $request): Response
    {
        $referance = new Reference();
        $referance->setInvitee($this->getUser()->getCustomer());

        $form = $this->createForm(ReferenceType::class, $referance);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $referance = $form->getData();

            $promotionService = $this->get('workouse_referral_marketing_plugin.promotion');

            $referance->setHash($promotionService->createHash($this->getUser()->getCustomer()->getEmail(), $referance->getReferrerEmail()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($referance);
            $em->flush();

            $this->get('sylius.email_sender')->send('reference_invite', [$referance->getReferrerEmail()], [
                'name' => $referance->getReferrerName(),
                'email' => $referance->getReferrerEmail(),
                'hash' => $referance->getHash(),
                'user' => $this->getUser()->getCustomer()
            ]);

            $event = new ReferenceEvent($referance);
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch($event, ReferenceEvent::INVITEE_POST);

            /** @var FlashBagInterface $flashBag */
            $flashBag = $request->getSession()->getBag('flashes');
            $flashBag->add('success', 'workouse_referral_marketing_plugin.referrer.added');

            return $this->redirectToRoute('workouse_referral_marketing_index');
        }

        return $this->render('@WorkouseReferralMarketingPlugin/shop/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function checkAction($hash, $_format)
    {
        /** @var Reference $referrer */
        $referrer = $this->getDoctrine()->getRepository(Reference::class)->findOneBy([
            'hash' => $hash,
            'status' => false
        ]);

        if ($referrer) {
            $referrer->setStatus(true);
            $this->getDoctrine()->getManager()->flush();

            $event = new ReferenceEvent($referrer);
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch($event, ReferenceEvent::REFERRER_POST);

        }

        return new TransparentPixelResponse($_format);

    }
}
