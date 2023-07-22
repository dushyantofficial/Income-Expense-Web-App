<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function send_message(){

        $api_key = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzQyMDc4NjksImlzcyI6ImxvY2FsaG9zdCIsImV4cCI6MTY3NDIwNzkyOSwiZGF0YSI6eyJpZCI6IjIzNyIsIm5hbWUiOiJudWtlZGVtbyIsIm1vYmlsZSI6IjkxOTQyNTM5MzAyNSIsImVtYWlsIjoibnVrZWRlbW9AZ21haWwuY29tIn19.QT-R7_r2Q8UHZwNh3zbhZXKFFRIYSfNoE3wSYoctg8c";
        $mobile = '919429420049';
        $url = "https://wa20.nuke.co.in/v5/api/index.php/addbroadcast";
        $param =  [

            'brodcast_service'=>'whatsapp_credits',
            'broadcast_name'=>'name',
            "template_id" => "demo_nuke",
            'contacts'=>$mobile,
            'uploaded_image1'=>'https://rathoredesign.com/wp-content/uploads/2021/03/BRDS-Logo-2021.png',

] ;
        $jsonval = json_encode($param);


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_FAILONERROR => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonval,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $api_key,
                'Content-Type: application/json'
            ),
        ));


        try {

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                echo json_encode(array('status' => "error", 'message' => curl_error($curl)));
                exit(0);
               // return back()->with('success','Message Send SuccessFully...');
            }
//            return redirect()->back()->with('success','Message Send SuccessFully...');
            echo json_encode(array('status' => "ok", 'message' => $response));
            exit(0);
        } catch (Exception $e) {
            echo json_encode(array('status' => "error", 'message' => $e));
            exit(0);
        }


    }

    public function template_send_message(){

        $currenturl = url()->full();
        $api_key = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NzQyMDc4NjksImlzcyI6ImxvY2FsaG9zdCIsImV4cCI6MTY3NDIwNzkyOSwiZGF0YSI6eyJpZCI6IjIzNyIsIm5hbWUiOiJudWtlZGVtbyIsIm1vYmlsZSI6IjkxOTQyNTM5MzAyNSIsImVtYWlsIjoibnVrZWRlbW9AZ21haWwuY29tIn19.QT-R7_r2Q8UHZwNh3zbhZXKFFRIYSfNoE3wSYoctg8c";
        $mobile = '919825196095';
//        $url = "https://wa20.nuke.co.in/v5/api/index.php/addbroadcast";
        $url = "https://wa20.nuke.co.in/v5/api/index.php/addbroadcast";
        $param =  [

            'brodcast_service'=>'whatsapp_credits',
            'broadcast_name'=>'name',
            "template_id" => "demo_nuke",
            'contacts'=>$mobile,
            'uploaded_image1'=>"https://rathoredesign.com/wp-content/uploads/2021/03/BRDS-Logo-2021.png",


] ;
        $jsonval = json_encode($param);


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_FAILONERROR => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonval,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $api_key,
                'Content-Type: application/json'
            ),
        ));


        try {
            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                echo json_encode(array('status' => "error", 'message' => curl_error($curl)));
                exit(0);
                // return back()->with('success','Message Send SuccessFully...');
            }
//            return redirect()->back()->with('success','Message Send SuccessFully...');
            echo json_encode(array('status' => "ok", 'message' => $response));
            exit(0);
        } catch (Exception $e) {
            echo json_encode(array('status' => "error", 'message' => $e));
            exit(0);
        }


    }
}
