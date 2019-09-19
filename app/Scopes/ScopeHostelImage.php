<?php
/**
 * Created by PhpStorm.
 * User: kuatekevin
 * Date: 14/09/2019
 * Time: 13:16
 */

namespace App\Scopes;


use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ScopeHostelImage implements Scope
{


    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('rel','=','hostel');
    }
}