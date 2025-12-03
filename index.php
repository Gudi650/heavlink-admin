<?php
// start session as early as possible (no output before this)
require_once __DIR__ . '/includes/session_config.inc.php';

if (!empty($_SESSION['login_errors'])) {
    echo '<div class="text-red-500 mb-3">';
    foreach ($_SESSION['login_errors'] as $error) {
        echo htmlspecialchars($error) . '<br>';
    }
    echo '</div>';
    unset($_SESSION['login_errors']);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 CDN for beautiful alerts and notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Main container with background image and full screen layout -->
    <div
        style="background-image: url('/pngwing.com.png'); background-size: cover; background-position: center;"
        class="flex justify-center items-center h-screen fixed inset-0 min-h-screen w-full bg-gray-200"
    >
        <!-- Login form container with teal background and opacity -->

        <form id="loginForm"
        class="bg-[#1E9E9E] flex justify-center items-center flex-col w-96 mx-5 mt-5 py-5 rounded opacity-75"
        action="./backend-config-file/login.inc.php"
        method="post"
        >
            <!-- Login title with white background -->
            <h2 class="bg-white text-black px-4 py-1 rounded-lg text-xl mb-7">Login</h2>
            

            
            <!-- Email input field with user icon -->
            <div class="flex items-center bg-white h-11 w-80 rounded-full px-4 mb-7">
                <input 
                    type="text" 
                    id="email"
                    name="email"
                    placeholder="Email" 
                    required 
                    class="flex-grow bg-transparent outline-none pl-1" 
                />
                <!-- User icon SVG -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 text-gray-500"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
                    />
                </svg>
            </div>
            
            <!-- Password input field with lock icon and toggle functionality -->
            <div class="flex items-center bg-white h-11 w-80 rounded-full px-4 mb-3">
                <input 
                    type="password" 
                    id="password"
                    name="password"
                    required 
                    placeholder="Password" 
                    class="flex-grow bg-transparent outline-none pl-1" 
                />
                <!-- Lock icon SVG with click handler for password visibility toggle -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 text-gray-500 cursor-pointer"
                    id="togglePassword"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
                    />
                </svg>
            </div>

            <!-- Remember me checkbox and forgot password link section -->
            <div class="flex items-center justify-between w-80 text-sm mb-5">
                <!-- Remember me checkbox -->
                <label class="flex items-center space-x-2">
                    <input
                        type="checkbox"
                        id="rememberMe"
                        class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500"
                    />
                    <span class="text-black">Remember Me</span>
                </label>

                <!-- Forgot password link -->
                <a href="#" class="text-black font-semibold hover:underline">
                    Forgot Password
                </a>
            </div>

            <!-- Login submit button with same width as input fields -->
            <button type="submit" class="bg-white text-black py-2 px-8 rounded-full cursor-pointer mb-7 w-80">Login</button>

            <!-- Sign up section with link to registration -->
            <p class="pb-2">
                Dont have an account?
                <span>
                    <a href="./signup.php" class="text-white ml-2">Sign Up</a>
                </span>
            </p>
        </form>
    </div>

    <script>
        // Track password visibility state
        let showPassword = false;

        // ===========================================
        // DOM ELEMENT REFERENCES
        // ===========================================
        // Get references to all form elements for manipulation
        const loginForm = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const errorMessage = document.getElementById('errorMessage');
        const rememberMeCheckbox = document.getElementById('rememberMe');

        // ===========================================
        // SWEETALERT2 NOTIFICATION FUNCTIONS
        // ===========================================
        
        // Show loading spinner during login process
  const showLoading = () => {
    Swal.fire({
      title: 'Logging in...',
                allowOutsideClick: false, // Prevent closing by clicking outside
      didOpen: () => {
                    Swal.showLoading(); // Display loading spinner
      }
    });
  };

        // Show success notification after successful login
        const showSuccess = (message) => {
    Swal.fire({
      icon: 'success',
      title: 'Success!',
      text: message,
    });
  };

        // Show error notification for login failures
        const showError = (message) => {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: message,
    });
  };
        
        // Password visibility toggle functionality
        togglePasswordBtn.addEventListener('click', () => {
            // Toggle password visibility state
            showPassword = !showPassword;
            // Change input type between 'password' and 'text'
            passwordInput.type = showPassword ? 'text' : 'password';
        });

       

        // Remember me checkbox functionality using localStorage
        rememberMeCheckbox.addEventListener('change', (e) => {
            if (e.target.checked) {
                // Save remember me preference to localStorage
                localStorage.setItem('rememberMe', 'true');
            } else {
                // Remove remember me preference from localStorage
                localStorage.removeItem('rememberMe');
            }
        });

        // ===========================================
        // PAGE INITIALIZATION
        // ===========================================
        
        // Load saved preferences when page loads
        window.addEventListener('load', () => {
            // Check if user previously selected "Remember Me"
            if (localStorage.getItem('rememberMe') === 'true') {
                rememberMeCheckbox.checked = true;
                // TODO: You can load saved email/password here if needed
                // Example: emailInput.value = localStorage.getItem('savedEmail');
            }
        });
    </script>
</body>
</html>