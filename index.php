<?php
include 'connect.php';

// READ: fetch all products
$result = $conn->query("SELECT * FROM products ORDER BY id");
$products = [];
while ($row = $result->fetch_assoc()) {
  $products[] = $row;
}

$activeTab  = $_GET['tab']     ?? 'all';
$successMsg = $_GET['success'] ?? '';
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cookie &amp; Co.</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif
    }

    body {
      background: #fff
    }

    /* NAVBAR */
    .navbar {
      display: flex;
      align-items: center;
      padding: 15px 8%;
      background: #3b5b8a;
      position: sticky;
      top: 0;
      z-index: 1000
    }

    .logo {
      font-weight: 700;
      font-size: 22px;
      color: #ffebaf
    }

    /* HERO */
    .hero {
      height: 70vh;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      padding: 0 8%;
      background: #d0e2f2
    }

    .hero-slides {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      transition: transform 1s cubic-bezier(.77, 0, .175, 1)
    }

    .slide {
      min-width: 100%;
      height: 100%;
      flex-shrink: 0;
      overflow: hidden
    }

    .slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 1.5s ease
    }

    /* BENTO */
    .bento {
      position: relative;
      padding: 65px 2% 30px 2%;
      background: #d0e2f2
    }

    .bento-bg-shape {
      position: absolute;
      top: 45px;
      left: 10px;
      right: 10px;
      bottom: 10px;
      background: #fff4bb;
      border-radius: 25px;
      border: 2px solid black;
      z-index: 0;
      box-shadow: 0 5px 20px rgba(0, 0, 0, .1)
    }

    .bento-grid {
      position: relative;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      grid-auto-rows: minmax(150px, 1fr);
      gap: 20px;
      z-index: 1
    }

    .bento-item {
      border: 1px solid #333;
      border-radius: 25px;
      overflow: hidden;
      position: relative
    }

    .bento-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 20px;
      display: block
    }

    /* TABS */
    .india {
      padding: 30px 8%;
      background: #d0e2f2
    }

    .india-tabs {
      display: flex;
      gap: 15px;
      justify-content: center;
      margin-bottom: 25px;
      flex-wrap: wrap
    }

    .india-tabs .tab {
      padding: 10px 25px;
      border: none;
      border-radius: 25px;
      background: #f0f0f0;
      color: #333;
      font-weight: 600;
      cursor: pointer;
      transition: .3s
    }

    .india-tabs .tab.active {
      background: #3b5b8a;
      color: #fff
    }

    .india-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px
    }

    .india-card {
      background: #fff;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
      transition: all .3s ease;
      cursor: pointer
    }

    .india-card:hover {
      transform: translateY(-10px) scale(1.03);
      box-shadow: 0 15px 30px rgba(0, 0, 0, .2)
    }

    .india-card img {
      width: 100%;
      aspect-ratio: 1/1;
      object-fit: contain;
      object-position: center top;
      display: block
    }

    .india-card p {
      padding: 10px;
      font-weight: 500;
      text-align: center;
      min-height: 60px
    }

    .india-card:hover p {
      color: #3b5b8a
    }

    .india-grid-2 {
      padding: 20px;
      gap: 25px
    }

    /* LISTS TABLE */
    .lists-table {
      display: none;
      padding: 10px 8% 40px;
      background: #d0e2f2
    }

    .lists-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px
    }

    .lists-header h2 {
      color: #3b5b8a
    }

    .btn-add {
      padding: 10px 22px;
      background: #3b5b8a;
      color: #fff;
      border: none;
      border-radius: 25px;
      font-weight: 600;
      cursor: pointer;
      font-size: 14px;
      transition: .2s
    }

    .btn-add:hover {
      background: #2a4570
    }

    .lists-table table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, .1)
    }

    .lists-table th,
    .lists-table td {
      padding: 14px 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
      vertical-align: middle
    }

    .lists-table th {
      background: #3b5b8a;
      color: #fff
    }

    .lists-table tr:last-child td {
      border-bottom: none
    }

    .lists-table tr:hover td {
      background: #f7faff
    }

    .action-btns {
      display: flex;
      gap: 8px;
      white-space: nowrap
    }

    .btn-edit {
      padding: 7px 16px;
      background: #f0a500;
      color: #fff;
      border: none;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: .2s
    }

    .btn-edit:hover {
      background: #d49000
    }

    .btn-delete {
      padding: 7px 16px;
      background: #e03535;
      color: #fff;
      border: none;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: .2s
    }

    .btn-delete:hover {
      background: #b52020
    }

    /* SUCCESS BANNER */
    .success-banner {
      display: none;
      margin-bottom: 18px;
      padding: 12px 20px;
      background: #d4edda;
      color: #155724;
      border-radius: 10px;
      font-weight: 600;
      border: 1px solid #c3e6cb
    }

    /* MODALS */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, .55);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 3000
    }

    .modal-box {
      background: #fff;
      padding: 35px 40px;
      border-radius: 18px;
      width: 500px;
      max-width: 94%;
      position: relative;
      box-shadow: 0 20px 60px rgba(0, 0, 0, .25)
    }

    .modal-box h3 {
      margin-bottom: 22px;
      color: #3b5b8a;
      font-size: 22px
    }

    .modal-close {
      position: absolute;
      top: 12px;
      right: 18px;
      font-size: 24px;
      cursor: pointer;
      color: #666
    }

    .modal-close:hover {
      color: #333
    }

    .form-group {
      margin-bottom: 16px
    }

    .form-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 6px;
      font-size: 14px;
      color: #444
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 10px 14px;
      border: 1.5px solid #ddd;
      border-radius: 10px;
      font-size: 14px;
      font-family: "Poppins", sans-serif;
      transition: .2s
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: #3b5b8a
    }

    .form-group textarea {
      resize: vertical;
      min-height: 80px
    }

    .form-row {
      display: flex;
      gap: 14px
    }

    .form-row .form-group {
      flex: 1
    }

    .modal-actions {
      display: flex;
      gap: 12px;
      margin-top: 22px;
      justify-content: flex-end
    }

    .btn-cancel {
      padding: 10px 22px;
      background: #eee;
      color: #555;
      border: none;
      border-radius: 20px;
      font-weight: 600;
      cursor: pointer
    }

    .btn-cancel:hover {
      background: #ddd
    }

    .btn-save {
      padding: 10px 28px;
      background: #3b5b8a;
      color: #fff;
      border: none;
      border-radius: 20px;
      font-weight: 600;
      cursor: pointer
    }

    .btn-save:hover {
      background: #2a4570
    }

    .confirm-text {
      margin-bottom: 20px;
      color: #444;
      line-height: 1.6
    }

    .btn-confirm-delete {
      padding: 10px 28px;
      background: #e03535;
      color: #fff;
      border: none;
      border-radius: 20px;
      font-weight: 600;
      cursor: pointer
    }

    .btn-confirm-delete:hover {
      background: #b52020
    }

    /* PRODUCT POPUP */
    .popup {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, .6);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 2000
    }

    .popup-content {
      background: #fff;
      padding: 20px;
      border-radius: 15px;
      width: 900px;
      max-width: 90%;
      height: 400px;
      position: relative;
      display: flex;
      align-items: center
    }

    .popup-inner {
      display: flex;
      gap: 20px;
      align-items: flex-start;
      width: 100%
    }

    .popup-inner img {
      width: 350px;
      height: 350px;
      object-fit: cover;
      border-radius: 15px
    }

    .popup-text {
      position: absolute;
      top: 80px;
      left: 360px;
      width: 500px;
      display: flex;
      flex-direction: column
    }

    .popup-text h3 {
      font-size: 40px;
      margin: 0 0 8px 0
    }

    .popup-text p {
      font-size: 16px;
      color: #333;
      margin: 0;
      word-wrap: break-word
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 25px;
      cursor: pointer;
      z-index: 10
    }

    /* FOOTER */
    .footer {
      background: #3b5b8a;
      color: #ffebaf;
      padding: 40px 8%
    }

    .footer-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px
    }

    .footer input {
      padding: 10px;
      border: none;
      border-radius: 20px;
      width: 100%
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <div class="navbar">
    <div class="logo">Cookie &amp; Co.</div>
  </div>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-slides">
      <div class="slide"><img src="images/bg-2.png" alt="" /></div>
      <div class="slide"><img src="images/bg-3.png" alt="" /></div>
      <div class="slide"><img src="images/bg-4.png" alt="" /></div>
    </div>
  </section>

  <!-- BENTO -->
  <section class="bento">
    <div class="bento-bg-shape"></div>
    <div class="bento-grid">
      <div class="bento-item blue" style="grid-column:span 2;grid-row:span 2"><img src="images/bento-big1.png" alt="" /></div>
      <div class="bento-item" style="grid-column:span 2;grid-row:span 1"><img src="images/bento-lang2.png" alt="" /></div>
      <div class="bento-item" style="grid-column:span 1;grid-row:span 2"><img src="images/bento-box1.png" alt="" /></div>
      <div class="bento-item" style="grid-column:span 1;grid-row:span 1"><img src="images/bento-small2.png" alt="" /></div>
      <div class="bento-item" style="grid-column:span 2;grid-row:span 1"><img src="images/bento-long1.png" alt="" /></div>
      <div class="bento-item" style="grid-column:span 1;grid-row:span 1"><img src="images/bento-small1.png" alt="" /></div>
    </div>
  </section>

  <!-- TABS + PRODUCT CARDS -->
  <section class="india">
    <div class="india-tabs">
      <button class="tab <?= $activeTab === 'all'      ? 'active' : '' ?>" data-category="all">All</button>
      <button class="tab <?= $activeTab === 'list'     ? 'active' : '' ?>" data-category="list">Lists</button>
      <button class="tab <?= $activeTab === 'cookies'  ? 'active' : '' ?>" data-category="cookies">Cookies</button>
      <button class="tab <?= $activeTab === 'brownies' ? 'active' : '' ?>" data-category="brownies">Brownies</button>
      <button class="tab <?= $activeTab === 'cakes'    ? 'active' : '' ?>" data-category="cakes">Cakes</button>
    </div>

    <?php
    $imgMap = [
      'Chocolate Chip Cookie'         => 'images/cookie-2.png',
      'Double Chocolate Cookie'       => 'images/doublechoco-cookie.png',
      'Oat Chocolate Walnut Cookie'   => 'images/oatchocowalnut-cookie.png',
      'White Macadamia Cookie'        => 'images/whitemaca-cookie.png',
      'Pistachio Cookie'              => 'images/pistachio-cookie.png',
      'Birthday Cake Cookie'          => 'images/birthdaycake-cookie.png',
      'Red Velvet Cookie'             => 'images/redvelvet-cookie.png',
      'White Chocolate Matcha Cookie' => 'images/whitechocomatcha-cookie.png',
      'Chocolate Fudge Brownies'      => 'images/fudge-brownies.png',
      'Biscoff Brownies'              => 'images/biscoff-brownie.png',
      'Red Velvet Brownies'           => 'images/redvelvetbrownie.png',
      'Chocolate Cheesecake Brownies' => 'images/chococheesecake-brownie.png',
      'Chocolate Cake'                => 'images/chocolate-cake.png',
      'Matcha Cake'                   => 'images/matcha-cake.png',
      'Strawberry Shortcake'          => 'images/strawberry-shortcake.png',
    ];
    ?>

    <div class="india-grid india-grid-2" id="productGrid" style="<?= $activeTab === 'list' ? 'display:none' : '' ?>">
      <?php foreach ($products as $p):
        $img = $imgMap[$p['name']] ?? 'images/placeholder.png';
        $cat = strtolower($p['category']);
      ?>
        <div class="india-card"
          data-category="<?= htmlspecialchars($cat) ?>"
          data-name="<?= htmlspecialchars($p['name']) ?>"
          data-description="<?= htmlspecialchars($p['description']) ?>">
          <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p['name']) ?>" />
          <p><?= htmlspecialchars($p['name']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- LISTS TABLE (CRUD) -->
  <div class="lists-table" id="listsTable" style="<?= $activeTab === 'list' ? 'display:block' : '' ?>">

    <div class="lists-header">
      <h2>Product Lists</h2>
      <button class="btn-add" id="btnOpenAdd">+ Add Product</button>
    </div>

    <?php if ($successMsg): ?>
      <div class="success-banner" id="successBanner" style="display:block">
        ✅ <?= htmlspecialchars($successMsg) ?>
      </div>
    <?php endif; ?>

    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Product Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $i => $p): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= htmlspecialchars($p['category']) ?></td>
            <td>₱<?= number_format((float)$p['price'], 2) ?></td>
            <td><?= htmlspecialchars($p['description']) ?></td>
            <td>
              <div class="action-btns">
                <button class="btn-edit"
                  data-id="<?= $p['id'] ?>"
                  data-name="<?= htmlspecialchars($p['name']) ?>"
                  data-category="<?= htmlspecialchars($p['category']) ?>"
                  data-price="<?= $p['price'] ?>"
                  data-description="<?= htmlspecialchars($p['description']) ?>">
                  ✏️ Edit
                </button>
                <button class="btn-delete"
                  data-id="<?= $p['id'] ?>"
                  data-name="<?= htmlspecialchars($p['name']) ?>">
                  🗑️ Delete
                </button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($products)): ?>
          <tr>
            <td colspan="6" style="text-align:center;color:#999;padding:30px">
              No products yet. Click "+ Add Product" to get started.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- ADD MODAL -->
  <div class="modal-overlay" id="addModal">
    <div class="modal-box">
      <span class="modal-close" id="closeAddModal">&times;</span>
      <h3>➕ Add New Product</h3>
      <form method="POST" action="productsCRUD.php">
        <input type="hidden" name="action" value="create" />
        <div class="form-group">
          <label>Product Name</label>
          <input type="text" name="name" placeholder="e.g. Lemon Tart Cookie" required />
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Category</label>
            <select name="category" required>
              <option value="">Select category...</option>
              <option value="Cookies">Cookies</option>
              <option value="Brownies">Brownies</option>
              <option value="Cakes">Cakes</option>
            </select>
          </div>
          <div class="form-group">
            <label>Price (₱)</label>
            <input type="number" name="price" placeholder="e.g. 145" min="1" step="0.01" required />
          </div>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" placeholder="Describe the product..." required></textarea>
        </div>
        <div class="modal-actions">
          <button type="button" class="btn-cancel" id="cancelAdd">Cancel</button>
          <button type="submit" class="btn-save">Add Product</button>
        </div>
      </form>
    </div>
  </div>

  <!-- EDIT MODAL -->
  <div class="modal-overlay" id="editModal">
    <div class="modal-box">
      <span class="modal-close" id="closeEditModal">&times;</span>
      <h3>✏️ Edit Product</h3>
      <form method="POST" action="productsCRUD.php">
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="id" id="editId" />
        <div class="form-group">
          <label>Product Name</label>
          <input type="text" name="name" id="editName" required />
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Category</label>
            <select name="category" id="editCategory" required>
              <option value="Cookies">Cookies</option>
              <option value="Brownies">Brownies</option>
              <option value="Cakes">Cakes</option>
            </select>
          </div>
          <div class="form-group">
            <label>Price (₱)</label>
            <input type="number" name="price" id="editPrice" min="1" step="0.01" required />
          </div>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" id="editDescription" required></textarea>
        </div>
        <div class="modal-actions">
          <button type="button" class="btn-cancel" id="cancelEdit">Cancel</button>
          <button type="submit" class="btn-save">Save Changes</button>
        </div>
      </form>
    </div>
  </div>

  <!-- DELETE CONFIRM MODAL -->
  <div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
      <span class="modal-close" id="closeDeleteModal">&times;</span>
      <h3>🗑️ Delete Product</h3>
      <p class="confirm-text">
        Are you sure you want to delete <strong id="deleteProductName"></strong>?<br />
        This action cannot be undone.
      </p>
      <form method="POST" action="productsCRUD.php">
        <input type="hidden" name="action" value="delete" />
        <input type="hidden" name="id" id="deleteId" />
        <div class="modal-actions">
          <button type="button" class="btn-cancel" id="cancelDelete">Cancel</button>
          <button type="submit" class="btn-confirm-delete">Yes, Delete</button>
        </div>
      </form>
    </div>
  </div>

  <!-- PRODUCT POPUP -->
  <div class="popup" id="popup">
    <div class="popup-content">
      <span class="close-btn" id="closeBtn">&times;</span>
      <div class="popup-inner">
        <img id="popupImage" src="" alt="Product Image" />
        <div class="popup-text">
          <h3 id="popupTitle">Product Name</h3>
          <p id="popupDescription">Description here.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <section class="footer">
    <div class="footer-grid">
      <div>
        <h3>Subscribe</h3><input placeholder="Enter email" />
      </div>
      <div>
        <h3>Know Us</h3>
        <p>About</p>
        <p>Contact</p>
        <p>Careers</p>
      </div>
      <div>
        <h3>Help</h3>
        <p>FAQ</p>
        <p>Policy</p>
      </div>
      <div>
        <h3>More</h3>
        <p>Offers</p>
        <p>App</p>
      </div>
    </div>
  </section>

  <script>

    // HERO SLIDER
    const slides = document.querySelectorAll('.slide');
    const heroSlides = document.querySelector('.hero-slides');
    let heroIndex = 0;

    function showSlide(index) {
      heroSlides.style.transform = `translateX(-${index * 100}%)`;
    }

    showSlide(heroIndex);

    setInterval(() => {
      heroIndex = (heroIndex + 1) % slides.length;
      showSlide(heroIndex);
    }, 5000);

    // TABS
    const tabs = document.querySelectorAll('.india-tabs .tab');
    const cards = document.querySelectorAll('.india-card');
    const listsTable = document.getElementById('listsTable');
    const productGrid = document.getElementById('productGrid');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        const cat = tab.dataset.category;
        if (cat === 'list') {
          listsTable.style.display = 'block';
          productGrid.style.display = 'none';
          return;
        }
        listsTable.style.display = 'none';
        productGrid.style.display = 'grid';
        cards.forEach(c => {
          c.style.display = (cat === 'all' || c.dataset.category === cat) ? 'block' : 'none';
        });
      });
    });

    // Auto-open Lists tab + dismiss banner
    (function() {
      const params = new URLSearchParams(window.location.search);
      if (params.get('tab') === 'list') document.querySelector('.tab[data-category="list"]').click();
      const banner = document.getElementById('successBanner');
      if (banner) setTimeout(() => banner.style.display = 'none', 3000);
    })();

    // ADD MODAL
    const addModal = document.getElementById('addModal');
    document.getElementById('btnOpenAdd').addEventListener('click', () => addModal.style.display = 'flex');
    ['closeAddModal', 'cancelAdd'].forEach(id => document.getElementById(id).addEventListener('click', () => addModal.style.display = 'none'));
    addModal.addEventListener('click', e => {
      if (e.target === addModal) addModal.style.display = 'none';
    });

    // EDIT MODAL
    const editModal = document.getElementById('editModal');
    document.querySelectorAll('.btn-edit').forEach(btn => {
      btn.addEventListener('click', () => {
        document.getElementById('editId').value = btn.dataset.id;
        document.getElementById('editName').value = btn.dataset.name;
        document.getElementById('editCategory').value = btn.dataset.category;
        document.getElementById('editPrice').value = btn.dataset.price;
        document.getElementById('editDescription').value = btn.dataset.description;
        editModal.style.display = 'flex';
      });
    });
    ['closeEditModal', 'cancelEdit'].forEach(id => document.getElementById(id).addEventListener('click', () => editModal.style.display = 'none'));
    editModal.addEventListener('click', e => {
      if (e.target === editModal) editModal.style.display = 'none';
    });

    // DELETE MODAL
    const deleteModal = document.getElementById('deleteModal');
    document.querySelectorAll('.btn-delete').forEach(btn => {
      btn.addEventListener('click', () => {
        document.getElementById('deleteId').value = btn.dataset.id;
        document.getElementById('deleteProductName').textContent = btn.dataset.name;
        deleteModal.style.display = 'flex';
      });
    });
    ['closeDeleteModal', 'cancelDelete'].forEach(id => document.getElementById(id).addEventListener('click', () => deleteModal.style.display = 'none'));
    deleteModal.addEventListener('click', e => {
      if (e.target === deleteModal) deleteModal.style.display = 'none';
    });

    // PRODUCT POPUP
    const popup = document.getElementById('popup');
    document.querySelectorAll('.india-card').forEach(card => {
      card.addEventListener('click', () => {
        document.getElementById('popupImage').src = card.querySelector('img').src;
        document.getElementById('popupTitle').textContent = card.dataset.name || card.querySelector('p').textContent;
        document.getElementById('popupDescription').textContent = card.dataset.description || 'No description available.';
        popup.style.display = 'flex';
      });
    });
    document.getElementById('closeBtn').addEventListener('click', () => popup.style.display = 'none');
    popup.addEventListener('click', e => {
      if (e.target === popup) popup.style.display = 'none';
    });
  </script>
</body>

</html>