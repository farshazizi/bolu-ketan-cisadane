<?php

namespace App\Services\Masters\InventoryStocks;

use App\Repositories\Masters\InventoryStocks\InventoryStockRepository;
use Exception;
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

            if (isset($data['icon']) && is_a($data['icon'], \Illuminate\Http\UploadedFile::class)) {
                $image = Image::make($data['icon']);

                // Resize to max 128x128 without cropping
                $image->resize(128, 128, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $iconPathFilename = 'icons/' . $id . '.' . $data['icon']->getClientOriginalExtension();
                Storage::disk('public')->put($iconPathFilename, (string) $image->encode());
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
            // Set Initial Value
            $iconPathFilename = null;

            $hasNewIcon = isset($data['icon']) && is_a($data['icon'], \Illuminate\Http\UploadedFile::class);
            $shouldRemoveIcon = $data['removeIcon'] ?? false;

            // Get Inventory Stock
            $inventoryStock = $this->inventoryStockRepository->getInventoryStockById($id);
            $iconPathFilename = $inventoryStock->icon;

            // Hapus icon lama jika diminta ATAU ada icon baru
            if ($shouldRemoveIcon || $hasNewIcon) {
                if ($inventoryStock->icon && Storage::disk('public')->exists($inventoryStock->icon)) {
                    Storage::disk('public')->delete($inventoryStock->icon);

                    $iconPathFilename = null;
                }
            }

            // Jika ada file icon baru, simpan
            if ($hasNewIcon) {
                $image = Image::make($data['icon']);
                $image->resize(128, 128, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $iconPathFilename = 'icons/' . $id . '.' . $data['icon']->getClientOriginalExtension();
                Storage::disk('public')->put($iconPathFilename, (string) $image->encode());
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
}
