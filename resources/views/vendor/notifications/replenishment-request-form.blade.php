<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Password Reset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        body,
        table,
        td,
        a {
            -ms-text-size-adjust: 100%;
            /* 1 */
            -webkit-text-size-adjust: 100%;
            /* 2 */
        }

        table,
        td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }


        a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
        }

        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }

        body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        table {
            border-collapse: collapse !important;
        }

        a {
            color: #359934;
        }

        img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
        }
    </style>

</head>

<body style="background-color: #fff;">
    <!-- start body -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">

        <tr>
            <td height="50" bgcolor="#cfefcf"></td>
        </tr>
        <!-- start logo -->
        <tr>
            <td align="center" bgcolor="#cfefcf">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="right" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: sans-serif; border-top: 3px solid #5dc68f;">
                            <a href="#" target="_blank" style="display: inline-block;">
                                <img src=" {{ asset('img/logo.png') }}" alt="Logo" border="0" width="48" style="display: block; width: 300px; max-width: 300px; min-width: 300px;">
                            </a>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <!-- end logo -->

        <!-- start hero -->
        <tr>
            <td align="center" bgcolor="#cfefcf">

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: sans-serif; ">
                            <h2 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">
                                Request for Approval {{ $data->school->ref_number }}</h2>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <!-- end hero -->

        <!-- start copy block -->
        <tr>
            <td align="center" bgcolor="#cfefcf">

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

                    <!-- start copy -->
                    <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: sans-serif; font-size: 16px; line-height: 24px;">
                            Good day,</td>
                    </tr>
                    <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: sans-serif; font-size: 16px; line-height: 24px;">
                            Please note that {{ $data->school->school_name }} - EMIS Number {{ $data->school->emis }} has items that cannot
                            be repaired. We hereby request on behalf of the school, for a replenishment approval according
                            to the list below</td>
                    </tr>
                    <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: sans-serif; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0;">The following items cannot be repaired:</p>
                        </td>
                    </tr>
                    <!-- end copy -->

                    <!-- start button -->
                    <tr>
                        <td align="left" bgcolor="#ffffff">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <th align="center">Item Category</th>
                                    <th align="center">Item Description</th>
                                    <th align="center">Number of Items to Replenished</th>
                                </tr>
                                @foreach ($data->items as $item)
                                @if ($item->replenished_count != 0)
                                <tr>
                                    <td align="center">{{ $item->getCategoryDetails->name }}</td>
                                    <td align="center">{{ $item->getItemDetails->name }}</td>
                                    <td align="center">{{ $item->replenished_count }}</td>
                                </tr>
                                @endif
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    <!-- end button -->

                    <!-- start copy -->
                    <tr>
                        <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #5dc68f">
                            <p style="margin: 0;">Regards,<br>LTSM Tracker</p>
                        </td>
                    </tr>
                    <!-- end copy -->

                </table>

            </td>
        </tr>
        <tr>
            <td height="50" bgcolor="#cfefcf"></td>
        </tr>
        <!-- end copy block -->
    </table>
    <!-- end body -->
</body>

</html>