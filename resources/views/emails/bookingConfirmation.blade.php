<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
</head>
<body>
    <h2>Booking Confirmation</h2>
    
    <p>Dear {{ $data['customer_name'] }},</p>
    
    <p>Your booking has been confirmed:</p>
    
    <ul>
        <li><strong>Name:</strong> {{ $data['customer_name'] }}</li>
        <li><strong>Email:</strong> {{ $data['email'] }}</li>
        <li><strong>Phone Number:</strong> {{ $data['phone_number'] }}</li>
        <li><strong>Vehicle Model:</strong> {{ $data['vehicle_model'] }}</li>
        <li><strong>Date:</strong> {{ $data['date'] }}</li>
        <li><strong>Slot:</strong> {{ $data['slot'] }}</li>
    </ul>
    
    <p>Thank you for choosing our service!</p>
</body>
</html>
