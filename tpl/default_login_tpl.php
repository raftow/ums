<div class="home_banner login_banner">
<div class="modal-dialog popup-login">
        <div class="modal_login modal-content">
                <div class="modal-header">
                        <div>
                                <a href="index.php" title="الرئيسسة">
                                        <img src="../[module]/pic/logo.png" alt="[login_by_sentence]" title="[login_by_sentence]"></a>
                                        
                                <h2 class='title_login'>[login_title]</h2>        
                        </div>
                </div>
                [no_message_s]
                <div class="quote">
                    <div class="quoteinn">
                        <p><font color='red'>[message]</font></p>
                    </div>
                </div>
                [no_message_e]
                <div class="modal-body"><h1>[login_by_gentle_sentence]</h1><br>
                        <form id="formlogin0" name="formlogin0" method="post" action="<?echo $action_page?>"  onSubmit="return checkForm();" dir="rtl" enctype="multipart/form-data">
                                <div class="form-group">
                                        <label>[login_by]
                                        </label>
                                        <input class="form-control" type="text" name="mail" value="<?php echo $user_name_c?>" required>
                                </div>
                                <div class="form-group">
                                        <label>[password_label]
                                        </label>
                                        <input type="password" class="form-control" name="pwd" value=""  autocomplete="off" required>                                        
                                </div>
                                <!-- [logbl] -->
                                <div class="form-group submit-login">
                                    <input type="submit" class="btnblogin btnbtsp btn-primary" value="[login_label]" name="loginGo">&nbsp;
                                </div>
                                [password_reminder_s]
                                <a class="btn-default password_reminder" href="pwd_reset.php">[password_reminder_label]</a>
                                [password_reminder_e]
                        </form>
                </div>
                
                [customer_login_s]
                <div class="modal-footer">
                        <div class="login-register">
                            <a class="btnbtsp btn_link" href="[customer_code]_login.php">[customer_login_title]</a>
                        </div>
                </div>
                [customer_login_e]
                [customer_register_s]
                <div class="modal-footer">
                        <div class="login-register">
                            <a class="btnbregister btnbtsp btn_link" href="[register_code]_register.php">[register_title]</a>
                        </div>
                </div>
                [customer_register_e]
        </div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
	document.getElementById("mail").focus();
});

function checkForm() 
{
	if($("#mail").val() == "" || ($("#pwd").val() == "")) {
		alert("[login_data_incomplete]");
		return false;
	} else {
		return true;
	}
}
</script>
<!-- log : [login_debugg_imploded_securized] -->
