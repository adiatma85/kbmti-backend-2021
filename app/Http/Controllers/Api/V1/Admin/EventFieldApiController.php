<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventFieldRequest;
use App\Http\Requests\UpdateEventFieldRequest;
use App\Http\Resources\Admin\EventFieldResource;
use App\Models\EventField;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventFieldApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_field_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventFieldResource(EventField::with(['event'])->get());
    }

    public function store(StoreEventFieldRequest $request)
    {
        $eventField = EventField::create($request->all());

        return (new EventFieldResource($eventField))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EventField $eventField)
    {
        abort_if(Gate::denies('event_field_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventFieldResource($eventField->load(['event']));
    }

    public function update(UpdateEventFieldRequest $request, EventField $eventField)
    {
        $eventField->update($request->all());

        return (new EventFieldResource($eventField))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EventField $eventField)
    {
        abort_if(Gate::denies('event_field_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventField->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
