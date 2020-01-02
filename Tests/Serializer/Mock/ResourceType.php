<?php

/**
 * ResourceType.php
 *
 * @since 12/06/16
 * @author gseidel
 */

namespace Enhavo\Bundle\FormBundle\Serializer\Mock;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);
        $builder->add('resources', CollectionType::class, [
            'entry_type' => ResourceType::class
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults( array(
            'data_class' => Resource::class,
        ));
    }
}