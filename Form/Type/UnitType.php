<?php
/**
 * Created by PhpStorm.
 * User: jenny
 * Date: 10.01.17
 * Time: 14:41
 */

namespace Enhavo\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;

class UnitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new CallbackTransformer(
                function ($currencyAsInt) {
                    //int -> text
                    $string = (string)$currencyAsInt;
                    $string = str_replace('.', ',', $string);
                    return $string;
                },
                function ($currencyAsString) {
                    //text -> int
                    $string = $currencyAsString;
                    $string = str_replace(',', '.', $string);
                    return $string;
                }
            ));
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'enhavo_unit';
    }
}
