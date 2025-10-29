<?php
require_once __DIR__ . '/../layout/header.php';
?>

<div class="container">
    <h2>Employees</h2>
    
    <a href="?controller=employee&action=add" class="btn-add">Add Employee</a>
    
    <table class="equipment-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $emp): ?>
            <tr>
                <td><?php echo htmlspecialchars($emp['employee_id']); ?></td>
                <td><?php echo htmlspecialchars($emp['full_name']); ?></td>
                <td><?php echo htmlspecialchars($emp['email']); ?></td>
                <td><?php echo htmlspecialchars($emp['department']); ?></td>
                <td><span class="status-<?php echo strtolower($emp['app_role']); ?>">
                    <?php echo htmlspecialchars($emp['app_role']); ?>
                </span></td>
                <td>
                    <a href="?controller=employee&action=delete&id=<?php echo $emp['employee_id']; ?>" 
                       onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

