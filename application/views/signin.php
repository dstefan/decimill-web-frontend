
<style>
    .signin { width: 350px; background-color: #fff; }
    .signin-wrapper { padding: 32px 30px 25px; }
    .signin-input { display: block; box-sizing: border-box; width: 100%; margin-bottom: 8px; font-size: 16px; padding: 5px; border: solid 1px #e1e2e3; }
    .signin-button { display: block; box-sizing: border-box; width: 100%; margin-top: 9px; padding: 7px; font-size: 14px; font-weight: bold; background-image: url('/application/images/button-bg-blue.png'); border: solid 1px #34679a; border-radius: 2px; box-shadow: 0 0 2px rgba(0, 0, 0, 0.05) inset; color: #fff; }
    .signin-button:hover { background-image: url('/application/images/button-bg-blue-dark.png'); box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2); }
</style>

<script>
    $(function() {

        // Compute margin, offset by 100px to the top
        var signinBlock = $('#signin-block');
        var signinHeight = signinBlock.outerHeight();
        var windowHeight = $(window).height();
        var marginTop = (windowHeight - signinHeight) / 2 - 110;

        // Allow min 70px from the top
        marginTop = Math.max(70, marginTop);

        // Set margin and visibility
        signinBlock.css('margin-top', marginTop + 'px');
        signinBlock.css('visibility', 'visible');
    });
</script>

<div id="signin-block" style="visibility: hidden; width: 350px; margin: 0 auto;">
    
    <div style="width: 350px; text-align: center; margin-bottom: 20px; font-family: 'Roboto Condensed'; font-size: 35px; font-weight: 300;">
        Sign-in to you account.
    </div>
    
    <div class="signin content-block">
        <div class="content-block-wrapper" style="padding: 30px;">
            <form action="/user/login" method="POST">
                <input type="text" class="signin-input" name="email" placeholder="Email" />
                <input type="password" class="signin-input" name="password" placeholder="Password" />
                <input type="submit" class="signin-button" value="Sign in" />
            </form>
            <div class="signin-register-wrapper" style="width: 100%; text-align: right; margin-top: 7px;">
                <a href="/home">Create an account</a>
            </div>
        </div>
    </div>
</div>