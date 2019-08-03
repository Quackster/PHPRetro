<?php
/*================================================================+\
|| # PHPRetro - An extendable virtual hotel site and management
|+==================================================================
|| # Copyright (C) 2009 Yifan Lu. All rights reserved.
|| # http://www.yifanlu.com
|| # Parts Copyright (C) 2009 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|| # All images, scripts, and layouts
|| # Copyright (C) 2009 Sulake Ltd. All rights reserved.
|+==================================================================
|| # PHPRetro is provided "as is" and comes without
|| # warrenty of any kind. PHPRetro is free software!
|| # License: GNU Public License 3.0
|| # http://opensource.org/licenses/gpl-license.php
\+================================================================*/

require_once('./includes/core.php');
$data = new register_sql;
$lang->addLocale("landing.register");

$page['name'] = $lang->loc['pagename.register'];
if(isset($_GET['registerCancel']) && $_GET['registerCancel'] == "true"){
session_unset();
header("Location: ".PATH."/"); exit;
}

if(session_is_registered(username)){ header("Location: ".PATH."/"); exit; }
//Referral
if(isset($_GET['referral'])){
	$referral = $input->FilterText($_GET['referral']);
	if($serverdb->num_rows($data->select1($referral)) > 0){
		$refer = true;
		$referrow = $db->fetch_row($data->select1($referral));
	}
}
$figure = $input->FilterText($_GET['figure']);
$gender = $input->FilterText($_GET['gender']);
if(isset($_POST['bean_avatarName'])){

$name = $input->FilterText($_POST['bean_avatarName']);
$password = $input->FilterText($_POST['password']);
$retypedpassword = $input->FilterText($_POST['retypedPassword']);
$day = $input->FilterText($_POST['bean_day']);
$month = $input->FilterText($_POST['bean_month']);
$year = $input->FilterText($_POST['bean_year']);
$email = $input->FilterText($_POST['bean_email']);
$retypedemail = $input->FilterText($_POST['bean_retypedEmail']);
$accept_tos = $_POST['bean_termsOfServiceSelection'];
if((!isset($_POST['bean_figure']) || !isset($_POST['bean_gender'])) && isset($_POST['randomFigure'])){
	$_POST['bean_gender'] = substr($_POST['randomFigure'], 0, 1);
	$_POST['bean_figure'] = substr($_POST['randomFigure'], 2);
}
$figure = $input->FilterText($_POST['bean_figure']);
$gender = $input->FilterText($_POST['bean_gender']);
$newsletter = $input->FilterText($_POST['bean_marketing']);
$referid = $input->FilterText($_POST['referral']);
if(isset($_POST['referral'])){
	$referral = $input->FilterText($_POST['referral']);
	if($serverdb->num_rows($data->select1($referral)) > 0){
		$refer = true;
		$referrow = $db->fetch_row($data->select1($referral));
	}
}
$_SESSION['bean_avatarName'] = $_POST['bean_avatarName'];
$_SESSION['password'] = $_POST['password'];
$_SESSION['retypedPassword'] = $_POST['retypedPassword'];
$_SESSION['bean_day'] = $_POST['bean_day'];
$_SESSION['bean_month'] = $_POST['bean_month'];
$_SESSION['bean_year'] = $_POST['bean_year'];
$_SESSION['bean_email'] = $_POST['bean_email'];
$_SESSION['bean_retypedEmail'] = $_POST['bean_retypedEmail'];
$_SESSION['bean_termsOfServiceSelection'] = $_POST['bean_termsOfServiceSelection'];
$_SESSION['bean_figure'] = $_POST['bean_figure'];
$_SESSION['bean_gender'] = $_POST['bean_gender'];
$_SESSION['bean_marketing'] = $_POST['bean_marketing'];
$_SESSION['referral'] = $_POST['referral'];
}elseif(isset($_SESSION['bean_avatarName'])){
$name = $input->FilterText($_SESSION['bean_avatarName']);
$password = $input->FilterText($_SESSION['password']);
$retypedpassword = $input->FilterText($_SESSION['retypedPassword']);
$day = $input->FilterText($_SESSION['bean_day']);
$month = $input->FilterText($_SESSION['bean_month']);
$year = $input->FilterText($_SESSION['bean_year']);
$email = $input->FilterText($_SESSION['bean_email']);
$retypedemail = $input->FilterText($_SESSION['bean_retypedEmail']);
$accept_tos = $_SESSION['bean_termsOfServiceSelection'];
$figure = $input->FilterText($_SESSION['bean_figure']);
$gender = $input->FilterText($_SESSION['bean_gender']);
$newsletter = $input->FilterText($_SESSION['bean_marketing']);
$referid = $input->FilterText($_SESSION['referral']);
if(isset($_SESSION['referral'])){
	$referral = $input->FilterText($_SESSION['referral']);
	if($serverdb->num_rows($data->select1($referral)) > 0){
		$refer = true;
		$referrow = $db->fetch_row($data->select1($referral));
	}
}
}

if(isset($_POST['bean_avatarName']) || isset($_SESSION['bean_avatarName'])){

// Start validating the stuff the user has submitted
$filter = preg_replace("/[^a-z\d\-=\?!@:\.]/i", "", $name);
$email_check = preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $email);

// If this variable stays false, we're safe and can add the user. If not, it means that
// we've encountered errors and we can not proceed, so instead show the errors and do not
// add the user to the database.
$failure = false;
$lang->addLocale("register.errors");

	// Name validation
	if($serverdb->num_rows($serverdb->query("SELECT id,name,email FROM ".PREFIX."users WHERE name = '".$name."' LIMIT 1")) > 0){
		$error['name'] = $lang->loc['error.2'];
		$failure = true;
	} elseif($filter != $name){
		$error['name'] = $lang->loc['error.3'];
		$failure = true;
	} elseif(strlen($name) > 24){
		$error['name'] = $lang->loc['error.4'];
		$failure = true;
	} elseif(strlen($name) < 1){
		$error['name'] = $lang->loc['error.5'];
		$failure = true;
	}

	// MOD- Names validation
	$first = substr($name, 0, 4);
	if (strnatcasecmp($first,"MOD-") == false) {
		$error['name'] = $lang->loc['error.6'];
		$failure = true;
	}

	// Password validation
	if($password !== $retypedpassword){
		$error['password'] = $lang->loc['error.7'];
		$failure = true;
	} elseif(strlen($password) < 6){
		$error['password'] = $lang->loc['error.8'];
		$failure = true;
	/*} elseif(strlen($password) > 20){
		$error['password'] = "Please shorten your password to 20 characters or less!";
		$failure = true;*/
	}

	// E-Mail validation
	if(strlen($email) < 6){
		$error['mail'] = $lang->loc['error.9'];
		$failure = true;
	} elseif($email_check !== 1){
		$error['mail'] = $lang->loc['error.9'];
		$failure = true;
	} elseif($email !== $retypedemail){
		$error['mail'] = $lang->loc['error.10'];
		$failure = true;
	}

	// Date of birth validation
	if($day < 1 || $day > 31 || $month > 12 || $month < 1 || $year < 1920 || $year > 2008){
		$error['dob'] = $lang->loc['error.11'];
		$failure = true;
	}
	
	// captcha check
	if(($_SESSION['register-captcha-bubble'] == strtolower($_POST['bean_captchaResponse']) && !empty($_SESSION['register-captcha-bubble'])) || $settings->find("site_capcha") == "0") {
		unset($_SESSION['register-captcha-bubble']);
	} else {
		$error['captcha'] = $lang->loc['error.1'];
		$failure = true;
	}

	// Terms of Service validation
	if($accept_tos !== "true"){
		$error['tos'] = $lang->loc['error.12'];
		$failure = true;
	}

	// validate figure
	$check = new HoloFigureCheck($figure,$gender,false);
	if($check->error > 0){
		$failure = true;
	}
	
	// Newsletter
	if($newsletter == "true"){
		$newsletter = "1";
	}else{
		$newsletter = "0";
	}
	
	// Finally, if everything's OK we add the user to the database, log him in, etc
	if($failure == false){
		$scredits = $settings->find("register_start_credits");
		
		$dob = $day . "-" . $month . "-" . $year;

		$password = $input->HoloHash($password, $name);

		
		$data->insert1($name,$password,$dob,$figure,$gender,$scredits);
		$row = $serverdb->fetch_row($data->select3($name));
		$serverdb->query("INSERT INTO ".PREFIX."users (id,name,lastvisit,online,ipaddress_last,newsletter,email_verified,show_home,email_friendrequest,email_minimail,email,show_online) VALUES ('".$row[0]."','".$row[1]."','".time()."','".time()."','".$_SERVER[REMOTE_ADDR]."','".$newsletter."','0','1','1','1','".$email."','1')");
		if($scredits > 0){
			$db->query("INSERT INTO ".PREFIX."transactions (userid,time,amount,descr) VALUES ('".$row[0]."','".time()."','".$scredits."','Welcome to " . $sitename . "!')");
		}
		
		if($settings->find("email_verify_enabled") == "1"){
		$hash = "";
		$length = 8;
		$possible = "0123456789qwertyuiopasdfghjkzxcvbnm";
		$i = 0;
		while ($i < $length) {
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		if (!strstr($hash, $char)) {
		  $hash .= $char;
		  $i++;
		}
		}
		$hash = sha1($hash);
		$num = $key;
		$db->query("INSERT INTO ".PREFIX."verify (id,email,key_hash) VALUES ('".$row[0]."','".$email."','".$hash."')");
		$lang->addLocale("email.confirmationemail");
		if($settings->find("email_verify_reward") != "0"){ $reward_text = $lang->loc['email.reward']." ".$settings->find("email_verify_reward")." ".$lang->loc['credits']; }else{ $reward_text = ""; }
		$subject = $lang->loc['email.subject']." ".SHORTNAME;
		$to = $email;
		$html = 
		'<h1 style="font-size: 16px">'.$lang->loc['email.verify.1'].'</h1>

		<p>
		'.$reward_text.'
		'.$lang->loc['email.verify.2'].' <a href="'.PATH.'/email?key='.$hash.'">'.$lang->loc['email.verify.2.b'].'</a>
		</p>

		<p>
		'.$lang->loc['email.verify.3'].'
		</p>

		<blockquote>
		<p>
		<b>'.$lang->loc['email.verify.4'].'</b> '.$name.'<br>
		<b>'.$lang->loc['email.verify.5'].'</b> '.$dob.'
		</p>
		</blockquote>

		<p>
		'.$lang->loc['email.verify.6'].'
		</p>

		<p>'.$lang->loc['email.verify.7'] .'<br><br>
		'.$lang->loc['email.verify.8'].'<p>
		'.PATH.'/</p>

		<p>
		'.$lang->loc['email.verify.9'].' <a href="'.PATH.'/email?remove='.$hash.'">'.$lang->loc['email.verify.9.b'].'</a>.
		</p>

		<p>
		'.$lang->loc['email.verify.11'].'<a href="'.PATH.'/help">'.$lang->loc['email.verify.12'].'</a>.
		</p>';
		$mailer = new HoloMail;
		$mailer->sendSimpleMessage($to,$subject,$html);
		}else{
			$serverdb->query("UPDATE ".PREFIX."users SET email_verified = '1' WHERE id = '".$row[0]."' LIMIT 1");
		}
		
		// Referral
		if($refer == true){
			$data->update1($referrow[0],$settings->find("register_referral_rewards"));
			$db->query("INSERT INTO ".PREFIX."transactions (userid,time,amount,descr) VALUES ('".$referrow[0]."','".time()."','".$settings->find("register_referral_rewards")."','Referring a user.')");
			$data->insert2($row[0],$referrow[0]);
			$_SESSION['referral'] = $referrow[0];
		}

		$user = new HoloUser($name,$password,true);
		$_SESSION['user'] = $user;

		header("Location: ".PATH."/security_check?page=./welcome");

		exit; // cut off the script

		// And we're done!
	}


}

require_once('./templates/register_header.php');

?>
	        	<div id="column1" class="column">
			     		
				<div class="habblet-container ">		
	<?php if($refer == true){ ?>
						<div id="inviter-info">
            <p><?php echo $lang->loc['your.friend']." ".$input->HoloText($referrow[1])." ".$lang->loc['is.waiting']; ?></p>
            <img alt="<?php echo $input->HoloText($referrow[1]); ?>" title="<?php echo $input->HoloText($referrow[1]); ?>" src="<?php echo $user->avatarURL($referrow[2],"b,4,4,sml,1,0"); ?>" />
        </div>
	<?php } ?>
    <form method="post" action="<?php echo PATH; ?>/register" id="registerform" autocomplete="off">
	<input type="hidden" name="bean.figure" id="register-figure" value="<?php echo $input->HoloText($figure); ?>" />
	<input type="hidden" name="bean.gender" id="register-gender" value="<?php echo $input->HoloText($gender); ?>" />
	<input type="hidden" name="bean.editorState" id="register-editor-state" value="" />
	<?php if($refer == true){ ?><input type="hidden" name="referral" id="register-referrer" value="<?php echo $input->HoloText($referral); ?>" /><?php } ?>
<?php
if(!isset($error['captcha'])){
?>
        <div id="register-column-left" >
            <div id="register-section-2">
                <div class="rounded rounded-blue">
                    <h2 class="heading"><span class="numbering white">2.</span><?php echo $lang->loc['choose.name']; ?></h2>

                    <fieldset id="register-fieldset-name">
	                    <div class="register-label white"><?php echo $lang->loc['habbo.name']; ?></div>
		                <input type="text" name="bean.avatarName" id="register-name" class="register-text" value="<?php echo $input->HoloText($name); ?>" size="25" />
		                <span id="register-name-check-container" style="display:none">
		                    <a class="new-button search-icon" href="#" id="register-name-check"><b><span></span></b><i></i></a>		                
		                </span>
                    </fieldset>
                    <div id="name-error-box">
				<?php if(isset($error['name'])){ ?>
                        <div class="register-error">
                            <div class="rounded rounded-red">
                                <div id="name-error-content">
                                    <?php echo $error['name']; ?>
                                </div>
                            </div>
                        </div>
				<?php } ?>
                    </div>

                </div>
            </div>

            <div id="register-section-3">
                <div id="registration-overlay"></div>
	            <div class="cbb clearfix gray">
    	            <h2 class="title heading"><span class="numbering white">3.</span><?php echo $lang->loc['your.details']; ?>	</h2>
    		        <div class="box-content">

			<?php if(isset($error['password'])){ ?>
	                    <div class="register-error">
	                    	<div class="rounded rounded-red">
								<div id="password-error-content">
									<div><?php echo $error['password']; ?></div>
								</div>
							</div>
	                    </div>
			<?php } ?>

                        <fieldset id="register-fieldset-password">
	                        <div class="register-label"><label for="register-password"><?php echo $lang->loc['password']; ?></label></div>
	                        <div class="register-label"><input type="password" name="password" id="register-password" class="register-text" size="25" value="" /></div>
	                        <div class="register-label"><label for="register-password2"><?php echo $lang->loc['confirm.password']; ?></label></div>
	                        <div class="register-label"><input type="password" name="retypedPassword" id="register-password2" class="register-text" size="25" value="" /></div>
                        </fieldset>
                        <div id="password-error-box"></div>

				<?php if(isset($error['dob'])){ ?>
	                    <div class="register-error">
	                    	<div class="rounded rounded-red">
                            	<div id="birthday-error-content">
	                         	   <div><?php echo $error['dob']; ?></div>
	                        	</div>
	                        </div>
	                    </div>
				<?php } ?>


                        <fieldset>
	                        <div class="register-label"><label><?php echo $lang->loc['dob']; ?></label></div>
							<?php $months = explode("|", $lang->loc['list.months']); ?>
	                        <div id="register-birthday"><select name="bean.day" id="bean_day" class="dateselector"><option value=""><?php echo $lang->loc['day']; ?></option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select> <select name="bean.month" id="bean_month" class="dateselector"><option value=""><?php echo $lang->loc['month']; ?></option><option value="1"><?php echo $months[0]; ?></option><option value="2"><?php echo $months[1]; ?></option><option value="3"><?php echo $months[2]; ?></option><option value="4"><?php echo $months[3]; ?></option><option value="5"><?php echo $months[4]; ?></option><option value="6"><?php echo $months[5]; ?></option><option value="7"><?php echo $months[6]; ?></option><option value="8"><?php echo $months[7]; ?></option><option value="9"><?php echo $months[8]; ?></option><option value="10"><?php echo $months[9]; ?></option><option value="11"><?php echo $months[10]; ?></option><option value="12"><?php echo $months[11]; ?></option></select> <select name="bean.year" id="bean_year" class="dateselector"><option value=""><?php echo $lang->loc['year']; ?></option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option><option value="1904">1904</option><option value="1903">1903</option><option value="1902">1902</option><option value="1901">1901</option><option value="1900">1900</option></select> </div>
                        </fieldset>

                        <div id="email-error-box">
				<?php if(isset($error['mail'])){ ?>
	                        <div class="register-error">
	                            <div class="rounded rounded-red">
                                    <div id="email-error-content">
	                                    <div><?php echo $error['mail']; ?></div>
	                                </div>
	                            </div>
	                        </div>
				<?php } ?>
                        </div>


                        <fieldset>
	                        <div class="register-label"><label for="register-email"><?php echo $lang->loc['email']; ?></label></div>
	                        <div class="register-label"><input type="text" name="bean.email" id="register-email" class="register-text" value="<?php echo $input->HoloText($email); ?>" size="25" maxlength="48" /></div>
	                        <div class="register-label"><label for="register-email2"><?php echo $lang->loc['confirm.email']; ?></label></div>
	                        <div class="register-label"><input type="text" name="bean.retypedEmail" id="register-email2" class="register-text" value="" size="25" maxlength="48" /></div>
                        </fieldset>

	                    <div id="register-marketing-box">
		                    <input type="checkbox" name="bean.marketing" id="bean_marketing" value="true" checked="checked" />
		                    <label for="bean_marketing"><?php echo $lang->loc['marketing']; ?></label>
	                    </div>                  


                        <fieldset id="register-fieldset-captcha">
							<noscript>
	                            <div class="register-label"><img src="<?php echo PATH; ?>/captcha.jpg" /></div>
	                            <div class="register-label"><label for="register-captcha"><?php echo $lang->loc['type.in.code']; ?></label></div>
	                            <div id="captcha_response"><input type="text" name="bean.captchaResponse" id="recaptcha_response_field" class="register-text" value="" size="25" /></div>
							</noscript>
						</fieldset>

                        <div id="terms-error-box">
				<?php if(isset($error['tos'])){ ?>
                            <div class="register-error">
                                <div class="rounded rounded-red">
                                    <?php echo $lang->loc['error.14']; ?>
                                </div>
                            </div>
				<?php } ?>
                        </div>
                        <fieldset id="register-fieldset-terms">
                            <div class="rounded rounded-darkgray" id="register-terms">
	                            <div id="register-terms-content">
	                                <p><a href="<?php echo PATH; ?>/papers/disclaimer" target="_blank" id="register-terms-link"><?php echo $lang->loc['terms']; ?></a></p>
                                    <p class="last">
                                        <input type="checkbox" name="bean.termsOfServiceSelection" id="register-terms-check" value="true" />
                                        <label for="register-terms-check"><?php echo $lang->loc['i.agree']; ?></label>
                                    </p>
                                </div>
                            </div>
                        </fieldset>
		            </div>
	            </div>
	            <div id="form-validation-error-box" style="display:none">
                    <div class="register-error">
                        <div class="rounded rounded-red">
                            <?php echo $lang->loc['failure']; ?>
                        </div>
                    </div>
	            </div>
	        </div>


        </div>
<?php }else{ ?>
        <div id="register-column-left" >
            <div id="register-section-2">
                <div class="rounded rounded-blue">
                    <h2 class="heading"><span class="numbering white">2.</span><?php echo $lang->loc['choose.name']; ?></h2>

                    <fieldset id="register-fieldset-name">

	                    <div class="register-label white"><?php echo $lang->loc['habbo.name']; ?></div>
	                    <div class="register-input"><?php echo $input->HoloText($name); ?></div>
                    </fieldset>

                </div>
            </div>

            <div id="register-section-3">
				<div id="registration-overlay"></div>
	            <div class="cbb clearfix gray">
    	            <h2 class="title heading"><span class="numbering white">3.</span><?php echo $lang->loc['your.details']; ?></h2>
    		        <div class="box-content">


                        <fieldset id="register-fieldset-password">
	                        <div class="register-label"><label for="register-password"><?php echo $lang->loc['password']; ?></label></div>
	                        <div class="register-input">*******</div>

                        </fieldset>

                        <fieldset>
	                        <div class="register-label"><label><?php echo $lang->loc['dob']; ?></label></div>
	                        <div class="register-input"><?php echo $input->HoloText($month); ?>/<?php echo $input->HoloText($day); ?>/<?php echo $input->HoloText($year); ?></div>
	                    </fieldset>

                        <div id="email-error-box">
                        </div>

                        <fieldset>
	                        <div class="register-label"><label for="register-email"><?php echo $lang->loc['email']; ?></label></div>
	                        <div class="register-input"><?php echo $input->HoloText($email); ?></div>
	                    </fieldset>

	                    <div id="register-marketing-box">
		                    <input type="checkbox" name="bean.marketing" id="bean_marketing" value="true" checked="checked" />
		                    <label for="bean_marketing"><?php echo $lang->loc['marketing']; ?></label>

	                    </div>


                        <fieldset id="register-fieldset-captcha">

                                <div class="register-label"><img id="captcha" src="<?php echo PATH; ?>/captcha.jpg?t=<?php echo time(); ?>&register=1" alt="" width="200" height="60" /></div>
                                <div class="register-label" id="captcha-reload">
                                    <img src="<?php echo PATH; ?>/web-gallery/v2/images/shared_icons/reload_icon.gif" width="15" height="15"/>
                                    <a href="#"><?php echo $lang->loc['cannot.read.capcha']; ?></a>
                                </div>

	                            <div id="captcha-error-box"><div class="register-error"><div class="rounded rounded-red"><?php echo $lang->loc['error.1']; ?></div></div></div>
	                            <div class="register-label"><label for="register-captcha"><?php echo $lang->loc['type.in.code']; ?></label></div>
	                            <div id="captcha_response"><input type="text" name="bean.captchaResponse" id="recaptcha_response_field" class="register-text error" value="" size="25" /></div>
        <script type="text/javascript">
        document.observe("dom:loaded", function() {
            Event.observe($("captcha-reload"), "click", function(e) {Utils.reloadCaptcha()});
        });
        </script>
                        </fieldset>

                        <div id="terms-error-box">
                        </div>

                        <fieldset id="register-fieldset-terms">
                            <div class="rounded rounded-darkgray" id="register-terms">
	                            <div id="register-terms-content">
	                                <p><a href="<?php echo PATH; ?>/papers/termsAndConditions" target="_blank" id="register-terms-link"><?php echo $lang->loc['terms']; ?></a></p>
                                    <p class="last">
                                        <input type="checkbox" name="bean.termsOfServiceSelection" id="register-terms-check" value="true"  checked="checked"/>
                                        <label for="register-terms-check"><?php echo $lang->loc['i.agree']; ?></label>

                                    </p>
                                </div>
                            </div>
                        </fieldset>
		            </div>
	            </div>
	            <div id="form-validation-error-box" style="display:none">
                    <div class="register-error">
                        <div class="rounded rounded-red">

                            <?php echo $lang->loc['failure']; ?>
                        </div>
                    </div>
	            </div>
	        </div>


        </div>
<?php } ?>
        <div id="register-column-right">

            <div id="register-avatar-editor-title">

                <h2 class="heading"><span class="numbering white">1.</span><?php echo $lang->loc['create.habbo']; ?></h2>
            </div>

            <div id="avatar-error-box">
            </div>
            <div id="register-avatar-editor">
                <p><b><?php echo $lang->loc['no.flash.chooser']; ?></b></p>
                <h3><?php echo $lang->loc['girls']; ?></h3>
				<?php $generator = new HoloFigureCheck(); ?>
                <div class="register-avatars clearfix">
					<?php $figure = $generator->generateFigure(false,"F"); ?>
	                <div class="register-avatar" style="background-image: url(<?php echo $user->avatarURL($figure[0],"b,4,4,sml,1,0"); ?>)">
	                    <input type="radio" name="randomFigure" value="F-<?php echo $figure[0]; ?>" />
	                </div>
					<?php $figure = $generator->generateFigure(false,"F"); ?>
	                <div class="register-avatar" style="background-image: url(<?php echo $user->avatarURL($figure[0],"b,4,4,sml,1,0"); ?>)">
	                    <input type="radio" name="randomFigure" value="F-<?php echo $figure[0]; ?>" />
	                </div>
					<?php $figure = $generator->generateFigure(false,"F"); ?>
	                <div class="register-avatar" style="background-image: url(<?php echo $user->avatarURL($figure[0],"b,4,4,sml,1,0"); ?>)">
	                    <input type="radio" name="randomFigure" value="F-<?php echo $figure[0]; ?>" />
	                </div>
                </div>
                <h3><?php echo $lang->loc['boys']; ?></h3>
                <div class="register-avatars clearfix">
					<?php $figure = $generator->generateFigure(false,"M"); ?>
	                <div class="register-avatar" style="background-image: url(<?php echo $user->avatarURL($figure[0],"b,4,4,sml,1,0"); ?>)">
	                    <input type="radio" name="randomFigure" value="M-<?php echo $figure[0]; ?>" />
	                </div>
					<?php $figure = $generator->generateFigure(false,"M"); ?>
	                <div class="register-avatar" style="background-image: url(<?php echo $user->avatarURL($figure[0],"b,4,4,sml,1,0"); ?>)">
	                    <input type="radio" name="randomFigure" value="M-<?php echo $figure[0]; ?>" />
	                </div>
					<?php $figure = $generator->generateFigure(false,"M"); ?>
	                <div class="register-avatar" style="background-image: url(<?php echo $user->avatarURL($figure[0],"b,4,4,sml,1,0"); ?>)">
	                    <input type="radio" name="randomFigure" value="M-<?php echo $figure[0]; ?>" />
	                </div>
	            </div>
                <p><?php echo $lang->loc['dislike']; ?></p>
            </div>

            <div id="register-buttons">
                <input type="submit" value="<?php echo $lang->loc['continue']; ?>" class="continue" id="register-button-continue" />
                <a href="<?php echo PATH; ?>/register/cancel" class="cancel"><?php echo $lang->loc['exit.register']; ?></a>
            </div>
	    </div>
    </form>
	
						
							
					
				</div>
				<script type="text/javascript">if (!$(document.body).hasClassName('process-template')) { Rounder.init(); }</script>

			 

</div>
<?php

require('./templates/login_footer.php');

?>
