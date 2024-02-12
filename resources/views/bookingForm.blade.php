<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Booking Form</title>
        @vite('resources/css/bookingForm.css')
    </head>
    <body>
        <div id="bookingForm"></div>
        @vite('resources/js/bookingForm.js')
    </body>
</html>