<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class ConsultationController extends Controller
{
    private function generateSchedules(Doctor $doctor): array
    {
        $start = Carbon::parse($doctor->start_time);
        $end = Carbon::parse($doctor->end_time);

        $schedules = [];

        while ($start < $end) {
            $schedules[] = $start->format('H:i:s');
            $start->addHour();
        }

        return $schedules;
    }

    public function index()
    {
        $consultations = Consultation::latest()->get();
        $members = Member::orderBy('fullname')->get();
        $doctors = Doctor::orderBy('fullname')->get();
    
        return view('consultation', compact('consultations', 'members', 'doctors'));
    }

    public function showSchedule(Request $request, Doctor $doctor)
    {
        // all doctors for left panel
        $doctors = Doctor::with('specialty')->get();

        // selected date
        $selectedDate = $request->date ?? now()->toDateString();

        // doctor working hours
        $allSchedules = $this->generateSchedules($doctor);

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
        $activeConsultation = Consultation::with('doctor')
            ->where('member_id', auth()->user()->member_id)
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

        $activeConsultation = Consultation::with('doctor')
            ->where('member_id', auth()->user()->member_id)
            ->whereIn('status', ['pending', 'ongoing'])
            ->latest('time')
            ->first();

        return view(
            'members.consultation',
            [
                'doctor' => null,
                'doctors' => $doctors,
                'availableSchedules' => [],
                'selectedDate' => now()->toDateString(),
                'activeConsultation' => $activeConsultation,
            ]
        );
    }

    // show consultation history for member
    public function history()
    {
        $consultations = Consultation::with([
            'doctor.specialty',
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
            'doctor.specialty',
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
            'status' => 'ongoing'
        ]);

        return back()->with('success', 'Consultation started.');
    }

    // finish consultation for doctor
    public function finish(Consultation $consultation)
    {
        $consultation->update([
            'status' => 'done',
        ]);

        return back()->with('success', 'Consultation finished.');
    }

    public function create()
    {
        return response()->json(['message' => 'Form create consultation belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'consultation_date' => ['required', 'date', 'after_or_equal:today'],
            'schedule_radio' => ['required', 'date_format:H:i:s'],
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
        ]);

        $doctor = Doctor::findOrFail($validated['doctor_id']);
        $memberId = auth()->user()->member_id;

        $activeConsultation = Consultation::where('member_id', $memberId)
            ->whereIn('status', ['pending', 'ongoing'])
            ->latest('time')
            ->first();

        if ($activeConsultation) {
            throw ValidationException::withMessages([
                'member_id' => 'You already have an active consultation.',
            ]);
        }

        $selectedDate = Carbon::parse($validated['consultation_date'])->toDateString();
        $selectedTime = Carbon::createFromFormat('H:i:s', $validated['schedule_radio'])->format('H:i:s');
        $availableSchedules = $this->generateSchedules($doctor);

        if (! in_array($selectedTime, $availableSchedules, true)) {
            throw ValidationException::withMessages([
                'schedule_radio' => 'Selected schedule is outside the doctor working hours.',
            ]);
        }

        $bookedSchedules = Consultation::where('doctor_id', $doctor->id)
            ->whereDate('time', $selectedDate)
            ->pluck('time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i:s');
            })
            ->toArray();

        if (in_array($selectedTime, $bookedSchedules, true)) {
            throw ValidationException::withMessages([
                'schedule_radio' => 'Selected schedule is already booked.',
            ]);
        }

        Consultation::create([
            'time' => Carbon::createFromFormat('Y-m-d H:i:s', $selectedDate . ' ' . $selectedTime),
            'status' => 'pending',
            'consultation_type' => 'General Consultation',
            'notes' => null,
            'member_id' => $memberId,
            'doctor_id' => $doctor->id,
        ]);

        return redirect()
            ->route('consultation')
            ->with('success', 'Consultation booked successfully.');
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
            'consultation_type' => ['required', Rule::in(['General Consultation', 'Specialist Consultation', 'Follow-up Consultation'])],
            'notes' => ['nullable', 'string'],
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
        ]);

        $consultation->update($validated);

        return redirect()->route('consultation');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('consultation');
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'time'               => 'required|date',
            'status'             => 'required|string|max:20',
            'consultation_type'  => 'required|in:none,ongoing,done',
            'notes'              => 'nullable|string',
            'member_id'          => 'required|exists:members,id',
            'doctor_id'          => 'required|exists:doctors,id',
        ]);

        $consultation = Consultation::create($request->only([
            'time', 'status', 'consultation_type', 'notes', 'member_id', 'doctor_id'
        ]));

        $consultation->load('member', 'doctor');

        return response()->json([
            'status' => 'oke',
            'consultation' => [
                'id'                 => $consultation->id,
                'member_id'          => $consultation->member_id,
                'doctor_id'          => $consultation->doctor_id,
                'time'               => $consultation->time,
                'status'             => $consultation->status,
                'consultation_type'  => $consultation->consultation_type,
                'notes'              => $consultation->notes,
                'created_at'         => $consultation->created_at->toDateTimeString(),
                'updated_at'         => $consultation->updated_at->toDateTimeString(),
            ]
        ]);
    }

    public function getEditForm(Request $request)
    {
        $consultation = Consultation::findOrFail($request->id);

        return response()->json([
            'id'                 => $consultation->id,
            'member_id'          => $consultation->member_id,
            'doctor_id'          => $consultation->doctor_id,
            'time'               => optional($consultation->time)->format('Y-m-d\TH:i'),
            'status'             => $consultation->status,
            'consultation_type'  => $consultation->consultation_type,
            'notes'              => $consultation->notes,
        ]);
    }

    public function saveDataUpdate(Request $request)
    {
        $request->validate([
            'id'                 => 'required|exists:consultations,id',
            'time'               => 'required|date',
            'status'             => 'required|string|max:20',
            'consultation_type'  => 'required|in:none,ongoing,done',
            'notes'              => 'nullable|string',
            'member_id'          => 'required|exists:members,id',
            'doctor_id'          => 'required|exists:doctors,id',
        ]);

        $consultation = Consultation::find($request->id);

        if ($consultation) {
            $consultation->time = $request->time;
            $consultation->status = $request->status;
            $consultation->consultation_type = $request->consultation_type;
            $consultation->notes = $request->notes;
            $consultation->member_id = $request->member_id;
            $consultation->doctor_id = $request->doctor_id;
            $consultation->save();

            return response()->json([
                'status'     => 'oke',
                'member_id'  => $consultation->member_id,
                'doctor_id'  => $consultation->doctor_id,
                'time'       => $consultation->time,
                'consultation_status' => $consultation->status,
                'consultation_type'   => $consultation->consultation_type,
                'notes'      => $consultation->notes,
                'updated_at' => $consultation->updated_at->toDateTimeString()
            ]);
        }

        return response()->json([
            'status' => 'gagal',
            'msg' => 'Consultation tidak ditemukan.'
        ]);
    }

    public function deleteData(Request $request)
    {
        $consultation = Consultation::find($request->id);

        if ($consultation) {
            $consultation->delete();
            return response()->json(['status' => 'oke']);
        }

        return response()->json([
            'status' => 'gagal',
            'msg' => 'Consultation tidak ditemukan.'
        ]);
    }
}
