<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventFieldResponseRequest;
use App\Http\Requests\UpdateEventFieldResponseRequest;
use App\Http\Resources\Admin\EventFieldResponseResource;
use App\Models\EventFieldResponse;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventFieldResponseApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_field_response_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventFieldResponseResource(EventFieldResponse::with(['event_registration', 'event_field'])->get());
    }

    public function store(StoreEventFieldResponseRequest $request)
    {
        $eventFieldResponse = EventFieldResponse::create($request->all());

        return (new EventFieldResponseResource($eventFieldResponse))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EventFieldResponse $eventFieldResponse)
    {
        abort_if(Gate::denies('event_field_response_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventFieldResponseResource($eventFieldResponse->load(['event_registration', 'event_field']));
    }

    public function update(UpdateEventFieldResponseRequest $request, EventFieldResponse $eventFieldResponse)
    {
        $eventFieldResponse->update($request->all());

        return (new EventFieldResponseResource($eventFieldResponse))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EventFieldResponse $eventFieldResponse)
    {
        abort_if(Gate::denies('event_field_response_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventFieldResponse->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
