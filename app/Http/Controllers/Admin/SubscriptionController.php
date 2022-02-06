<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ReceiptValidator\iTunes\Validator as iTunesValidator;
use App\Subscriptions;

class SubscriptionController extends Controller
{
    
    /**
     * subscription Validation
     * 
     * @param Illuminate\Http\Request $request
     * @return JSON Response
     */
    public function subscriptionValidation(Request $request){
        $receiptBase64Data = $request->receipt_code;
        $response = [
            'ErrorCode' => 201,
            'Message' => 'Not valid',
            'Data' => array(),
            'success'=> 0
        ];
        $validator = new iTunesValidator(iTunesValidator::ENDPOINT_PRODUCTION); // Or iTunesValidator::ENDPOINT_SANDBOX if sandbox testing
        
        if($request->device_type == 1) {
            $response = $this->iTunes($receiptBase64Data,$request->user_id);
        } else if($request->device_type == 0){
            $response = $this->playStore($request->product_id, $receiptBase64Data);
        }       
        $this->apiResponse = $response; 
        return $response;
    }

    /**
     * to validate iTunes purchase
     * 
     * @param string $receiptCode
     * @return array
     */
    public function iTunes($receiptCode,$userId)
    {
        $response = [
            'ErrorCode' => 201,
            'Message' => trans('validation.receipt_not_valid'),
            'Data' => array(),
            'success'=> 0
        ];
        $subscriptions  = new Subscriptions();
        $validator = new iTunesValidator(iTunesValidator::ENDPOINT_PRODUCTION);
        $receiptBase64Data = $receiptCode;
        try {
            $sharedSecret = env('INAPP_IOS_SHARED_SECRET'); // Generated in iTunes Connect's In-App Purchase menu
            $responseValidation = $validator->setSharedSecret($sharedSecret)->setReceiptData($receiptBase64Data)->validate();
            
        } catch (Exception $e) {
            $response = [
                'ErrorCode' => 201,
                'Message' => trans('validation.error_occur'),
                'Data' => array(),
                'success'=> 0
            ];
            return $response;
        } 
        if ($responseValidation->isValid()) { 
          if ($responseValidation->getResultCode() == '21007') {
                $response = [
                'ErrorCode' => 201,
                'Message' => trans('validation.receipt_not_valid'),
                'Data' => array(),
                'success'=> 0
            ];
            }
            $receiptData = $responseValidation->getLatestReceiptInfo();
            if($receiptData == []){
                $response = [
                    'ErrorCode' => 201,
                    'Message' => trans('validation.receipt_not_valid'),
                    'Data' => array(),
                    'success'=> 0
                ];
                return $response;
            }
           
            $subscriptionsArray = array(
                'user_id' => $userId, 
                'product_id' => $receiptData[0]['product_id'], 
                'transaction_id' => $receiptData[0]['transaction_id'],
                'end_date' => $receiptData[0]['expires_date'],
                'subscription_receipt_data' => $receiptCode,
                'is_active' => 1
            );
            $subscriptionDetails = $subscriptions->getDetails($userId);
            if (!empty($subscriptionDetails)) { 
                $subscriptions->updateSubscriptionDetails($userId, $subscriptionsArray);    
            } else { 
                $subscriptions->insert($subscriptionsArray);
            }
            $response = [
                'ErrorCode' => 0,
                'Message' => trans('validation.receipt_valid'),
                'Data' => array(),
                'success'=> 0
                ];

        } else {
                $subscriptionsArray['is_active'] = 0;
                $subscriptions->updateSubscriptionDetails($userId, $subscriptionsArray);  
        }
        return $response;
    }

    /**
     * to validate playStore purchase
     * 
     * @param string $productId
     * @param string $purchaseToken
     * @return array
     */
    public function playStore($productId, $purchaseToken)
    {
        $response = [
            'ErrorCode' => 0,
            'Message' => trans('validation.receipt_valid'),
            'Data' => json_decode('{}'),
            'success'=> 0
        ];
        $subscriptions  = new Subscriptions();
        $userId = config('app.user_id');
        $today = date('Y-m-d');
        
        $client = new \Google_Client();
        $client->setApplicationName(env('INAPP_ANDROID_APPLICATION_NAME'));
        $client->setAuthConfig(env('INAPP_ANDROID_SERVICE_ACCOUNT_JSON_MAIN'));
        $client->setScopes([\Google_Service_AndroidPublisher::ANDROIDPUBLISHER]);

        $validator = new PlayValidator(new \Google_Service_AndroidPublisher($client));

        try {
            $responseValidation = $validator->setPackageName(env('INAPP_ANDROID_PACKAGE_NAME'))
                                    ->setProductId($productId)
                                    ->setPurchaseToken($purchaseToken)
                                    ->validateSubscription();
            $rawResponse = $responseValidation->getRawResponse();
            $updateUserArray['OriginalTransactionID'] = $rawResponse['orderId'];    
        
            $subscriptionsArray = array(
                'user_id' => $userId, 
                'product_id' => $productId, 
                'transaction_id' =>  $rawResponse['orderId'],
                'end_date' => date('Y-m-d H:i:s',$responseValidation->getExpiryTimeMillis() / 1000),
                'subscription_receipt_data' => $purchaseToken
            );
            if (date('Y-m-d H:i:s',$responseValidation->getExpiryTimeMillis() / 1000) > $today ) {                                                                          
                if (config('app.isExpired') == 1) {     
                    $subscriptionsArray['is_active'] = 1;          
                }
            } else {
                if (config('app.isExpired') == 0) {     
                    $subscriptionsArray['is_active'] = 0;      
                }
            }
            $subscriptionDetails = $subscriptions->getDetails($userId);
            if (!empty($subscriptionDetails)) {
                $subscriptions->updateSubscriptionDetails($userId, $subscriptionsArray);    
            } else { 
                $subscriptions->insert($subscriptionsArray);
            }
            
        } catch (Exception $e){
            $response = [
                'ErrorCode' => 201,
                'Message' => trans('validation.receipt_not_valid'),
                'Data' => json_decode('{}'),
                'success'=> 0
            ];
        }
        return $response;
    }

}
