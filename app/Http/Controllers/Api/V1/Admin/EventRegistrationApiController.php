<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRegistrationRequest;
use App\Http\Requests\UpdateEventRegistrationRequest;
use App\Http\Resources\Admin\EventRegistrationResource;
use App\Models\EventRegistration;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventRegistrationApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_registration_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventRegistrationResource(EventRegistration::with(['event'])->get());
    }

    public function store(StoreEventRegistrationRequest $request)
    {
        $eventRegistration = EventRegistration::create($request->all());

        return (new EventRegistrationResource($eventRegistration))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EventRegistration $eventRegistration)
    {
        abort_if(Gate::denies('event_registration_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventRegistrationResource($eventRegistration->load(['event']));
    }

    public function update(UpdateEventRegistrationRequest $request, EventRegistration $eventRegistration)
    {
        $eventRegistration->update($request->all());

        return (new EventRegistrationResource($eventRegistration))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EventRegistration $eventRegistration)
    {
        abort_if(Gate::denies('event_registration_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventRegistration->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
