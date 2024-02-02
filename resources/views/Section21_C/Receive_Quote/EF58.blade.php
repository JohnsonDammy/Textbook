<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    {{-- <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}
{{-- 

    <link rel="stylesheet" href="{{ public_path('jss/bootstrap.min.css') }}" />
<script src="{{ public_path('jss/jquery.slim.min.js') }}"></script>
<script src="{{ public_path('jss/popper.min.js') }}"></script>
<script src="{{ public_path('jss/bootstrap.bundle.min.js') }}"></script> --}}
    <style>
      .box {
        border: 2px solid black;
        height: 50px;
        width: 550px;
        margin-top: 20px;
      }

      .boxN {
        border: 2px solid black;
        font-size: 12px;

      }

      .boxP {
        border: 1px solid black;
margin-left: 30px;
      }

      .boxP1 {
        /* border: 2px solid black; */
        width: 200px;
        height: 30px;
        margin-top: -18px;
        margin-left: 60px;
      }

      
      .boxP2 {
        /* border: 2px solid black; */
        width: 400px;
        height: 30px;
        margin-top: -18px;
        margin-left: 150px;
      }

      .boxP3 {
        /* border: 2px solid black; */
        width: 400px;
        height: 30px;
        margin-left: 300px;
        margin-top: -29px;
      }




      .boxP3 {
        /* border: 2px solid black; */
        width: 400px;
        height: 30px;
        margin-left: 300px;
        margin-top: -29px;
      }


      
      .boxP4 {
        /* border: 2px solid black; */
        width: 250px;
        height: 30px;
        margin-left: 800px;
        margin-top: -29px;
      }

         
      .boxP5 {
        /* border: 2px solid black; */
        width: 150px;
        height: 30px;
        margin-left: 1050px;
        margin-top: -29px;
      }

        
      .boxP6 {
        /* border: 2px solid black; */
        width: 270px;
        height: 30px;
 
      }

        
      .short {
        /* border: 2px solid black; */
        width: 100px;
        height: 30px;
 
      }

      .box1 {
        font-size: 10px;
        margin-left: 600px;
        margin-top: -80px;
      }

      .kop2 {
        margin-left: 715px;
        margin-top: -10px;
        font-size: 13px;
      }

      .kop {
        margin-left: 715px;
        margin-top: -100px;
      }

      .kop3 {
        margin-left: 740px;
        margin-top: -600px;
        font-size: 10px;
      }

      img {
        margin-left: 600px;
        margin-top: -90px;
      }

      table{
        width: 1200px;
      }

      .txt{
        margin-left: 1030px;
      }
      
      body{
        font-family: Arial, Helvetica, sans-serif;

      }
      </style>
  </head>
  <body>
    <br /><br />

    <div class="container">
        <h2 class="txt">EF58</h2>
      <div class="box">
        <h2>PROCUREMENT OF LTSM: 2023/2034</h2>
      </div>

      <img
      src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('img/kznM.png'))) }}"
      />
      <div class="kop"><u>DEPARTMENT OF EDUCATION</u></div>
      <br />

      <div class="kop2">
        PROVINCE KWAZULU-NATAL<br />
        REPUBLIC OF SOUTH AFRICA
      </div>
      <br />

      <br />
      <table border="1">
        <tr>
          <td>
        <div class="boxN"><center> <b>  @if($requestType == "Stationery")
            STATIONERY 
            @else
            TEXTBOOK
            @endif</b></center></div>
          </td>
          <td>

            <div class="boxP"><center> <b>COMPARATIVE SCHEDULE: EVALUATION & AWARD OF QUOTATIONS</b></center></div>
          </td>
        </tr>
        <tr>
            <td>
                <div>
                    <label>District</label>  <div class="boxP1">{{ strtoupper ($districtName) }}</div>
                    <label>Circuit</label>  <div class="boxP1">{{ strtoupper($circuitName) }}</div>

    
                </div>
            </td>
            <td>
                <div>
                    <label>NAME OF SCHOOL</label>  <div class="boxP2">{{ strtoupper($schoolname) }}</div>
                    <label>EMIS NO</label>  <div class="boxP2">{{ $emis }}</div>

    
                </div>
            </td>
   
        </tr>
 
      </table>
      <table border="1">
        <tr>
            <td>No</td><td> QUOTATIONS INVITED FROM</td><td>QUOTED PRICE</td><td><b>REMARKS: to include compliance to specification, Delivery Period etc</b></td><td>TAX CLEARANCE<br>CERTIFICATE VALID</td>
        </tr>
   
        @foreach ($CapturedData as $item)
        <tr>
            <td style="width: -50px">{{ $loop->iteration }}</td> 
            <td>{{ $item->CompanyName }}</td>
         <td style="width: auto;"> R {{ number_format($item->amount , 2, '.', ',') }}</td>

         <td>{{ $item->comment }}</td> 
         <td>{{ $item->taxClearance }}</td>
        </tr>
        @endforeach
        <tr>
          <td style="width: 160px">RECOMMENDED SUPPLIER     </td>  
          <td style="width: 400px">{{ $recommendedSupplierName }}</td>
          <td style="width: 400px" colspan="3"> TOTAL PRICE (VAT INCLUSIVE)
            &nbsp;R {{ number_format($recommendedSupplierAmount +($recommendedSupplierAmount * 15/100) , 2, '.', ',') }}</td>
         
      </tr>
      <tr>
        <td style="width: 160px">DEVIATION REASON </td>
        <td style="width: 400px" colspan="4">{{$DeviationReason}}</td>
      </tr>
 
      </table>
     
      
      <table border="1">
        <tr>
            <td>&nbsp;</td><td>In respect of the recommended quotation, it is hereby certified that:-</td>

        </tr>
        <tr>
            <td>1</td><td>The quotation is in accordance with the school's requirements.
            </td>

        </tr>
        <tr>
            <td>2</td><td>In respect of the recommended quotation, it is hereby certified that:-</td>

        </tr>
        <tr>
            <td>3</td><td>Funds have been utilized responsibly and prudently thereby ensuring that value for money has been obtained. Further the textbook quotation does not exceed catalogued prices by 27%</td>

        </tr>
        <tr>
            <td>4</td><td>The quotation is in terms of required specifications, calculations thereon have been verified and the offer has been found to be the lowest.</td>

        </tr>
        <tr>
            <td>5</td><td>The firm has submitted a valid tax clearance certificate and Declaration of Interest Form (SBD4)</td>

        </tr>
        <tr>
            <td>6</td><td>IA Disclosure of Interests, Confidentiality and Impartiality Form has been completed by all members involved in this process</td>

        </tr>

      </table>
      <table border="1">
        <tr>
            <td>PRINCIPAL - NAME</td><td>&nbsp;</td> <td>SIGNATURE</td><td>&nbsp;</td><td>DATE</td>
           </tr>
           <tr>
            <td>SGB CHAIRPERSON - NAME</td><td>&nbsp;</td> <td>SIGNATURE</td><td>&nbsp;</td><td>DATE</td>
           </tr>
           <tr>
            <td>SGB TREASURER - NAME</td><td>&nbsp;</td> <td>SIGNATURE</td><td>&nbsp;</td><td>DATE</td>
           </tr>
      </table>

    </div>
  </body>
</html>
