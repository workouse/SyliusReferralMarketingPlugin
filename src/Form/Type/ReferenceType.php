<?php


namespace Workouse\ReferralMarketingPlugin\Form\Type;


use Workouse\ReferralMarketingPlugin\Entity\Reference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referrerName', TextType::class, [
                'label' => 'workouse_referral_marketing_plugin.form.referrer_name',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('referrerEmail', EmailType::class, [
                'label' => 'workouse_referral_marketing_plugin.form.referrer_email',
                'constraints' => [
                    new NotBlank(),
                    new Email()
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
