
function populateUpdateModal(id, vehicleNumPlate, violation, datetime, location) {
    document.getElementById('update_summon_id').value = id;
    document.getElementById('update_vehicleNumPlate').value = vehicleNumPlate;
    document.getElementById('update_violation').value = violation;
    document.getElementById('update_datetime').value = datetime;
    document.getElementById('update_location').value = location;

    document.getElementById('updateModalTitle').innerText = 'Update Summon ' + id;
}

function confirmDelete(summon_ID, veh_numPlate) {
    if (confirm("Are you sure you want to delete this summon?")) {
        window.location.href = 'deleteSummons_data.php?summon_ID=' + summon_ID + '&vehicle_numPlate=' + veh_numPlate;
    }
}


function validateVehicleNumPlate(formID) {
    // Get the vehicle number plate entered by the user
    var vehicleNumPlate = document.getElementById("vehicleNumPlate").value;

    // Send an AJAX request to the server to check if the vehicle number plate exists
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "checkNumPlate.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            // If the vehicle number plate exists, allow form submission
            if (xhr.responseText === "exists") {
                // Form submission will be triggered here
                document.getElementById(formID).submit();
            }else
            {
                alert("The vehicle number plate is not within the Vehicle table.");
                // Do not submit the form
                return false;
            }
        }
    };
    // Send the request with the vehicle number plate data
    xhr.send("vehicleNumPlate=" + encodeURIComponent(vehicleNumPlate));

    // Prevent the form from submitting automatically
    return false;
}
