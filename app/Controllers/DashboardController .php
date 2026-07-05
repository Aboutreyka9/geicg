<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Core\Auth;

class DashboardController extends Controller
{

    public function index()
    {

        Auth::check();

        // $dashboard = new DashboardModel();
        $data = [];

        // $data = [
        //     'totalSales' => $dashboard->totalSalesToday(),
        //     'totalProducts' => $dashboard->totalProducts(),
        //     'lowStock' => $dashboard->lowStockProducts()
        // ];

        $this->view('dashboard/show', $data);
    }

    function test()  {
        return $this->viewGuest('auth/login', ["title" => "Connexion"]);
        
    }
}
