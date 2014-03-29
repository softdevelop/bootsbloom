<?php 
//
// This source code was recovered by Recover-PHP.com
//

App::import("Vendor", "paypal", array( "file" => "paypal/Paypal.php" ));

class PaypalComponent extends Object
{
    public function processPayment($paymentInfo, $function)
    {
        $paypal = new Paypal();
        if( $function == "DoDirectPayment" ) 
        {
            return $paypal->DoDirectPayment($paymentInfo);
        }

        if( $function == "SetExpressCheckout" ) 
        {
            return $paypal->SetExpressCheckout($paymentInfo);
        }

        if( $function == "GetExpressCheckoutDetails" ) 
        {
            return $paypal->GetExpressCheckoutDetails($paymentInfo);
        }

        if( $function == "DoExpressCheckoutPayment" ) 
        {
            return $paypal->DoExpressCheckoutPayment($paymentInfo);
        }

        if( $function == "DoVoid" ) 
        {
            return $paypal->DoVoid($paymentInfo);
        }

        if( $function == "DoReauthorization" ) 
        {
            return $paypal->DoReauthorization($paymentInfo);
        }

        if( $function == "DoCapture" ) 
        {
            return $paypal->DoCapture($paymentInfo);
        }

        return "Function Does Not Exist!";
    }

}
