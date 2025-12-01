<?php
// Require authentication before rendering any output
include_once __DIR__ . '/includes/auth.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Users Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

  <!-- Registered Users Table Heading -->
  <div class="flex justify-between items-center py-2 mx-5 mt-3 mb-3">
    <p class="font-semibold">Registered Users</p>
    <div class="flex items-center relative inline-block text-left group cursor-pointer">
      <div class="flex items-center">
        <p class="flex mr-1 font-semibold">Order By:</p>
        <button type="button" class="flex items-center pr-1 border-b border-b-[#1E9E9E] focus:outline-none relative">
          <span>Ascending Order</span>
          <span class="flex items-center justify-center w-5 h-5 ml-2">
            <img src="https://img.icons8.com/ios/30/expand-arrow--v2.png" alt="DownArrow icon" width="16" height="16" class="transition-transform duration-200 group-hover:rotate-180" style="object-fit:contain;" />
          </span>
        </button>
      </div>
      <div class="absolute left-0 top-full mt-2 min-w-[140px] z-10 hidden group-hover:block bg-white shadow-lg rounded-md">
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Descending Order</a>
      </div>
    </div>
  </div>

  <!-- Registered Users Table -->
  <div class="overflow-x-auto md:overflow-x-visible ml-5 mr-5">
    <table class="min-w-[700px] w-full md:w-170 lg:w-280">
      <thead class="bg-[#1E9E9E] border text-white font-regular rounded-t-lg">
        <tr>
          <th class="text-left text-2xl text-sm tracking-wide font-semibold py-3 pl-2">#</th>
          <th class="text-left text-2xl text-sm tracking-wide font-semibold py-3">Firstname</th>
          <th class="text-left text-2xl text-sm tracking-wide font-semibold py-3">Lastname</th>
          <th class="text-left text-2xl text-sm tracking-wide font-semibold py-3">PhoneNumber</th>
          <th class="text-left text-2xl text-sm tracking-wide font-semibold py-3">Email</th>
        </tr>
      </thead>
      <tbody id="registered-users-body">
        <!-- Populated by JS -->
      </tbody>
    </table>
  </div>

  <!-- Subscribed Users Table Heading -->
  <div class="flex justify-between items-center py-2 mx-5 mt-5">
    <p class="font-semibold">Subscribed Users</p>
    <div class="flex items-center relative inline-block text-left group cursor-pointer">
      <div class="flex items-center">
        <p class="flex mr-1 font-semibold">Order By:</p>
        <button type="button" class="flex items-center pr-1 border-b border-b-[#1E9E9E] focus:outline-none relative">
          <span>Ascending Order</span>
          <span class="flex items-center justify-center w-5 h-5 ml-2">
            <img src="https://img.icons8.com/ios/30/expand-arrow--v2.png" alt="DownArrow icon" width="16" height="16" class="transition-transform duration-200 group-hover:rotate-180" style="object-fit:contain;" />
          </span>
        </button>
      </div>
      <div class="absolute left-0 top-full mt-2 min-w-[140px] z-10 hidden group-hover:block bg-white shadow-lg rounded-md">
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Descending Order</a>
      </div>
    </div>
  </div>

  <!-- Subscribed Users Table -->
  <div class="overflow-x-auto md:overflow-x-visible mt-2 ml-5 mr-5 rounded-md">
    <table class="min-w-[700px] w-full divide-y border-b border-[#ADACAC] md:w-170 lg:w-280">
      <thead class="bg-[#1E9E9E] border text-white font-regular">
        <tr>
          <th class="text-left text-2xl text-sm tracking-wide font-semibold py-3 pl-2">#</th>
          <th class="text-left text-2xl text-sm tracking-wide font-semibold py-3">Profile</th>
          <th class="text-left text-2xl text-sm tracking-wide font-semibold py-3">Firstname</th>
          <th class="text-left text-2xl text-sm tracking-wide font-semibold py-3">Lastname</th>
          <th class="text-left text-2xl text-sm tracking-wide font-semibold py-3">PhoneNumber</th>
          <th class="text-left text-2xl text-sm tracking-wide font-semibold py-3">Email</th>
        </tr>
      </thead>
      <tbody id="subscribed-users-body">
        <!-- Populated by JS -->
      </tbody>
    </table>
  </div>

  <script>
    // Sample data for demonstration
    const registeredUsers = [
      { firstname: "John", lastname: "Doe", phone: "1234567890", email: "john@example.com" },
      { firstname: "Jane", lastname: "Smith", phone: "0987654321", email: "jane@example.com" }
    ];

    const subscribedUsers = [
      { profile: "Profile 1", Firstname: "Alice", Lastname: "Brown", PhoneNumber: "1112223333", Email: "alice@example.com" },
      { profile: "Profile 2", Firstname: "Bob", Lastname: "Green", PhoneNumber: "4445556666", Email: "bob@example.com" }
    ];

    // Populate Registered Users Table
    const regBody = document.getElementById('registered-users-body');
    registeredUsers.forEach((user, idx) => {
      const tr = document.createElement('tr');
      tr.className = "border-b border-[#ADACAC]";
      tr.innerHTML = `
        <td class="py-3 pl-2">${idx + 1}</td>
        <td class="py-3">${user.firstname}</td>
        <td class="py-3">${user.lastname}</td>
        <td class="py-3">${user.phone}</td>
        <td class="py-3">${user.email}</td>
      `;
      regBody.appendChild(tr);
    });

    // Populate Subscribed Users Table
    const subBody = document.getElementById('subscribed-users-body');
    subscribedUsers.forEach((user, idx) => {
      const tr = document.createElement('tr');
      tr.className = "border-b border-[#ADACAC]";
      tr.innerHTML = `
        <td class="py-3 pl-2">${idx + 1}</td>
        <td class="py-3">${user.profile}</td>
        <td class="py-3">${user.Firstname}</td>
        <td class="py-3">${user.Lastname}</td>
        <td class="py-3">${user.PhoneNumber}</td>
        <td class="py-3">${user.Email}</td>
      `;
      subBody.appendChild(tr);
    });
  </script>
</body>
</html>