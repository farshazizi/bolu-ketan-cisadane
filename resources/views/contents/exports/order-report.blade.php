<table>
    <thead>
        <tr>
            <th style="width: 100px"><b>LAPORAN PESANAN HARIAN</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td style="width: 100px"><b>Tanggal</b></td>
                <td>{{ $item->date }}</td>
            </tr>
            <tr>
                <td style="width: 100px"><b>Nama</b></td>
                <td>{{ $item->name }}</td>
            </tr>
            <tr>
                <td style="width: 100px"><b>Alamat</b></td>
                <td>{{ $item->address }}</td>
            </tr>
            <tr>
                <td style="width: 100px"><b>No. Telepon</b></td>
                <td>{{ $item->phone }}</td>
            </tr>
            <tr>
                <td style="width: 100px"><b>Notes</b></td>
                <td>{{ $item->notes }}</td>
            </tr>
            <tr>
                <td colspan="3" style="background-color: $CEE2F2; text-align: center"><b>Pesanan</b></td>
            </tr>
            <tr>
                <td style="width: 100px; text-align: center"><b>No</b></td>
                <td style="width: 150px"><b>Nama Item</b></td>
                <td style="width: 100px; text-align: center"><b>Jumlah Item</b></td>
            </tr>
            @foreach ($item->orderDetails as $key => $itemOrderDetail)
                <tr>
                    <td style="width: 100px; text-align: center">{{ $key + 1 }}</td>
                    <td style="width: 150px">{{ $itemOrderDetail->inventoryStock['name'] }}</td>
                    <td style="width: 100px; text-align: center">{{ $itemOrderDetail['quantity'] }}</td>
                </tr>
            @endforeach
            <tr></tr>
        @endforeach
    </tbody>
</table>
