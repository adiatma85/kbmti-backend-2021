<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEventRegistrationRequest;
use App\Http\Requests\StoreEventRegistrationRequest;
use App\Http\Requests\UpdateEventRegistrationRequest;
use App\Models\Event;
use App\Models\EventRegistration;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventRegistrationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('event_registration_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventRegistrations = EventRegistration::with(['event'])->get();

        $events = Event::get();

        return view('admin.eventRegistrations.index', compact('eventRegistrations', 'events'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_registration_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.eventRegistrations.create', compact('events'));
    }

    public function store(StoreEventRegistrationRequest $request)
    {
        $eventRegistration = EventRegistration::create($request->all());

        return redirect()->route('admin.event-registrations.index');
    }

    public function edit(EventRegistration $eventRegistration)
    {
        abort_if(Gate::denies('event_registration_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $eventRegistration->load('event');

        return view('admin.eventRegistrations.edit', compact('events', 'eventRegistration'));
    }

    public function update(UpdateEventRegistrationRequest $request, EventRegistration $eventRegistration)
    {
        $eventRegistration->update($request->all());

        return redirect()->route('admin.event-registrations.index');
    }

    public function show(EventRegistration $eventRegistration)
    {
        abort_if(Gate::denies('event_registration_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventRegistration->load('event');

        return view('admin.eventRegistrations.show', compact('eventRegistration'));
    }

    public function destroy(EventRegistration $eventRegistration)
    {
        abort_if(Gate::denies('event_registration_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventRegistration->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventRegistrationRequest $request)
    {
        EventRegistration::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
