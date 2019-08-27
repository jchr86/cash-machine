<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 26/08/19
 * Time: 12:32
 */

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Client;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Client Admin.
 *
 * @author JCHR <car.chr@gmail.com>
 */
final class ClientAdmin extends AbstractAdmin
{
    /** {@inheritdoc} */
    protected $baseRouteName = 'admin_client';

    /** {@inheritdoc} */
    protected $baseRoutePattern = 'client';

    /** {@inheritdoc} */
    protected $classnameLabel = 'admin.client';

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
            ->add('name', null, [
                'label' => 'label.name',
            ])
            ->add('lastname', null, [
                'label' => 'label.lastname',
            ])
            ->add('email', null, [
                'label' => 'label.email',
            ])
            ->add('gender', ChoiceFilter::class, [
                'label' => 'label.gender',
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => Client::getGenderList(),
                ],
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
            ->add('name', null, [
                'label' => 'label.name',
            ])
            ->add('lastname', null, [
                'label' => 'label.lastname',
            ])
            ->add('email', null, [
                'label' => 'label.email',
            ])
            ->add('gender', 'choice', [
                'label' => 'label.gender',
                'choices' => array_flip(Client::getGenderList()),
                'catalogue' => 'messages',
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
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('label.personal_data', [
                'class' => 'col-md-6',
            ])
                ->add('name', null, [
                    'label' => 'label.name',
                ])
                ->add('lastname', null, [
                    'label' => 'label.lastname',
                ])
                ->add('email', null, [
                    'label' => 'label.email',
                ])
                ->add('gender', ChoiceType::class, [
                    'label' => 'label.gender',
                    'choices' => Client::getGenderList(),
                    'placeholder' => '',
                ])
            ->end()
            ->with('label.address', [
                'class' => 'col-md-6',
            ])
                ->add('street', null, [
                    'label' => 'label.street',
                ])
                ->add('externalNum', null, [
                    'label' => 'label.external_num',
                ])
                ->add('internalNum', null, [
                    'label' => 'label.internal_num',
                ])
                ->add('suburb', null, [
                    'label' => 'label.suburb',
                ])
                ->add('town', null, [
                    'label' => 'label.town',
                ])
                ->add('state', null, [
                    'label' => 'label.state',
                ])
                ->add('postalCode', null, [
                    'label' => 'label.postal_code',
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
            ->with('label.personal_data', [
                'class' => 'col-md-6',
            ])
                ->add('id', null, [
                    'label' => 'label.id',
                ])
                ->add('name', null, [
                    'label' => 'label.name',
                ])
                ->add('lastname', null, [
                    'label' => 'label.lastname',
                ])
                ->add('email', null, [
                    'label' => 'label.email',
                ])
                ->add('gender', 'choice', [
                    'label' => 'label.gender',
                    'choices' => array_flip(Client::getGenderList()),
                    'catalogue' => 'messages',
                ])
            ->end()
            ->with('label.address', [
                'class' => 'col-md-6',
            ])
                ->add('street', null, [
                    'label' => 'label.street',
                ])
                ->add('externalNum', null, [
                    'label' => 'label.external_num',
                ])
                ->add('internalNum', null, [
                    'label' => 'label.internal_num',
                ])
                ->add('suburb', null, [
                    'label' => 'label.suburb',
                ])
                ->add('town', null, [
                    'label' => 'label.town',
                ])
                ->add('state', null, [
                    'label' => 'label.state',
                ])
                ->add('postalCode', null, [
                    'label' => 'label.postal_code',
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
