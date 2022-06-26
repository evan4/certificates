<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CertificateNew;
use App\Http\Requests\CertificatePostRequest;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function activateCertificate(Request $request)
    {
        $certCode = filter_var( $request->input('code'), FILTER_SANITIZE_SPECIAL_CHARS);

        $response = false;
        $msg = '';
        $responseCode = 200;

        $certificate = DB::table('certificates')
            ->select('id')
            ->where('code', $certCode)
            ->whereNull('activate_at')
            ->first();

        if($certificate){
            DB::table('certificates')
                ->where('id', $certificate->id )
                ->update(
                    [
                        'activate_at' => today(),
                    ]
                );

            $response = true;  
        }else{
            $msg = 'There is no certificate with that id';
            $responseCode = 404;
        }

        return response()->json([
            'success' => $response,
            'msg' => $msg
        ], $responseCode);
        
    }

    public function storeCertificate(CertificatePostRequest $request)
    {
        $user = $request->user();
        
        $msg = '';
        $responseCode = 200;

        $validated = $request->validated();
        
        $certificateDataset = [
            'first_name' => strip_tags(trim($validated['first_name'])),
            'last_name' => strip_tags(trim($validated['last_name'])),
            'email' => trim($validated['email']),
            'tree_amount' => (int) $validated['amount'],
            'amount' => (int) $validated['total'],
            'plantation_id' => (int) $validated['plantation_id'],
            'payment_option_id' => (int) $validated['payment_option_id'],
            'currency_id' => (int) $validated['currency_id'],
            'code' => (string) Str::uuid(),
        ];

        if($user->payment_account >= $certificateDataset['amount']){
            try {
                $result = DB::transaction(function() use ($certificateDataset, $user) {
                    DB::table('certificates')->insertGetId($certificateDataset);
                    $userAccount = $user->payment_account - $certificateDataset['amount'];

                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['payment_account' => $userAccount]);

                        $currency = DB::table('currencies')
                        ->select('name')
                        ->where('id', $certificateDataset['currency_id'])
                        ->first();
                    $certificateDataset['currencyName'] = $currency->name;
        
                    $plantation =  DB::table('plantations')
                        ->select('name', 'year')
                        ->where('id', $certificateDataset['plantation_id'])
                        ->first();
                    $paymentOption = DB::table('payment_options')
                        ->select('name')
                        ->where('id', $certificateDataset['payment_option_id'])
                        ->first();
        
                    $details = [
                        'theme' => 'New Certificate',
                        'email' => $certificateDataset['email'],
                        'first_name' => $certificateDataset['first_name'],
                        'last_name' => $certificateDataset['last_name'],
                        'tree_amount' => $certificateDataset['tree_amount'],
                        'plantation' => $plantation->name.','.$plantation->year,
                        'paymentOption' => $paymentOption->name,
                        'amount' => $certificateDataset['amount'],
                        'code' => $certificateDataset['code'],
                    ];
                    
                    Mail::to($certificateDataset['email'])->send(new CertificateNew($details));
        
                    return true;
                });
                return response()->json([
                    'success' => $result,
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'msg' => $e->getMessage()
                ], 409);
            }
        }else{
            return response()->json([
                'success' => false,
                'msg' => 'You have not enough money for this operation'
            ], 409);
        }

    }
}
