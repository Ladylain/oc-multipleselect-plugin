<?php namespace Ladylain\MultipleSelect\FormWidgets\MultipleSelect;

use Illuminate\Support\Collection;
use October\Rain\Database\Relations\Relation as RelationBase;
use SystemException;

/**
 * HasRelationStore contains logic for related tag items
 */
trait HasRelationLink
{
        /**
     * getLoadValueFromRelation
     */
    protected function getLoadValueFromRelation($keys)
    {
        // Take value from options
        if ($this->useOptions) {
            if (!$keys) {
                return [];
            }

            $result = (new Collection($this->formField->options()))
                ->reject(function($value, $key) use ($keys) {
                    return !in_array($key, $keys);
                })
                ->all();
        }
        // Take existing relationship
        else {
            $result = $this->getRelationObject()->pluck($this->nameFrom, $this->keyFrom)->all();
        }

        // Default value
        if (!$result && !$this->model->exists) {
            return $keys;
        }

        return $result;
    }

    /**
     * getFieldOptionsForRelation
     */
    protected function getFieldOptionsForRelation()
    {
        return RelationBase::noConstraints(function () {
            $query = $this->getRelationObject()->newQuery();

            // Even though "no constraints" is applied, belongsToMany constrains the query
            // by joining its pivot table. Remove all joins from the query.
            $query->getQuery()->getQuery()->joins = [];

            return $query->pluck($this->nameFrom, $this->keyFrom)->all();
        });
    }

    /**
     * processSaveForRelation
     */
    protected function processSaveForRelation($keys)
    {

        if (!$keys) {
            return $keys;
        }

        $relationModel = $this->getRelationModel();

        // Options from form field
        if ($this->useOptions) {
            $existingTags = (new Collection($this->formField->options()))
                ->reject(function($value, $key) use ($keys) {
                    return !in_array($value, $keys);
                })
                ->all()
            ;
        }
        // Options from model
        else {
            $existingTags = $relationModel
                ->whereIn($this->keyFrom, $keys)
                ->pluck($this->nameFrom, $relationModel->getKeyName())
                ->all()
            ;
        }

        return array_keys($existingTags);
    }

    /**
     * getRelationQuery
     */
    protected function getRelationQuery()
    {
        $query = $this->getRelationModel()->newQuery();

        $this->getRelationObject()->addDefinedConstraintsToQuery($query);

        return $query;
    }
}