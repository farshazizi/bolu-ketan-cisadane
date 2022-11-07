<table>
    <thead>
        <tr>
            <th><b>LAPORAN PENJUALAN HARIAN</b></th>
        </tr>
        <tr>
            <th rowspan="2" style="width: 150px; text-align: center"><b>No</b></th>
            <th rowspan="2" style="width: 150px; text-align: center"><b>Jam Transaksi</b></th>
            <th colspan="{{ count($inventoryStocks) + 1 }}" style="width: 150px; text-align: center"><b>Stock</b></th>
        </tr>
        <tr>
            @foreach ($inventoryStocks as $inventoryStock)
                <th style="width: 150px; text-align: center">{{ $inventoryStock['name'] }}</th>
            @endforeach
            <th style="width: 150px; text-align: center">Total Tambahan</th>
            <th style="width: 150px; text-align: center">Debit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $key => $sale)
            <tr>
                <td style="text-align: center">{{ $key + 1 }}</td>
                <td style="text-align: right">{{ $sale['createdAt'] }}</td>
                @foreach ($sale['saleDetails'] as $saleDetail)
                    <td style="text-align: right">{{ $saleDetail['quantity'] }}</td>
                @endforeach
                <td style="text-align: right">{{ number_format($sale['totalAdditional'], 0) }}</td>
                <td style="text-align: right">{{ number_format($sale['grandTotal'], 0) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="text-align: center"><b>Jumlah</b></td>
            @foreach ($totalSales as $totalSale)
                <td>{{ $totalSale['quantity'] }}</td>
            @endforeach
            <td style="text-align: right">{{ number_format($sumTotalAdditionalSales, 0) }}</td>
            <td style="text-align: right">{{ number_format($sumGrandTotalSales, 0) }}</td>
        </tr>
    </tfoot>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <thead>
        <tr>
            <th><b>LAPORAN PEMBELIAN HARIAN</b></th>
        </tr>
        <tr>
            <th rowspan="2" style="width: 150px; text-align: center"><b>No</b></th>
            <th rowspan="2" style="width: 150px; text-align: center"><b>Jam Transaksi</b></th>
            <th colspan="{{ count($ingredients) }}" style="width: 150px; text-align: center"><b>Stock</b></th>
        </tr>
        <tr>
            @foreach ($ingredients as $ingredient)
                <th style="width: 150px; text-align: center">{{ $ingredient['name'] }}</th>
            @endforeach
            <th style="width: 150px; text-align: center">Debit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($purchases as $key => $purchase)
            <tr>
                <td style="text-align: center">{{ $key + 1 }}</td>
                <td style="text-align: right">{{ $purchase['createdAt'] }}</td>
                @foreach ($purchase['purchaseDetails'] as $purchaseDetail)
                    <td style="text-align: right">{{ $purchaseDetail['quantity'] }}</td>
                @endforeach
                <td style="text-align: right">{{ number_format($purchase['grandTotal'], 0) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="text-align: center"><b>Jumlah</b></td>
            @foreach ($totalPurchases as $totalPurchase)
                <td>{{ $totalPurchase['quantity'] }}</td>
            @endforeach
            <td style="text-align: right">{{ number_format($sumGrandTotalPurchases, 0) }}</td>
        </tr>
    </tfoot>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <thead>
        <tr>
            <th style="width: 150px; text-align: center"><b>PENJUALAN</b></th>
            <th style="width: 150px; text-align: center"><b>PEMBELIAN</b></th>
            <th style="width: 150px; text-align: center"><b>SALDO</b></th>
        </tr>
        <tr>
            <th style="width: 150px; text-align: right">{{ number_format($sumGrandTotalSales, 0) }}</th>
            <th style="width: 150px; text-align: right">{{ number_format($sumGrandTotalPurchases, 0) }}</th>
            <th style="width: 150px; text-align: right">{{ number_format(($sumGrandTotalSales - $sumGrandTotalPurchases), 0) }}</th>
        </tr>
    </thead>
</table>
