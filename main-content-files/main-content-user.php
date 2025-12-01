 <!-- Registered Users Table Heading -->

  <!--This is the section for displaying the hesers of the registred tables-->
  <div class="flex justify-between items-center py-2 mx-5 mt-3 mb-3">
    <p class="font-semibold">Registered Churches</p>
  <div id="orderToggleWrapper" class="flex items-center relative inline-block text-left group cursor-pointer">
      <div class="flex items-center">
        <p class="flex mr-1 font-semibold">Order By:</p>
        <button id="orderToggleBtn" type="button" class="flex items-center pr-1 border-b border-b-[#1E9E9E] focus:outline-none relative" aria-pressed="false">
          <span id="orderToggleLabel">Ascending Order</span>
          <span class="flex items-center justify-center w-5 h-5 ml-2">
            <img id="orderToggleIcon" src="https://img.icons8.com/ios/30/expand-arrow--v2.png" alt="DownArrow icon" width="16" height="16" class="transition-transform duration-200" style="object-fit:contain; transform: rotate(0deg);" />
          </span>
        </button>
      </div>
      <div id="orderDropdown" class="absolute left-0 top-full mt-2 min-w-[140px] z-10 hidden bg-white shadow-lg rounded-md">
        <a href="#" id="orderToggleDesc" class="block px-4 py-2 hover:bg-gray-100">Descending Order</a>
      </div>
    </div>
  </div>

  <!-- Registered Users Table -->
  <div class="overflow-x-auto md:overflow-x-visible ml-5 mr-5">
    <table class="min-w-[700px] w-full md:w-170 lg:w-280">
      <thead class="bg-[#1E9E9E] border text-white font-regular rounded-t-lg">
        
        <tr class="border-b border-[#ADACAC]">
          <th class="text-left text-base tracking-wide font-semibold py-3 pl-2">id</th>
          <th class="text-left text-base tracking-wide font-semibold py-3">Church Name</th>
          <th class="text-left text-base tracking-wide font-semibold py-3">Church Address</th>
          <th class="text-left text-base tracking-wide font-semibold py-3">Church Type</th>
          <th class="text-left text-base tracking-wide font-semibold py-3">PhoneNumber</th>
          <th class="text-left text-base tracking-wide font-semibold py-3">Email</th>
        </tr>
      </thead>
      <tbody id="registered-users-body">

      <!-- checking for an empty array -->
        <?php if (empty($churches)): ?>
        <tr>
          <td colspan="6" class="text-center py-4">No subscribed users found.</td>
        </tr>
        <?php else: ?>

        <!--displaying the data from the database-->
        <?php foreach ($churches as $church): ?>
          <tr class="border-b border-[#ADACAC]">
            <td class="py-3 pl-2">
              <?php echo htmlspecialchars($church['church_id']); ?>
            </td>
            <td class="py-3">
              <?php echo htmlspecialchars($church['name']); ?>
            </td>
            <td class="py-3">
              <?php echo htmlspecialchars($church['address']); ?>
            </td>
            <td class="py-3"> 
              <?php echo htmlspecialchars($church['type']); ?>
            </td>
            <td class="py-3">
              <?php echo htmlspecialchars($church['contact_phone']); ?>
            </td>
            <td class="py-3">
              <?php echo htmlspecialchars($church['contact_email']); ?>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php endif; ?>
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

        <tr class="border-b border-[#ADACAC]">
          <th class="text-left text-base tracking-wide font-semibold py-3 pl-2">id</th>
          <th class="text-left text-base tracking-wide font-semibold py-3">Church Name</th>
          <th class="text-left text-base tracking-wide font-semibold py-3">Church Address</th>
          <th class="text-left text-base tracking-wide font-semibold py-3">Church Type</th>
          <th class="text-left text-base tracking-wide font-semibold py-3">PhoneNumber</th>
          <th class="text-left text-base tracking-wide font-semibold py-3">Email</th>
        </tr>
      </thead>

      <tbody id="subscribed-users-body">

        <!-- checking for an empty array -->
        <?php if (empty($churches)): ?>
        <tr>
          <td colspan="6" class="text-center py-4">No subscribed Churches found.</td>
        </tr>
        <?php else: ?>

        <!--displaying the data from the database-->
        <?php foreach ($churches as $church): ?>
          <tr class="border-b border-[#ADACAC]">
            <td class="py-3 pl-2">
              <?php echo htmlspecialchars($church['church_id']); ?>
            </td>
            <td class="py-3">
              <?php echo htmlspecialchars($church['name']); ?>
            </td>
            <td class="py-3">
              <?php echo htmlspecialchars($church['address']); ?>
            </td>
            <td class="py-3"> 
              <?php echo htmlspecialchars($church['type']); ?>
            </td>
            <td class="py-3">
              <?php echo htmlspecialchars($church['contact_phone']); ?>
            </td>
            <td class="py-3">
              <?php echo htmlspecialchars($church['contact_email']); ?>
            </td>
          </tr>
        <?php endforeach; ?>

        <tr>
          <td class="py-3 pl-2">1</td>
          <td class="py-3">Profile 1</td>
          <td class="py-3">Alice</td>
          <td class="py-3">Brown</td>
          <td class="py-3">1112223333</td>
          <td class="py-3">alice@example.com</td>
          <td class="py-3">
        </tr>

        <?php endif; ?>
        
      </tbody>
    </table>
  </div>

  <script>
    // Table ordering: toggles ascending/descending by Church Name (2nd column)
    (function(){
      const btn = document.getElementById('orderToggleBtn');
      const label = document.getElementById('orderToggleLabel');
      const icon = document.getElementById('orderToggleIcon');
      const descLink = document.getElementById('orderToggleDesc');
      const wrapper = document.getElementById('orderToggleWrapper');
      const dropdown = document.getElementById('orderDropdown');
      let ascending = true;
      let hideTimer = null;
      const HIDE_DELAY = 700; // milliseconds the dropdown lingers after mouse leaves

      function getRows(tbodyId) {
        const tb = document.getElementById(tbodyId);
        if (!tb) return [];
        return Array.from(tb.querySelectorAll('tr')).filter(tr => tr.querySelectorAll('td').length > 0);
      }

      function sortTbody(tbodyId, asc){
        const rows = getRows(tbodyId);
        if (!rows.length) return;
        const tbody = document.getElementById(tbodyId);
        rows.sort((a,b)=>{
          const aText = (a.cells[1] && a.cells[1].textContent || '').trim().toLowerCase();
          const bText = (b.cells[1] && b.cells[1].textContent || '').trim().toLowerCase();
          if (aText < bText) return asc ? -1 : 1;
          if (aText > bText) return asc ? 1 : -1;
          return 0;
        });
        rows.forEach(r => tbody.appendChild(r));
      }

      function applyOrder(){
        sortTbody('registered-users-body', ascending);
        sortTbody('subscribed-users-body', ascending);
        label.textContent = ascending ? 'Ascending Order' : 'Descending Order';
        icon.style.transform = ascending ? 'rotate(0deg)' : 'rotate(180deg)';
        btn.setAttribute('aria-pressed', String(!ascending));
        // Set dropdown option text to the opposite action (what clicking it will do)
        if (descLink) {
          descLink.textContent = ascending ? 'Descending Order' : 'Ascending Order';
        }
      }

      function showDropdown(){
        if (!dropdown) return;
        clearTimeout(hideTimer);
        dropdown.classList.remove('hidden');
      }

      function hideDropdownDelayed(){
        if (!dropdown) return;
        clearTimeout(hideTimer);
        hideTimer = setTimeout(()=>{
          dropdown.classList.add('hidden');
        }, HIDE_DELAY);
      }

      // Toggle sorting when main button clicked and hide dropdown if open
      btn && btn.addEventListener('click', function(e){
        ascending = !ascending;
        applyOrder();
        dropdown && dropdown.classList.add('hidden');
      });

      // Dropdown link toggles the order (sets to the opposite) and hides dropdown immediately
      descLink && descLink.addEventListener('click', function(e){
        e.preventDefault();
        // toggle to the opposite order
        ascending = !ascending;
        applyOrder();
        dropdown && dropdown.classList.add('hidden');
      });

      // Show dropdown when hovering the wrapper/button; hide with delay when leaving
      if (wrapper){
        wrapper.addEventListener('mouseenter', showDropdown);
        wrapper.addEventListener('mouseleave', hideDropdownDelayed);
      }
      if (dropdown){
        dropdown.addEventListener('mouseenter', showDropdown);
        dropdown.addEventListener('mouseleave', hideDropdownDelayed);
      }

      // initial apply
      applyOrder();
    })();
  </script>