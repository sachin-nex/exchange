<?php

namespace App\Http\Controllers;

use App\Libraries\Bitgo;
use Illuminate\Http\Request;
use App\Models\BitgoModel;
use App\Models\AddressModel;
use App\Traits\StatusResponse;
use Validator;

class BitgoController extends Controller {

	use StatusResponse;

	public function __construct()
	{
		$this->obj = new Bitgo;

		$this->enterprise = env('BITGO_ENTERPRISE_ID');
	}

	public function generate_wallet(Request $request)
	{
		$validator = Validator::make($request->all(),[
            'coin' 	=> 'required|in:eth|min:2',
            'mode' 	=> 'required|in:test,prod|min:2',
            'number'=> 'required|integer'
        ]);

        if ($validator->fails()){

        	$data = $validator->getMessageBag()->toArray();

        	$message = $validator->errors()->first();

        	$response =  $this->_status('VER', $message, $data);

        }else{

        	$d = $request->all();

        	$coin = $this->get_coin($d['mode'],$d['coin']);

        	$url =  $coin.'/wallet/generate';

        	$wallet = [];

        	for ($i = 0; $i < $d['number']; $i++) {
        		$u = date("YmdHis");
        		$p = [
        			'data'  => [

        				'label'		 =>	'wallet_'.strtoupper($d['coin']).'_'.$u,
        				'passphrase' =>	'pass_'.strtoupper($d['coin']).'_'.$u,
        				'enterprise' => $this->enterprise
        			],

        			'url'	=>	$url,
        			'coin'	=> 	$d['coin']
        		];

        		$response = $this->obj->bit_generate_wallet_post($p); 

        		$m = [
        			'wallet_id'	=> $response['id'],
        			'response'	=> json_encode($response),
        			'address'	=> $response['coinSpecific']['baseAddress'],
        			'status'	=> 1,
        			'created_at'=> date("Y-m-d H:i:s")
        		];

        		$model = AddressModel::create($m);

        		$wallet[$i] = $response['id'];

        		$response =  $this->_status('SUCC', 'Address has been generated', $wallet);	
        	}
        }

        return $response;
	}

	public function get_wallet_info($coin,$wallet)
	{
		$d = [
			'data'	=> $wallet,
			'coin'	=> $coin,
			'url' 	=> $coin.'/wallet/'.$wallet
		];
		$response = $this->obj->bit_info_wallet_get($d);
		die(json_encode($response));
	}

	public function post_send_txn(Request $request)
	{
		print_r($request->all()); exit;
	}

	private function get_coin($mode, $coin)
	{
		if($mode == 'test')
		{
			if($coin == 'eth')
				$c = 'teth';

		}else{

			if($coin == 'eth')
				$c = 'eth';
		}

		return $c;
	}

}