<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\CalendarLine;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Auth::user()->companies;

        return view('calendars.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'nullable|string|max:255',
            'source_file' => 'required|url', 
        ]);
    
       
        $calendar = Calendar::create([
            'company_id' => $request->company_id,
            'name' => $request->name,
            'source_file' => $request->source_file,
        ]);
    
        
        $apiUrl = "https://ical.mathieutu.dev/json?url=" . rawurlencode($calendar->source_file);
        $response = Http::withOptions([
            'verify' => false, 
        ])->get($apiUrl);
    
        if (!$response->successful()) {
            $calendar->delete(); 
            return back()->withErrors([
                'source_file' => 'Erreur lors de l\'analyse du lien iCal.',
            ]);
        }
    
        
        $data = $response->json();        
        $events = $data['events'] ?? [];   

    
        foreach ($events as $event) {

            if (empty($event['start']) || empty($event['end'])) {
                continue;
            }

            CalendarLine::create([
                'calendar_id' => $calendar->id,
                'uid' => $event['uid'] ?? null,
                'title' => $event['summary'] ?? null,
                'description' => $event['description'] ?? null,
                'start' => $event['start'] ?? null,
                'end' => $event['end'] ?? null,
                'duration_minutes' => isset($event['start'], $event['end'])
                    ? Carbon::parse($event['start'])->diffInMinutes(Carbon::parse($event['end']))
                    : null,
                'total_hours' => $event['totalHours'] ?? null,
                'location' => $event['location'] ?? null,
                'status' => null,
                'is_billable' => true,
                'hourly_rate' => null,
                'amount' => null,
                'tva_rate' => null,
                'tva_amount' => null,
                'total_with_tva' => null,
            ]);
        }
    
        return redirect()
            ->route('companies.index')
            ->with('success', 'Calendrier importé avec succès. ' . count($events) . ' événements ajoutés.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Calendar $calendar)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
