<?php

namespace App\Repositories\Models;

use App\Models\Cart;
use Illuminate\Support\Collection;

/**
 * @method Cart make()
 * @method Collection|Cart[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Cart|null find($id)
 * @method Cart create(array $parameters = [])
 */
class CartRepository extends ModelRepository
{
    protected $modelClassName = Cart::class;

    /**
     * @param integer $userId
     * @return Collection|Cart[]
     */
    public function getByUserId($userId)
    {
        return $this->model->newQuery()->orderBy('id', 'desc')->where('user_id', $userId)->first();
    }

    /**
     * @return Collection|Cart[]
     */
    public function getCartId()
    {
        if (Auth::user()) {
            //gets latest id by userid
            return $this->model->newQuery()->orderBy('id', 'desc')->where('user_id', $userId)->first();
        } else {
            return $this->model->newQuery()->orderBy('id', 'desc')->first();
        }
    }

    public function clearCart($userId)
    {
        $query = $this->model->newQuery()->orderBy('id', 'desc')->where('user_id', $userId)->first();
        //Finds all orders with current cart, clears cart_id
    }
    //when cart is completed, create a new one
}
