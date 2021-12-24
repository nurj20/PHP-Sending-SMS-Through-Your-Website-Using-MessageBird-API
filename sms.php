<?php
require 'vendor/autoload.php';
if(isset($_POST['submit'])){
    $recipient = $_POST['recipient'];
    $sms = $_POST['sms'];

    $messageBird = new \MessageBird\Client('USE_YOUR_API_KEY_HERE');
    $message =  new \MessageBird\Objects\Message();
    try{

        $message->originator = 'USE_YOUR_PHONE_REGISTERED_WITH_MESSAGEBIRD_HERE';
        $message->recipients = [$recipient];
        $message->body = $sms;
        $response = $messageBird->messages->create($message);
    }
    catch(Exception $e) {echo $e;}
}
?>
<link rel="stylesheet" href="style.css">
<div class="sms-container">

<form action="sms.php" method="POST">
    <h1>Send SMS Online</h1>
    <label for="recipient">Recipient's Number</label>
    <input type="text" name="recipient" id="recipient">
    <label for="sms">Write SMS</label>
    <textarea name="sms" id="sms" cols="30" rows="10"></textarea>
    <input type="submit" value="Send SMS" name="submit">
</form>
<div class="response-container">
    <h1>SMS Status</h1>
    <p>
        <?php
        if($response){
          echo "<style>
          form{
            display:none;
        }
        .response-container{
        display:block;
        }
          </style>
          ";
          $res = $response->recipients->items[0]->recipient;
          $status = $response->recipients->items[0]->status;
          echo "<b> From: <b/> $response->originator <br>";  
          echo "<b> To: <b/> $res <br>";
          echo "<b> SMS: <b/> $response->body <br>";
          echo "<b> Status: <b/> $status <br>";

        }
        ?>
    </p>
</div>
</div>