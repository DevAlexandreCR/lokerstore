<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Admins;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use App\Interfaces\ProductsInterface;
use Illuminate\Http\RedirectResponse;
use App\Jobs\NotifyAdminsAfterCompleteExport;
use App\Jobs\NotifyAdminsAfterCompleteImport;
use App\Http\Requests\Admin\Excel\ExportRequest;
use App\Http\Requests\Admin\Excel\ImportRequest;

class ExcelController extends Controller
{
    /**
     * @param ExportRequest $request
     * @param ProductsInterface $products
     * @return RedirectResponse
     */
    public function index(ExportRequest $request, ProductsInterface $products): RedirectResponse
    {
        $fileName = 'products_' . now()->format('Y-m-d') .'.xlsx';

        (new ProductsExport($products))->queue($fileName, 'exports')->chain([
            new NotifyAdminsAfterCompleteExport($request->user(Admins::GUARDED), $fileName)
        ]);

        return back()->with('success', __('Exporting products... we\'ll send you an email when the download is available'));
    }

    public function store(ImportRequest $request, ProductsInterface $products): RedirectResponse
    {
        (new ProductsImport($products))->queue($request->file('file'), 'imports')->chain([
            new NotifyAdminsAfterCompleteImport($request->user(Admins::GUARDED))
        ]);
        return back()->with('success', __('Importing products... we\'ll send you an email when the import is ended'));
    }
}
