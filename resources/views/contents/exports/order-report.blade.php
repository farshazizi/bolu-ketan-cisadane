<table>
    <thead>
        <tr>
            <th><b>LAPORAN PENJUALAN HARIAN</b></th>
        </tr>
        <tr>
            <th rowspan="2" style="width: 150px; text-align: center"><b>No</b></th>
            <th rowspan="2" style="width: 150px; text-align: center"><b>Transaksi</b></th>
            <th colspan="{{ count($inventoryStocks) }}" style="width: 150px; text-align: center"><b>Stock</b></th>
        </tr>
        <tr>
            @foreach ($inventoryStocks as $inventoryStock)
                <th style="width: 150px; text-align: center">{{ $inventoryStock['name'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $key => $order)
            <tr>
                <td style="text-align: center">{{ $key + 1 }}</td>
                <td style="text-align: right">{{ $order['name'] }}</td>
                @foreach ($order['orderDetails'] as $orderDetail)
                    <td style="text-align: right">{{ $orderDetail['quantity'] }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="text-align: center"><b>Jumlah</b></td>
            @foreach ($totalOrders as $totalOrder)
                <td>{{ $totalOrder['quantity'] }}</td>
            @endforeach
        </tr>
    </tfoot>
</table>
