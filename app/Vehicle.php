<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //
    protected $fillable = [
        'name', 'vehicle_reg_no', 'frame_no', 'sticker_no'
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function reminders() {
        return $this->hasMany(Reminder::class);
    }
}
