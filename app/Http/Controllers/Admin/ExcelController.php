<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Photos\SavePhotoAction;
use App\Constants\Admins;
use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Excel\ExportRequest;
use App\Http\Requests\Admin\Excel\ImagesRequest;
use App\Http\Requests\Admin\Excel\ImportRequest;
use App\Imports\ProductsImport;
use App\Interfaces\ProductsInterface;
use App\Interfaces\StocksInterface;
use App\Jobs\DeleteErrorsImportsTable;
use App\Jobs\NotifyAdminsAfterCompleteExport;
use App\Jobs\NotifyAdminsAfterCompleteImport;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

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
            new NotifyAdminsAfterCompleteExport(
                $request->user(Admins::GUARDED),
                $fileName,
                trans('Products'),
                trans('Products exported successfully')
            ),
        ]);

        return back()->with('success', __('Exporting products... we\'ll send you an email when the download is available'));
    }

    /**
     * @param ImportRequest $request
     * @param ProductsInterface $products
     * @param StocksInterface $stocks
     * @return RedirectResponse
     */
    public function store(ImportRequest $request, ProductsInterface $products, StocksInterface $stocks): RedirectResponse
    {
        (new ProductsImport($products, $stocks))->queue($request->file('file'), 'imports')->chain([
            new NotifyAdminsAfterCompleteImport($request->user(Admins::GUARDED)),
            new DeleteErrorsImportsTable(),
        ]);

        return back()->with('success', __('Importing products... we\'ll send you an email when the import is ended'));
    }

    public function images(ImagesRequest $request): RedirectResponse
    {
        return $this->saveImages($request->file('images'));
    }

    /**
     * @param array $images
     * @return RedirectResponse
     */
    public function saveImages(array $images): RedirectResponse
    {
        $errors = [];
        $saved = 0;
        foreach ($images as $image) {
            $name = $image->getClientOriginalName();
            $array = explode('_', $name);
            $product = Product::where('reference', $array[0])->first();
            if ($product) {
                $saved ++;
                SavePhotoAction::execute($product->id, $image);
            } else {
                $errors[] = $array[0] .  trans(' Reference not found');
            }
        }

        return redirect()->route('products.index')
            ->with('success', $saved . trans(' Images imported successfully'))
            ->withErrors($errors);
    }
}
