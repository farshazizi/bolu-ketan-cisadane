<table>
    <thead>
        <tr>
            <th colspan="6" style="text-align: center"><b>LAPORAN PENJUALAN HARIAN</b></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center"><b>No</b></td>
            <td style="text-align: center"><b>Nama Item</b></td>
            <td style="text-align: center"><b>Jumlah Item</b></td>
            <td style="text-align: center"><b>Price</b></td>
            <td style="text-align: center"><b>Debit</b></td>
            <td style="text-align: center"><b>Kredit</b></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center">Penjualan</td>
        </tr>
        @foreach ($sales as $key => $item)
            <tr>
                <td style="width: 50px; text-align: center">{{ $key + 1 }}</td>
                <td style="width: 150px">{{ $item['name'] }}</td>
                <td style="width: 100px; text-align: center">{{ $item['quantity'] }}</td>
                <td style="width: 150px; text-align: right">{{ number_format($item['price'], 0) }}</td>
                <td style="width: 150px; text-align: right">Rp{{ number_format($item['debit'], 0) }}</td>
                <td style="width: 150px; text-align: right"></td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6" style="text-align: center">Pembelian</td>
        </tr>
        @foreach ($purchases as $key => $item)
            <tr>
                <td style="width: 50px; text-align: center">{{ $key + 1 }}</td>
                <td style="width: 150px">{{ $item['name'] }}</td>
                <td style="width: 100px; text-align: center">{{ $item['quantity'] }}</td>
                <td style="width: 150px; text-align: right">{{ number_format($item['price'], 0) }}</td>
                <td style="width: 150px; text-align: right"></td>
                <td style="width: 150px; text-align: right">Rp{{ number_format($item['kredit'], 0) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" style="text-align: center"><b>Saldo Akhir</b></td>
            <td colspan="2" style="text-align: center"><b>Rp{{ number_format($balance, 0) }}</b></td>
        </tr>
    </tbody>
</table>
