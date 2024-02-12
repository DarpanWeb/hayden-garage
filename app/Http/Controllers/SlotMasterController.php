<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Bookings;
use App\Models\SlotMaster;
use App\Models\DisabledSlots;

class SlotMasterController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->bookings = new Bookings();
        $this->slotMaster = new SlotMaster();
        $this->disabledSlots = new DisabledSlots();
    }

    /**
     * Store data to disable slots
     *
     * @return arr
    */
    public function disableSlots()
    {
        $this->validate($this->request, [
            'date' => 'required|date_format:Y-m-d',
            'slot_ids' => 'required|array',
        ]);
        
        $date = $this->request->input('date');
        $slotIds = $this->request->input('slot_ids');

        // Create array to disable slots for particular date
        foreach ($slotIds as $slotId) {
            $insertArray[] = [
                'date' => $date,
                'slot_id' => $slotId,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->disabledSlots->saveData($insertArray);

        return response(['status' => true, 'message' => 'Slots are successfully disabled'], Response::HTTP_OK);
    }

    /**
     * Get available slots for booking
     *
     * @return arr
    */
    public function getAvailableSlots() {
        $this->validate($this->request, [
            'date' => 'required|date_format:Y-m-d',
        ]);

        $date = $this->request->input('date');
        $availableSlots = $this->slotMaster->getAvailableSlots($date);

        return response(['status' => true, 'message' => 'Slots are successfully disabled', 'data' => $availableSlots], Response::HTTP_OK);
    }
}
