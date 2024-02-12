<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Booking List</title>
        @vite('resources/css/adminPanel.css')
        @vite('resources/css/bookingForm.css')
    </head>
    <body>
        <div id="adminPanel"></div>
        @vite('resources/js/adminPanel.js')
    </body>
</html>