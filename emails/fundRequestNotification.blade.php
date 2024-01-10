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

     <center><img src="{{asset('C:\Users\Damilare.Oloko\Pictures\Textbook\public\img\logo.png')}}"></center>

     <h2>Section 21 C</h2>


     <p>
        “Section 21 C -  <b>{{$ReferencesID}}</b>

Good day,

Please note that <b>{{$SchooName}}</b> – EMIS Number {{$emis}} has requested to use their allocated funds.

Regards
System Support”

     {{-- </p>
        <h2>Procurement Selection Request</h2>
        <p><strong>School Name:</strong> {{ $SchooName }}</p>
        <p><strong>Year:</strong> {{ $year }}</p>
        <p><strong>Selected Value:</strong> {{ $selectedV }}</p>
        <p>School Have Succeefully Select A Procurement Selection</p>
        <p>Thank you for using our application!</p> --}}
    </div>
</body>
</html>
