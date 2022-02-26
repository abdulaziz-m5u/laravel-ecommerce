<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Exports\RevenueExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

class ReportController extends Controller
{
    public function revenue(Request $request)
	{
		$startDate = $request->input('start');
        $endDate = $request->input('end');

		if ($startDate && !$endDate) {
			return redirect('admin/reports/revenue');
		}

		if (!$startDate && $endDate) {
			return redirect('admin/reports/revenue');
		}

		if ($startDate && $endDate) {
			if (strtotime($endDate) < strtotime($startDate)) {
				return redirect('admin/reports/revenue');
			}

			$earlier = new \DateTime($startDate);
			$later = new \DateTime($endDate);
			$diff = $later->diff($earlier)->format("%a");
			
			if ($diff >= 31) {
				return redirect('admin/reports/revenue');
			}
		} else {
			$currentDate = date('Y-m-d');
			$startDate = date('Y-m-01', strtotime($currentDate));
			$endDate = date('Y-m-t', strtotime($currentDate));
		}
		$startDate = $startDate;
        $endDate = $endDate;

		$sql = "WITH recursive date_ranges AS (
			SELECT :start_date_series AS date
			UNION ALL
			SELECT date + INTERVAL 1 DAY
			FROM date_ranges
			WHERE date < :end_date_series
			),
			filtered_orders AS (
				SELECT * 
				FROM orders
				WHERE DATE(order_date) >= :start_date
					AND DATE(order_date) <= :end_date
					AND status = :status
					AND payment_status = :payment_status
			)
		 SELECT 
			 DISTINCT DR.date,
			 COUNT(FO.id) num_of_orders,
			 COALESCE(SUM(FO.grand_total),0) gross_revenue,
			 COALESCE(SUM(FO.tax_amount),0) taxes_amount,
			 COALESCE(SUM(FO.shipping_cost),0) shipping_amount,
			 COALESCE(SUM(FO.grand_total - FO.tax_amount - FO.shipping_cost - FO.discount_amount),0) net_revenue
		 FROM date_ranges DR
		 LEFT JOIN filtered_orders FO ON DATE(order_date) = DR.date
		 GROUP BY DR.date
		 ORDER BY DR.date ASC";

		$revenues = \DB::select(
			\DB::raw($sql),
			[
				'start_date_series' => $startDate,
				'end_date_series' => $endDate,
				'start_date' => $startDate,
				'end_date' => $endDate,
				'status' => Order::COMPLETED,
				'payment_status' => Order::PAID,
			]
		);

		$revenues = ($startDate && $endDate) ? $revenues : [];

		if ($exportAs = $request->input('export')) {
			if (!in_array($exportAs, ['xlsx', 'pdf'])) {
				return redirect('admin/reports/revenue');
			}

			if ($exportAs == 'xlsx') {
				$fileName = 'report-revenue-'. $startDate .'-'. $endDate .'.xlsx';

				return Excel::download(new RevenueExport($revenues), $fileName);
			}

			if ($exportAs == 'pdf') {
				$fileName = 'report-revenue-'. $startDate .'-'. $endDate .'.pdf';
				$pdf = PDF::loadView('admin.reports.exports.revenue-pdf', compact('revenues', 'startDate','endDate'));

				return $pdf->download($fileName);
			}
        }

		return view('admin.reports.revenue', compact('revenues','startDate','endDate'));
	}
}
