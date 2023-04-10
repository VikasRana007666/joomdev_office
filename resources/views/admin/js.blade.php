<script>
    // Generating Strong Password
    const generatePasswordBtn = document.querySelector("#generatePassword");
    generatePasswordBtn.addEventListener("change", () => {
        if (generatePasswordBtn.checked) {
            const newPassword = generateStrongPassword();
            console.log(newPassword);
            document.querySelector("input[name='password']").value = newPassword;
        } else {
            document.querySelector("input[name='password']").value = "";
        }
    });

    function generateStrongPassword() {

        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        for (let i = 0; i < 14; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            result += characters.charAt(randomIndex);
        }
        return result;
    }

    // Hide and Show Password

    const passwordInput = document.querySelector('#password-input');
    const passwordToggle = document.querySelector('#password-toggle');
    passwordToggle.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordToggle.textContent = 'Hide';
        } else {
            passwordInput.type = 'password';
            passwordToggle.textContent = 'Show';
        }
    });
</script>
