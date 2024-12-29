<?php

namespace App\Helpers;

use App\Models\Book;
use Illuminate\Support\Facades\Cookie;

class CartManager
{

    /* add item to cart */

    public static function addItemToCart(int $book_id, $quantity = 1)
    {
        $carts_items = self::getAllCartItemsFromCookies();

        $already_exist_item = null;

        $book = Book::find($book_id);

        foreach ($carts_items as $key => $item) {

            if ($item['book_id'] == $book_id) {

                $already_exist_item = $key;

                break;
            }
        }

        if ($already_exist_item !== null) {

            $carts_items[$already_exist_item]['quantity'] = $carts_items[$already_exist_item]['quantity'] + $quantity;

            $carts_items[$already_exist_item]['total_amount'] = $carts_items[$already_exist_item]['quantity'] * $carts_items[$already_exist_item]['unit_amount'];
        } else {

            if ($book) {

                $carts_items[$book_id] = [
                    'book_id' => $book_id,
                    'name' => $book->name,
                    'slug' => $book->slug,
                    'identifiant' => $book->identifiant,
                    'image' => $book->images[0],
                    'quantity' => $quantity,
                    'unit_amount' => $book->price,
                    'total_amount' => $book->price,
                ];
            }
        }

        self::addCartItemsToCookies($carts_items);

        return count($carts_items);
    }

    /* remove item from cart */

    public static function removeCartItem(int $book_id)
    {
        $carts_items = self::getAllCartItemsFromCookies();

        if (count($carts_items)) {

            foreach ($carts_items as $key => $item) {

                if ($item['book_id'] == $book_id) {

                    //unset($carts_items[$book_id]);

                    unset($carts_items[$key]);
                }
            }
        }

        self::addCartItemsToCookies($carts_items);

        return $carts_items;
    }

    /* add cart items to cookies */

    public static function addCartItemsToCookies(array $carts_items)
    {
        Cookie::queue('carts_items', json_encode($carts_items), 60 * 24 * 30);
    }

    /* clear cart item from cookies */

    public static function clearCartItemsFromCookies()
    {
        Cookie::queue(Cookie::forget('carts_items'));

        $title = 'order_identifiant' . auth_user()->id;

        session()->forget($title);

        return [];
    }

    /* get all cart item from cart */

    public static function getAllCartItemsFromCookies()
    {
        $carts_items = json_decode(Cookie::get('carts_items'), true);

        if (!$carts_items) {

            $carts_items = [];
        }

        return $carts_items;
    }

    /* increment cart item quantity */

    public static function incrementItemQuantityToCart($book_id, $quantity = 1)
    {
        $carts_items = self::getAllCartItemsFromCookies();

        foreach ($carts_items as $key => $item) {

            if ($item['book_id'] == $book_id) {

                $carts_items[$key]['quantity'] = $carts_items[$key]['quantity'] + $quantity;

                $carts_items[$key]['total_amount'] = $carts_items[$key]['quantity'] * $carts_items[$key]['unit_amount'];
            }
        }

        self::addCartItemsToCookies($carts_items);

        return $carts_items;
    }

    /* derement cart item quantity */

    public static function decrementItemQuantityFromCart($book_id)
    {
        $carts_items = self::getAllCartItemsFromCookies();

        foreach ($carts_items as $key => $item) {

            if ($item['book_id'] == $book_id) {

                if ($carts_items[$key]['quantity'] > 1) {

                    $carts_items[$key]['quantity']--;

                    $carts_items[$key]['total_amount'] = $carts_items[$key]['quantity'] * $carts_items[$key]['unit_amount'];
                }
            }
        }

        self::addCartItemsToCookies($carts_items);

        return $carts_items;
    }

    /* computed grand total
        @return int 
    */

    public static function computedGrandTotal(array $items): int
    {
        return array_sum(array_column($items, 'total_amount'));
    }

    /* computed grand total
        @return int 
    */

    public static function getComputedGrandTotalValue(array $items): int
    {
        return array_sum(array_column($items, 'total_amount'));
    }
}
