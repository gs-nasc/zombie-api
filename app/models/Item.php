<?php

namespace ZombieAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    public $timestamps = false;
    protected $fillable = ['name', 'points'];

    public function inventory()
    {
        return $this->belongsToMany(Inventory::class);
    }
}
