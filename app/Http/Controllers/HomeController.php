<?php

namespace App\Http\Controllers;

use App\Models\NFT\NFT;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function storePaymentRequest(Request $request){
        $input = $request->all();

        return response()->json([
            'status' => true,
            'message' => 'Payment Request Created Successfully',
            'data' => $input
        ]);
    }
    public function paymentLink(Request $request)
    {
        $input = $request->all();
        //Get NFT ID Record
        $nft_id = $input['nft_id']??null;
        $nft = NFT::where('id', $nft_id)->first();
        //Check NFT Record
        if(!$nft) {
            return response()->json([
                'status' => false,
                'message' => 'NFT Record Not Found'
            ]);
        }

        //Create Payment Link for NFT
        $dataNFT = [
            'event_id' => $nft->task_id,
            'user_id' => $nft->owner_id,
            'nft_id' => $nft->id,
            'nft_name' => $nft->name,
            'nft_description' => $nft->description,
            'nft_image_url' => $nft->image_url,
            'nft_size' => $nft->size,
            //'nft_asset_contract' => $nft->asset_contract,
            'email' => $input['email']??null,
            'amount' => $input['amount']??null,
            'description' => $input['description']??null,
            'due_date' => $input['due_date']??null,
            'invoice_number' => $input['invoice_number']??null,
            'paid' => false,
            'link' => $input['link']??null,
            'stripe_payment_id' => $input['stripe_payment_id']??null,
            'network' => $input['network']??null,
        ];
        //Callback URL
        $callback_url = route('payment-request', ['link' => $dataNFT['link']]);
        $dataNFT['callback_url'] = $callback_url;
        //MD5 Hash
        $dataNFT['hash'] = md5(json_encode($dataNFT));

        //Create Payment Link with data. Set for router payment-request
        $paymentLink = route('payment-request', $dataNFT);

        //Return Payment Link
        return redirect($paymentLink);
    }

}
