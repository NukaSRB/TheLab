<?php

namespace App\Services\Backpack\Filters;

class DropDown
{
    /**
     * @var string
     */
    public $column;

    /**
     * @var string
     */
    public $label;

    /**
     * @var array
     */
    public $values;

    /**
     * @var array
     */
    public $options;

    /**
     * DropDown constructor.
     *
     * @param string $column
     * @param string $label
     * @param array  $values
     */
    public function __construct($column, $label, array $values)
    {
        $this->column = $column;
        $this->label  = $label;
        $this->values = $values;

        $this->setOptions();
    }

    public function setOptions()
    {
        $this->options = [
            'name'  => $this->column,
            'label' => $this->label,
            'type'  => 'dropdown',
        ];
    }

    public function logic($value)
    {
        $this->crud->addClause('where', $this->column, $value);
    }
}
