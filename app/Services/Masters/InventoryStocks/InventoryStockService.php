<?php

namespace App\Services\Masters\InventoryStocks;

use App\Repositories\Masters\InventoryStocks\InventoryStockRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Ramsey\Uuid\Uuid;

class InventoryStockService
{
    private $inventoryStockRepository;

    public function __construct(InventoryStockRepository $inventoryStockRepository)
    {
        $this->inventoryStockRepository = $inventoryStockRepository;
    }

    public function data()
    {
        $inventoryStocks = $this->inventoryStockRepository->getInventoryStocks();

        return $inventoryStocks;
    }

    public function storeInventoryStock($data)
    {
        try {
            // Set Initial Value
            $iconPathFilename = null;

            // Set Variable
            $id = Uuid::uuid4();

            if (isset($data['icon']) && $data['icon'] instanceof UploadedFile) {
                $iconPathFilename = $this->storeIcon($data['icon'], $id);
            }

            // Set Key
            $data['id'] = $id;
            $data['icon'] = $iconPathFilename;

            $inventoryStock = $this->inventoryStockRepository->storeInventoryStock($data);

            return $inventoryStock;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Stok gagal ditambahkan.');
        }
    }

    public function getInventoryStockById($id)
    {
        $inventoryStock = $this->inventoryStockRepository->getInventoryStockById($id);

        return $inventoryStock;
    }

    public function updateInventoryStockById($data, $id)
    {
        try {
            $hasNewIcon = isset($data['icon']) && $data['icon'] instanceof UploadedFile;
            $shouldRemoveIcon = $data['removeIcon'] ?? false;

            // Get Inventory Stock
            $inventoryStock = $this->inventoryStockRepository->getInventoryStockById($id);
            $iconPathFilename = $inventoryStock->icon;

            // Hapus icon lama jika diminta ATAU ada icon baru
            if ($shouldRemoveIcon || $hasNewIcon) {
                if ($inventoryStock->icon && Storage::disk('public')->exists($inventoryStock->icon)) {
                    Storage::disk('public')->delete($inventoryStock->icon);
                }

                $iconPathFilename = null;
            }

            // Jika ada file icon baru, simpan
            if ($hasNewIcon) {
                $iconPathFilename = $this->storeIcon($data['icon'], $id);
            }

            // Set Key
            $data['icon'] = $iconPathFilename;

            $inventoryStock = $this->inventoryStockRepository->updateInventoryStockById($data, $id);

            return $inventoryStock;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Stok gagal diperbaharui.');
        }
    }

    public function destroyInventoryStockById($id)
    {
        try {
            $inventoryStock = $this->inventoryStockRepository->destroyInventoryStockById($id);

            return $inventoryStock;
        } catch (Exception $exception) {
            Log::error($exception);
            throw new Exception('Stok gagal dihapus.');
        }
    }

    public function getPriceById($id)
    {
        $price = $this->inventoryStockRepository->getPriceById($id);

        return $price;
    }

    private function storeIcon(UploadedFile $file, $id)
    {
        $image = Image::make($file);

        // Resize to max 128x128 without cropping
        $image->resize(128, 128, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Timestamp in filename so browsers don't serve a cached old icon
        $iconPathFilename = 'icons/' . $id . '-' . time() . '.' . $file->getClientOriginalExtension();
        Storage::disk('public')->put($iconPathFilename, (string) $image->encode());

        return $iconPathFilename;
    }
}
