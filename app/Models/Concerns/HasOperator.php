<?php

namespace App\Models\Concerns;

use Encore\Admin\Facades\Admin;

trait HasOperator
{
    public function initializeHasOperator()
    {
        static::saving(function ($model) {
            $this->updateOperator();
        });
    }

    public function updateOperator()
    {
        $by = $this->freshOperator();

        $updatedByColumn = $this->getUpdatedByColumn();

        if (! is_null($updatedByColumn) && ! $this->isDirty($updatedByColumn)) {
            $this->setUpdatedBy($by);
        }

        $createdByColumn = $this->getCreatedByColumn();

        if (! $this->exists && ! is_null($createdByColumn) && ! $this->isDirty($createdByColumn)) {
            $this->setCreatedBy($by);
        }

        return $this;
    }

    public function setCreatedBy($value)
    {
        $this->{$this->getCreatedByColumn()} = $value;

        return $this;
    }

    public function setUpdatedBy($value)
    {
        $this->{$this->getUpdatedByColumn()} = $value;

        return $this;
    }

    public function freshOperator()
    {
        return Admin::user()->name ?? '';
    }

    public function getCreatedByColumn()
    {
        return 'created_by';
    }

    public function getUpdatedByColumn()
    {
        return 'updated_by';
    }
}
