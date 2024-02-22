$(document).ready(function (e) {
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        
    })()
    
    $("#loginBtn").click(function (e) { 
        window.location.href= "../login/login.php"
    });    

    $("#submitBtn").click(function (e) {
        
        // alert();
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                
                if($("#pwd").val()==$("#pwd2").val()){
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }else{
                        // alert('success');
                    //$("#registerForm").submit();
                    }
                }else{
                    alert('password not match');
                    e.stopPropagation();
                    e.preventDefault();
                }
                form.classList.add('was-validated')
            })
        
        
    });

    
});