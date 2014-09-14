<?php
namespace FormManager;

use FormManager\Fields\Field;

class Bootstrap
{
    /**
     * Magic method to generate bootstrap fields
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return Field
     */
    public static function __callStatic($name, $arguments)
    {
        $field = Field::__callStatic($name, $arguments);

        return $field->render(__CLASS__.'::'.self::getTemplate($field));
    }

    /**
     * Generate a bootstrap standard form
     *
     * @param null|array $fields
     *
     * @return Form
     */
    public static function form(array $fields = null)
    {
        $form = new Form();

        if ($fields) {
            $form->add($fields);
        }

        return $form->rule('form');
    }

    /**
     * Generate a bootstrap horizontal form
     *
     * @param null|array $fields
     *
     * @return Form
     */
    public static function formHorizontal(array $fields = null)
    {
        return self::form($fields)->addClass('form-horizontal');
    }

    /**
     * Generate a bootstrap inline form
     *
     * @param null|array $fields
     *
     * @return Form
     */
    public static function formInline(array $fields = null)
    {
        return self::form($fields)->addClass('form-inline');
    }

    /**
     * Returns the render template name used in a field
     *
     * @param Field $field
     *
     * @return string
     */
    public static function getTemplate($field)
    {
        $input = $field->input;

        switch ($input->getElementName()) {
            case 'textarea':
            case 'select':
                return 'formGroupTemplate';

            case 'button':
                return 'buttonTemplate';

            case 'input':
                switch ($input->attr('type')) {
                    case 'checkbox':
                    case 'radio':
                        return 'radioCheckboxTemplate';

                    case 'submit':
                    case 'reset':
                    case 'button':
                        return 'buttonTemplate';

                    default:
                        return 'formGroupTemplate';
                }
        }
    }

    /**
	 * Generates a basic control-group
	 *
	 * <div class="form-group">
     *     <label class="control-label"></label>
     *     <input class="form-control">
     * </div>
     *
     * @param Field $field
     *
     * @return string
     */
    public static function formGroupTemplate($field)
    {
        $form = $field->input->getForm();

        if ($form->hasClass('form-inline')) {
            $field->label->addClass('sr-only');
        } else {
            $field->label->addClass('control-label');
        }

        $field->input->addClass('form-control');

        $html = self::getInputHtml($field);

        //Horizontal form
        if ($form->hasClass('form-horizontal')) {
            $field->label->addClass('col-sm-2');
            $html = Element::div(true)->addClass('col-sm-10')->toHtml($html);
        }

        return self::getFormGroupHtml($field, $field->label.$html);
    }

    /**
	 * Generates a checkbox control-group
	 *
	 * <div class="checkbox">
     *     <label><input> </label>
     * </div>
     *
     * @param Field $field
     *
     * @return string
     */
    public static function radioCheckboxTemplate($field)
    {
        $form = $field->input->getForm();

        $html = self::getRadioCheckHtml($field);

        //Horizontal form
        if ($form->hasClass('form-horizontal')) {
            $html = Element::div(true)->addClass('col-sm-offset-2 col-sm-10')->toHtml($html);
        }

        return self::getFormGroupHtml($field, $html);
    }

    /**
	 * Generates a button control-group
	 *
     * <div class="form-group">
     *     <input class="btn">
     * </div>
     *
     * @param Field $field
     *
     * @return string
     */
    public static function buttonTemplate($field)
    {
        $form = $field->input->getForm();

        $html = $field->input->addClass('btn')->toHtml();

        //Horizontal form
        if ($form->hasClass('form-horizontal')) {
            $html = Element::div(true)->addClass('col-sm-offset-2 col-sm-10')->toHtml($html);
        }

        return self::getFormGroupHtml($field, $html);
    }

    /**
     * Generates a html code of the form-group div used in all templates
     *
     * @param Field  $field
     * @param string $html
     *
     * @return string
     */
    private static function getFormGroupHtml($field, $html)
    {
        $group = Element::div(true)->class('form-group');

        if ($field->error()) {
            $group->addClass('has-error');
        }

        if ($field->input->attr('disabled')) {
            $group->addClass('disabled');
        }

        switch ($field->get('size')) {
            case 'lg':
                $group->addClass('form-group-lg');
                break;

            case 'sm':
                $group->addClass('form-group-sm');
                break;
        }

        return $group->toHtml($html).' ';
    }

    /**
     * Generates the html code of a field
     *
     * @param Field $field
     *
     * @return string
     */
    private static function getInputHtml($field)
    {
        $html = $field->input->toHtml();

        //Errors
        if ($field->error()) {
            $field->errorLabel->addClass('text-danger');
        }

        //Input addons
        $addon = $field->get('addon-before') ?: $field->get('addon-after');

        if ($addon) {
            $addon = '<div class="input-group-addon">'.$addon.'</div>';

            if ($field->get('addon-before')) {
                $html = $addon.$html;
            } else {
                $html = $html.$addon;
            }

            $html = Element::div(true)->class('input-group')->toHtml($html);
        }

        $html .= $field->errorLabel;

        //Help block
        if ($help = $field->get('help')) {
            $html .= Element::span(true)->class('help-block')->toHtml($help);
        }

        return $html;
    }

    /**
     * Generates the html code of a checkbox/radio field
     *
     * @param Field $field
     *
     * @return string
     */
    private static function getRadioCheckHtml($field)
    {
        //Errors
        if ($field->error()) {
            $field->errorLabel->addClass('text-danger');
        }

        //Generates random id if not defined
        $field->input->id();

        $html = $field->input->toHtml();
        $html = $field->label->toHtml($html.' ').$field->errorLabel;
        $html = Element::div(true)->class($field->input->attr('type'))->toHtml($html);

        //Help block
        if ($help = $field->get('help')) {
            $html .= Element::span(true)->class('help-block')->toHtml($help);
        }

        return $html;
    }
}
