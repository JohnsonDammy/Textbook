<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        .container {
  padding: 30px;
  font-family:"Calibri",sans-serif;

        }

        .label-container {
            display: flex;
        }

        .kop{
            height: ;
        }

        table{
            border-collapse: collapse;
            width:850px;
            height: 300px;

        }

         td {
  padding: 10px;
}

        .kop1{
            margin-top: -14px;
            margin-left: 400px;
        }

        .bannar{
            width: 1000px;
            height: 100px;
            margin-left: -50px;
            margin-right: -500px;
        }

        .imgk{

            margin-left: 500px;
        }

        .kopN{
            margin-top: -30000px;
        }

    </style>
</head>
<body>
    
    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('img/logo.png'))) }}" >
    <br><br><br>
    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('img/bannar.png'))) }}" class="bannar">

    <div class="container">
        <div class="label-container">
            <div class="kop">Name o School:__________________________________</div>
            <div class="kop1">EMIS No:________________________</div>
        </div>
        <br><br>

        <div class="label-container">
            <div class="kop">District:__________________________________________</div>
            <div class="kop1">Circuit:_________________________</div>
        </div>
        <br><br><br>

        <div class="label-container">
            <div class="kop">
                1. Details of School LTSM Committee Members, as required by KZN Circular No 55 of 2012 are
                hereby submitted as follows:
            </div>
        </div>

        <br>

        <div class="label-container">
            <div class="kop">
                <table border="1">

                    <tr><th>Name</th> <th>*** Designation </th> <th>Contact No.</th> <th>Signature</th><th>Date</th></tr>
                    <tr>
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td> <td>&nbsp;</td><td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td> <td>&nbsp;</td><td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td> <td>&nbsp;</td><td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td> <td>&nbsp;</td><td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td> <td>&nbsp;</td><td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td> <td>&nbsp;</td><td>&nbsp;</td>
                    </tr>
                </tr>

            </tr>



                </table>
            </div>
        </div>


<br>
        <div class="label-container">
            <div class="kop">
                * Designation of the Committee must include, but is not limited to, the following:
                Principal; member of the SMT; Senior teacher; Phase co-ordinator; Educator representative in the SGB
            </div>
        </div>

        <br>

        <div class="label-container">
            <div class="kop">
              2  It is hereby declared that the School LTSM Committee members are knowledgeable in the
                requirements outlined in the relevant prescripts on the requisitioning; procurement; receipt;
                storage; issuing; recording; retrieval and retention of learning and teaching support material,
                including but not limited to the following KZN Circulars numbered:
                55 of 2012; 44 of 2013; 102 of 2013; 66 of 2022; 100 of 2022; 102 of 2022; 114 of 2022; 130 of
                2022; 08 of 2023; 56 of 2023; 57 of 2023; 58 of 2023
            </div>
        </div>

        <br>

        <div class="label-container">
            <div class="kop">
                ________________________________<br>
                SIGNATURE OF PRINCIPAL
            </div>
        </div>
        
     <br>
        <div class="label-container">
            <div class="kop">
                DATE:______________________<br>
            </div>

        </div>
        <label class="imgk">    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('img/stamp.png'))) }}" >
        </label>

        



    </div>
</body>
</html>
