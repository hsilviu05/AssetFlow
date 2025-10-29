<?php
require_once __DIR__ . '/../layout/header.php';
?>

<div class="container">
    <h2>Allocate Equipment</h2>
    
    <form method="POST" action="index.php?controller=allocation&action=allocate">
        <div class="form-group">
            <label>Select Equipment:</label>
            <select name="equipment_id" required>
                <option value="">-- Choose Equipment --</option>
                <?php foreach ($equipment as $item): ?>
                    <?php if ($item['status'] == 'Available'): ?>
                        <option value="<?php echo htmlspecialchars($item['equipment_id']); ?>">
                            <?php echo htmlspecialchars($item['name']); ?> 
                            (<?php echo htmlspecialchars($item['inventory_code']); ?>)
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <?php if (empty($equipment)): ?>
                <p style="color: orange;">No equipment available for allocation.</p>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label>Select Employee:</label>
            <select name="employee_id" required>
                <option value="">-- Choose Employee --</option>
                <?php foreach ($employees as $emp): ?>
                    <option value="<?php echo htmlspecialchars($emp['employee_id']); ?>">
                        <?php echo htmlspecialchars($emp['full_name']); ?> 
                        (<?php echo htmlspecialchars($emp['department']); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Allocation Date:</label>
            <input type="date" name="allocation_date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Estimated Return Date (Optional):</label>
            <input type="date" name="estimated_return_date">
        </div>
        
        <div class="form-group">
            <label>Notes:</label>
            <textarea name="notes" placeholder="Additional notes about this allocation..."></textarea>
        </div>
        
        <input type="hidden" name="admin_id" value="<?php echo $_SESSION['user_id']; ?>">
        
        <button type="submit">Allocate Equipment</button>
        <a href="index.php?controller=equipment&action=list" class="btn-cancel">Cancel</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

<style>
.btn-cancel {
    background-color: #6c757d;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    margin-left: 1rem;
}

.btn-cancel:hover {
    background-color: #5a6268;
}
</style>
