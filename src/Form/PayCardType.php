<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 28/08/19
 * Time: 22:27
 */

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Pay Card Type.
 *
 * @author JCHR <car.chr@gmail.com>
 */
class PayCardType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('balance', ChoiceType::class, [
                'label' => 'label.pay_card_balance',
                'choices' => [
                    'operation_balance' => true,
                    'operation_custom_amount' => false,
                ],
                'expanded' => true,
                'required' => true,
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('amount', NumberType::class, [
                'label' => 'label.amount_payable',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
