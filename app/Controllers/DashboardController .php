<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Core\Auth;
use TABLES;
use App\Models\Personne;
use App\Services\Service;
use App\Core\MainController;
use App\Services\PersonneService;
use DashboardModel;

class DashboardController extends Controller
{

    public function index()
    {

        Auth::check();

        $dashboard = new DashboardModel();

        $data = [
            'totalSales' => $dashboard->totalSalesToday(),
            'totalProducts' => $dashboard->totalProducts(),
            'lowStock' => $dashboard->lowStockProducts()
        ];

        $this->view('dashboard/index', $data);
    }
}
