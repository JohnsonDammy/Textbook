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

                <td width="60%">
                    <div style="font-size: 20px;color: #fff;">
                        <strong>LTSM Replenishment Request </strong>
                    </div>
                </td>
                <td width="40%" valign="top"><img src="http://furnitureapp.php-dev.in/img/logo.png" alt="Avenues" title="Avenues" width="300" height="80" class="CToWUd"> </td>
                </td>
            </tr>
        </table>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="100%" align=" left" valign="top" style="font-family:Arial,Helvetica,sans-serif;">
                    <p style="margin: 0;">The Head of Department</p>
                    <br>
                    <p style=" font-weight: bold;margin: 0; text-transform: uppercase;">REQUEST FOR REPLENISHMENT OF
                        WRITTEN-OFF LTSM</p>
                    <br>
                    <p style=" font-weight: bold;margin: 0; text-transform: uppercase;">
                        {{ $data->school->school_name }}
                    </p>
                    <br>
                    <p style=" font-weight: bold; line-height: 1; margin: 0; text-transform: uppercase;">
                        {{ $data->school->emis }} - {{ $data->school->district }}
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
                <td width="100%">
                    <p style="font-size:14px;">
                        In response to LTSM Collection Request, <b> {{ $data->school->ref_number }}</b>, the following items were found to
                        be “worn out; useless and damaged” and must be written-off as repairs are not possible or not
                        economically viable. A disposal list has been accordingly issued to the school. Images of the
                        items have been uploaded on the on-line LTSM Tracking App for further verification.
                    </p>
                    <br>
                    <p style="font-size:14px;">
                        A request is made to replenish these losses with new replacement items as listed below.
                    </p>
                </td>
            </tr>
        </table>
        <table width="100%" style="border-collapse: collapse;text-align: center; border-bottom:1px solid #8f8c8c;">
            <tr>
                <td width="60%" class="column-header">Item
                    Description</td>
                <td width="20%" class="column-header">Qty to be Written Off</td>
                <td width="20%" class="column-header">Qty to be Replenished</td>
            </tr>
            @foreach ($data->items as $item)
            @if ($item->replenished_count != 0)
            <tr>
                <td class="row">{{ $item->getCategoryDetails->name }} -
                    {{ $item->getItemDetails->name }}
                </td>
                <td class="row">{{ $item->replenished_count }}</td>
                <td class="row"> </td>
            </tr>
            @endif
            @endforeach
            <tr>
                <td class="row"></td>
                <td class="row"></td>
                <td class="row"></td>
            </tr>


        </table>
        <table width="100%" style="border-bottom:1px solid #8f8c8c;">
            <tr>
                <td width="100%" style="padding:0">
                    <div>
                        <br><br>
                        <p style="padding-left: 10px; margin-left: 10px;">System Support </p>
                        <br>
                        <br>
                    </div>
                </td>
            </tr>
        </table>
        <table width="100%">
            <td width="50%" style="padding: 0;">
                <p style="text-align: center; font-size: 14px;">The request for replenishment of written-off LTSM Items as

                    indicated above is hereby</p>
                <br>
                <p style="text-align: center; font-size:18px">APPROVED / REJECTED</p>
                <br><br>
                <div style="border-top:1px solid #000">
                    <p style="float: left;">Name of Official </p>
                    <p style="text-align: center;">Rank</p>
                </div>
                <br>
                <br>
                <div style="border-top:1px solid #000">
                    <p style="float: left;">Signature </p>
                    <p style="text-align: center;">Date</p>
                </div>
                <br>
            </td>
            <td width="50%" align="center" style="border-left:1px solid #8f8c8c;">
                <strong style="font-size: 20px;">[OFFICIAL STAMP]</strong>
            </td>
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