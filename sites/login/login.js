$(document).ready(function(e){
    $("#logoutBtn").click(function (e) { 
        logout();
    });
});

$("#submitBtn").click(function (e) {
        
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

function logout(){
    $.ajax({
        type: "POST",
        url: "bgprocess.php",
        data: {
            action_flag:'logout'
        },
    });
}