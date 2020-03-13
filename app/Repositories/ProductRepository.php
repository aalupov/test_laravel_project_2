<?php
namespace App\Repositories;

use App\Product as Model;

/**
 * Class ProductRepository
 *
 * @package App\Repositories
 */
class ProductRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'products.id',
        'products.name',
        'products.price',
        'vendors.name as vendor_name',
        'vendors.email as vendor_email'
    ];

    /**
     * const array
     */
    private const COLUMNS_2 = [
        'products.id',
        'vendors.name',
        'vendors.email'
    ];
    
    /**
     *
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Get Model to edit
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Get the products
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getProducts()
    {
        $result = $this->startConditions()
            ->join('vendors', 'vendors.id', '=', 'products.vendor_id')
            ->select(self::COLUMNS)
            ->orderBy('products.price')
            ->orderBy('products.name')
            ->paginate(25);

        return $result;
    }

    /**
     * Get the vendor by product id
     *
     * @param int $id
     *
     * @return App\Product
     */
    public function getVendor($id)
    {
        $result = $this->startConditions()
            ->join('vendors', 'vendors.id', '=', 'products.vendor_id')
            ->select(self::COLUMNS_2)
            ->find($id);

        return $result;
    }

    /**
     * Update the product price
     *
     * @param int $id
     * @param int $price
     *
     * @return void
     */
    public function updatePrice($id, $price)
    {
        $result = $this->startConditions()
            ->where('id', $id)
            ->update([
            'price' => $price
        ]);
    }
}