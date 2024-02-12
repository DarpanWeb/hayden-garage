<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotMaster extends Model
{
    use HasFactory;

    protected $table = 'slot_masters';
    protected $primaryKey = 'id';

    /**
     * Get slot information
     * 
     * @param arr $whereCondition
     *
     * @return Illuminate\Support\Collection
    */
    public function getSlotData($whereCondition)
    {
        return $this->where($whereCondition)->get();
    }

    /**
     * Get slot information by slot ID
     * 
     * @param int slotId
     *
     * @return App\Models\SlotMaster
    */
    public function getSlot($slotId)
    {
        return $this->where('id', $slotId)->first();
    }

    /**
     * Get all available slots that can be booked
     * 
     * @param string $date
     *
     * @return Illuminate\Support\Collection
    */
    public function getAvailableSlots($date)
    {
        return $this->leftJoin('disabled_slots', function($join) use ($date){
            $join->on('disabled_slots.slot_id', 'slot_masters.id')
                ->where('disabled_slots.date', $date);
            })
            ->leftJoin('bookings', function($join) use ($date){
                $join->on('bookings.slot_id', 'slot_masters.id')
                    ->where('bookings.date', $date);
                })
            ->select(
                'slot_masters.id as slot_id',
                'slot_masters.slot_timing',
                \DB::raw('CASE 
                    WHEN disabled_slots.slot_id IS NULL AND bookings.slot_id IS NULL THEN 1
                    ELSE 0
                 END AS status'),
            )
            ->where('slot_masters.status', config('constants.STATUSES.ENABLED'))
            ->orderBy('slot_masters.id')
            ->get();
    }
}
