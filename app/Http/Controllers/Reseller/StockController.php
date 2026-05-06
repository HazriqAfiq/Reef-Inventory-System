<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = auth()->user()->resellerStocks()->with('product')->paginate(15);
        return view('reseller.stock.index', compact('stocks'));
    }
}
