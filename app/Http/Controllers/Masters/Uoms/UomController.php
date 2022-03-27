<?php

namespace App\Http\Controllers\Masters\Uoms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\Uoms\StoreUomRequest;
use App\Http\Requests\Masters\Uoms\UpdateUomRequest;
use App\Services\Masters\Uoms\UomService;
use Exception;
use Illuminate\Support\Facades\Log;

class UomController extends Controller
{
    private $uomService;

    public function __construct(UomService $uomService)
    {
        $this->uomService = $uomService;
    }

    public function index()
    {
        return view('contents.masters.uoms.index');
    }

    public function data()
    {
        $data = $this->uomService->data();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($uom) {
                return ('
                <div class="btn-group btn-group-sm" style="float: left">
                    <a class="btn nav-link" href="' . route('uoms.edit', ['id' => $uom->id]) . '" data-id="' . $uom->id . '"><i class="far fa-edit fa-lg"></i></a>
                    <a class="btn nav-link" id="delete" data-id="' . $uom->id . '" href="#"><i class="far fa-trash-alt fa-lg"></i></a>
                </div>
                ');
            })
            ->toJson();
    }

    public function create()
    {
        return view('contents.masters.uoms.create');
    }

    public function store(StoreUomRequest $storeUomRequest)
    {
        try {
            $request = $storeUomRequest->safe()->collect();

            $uom = $this->uomService->store($request);
            if ($uom) {
                return back()->with([
                    'status' => 'success',
                    'message' => 'Satuan berhasil ditambahkan.'
                ]);
            }

            return back()->with([
                'status' => 'error',
                'message' => 'Satuan gagal ditambahkan.'
            ])->withInput();
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'error',
                'message' => 'Satuan gagal ditambahkan.'
            ])->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $uom = $this->uomService->getUomById($id);
            return view('contents.masters.uoms.edit', compact('id', 'uom'));
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'error',
                'message' => 'Terjadi kendala.'
            ]);
        }
    }

    public function update(UpdateUomRequest $updateUomRequest, $id)
    {
        try {
            $request = $updateUomRequest->safe()->collect();

            $uom = $this->uomService->update($request, $id);

            if ($uom) {
                return back()->with([
                    'status' => 'success',
                    'message' => 'Satuan berhasil diperbaharui.'
                ]);
            }

            return back()->with([
                'status' => 'error',
                'message' => 'Satuan gagal diperbaharui.'
            ])->withInput();
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'error',
                'message' => 'Satuan gagal diperbaharui.'
            ])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $uom = $this->uomService->destroy($id);

            if ($uom) {
                return response()->json([
                    'message' => 'Satuan berhasil dihapus.'
                ], 200);
            }

            return response()->json([
                'message' => 'Satuan gagal dihapus.'
            ], 500);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
