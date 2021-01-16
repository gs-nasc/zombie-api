<?php

namespace ZombieAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Survivor extends Model {
    protected $table = "survivor";
    public $timestamps = true;
    protected $fillable = ['name', 'birth', 'gender', 'latitude', 'longitude', 'infected'];

    public function inventory() {
        return $this->hasMany(Inventory::class);
    }

    public function reports() {
        return $this->hasMany(Report::class);
    }
}