<script>
function validateInput(input) {
    // Check if input contains any JavaScript code
    if (input.match(/<\s*script.*?>/i)) {
        // Reject input
        return false;
    }
    // Accept input
    return true;
}

function handleSubmit(event) {
    let form = event.target; // Get the form element
    let inputs = form.querySelectorAll('input'); // Get all input elements within the form
    
    // Loop through each input element and validate its value
    for (let i = 0; i < inputs.length; i++) {
        let input = inputs[i].value;
        
        // If any input contains JavaScript code, prevent form submission and show alert
        if (!validateInput(input)) {
            alert("Input contains JavaScript code and is not allowed.");
            event.preventDefault(); // Prevent form submission
            return;
        }
    }
}
</script>