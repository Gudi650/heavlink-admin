        
        <?php
        // Fetch the total number of new demos from the database
        if (isset($_SESSION['totaldemos'])) {
            $totalRows =$_SESSION['totaldemos'];
        }
            
        ?>

        <!-- Side Navigation -->
        <nav class="mt-0 pt-0">
            <ul id="sidebar" class="fixed bg-[#1E9E9E] w-20 h-screen p-4 text-white z-50 transition-all duration-300 ease-in-out">

                <!-- User info and toggle button -->
                <div id="headerContainer" class="flex items-center justify-center">
                    <h3 id="userInfo" class="text-sm hidden">
                        Welcome Back<br>
                        Administrator
                    </h3>
                    <!-- Hamburger menu toggle button -->
                    <span id="toggleBtn" class="cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </span>
                </div>
                <hr class="mb-4 mt-2">
                
                <!-- Navigation Links -->
                <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
                <li class="mb-4 pl-3 py-3 transition-colors duration-200 <?php echo ($currentPage == 'index.php') ? 'bg-white text-[#1E9E9E] rounded' : 'hover:bg-white hover:text-[#1E9E9E] hover:rounded'; ?>">
                    <a href="index.php" class="flex items-center <?php echo ($currentPage == 'index.php') ? 'text-[#1E9E9E]' : 'text-white hover:text-[#1E9E9E]'; ?>">
                        <span class="inline-block mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                            </svg>
                        </span>
                        <span id="dashboardLabel" class="hidden">Dashboard</span>
                    </a>
                </li>

                <li class="mb-4 pl-3 py-3 transition-colors duration-200 <?php echo ($currentPage == 'user.php') ? 'bg-white text-[#1E9E9E] rounded' : 'hover:bg-white hover:text-[#1E9E9E] hover:rounded'; ?>">
                    <a href="user.php" class="flex items-center <?php echo ($currentPage == 'user.php') ? 'text-[#1E9E9E]' : 'text-white hover:text-[#1E9E9E]'; ?>">
                        <span class="inline-block mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </span>
                        <span id="usersLabel" class="hidden">Chruches</span>
                    </a>
                </li>

                <li class="mb-4 pl-3 py-3 transition-colors duration-200 <?php echo ($currentPage == 'Finances.php') ? 'bg-white text-[#1E9E9E] rounded' : 'hover:bg-white hover:text-[#1E9E9E] hover:rounded'; ?>">
                    <a href="Finances.php" class="flex items-center <?php echo ($currentPage == 'Finances.php') ? 'text-[#1E9E9E]' : 'text-white hover:text-[#1E9E9E]'; ?>">
                        <span class="inline-block mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>
                        </span>
                        <span id="financesLabel" class="hidden">Finances</span>
                    </a>
                </li>

                

                <li class=" hidden mb-4 pl-3 py-3 transition-colors duration-200 <?php echo ($currentPage == 'Notification.php') ? 'bg-white text-[#1E9E9E] rounded' : 'hover:bg-white hover:text-[#1E9E9E] hover:rounded'; ?>">
                    <a href="Notification.php" class="flex items-center <?php echo ($currentPage == 'Notification.php') ? 'text-[#1E9E9E]' : 'text-white hover:text-[#1E9E9E]'; ?>">
                        <span class="inline-block mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
  </svg>
                        </span>
                        <span id="notificationLabel" class="hidden">Notification</span>
                    </a>
                </li>

                <li class="mb-4 pl-3 py-3 transition-colors duration-200 <?php echo ($currentPage == 'demo.php') ? 'bg-white text-[#1E9E9E] rounded' : 'hover:bg-white hover:text-[#1E9E9E] hover:rounded'; ?>">
                    <a href="demo.php" class="flex items-center <?php echo ($currentPage == 'demo.php') ? 'text-[#1E9E9E]' : 'text-white hover:text-[#1E9E9E]'; ?>">
                        <span class="inline-block mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
      </svg>
                        </span>
                        <span id="demosLabel" class="hidden">
                            Demos
                            <span class = "text-white bg-red-500 px-1 rounded-xl ml-16">
                                <?php
                                if(!empty($totalRows)){
                                    echo $totalRows;
                                }else{
                                    echo "0";
                                }
                                ?>
                                
                            </span>
                        </span>
                    </a>
                </li>

                <li class="hidden mb-4 pl-3 py-3 transition-colors duration-200 <?php echo ($currentPage == 'report.php') ? 'bg-white text-[#1E9E9E] rounded' : 'hover:bg-white hover:text-[#1E9E9E] hover:rounded'; ?>">
                    <a href="report.php" class="flex items-center <?php echo ($currentPage == 'report.php') ? 'text-[#1E9E9E]' : 'text-white hover:text-[#1E9E9E]'; ?>">
                        <span class="inline-block mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
  </svg>
                        </span>
                        <span id="reportLabel" class="hidden">report</span>
                    </a>
                </li>

                <li class="mb-4 pl-3 py-3 transition-colors duration-200 <?php echo ($currentPage == 'Settings.php') ? 'bg-white text-[#1E9E9E] rounded' : 'hover:bg-white hover:text-[#1E9E9E] hover:rounded'; ?>">
                    <a href="Settings.php" class="flex items-center <?php echo ($currentPage == 'Settings.php') ? 'text-[#1E9E9E]' : 'text-white hover:text-[#1E9E9E]'; ?>">
                        <span class="inline-block mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
      </svg>
                        </span>
                        <span id="settingsLabel" class="hidden">Settings</span>
                    </a>
                </li>

                <!-- Log Out Button (server-side logout via POST) -->
                <li class="mb-4 pl-3 py-3 hover:bg-white hover:text-[#1E9E9E] hover:rounded transition-colors duration-200 min-h-[44px] flex items-center">
                    <form action="backend-config-file/logout.inc.php" method="post" class="w-full m-0 p-0">
                        <button type="submit" class="flex items-center w-full bg-transparent border-none outline-none cursor-pointer text-white hover:text-[#1E9E9E] text-sm">
                            <span class="inline-block mr-2 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                </svg>
                            </span>
                            <span id="logoutLabel" class="hidden whitespace-nowrap">Log Out</span>
                        </button>
                    </form>
                </li>
        </ul>
    </nav>

        <!-- Main content area (for demonstration) -->
        <div class="flex-1 ml-20 transition-all duration-300 ease-in-out w-100" id="mainContent">
            
        

            <!-- Topbar Section included from topside.php -->
            <?php include __DIR__ . '/topside.php'; ?>

                        <!-- Main Content Area -->
                        <div class="p-8">
                            <?php
                            if (isset($mainContentFile)) {
                                    include $mainContentFile;
                            } else {
                                    echo "<p>Welcome to the dashboard.</p>";
                            }
                            ?>
                        </div>
        </div>

    <script>
        // ===========================================
        // SIDEBAR TOGGLE FUNCTIONALITY
        // ===========================================
        
        // State management for sidebar
        let isOpen = false;
        
        // DOM element references
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');
        const userInfo = document.getElementById('userInfo');
        const logoutBtn = document.getElementById('logoutBtn');
        const mainContent = document.getElementById('mainContent');
        const headerContainer = document.getElementById('headerContainer');
        
        // Get all label elements
        const labels = [
            'dashboardLabel', 'usersLabel', 'financesLabel', 'systemLabel', 
            'notificationLabel', 'demosLabel', 'reportLabel', 'settingsLabel', 'logoutLabel'
        ];
        
        // Toggle sidebar functionality
        const toggleSidebar = () => {
            isOpen = !isOpen;
            
            if (isOpen) {
                // Expand sidebar - show labels and user info
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-60'); // Reduced from w-80 to w-60 (240px) for better proportions
                mainContent.classList.remove('ml-20');
                mainContent.classList.add('ml-60');
                headerContainer.classList.remove('justify-center');
                headerContainer.classList.add('justify-between');
                userInfo.classList.remove('hidden');
                userInfo.classList.add('block');
                
                // Notify top navigation about sidebar state
                window.postMessage({ type: 'sidebarToggle', isOpen: true }, '*');
                
                // Show all labels
                labels.forEach(labelId => {
                    const label = document.getElementById(labelId);
                    if (label) {
                        label.classList.remove('hidden');
                        label.classList.add('block');
                    }
                });
                
                // Update padding for expanded state and remove centering
                const listItems = sidebar.querySelectorAll('li');
                listItems.forEach(item => {
                    item.classList.remove('pl-3', 'flex', 'justify-center');
                    item.classList.add('pl-5');
                });
                
            } else {
                // Collapse sidebar - hide labels and user info
                sidebar.classList.remove('w-60');
                sidebar.classList.add('w-20');
                mainContent.classList.remove('ml-60');
                mainContent.classList.add('ml-20');
                headerContainer.classList.remove('justify-between');
                headerContainer.classList.add('justify-center');
                userInfo.classList.remove('block');
                userInfo.classList.add('hidden');
                
                // Notify top navigation about sidebar state
                window.postMessage({ type: 'sidebarToggle', isOpen: false }, '*');
                
                // Hide all labels
                labels.forEach(labelId => {
                    const label = document.getElementById(labelId);
                    if (label) {
                        label.classList.remove('block');
                        label.classList.add('hidden');
                    }
                });
                
                // Update padding for collapsed state and center icons
                const listItems = sidebar.querySelectorAll('li');
                listItems.forEach(item => {
                    item.classList.remove('pl-5');
                    item.classList.add('pl-3', 'flex', 'justify-center');
                });
            }
        };
        
        // ===========================================
        // EVENT LISTENERS
        // ===========================================
        
        // Toggle button click event
        toggleBtn.addEventListener('click', toggleSidebar);
        
        // Logout button functionality
        logoutBtn.addEventListener('click', () => {
            // Clear session and local storage
            sessionStorage.clear();
            localStorage.clear();
            
            // Show logout confirmation (you can replace this with actual logout logic)
            alert('Logged out successfully! Session and local storage cleared.');
            
            // Optional: Redirect to login page
            // window.location.href = '/login.html';
        });
        
        // ===========================================
        // ACTIVE LINK HIGHLIGHTING
        // ===========================================
        
        
        
        // Highlight active link on page load and center icons initially
        window.addEventListener('load', () => {
            highlightActiveLink();
            // Center icons on initial load (sidebar starts collapsed)
            const listItems = sidebar.querySelectorAll('li');
            listItems.forEach(item => {
                item.classList.add('flex', 'justify-center');
            });
        });
        
        // ===========================================
        // HOVER EFFECTS
        // ===========================================
        
        // Add hover effects to all navigation items
        const navItems = sidebar.querySelectorAll('li');
        navItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                if (!item.classList.contains('bg-white')) {
                    item.classList.add('bg-white', 'text-[#1E9E9E]', 'rounded');
                    const link = item.querySelector('a, button');
                    if (link) {
                        link.classList.add('text-[#1E9E9E]');
                    }
                }
            });
            
            item.addEventListener('mouseleave', () => {
                // Only remove hover effects if not the active item
                if (!item.classList.contains('text-[#1E9E9E]') || 
                    (!item.querySelector('a[href="' + window.location.pathname + '"]') && 
                     !(window.location.pathname === '/' && item.querySelector('a[href="/"]')))) {
                    item.classList.remove('bg-white', 'text-[#1E9E9E]', 'rounded');
                    const link = item.querySelector('a, button');
                    if (link) {
                        link.classList.remove('text-[#1E9E9E]');
                    }
                }
            });
        });
    </script>
