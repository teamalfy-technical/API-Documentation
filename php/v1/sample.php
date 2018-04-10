<?php
//SEND BILL(POST REQUEST) SAMPLE CODE

if (isset($_POST['submit'])) {

	$error = 0;
	$response = '';

	$wallet = $_POST['wallet'];//wallet number 
	$amount = $_POST['amount'];//amount of money
	$api_key = 'E8C48D4BBAC8FDC0484E58E579EB74C3';//api key generated by system
	$wallet_type = 'm'; //wallet type('m' for MTN, 't' for Tigo)
	$description = 'Business'; //Description of transaction

	if (empty($wallet)) {
		$error++;
	}
	if (empty($amount)) {
		$error++;
	}
	if (empty($api_key)) {
		$error++;
	}
	if (empty($wtype)) {
		$error++;
	}
	if (empty($description)) {
		$error++;
	}

if ($error == 0) {
	$response = sendbill($wallet_type, $wallet, $amount, $description, $api_key);
	$json = json_decode($response,TRUE); 	
	$invoice = $json['invoice_number'];
	

	$form = '<form method="POST" action="">
				<input type="hidden" name="invoice" value="'.$invoice.'"/>
				<input type="submit" name="check"/>
			 </form>';

}

if (isset($_POST['check'])) {
	$invoice = $_POST['invoice'];
	$api_key = 'E8C48D4BBAC8FDC0484E58E579EB74C3';

	if (empty($invoice) || empty($api_key)) {
		$error++;
	}

	if ($error == 0) {
		$response = checkbill($invoice, $api_key);
	}
}

function sendbill($wallet_type,$wallet,$amount,$description,$api_key){

$base_url = "https://www.cediplus.com/apiplus/plus_v1";
$base_url_parameters = 'wallet_type='.$wtype.'&wallet='.$wallet.'&amount='.$amount.'&description='.$description.'&api_key='.$api_key.'&action=sendbill'; 
   $header = array(
     'http' => array(
       'method'  => 'POST',
       'header'  => 'Content-type: application/x-www-form-urlencoded',
       'content' => $sPD
     )
   );
   $context = stream_context_create($header);
   $resultx = file_get_contents($base_url, false, $context);
   $result = json_decode($resultx, TRUE);

   return $result;

}




//CHECK BILL(POST REQUEST) SAMPLE CODE

function checkbill($invoice,$api){
	//Parameter values declared as a variable and assigned example values
$invoice = 'xxxxxxxxxxx';
$api_key = 'xxxxxxxxxxxxxxx';

$base_url = "https://www.cediplus.com/apiplus/plus_v1";
$base_url_parameters = '&invoice='.$invoice.'&api_key='.$api_key.'&action=checkbill'; 
   $header = array(
     'http' => array(
       'method'  => 'POST',
       'header'  => 'Content-type: application/x-www-form-urlencoded',
       'content' => $base_url_parameters
     )
   );
   $context = stream_context_create($aHTTP);
   $resultx = file_get_contents($sURL, false, $context);
   $result = json_decode($resultx, TRUE);

   return $result;
}


?>

<html>
	<form method="POST" action="">
		<input type="text" name="wallet" placeholder="Phone Number"/>
		<input type="number" name="amount" placeholder="Amount" />
		<button type="submit" name="submit">Send</button>
	</form>
	<p>Response: <span><?php echo $response;?></span></p></br>
	<span><?php echo $form;?></span>
</html>
