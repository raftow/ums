<div class="home_banner">
    <div class="modal-dialog verify popup-company banner">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class='title_register'>الرجاء إدخال الرمز</h2>
            </div>
            [otp_verify_msg_s]
                <div class="quote">
                    <div class="quoteinn">
                        <p class='login_war'>[otp_verify_msg][otp_verify_the_message]</p>
                    </div>
                </div>
            [otp_verify_msg_s]
            <div class="modal-body">


                <div class="form-group center-me">

                    <label class='light_label'>الرجاء إدخال الرمز الذي تم إرساله إلى [otp_destination] <!-- [otp_info_export] -->
                    </label>
                    <form id="form_register" name="form_register" method="post" class="digit-group" direction="ltr" action="login.php" data-group-name="digits" data-autosubmit="true" autocomplete="off" dir="rtl" enctype="multipart/form-data">

                        <div class='otp-digits-div'>
                            <div class='otp-digits-input'>
                                <input type="number" class="form-control otp-digits" id="otp_verify_code" name="otp_verify_code" value="" tabindex=0 autocomplete="off" required autofocus>
                            </div>
                        </div>
                        <input type="hidden" name="user_name_logged_in" value="[user_name_logged_in]">
                        <input type="hidden" name="user_id_logged_in" value="[user_id_logged_in]">
                        <input type="submit" class="btnbtsp btn-primary btncheck" value="تحقق" name="otp_verify_go">&nbsp;
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>