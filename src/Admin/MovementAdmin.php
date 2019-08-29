<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 29/08/19
 * Time: 00:45
 */

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Account;
use App\Entity\Movement;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Movement Admin.
 *
 * @author JCHR <car.chr@gmail.com>
 */
final class MovementAdmin extends AbstractAdmin
{
    /** {@inheritdoc} */
    protected $datagridValues = [
        '_sort_order' => 'DESC',
    ];

    /** {@inheritdoc} */
    protected $baseRoutePattern = 'movement';

    /** {@inheritdoc} */
    protected $baseRouteName = 'admin_movement';

    /** {@inheritdoc} */
    protected $classnameLabel = 'admin.movement';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('delete');
        $collection->remove('edit');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('account.client.name', null, [
                'label' => 'label.name',
            ])
            ->add('account.client.lastname', null, [
                'label' => 'label.lastname',
            ])
            ->add('account.cardNumber', null, [
                'label' => 'label.card_number',
            ])
            ->add('account.type', ChoiceFilter::class, [
                'label' => 'label.account_type',
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => Account::getTypeList(),
                ],
            ])
            ->add('amount', null, [
                'label' => 'label.movement_amount',
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
            ->add('account.client', null, [
                'label' => 'label.client',
            ])
            ->add('account', null, [
                'label' => 'label.card_number',
                'associated_property' => 'cardNumber',
            ])
            ->add('account.type', 'choice', [
                'label' => 'label.account_type',
                'choices' => array_flip(Account::getTypeList()),
                'catalogue' => 'messages',
            ])
            ->add('type', 'choice', [
                'label' => 'label.movement_type',
                'choices' => array_flip(Movement::getTypeList()),
                'catalogue' => 'messages',
            ])
            ->add('amount', 'currency', [
                'label' => 'label.movement_amount',
                'code' => 'getAmountFormat',
                'currency' => '$',
            ])
            ->add('createdAt', null, [
                'label' => 'label.created_at',
                'format' => 'd/m/Y H:i',
            ])
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->with('label.movement_detail', [
                'class' => 'col-md-6',
            ])
                ->add('id', null, [
                    'label' => 'label.id',
                ])
                ->add('account.client', null, [
                    'label' => 'label.client',
                ])
                ->add('account', null, [
                    'label' => 'label.card_number',
                    'associated_property' => 'cardNumber',
                ])
                ->add('account.type', 'choice', [
                    'label' => 'label.account_type',
                    'choices' => array_flip(Account::getTypeList()),
                    'catalogue' => 'messages',
                ])
                ->add('type', 'choice', [
                    'label' => 'label.movement_type',
                    'choices' => array_flip(Movement::getTypeList()),
                    'catalogue' => 'messages',
                ])
                ->add('amount', 'currency', [
                    'label' => 'label.movement_amount',
                    'code' => 'getAmountFormat',
                    'currency' => '$',
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
