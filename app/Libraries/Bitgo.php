<?php
namespace App\Libraries;
use DB;
use App\Models\BitgoLogModel;
use Ixudra\Curl\Facades\Curl;

class Bitgo{

	public function __construct()
    {
    	$this->local_v2_url = env('BITGO_V2_LOCAL_URL');
    	$this->token 		= env('BITGO_TOKEN');
        $this->bitgo_url    = env('BITGO_TEST_URL');
        $this->enterprise   = env('BITGO_ENTERPRISE_ID');
    }

    public function bit_generate_wallet_post($data)
    {

        $url = $this->local_v2_url.$data['url'];

    	$response = Curl::to($url)
            ->withData(json_encode($data['data']))
            ->withHeader("Authorization: Bearer $this->token")
            ->withContentType("application/json")
            ->post();

        $resp = BitgoLogModel::create([
            'event'     => 'BITGO_GENERATE_WALLET',
            'url'       => $url,
            'method'    => 'POST',
            'request'   => json_encode($data['data']),
            'response'  => $response,
            'ip_address'=> request()->ip(),
            'created_at'=> date('Y-m-d H:i:s'),
        ]);

        return json_decode($response,true);  
    }

    public function bit_info_wallet_get($data)
    {
        $url = $this->bitgo_url.$data['url'];

        $response = Curl::to($url)
            ->withHeader("Authorization: Bearer $this->token")
            ->withContentType("application/json")
            ->get();

        $resp = BitgoLogModel::create([
            'event'     => 'BITGO_GET_WALLET',
            'url'       => $url,
            'method'    => 'GET',
            'request'   => '',
            'response'  => $response,
            'ip_address'=> request()->ip(),
            'created_at'=> date('Y-m-d H:i:s'),
        ]);

        return json_decode($response,true);  
    }

    public function bit_send_txn_post($data)
    {
        $url = $this->local_v2_url.$data['url'];

        $response = Curl::to($url)
            ->withHeader("Authorization: Bearer $this->token")
            ->withContentType("application/json")
            ->get();

        $resp = BitgoLogModel::create([
            'event'     => 'BITGO_GET_WALLET',
            'url'       => $url,
            'method'    => 'GET',
            'request'   => '',
            'response'  => $response,
            'ip_address'=> request()->ip(),
            'created_at'=> date('Y-m-d H:i:s'),
        ]);

        return json_decode($response,true);
    }

}