<?php
// https://docs.midtrans.com/en/snap/integration-guide?id=integration-steps-overview

namespace Midtrans;

include_once("../Config/load.php");
// include_once("../Config/cdn.php");


$SERVER_KEY = "SB-Mid-server-YcCmoDWvTmyJKpdprLM4xyNc";
$CLIENT_KEY = "SB-Mid-client-cmSC_eQFz2dIfF-D";

require_once dirname(__FILE__) . '/midtrans-php-master/Midtrans.php';
// Set Your server key
// can find in Merchant Portal -> Settings -> Access keys
Config::$serverKey = $SERVER_KEY;
Config::$clientKey = $CLIENT_KEY;

// non-relevant function only used for demo/example purpose
printExampleWarningMessage();

// Uncomment for production environment
// Config::$isProduction = true;

// Enable sanitization
Config::$isSanitized = true;

// Enable 3D-Secure
Config::$is3ds = true;

// Uncomment for append and override notification URL
// Config::$appendNotifUrl = "https://example.com";
// Config::$overrideNotifUrl = "https://example.com";

// Required
$transaction_details = array(
    'order_id' => rand(),
    'gross_amount' => $_POST["priceSub"],
);

$subscription_details = array(
    'id' => $_POST["durationSub"],
    'price' => $_POST["priceSub"],
    'quantity' => 1,
    'name' => $_POST["nameSub"],
);

// Optional
$customer_details = array(
    'first_name'    => $_POST["fnSub"],
    'email'         => $_POST["emailSub"],
);


// Optional
// $callbacks = array(
//     'finish'    => "http://localhost/Proyek_Aplin/CalonSultan/success-payment.php",
// );

// Optional, remove this to display all available payment methods
$enable_payments = array('credit_card', 'cimb_clicks', 'mandiri_clickpay', 'echannel');

// Fill transaction details
$transaction = array(
    // 'enabled_payments' => $enable_payments,
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => array($subscription_details),
    // 'callbacks' => $callbacks
);

$snap_token = '';
try {
    $snap_token = Snap::getSnapToken($transaction);
} catch (\Exception $e) {
    echo $e->getMessage();
}
echo "<script>console.log('$snap_token');</script>";

// echo "snapToken = " . $snap_token;

function printExampleWarningMessage()
{
    if (strpos(Config::$serverKey, 'your ') != false) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'<your server key>\';');
        die();
    }
}
$user = json_decode($_COOKIE["user"], true);
$backpageurl = "../subscription.php?sub=";
if ($_POST["durationSub"] == 1) {
    $backpageurl .= "1msae4e";
} else if ($_POST["durationSub"] == 6) {
    $backpageurl .= "6msks4e";
} else {
    $backpageurl .= "1ywa4ev";
}
// echo $backpageurl;
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Calon Sultan</title>
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <link rel="icon" href="../Images/logo.png" type="image/x-icon">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" type="text/css" href="../CSS/tailwind.css">
    <link rel="stylesheet" type="text/css" href="../CSS/style-custom.css">
    <style>
        .gradient {
            background: linear-gradient(90deg, #487f63 0%, #f0b86c 100%);
        }
    </style>
</head>


<body class="leading-normal tracking-normal text-white gradient" style="font-family: 'Source Sans Pro', sans-serif">


    <div class="w-full flex justify-center">
        <div class="block p-6 rounded-lg shadow-lg bg-darkColor max-w-md mt-36 w-96">
            <div class="text-lg font-bold text-center mb-6 text-whiteColor">Payment Page</div>

            <div class="form-group mb-6">
                <span class="text-yellowColor text-center"> </span> <br />
                <br />
                <input type="hidden" id="nameSub" value='<?= $_POST["nameSub"] ?>'>
                <input type="hidden" id="emailUser" value='<?= $user["email"] ?>'>
                <input type="hidden" id="priceSub" value='<?= $_POST["priceSub"] ?>'>
                <span class="ml-1 text-whiteColor">User : <?= $user["nama"]; ?> </span> <br />
                <span class="ml-1 text-whiteColor">Subscription Name : <?= $_POST["nameSub"] ?> </span> <br />
                <span class="ml-1 text-whiteColor">Subscription Price : <?= $_POST["priceSub"] ?> </span> <br />
            </div>
            <button id="pay-button" class="w-full px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight  uppercase  rounded   shadow-md  hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out mt-10">Pay!</button>

            <div class="w-full flex justify-center mt-10">
                <a href=<?= $backpageurl; ?> class="text-red-200">Cancel </a>
            </div>
        </div>
    </div>
    <!-- <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre>  -->

    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey; ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript">
        function callAjaxTrans(status) {
            $.ajax({
                type: "POST",
                url: "../Controller/auth-payment.php",
                data: {
                    payment: document.getElementById("nameSub").value,
                    price: document.getElementById("priceSub").value,
                    status: status,
                    email: document.getElementById("emailUser").value
                }
            }).done((data) => {
                alert(data);
                if (data == "Transaksi Subscription Berhasil") {
                    window.location.href = "../success-payment.php?code=scs";
                }
            });
        }
        document.getElementById('pay-button').onclick = function() {
            // what to do : send ajax insert to db user-validation
            // di sana nanti set session 
            // $.ajax({
            //     type: "POST",
            //     url: "../Controller/auth-payment.php",
            //     data: {
            //         paymentvalidation: document.getElementById("nameSub").value,
            //         price: document.getElementById("priceSub").value,
            //         email: document.getElementById("emailUser").value
            //     }
            // }).done(data)({
            //     alert(data);
            // });

            // SnapToken acquired from previous step
            snap.pay('<?php echo $snap_token ?>', {
                // Optional
                onSuccess: function(result) {
                    // console.log(JSON.stringify(result, null, 2));

                    callAjaxTrans(1);
                },
                // Optional
                onPending: function(result) {
                    // console.log("pending");
                    callAjaxTrans(2);
                },
                // Optional
                onError: function(result) {
                    alert("Transaksi Ditolak");
                    // /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
</body>

</html>