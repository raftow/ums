<link href="../ums/css/simple_login_tpl.css" rel="stylesheet" type="text/css">
    <div class="main">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <!-- <div class="signin-header">جامعة نايف العربية للعلوم الأمنية</div> -->
                <div class="signin-content">
                    <div class="signin-image">
                        <a href="#" class="signup-image-link">[site_name]</a>
                        <figure><img src="../client-[company]/pic/login-picture.png" alt="sing up image"></figure>                        
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">تسجيل دخول [admin_account_jobs]</h2>
                        <form method="POST" class="register-form" id="login-form" action="<? echo $action_page ?>" onSubmit="return checkForm();" dir="ltr" enctype="multipart/form-data" autocomplete="off">
                            [companies_s]
                            <div class="form-group">
                                <label for="company"><i class="zmdi zmdi-layers"></i></label>
                                <select name="company" id="company">
                                    [companies_options]
                                </select>
                            </div>
                            [companies_e]
                            <div class="form-group">
                                <label for="mail"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="mail" id="mail" placeholder="[login_by]"/>
                            </div>
                            <div class="form-group">
                                <label for="pwd"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pwd" id="pwd" placeholder="[password_label]"/>
                            </div>                            
                            <div class="form-group form-button">
                                <input type="submit" id="signin" class="form-submit" value="[login_label]" name="loginGo"/>
                            </div>
                        </form>
                        
                        <!--<div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>-->
                    </div>
                </div>
            </div>
        </section>

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