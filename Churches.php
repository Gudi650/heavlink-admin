<?php
// Require authentication before rendering any output
include_once __DIR__ . '/includes/auth.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Products Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 px-5 pt-5">

  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Products</h1>
    <button id="addProductBtn" class="bg-[#1e9e9e] hover:bg-[#188888] text-white px-4 py-2 text-sm font-semibold">
      <img src="https://img.icons8.com/ios-filled/18/FFFFFF/plus-math.png" alt="Add" class="inline-block mr-2 align-middle" />
      Add Product
    </button>
  </div>

  <!-- Add Church button (opens form page) -->
  <div class="mb-6">
    <a href="../registerChurch.php" class="inline-flex items-center gap-2 bg-[#1e9e9e] hover:bg-[#188888] text-white px-4 py-2 text-sm font-semibold rounded">
      <img src="https://img.icons8.com/ios-filled/16/FFFFFF/plus-math.png" alt="Add Church" />
      Add Church
    </a>
  </div>

  <div class="overflow-x-auto max-w-full">
    <table class="min-w-[800px] w-full bg-white text-sm" id="productsTable">
      <thead class="bg-slate-100">
        <tr>
          <th class="py-3 px-4 text-left">Name</th>
          <th class="py-3 px-4 text-left">Description</th>
          <th class="py-3 px-4 text-left">Price</th>
          <th class="py-3 px-4 text-left">Subscription</th>
          <th class="py-3 px-4 text-left">Actions</th>
        </tr>
      </thead>
      <tbody id="productsBody">
        <!-- Populated by JS -->
      </tbody>
    </table>
  </div>

  <!-- Add Product Modal -->
  <div id="addModal" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black bg-opacity-30 hidden">
    <div class="bg-white p-6 w-11/12 max-w-md rounded shadow relative">
      <button class="absolute top-2 right-2 text-slate-500 hover:text-[#1e9e9e] text-2xl" onclick="closeAddModal()">&times;</button>
      <h2 class="text-lg font-bold mb-4">Add Product</h2>
      <form id="addForm" class="space-y-4">
        <input type="text" class="w-full border px-3 py-2 rounded" placeholder="Name" required name="name" />
        <textarea class="w-full border px-3 py-2 rounded" placeholder="Description" required name="description"></textarea>
        <input type="number" class="w-full border px-3 py-2 rounded" placeholder="Price" required name="price" />
        <input type="text" class="w-full border px-3 py-2 rounded" placeholder="Subscription Period (e.g. 1 month)" name="subscriptionPeriod" />
        <button type="submit" class="bg-[#1e9e9e] hover:bg-[#188888] text-white px-4 py-2 rounded shadow w-full">Add</button>
      </form>
    </div>
  </div>

  <!-- Edit Product Modal -->
  <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black bg-opacity-30 hidden">
    <div class="bg-white p-6 w-11/12 max-w-md rounded shadow relative">
      <button class="absolute top-2 right-2 text-slate-500 hover:text-[#1e9e9e] text-2xl" onclick="closeEditModal()">&times;</button>
      <h2 class="text-lg font-bold mb-4">Edit Product</h2>
      <form id="editForm" class="space-y-4">
        <input type="text" class="w-full border px-3 py-2 rounded" placeholder="Name" required name="name" />
        <textarea class="w-full border px-3 py-2 rounded" placeholder="Description" required name="description"></textarea>
        <input type="number" class="w-full border px-3 py-2 rounded" placeholder="Price" required name="price" />
        <input type="text" class="w-full border px-3 py-2 rounded" placeholder="Subscription Period (e.g. 1 month)" name="subscriptionPeriod" />
        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow w-full">Update</button>
      </form>
    </div>
  </div>

  <script>
    // Sample data
    let products = [
      { id: "1", name: "Product A", description: "Description A", price: 10, subscriptionPeriod: "1 month" },
      { id: "2", name: "Product B", description: "Description B", price: 20, subscriptionPeriod: "6 months" }
    ];

    let editProductId = null;

    function renderProducts() {
      const tbody = document.getElementById('productsBody');
      tbody.innerHTML = '';
      products.forEach(product => {
        const tr = document.createElement('tr');
        tr.className = "border-b border-slate-200";
        tr.innerHTML = `
          <td class="py-2 px-4 font-semibold">${product.name}</td>
          <td class="py-2 px-4">${product.description}</td>
          <td class="py-2 px-4">${product.price}</td>
          <td class="py-2 px-4">${product.subscriptionPeriod || ''}</td>
          <td class="py-2 px-4 flex gap-2 items-center">
            <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 text-xs rounded" onclick="openEditModal('${product.id}')">
              <img src="https://img.icons8.com/ios-filled/16/FFFFFF/edit.png" alt="Edit" class="inline-block mr-1 align-middle" />
              Edit
            </button>
            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded" onclick="deleteProduct('${product.id}')">
              <img src="https://img.icons8.com/ios-filled/16/FFFFFF/delete-sign.png" alt="Delete" class="inline-block mr-1 align-middle" />
              Delete
            </button>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    // Add Product Modal
    document.getElementById('addProductBtn').onclick = () => {
      document.getElementById('addModal').classList.remove('hidden');
    };
    function closeAddModal() {
      document.getElementById('addModal').classList.add('hidden');
      document.getElementById('addForm').reset();
    }
    document.getElementById('addForm').onsubmit = function(e) {
      e.preventDefault();
      const form = e.target;
      const newProduct = {
        id: Date.now().toString(),
        name: form.name.value,
        description: form.description.value,
        price: form.price.value,
        subscriptionPeriod: form.subscriptionPeriod.value
      };
      products.push(newProduct);
      renderProducts();
      closeAddModal();
      alert('Product added successfully.');
    };

    // Edit Product Modal
    function openEditModal(id) {
      editProductId = id;
      const product = products.find(p => p.id === id);
      const form = document.getElementById('editForm');
      form.name.value = product.name;
      form.description.value = product.description;
      form.price.value = product.price;
      form.subscriptionPeriod.value = product.subscriptionPeriod || '';
      document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() {
      document.getElementById('editModal').classList.add('hidden');
      document.getElementById('editForm').reset();
      editProductId = null;
    }
    document.getElementById('editForm').onsubmit = function(e) {
      e.preventDefault();
      const form = e.target;
      const idx = products.findIndex(p => p.id === editProductId);
      if (idx > -1) {
        products[idx] = {
          ...products[idx],
          name: form.name.value,
          description: form.description.value,
          price: form.price.value,
          subscriptionPeriod: form.subscriptionPeriod.value
        };
        renderProducts();
        closeEditModal();
        alert('Product updated successfully.');
      }
    };

    // Delete Product
    function deleteProduct(id) {
      if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        products = products.filter(p => p.id !== id);
        renderProducts();
        alert('Product deleted.');
      }
    }

    // Initial render
    renderProducts();
  </script>
</body>
</html>