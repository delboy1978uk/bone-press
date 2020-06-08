<?php

namespace Bone\Press\Form;

use Del\Form\AbstractForm;
use Del\Form\Field\CheckBox;
use Del\Form\Field\Submit;
use Del\Form\Field\Text;
use Del\Form\Renderer\Field\CheckboxRender;
use Del\Form\Renderer\HorizontalFormRenderer;

class PageForm extends AbstractForm
{
    public function init()
    {
        $this->setFormRenderer(new HorizontalFormRenderer());

        $title = new Text('title');
        $title->setLabel('Title');
        $slug = new Text('slug');
        $slug->setLabel('URL slug');
        $published = new CheckBox('published');
        $published->setOption(1, ' Yes');
        $published->setLabel('Published');
        $published->setRenderer(new CheckboxRender());
        $submit = new Submit('submit');
        $submit->setValue('Update');

        $this->addField($title);
        $this->addField($slug);
        $this->addField($published);
        $this->addField($submit);
    }
}
