<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendMailable;
use App\Models\Bookings;
use App\Models\SlotMaster;

class BookingController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->bookings = new Bookings();
        $this->slotMaster = new SlotMaster();
    }

    /**
     * Store bookings with customer information
     *
     * @return arr
    */
    public function bookSlots()
    {
        $this->validate($this->request, [
            'customer_name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:10',
            'vehicle_model' => 'required|string',
            'date' => 'required|date_format:Y-m-d',
            'slot_id' => 'required|numeric',
        ]);

        $bookingData = $this->request->all();
        
        // Check if the slot is already booked for that day
        if ($this->bookings->checkBookingExists($bookingData['slot_id'], $bookingData['date'])) {
            return response(['status' => false, 'message' => 'Slot is already booked', 'errors' => ['Slot is already booked']], Response::HTTP_BAD_REQUEST);
        }

        // Save booking
        DB::beginTransaction();
        $this->bookings->saveBooking($bookingData);
        
        // Add slot timing for email text
        $bookingData['slot'] = $this->slotMaster->getSlot($bookingData['slot_id'])->slot_timing;

        // Send booking succesfull email to the client
        $this->sendEmail($bookingData);
        DB::commit();
        
        return response(['status' => true, 'message' => 'Slot is successfully booked'], Response::HTTP_OK);
    }

    /**
     * Email configuration with dispatcher
     *
     * @param arr $data
     * 
     * @return boolean
    */
    public function sendEmail($data)
    {
        $data['subject'] = 'Booking Successfull';

        $recipientEmail = $data['email'];
        $recipientName = $data['customer_name'];

        Mail::to($recipientEmail, $recipientName)
            ->send(new SendMailable($data));
        return true;
    }

    /**
     * Get booking listing data
     *
     * @return arr
    */
    public function getBookings()
    {
        $this->validate($this->request, [
            'date' => 'required|date_format:Y-m-d',
        ]);
        
        $date = $this->request->input('date');

        // Get slot bookings for input date
        $bookingData = $this->bookings->getBookings($date);

        return response(['status' => true, 'message' => 'Data received', 'data' => $bookingData], Response::HTTP_OK);
    }
}
