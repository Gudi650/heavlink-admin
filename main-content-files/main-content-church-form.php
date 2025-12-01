<?php
// Church creation form - responsive and accessible
// This file is intended to be included into your admin layout.
?>

<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md border border-gray-100">
  <div class="flex items-start gap-4">
    <div class="h-10 w-10 flex items-center justify-center rounded-md bg-[#1e9e9e] text-white text-lg font-bold">C</div>
    <div class="flex-1">
      <h2 class="text-2xl font-semibold text-gray-800">Add New Church</h2>
      <p class="text-sm text-gray-600 mt-1">Fill in the church details below. Fields marked <span class="text-rose-600">*</span> are required.</p>
    </div>
  </div>

  <form id="churchForm" action="backend-config-file/churches-buttons.inc.php" method="POST" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">

    <div class="col-span-1 md:col-span-2">
      <label for="name" class="block text-xs font-semibold tracking-wide text-gray-700">Church Name <span class="text-rose-600">*</span></label>
      <input id="name" name="name" type="text" required class="mt-1 block w-full border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1e9e9e] focus:border-[#1e9e9e] shadow-sm" placeholder="e.g. First Community Church">
    </div>

    <div>
      <label for="address" class="block text-xs font-medium text-gray-700">Address</label>
      <input id="address" name="address" type="text" class="mt-1 block w-full border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1e9e9e] focus:border-[#1e9e9e]" placeholder="Street address">
    </div>

    <div>
      <label for="city" class="block text-xs font-medium text-gray-700">City</label>
      <input id="city" name="city" type="text" class="mt-1 block w-full border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1e9e9e] focus:border-[#1e9e9e]" placeholder="City">
    </div>

    <div>
      <label for="state" class="block text-xs font-medium text-gray-700">State / Region</label>
      <input id="state" name="state" type="text" class="mt-1 block w-full border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1e9e9e] focus:border-[#1e9e9e]" placeholder="State">
    </div>

    <div>
      <label for="country" class="block text-xs font-medium text-gray-700">Country</label>
      <input id="country" name="country" type="text" class="mt-1 block w-full border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1e9e9e] focus:border-[#1e9e9e]" placeholder="Country">
    </div>

    <div>
      <label for="postal" class="block text-xs font-medium text-gray-700">Postal Code</label>
      <input id="postal" name="postal" type="text" class="mt-1 block w-full border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1e9e9e] focus:border-[#1e9e9e]" placeholder="ZIP / Postal code">
    </div>

    <div>
      <label for="phone" class="block text-xs font-medium text-gray-700">Phone</label>
      <input id="phone" name="phone" type="tel" class="mt-1 block w-full border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1e9e9e] focus:border-[#1e9e9e]" placeholder="+1 555 555 555">
    </div>

    <div>
      <label for="email" class="block text-xs font-medium text-gray-700">Contact Email</label>
      <input id="email" name="email" type="email" class="mt-1 block w-full border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1e9e9e] focus:border-[#1e9e9e]" placeholder="contact@church.org">
    </div>

    <div>
      <label for="website" class="block text-xs font-medium text-gray-700">Website</label>
      <input id="website" name="website" type="url" class="mt-1 block w-full border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1e9e9e] focus:border-[#1e9e9e]" placeholder="https://">
    </div>

    <div class="col-span-1 md:col-span-2">
      <label for="description" class="block text-xs font-medium text-gray-700">Short Description</label>
      <textarea id="description" name="description" rows="4" class="mt-1 block w-full border border-gray-200 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1e9e9e] focus:border-[#1e9e9e]" placeholder="A short description or notes about the church"></textarea>
    </div>

    <div id="formError" class="col-span-1 md:col-span-2 hidden text-sm text-rose-700 bg-rose-50 border border-rose-100 px-3 py-2 rounded"></div>

    <div class="col-span-1 md:col-span-2 flex items-center justify-end gap-3 mt-2">
      <button type="reset" class="px-4 py-2 border border-gray-200 rounded-md text-gray-700 hover:bg-gray-50">Reset</button>
      <button type="submit" id="submitBtn" class="px-4 py-2 bg-[#1e9e9e] text-white rounded-md shadow hover:bg-[#176e6e] transition-colors">Create Church</button>
    </div>

  </form>

  <script>
  (function(){
    const form = document.getElementById('churchForm');
    const submit = document.getElementById('submitBtn');
    const errorBox = document.getElementById('formError');

    function showError(msg) {
      errorBox.textContent = msg;
      errorBox.classList.remove('hidden');
    }
    function clearError() {
      errorBox.textContent = '';
      errorBox.classList.add('hidden');
    }

    form.addEventListener('submit', function(e){
      clearError();
      const name = document.getElementById('name');
      const email = document.getElementById('email');
      if (!name.value.trim()) {
        e.preventDefault();
        name.focus();
        showError('Please provide the church name.');
        return false;
      }
      if (email.value.trim()) {
        // light email validation
        const re = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
        if (!re.test(email.value.trim())) {
          e.preventDefault();
          email.focus();
          showError('Please provide a valid email address or leave it blank.');
          return false;
        }
      }
      // disable the submit button to avoid duplicate submits
      submit.disabled = true;
      submit.classList.add('opacity-70');
      return true;
    });
  })();
  </script>

</div>
