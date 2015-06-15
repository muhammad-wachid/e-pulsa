<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PulsaController extends Controller
{
    private $server_trxid = "";

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // phpinfo();
        $data = array();
        $data['respon'] = "";
        $data['error'] = "";
        return view('pulsa.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function topup()
    {
        $input = Input::all();
        $data = array();
        $data['respon'] = "";

        $url = 'http://183.91.68.19:7357/h2h.php?';
        $channelID = "kaskustest";
        $storeID = "test01";
        $posID = "";
        $channelPIN = "1234";
        $cashierID = "";
        $serverSecretKey = "777888";
        $serverTrxID = "";
        $partnerTrxID = "";
        $lock = $channelID + $storeID;
        $date = date('YmdHis');
        $signature = md5(md5($channelPIN + $serverSecretKey + $partnerTrxID) + md5($lock + $date));

        $phone =  $input['nohp']; //$request->input('nohp');
        $vType = $input['nominal']; //$request->input('nominal');

        $queryURL = $url 
                    . "channelid=" . $channelID 
                    . "&posid=" . $posID 
                    . "&password=" . $signature 
                    . "&cmd=topup&hp=" . $phone 
                    . "&vtype=" . $vType
                    . "&trxtime=" . $date
                    . "&partner_trxid=" . $partnerTrxID
                    . "&storeid=" . $storeID
                    . "&cashierid=" . $cashierID;

        $ch = curl_init();
 
        curl_setopt($ch, CURLOPT_URL, $queryURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
         
        $output = curl_exec($ch);
         
        curl_close($ch);

        $data['respon'] = $output;
        if ($output === FALSE)
        {
            $data['error'] = curl_error($ch);
        }
        else 
        {
            $data['error'] = "";
        }
        return view('pulsa.index', $data);
    }

    public function inquiry()
    {
        $data = array();
        $data['respon'] = "";

        $url = 'http://183.91.68.19:7357/h2h.php?';
        $channelID = "kaskustest";
        $storeID = "test01";
        $posID = "";
        $channelPIN = "1234";
        $cashierID = "";
        $serverSecretKey = "777888";
        $serverTrxID = "";
        $partnerTrxID = "";
        $lock = $channelID + $storeID;
        $date = date('YmdHis');
        $signature = md5(md5($channelPIN + $serverSecretKey + $partnerTrxID) + md5($lock + $date));

        $queryURL = $url 
                    . "channelid=" . $channelID 
                    . "&posid=" . $posID 
                    . "&password=" . $signature 
                    . "&cmd=inquiry&trxtime=" . $date
                    . "&server_trxid=" . $this->server_trxid
                    . "&storeid=" . $storeID
                    . "&cashierid=" . $cashierID;

        $ch = curl_init();
 
        curl_setopt($ch, CURLOPT_URL, $queryURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
         
        $output = curl_exec($ch);
         
        curl_close($ch);

        if ($output === FALSE)
        {
            $data['error'] = curl_error($ch);
        }
        else 
        {
            $data['error'] = "";
        }
        return view('pulsa.index', $data);
    }

}
