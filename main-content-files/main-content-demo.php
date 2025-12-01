<?php

//require the demo.inc.php to obtain the data
require_once __DIR__ . '/../backend-config-file/demo.inc.php';

?>



<h1 class="font-noto-regular font-bold pb-5 text-2xl">Demo Requests</h1>
<div class="overflow-x-auto md:overflow-x-visible ml-5 mr-5">
  <table class="min-w-[700px] w-full table-auto md:w-170 lg:w-280 divide-y border-b border-[#ADACAC]">
    <thead class="bg-[#1E9E9E] border text-white font-regular">
      <tr class="border-b border-[#ADACAC]">
        <th class="text-left text-base tracking-wide font-semibold py-3 pl-2">Name</th>
        <th class="text-left text-base tracking-wide font-semibold py-3">Email</th>
        <th class="text-left text-base tracking-wide font-semibold py-3">Church Name</th>
        <th class="text-left text-base tracking-wide font-semibold py-3">Role</th>
  <th class="text-left text-base tracking-wide font-semibold py-3">Status</th>
  <th class="text-left text-base tracking-wide font-semibold py-3 w-40">Requested At</th>
  <th class="text-left text-base tracking-wide font-semibold py-3 w-44">Actions</th>
      </tr>
    </thead>
    <tbody>
        <!--checking for demos and displaying if available-->

        <?php if(empty($demos)) : ?>
      <tr>
        <td colspan="7" class="text-center py-4">No subscribed users found.</td>
      </tr>
        <?php else : ?>

        <!--displaying the demos in the table-->

        <?php foreach($demos as $demo) : ?>
          <tr class="border-b border-[#ADACAC]">
            <td class="py-3 pl-2 max-w-[240px] truncate"><?php echo htmlspecialchars($demo['fname'] . ' ' . $demo['lname']); ?></td>
            <td class="py-3 max-w-[220px] truncate"><?php echo htmlspecialchars($demo['email']); ?></td>
            <td class="py-3 max-w-[220px] truncate"><?php echo htmlspecialchars($demo['churchname']); ?></td>
            <?php
              // Render role as a colored badge
              $roleRaw = $demo['role'] ?? '';
              $roleKey = strtolower(trim($roleRaw));
              switch ($roleKey) {
                case 'admin':
                case 'administrator':
                  $roleCls = 'bg-blue-100 text-blue-800';
                  break;
                case 'pastor':
                case 'leader':
                  $roleCls = 'bg-indigo-100 text-indigo-800';
                  break;
                case 'member':
                case 'subscriber':
                  $roleCls = 'bg-green-100 text-green-800';
                  break;
                case 'staff':
                case 'editor':
                  $roleCls = 'bg-teal-100 text-teal-800';
                  break;
                default:
                  $roleCls = 'bg-gray-100 text-gray-800';
              }
            ?>
            <td class="py-3"><span class="inline-block px-2 py-1 rounded-full text-sm font-medium <?php echo $roleCls; ?>"><?php echo htmlspecialchars($roleRaw); ?></span></td>
            <?php
              // Normalize status and choose badge colors
              $statusRaw = $demo['Status'] ?? '';
              $status = strtolower(trim($statusRaw));
              $badgeBase = 'inline-block px-2 py-1 rounded-full text-sm font-semibold';
              if ($status === 'approved' || $status === 'approve') {
                $badgeColor = 'bg-green-100 text-green-800';
              } elseif ($status === 'pending') {
                $badgeColor = 'bg-yellow-100 text-yellow-800';
              } elseif ($status === 'deleted' || $status === 'removed') {
                $badgeColor = 'bg-rose-100 text-rose-800';
              } else {
                $badgeColor = 'bg-gray-100 text-gray-800';
              }
            ?>
            <td class="py-3"><span class="<?php echo $badgeBase . ' ' . $badgeColor; ?>"><?php echo htmlspecialchars($statusRaw); ?></span></td>
            <td class="py-3 whitespace-nowrap text-sm text-gray-600 w-40"><?php echo htmlspecialchars($demo['CreatedAt']); ?></td>
            <td class="py-3 whitespace-nowrap w-44">

              <!--form to collect the date of the user in the row-->
              <form action="backend-config-file/demo-buttons.inc.php" method="POST" class="flex items-center gap-2">

                <input type="hidden" name="email" value="<?php echo htmlspecialchars($demo['email']); ?>">

                <input type="hidden" name="role" value="<?php echo htmlspecialchars($demo['role']); ?>">

                <input type="hidden" name="fname" value="<?php echo htmlspecialchars($demo['fname']); ?>">

                <input type="hidden" name="lname" value="<?php echo htmlspecialchars($demo['lname']); ?>">

                <input type="hidden" name="churchname" value="<?php echo htmlspecialchars($demo['churchname']); ?>">

                <div class="flex items-center gap-2">

                  <button type="submit" name="action" value="approve" aria-label="Approve demo" class="flex items-center gap-2 bg-gradient-to-r from-green-400 to-green-500 hover:from-green-500 hover:to-green-600 text-white px-4 py-2 min-h-[40px] shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-green-300">

                    <!-- modern check icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4 fill-white" aria-hidden="true"><path d="M20.285 6.709a1 1 0 0 0-1.414-1.418l-9.192 9.2-3.192-3.2a1 1 0 1 0-1.414 1.414l3.899 3.899a1 1 0 0 0 1.414 0l9.899-9.895z"/></svg>

                    <span class="text-sm font-semibold">Approve</span>
                  </button>

                  <button type="submit" name="action" value="delete" aria-label="Delete demo" class="flex items-center gap-2 bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white px-4 py-2 min-h-[40px] shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-rose-300">

                      <!-- improved trash icon (solid, filled with currentColor) -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M6 2a1 1 0 00-.894.553L4 5H2a1 1 0 000 2h1v9a2 2 0 002 2h8a2 2 0 002-2V7h1a1 1 0 100-2h-2l-1.106-2.447A1 1 0 0014 2H6zm3 7a1 1 0 012 0v6a1 1 0 11-2 0V9z" clip-rule="evenodd"/></svg>
                      <span class="text-sm font-semibold">Delete</span>
                  </button>

                </div>
                
              </form>

            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>