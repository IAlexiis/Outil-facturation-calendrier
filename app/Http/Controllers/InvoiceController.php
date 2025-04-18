<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CalendarLine;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
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
            'company_id'   => 'required|exists:companies,id',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'hourly_rate'  => 'required|numeric|min:0',
            'tva_rate'     => 'nullable|numeric|min:0',
        ]);

        
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();

       
        $lines = CalendarLine::whereHas('calendar', function ($query) use ($request) {
                $query->where('company_id', $request->company_id);
            })
            ->whereBetween('start', [$start, $end])
            ->where('is_billable', true)
            ->get();


        
        $totalHeures = $lines->sum('total_hours');
        $hourlyRate = $request->hourly_rate;
        $tvaRate = $request->tva_rate ?? 0;

        
        $montantHT = round($totalHeures * $hourlyRate, 2);
        $montantTVA = round($montantHT * ($tvaRate / 100), 2);
        $totalTTC = round($montantHT + $montantTVA, 2);

        
        $invoice = Invoice::create([
            'user_id'       => Auth::id(),
            'company_id'    => $request->company_id,
            'invoice_date'  => now(),
            'period'        => $request->start_date . ' → ' . $request->end_date,
            'total_hours'   => round($totalHeures, 2),
            'hourly_rate'   => $hourlyRate,
            'tva_rate'      => $tvaRate,
            'total'         => $montantHT,
            'pdf_path'      => null,
        ]);

        return redirect()
            ->route('invoices.show', $invoice->id)
            ->with('success', 'Facture générée avec succès');
    }

    public function show($id)
    {
        $invoice = Invoice::with('company')->findOrFail($id);

        [$start, $end] = explode(' → ', $invoice->period);
        $start = Carbon::parse($start)->startOfDay();
        $end = Carbon::parse($end)->endOfDay();
    
        $events = CalendarLine::whereHas('calendar', function ($query) use ($invoice) {
            $query->where('company_id', $invoice->company_id);
        })
        ->whereBetween('start', [$start, $end])
        ->where('is_billable', true)
        ->get();
    
        return view('invoices.show', compact('invoice', 'events'));
    }

    public function byCompany(Company $company)
{
    $invoices = $company->invoices()->latest()->get();

    return view('invoices.by-company', compact('company', 'invoices'));
}

public function destroy(Invoice $invoice)
{
    $invoice->delete();

    return redirect()->back()->with('success', 'Facture supprimée avec succès');
}
}
