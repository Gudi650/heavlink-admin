<?php
// Require authentication before rendering any output
include_once __DIR__ . '/includes/auth.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Notification Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS CDN -->
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-50">
  <div class="my-5 mx-5">
    <p class="text-xl font-semibold text-[#1E9E9E]">
      Choose Notification based on the system selected.
    </p>
  </div>
  <!-- Heading of the page -->

  <div class="flex flex-col md:flex-row md:items-center justify-between mr-5">
    <!-- Flex container for the dropdown and button -->
    <div class="flex items-center relative inline-block text-left group cursor-pointer mx-5 mt-1">
      <div class="flex items-center">
        <p class="flex mr-1 font-semibold">System Name:</p>
        <p id="dropdownTrigger" class="pr-1 border-b border-b-[#1E9E9E] flex items-center cursor-pointer">
          Mednet
          <img
            src="https://img.icons8.com/ios/30/expand-arrow--v2.png"
            alt="DownArrow icon"
            width="14"
            height="14"
            style="object-fit: contain;"
            class="pl-1"
          />
        </p>
      </div>
      <!-- Dropdown menu -->
      <div id="dropdownMenu" class="absolute ml-[120px] hidden bg-white shadow-lg rounded-md z-10">
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">
          Office System
        </a>
      </div>
    </div>

    <!-- Button that opens modal via intercepted route -->
    <a
      href="#"
      id="sendNotificationBtn"
      class="bg-[#1E9E9E] text-white px-3 py-2 mt-5 md:mt-3 rounded-md hover:bg-[#0d7a7a] transition-colors duration-200 flex items-center ml-5 md:ml-0"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="size-6 mr-2"
      >
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
      </svg>
      Send Notification
    </a>
  </div>

  <!-- Modal (hidden by default) -->
  <!-- Send Notification Modal (hidden by default) -->
  <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg max-w-lg w-full">
      <h2 class="text-xl font-bold mb-4 text-[#1E9E9E]">Send Notification</h2>
      <form id="notificationForm" class="space-y-4">
        <div>
          <label for="systemName" class="block text-sm font-medium text-gray-700 mb-1">
            System Name
          </label>
          <input
            type="text"
            id="systemName"
            name="systemName"
            placeholder="Enter system name"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#1E9E9E]"
          />
        </div>
        <div>
          <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
            Notification Message
          </label>
          <textarea
            id="message"
            name="message"
            rows="4"
            placeholder="Type your message here..."
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#1E9E9E] resize-none"
          ></textarea>
        </div>
        <div class="flex justify-end space-x-2">
          <button
            type="button"
            id="closeModal"
            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-[#1E9E9E] text-white rounded hover:bg-[#168a8a]"
          >
            Send
          </button>
        </div>
        <div>
          <p id="modalError" class="text-red-500 text-sm hidden"></p>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Dropdown logic
    const dropdownTrigger = document.getElementById('dropdownTrigger');
    const dropdownMenu = document.getElementById('dropdownMenu');
    dropdownTrigger.addEventListener('click', function(e) {
      e.stopPropagation();
      dropdownMenu.classList.toggle('hidden');
    });
    document.addEventListener('click', function() {
      dropdownMenu.classList.add('hidden');
    });

      // Modal logic
      const sendNotificationBtn = document.getElementById('sendNotificationBtn');
      const modal = document.getElementById('modal');
      const closeModal = document.getElementById('closeModal');
      const notificationForm = document.getElementById('notificationForm');
      const modalError = document.getElementById('modalError');

      sendNotificationBtn.addEventListener('click', function(e) {
        e.preventDefault();
        modal.classList.remove('hidden');
      });
      closeModal.addEventListener('click', function() {
        modal.classList.add('hidden');
        modalError.classList.add('hidden');
        notificationForm.reset();
      });
      // Optional: close modal when clicking outside
      modal.addEventListener('click', function(e) {
        if (e.target === modal) {
          modal.classList.add('hidden');
          modalError.classList.add('hidden');
          notificationForm.reset();
        }
      });

      // Form validation
      notificationForm.onsubmit = function(e) {
        e.preventDefault();
        var name = document.getElementById('systemName').value.trim();
        var message = document.getElementById('message').value.trim();
        if (!name || !message) {
          modalError.textContent = 'Please fill in all fields';
          modalError.classList.remove('hidden');
          return;
        }
        // Simulate success (no backend)
        modalError.classList.add('hidden');
        alert('Notification sent successfully!');
        modal.classList.add('hidden');
        notificationForm.reset();
      };
  </script>
</body>
</html>