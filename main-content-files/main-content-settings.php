<?php
// Settings main content fragment
// show session messages if any
if (!empty($_SESSION['settings_errors'])) {
    echo '<div class="mx-5 my-4 p-3 bg-rose-50 text-rose-700 rounded">';
    foreach ($_SESSION['settings_errors'] as $err) echo '<div>' . htmlspecialchars($err) . '</div>';
    echo '</div>';
    unset($_SESSION['settings_errors']);
}

if (!empty($_SESSION['settings_success'])) {
    echo '<div class="mx-5 my-4 p-3 bg-green-50 text-green-700 rounded">' . htmlspecialchars($_SESSION['settings_success']) . '</div>';
    unset($_SESSION['settings_success']);
}

?>

<div class="p-6 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-4">Settings</h1>

    <div class="grid gap-6 grid-cols-1 md:grid-cols-2">
  <!-- Profile -->
  <section class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
      <h2 class="text-lg font-semibold mb-3">Profile</h2>
      <p class="text-sm text-gray-500 mb-4">Update your public profile information.</p>
  <form action="./backend-config-file/settings.inc.php" method="post" class="space-y-4">
        <input type="hidden" name="action" value="profile">
  <div class="grid gap-3 grid-cols-1 md:grid-cols-2">
          <div>
            <label class="text-sm font-medium">First name</label>
            <input type="text" name="first_name" class="w-full mt-1 px-3 py-2 border rounded" placeholder="First name">
          </div>
          <div>
            <label class="text-sm font-medium">Last name</label>
            <input type="text" name="last_name" class="w-full mt-1 px-3 py-2 border rounded" placeholder="Last name">
          </div>
        </div>
        <div>
          <label class="text-sm font-medium">Email</label>
          <input type="email" name="email" class="w-full mt-1 px-3 py-2 border rounded bg-gray-50" placeholder="you@example.com">
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-[#1E9E9E] text-white px-4 py-2 rounded">Save profile</button>
        </div>
      </form>
    </section>

  <!-- Security -->
  <section class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
      <h2 class="text-lg font-semibold mb-3">Security</h2>
      <p class="text-sm text-gray-500 mb-4">Change your password and manage authentication settings.</p>
  <form action="./backend-config-file/settings.inc.php" method="post" class="space-y-4">
        <input type="hidden" name="action" value="password">
        <div>
          <label class="text-sm font-medium">Current password</label>
          <input type="password" name="current_password" class="w-full mt-1 px-3 py-2 border rounded" />
        </div>
        <div>
          <label class="text-sm font-medium">New password</label>
          <input type="password" name="new_password" class="w-full mt-1 px-3 py-2 border rounded" />
        </div>
        <div>
          <label class="text-sm font-medium">Confirm new password</label>
          <input type="password" name="confirm_password" class="w-full mt-1 px-3 py-2 border rounded" />
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-[#1E9E9E] text-white px-4 py-2 rounded">Change password</button>
        </div>
      </form>
    </section>

  <!-- Appearance -->
  <section class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 md:col-span-2">
      <h2 class="text-lg font-semibold mb-3">Appearance</h2>
      <p class="text-sm text-gray-500 mb-4">Upload branding assets and tweak appearance options.</p>
  <form action="./backend-config-file/settings.inc.php" method="post" enctype="multipart/form-data" class="space-y-4">
        <input type="hidden" name="action" value="appearance">
        <div class="flex items-center gap-4 flex-col sm:flex-row">
          <div class="w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 bg-gray-100 rounded flex items-center justify-center overflow-hidden">
            <img src="/assets/images/saltLogo.png" alt="logo" class="max-w-full max-h-full">
          </div>
          <div class="flex-1">
            <label class="text-sm font-medium">Upload logo</label>
            <input type="file" name="logo" class="mt-2 block w-full" accept="image/*">
            <p class="text-xs text-gray-400 mt-1">PNG or SVG recommended. Max 2MB.</p>
          </div>
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-[#1E9E9E] text-white px-4 py-2 rounded">Save appearance</button>
        </div>
      </form>
    </section>

  <!-- Notifications -->
  <section class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 md:col-span-2">
      <h2 class="text-lg font-semibold mb-3">Notifications</h2>
      <p class="text-sm text-gray-500 mb-4">Control which notifications are sent to admins.</p>
  <form action="./backend-config-file/settings.inc.php" method="post" class="space-y-4">
        <input type="hidden" name="action" value="notifications">
        <div class="grid gap-3 md:grid-cols-2">
          <label class="flex items-center gap-3">
            <input type="checkbox" name="notify_demo" class="h-4 w-4">
            <span class="text-sm">Notify me on new demo requests</span>
          </label>
          <label class="flex items-center gap-3">
            <input type="checkbox" name="notify_payments" class="h-4 w-4">
            <span class="text-sm">Notify me on payment failures</span>
          </label>
        </div>
        <div class="flex justify-end">
          <button type="submit" class="bg-[#1E9E9E] text-white px-4 py-2 rounded">Save notifications</button>
        </div>
      </form>
    </section>
  </div>

</div>
