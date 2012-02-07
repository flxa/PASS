<?php
	$html .= '<fieldset><form action="index.php" method="POST">';
	$html .= '<input type="hidden" name="m" value="users">';
	$html .= '<input type="hidden" name="v" value="users">';
	$html .= '<input type="hidden" name="c" value="users">';
	$html .= '<input type="hidden" name="task" value="dologin">';
	$html .= '<div class="alert-message info">
		  <p><strong>Welcome to PASS.</strong><br>
		  Please enter your Username and Password to login to the system!</p>
		</div>';
	$html .= '<div class="input">
			<div class="input-append">
				<input type="text" name="user" value="'; if ($_COOKIE['pass_username']!='') { $html .= $_COOKIE['pass_username']; } $html .= '" placeholder="Username" class="medium" />
				<span class="add-on">@printnational.com.au</span> 
			</div>
		</div><br><br><br>';
	$html .= '<div class="input">
			<div class="input-append">
				<input type="password" name="pass" value="" placeholder="password" class="medium" size="12" />
				<span class="add-on">6-12 Characters</span> 
			</div>
		</div><br><br><br>';
	$html .= '<div class="input">
			<div class="input-append">
				<input type="submit" name="login" value="Login" class="btn primary" />
				<span class="add-on"><input type="checkbox" name="remember" value="1"'; if ($data->remember==1 || $_COOKIE['pass_username']!='') { $html .= ' checked'; } $html .= '>&nbsp;Remember Username?</span>
			</div>
		</div><br><br><br>';
	$html .= '<div class="alert-message warning">
				<p><strong>Forget Something?</strong><br>
				<a href="#" class="btn small">Forgot Username?</a>
				<a href="#" class="btn small">Forgot Password?</a>
				</p>
			</div>';
	$html .= '</form></fieldset>';		
?>