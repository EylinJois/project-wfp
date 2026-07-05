<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::query()
            ->orderByDesc('time')
            ->get();

        return view('consultation', compact('consultations'));
    }

    public function showSchedule(Request $request, Doctor $doctor)
    {
        // all doctors for left panel
        $doctors = Doctor::with('specialty')->get();

        // selected date
        $selectedDate = $request->date ?? now()->toDateString();

        // doctor working hours
        $start = Carbon::parse($doctor->start_time);
        $end = Carbon::parse($doctor->end_time);

        // generate all schedules
        $allSchedules = [];

        while ($start < $end) {

            $allSchedules[] = $start->format('H:i:s');

            $start->addHour();
        }

        // booked schedules
        $bookedSchedules = Consultation::where('doctor_id', $doctor->id)
            ->whereDate('time', $selectedDate)
            ->pluck('time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i:s');
            })
            ->toArray();

        // available schedules only
        $availableSchedules = array_diff(
            $allSchedules,
            $bookedSchedules
        );
        $activeConsultation = Consultation::where(
            'member_id',
            auth()->user()->member_id
        )
            ->whereIn('status', ['pending', 'ongoing'])
            ->latest('time')
            ->first();

        return view('members.consultation', compact(
            'doctor',
            'doctors',
            'availableSchedules',
            'selectedDate',
            'activeConsultation'
        ));
    }

    // show consultation for member
    public function indexConsultation()
    {
        $doctors = Doctor::with('specialty')->get();

        $consultation = Consultation::where('member_id', auth()->user()->member_id)
            ->whereIn('status', ['pending', 'ongoing'])
            ->latest()
            ->first();

        return view(
            'members.consultation',
            compact('consultation', 'doctors')
        );
    }

    // show consultation history for member
    public function history()
    {
        $consultations = Consultation::with([
            'doctor',
            'chats',
        ])
            ->where('member_id', auth()->user()->member_id)
            ->where('status', 'done')
            ->latest('time')
            ->get();

        $consultations->each(function ($consultation) {
            $consultation->formatted_date = date('d M Y', strtotime($consultation->time));
            $consultation->formatted_time = date('H:i', strtotime($consultation->time));
        });

        return view(
            'members.history',
            compact('consultations')
        );
    }

    public function historyDetail(Consultation $consultation)
    {
        abort_if(
            $consultation->member_id != auth()->user()->member_id,
            403
        );

        $consultation->load([
            'doctor',
            'member',
            'chats',
        ]);

        return view(
            'members.history-detail',
            compact('consultation')
        );
    }

    // show consultation for doctor
    public function doctorConsultations()
    {
        $query = Consultation::with([
            'member',
            'doctor',
        ])
            ->where('doctor_id', auth()->user()->doctor_id);

        if (request()->filled('status') && request('status') != 'all') {
            $query->where('status', request('status'));
        }

        $consultations = $query
            ->orderByDesc('time')
            ->get();

        return view(
            'doctors.consultation',
            compact('consultations')
        );
    }

    // show schedule for doctor
    public function schedule()
    {
        $doctor = auth()->user()->doctor_id;

        $consultations = Consultation::with('member')
            ->where('doctor_id', $doctor)
            ->orderBy('time')
            ->get();

        return view(
            'doctors.schedule',
            compact('consultations')
        );
    }

    // start consultation for doctor
    public function start(Consultation $consultation)
    {
        $consultation->update([
            'status' => 'ongoing',
            'consultation_type' => 'ongoing',
        ]);

        return back()->with('success', 'Consultation started.');
    }

    // finish consultation for doctor
    public function finish(Consultation $consultation)
    {
        $consultation->update([
            'status' => 'done',
            'consultation_type' => 'done',
        ]);

        return back()->with('success', 'Consultation finished.');
    }

    public function create()
    {
        return response()->json(['message' => 'Form create consultation belum tersedia.']);
    }

    public function store(Request $request)
    {
        try {
            $request->merge([
                'time' => $request->consultation_date.' '.$request->schedule_radio,
            ]);
            $validated = $request->validate([
                'time' => ['required'],
                'status' => ['required', 'string', 'max:20'],
                'consultation_type' => ['required', Rule::in(['none', 'ongoing', 'done'])],
                'notes' => ['nullable', 'string'],
                'member_id' => ['required', 'integer', 'exists:members,id'],
                'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            ]);

            Consultation::create($validated);

            return redirect()
                ->route('consultation.index')
                ->with('success', 'Consultation booked successfully.');
        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    // check if the user is the doctor or member of the consultation
    public function show(Consultation $consultation)
    {
        if (auth()->user()->doctor_id &&
            $consultation->doctor_id != auth()->user()->doctor_id) {
            abort(403);
        }

        if (auth()->user()->member_id &&
            $consultation->member_id != auth()->user()->member_id) {
            abort(403);
        }

        $consultation->load([
            'doctor',
            'member',
            'chats',
        ]);

        if (auth()->user()->doctor_id) {
            return view('doctors.chat', compact('consultation'));
        }

        return view('members.chat', compact('consultation'));
    }

    public function edit(Consultation $consultation)
    {
        return response()->json(['consultation' => $consultation]);
    }

    public function update(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'time' => ['required', 'date'],
            'status' => ['required', 'string', 'max:20'],
            'consultation_type' => ['required', Rule::in(['kosong', 'sedang berlangsung', 'selesai'])],
            'notes' => ['nullable', 'string'],
            'member_id' => ['required', 'integer', 'exists:member,id'],
            'doctor' => ['required', 'integer', 'exists:dokter,id'],
        ]);

        $consultation->update($validated);

        return redirect()->route('consultation.index');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('consultation.index');
    }
}
