<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\PaymentStatus;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate Gross Sales
        $grossSales = DB::table('sales')->sum('total_amount');

        // Calculate Net Sales
        $netSales = $grossSales - DB::table('sales')->where('payment_status_id', PaymentStatus::where('name', 'Refunded')->first()->id)->sum('total_paid');

        // Calculate Invoice Due
        $invoiceDue = DB::table('sales')->where('payment_status_id', PaymentStatus::where('name', 'Unpaid')->first()->id)->count();

        // Calculate Total Sell Return
        $totalSellReturn = DB::table('sales')->where('payment_status_id', PaymentStatus::where('name', 'Refunded')->first()->id)->count();

        return view('dashboard', compact('grossSales', 'netSales', 'invoiceDue', 'totalSellReturn'));
    }
}

