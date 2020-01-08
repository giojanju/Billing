<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\QueryFilters\ClientName;
use App\QueryFilters\Id;
use App\QueryFilters\UserId;
use Exception;
use Illuminate\Pipeline\Pipeline;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = app(Pipeline::class)
            ->send(Payment::with('client', 'user'))
            ->through([
                Id::class,
                UserId::class,
                ClientName::class,
            ])
            ->thenReturn();

        $payments = $payments->latest()->paginate(10);

        return view('payments.index', compact('payments'));
    }

    public function remove(Payment $payment)
    {
        try {
            $payment->delete();
        } catch (Exception $e) {
            return redirectFail('payments.index', 'Payment deleted successful!');
        }

        return redirectSuccess('payments.index', 'Payment deleted successful!');
    }
}
