<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Prooph\ProophessorDo\Projection\Invoice\InvoiceFinder;

class InvoiceListController extends Controller
{
    public function get(Request $request, InvoiceFinder $invoiceFinder): View
    {
        $invoices = $invoiceFinder->findAll();

        return view('proophessor_do/invoice-list', [
            'invoices' => $invoices,
        ]);
    }
}
