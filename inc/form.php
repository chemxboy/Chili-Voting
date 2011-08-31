<?php
$errors = false;
if ( $_POST && $_POST['best'] && $_POST['unique'] && $_POST['hot'] && $_POST['name'] == "oij123"){ ?>
<div id="post">  <pre>
<?php // handle the post here
    // load Zend Gdata libraries
    require_once '/home/vhosts/chili/inc/ZendGdata/library/Zend/Loader.php';
    Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
    Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

    // set credentials for ClientLogin authentication
    $user = "username@googleaccount.com";
    $pass = "accountpassword";

    try {
      // connect to API
      $service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
      $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
      $service = new Zend_Gdata_Spreadsheets($client);

      // set target spreadsheet and worksheet
      $ssKey = 'spreadsheetid';
      $wsKey = 'od6';

      // create row content
      $row = array(
        "unique" => $_POST['unique'], 
        "hot" => $_POST['hot'], 
        "best" => $_POST['best'],
        //"date" => date("m/d/y")
      );

      // insert new row
      $entryResult = $service->insertRow($row, $ssKey, $wsKey);
      //echo 'The ID of the new row entry is: ' . $entryResult->id;
      
      echo '</pre>';
      echo '<p>Awesome! You should probably go eat some tums now...</p></div>';
      
    } catch (Exception $e) {
      echo '</pre>';
      echo '<p>WOOPS!</p> <p>Nomination failed,</p> <p>call IT!</p></div>';
      //die('ERROR: ' . $e->getMessage());
    }

?>
  
<?php } elseif( $_POST ) {
    $errors = true;
} ?>


<?php if( (!$_POST) || ( $_POST && $errors) ){ ?>

<form id="form" method="post" action="index.php">
<?php if ( $errors ) { ?>
  <div class="message">Please make sure that everything is filled out.</div>
 
<?php } ?>

  <fieldset>
    <div class="form-row">
      <input type="hidden" name="name" value="oij123" />
      <label for="unique">Most Unique</label>
       <select id="unique" name="unique">
        <option label="Select..." value="">Select...</option>
      	<option label="Rodney's Revenge" value="Full Name">Full Name</option>
		<option label="Sgt Peppers" value="Full Name">Full Name</option>
		<option label="Chili Con Carnival in your Mouth" value="Full Name">Full Name</option>
      </select>
    </div>
    <div class="form-row">
     	 &nbsp;
      </div>
    <div class="form-row">
      <label for="hot">Hot as F*ck!</label>
      <select id="hot" name="hot">
         <option label="Select..." value="">Select...</option>
      	<option label="Rodney's Revenge" value="Full Name">Full Name</option>
		<option label="Sgt Peppers" value="Full Name">Full Name</option>
		<option label="Chili Con Carnival in your Mouth" value="Full Name">Full Name</option>
      </select>
    </div>
    <div class="form-row">
     	 &nbsp;
      </div>
    <div class="form-row">
      <label for="best" class="best">Best Overall</label>
       <select id="best" name="best">
         <option label="Select..." value="">Select...</option>
      	<option label="Rodney's Revenge" value="Full Name">Full Name</option>
		<option label="Sgt Peppers" value="Full Name">Full Name</option>
		<option label="Chili Con Carnival in your Mouth" value="Full Name">Full Name</option>
      </select>
      </div>
      <div class="form-row">
     	 &nbsp;
      </div>
      <div class="form-row">
     	 <input type="submit" onClick="this.value='wait...'" value="VOTE" id="submit" />
      </div>
  </fieldset>
</form>



<?php } ?>
