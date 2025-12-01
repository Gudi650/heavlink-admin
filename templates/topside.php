<?php
// Ensure session is available and fetch admin email to display in the topbar
require_once __DIR__ . '/../includes/session_config.inc.php';
require_once __DIR__ . '/../includes/dbh.inc.php';

$userEmail = 'email@gmail.com';
if (!empty($_SESSION['user_id'])) {
    try {
        $stmt = $pdo->prepare('SELECT email FROM admin WHERE id = :id');
        $stmt->execute([':id' => $_SESSION['user_id']]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($admin && !empty($admin['email'])) {
            $userEmail = $admin['email'];
        }
    } catch (Exception $e) {
        // keep default email on error
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Navigation</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <!-- Top Navigation Bar -->
    <div class="flex items-center border-b border-b-gray-200 w-full justify-between px-4 py-2 gap-4">
        <!-- Dashboard Title -->
        <h1 class="text-[#1E9E9E] text-xl font-bold">Dashboard</h1>

        <!-- Search Input Form -->
        <form action="" class="hidden md:block relative flex-1 max-w-xs">
            <div class="relative">
                <input 
                    type="search" 
                    id="searchInput"
                    placeholder="Search..." 
                    class="w-full h-9 rounded-full border border-[#B5B5B5] bg-[#F0EDED] px-4 pr-10 focus:outline-none focus:ring-2 focus:ring-[#1E9E9E] focus:border-transparent"
                />
                <!-- Search Icon -->
                <img
                    src="https://img.icons8.com/material-sharp/18/B5B5B5/search.png"
                    alt="Search icon"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4"
                />
            </div>
        </form>

        <!-- User Profile Section -->
        <div id="userProfile" class="relative bg-[#1E9E9E] hidden md:flex rounded-full text-white items-center h-12 px-2 pr-3 hover:bg-[#1a8a8a] transition-colors duration-200 cursor-pointer" aria-haspopup="true" aria-expanded="false">
            <!-- User Avatar -->
            <div class="flex-shrink-0">
                <img
                    src="https://img.icons8.com/ios-glyphs/30/user--v1.png"
                    alt="User icon"
                    class="w-10 h-10 bg-[#F0EDED] p-2 rounded-full border-2 border-white"
                />
            </div>
            <!-- User Info -->
            <div class="ml-3 flex-1 min-w-0">

                <h3 class="text-sm font-medium truncate">Administrator</h3>

                <span class="text-xs text-gray-200 truncate block">
                    <?php echo htmlspecialchars($userEmail); ?>
                </span>
            </div>
            <!-- Dropdown Arrow -->
            <div class="flex-shrink-0 ml-2">
                <img
                    src="https://img.icons8.com/ios/50/FFFFFF/expand-arrow--v2.png"
                    alt="DownArrow icon"
                    class="w-4 h-4 cursor-pointer hover:opacity-80 transition-opacity duration-200"
                />
            </div>
            
            <!-- Dropdown menu (hidden by default) -->
            <div id="userDropdown" class="hidden absolute right-0 top-full mt-2 w-52 bg-white text-gray-800 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50 transform origin-top-right transition ease-out duration-150" role="menu" aria-label="User menu">
                <!-- small caret pointing to the profile -->
                <div class="absolute right-4 -top-2 w-4 h-4 bg-white transform rotate-45 shadow-sm" aria-hidden="true"></div>
                <div class="py-1">
                    <button id="editImageBtn" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-3 focus:outline-none focus:bg-gray-100" role="menuitem">
                        <span class="inline-flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full">
                            <!-- camera / edit icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h2l1-2h8l1 2h2a1 1 0 0 1 1 1v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a1 1 0 0 1 1-1z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            </svg>
                        </span>
                        <span class="flex-1">Edit Image</span>
                    </button>
                    <form action="backend-config-file/logout.inc.php" method="post" class="m-0">
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-50 flex items-center gap-3 focus:outline-none focus:bg-gray-100" role="menuitem">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full">
                                <!-- logout icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H3m0 0l4-4m-4 4l4 4" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12v6a2 2 0 0 1-2 2H9" />
                                </svg>
                            </span>
                            <span class="flex-1">Log out</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   

    <script>
        // ===========================================
        // SEARCH FUNCTIONALITY
        // ===========================================
        
        // DOM element references
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const searchQuery = document.getElementById('searchQuery');
        
        // Search handling function
        const handleSearch = (term) => {
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            
            if (term && term.trim() !== '') {
                // Set search parameter
                urlParams.set('search', term);
                // Show search results
                searchResults.classList.remove('hidden');
                searchQuery.textContent = `Searching for: "${term}"`;
            } else {
                // Remove search parameter
                urlParams.delete('search');
                // Hide search results
                searchResults.classList.add('hidden');
            }
            
            // Update URL without page reload
            const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
            window.history.replaceState({}, '', newUrl);
        };
        
        // ===========================================
        // EVENT LISTENERS
        // ===========================================
        
        // Search input event listener
        searchInput.addEventListener('input', (e) => {
            handleSearch(e.target.value);
        });
        
        // ===========================================
        // URL PARAMETER HANDLING
        // ===========================================
        
        // Load search parameter from URL on page load
        window.addEventListener('load', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const searchTerm = urlParams.get('search');
            
            if (searchTerm) {
                searchInput.value = searchTerm;
                searchResults.classList.remove('hidden');
                searchQuery.textContent = `Searching for: "${searchTerm}"`;
            }
        });
        
        // ===========================================
        // RESPONSIVE BEHAVIOR
        // ===========================================
        
        // Handle window resize for responsive behavior
        window.addEventListener('resize', () => {
            // You can add responsive logic here if needed
            // For example, adjusting search input visibility on different screen sizes
        });
        
        // ===========================================
        // USER PROFILE DROPDOWN (Optional Enhancement)
        // ===========================================
        
        // USER PROFILE DROPDOWN
        const userProfile = document.getElementById('userProfile');
        const userDropdown = document.getElementById('userDropdown');
        const editImageBtn = document.getElementById('editImageBtn');

        const openDropdown = () => {
            userDropdown.classList.remove('hidden');
            userProfile.setAttribute('aria-expanded', 'true');
        };

        const closeDropdown = () => {
            userDropdown.classList.add('hidden');
            userProfile.setAttribute('aria-expanded', 'false');
        };

        // Toggle on click
        userProfile.addEventListener('click', (e) => {
            // Prevent the click from closing immediately when clicking inside
            e.stopPropagation();
            if (userDropdown.classList.contains('hidden')) {
                openDropdown();
            } else {
                closeDropdown();
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!userProfile.contains(e.target)) {
                closeDropdown();
            }
        });

        // Close on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeDropdown();
        });

        // EDIT IMAGE modal (simple inline modal)
        const modalHtml = `
            <div id="editImageModal" class="fixed inset-0 z-60 flex items-center justify-center bg-black bg-opacity-40">
                <div class="bg-white rounded-lg p-6 w-11/12 max-w-md">
                    <h3 class="text-lg font-semibold mb-3">Edit Profile Image</h3>
                    <form id="editImageForm" class="space-y-3">
                        <input type="file" id="profileImageInput" accept="image/*" class="w-full" />
                        <div class="flex justify-end gap-2">
                            <button type="button" id="cancelEditBtn" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                            <button type="button" id="saveEditBtn" class="px-4 py-2 bg-[#1E9E9E] text-white rounded">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        `;

        let editModal = null;

        editImageBtn.addEventListener('click', (ev) => {
            ev.stopPropagation();
            // show modal
            if (!editModal) {
                const wrapper = document.createElement('div');
                wrapper.innerHTML = modalHtml;
                document.body.appendChild(wrapper);
                editModal = document.getElementById('editImageModal');

                // wire buttons
                document.getElementById('cancelEditBtn').addEventListener('click', () => {
                    editModal.remove();
                    editModal = null;
                });

                document.getElementById('saveEditBtn').addEventListener('click', () => {
                    // Placeholder: actual upload not implemented
                    alert('Image upload not implemented yet. I can add server-side handling if you want.');
                });
            }
            closeDropdown();
        });
    </script>
</body>
</html>