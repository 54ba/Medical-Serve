<?php

namespace App\Models\Information;


use App\Models\Hospitalization\Hospitalization;

class Picture extends Information
{
    protected $fillable=[
        'source'
    ];
    public $upload_path = 'uploads/pictures';

    public function hospitalization()
    {
        $this->belongsTo(Hospitalization::class);
    }

    public function delete()
    {
        @unlink(storage_path($this->upload_path)."/{$this->source}");

        return parent::delete();
    }
}
