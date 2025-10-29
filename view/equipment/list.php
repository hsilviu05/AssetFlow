<?php
require_once __DIR__ . '/../layout/header.php';
?>

<div class="container">
    <h2>Equipment Inventory</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="toast error-toast">
            <span><?php echo htmlspecialchars($_GET['error']); ?></span>
            <button onclick="this.parentElement.remove()">&times;</button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="toast success-toast">
            <span><?php echo htmlspecialchars($_GET['success']); ?></span>
            <button onclick="this.parentElement.remove()">&times;</button>
        </div>
    <?php endif; ?>
        <!-- Image Carousel -->
        <div class="carousel-container">
    <div class="carousel-slide active">
        <img src="/public/uploads/tech-loaded-workspace-stockcake.jpg" alt="Equipment 1">
    </div>
    <div class="carousel-slide">
        <img src="/public/uploads/tech-device-overload-stockcake.jpg" alt="Equipment 2">
    </div>
    <div class="carousel-slide">
        <img src="/public/uploads/technology-workspace-desk-stockcake.jpg" alt="Equipment 3">
    </div>
        <button class="carousel-btn prev" onclick="changeSlide(-1)">&#10094;</button> 
        <button class="carousel-btn next" onclick="changeSlide(1)">&#10095;</button>
    </div>
    
    <!-- Equipment Table -->
    <table class="equipment-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipment as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['equipment_id']); ?></td>
                <td>
                    <?php if (!empty($item['photo_path'])): ?>
                        <img src="../public/<?php echo htmlspecialchars($item['photo_path']); ?>" 
                             alt="<?php echo htmlspecialchars($item['name']); ?>" 
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; margin-right: 8px;">
                    <?php endif; ?>
                    <?php echo htmlspecialchars($item['name']); ?>
                </td>
                <td><?php echo htmlspecialchars($item['type_id']); ?></td>
                <td><span class="status-<?php echo strtolower($item['status']); ?>">
                    <?php echo htmlspecialchars($item['status']); ?>
                </span></td>
                <td>
                    <?php if ($item['status'] == 'Allocated' && ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'manager')): ?>
                        <?php
                        require_once __DIR__ . '/../../model/AllocationModel.php';
                        $allocationModel = new AllocationModel();
                        $allocations = $allocationModel->findAll();
                        $allocationId = null;
                        foreach ($allocations as $alloc) {
                            if ($alloc['equipment_id'] == $item['equipment_id']) {
                                $allocationId = $alloc['allocation_id'];
                                break;
                            }
                        }
                        ?>
                        <?php if ($allocationId): ?>
                            <a href="?controller=deallocate&id=<?php echo $allocationId; ?>" 
                               onclick="return confirm('Deallocate this equipment?')" 
                               style="color: #ffc107; margin-right: 10px;">Deallocate</a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($_SESSION['user_role'] == 'admin'): ?>
                        <a href="?controller=equipment&action=delete&id=<?php echo $item['equipment_id']; ?>" 
                           onclick="return confirm('Are you sure?')">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <a href="?controller=equipment&action=add" class="btn-add">Add Equipment</a>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

<script>
setTimeout(function() {
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(toast => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    });
}, 5000);
</script>
