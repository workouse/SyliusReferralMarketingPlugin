<?php

declare(strict_types=1);

namespace Workouse\SyliusReferralMarketingPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Workouse\SyliusReferralMarketingPlugin\Entity\Reference;

class ReferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referrerName', TextType::class, [
                'label' => 'workouse_referral_marketing_plugin.form.referrer_name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'workouse_referral_marketing_plugin.referrer_name.not_blank',
                    ]),
                ],
            ])
            ->add('referrer', EmailType::class, [
                'label' => 'workouse_referral_marketing_plugin.form.referrer_email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'workouse_referral_marketing_plugin.referrer_email.not_blank',
                    ]),
                    new Email(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reference::class,
        ]);
    }
}
