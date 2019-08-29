<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 28/08/19
 * Time: 09:15
 */

declare(strict_types=1);

namespace App\Form;

use App\Service\CashMachine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Cash Withdrawal Type.
 *
 * @author JCHR <car.chr@gmail.com>
 */
class CashWithdrawalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $bills = CashMachine::getBillsAvailable();
        $minBill = min($bills);

        $builder
            ->add('amount', IntegerType::class, [
                'label' => 'label.amount_withdraw',
                'help' => 'help.amount_withdraw',
                'help_translation_parameters' => [
                    '%bills%' => implode(', ', $bills),
                ],
                'constraints' => [
                    new NotBlank(),
                    new GreaterThanOrEqual($minBill),
                ],
                'attr' => [
                    'min' => $minBill,
                    'step' => $minBill,
                ],
                'required' => true,
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
