<?php
namespace App\Repositories;

use App\Order as Model;
use Carbon\Carbon;

/**
 * Class OrderRepository
 *
 * @package App\Repositories
 */
class OrderRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'orders.id',
        'orders.status',
        'partners.name'
    ];

    /**
     * const array
     */
    private const COLUMNS_2 = [
        'order_products.id',
        'order_products.order_id',
        'order_products.quantity',
        'order_products.price',
        'order_products.product_id',
        'products.name'
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
     * Get the orders
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getOrders()
    {
        $result = $this->startConditions()
            ->join('partners', 'partners.id', '=', 'orders.partner_id')
            ->select(self::COLUMNS)
            ->with([
            'products' => function ($query) {
                $query->join('products', 'products.id', '=', 'order_products.product_id');
                $query->select(self::COLUMNS_2);
            }
        ])
            ->orderBy('id', 'desc')
            ->get();

        return $result;
    }

    /**
     * Get the overdue orders
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getOverdueOrders()
    {
        $result = $this->startConditions()
            ->join('partners', 'partners.id', '=', 'orders.partner_id')
            ->select(self::COLUMNS)
            ->where('orders.status', 10)
            ->whereDate('delivery_dt', '<', Carbon::now())
            ->with([
            'products' => function ($query) {
                $query->join('products', 'products.id', '=', 'order_products.product_id');
                $query->select(self::COLUMNS_2);
            }
        ])
            ->orderBy('delivery_dt', 'desc')
            ->limit(50)
            ->get();

        return $result;
    }

    /**
     * Get the current orders
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getCurrentOrders()
    {
        $result = $this->startConditions()
            ->join('partners', 'partners.id', '=', 'orders.partner_id')
            ->select(self::COLUMNS)
            ->where('orders.status', 10)
            ->whereDate('delivery_dt', '>', Carbon::now()->subHours(24))
            ->with([
            'products' => function ($query) {
                $query->join('products', 'products.id', '=', 'order_products.product_id');
                $query->select(self::COLUMNS_2);
            }
        ])
            ->orderBy('delivery_dt')
            ->get();

        return $result;
    }

    /**
     * Get the new orders
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getNewOrders()
    {
        $result = $this->startConditions()
            ->join('partners', 'partners.id', '=', 'orders.partner_id')
            ->select(self::COLUMNS)
            ->where('orders.status', 0)
            ->whereDate('delivery_dt', '>', Carbon::now())
            ->with([
            'products' => function ($query) {
                $query->join('products', 'products.id', '=', 'order_products.product_id');
                $query->select(self::COLUMNS_2);
            }
        ])
            ->orderBy('delivery_dt')
            ->limit(50)
            ->get();

        return $result;
    }
    
    /**
     * Get the completed orders
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getCompletedOrders()
    {
        $result = $this->startConditions()
        ->join('partners', 'partners.id', '=', 'orders.partner_id')
        ->select(self::COLUMNS)
        ->where('orders.status', 20)
        ->whereDate('delivery_dt', '>', Carbon::now()->startOfDay())
        ->with([
            'products' => function ($query) {
            $query->join('products', 'products.id', '=', 'order_products.product_id');
            $query->select(self::COLUMNS_2);
            }
            ])
            ->orderBy('delivery_dt', 'desc')
            ->limit(50)
            ->get();
            
            return $result;
    }

    /**
     * Get the order by order id
     *
     * @param int $id
     *
     * @return App\Order
     */
    public function getOrderByOrderId($id)
    {
        $result = $this->startConditions()
            ->join('partners', 'partners.id', '=', 'orders.partner_id')
            ->leftJoin('order_products', 'order_products.order_id', '=', 'orders.id')
            ->select('orders.id', 'orders.status', 'orders.partner_id', 'orders.client_email', 'partners.name', 
                      \DB::raw('SUM(order_products.quantity * order_products.price) as price'))
            ->with([
            'products' => function ($query) {
                $query->join('products', 'products.id', '=', 'order_products.product_id');
                $query->select(self::COLUMNS_2);
            }
        ])
            ->find($id);

        return $result;
    }

    /**
     * Update the new order
     *
     * @param int $id
     * @param array $data
     *
     * @return void
     */
    public function updateOrder($id, $data)
    {
        $result = $this->startConditions()
            ->where('id', $id)
            ->update([
            'client_email' => $data['client_email'],
            'partner_id' => $data['partner_id'],
            'status' => $data['status']
        ]);
    }
}