<?php

/*
 * This file is part of the enhavo package.
 *
 * (c) WE ARE INDEED GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enhavo\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class BooleanType extends AbstractType
{
    public const VALUE_TRUE = '1';
    public const VALUE_FALSE = '0';
    public const VALUE_NULL = 'null';

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CallbackTransformer(
            function ($originalDescription) use ($options) {
                if (true === $originalDescription) {
                    return self::VALUE_TRUE;
                }
                if (false === $originalDescription) {
                    return self::VALUE_FALSE;
                }
                if (null === $originalDescription || '' === $originalDescription) {
                    if (true === $options['default'] || self::VALUE_TRUE === $options['default']) {
                        return self::VALUE_TRUE;
                    }
                    if (false === $options['default'] || self::VALUE_FALSE === $options['default']) {
                        return self::VALUE_FALSE;
                    }

                    return self::VALUE_NULL;
                }

                return $originalDescription;
            },
            function ($submittedDescription) use ($options) {
                if (self::VALUE_TRUE === $submittedDescription) {
                    return true;
                } elseif (self::VALUE_FALSE === $submittedDescription) {
                    return false;
                } elseif (self::VALUE_NULL === $submittedDescription) {
                    return null;
                }

                return $options['default'];
            }
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ('' === $view->vars['value']) {
            $view->vars['value'] = self::VALUE_NULL;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                $this->translator->trans('label.yes', [], 'EnhavoAppBundle') => self::VALUE_TRUE,
                $this->translator->trans('label.no', [], 'EnhavoAppBundle') => self::VALUE_FALSE,
            ],
            'choice_translation_domain' => 'EnhavoAppBundle',
            'translation_domain' => 'EnhavoAppBundle',
            'expanded' => true,
            'multiple' => false,
            'default' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'enhavo_boolean';
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
