<div class="home_banner login_banner">
    <div class="modal-dialog popup-login">
        <div class="modal_login modal-content">
            <div class="modal-header">
                <div>
                    <div class="login title_company">
                        <img src="../external/pic/title-company-[company].png" alt="" style="margin-top: 0px;width: 412px !important;height: 86px;border-radius: 0;">
                    </div>
                    <div class="login logo_company">
                        <img src="../external/pic/logo-company-[company].png" alt="" style="margin-right: 0;margin-left: 0;margin-top: 0px;width: 86px !important;height: 86px;border-radius: 0;">
                    </div>
                </div>
                <!--<div>
                    <a href="index.php" title="الرئيسسة">
                        <img src="../[module]/pic/logo.png" alt="[login_by_sentence]" title="[login_by_sentence]"></a>

                    <h2 class='title_login'>[login_title]</h2>
                </div>-->
            </div>
            [no_message_s]
            <div class="quote">
                <div class="quoteinn">
                    <p>
                        <font color='red'>[message]</font>
                    </p>
                </div>
            </div>
            [no_message_e]
            <h1 class='modal-title'>[site_name]</h1>
            <div class="modal-body">
                <form id="formlogin0" name="formlogin0" class="login default" method="post" action="<? echo $action_page ?>" onSubmit="return checkForm();" dir="ltr" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                        <label class="label login">[login_by]
                        </label>
                        <input class="form-auth login username" spellcheck="false" type="text" name="mail" value="<?php echo $user_name_c ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="label login">[password_label]
                        </label>
                        <input type="password" class="form-auth login pwd" name="pwd" value="" autocomplete="off" required>
                    </div>
                    <!-- [logbl] -->
                    <div class="form-group submit-login">
                        <input type="submit" class="btnblogin btnbtsp btn-primary" value="[login_label]" name="loginGo">&nbsp;
                    </div>
                    <h4>[login_by_gentle_sentence]</h4><br>
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
        $("html, body").animate({
            scrollTop: $(document).height()
        }, "slow");
        document.getElementById("mail").focus();
    });

    function checkForm() {
        if ($("#mail").val() == "" || ($("#pwd").val() == "")) {
            alert("[login_data_incomplete]");
            return false;
        } else {
            return true;
        }
    }
</script>
<!-- log : [login_debugg_imploded_securized] -->