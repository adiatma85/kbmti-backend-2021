<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpcomingProkerRequest;
use App\Http\Requests\UpdateUpcomingProkerRequest;
use App\Http\Resources\Admin\UpcomingProkerResource;
use App\Models\UpcomingProker;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpcomingProkerApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('upcoming_proker_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UpcomingProkerResource(UpcomingProker::all());
    }

    public function store(StoreUpcomingProkerRequest $request)
    {
        $upcomingProker = UpcomingProker::create($request->all());

        return (new UpcomingProkerResource($upcomingProker))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UpcomingProker $upcomingProker)
    {
        abort_if(Gate::denies('upcoming_proker_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UpcomingProkerResource($upcomingProker);
    }

    public function update(UpdateUpcomingProkerRequest $request, UpcomingProker $upcomingProker)
    {
        $upcomingProker->update($request->all());

        return (new UpcomingProkerResource($upcomingProker))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UpcomingProker $upcomingProker)
    {
        abort_if(Gate::denies('upcoming_proker_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $upcomingProker->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
