<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use App\Models\CalendarLine;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function create()
{
    $companies = Auth::user()->companies;

    return view('invoices.create', compact('companies'));
}

public function store(Request $request)
{
    $request->validate([
        'company_id' => 'required|exists:companies,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'hourly_rate' => 'required|numeric|min:0',
        'tva_rate' => 'nullable|numeric|min:0',
    ]);

    
    $lines = CalendarLine::whereHas('calendar', function ($query) use ($request) {
        $query->where('company_id', $request->company_id);
    })
    ->whereBetween('start', [$request->start_date, $request->end_date])
    ->where('is_billable', true)
    ->get();

   
    $totalMinutes = $lines->sum('duration_minutes');
    $totalHeures = $totalMinutes / 60;
    $hourlyRate = $request->hourly_rate;
    $tvaRate = $request->tva_rate ?? 0;

    
    $montantHT = round($totalHeures * $hourlyRate, 2);
    $montantTVA = round($montantHT * ($tvaRate / 100), 2);
    $totalTTC = round($montantHT + $montantTVA, 2);

   
    $invoice = Invoice::create([
        'user_id' => Auth::id(),
        'company_id' => $request->company_id,
        'invoice_date' => now(),
        'period' => $request->start_date . ' → ' . $request->end_date,
        'total_hours' => round($totalHeures, 2),
        'total' => $montantHT,
        'hourly_rate' => $hourlyRate,
        'pdf_path' => null, 
    ]);

    return redirect()
        ->route('invoices.show', $invoice->id)
        ->with('success', 'Facture générée avec succès ✅');
}

public function show($id)
{
    $invoice = Invoice::with('company')->findOrFail($id);

    return view('invoices.show', compact('invoice'));
}
}
