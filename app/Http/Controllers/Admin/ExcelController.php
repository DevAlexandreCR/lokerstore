<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Admins;
use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Interfaces\ProductsInterface;
use App\Jobs\NotifyAdminsAfterCompleteExport;
use App\Http\Requests\Admin\Excel\ExportRequest;

class ExcelController extends Controller
{
    public function index(ExportRequest $request, ProductsInterface $products)
    {
        $fileName = 'products_' . now()->format('Y-m-d') .'.xlsx';
        return (new ProductsExport($products))->download($fileName);
//        (new ProductsExport($products))->queue($fileName, 'exports')->chain([
//            new NotifyAdminsAfterCompleteExport($request->user(Admins::GUARDED), $fileName)
//        ]);

//        return back()->with('success', __('Exporting products... we\'ll send you an email when the download is available'));
    }
}
