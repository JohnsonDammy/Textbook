<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Helvetica, sans-serif;
            font-size: 14px;
        }

        p {
            margin: 0;
        }

        .container {
            border: 1px solid #8f8c8c;
            max-width: 680px;
            margin: 0 auto;
        }

        td {
            padding: 10px;
        }

        .column-header {
            font-weight: 600;
            padding: 5px;
            border: 1px solid #8f8c8c;
        }

        .row {
            height: 15px;
            padding: 5px;
            border-left: 1px solid #8f8c8c;
            border-right: 1px solid #8f8c8c;
            border-bottom: 1px solid #8f8c8c;
        }
    </style>
</head>

<body>
    <div class="container">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr bgcolor="#538235" height="80">


                <td width="40%" valign="top"><img src="http://furnitureapp.php-dev.in/img/logo.png" alt="Avenues"
                        title="Avenues" width="300" height="80" class="CToWUd"> </td>
                </td>
                <td>
                    <div style="padding-left: 25px;font-size: 22px;color: #fff;">
                        <strong>LTSM Collection Slip No. {{$data->ref_number}}</strong>
                    </div>
                </td>
            </tr>
        </table>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="50%" align=" left" valign="top" style="font-family:Arial,Helvetica,sans-serif;">
                    <p style="margin: 0;">The Principal</p>
                    <br>
                    <p style=" font-weight: bold;margin: 0; text-transform: uppercase;">
                        {{$data->school_name}} </p>
                    <br>
                    <p style=" font-weight: bold; line-height: 1; margin: 0; text-transform: uppercase;">
                        {{$data->emis}} - {{$data->district}}
                    </p>
                </td>
                <td width="50%" valign="top"> </td>
                </td>
            </tr>
        </table>
        <table width="100%" style="border-top:1px solid #8f8c8c;border-bottom:1px solid #8f8c8c;padding:0 0 8px 0">
            <tr>
                <td>
                <td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="100%">
                        <p style="font-size:14px; margin-bottom: 0;">In response to your LTSM Collection Request, <b>{{$data->ref_number}}</b>, this serves as record of
                            collection, as follows:-
                            </p>
                </td>
            </tr>
        </table>
        <table width="100%" style="border-collapse: collapse;text-align: center; border-bottom:1px solid #8f8c8c;">
            <tr>
                <td width="40%" class="column-header">Item
                    Description</td>
                <td width="20%" class="column-header">Qty Reported</td>
                <td width="20%" class="column-header">Qty
                    Collected</td>
                <td width="20%" class="column-header">Comments</td>
            </tr>
            @foreach($data->getBrokenItems as $item)
            <tr>
                <td class="row">{{ $item->getCategoryDetails->name }} -{{ $item->getItemDetails->name }}</td>
                <td class="row">{{ $item->count }}</td>
                <td class="row"></td>
                <td class="row"></td>
            </tr>
            @endforeach

        </table>
        <table style="border:1px solid #8f8c8c;">
            <tr>
                <td width=" 60%" style="padding:0;">
                    <p>It is confirmed that items were collected by the
                        Department's Repair Agent as per quantities indicated in the Qty
                        Collected Column</p>
                    <br>
                    <br>
                    <div style="border-top:1px solid #000">
                        <span style="float: left;">Principal Name (OR
                            Designate) </span>
                    </div>
                    <br><br>
                    <br>
                    <div style="border-top:1px solid #000">
                        <p style="float: left;">Signature</p>
                        <p style="text-align: center;">Date</p>
                    </div>

                </td>
                <td width="40%" style="border-left:1px solid #8f8c8c ;">
                    <p style="font-size: 14px; font-weight: bold; text-align:center;padding:0 5px;margin:0">
                        [SCHOOL STAMP]
                    </p>
                    <br>
                    <p style="font-size: 14px; font-weight: bold; text-align:center;padding:0 5px;margin:0">
                        OR</p>
                    <br>
                    <p style="font-size: 14px; font-weight: bold; text-align:center;padding:0 5px;margin:0">
                        PERSAL No:__________
                    </p>
                </td>
            </tr>
        </table>
        <table width="100%" style="border-top:1px solid #8f8c8c;border-bottom:1px solid #8f8c8c;padding:0 0 8px 0">
            <tr>
                <td>
                <td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="100%" style="padding:0">
                    <p style="font-size:18px; color: #000;">
                        It is confirmed that items were collected as per quantities indicated in the Qty Collected Column.
                        The Online LTSM Tracking App has been updated accordingly/shall be updated within 24 hours. </p>
                    <br><br>
                    <br>
                    <div style="border-top: 1px solid #000;">
                        <span style="float: left;">Driver Name: </span>
                    </div>
                    <br><br><br>
                    <div style="border-top: 1px solid #000;">
                        <p style="float: left;">Signature </p>
                        <p style="text-align: center;">Date </p>
                    </div>
                </td>
            </tr>
        </table>
        <table width="100%" style="border-top:1px solid #8f8c8c;border-bottom:1px solid #8f8c8c;padding:0 0 8px 0">
            <tr>
                <td>
                <td>
            </tr>
        </table>
    </div>
</body>

</html>