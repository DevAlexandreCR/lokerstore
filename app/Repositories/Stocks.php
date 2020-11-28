<?php

namespace App\Repositories;

use App\Interfaces\StocksInterface;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Stocks implements StocksInterface
{
    private Stock $stocks;

    public function __construct(Stock $stocks)
    {
        $this->stocks = $stocks;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->stocks::all();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->stocks->create($request->all());
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return mixed
     */
    public function update(Request $request, Model $model)
    {
        return $model->update($request->all());
    }

    /**
     * @param Model $model
     * @return mixed
     */
    public function destroy(Model $model)
    {
        return $this->stocks::destroy($model->id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $productRef = $data['reference'];

        $product = Product::select('id')->where('reference', $productRef)->first();
        $data['product_id'] = $product->id;

        return $this->stocks->create($data);
    }
}
