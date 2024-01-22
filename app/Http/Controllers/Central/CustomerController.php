<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use MannikJ\Laravel\Wallet\Exceptions\UnacceptedTransactionException;
use Symfony\Component\Translation\Exception\InvalidArgumentException;

// TODO: Write test for this controller
class CustomerController extends Controller
{
    public function index(Request $request)
    {
        return view('customer.index', [
            'customers' => auth()->user()
                ->customers()
                ->when($request->get('search'), function (Builder $query) use ($request){
                    $query->where('email', 'like', '%' . $request->get('search') . '%');
                })
                ->paginate()
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validateWithBag($customer->email, [
            'type' => ['required', 'in:deposit,withdraw'],
            'amount' => ['required', 'decimal:2', 'money', 'numeric', 'min:1'],
            'description' => ['max:1000'],
        ]);

        try{
            if($request->get('type') === 'deposit'){
                $customer->wallet->deposit(money($request->amount)->getAmount(), [
                    'description' => $request->get('description') ?? 'Credit'
                ]);
            }elseif ($request->get('type') === 'withdraw'){
                $customer->wallet->withdraw(money($request->amount)->getAmount(), [
                    'description' => $request->get('description') ?? 'Debit'
                ]);
            }else{
                throw new InvalidArgumentException('Invalid transaction type');
            }
            return back()->with('message', 'Account funded');
        }catch (\InvalidArgumentException $exception){
            return back()->with('error', $exception->getMessage());
        }catch (\Exception $exception){
            logger()->error("Customer funding failed: " . $exception->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }
}
