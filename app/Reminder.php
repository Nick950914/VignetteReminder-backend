<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    //
    protected $fillable = [
        'title', 'changed_on', 'due_change_date', 'note'
    ];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }
}
