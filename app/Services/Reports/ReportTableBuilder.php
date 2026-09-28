<?php

namespace App\Services\Reports;

class ReportTableBuilder
{
    /**
     * Sum detail quantities per item, in the order of $items (one report column per item).
     */
    public function quantitiesPerItem($items, $details, $itemForeignKey)
    {
        $quantities = [];
        foreach ($details as $detail) {
            $itemId = $detail->{$itemForeignKey};
            $quantities[$itemId] = ($quantities[$itemId] ?? 0) + $detail->quantity;
        }

        return $this->mapItems($items, function ($item) use ($quantities) {
            return $quantities[$item->id] ?? 0;
        });
    }

    /**
     * Sum each item column over all rows, producing the "Jumlah" footer.
     */
    public function totalPerItem($items, $rows, $detailsKey)
    {
        return $this->mapItems($items, function ($item, $index) use ($rows, $detailsKey) {
            $total = 0;
            foreach ($rows as $row) {
                $total += $row[$detailsKey][$index]['quantity'];
            }

            return $total;
        });
    }

    private function mapItems($items, callable $quantity)
    {
        $columns = [];
        foreach ($items->values() as $index => $item) {
            $columns[] = [
                'id' => $item->id,
                'name' => $item->name,
                'quantity' => $quantity($item, $index),
            ];
        }

        return $columns;
    }
}
