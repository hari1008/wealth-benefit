<?php

/*
 * File: PaymentContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\PaymentContract;
use App\Implementers\BaseImplementer;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Transaction;
use App\Codes\Constant;
use App\Models\UserSession;

class PaymentContractImpl extends BaseImplementer implements PaymentContract {
    
    public function __construct() {
    }
    
    
    /**
        * 
        * Does redirection to the ccavenue after filling the information 
        * 
        * @param $data which contains order id and encVal
        * 
        * @throws Exception If something happens during the process
        * 
    */
    public function bringPaymentForm($request) {
        try{ 
            $request['accessCode'] = env('CCAVENUE_ACCESS_CODE');
            $request['merchantId'] = env('CCAVENUE_MERCHANT_ID');
            $request['redirectUrl'] = env('APP_URL').'/response';
            $request['cancelUrl'] = env('APP_URL').'/cancel';
            $request['rsaKeyUrl'] = env('APP_URL').'/get-rsa-key';
            return view('payment.ccavenue',array('data'=>$request));
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    
    /**
        * 
        * Does capture the response of the ccavenue
        * 
        * @param $data which contains encResp
        * 
        * @throws Exception If something happens during the process
        * 
    */
    public function captureResponse($data) {
        try{ 
            $workingKey= env('CCAVENUE_WORKING_KEY');		//Working Key should be provided here.
            $encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
            $rcvdString= $this->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
            $order_status="";
            $decryptValues=explode('&', $rcvdString);
            $dataSize=sizeof($decryptValues);

            for($i = 0; $i < $dataSize; $i++) 
            {
                $data = explode('=',$decryptValues[$i]);
                $information[$data[0]] = $data[1];
            }
            if($information['order_status'] === "Success")
            {
                    $transactionDetails = Transaction::where('transaction_payment_id',$information['order_id'])->first();
                    if($transactionDetails['status'] == Constant::$PAYMENT_INITIATED){
                        $userExpertSession = UserSession::insertUserExpertSessionInfo($transactionDetails);
                        $transactionDetails->status = Constant::$PAYMENT_SUCCESS;
                        $transactionDetails->transaction_response = json_encode($information);
                        $transactionDetails->save();
                        return redirect('success?sessions='.$userExpertSession['sessions_available']);
                    }
                    else{
                        return redirect('failure');
                        echo 'Already processed payment request'; die;
                    }
            }
            else if($information['order_status'] === "Aborted")
            {
                    $transactionDetails = Transaction::where('transaction_payment_id',$information['order_id'])->first();
                    $transactionDetails->status = Constant::$PAYMENT_ABORTED;
                    $transactionDetails->transaction_response = json_encode($information);
                    $transactionDetails->save();
                    return redirect('aborted');

            }
            else if($information['order_status'] === "Failure")
            {
                    $transactionDetails = Transaction::where('transaction_payment_id',$information['order_id'])->first();
                    $transactionDetails->status = Constant::$PAYMENT_FAILURE;
                    $transactionDetails->transaction_response = json_encode($information);
                    $transactionDetails->save();
                    return redirect('failure');
            }
            else
            {
                    echo "<br>Security Error. Illegal access detected";
            }
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    /**
        * 
        * Does provide the RSA key
        * 
        * @param $data which contains order_id
        * 
        * @throws Exception If something happens during the process
        * 
    */
    public function getRSAKey($request) {
        try{ 
                $url = "https://secure.ccavenue.ae/transaction/getRSAKey";
                $fields = array('access_code'=>env('CCAVENUE_ACCESS_CODE'),'order_id'=>$request['order_id']);

                $postvars='';
                $sep='';
                foreach($fields as $key=>$value)
                {
                        $postvars.= $sep.urlencode($key).'='.urlencode($value);
                        $sep='&';
                }

                $ch = curl_init();

                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_POST,count($fields));
                curl_setopt($ch, CURLOPT_CAINFO,public_path().'/'.env('CC_AVENUE_PEM_FILE'));
                curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                return $this->renderSuccess(trans('messages.rsa_get_successfully'),$result);
        } 
        catch(\Exception $e){
                UtilityHelper::logException(__METHOD__, $e);
                return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
            
    }
    
    public function encrypt($plainText,$key)
    {
        $secretKey = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
        $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
        $plainPad = $this->pkcs5_pad($plainText, $blockSize);
        if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) 
        {
              $encryptedText = mcrypt_generic($openMode, $plainPad);
              mcrypt_generic_deinit($openMode);
        } 
        return bin2hex($encryptedText);
    }

    public function decrypt($encryptedText,$key)
    {
        $secretKey = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText= $this->hextobin($encryptedText);
        $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
        mcrypt_generic_init($openMode, $secretKey, $initVector);
        $decryptedText = mdecrypt_generic($openMode, $encryptedText);
        $decryptedText = rtrim($decryptedText, "\0");
        mcrypt_generic_deinit($openMode);
        return $decryptedText;
    }
    
    //*********** Padding Function *********************
    public function pkcs5_pad ($plainText, $blockSize)
    {
        $pad = $blockSize - (strlen($plainText) % $blockSize);
        return $plainText . str_repeat(chr($pad), $pad);
    }

    //********** Hexadecimal to Binary function for php 4.0 version ********
    public function hextobin($hexString) 
    { 
           $length = strlen($hexString); 
           $binString="";   
           $count=0; 
           while($count<$length) 
           {       
               $subString =substr($hexString,$count,2);           
               $packedString = pack("H*",$subString); 
               if ($count==0)
               {
                           $binString=$packedString;
               } 

               else 
               {
                           $binString.=$packedString;
               } 

               $count+=2; 
           } 
           return $binString; 
    }
    public function getSplitPayment($request)
    {
        // Provide working key share by CCAvenues
        
        $working_key = env('CCAVENUE_WORKING_KEY');		//Working Key should be provided here.
        
        // Provide access code Shared by CCAVENUES

        $access_code = env('CCAVENUE_ACCESS_CODE');
        
        // Provide URL shared by ccavenue (UAT OR Production url)

        $URL="https://login.ccavenue.ae/apis/servlet/DoWebTrans";

        // Sample request string for the API call

        $merchant_json_data  = array("reference_no" => $request['referenceNo'],
                                    "split_tdr_charge_type"=>"A",
                                    "merComm"=>"2.0",
                                    "split_data_list"=>array(
                                                array("splitAmount"=> "5","subAccId" => "43712-1")) //more arrays should be added to split respective transactions.																split one transaction at a time add only one array.
                                );

        // Generate json data after call below method

         $merchant_data = json_encode($merchant_json_data);

         // Encrypt merchant data with working key shared by ccavenue

         $encrypted_data = $this->encrypt($merchant_data, $working_key);

         //make final request string for the API call

         $final_data ="request_type=JSON&access_code=".$access_code."&command=createSplitPayout&response_type=JSON&enc_request=".$encrypted_data."&version=1.1";

         // Initiate api call on shared url by CCAvenues

         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL,$URL);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_VERBOSE, 1);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS,$final_data);

         // Get server response ... curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec ($ch);

         curl_close ($ch);

         $information=explode('&',$result);
         $dataSize=sizeof($information);
         print_r($information);
         $status1=explode('=',$information[0]);
          $status2=explode('=',$information[1]); 
          if($status1[1] == '1'){
                  $status=$status2[1];
          }else{
              print_r($status2[1]);
                 $status=$this->decrypt($status2[1],$working_key);
         }
         die;
          echo "<pre>";
                 print_r($status);
         echo "</pre>";


    }
}    