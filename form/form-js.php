<script src="https://www.google.com/recaptcha/api.js?render=<?=$config['captcha_key']?>"></script>
<script>
    var contactForm = $('#contactForm');
    function generateCaptchaToken(){
        var grecaptchaInput = contactForm.find("[name=g-recaptcha-response]");
        if(grecaptchaInput.length > 0){
            grecaptchaInput.remove();
        }
        grecaptcha.execute('<?=$config['captcha_key']?>').then(function(token) {
            if (token && token.length > 0) {
                contactForm.prepend('<input type="hidden" name="g-recaptcha-response" class="g-re-response" value="' + token + '">');
            }
        });
    }
    grecaptcha.ready(function() {
        // response is promise with passed token
        generateCaptchaToken();
    });

    contactForm.submit(function(event){
        event.preventDefault();
        var displayMessage =  $("#cf-mess");
        displayMessage.addClass('d-none');

        contactForm.find(".has-error").removeClass('has-error');

        $.ajax({
            url: 'form/form-process.php',
            // url:contactForm.attr('action'),
            type:'POST',
            data:contactForm.serialize(),
            beforeSend: function(){
                // Show image container
                $("#loader").show();
            },
            success:function(result){
                console.log(result)
                if(result.error) {
                    for(var key in result.error){
                        if(!result.error.hasOwnProperty(key)){
                            continue;
                        }
                        $("[name="+key+"]").addClass('has-error'); // add the error class to show red input
                    }
                }
                if(result.success){
                    displayMessage.removeClass('d-none');
                    generateCaptchaToken();
                    contactForm.find(".form-control").val('');
                }
            },
            complete:function(){
                generateCaptchaToken();
            },
            dataType:"json"
        });
        return false;
    });
</script>
