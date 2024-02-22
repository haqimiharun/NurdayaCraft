$(document).ready(function () {

    $("#dropDown").on('change', function() {
        if(this.value=='logout'){
            $.ajax({
                type: "POST",
                url: "bgprocess.php",
                data: {
                    action_flag:'logout'
                },
            });
        }
    });

    
});