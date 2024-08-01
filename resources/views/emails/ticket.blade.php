<!DOCTYPE html>
<html>
<head>
    <title>Ticket Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h3 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
        }

        h4 {
            color: #333;
            border-bottom: 2px solid #f4f4f4;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            line-height: 1.6;
            margin: 10px 0;
        }

        .ticket-info {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
        }

        .ticket-info p {
            margin: 5px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h3>Successful Raise Your Ticket</h3>
    <h4>Details</h4>
    <div class="ticket-info">
        <p>Name: {{ $ticket->name }}</p>
        <p>Mobile: {{ $ticket->mobile }}</p>
        <p>Reference Number: {{ $ticket->reference_number }}</p>
    </div>
</div>
</body>
</html>
