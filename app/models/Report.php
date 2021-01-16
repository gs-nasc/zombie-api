<?php

namespace ZombieAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'report';
    public $timestamps = false;
    protected $fillable = ['survivor_id'];

    public function survivor() {
        return $this->belongsTo(Survivor::class);
    }

}
