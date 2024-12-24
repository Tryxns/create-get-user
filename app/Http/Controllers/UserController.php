<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    //
    function register_user(Request $request) {
        $last_record = User::create($request->all());

        return response()->json([
            'id'        => $last_record->id,
            'email'     => $last_record->email,
            'name'      => $last_record->name,
            'created_at'=> $last_record->created_at,
        ]);
    }

    function get_user(Request $request){      
        // init var
        $data   = [];
        $users  = [];

        // paging
        $page   = 1;
        if( $request->input('page') ) $page = $request->input('page');

        $limit  = 10;
        $offset = ($page-1)*$limit;
        // paging end

        $sortBy = 'created_at';
        if( $request->input('sortBy') ) $sortBy = $request->input('sortBy');

        // Base Query
        $query_user= DB::table('users')
        ->select('users.id', 'name', 'email', 'users.created_at', DB::raw('count(`orders`.`user_id`) as orders_count'))
        ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
        ->where('active',1)
        ->skip($offset)->take($limit)
        ->orderBy("users.".$sortBy, 'asc')->groupBy('users.id', 'name', 'email', 'users.created_at');

        if ( $request->input('search') ) {
            $search = $request->input('search');
            $query_user->where('name', 'like', '%'.$search.'%')->orWhere('email','like', '%'.$search.'%');
        }

        $query_rs = $query_user->get();
        
        foreach ( $query_rs as $user) {
            $users[]=[
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'created_at' => $user->created_at,
                'orders_count' => $user->orders_count
            ];
        }
        $data['page'] = $page;
        $data['users'] = $users;
        return response()->json($data);
    }
}
