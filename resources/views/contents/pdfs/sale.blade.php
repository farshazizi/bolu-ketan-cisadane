<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Penjualan {{ $data->invoice_number }}</title>
    <style>
        html,
        body {
            font-family: 'Myriad', sans-serif;
            font-weight: normal;
        }
    </style>
</head>

<body>
    <div class="logo" style="text-align: center">
        <img src="data:image/png;base64, {{ $imageLogo }}" style="width: 240px" />
    </div>

    <div class="header">
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td>
                        <h3
                            style="background-color: #722C14; border-radius: 32px; color: white; padding: 8px; text-align: center">
                            {{ $data->invoice_number }}
                        </h3>
                    </td>
                    <td style="width: 40%"></td>
                    <td>
                        <h4 style="color: #722C14">Karawang, {{ $data->date }} <br> Pukul {{ $data->time }}</h4>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="body" style="margin-top: 48px">
        <table style="width: 100%; border-collapse: collapse">
            <thead style="background-color: #722C14; color: white">
                <tr style="text-align: center">
                    <td
                        style="border-right: 1px white solid; border-top-left-radius: 8px; border-bottom-left-radius: 8px; padding: 8px">
                        <b>No.</b>
                    </td>
                    <td style="border-right: 1px white solid"><b>NAMA BARANG</b></td>
                    <td style="border-right: 1px white solid"><b>HARGA</b></td>
                    <td style="border-right: 1px white solid"><b>JUMLAH BARANG</b></td>
                    <td style="border-top-right-radius: 8px; border-bottom-right-radius: 8px"><b>TOTAL</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->saleDetails as $key => $item)
                    <tr>
                        <td
                            style="border-right: 1px #722C14 solid; padding-top: 12px; padding-bottom: 12px; text-align: center">
                            <p style="color: #722C14">
                                {{ $key + 1 }}
                            </p>
                        </td>
                        <td style="border-right: 1px #722C14 solid; padding-top: 12px; padding-bottom: 12px">
                            <p style="color: #722C14; margin: 8px">
                                {{ $item->inventoryStock->name }}
                            </p>
                        </td>
                        <td
                            style="border-right: 1px #722C14 solid; padding-top: 12px; padding-bottom: 12px; text-align: right">
                            <p style="color: #722C14; margin: 8px">
                                {{ number_format($item->price + $item->total_additional, 0) }}
                            </p>
                        </td>
                        <td
                            style="border-right: 1px #722C14 solid; padding-top: 12px; padding-bottom: 12px; text-align: center">
                            <p style="color: #722C14">
                                {{ $item->quantity }}
                            </p>
                        </td>
                        <td style="padding-top: 12px; padding-bottom: 12px; text-align: right">
                            <p style="color: #722C14; margin: 8px">
                                {{ number_format($item->total  + $item->total_additional, 0) }}
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer" style="margin-top: 16px">
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td rowspan="3">
                        <p style="color: #722C14; font-size: 24px">
                            <i>
                                Jl. Cisadane XV, No 73 <br />
                                Adiarsa Barat, Karawang <br />
                                No. Telepon: 0813-8993-3245
                            </i>
                        </p>
                    </td>
                    <td style="width: 8px"></td>
                    <td>
                        <table>
                            <tr>
                                <td style="width: 100px">
                                    <p style="color: #722C14; font-size: 24px; text-align: left">
                                        Total Diskon
                                    </p>
                                </td>
                                <td style="text-align: right; width: 150px">
                                    <p style="color: #722C14; font-size: 24px">
                                        <b>Rp{{ number_format($totalDiscount, 0) }}</b>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 8px"></td>
                    <td>
                        <table>
                            <tr>
                                <td style="width: 100px">
                                    <p style="color: #722C14; font-size: 24px; text-align: left">
                                        Total
                                    </p>
                                </td>
                                <td style="text-align: right; width: 150px">
                                    <p style="color: #722C14; font-size: 24px">
                                        <b>Rp{{ number_format($data->grand_total, 0) }}</b>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 8px"></td>
                    <td style="text-align: center">
                        <p style="color: #722C14; font-size: 24px">
                            <i> Hormat Kami,</i>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
