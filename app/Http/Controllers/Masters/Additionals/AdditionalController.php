<?php

namespace App\Http\Controllers\Masters\Additionals;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\Additionals\StoreAdditionalRequest;
use App\Http\Requests\Masters\Additionals\UpdateAdditionalRequest;
use App\Services\Masters\Additionals\AdditionalService;
use Exception;
use Illuminate\Support\Facades\Log;

class AdditionalController extends Controller
{
    private $additionalService;

    public function __construct(AdditionalService $additionalService)
    {
        $this->additionalService = $additionalService;
    }

    public function index()
    {
        return view('contents.masters.additionals.index');
    }

    public function data()
    {
        $data = $this->additionalService->data();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('price', function ($additional) {
                $price = number_format($additional->price, 0);
                return $price;
            })
            ->addColumn('action', function ($additional) {
                return ('
                <div class="btn-group btn-group-sm" style="float: left">
                    <a class="btn nav-link" href="' . route('additionals.edit', ['id' => $additional->id]) . '" data-id="' . $additional->id . '"><i class="far fa-edit fa-lg"></i></a>
                    <a class="btn nav-link" id="delete" data-id="' . $additional->id . '" href="#"><i class="far fa-trash-alt fa-lg"></i></a>
                </div>
                ');
            })
            ->toJson();
    }

    public function create()
    {
        return view('contents.masters.additionals.create');
    }

    public function store(StoreAdditionalRequest $storeAdditionalRequest)
    {
        try {
            $request = $storeAdditionalRequest->validated();

            $additional = $this->additionalService->storeAdditional($request);

            if ($additional) {
                return back()->with([
                    'status' => 'success',
                    'message' => 'Tambahan berhasil ditambahkan.'
                ]);
            }

            return back()->with([
                'status' => 'error',
                'message' => 'Tambahan gagal ditambahkan.'
            ])->withInput();
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'error',
                'message' => 'Tambahan gagal ditambahkan.'
            ])->withInput();
        }
    }

    public function edit($id)
    {
        $additional = $this->additionalService->getAdditionalById($id);

        return view('contents.masters.additionals.edit', compact('id', 'additional'));
    }

    public function update(UpdateAdditionalRequest $updateAdditionalRequest, $id)
    {
        try {
            $request = $updateAdditionalRequest->validated();

            $additional = $this->additionalService->updateAdditionalById($request, $id);

            if ($additional) {
                return back()->with([
                    'status' => 'success',
                    'message' => 'Tambahan berhasil diperbaharui.'
                ]);
            }

            return back()->with([
                'status' => 'error',
                'message' => 'Tambahan gagal diperbaharui.'
            ])->withInput();
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->with([
                'status' => 'error',
                'message' => 'Tambahan gagal diperbaharui.'
            ])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $additional = $this->additionalService->destroyAdditionalById($id);

            if ($additional) {
                return response()->json([
                    'message' => 'Tambahan berhasil dihapus.'
                ], 200);
            }

            return response()->json([
                'message' => 'Tambahan gagal dihapus.'
            ], 500);
        } catch (Exception $exception) {
            Log::error($exception);
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
