<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\PaymentStatus;
use Carbon\Carbon;

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

        // Fetch sales data for the last 30 days
        $salesLast30Days = $this->getSalesDataLastDays(30);

        // Fetch sales data for the last 12 months
        $salesLast12Months = $this->getSalesDataLastMonths(12);

        return view('dashboard', compact('grossSales', 'netSales', 'invoiceDue', 'totalSellReturn', 'salesLast30Days', 'salesLast12Months'));
    }



    private function getSalesDataLastDays($days)
    {
        $startDate = Carbon::now()->subDays($days);
        $endDate = Carbon::now();

        return DB::table('sales')
        ->select(DB::raw('DATE(date) as date'), DB::raw('SUM(total_amount) as total_sales'))
        ->whereBetween('date', [$startDate, $endDate])
        ->groupBy(DB::raw('DATE(date)'))
        ->orderBy(DB::raw('DATE(date)'))
        ->get();
    }

    private function getSalesDataLastMonths($months)
    {
        $startDate = Carbon::now()->subMonths($months)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // return DB::table('sales')
        //     ->select(DB::raw('DATE_FORMAT(date, "%Y-%m") as date'), DB::raw('SUM(total_amount) as total_sales'))
        //     ->whereBetween('date', [$startDate, $endDate])
        //     ->groupBy('date')
        //     ->orderBy('date')
        //     ->get();

        return DB::table('sales')
            ->select(
                DB::raw('CONCAT(YEAR(date), "-", MONTH(date)) as month_year'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('month_year')
            ->orderBy('month_year')
            ->get();
    }
}

