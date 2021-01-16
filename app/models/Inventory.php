<?php

namespace ZombieAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = "survivor_item";
    public $timestamps = false;
    protected $fillable = ['survivor_id', 'item_id', 'qty'];
    
    public function item() {
        return $this->belongsTo(Item::class);
    }

}
