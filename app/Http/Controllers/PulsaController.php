<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PulsaController extends Controller
{

    function generateRandomString($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // phpinfo();
        $data = array();
        $data['respon']['rescode'] = "";
        $data['respon']['hp'] = "";
        $data['respon']['vtype'] = "";
        $data['respon']['server_trxid'] = "";
        $data['respon']['partner_trxid'] = "";
        $data['respon']['scrmessage'] = "";
        $data['respon']['resmessage'] = "";
        $data['respon']['sn'] = "";
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
        $posID = "1";
        $channelPIN = "1234";
        $cashierID = "1";
        $serverSecretKey = "777888";
        $serverTrxID = "";
        $partnerTrxID = $this->generateRandomString();
        $lock = $channelID . $storeID . $posID;
        $date = date('YmdHis');
        $param1 = $channelPIN . $serverSecretKey . $serverTrxID . $partnerTrxID;
        $param2 = $lock . $date;
        $md1 = md5($param1);
        $md2 = md5($param2);
        $signature = md5($md1 . $md2);

        $phone =  $input['nohp'];
        $vType = $input['nominal'];

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
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,300); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 600);

        set_time_limit(605);
         
        $output = curl_exec($ch);
         
        if ($output === FALSE)
        {
            $data['error'] = curl_error($ch);
        }
        else 
        {
            $data['error'] = "";

            libxml_use_internal_errors(true);

            $xml = simplexml_load_string($output);
            if ($xml === false) {
                echo "Failed loading XML: ";
                foreach(libxml_get_errors() as $error) {
                    echo "<br>", $error->message;
                }
            }

            $data['respon']['rescode'] = $xml->rescode;
            $data['respon']['hp'] = $xml->hp;
            $data['respon']['vtype'] = $xml->vtype;
            $data['respon']['server_trxid'] = $xml->server_trxid;
            $data['respon']['partner_trxid'] = $xml->partner_trxid;
            $data['respon']['scrmessage'] = $xml->scrmessage;
            $data['respon']['resmessage'] = "";
            $data['respon']['sn'] = "";
        }

        curl_close($ch);
        return view('pulsa.index', $data);
    }

    public function inquiry()
    {
        $input = Input::all();
        $data = array();

        $url = 'http://183.91.68.19:7357/h2h.php?';
        $channelID = "kaskustest";
        $storeID = "test01";
        $posID = "1";
        $channelPIN = "1234";
        $cashierID = "1";
        $serverSecretKey = "777888";
        $serverTrxID = $input['server_trxid'];
        $partnerTrxID = $input['partner_trxid'];
        $lock = $channelID . $storeID . $posID;
        $date = date('YmdHis');
        // $param1 = $channelPIN . $serverSecretKey . $serverTrxID . $partnerTrxID;
        $param1 = $channelPIN . $serverSecretKey . $serverTrxID;
        $param2 = $lock . $date;
        $md1 = md5($param1);
        $md2 = md5($param2);
        $signature = md5($md1 . $md2);

        $queryURL = $url 
                    . "channelid=" . $channelID 
                    . "&posid=" . $posID 
                    . "&password=" . $signature 
                    . "&cmd=inquiry&trxtime=" . $date
                    . "&server_trxid=" . $serverTrxID
                    . "&storeid=" . $storeID
                    . "&cashierid=" . $cashierID;

        $ch = curl_init();
 
        curl_setopt($ch, CURLOPT_URL, $queryURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,300); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 600);

        set_time_limit(605);
         
        $output = curl_exec($ch);
        


        if ($output === FALSE)
        {
            $data['error'] = curl_error($ch);
        }
        else 
        {
            $data['error'] = "";libxml_use_internal_errors(true);

            $xml = simplexml_load_string($output);
            if ($xml === false) {
                echo "Failed loading XML: ";
                foreach(libxml_get_errors() as $error) {
                    echo "<br>", $error->message;
                }
            }

            $this->server_trxid = $xml->server_trxid;

            $data['respon']['rescode'] = $xml->rescode;
            $data['respon']['hp'] = $xml->hp;
            $data['respon']['vtype'] = $xml->vtype;
            $data['respon']['server_trxid'] = $xml->server_trxid;
            $data['respon']['partner_trxid'] = $xml->partner_trxid;
            $data['respon']['scrmessage'] = $xml->scrmessage;
            $data['respon']['resmessage'] = $xml->resmessage;
            $data['respon']['sn'] = $xml->sn;
        }
        curl_close($ch);
        return view('pulsa.index', $data);
    }

}
