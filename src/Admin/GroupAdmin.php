<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class GroupAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('roles')
            ->add('id')
            ->add('slug')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('enabled')
            ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('roles')
            ->add('id')
            ->add('slug')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('enabled')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('roles')
            ->add('id')
            ->add('slug')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('enabled')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('roles')
            ->add('id')
            ->add('slug')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('enabled')
            ;
    }
}
