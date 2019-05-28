<?php
include($_SERVER["DOCUMENT_ROOT"] . "/app_config.php");
if($_SESSION['payment']=='atm') {
    function null2unknown($data) {
        if ($data == "") {
            return "No Value Returned";
        } else {
            return $data;
        }
    }

    $SECURE_SECRET = "A3EFDFABA8653DF2342E8DAC29B51AF0";
    $vpc_Txn_Secure_Hash = $_GET ["vpc_SecureHash"];
    // unset ( $_GET ["vpc_SecureHash"] );
    unset ( $_SESSION['err_pend'] );
    unset ( $_SESSION['err_fail'] );

    // set a flag to indicate if hash has been validated
    $errorExists = false;

    ksort ($_GET);

    if (strlen ( $SECURE_SECRET ) > 0 && $_GET ["vpc_TxnResponseCode"] != "7" && $_GET ["vpc_TxnResponseCode"] != "No Value Returned") {
        
        //$stringHashData = $SECURE_SECRET;
        //*****************************khởi tạo chuỗi mã hóa rỗng*****************************
        $stringHashData = "";
        
        // sort all the incoming vpc response fields and leave out any with no value
        foreach ( $_GET as $key => $value ) {
    //        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
    //            $stringHashData .= $value;
    //        }
    //      *****************************chỉ lấy các tham số bắt đầu bằng "vpc_" hoặc "user_" và khác trống và không phải chuỗi hash code trả về*****************************
            if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
                $stringHashData .= $key . "=" . $value . "&";
            }
        }
    //  *****************************Xóa dấu & thừa cuối chuỗi dữ liệu*****************************
        $stringHashData = rtrim($stringHashData, "&");	
        
        
    //    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper ( md5 ( $stringHashData ) )) {
    //    *****************************Thay hàm tạo chuỗi mã hóa*****************************
        if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*',$SECURE_SECRET)))) {
            // Secure Hash validation succeeded, add a data field to be displayed
            // later.
            $hashValidated = "CORRECT";
        } else {
            // Secure Hash validation failed, add a data field to be displayed
            // later.
            $hashValidated = "INVALID HASH";
        }
    } else {
        // Secure Hash was not validated, add a data field to be displayed later.
        $hashValidated = "INVALID HASH";
    }

    // Define Variables
    // ----------------
    // Extract the available receipt fields from the VPC Response
    // If not present then let the value be equal to 'No Value Returned'
    // Standard Receipt Data
    $amount = null2unknown ( $_GET ["vpc_Amount"] );
    $locale = null2unknown ( $_GET ["vpc_Locale"] );
    //$batchNo = null2unknown ( $_GET ["vpc_BatchNo"] );
    $command = null2unknown ( $_GET ["vpc_Command"] );
    //$message = null2unknown ( $_GET ["vpc_Message"] );
    $version = null2unknown ( $_GET ["vpc_Version"] );
    //$cardType = null2unknown ( $_GET ["vpc_Card"] );
    $orderInfo = null2unknown ( $_GET ["vpc_OrderInfo"] );
    //$receiptNo = null2unknown ( $_GET ["vpc_ReceiptNo"] );
    $merchantID = null2unknown ( $_GET ["vpc_Merchant"] );
    //$authorizeID = null2unknown ( $_GET ["vpc_AuthorizeId"] );
    $merchTxnRef = null2unknown ( $_GET ["vpc_MerchTxnRef"] );
    $transactionNo = null2unknown ( $_GET ["vpc_TransactionNo"] );
    //$acqResponseCode = null2unknown ( $_GET ["vpc_AcqResponseCode"] );
    $txnResponseCode = null2unknown ( $_GET ["vpc_TxnResponseCode"] );

    // This is the display title for 'Receipt' page 
    //$title = $_GET ["Title"];


    // This method uses the QSI Response code retrieved from the Digital
    // Receipt and returns an appropriate description for the QSI Response Code
    //
    // @param $responseCode String containing the QSI Response Code
    //
    // @return String containing the appropriate description
    //
    function getResponseDescription($responseCode) {
        
        switch ($responseCode) {
            case "0" :
                $result = "Giao dịch thành công - Approved";
                break;
            case "1" :
                $result = "Ngân hàng từ chối giao dịch - Bank Declined";
                break;
            case "3" :
                $result = "Mã đơn vị không tồn tại - Merchant not exist";
                break;
            case "4" :
                $result = "Không đúng access code - Invalid access code";
                break;
            case "5" :
                $result = "Số tiền không hợp lệ - Invalid amount";
                break;
            case "6" :
                $result = "Mã tiền tệ không tồn tại - Invalid currency code";
                break;
            case "7" :
                $result = "Lỗi không xác định - Unspecified Failure ";
                break;
            case "8" :
                $result = "Số thẻ không đúng - Invalid card Number";
                break;
            case "9" :
                $result = "Tên chủ thẻ không đúng - Invalid card name";
                break;
            case "10" :
                $result = "Thẻ hết hạn/Thẻ bị khóa - Expired Card";
                break;
            case "11" :
                $result = "Thẻ chưa đăng ký sử dụng dịch vụ - Card Not Registed Service(internet banking)";
                break;
            case "12" :
                $result = "Ngày phát hành/Hết hạn không đúng - Invalid card date";
                break;
            case "13" :
                $result = "Vượt quá hạn mức thanh toán - Exist Amount";
                break;
            case "21" :
                $result = "Số tiền không đủ để thanh toán - Insufficient fund";
                break;
            case "24" :
                $result = "Thông tin thẻ không đúng - Invalid Card Info";
                break;
            case "25" :
                $result = "OTP không đúng - Invalid OTP";
                break;
            case "253" :
                $result = "Quá thời gian thanh toán - Transaction Time out";
                break;    
            case "99" :
                $result = "Người sủ dụng hủy giao dịch - User cancel";
                break;
            default :
                $result = "Unable to be determined";
        }
        return $result;
    }

    //  -----------------------------------------------------------------------------
    
    //  ----------------------------------------------------------------------------

        $transStatus = "";
        if($hashValidated=="CORRECT" && $txnResponseCode=="0"){
            $_SESSION['transactionNo'] = $transactionNo;
            header("Location: ".urlConfirm);
        }elseif ($hashValidated=="INVALID HASH" && $txnResponseCode=="0"){
            $_SESSION['err_pend'] = getResponseDescription($txnResponseCode);
            header("Location: ".urlPending);
        }else {
            $_SESSION['err_time'] = time(); 
            $_SESSION['err_fail'] = getResponseDescription($txnResponseCode);
        header("Location: ".urlError);
        } 
    ?>
<?php
} else {
    include($_SERVER["DOCUMENT_ROOT"] . "/payment/visa/dr.php");
}
?>