<?php
// Load finances data
require_once __DIR__ . '/../backend-config-file/finances.inc.php';
?>

<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-500">Admin: Purchases</h1>

    <div class="mb-10">
      <h2 class="text-xl font-semibold mb-2 text-green-700">Successful Purchases</h2>
      <div class="overflow-x-auto md:overflow-x-visible ml-5 mr-5">
        <table class="min-w-[700px] w-full md:w-170 lg:w-280 divide-y border-b border-[#ADACAC]">
          <thead class="bg-[#1E9E9E] border text-white font-regular rounded-t-lg">
            <tr class="border-b border-[#ADACAC]">
              <th class="text-left text-base tracking-wide font-semibold py-3 pl-2">User</th>
              <th class="text-left text-base tracking-wide font-semibold py-3">Product</th>
              <th class="text-left text-base tracking-wide font-semibold py-3">Amount</th>
              <th class="text-left text-base tracking-wide font-semibold py-3">Start Date</th>
              <th class="text-left text-base tracking-wide font-semibold py-3">End Date</th>
              <th class="text-left text-base tracking-wide font-semibold py-3">Status</th>
            </tr>
          </thead>
          <tbody>
          <?php if (!empty($successfulPayments)) : ?>
            <?php foreach ($successfulPayments as $p) : ?>
              <tr class="border-b border-[#ADACAC]">
                <td class="py-3 pl-2"><?php echo htmlspecialchars($p['user']); ?></td>
                <td class="py-3"><?php echo htmlspecialchars($p['product']); ?></td>
                <td class="py-3"><?php echo htmlspecialchars($p['amount']); ?></td>
                <td class="py-3"><?php echo $p['start_date'] ? htmlspecialchars(date('M j, Y g:i A', strtotime($p['start_date']))) : '-'; ?></td>
                <td class="py-3"><?php echo $p['end_date'] ? htmlspecialchars(date('M j, Y g:i A', strtotime($p['end_date']))) : '-'; ?></td>
                <td class="py-3">
                  <?php
                    $st = strtolower($p['status'] ?? '');
                    $badge = 'bg-gray-100 text-gray-800';
                    if (in_array($st, ['active','success','paid','completed'], true)) $badge = 'bg-green-100 text-green-700';
                    if (in_array($st, ['expired','expired_subscription'], true)) $badge = 'bg-yellow-100 text-yellow-700';
                  ?>
                  <span class="inline-block px-2 py-1 rounded-full text-sm font-semibold <?php echo $badge; ?>"><?php echo htmlspecialchars($p['status'] ?: ''); ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>

            <tr>
              <td colspan="6" class="text-center py-4">
                No successful purchases found.
              </td>
            </tr>
            
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div>
      <h2 class="text-xl font-semibold mb-2 text-red-700">Failed Payments</h2>
      <div class="overflow-x-auto md:overflow-x-visible mt-2 ml-5 mr-5 rounded-md">
        <table class="min-w-[700px] w-full divide-y border-b border-[#ADACAC] md:w-170 lg:w-280">
          <thead class="bg-[#1E9E9E] border text-white font-regular">
            <tr class="border-b border-[#ADACAC]">
              <th class="text-left text-base tracking-wide font-semibold py-3 pl-2">Order Ref</th>
              <th class="text-left text-base tracking-wide font-semibold py-3">User</th>
              <th class="text-left text-base tracking-wide font-semibold py-3">System</th>
              <th class="text-left text-base tracking-wide font-semibold py-3">Amount</th>
              <th class="text-left text-base tracking-wide font-semibold py-3">Status</th>
              <th class="text-left text-base tracking-wide font-semibold py-3">Date</th>
              <th class="text-left text-base tracking-wide font-semibold py-3">Phone</th>
            </tr>
          </thead>
          <tbody>
          <?php if (!empty($failedPayments)) : ?>
            <?php foreach ($failedPayments as $f) : ?>
              <tr class="border-b border-[#ADACAC]">
                <td class="py-3 pl-2"><?php echo htmlspecialchars($f['order_ref'] ?: '-'); ?></td>
                <td class="py-3"><?php echo htmlspecialchars($f['user']); ?></td>
                <td class="py-3"><?php echo htmlspecialchars($f['system'] ?: $f['product']); ?></td>
                <td class="py-3"><?php echo htmlspecialchars($f['amount']); ?></td>
                <td class="py-3">
                  <span class="inline-block px-2 py-1 rounded-full text-sm font-semibold bg-rose-100 text-rose-700"><?php echo htmlspecialchars($f['status'] ?: 'failed'); ?></span>
                </td>
                <td class="py-3"><?php echo $f['date'] ? htmlspecialchars(date('M j, Y g:i A', strtotime($f['date']))) : '-'; ?></td>
                <td class="py-3"><?php echo htmlspecialchars($f['phone'] ?: '-'); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="7" class="text-center py-4">No failed payments found.</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
  