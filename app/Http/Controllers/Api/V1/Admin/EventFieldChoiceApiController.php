<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventFieldChoiceRequest;
use App\Http\Requests\UpdateEventFieldChoiceRequest;
use App\Http\Resources\Admin\EventFieldChoiceResource;
use App\Models\EventFieldChoice;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventFieldChoiceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_field_choice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventFieldChoiceResource(EventFieldChoice::with(['event_field'])->get());
    }

    public function store(StoreEventFieldChoiceRequest $request)
    {
        $eventFieldChoice = EventFieldChoice::create($request->all());

        return (new EventFieldChoiceResource($eventFieldChoice))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EventFieldChoice $eventFieldChoice)
    {
        abort_if(Gate::denies('event_field_choice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventFieldChoiceResource($eventFieldChoice->load(['event_field']));
    }

    public function update(UpdateEventFieldChoiceRequest $request, EventFieldChoice $eventFieldChoice)
    {
        $eventFieldChoice->update($request->all());

        return (new EventFieldChoiceResource($eventFieldChoice))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EventFieldChoice $eventFieldChoice)
    {
        abort_if(Gate::denies('event_field_choice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventFieldChoice->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
