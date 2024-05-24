<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'count_items',
        'quantity_items',
        'service_price',
    ];

    public function __construct()
    {
        $this->caculateCart();
    }

    public function addProductCart($id, $quantity, $price, $service_price)
    {
        $product = Batch::find($id);
        $cart = session()->get('cart');
        $this->service_price = $service_price;
        //if cart is empty then this the first product
        if (!$cart) {

            $cart = [
                $id => [
                    'name' => $product->product->name,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $price * $quantity,
                    'discount' => 0,
                    'prices' => [
                        1 => $product->wholesale_price,
                        2 => $product->retail_price,
                        4 => $product->final_price,
                    ]
                ]
            ];
            session()->put('cart', $cart);
            $this->caculateCart();
            return;
        }

        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity + $cart[$id]['quantity'];
            $cart[$id]['subtotal'] = $cart[$id]['price'] * $cart[$id]['quantity'];
            $cart[$id]['subtotal'] = $cart[$id]['subtotal'] - ($cart[$id]['subtotal'] * ($cart[$id]['discount'] / 100));
            session()->put('cart', $cart);
            $this->caculateCart();
            return;
        }

        //if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            'name' => $product->product->name,
            'quantity' => $quantity,
            'price' => $price,
            'discount' => 0,
            //'subtotal' => (($price * $quantity) - (($price * $quantity) * ($discount / 100))),
            'subtotal' => $price * $quantity,
            'prices' => [
                1 => $product->wholesale_price,
                2 => $product->retail_price,
                4 => $product->final_price,
            ]
        ];
        session()->put('cart', $cart);
        $this->caculateCart();
    }

    public function caculateCart()
    {
        $cart = session()->get('cart');
        $totalProductsInCart = 0;
        $quantityItems = 0;
        if ($cart) {
            foreach ($cart as $id => $item) {
                $totalProductsInCart += $item['subtotal'];
                $quantityItems += $item['quantity'];
            }
            //$this->total = $totalProductsInCart;
            $this->total = $totalProductsInCart + $this->service_price;
            $this->count_items = count($cart);
            $this->quantity_items = $quantityItems;
        }
    }

    public function updateProductCart($id, $quantity, $service_price)
    {
        $this->service_price = $service_price;
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            $cart[$id]['subtotal'] = $cart[$id]['price'] * $cart[$id]['quantity'];
            session()->put('cart', $cart);
            $this->caculateCart();
        }
    }

    public function updateServicePrice($price)
    {
        $this->service_price = $price;
    }

    public function updateProductCartPrice($id, $price, $service_price)
    {
        $this->service_price = $service_price;
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $cart[$id]['price'] = $price;
            $cart[$id]['subtotal'] = $price * $cart[$id]['quantity'];
            session()->put('cart', $cart);
            $this->caculateCart();
        }
    }

    public function updateProductCartDiscount($id, $discount, $service_price)
    {
        $this->service_price = $service_price;
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $cart[$id]['discount'] = $discount;
            $cart[$id]['subtotal'] = $cart[$id]['price'] * $cart[$id]['quantity'];
            $discount_percent = $discount / 100;
            $discount = $cart[$id]['subtotal'] * $discount_percent;
            //dd($discount_percent, $discount, $cart[$id]['subtotal']);
            $cart[$id]['subtotal'] = $cart[$id]['subtotal'] - $discount;
            $cart[$id]['subtotal'] = round($cart[$id]['subtotal'], 2);
            session()->put('cart', $cart);
            $this->caculateCart();
        }
    }

    public function deleteProductCart($id, $service_price)
    {
        $this->service_price = $service_price;
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            $this->caculateCart();
        }
    }
}
