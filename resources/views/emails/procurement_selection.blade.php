<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007BFF;
        }
        p {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">

     <center><img src="{{asset('/img/logo.png')}}"></center>
        <h2>Procurement Selection Request</h2>
        <p><strong>School Name:</strong> {{ $SchooName }}</p>
        <p><strong>Year:</strong> {{ $year }}</p>
        <p><strong>Selected Value:</strong> {{ $selectedV }}</p>
        <p>School Have Succeefully Select A Procurement Selection</p>
        <p>Thank you for using our application!</p>
    </div>
</body>
</html>
