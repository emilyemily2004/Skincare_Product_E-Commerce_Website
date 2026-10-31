document.addEventListener("DOMContentLoaded", function() {
    const editBtn = document.getElementById("editProfileBtn");
    const saveBtn = document.getElementById("saveBtn");
    const form = document.getElementById("profileForm");
    const inputs = form.querySelectorAll("input");

    let isEditing = false;

    editBtn.addEventListener("click", function(e) {
        e.preventDefault();
        if (!isEditing) {
            // Enable editing
            isEditing = true;
            inputs.forEach(i => i.disabled = false);
            saveBtn.style.display = "inline-block";
            editBtn.textContent = "Cancel";
        } else {
            // Cancel edit
            isEditing = false;
            inputs.forEach(i => i.disabled = true);
            saveBtn.style.display = "none";
            editBtn.textContent = "Edit Profile";
        }
    });

    form.addEventListener("submit", function(e) {
        e.preventDefault();

        // Collect data
        const username = document.getElementById("username").value;
        const email    = document.getElementById("email").value;
        const phone    = document.getElementById("phone").value;

        // AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "updateProfile.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText === "success") {
                    alert("Profile updated successfully!");
                    location.reload(); // refresh to show new values
                } else {
                    alert("Error: " + xhr.responseText);
                }
            }
        };

        const params = "username=" + encodeURIComponent(username) +
                       "&email=" + encodeURIComponent(email) +
                       "&phone=" + encodeURIComponent(phone);
        xhr.send(params);
    });
});