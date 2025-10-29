<?php
require_once __DIR__ . '/../layout/header.php';
?>

<div class="container">
    <h2>Add New Equipment</h2>
    
    <form method="POST" action="index.php?controller=equipment&action=add" enctype="multipart/form-data">
        <div class="form-group">
            <label>Inventory Code:</label>
            <input type="text" name="inventory_code" required>
        </div>
        
        <div class="form-group">
            <label>Equipment Name:</label>
            <input type="text" name="name" required>
        </div>
        
        <div class="form-group">
            <label>Type ID:</label>
            <input type="number" name="type_id" required>
        </div>
        
        <div class="form-group">
            <label>Specifications:</label>
            <textarea name="specifications"></textarea>
        </div>
        
        <div class="form-group">
            <label>Status:</label>
            <select name="status" required>
                <option value="Available">Available</option>
                <option value="Allocated">Allocated</option>
                <option value="Service">Service</option>
                <option value="Decommissioned">Decommissioned</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Purchase Date:</label>
            <input type="date" name="purchase_date" required>
        </div>
        
        <div class="form-group">
            <label>OS Version:</label>
            <input type="text" name="os_version" required>
        </div>
        
        <div class="form-group">
            <label>Location:</label>
            <input type="text" name="location" required>
        </div>
        
        <div class="form-group">
            <label>Photo:</label>
            <input type="file" name="photo" accept="image/*">
            <small>Upload a photo of the equipment (optional)</small>
        </div>
        
        <button type="submit">Add Equipment</button>
        <a href="index.php?controller=equipment&action=list">Cancel</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>