<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAnggotumRequest;
use App\Http\Requests\UpdateAnggotumRequest;
use App\Http\Resources\Admin\AnggotumResource;
use App\Models\Anggotum;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnggotaApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('anggotum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AnggotumResource(Anggotum::all());
    }

    public function store(StoreAnggotumRequest $request)
    {
        $anggotum = Anggotum::create($request->all());

        if ($request->input('image', false)) {
            $anggotum->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new AnggotumResource($anggotum))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Anggotum $anggotum)
    {
        abort_if(Gate::denies('anggotum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AnggotumResource($anggotum);
    }

    public function update(UpdateAnggotumRequest $request, Anggotum $anggotum)
    {
        $anggotum->update($request->all());

        if ($request->input('image', false)) {
            if (!$anggotum->image || $request->input('image') !== $anggotum->image->file_name) {
                if ($anggotum->image) {
                    $anggotum->image->delete();
                }
                $anggotum->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($anggotum->image) {
            $anggotum->image->delete();
        }

        return (new AnggotumResource($anggotum))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Anggotum $anggotum)
    {
        abort_if(Gate::denies('anggotum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $anggotum->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
