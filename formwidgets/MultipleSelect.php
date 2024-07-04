<?php namespace Ladylain\MultipleSelect\FormWidgets;

use Backend\Classes\FormWidgetBase;


/**
 * MultipleSelect Form Widget
 *
 * @link https://docs.octobercms.com/3.x/extend/forms/form-widgets.html
 */
class MultipleSelect extends FormWidgetBase
{
    use \Backend\Traits\FormModelWidget;
    use \Backend\FormWidgets\TagList\HasStringStore;
    use \Ladylain\MultipleSelect\FormWidgets\MultipleSelect\HasRelationLink;

    const MODE_ARRAY = 'array';
    const MODE_STRING = 'string';
    const MODE_RELATION = 'relation';

    /**
     * @var string separator for tags: space, comma.
     */
    public $separator = 'comma';

     /**
     * @var mixed options settings. Set to true to get from model.
     */
    public $options;

    /**
     * @var string mode for the return value. Values: string, array, relation.
     */
    public $mode;

    /**
     * @var string nameFrom if mode is relation, model column to use for the name reference.
     */
    public $nameFrom = 'name';

    /**
     * @var bool useKey instead of value for saving and reading data.
     */
    public $keyFrom = 'id';


    /**
     * @var bool useOptions
     */
    protected $useOptions = false;

    protected $defaultAlias = 'multiselect';

    public function init()
    {
        $this->fillFromConfig([
            'options',
            'mode',
            'nameFrom',
            'keyFrom'
        ]);

        $this->processMode();

        $this->useOptions = $this->formField->options !== null;
    }

    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('multipleselect');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['fieldOptions'] = $this->getFieldOptions();
        $this->vars['selectedValues'] = $this->getLoadValue();
    }

    public function loadAssets()
    {
        $this->addCss('css/multipleselect.css');
        $this->addJs('js/multipleselect.js');
    }

    public function getSaveValue($value)
    {
        return explode(',',$value);
    }

        /**
     * processMode
     */
    protected function processMode()
    {
        // Set by config
        if ($this->mode !== null) {
            return;
        }

        [$model, $attribute] = $this->nearestModelAttribute($this->valueFrom);

        if ($model instanceof Model && $model->hasRelation($attribute)) {
            $this->mode = static::MODE_RELATION;
            return;
        }

        if ($model instanceof Model && $model->isJsonable($attribute)) {
            $this->mode = static::MODE_ARRAY;
            return;
        }

        $this->mode = static::MODE_STRING;
    }

        /**
     * @inheritDoc
     */
    public function getLoadValue()
    {
        $value = parent::getLoadValue();

        if ($this->mode === static::MODE_RELATION) {
            return $this->getLoadValueFromRelation($value);
        }

        if (!is_array($value) && $this->mode === static::MODE_STRING) {
            return $this->getLoadValueFromString($value);
        }

        return $value;
    }

    /**
     * getFieldOptions returns defined field options, or from the relation if available.
     * @return array
     */
    public function getFieldOptions()
    {
        $options = [];

        if ($this->useOptions) {
            $options = $this->formField->options();
        }
        elseif ($this->mode === static::MODE_RELATION) {
            $options = $this->getFieldOptionsForRelation();
        }

        foreach ($options as $value) {
            if (!is_scalar($value)) {
                throw new SystemException("Field options for [{$this->fieldName}] must be scalar value when used in a multiple select.");
            }
        }

        return $options;
    }
}
