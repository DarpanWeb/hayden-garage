<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'id';

    /**
     * Check if slot is already booked for a particular date
     * 
     * @param int $slotId
     * @param string $date
     *
     * @return boolean
    */
    public function checkBookingExists($slotId, $date)
    {
        return $this->where('date', $date)->where('slot_id', $slotId)->exists();
    }

    /**
     * Save booking information
     * 
     * @param arr $bookingData
     *
     * @return boolean
    */
    public function saveBooking($bookingData)
    {
        return $this->insert($bookingData);
    }

    /**
     * Get booking information
     * 
     * @param string $date
     *
     * @return Illuminate\Support\Collection
    */
    public function getBookings($date)
    {
        return $this->rightJoin('slot_masters', function ($join) use ($date) {
                $join->on('slot_id', 'slot_masters.id')
                    ->where('bookings.date', $date);
            })
            ->leftJoin('disabled_slots', function($join) use ($date){
                $join->on('disabled_slots.slot_id', 'slot_masters.id')
                    ->where('disabled_slots.date', $date);
            })
            ->select(
                'bookings.customer_name',
                'bookings.email',
                'bookings.phone_number',
                'bookings.vehicle_model',
                'bookings.status',
                'bookings.created_at as booking_time',
                'slot_masters.slot_timing',
                'slot_masters.id  as slot_id',
                \DB::raw('CASE 
                    WHEN disabled_slots.slot_id IS NULL AND bookings.slot_id IS NULL THEN 1
                    ELSE 0
                END AS status'),
            )
            ->orderBy('slot_masters.id')
            ->get();
    }
}
