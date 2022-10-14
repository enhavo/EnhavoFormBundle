<?php

namespace Enhavo\Bundle\FormBundle\Form\VueType;

use Enhavo\Bundle\VueFormBundle\Form\AbstractVueType;
use Enhavo\Bundle\VueFormBundle\Form\VueData;
use Symfony\Component\Form\FormView;

class PositionVueType extends AbstractVueType
{
    public static function supports(FormView $formView): bool
    {
        return in_array('enhavo_position', $formView->vars['block_prefixes']);
    }

    public function buildView(FormView $view, VueData $data)
    {
        $data['position'] = true;
    }
}
