function tempAlert(duration)
{    
    document.getElementById("qa_form").onsubmit = function() {displaySuccessMessage()};   
     
    function displaySuccessMessage() {        
        var modal = document.getElementById('success_modal');     
        modal.style.display = "block";
    }   
}

