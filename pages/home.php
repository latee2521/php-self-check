<!-- jQuery & jQueryUI + theme -->
<!--<link href="http://203.158.192.143/selfcheck/includes/keyboard/css/ui-lightness/jquery-ui.min.css" rel="stylesheet" />-->
<link href="http://203.158.192.143/selfcheck/includes/keyboard/css/ui-smooth/jquery-ui.min.css" rel="stylesheet" />
<script src="http://203.158.192.143/selfcheck/includes/keyboard/js/jquery-ui.min.js"></script>

<!-- keyboard widget css & script -->
<link href="http://203.158.192.143/selfcheck/includes/keyboard/css/keyboard.css" rel="stylesheet" />
<script src="http://203.158.192.143/selfcheck/includes/keyboard/js/jquery.keyboard.js"></script>

<!-- keyboard optional extensions -->
<script src="http://203.158.192.143/selfcheck/includes/keyboard/js/jquery.mousewheel.js"></script>
<script src="http://203.158.192.143/selfcheck/includes/keyboard/js/jquery.keyboard.extension-autocomplete.js"></script>
<script src="http://203.158.192.143/selfcheck/includes/keyboard/js/jquery.keyboard.extension-typing.js"></script>
<script src="http://203.158.192.143/selfcheck/includes/keyboard/js/jquery.keyboard.extension-mobile.js"></script>
<script src="http://203.158.192.143/selfcheck/includes/keyboard/js/jquery.keyboard.extension-navigation.js"></script>
<script src="http://203.158.192.143/selfcheck/includes/keyboard/js/jquery.keyboard.extension-scramble.js"></script>
<script src="http://203.158.192.143/selfcheck/includes/keyboard/layouts/thai.js"></script>


<div id="page_content">

<?php 
//keypad include
if ($allow_manual_userid_entry) { 
	//include_once('includes/keypad.php');
?>

<div id="keypad_icon" onClick="getkeyboardbarcode()">
	    <img id="keyboard" title="เปิดการใช้งาน Virtual Keyboard" src="images/keypad_icon.gif" style="cursor:pointer" />
</div>

<?php } ?>

	<div id="banner_title">
		<h2>
			<span>&nbsp;<?php echo $library_name;?></span><br  />
			<?php echo $module_name;?>
		</h2>
	</div>
	<div class="corners" id="banner">
		<span id="swap">
			<img src="images/<?php echo $card_image;?>_card1.png" align="left" class="active" />
			<?php if ($card_image!='magnetic'){ ?>
				<img src="images/<?php echo $card_image;?>_card2.png" align="left"/>
			<?php }?>
		</span>
		<h2><?php echo $intro_screen_text;?></h2>
	</div>
	
	<div id="response"></div><!-- response container for showing failed login/blocked patron messages -->
			
	<!--  ============= form for submitting patron id ============= -->
	<!--<div style="position: absolute;left:-10000px;height:1px;overflow:hidden">-->
	<div style="display:none; position:absolute">
		<form id="form">
			<input name="barcode" type="text" id="barcode"  />
			<input name="password" type="password" id="password" />
		</form>
	</div>
	<!--  ============= end form for submitting items ============= -->

</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#form').submit(function(){
		
		$barcode=$('#barcode');
		$password=$('#password');
		$response=$("#response");
		$response.html('<h2 style="color:#4d8b27"> กำลังตรวจสอบข้อมูลสมาชิก กรุณารอสักครู่... <img src="images/checking_account.gif" /></h2>');
		
		$.post("processes/account_check.php", { barcode: $barcode.val(), password: $password.val() },
			function(data){
				setTimeout(function(){
					if (data=='out of order'){ //does the response indicate a failed sip2 connection
						window.location.href='index.php?page=out_of_order';
					} else if (data=='blocked account'){ //does the response indicate a blocked account
						$.dbj_sound.play('<?php echo $error_sound;?>');
						$response.html('<h2 id="error_message"><span style="text-decoration:blink">ข้อมูลสมาชิกมีปัญหา</span> กรุณาติดต่อเจ้าหน้าที่ !</h2>');
						setTimeout(function() { $('#error_message').hide(); },10000);
					} else if (data=='invalid account'){ //does the response indicate an invalid account
						$.dbj_sound.play('<?php echo $error_sound;?>');
						$response.html('<h2 id="error_message"><span style="text-decoration:blink">ข้อมูลผิดพลาด</span> กรุณาสแกนรหัสบาร์โค๊ดอีกครั้ง !</h2>');
					setTimeout(function() { $('#error_message').hide(); },10000);
					} else { //if everything is ok with the patron's account show the welcome screen
						$("#page_content").html(data);
					
					}
				}, 1000);
		},'json'); //responses from process/account_check.php are expectd to be in json
		
		//$barcode.val('');
		//$password.val('');
		//$barcode.focus();
		
		return false;   
	});
});


function getkeyboardbarcode(){
$('#keyboard').click(function(){
		$('#barcode').attr('readonly', false);
		$('#password').attr('readonly', false);
		$('#barcode').val('');
		$('#password').val('');
});

$('#barcode').keyboard({
		layout : 'custom',
		alwaysOpen : false,
		stopAtEnd : true,
		maxLength : 14,
		customLayout : { 
				'default' : [
				'1 2 3',
				'4 5 6',
				'7 8 9',
				'0 - #',
				'{bksp}  {accept}'
				] 
		},
		position : {
				//of : null, 
				my : 'center top',
				at : 'center top',
				at2: 'center bottom' 
		},
		display : {
			'accept' : 'Enter:Enter (Shift-Enter)',
			'bksp'   : 'Cancle:Backspace'
		},
		accepted : function(){
				setTimeout(function() { 
						$('#password').focus();
				}, 1000);
				getkeyboardpassword();
		}
});

}

function getkeyboardpassword(){
$('#password').keyboard({
		layout       : 'thai-qwerty',
		alwaysOpen : false,
		stopAtEnd : true,
		openOn       : 'focus',
		position     : {
				//of : null, 
				my : 'center top',
				at : 'center top',
				at2: 'center bottom' 
		},
		display : {
			'accept' : 'Submit:Submit (Shift-Enter)',
			'bksp'   : 'Backspace:Backspace',
		},
		accepted : function(){
				setTimeout(function() { 
						$('#barcode').attr('readonly', 'readonly');
						$('#password').attr('readonly', 'readonly');
						$('#form').submit();
				},1000);
		}
});
}
</script>