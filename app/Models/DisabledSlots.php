<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisabledSlots extends Model
{
    use HasFactory;

    protected $table = 'disabled_slots';
    protected $primaryKey = 'id';

    /**
     * Save disabled slots information
     * 
     * @param arr $disabledSlots
     *
     * @return boolean
    */
    public function saveData($disabledSlots)
    {
        return $this->insert($disabledSlots);
    }
}
