<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <title>Document</title>
    <style>
        .box{
            border: 2px solid black;
            padding: 30px;
            width: 200px;
            height: 100px;
            margin-left: 1150px;
        }

        .box1{
            border: 2px solid black;
            padding: 30px;
            width: 200px;
            height: 100px;
            margin-left: 1150px;
            margin-top: -30px;
        }


        table{
            margin-top: -100px;
        }

        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:27px;
        }
    </style>
  </head>
  <body>
    <div class="container">
      <h3>The Manager</h3>
      <br />
      @foreach ($CapturedData as $item)

      <u>{{$item->email}}</u>________________<br /><br>
      <u>{{$item->CompanyAddress}}</u>__________<br /><br>
      <u>{{$item->CompanyContact}}</u>______<br /><br>
<br>
      <br>
      <p>ORDER FOR THE PURCHASE FOR {{session('requestType')}}</p><br>

      <ol>
        <li> I, <u>{{$school_principal}}, </u>Principal of <u>{{session('schoolname')}}________________________<br></u>School Confirm that the School has  been granted Section 21(1)(c) function and has been mandated by the Department to place orders <br> for stationery / textbooks.</li><br><br>
        <li> The date <u>{{$QuoteDate}} ,  </u>for the supply and delivery of stationery / textbooks has been found to be favourable</li><br><br>
        <li>Your quotation has been approved in full / approved duly reduced in terms of available funds in the amount of  <u>R      R {{ number_format($item->amount, 2, '.', ',') }}</u></li><br><br>
        <li>This serve as an order for supply and delivery to be finalized by___<u>{{$DeliveryDate}}</u>.Failure to supply by {{$FailDate}} <br> (the specified date) shall render this order null and void and your failure to deliver shall be reported to the Department of Education</li><br><br>
        <li>Upon delivery, the school undertakes to make payment in the amount of goods delivered. Funds have been earmarked and shall be recieved from the Department of Education in due course for the payment of LTSM items as per this order.</li><br><br>
      </ol>
      <br>
     <div class="box">
        School Stamp
     </div>
      <table>
        <tr><td> Principal (Name):_______________</td><td>Signature:________________</td><td>Date:__________</td></tr>
        <tr><td> SGB Chairperson(Name):__________</td><td>Signature:___________</td><td>Date:___________</td></tr>
        <tr><td> SGB Treasurer (Name):________________</td><td>Signature:________</td><td>Date:__________</td></tr>

      </table>

      @endforeach
<hr>
<p>Receipt of order is hereby acknowledged :__________(name) on behalf of _______(name of company)</p>
<p>Signature:________Date:__________</p>
    

<div class="box1">
    Supplier Stamp
 </div>
    </div>
  </body>
</html>
