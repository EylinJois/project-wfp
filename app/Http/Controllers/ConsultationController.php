<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Doctor;

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

        return view('members.consultation', compact(
            'doctor',
            'doctors',
            'availableSchedules',
            'selectedDate'
        ));
    }

    public function indexConsultation()
    {
        $doctors = Doctor::with('specialty')->get();

        $consultations = Consultation::query()
            ->orderByDesc('time')
            ->get();

        return view('members.consultation', [
            'doctors' => $doctors,
            'consultations' => $consultations,
            'doctor' => null,
            'availableSchedules' => [],
            'selectedDate' => now()->toDateString(),
        ]);
    }


    public function create()
    {
        return response()->json(['message' => 'Form create consultation belum tersedia.']);
    }

    public function store(Request $request)
    {
        try {
            $request->merge([
                'time' => $request->consultation_date . ' ' . $request->schedule_radio
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

            return redirect()->route('consultation.index', ['success' => 'Consultation booked successfully.']);
        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function show(Consultation $consultation)
    {
        return response()->json(['consultation' => $consultation]);
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
