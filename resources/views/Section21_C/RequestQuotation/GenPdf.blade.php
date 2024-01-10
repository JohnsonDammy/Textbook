
@php
$totalLoops = 0;
$totalPrice=0;
$totalChunks = ceil($dataSavedTextbook->count() / 15);
$remainderRows = $dataSavedTextbook->count() % 15;
@endphp
 
@foreach ($dataSavedTextbook->chunk(15) as $chunk)
 
    @php
    $totalLoops++;
    @endphp
 
<html>
{{--     <div style="page-break-before: always;"></div> --}}
    <head>
    <meta http-equiv=Content-Type content="text/html; charset=windows-1252">
    <meta name=Generator content="Microsoft Word 15 (filtered)">
 
 
    <style>
        table{
            border-collapse: collapse;
            border: 3px solid black;
        }
    /* Font Definitions */
    @font-face
        {font-family:"Cambria Math";
        panose-1:2 4 5 3 5 4 6 3 2 4;}
    @font-face
        {font-family:Calibri;
        panose-1:2 15 5 2 2 2 4 3 2 4;}
    /* Style Definitions */
    p.MsoNormal, li.MsoNormal, div.MsoNormal
        {margin-top:0cm;
        margin-right:0cm;
        margin-bottom:8.0pt;
        margin-left:0cm;
        line-height:107%;
        font-size:11.0pt;
        font-family:"Calibri",sans-serif;
        color:black;}
    .MsoPapDefault
        {margin-bottom:8.0pt;
        line-height:107%;}
    @page WordSection1
        {}
    div.WordSection1
        {page:WordSection1;}
   
    .tables{
       
        
    
    width:1100px;

    }
    .anotherT{
        margin-top: -386px;
        margin-left: 1110px;
        
        width:400px;
    }
   
    .anotherM{
        
        margin-top: -10px;
       
        width:1100px;
    }
    .txt{
        font-size:13pt;
        font-family:"Calibri",sans-serif;
    }
   
    .txtx{
        font-size:7pt;
        font-family:"Calibri",sans-serif;
    }
    .anotherP{
        
        margin-top: -10px;
        width:1100px;
    }
   
    .anotherK{

            margin-top: -175px;
            margin-left: 1110px;
            height: 170px;
            width: 400px;
    }
    .anotherB{
            
    }
   
    .txtB{
        width:22px;
    }
   
    img{
        margin-bottom: -130px;
        margin-left:50px;
    }
   
    .anotherE{
        
        margin-left: 1170px;
        margin-bottom: -150px;
    }
   
    .check{
        width:90px;
        height: 70px;
    }

    .Test{
        font-size:12pt;
        font-family:"Calibri",sans-serif;

    }
 

    table{
            border: 3px black solid;
    }

    </style>
   
    </head>
    <body lang=EN-ZA style='word-wrap:break-word'>
        <main>
     
            <div class="container">
    <div class=WordSection1>
        <div style="page-break-before: always;"></div>
        <table border="1" class="anotherE">
            <tr>
                <th class="check"><label class="txtx" > Page No </label></th><th rowspan="2">&nbsp;&nbsp;OF&nbsp;&nbsp;</th><th><label class="txtx"> Total Page</label></th>
            </tr>
            <tr>
                <td>{{ $totalLoops }}</td><td>{{ $totalChunks }}</td>
            </tr>
        </table>
          <div style="page-break-before: always;"></div>
    <p>
        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('img/iconss.jpg'))) }}" width="141px" height="78px">
    </p>
    <label><center><b><span style='font-size:13.5pt;line-height:107%;font-family:"Arial",sans-serif'>
     
        KWAZULU NATAL DEPARTMENT OF EDUCATION </span></center></b></label>
   
    <p class=MsoNormal><center>STANDARDISED REQUEST FOR QUOTATION
    FORM {{date('Y')}} </center></p>
   
    <table border="1" class="anotherB">
        <tr>
            @php
            $remainingDigitss = $emis; // No need for {{ }}
            $arrayOfValues = str_split($remainingDigitss);
        @endphp
 
            <td width="100px"><label class="txt">SECTION A</label></td><td width="120px"><label class="txt">EMIS CODE:</label></td><td class="txtB">{{ $arrayOfValues[0] }}</td><td class="txtB">{{ $arrayOfValues[1] }}</td><td class="txtB">{{ $arrayOfValues[2] }}</td><td class="txtB">{{ $arrayOfValues[3] }}</td><td class="txtB">{{ $arrayOfValues[4] }}</td><td class="txtB">{{ $arrayOfValues[5] }}</td><td width="950px"><label class="txt">NAME OF SCHOOL: {{ $schoolname }}</label></td><TD>&nbsp;</TD>
        </tr>
        <tr>
        <td><label class="txt">DELIVERY ADDRESS:</label></td>  <td colspan="8">&nbsp;</td><td width="180px" rowspan="5">[SCHOOL STAMP]</td>
        </tr>
        <tr>
            <td colspan="9"><p class=MsoNormal><span style='font-size:13pt;line-height:106%'>Please furnish
                a quotation in respect of the items listed below. Quotations must be valid
                until 30 November 2023. Quotations must be accompanied by a completed SDB4
                Form and a Certified Copy of a Valid Tax Clearance Certificate. Illegible
                writing and use of correction fluid shall invalidate your quotation.</span></p></td>
        </tr>
        <tr>
            <td colspan="9"><p class=MsoNormal><span style='font-size:13pt;line-height:106%'>For
                Textbook Quotations, the total cost has been determined using the
                Department's catalogue (Sections B1 &amp; B2). Companies must please complete
                Section C(2) by indicating the percentage and value of your service which
                must be all-inclusive (transportation; labour; profits and taxes) and stamp
                and sign at Section C(1).</span></p></td>
        </tr>
        <tr>
            <td colspan="9"> <p class=MsoNormal><span style='font-size:13pt;line-height:106%'>For
                Stationery Quotations, companies must complete Section B2 and stamp and sign
                at Section C(1).</span></p></td>
        </tr>
    </table>
    <p class=MsoNormal><a name="_Hlk150763349">&nbsp;</a></p>
   
 
 
 
    <table class="tables" border="1">
    <tr>
        <th colspan="4"><label class="txt">SECTION B(1) </label></th>
    </tr>
    <tr><th> <label class="txt">ISB NO./ITEM NO.</label></th> <th><label class="txt">TEXTBOOK/STATIONERY ITEM DESCRIPTION</label></th><th><label class="txt">UNIT</label></th><th><label class="txt">QTY</label></th></tr>
   
   
    @foreach ($chunk as $item)
    @php
          $price = (float) str_replace(['R', ',', ' '], '', $item->Price);
         $totalPrice=$totalPrice +  $item->TotalPrice;
    @endphp
 
 
   
    <tr><td><label class="Test"> &nbsp;{{  $item->ISBN }}</label></td><td><label class="Test">&nbsp; {{  $item->Title }}</label></td><td><label class="Test">&nbsp; R {{ number_format($price, 2, '.', ',') }}</label></td><td><label class="Test">&nbsp;{{  $item->Quantity }}</label></td></tr>
    @endforeach
 
    @if($totalLoops == $totalChunks && $remainderRows != 0)
    @php
        $additionalRows = 15-$remainderRows;
    @endphp
 
     @for ($i = 1; $i <= $additionalRows; $i++)
     <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp; </td><td>&nbsp;</td></tr>
     @endfor
   @endif
    </table>
   
 
 
    <table  border="1" class="anotherT table" >
        <tr>
            <th colspan="4"> <label class="txt">SECTION B(1)</label></th>
        </tr>
        <tr>
            <th colspan="2"><label class="txt">UNIT PRICE</label></th> <th colspan="2"><label class="txt">TOTAL VALUE</label></th>
        </tr>
        @php
           $count =1;
        @endphp
        @foreach ($chunk as $item)
        <tr>
           
           
            <td>&nbsp; {{--  R {{ number_format($item->TotalPrice, 2, '.', ',') }} --}}</td><td>&nbsp;</td><td>&nbsp;
                {{--  @if( $totalLoops == $totalChunks && $count == 1)  
                  R {{ number_format($totalPrice, 2, '.', ',') }}
                  @endif --}}
           </td><td>&nbsp;</td>
           
 
        </tr>
        @php
            $count++;
        @endphp
        @endforeach
 
        @if($totalLoops == $totalChunks && $remainderRows != 0)
        @php
            $additionalRows = 15-$remainderRows;
        @endphp
   
         @for ($i = 1; $i <= $additionalRows; $i++)
         <tr>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
         @endfor
       @endif

        <tr>
            <td colspan="2"><label class="txt">TOTAL OF ALL PAGES</label></td><td>&nbsp;</td><td>&nbsp;</td>
   
        </tr>
    </table>
 
 
   
   
    <table border="1" class="anotherM">
    <tr>
        <th colspan="2"><label class="txt">SECTION C(1)</label></th>
    </tr>
    <tr>
        <th rowspan="3" height="160px"><label class="txt">[COMPANY STAMP]</label></th>
        <td><label class="txt">NAME OF COMPANY</label></td>
    </tr>
    <tr>
        <td><label class="txt">DATE</label></td>
    </tr>
    <tr>
        <td><label class="txt">SIGNATURE</label></td>
    </tr>
    </table>
   
    <table class="anotherK" border="1">
        <tr>
            <th colspan="3" width="300"><label class="txt">SECTION C(2)</label></th>
        </tr>
        <tr>
            <td width="200px"> <label class="txt"> SERVICE CHARGE</label></td><td width="80px"></td><td width="60px"></td>
        </tr>
        <tr>
            <td  width="200px"><label class="txt"> QUOTATION FOR TEXTBOOKS </td></label><td></td width="80px"><td width="60px"></td>
        </tr>
    </table>
    </div>
    </main>
   
    </body>
 
 
 
 
    </html>
   
 
   
 
@endforeach