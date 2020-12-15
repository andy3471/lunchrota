<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Multitenantable {

    protected static function bootMultitenantable()
    {
        if (auth()->check()) {
            static::creating(function ($model) {
                $model->tenant_id = Auth()->user()->tenant_id;
            });

            static::addGlobalScope('tenant_id', function (Builder $builder) {
                $builder->where('tenant_id', Auth()->user()->tenant_id);
            });
        }
    }

}