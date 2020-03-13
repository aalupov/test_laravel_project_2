<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;
use App\Repositories\PartnerRepository;
use App\Repositories\ProductRepository;
use App\Mail\CompletedOrderMailSend;
use Illuminate\Support\Facades\Mail;

abstract class BaseController extends Controller
{

    /**
     * const array
     */
    protected const viewShareVarsHome = [
        'weather'
    ];

    /**
     * const array
     */
    protected const viewShareVarsOrders = [
        'orders'
    ];

    /**
     * const array
     */
    protected const viewShareVarsProducts = [
        'products'
    ];

    /**
     * const array
     */
    protected const viewShareVarsOrderEdit = [
        'id',
        'order',
        'partners'
    ];

    /**
     * const decimal
     */
    private const LAT = 53.25209;

    /**
     * const decimal
     */
    private const LON = 34.37167;

    /**
     * const string
     */
    private const API_KEY = '9f32f764-1854-4cc2-9160-ee160920a390';

    /**
     * BaseController constructor
     */
    public function __construct()
    {
        $this->OrderRepository = app(OrderRepository::class);
        $this->PartnerRepository = app(PartnerRepository::class);
        $this->ProductRepository = app(ProductRepository::class);
    }

    /**
     * Count the order price
     *
     * @param Illuminate\Database\Eloquent\Collection $collection
     *
     * @return Illuminate\Database\Eloquent\Collection $collection
     */
    protected function countPrice($collection)
    {
        foreach ($collection as $items) {
            $price = 0;
            foreach ($items->products as $item) {
                $price += $item->quantity * $item->price;
            }
            $items->price = $price;
        }
        return $collection;
    }

    /**
     * Get weather
     *
     * @return array
     */
    protected function getWeather()
    {
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "X-Yandex-API-Key: " . self::API_KEY . ""
            )
        );

        $url = "https://api.weather.yandex.ru/v1/forecast?lat=" . self::LAT . "&lon=" . self::LON . "&limit=1&hours=false&extra=false";
        $context = stream_context_create($opts);
        $contents = file_get_contents($url, false, $context);
        $clima = json_decode($contents);

        $weather['temp'] = $clima->fact->temp;
        $weather['wind_speed'] = $clima->fact->wind_speed;
        $weather['pressure'] = $clima->fact->pressure_mm;
        $weather['icon'] = $clima->fact->icon . ".svg";

        return $weather;
    }

    /**
     * send the completed order email.
     *
     * @param Model $data
     * @param Illuminate\Database\Eloquent\Collection $order
     *
     * @return void
     */
    protected function sendCompletedOrderEmail($data, $order)
    {
        $objMailSend = new \stdClass();
        $objMailSend->sender_message = 'The order #' . $order->id . ' has been completed';
        $objMailSend->date = \Carbon\Carbon::now();
        $objMailSend->order = $order;
        $objMailSend->sender_email = env('MAIL_FROM_ADDRESS', 'test@laravel.com');
        $objMailSend->sender_name = env('MAIL_FROM_NAME', 'Laravel');
        $objMailSend->receiver_name = $data->name;
        $mailTo = $data->email;

        Mail::to($mailTo)->send(new CompletedOrderMailSend($objMailSend));
    }
}