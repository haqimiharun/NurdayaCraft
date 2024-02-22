$(document).ready(function (e) {
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        
    })()
    
    

    $("#checkoutBtn").click(function (e) {
        
        // alert();
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated')
            })
        
        
    });

    
});