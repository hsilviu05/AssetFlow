<?php
require_once __DIR__ . '/../layout/header.php';
?>

<div class="container">
    <h2>Add New Employee</h2>
    
    <form method="POST" action="index.php?controller=employee&action=add">
        <div class="form-group">
            <label>Full Name:</label>
            <input type="text" name="full_name" required>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label>Department:</label>
            <input type="text" name="department" required>
        </div>
        
        <div class="form-group">
            <label>Role:</label>
            <select name="app_role" required>
                <option value="employee">Employee</option>
                <option value="manager">Manager</option>
                <option value="admin">Admin</option>
                <option value="it_manager">IT Manager</option>
            </select>
        </div>
        
        <button type="submit">Add Employee</button>
        <a href="index.php?controller=employee&action=list" class="btn-cancel">Cancel</a>
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
</style>

