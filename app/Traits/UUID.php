<?php

namespace App\Traits;
use Illuminate\Support\Str;

Trait UUID 
{
		
	protected static function boot()
	{
	    parent::boot();

	    static::creating(function ($model) {
	       $model->id = (string) Str::uuid();
	    });
	}
}