<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 26/08/19
 * Time: 19:04
 */

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Account;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Account Admin.
 *
 * @author JCHR <car.chr@gmail.com>
 */
final class AccountAdmin extends AbstractAdmin
{

    /** {@inheritdoc} */
    protected $baseRouteName = 'admin_account';

    /** {@inheritdoc} */
    protected $baseRoutePattern = 'account';

    /** {@inheritdoc} */
    protected $classnameLabel = 'admin.account';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('client', null, [
                'label' => 'label.client',
            ])
            ->add('type', ChoiceFilter::class, [
                'label' => 'label.account_type',
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => Account::getTypeList(),
                ],
            ])
            ->add('number', null, [
                'label' => 'label.account_number',
            ])
            ->add('cardNumber', null, [
                'label' => 'label.card_number',
            ])
            ->add('amount', null, [
                'label' => 'label.amount',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('id', null, [
                'label' => 'label.id',
            ])
            ->add('client', null, [
                'label' => 'label.client',
            ])
            ->add('type', 'choice', [
                'label' => 'label.account_type',
                'choices' => array_flip(Account::getTypeList()),
                'catalogue' => 'messages',
            ])
            ->add('number', null, [
                'label' => 'label.account_number',
            ])
            ->add('cardNumber', null, [
                'label' => 'label.card_number',
            ])
            ->add('amount', null, [
                'label' => 'label.amount',
            ])
            ->add('balance', null, [
                'label' => 'label.balance',
            ])
            ->add('createdAt', null, [
                'label' => 'label.created_at',
                'format' => 'd/m/Y H:i',
            ])
            ->add('updatedAt', null, [
                'label' => 'label.updated_at',
                'format' => 'd/m/Y H:i',
            ])
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('label.account', [
                'class' => 'col-md-6',
            ])
                ->add('client', null, [
                    'label' => 'label.client',
                    'placeholder' => '',
                ])
                ->add('type', ChoiceType::class, [
                    'label' => 'label.account_type',
                    'choices' => Account::getTypeList(),
                    'placeholder' => '',
                ])
                ->add('number', null, [
                    'label' => 'label.account_number',
                    'help' => 'help.debit_card',
                ])
                ->add('clabe', null, [
                    'label' => 'label.clabe',
                    'help' => 'help.debit_card',
                ])
                ->add('amount', null, [
                    'label' => 'label.amount',
                ])
            ->end()
            ->with('label.card', [
                'class' => 'col-md-6',
            ])
                ->add('cardNumber', null, [
                    'label' => 'label.card_number',
                ])
                ->add('expiryMonth', null, [
                    'label' => 'label.expiry_month',
                ])
                ->add('expiryYear', null, [
                    'label' => 'label.expiry_year',
                ])
                ->add('cvc', null, [
                    'label' => 'label.cvc',
                ])
                ->add('pin', null, [
                    'label' => 'label.pin',
                ])
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->with('label.account', [
                'class' => 'col-md-6',
            ])
                ->add('id', null, [
                    'label' => 'label.id',
                ])
                ->add('client', null, [
                    'label' => 'label.client',
                    'placeholder' => '',
                ])
                ->add('type', 'choice', [
                    'label' => 'label.account_type',
                    'choices' => array_flip(Account::getTypeList()),
                    'catalogue' => 'messages',
                ])
                ->add('number', null, [
                    'label' => 'label.account_number',
                    'help' => 'help.debit_card',
                ])
                ->add('clabe', null, [
                    'label' => 'label.clabe',
                    'help' => 'help.debit_card',
                ])
                ->add('amount', null, [
                    'label' => 'label.amount',
                ])
                ->add('balance', null, [
                    'label' => 'label.balance',
                ])
            ->end()
            ->with('label.card', [
                'class' => 'col-md-6',
            ])
                ->add('cardNumber', null, [
                    'label' => 'label.card_number',
                ])
                ->add('expiryMonth', null, [
                    'label' => 'label.expiry_month',
                ])
                ->add('expiryYear', null, [
                    'label' => 'label.expiry_year',
                ])
            ->end()
            ->with('label.dates', [
                'class' => 'col-md-6',
            ])
                ->add('createdAt', null, [
                    'label' => 'label.created_at',
                    'format' => 'd/m/Y H:i',
                ])
                ->add('updatedAt', null, [
                    'label' => 'label.updated_at',
                    'format' => 'd/m/Y H:i',
                ])
            ->end()
        ;
    }
}
