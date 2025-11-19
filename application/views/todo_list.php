<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Modern To-Do List</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link href="http://localhost/adityaMVC/assets/style.css" rel="stylesheet">
   </head>
   <body class="bg-light">
      <div class="app-container">
         <!-- Header Section -->
         <div class="header-section">
            <div class="d-flex justify-content-between align-items-center">
               <h1 class="app-title"><i class="fas fa-book"></i>Task Manager</h1>
               <button type="button" class="btn btn-light btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#addTaskModal">
               <i class="fas fa-plus-circle me-2"></i>Add New Task
               </button>
            </div>
         </div>
         <!-- Filter & Search Section -->
         <div class="filter-section">
            <div class="row g-3">
               <div class="col-md-6">
                  <form method="get" action="<?php echo site_url('todo/index'); ?>">
                     <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="q" class="form-control" placeholder="Search tasks..."
                           value="<?php echo isset($search) ? $search : ''; ?>">
                        <?php if (!empty($status)): ?>
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                        <?php endif; ?>
                        <button class="btn btn-primary" type="submit">Search</button>
                     </div>
                  </form>
               </div>
               <div class="col-md-6">
                  <form method="get" action="<?= site_url('todo/index') ?>">
                     <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-filter text-muted"></i></span>
                        <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                           <option value="">All Tasks</option>
                           <option value="pending" <?= isset($status) && $status=='pending'?'selected':'' ?>>Pending</option>
                           <option value="completed" <?= isset($status) && $status=='completed'?'selected':'' ?>>Completed</option>
                        </select>
                     </div>
                  </form>
               </div>
            </div>
            <br/>
            <div class="csv-upload fade-in">
               <h5><i class="fas fa-file-csv me-2"></i>Import Tasks from CSV</h5>
               <form method="post" enctype="multipart/form-data" action="<?php echo site_url('todo/import_csv'); ?>">
                  <div class="input-group">
                     <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                     <button type="submit" class="btn btn-success">
                     <i class="fas fa-upload me-1"></i>Upload CSV
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Bulk Actions Section -->
      <div class="bulk-actions-section mb-3 mx-5">
         <div class="d-flex justify-content-between align-items-center">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" id="selectAll">
               <label class="form-check-label" for="selectAll">
               Select All
               </label>
            </div>
            <div>
               <span id="selectedCount" class="badge bg-primary me-2" style="display: none;">0 selected</span>
               <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn" disabled>
               <i class="fas fa-trash me-1"></i>Delete Selected
               </button>
            </div>
         </div>
      </div>
      <!-- Tasks List -->
      <div class="tasks-container mx-5" style="max-height: 400px">
         <?php if (!empty($todos)): ?>
         <ul class="list-unstyled mb-0">
            <?php foreach ($todos as $todo): ?> 
            <li class="task-item">
               <!-- Add this checkbox at the beginning of task item -->
               <div class="me-3">
                  <input type="checkbox" class="form-check-input task-checkbox" value="<?= $todo->id ?>">
               </div>
               <div class="task-content">
                  <div class="task-title"><?= htmlspecialchars($todo->title) ?></div>
                  <div>
                     <span class="task-status status-<?= htmlspecialchars($todo->status) ?> me-3">
                     <i class="fas fa-<?= $todo->status === 'completed' ? 'check-circle' : 'clock' ?> me-1"></i>
                     <?= ucfirst(htmlspecialchars($todo->status)) ?>
                     </span>
                     <!-- Created Date with exact timestamp -->
                     <small class="text-muted">
                     <i class="far fa-calendar me-1"></i>
                     Created At <?= date('d M Y, H:i', strtotime($todo->created_at)) ?>
                     </small>
                  </div>
                  <!-- Task Description -->
                  <div class="text-muted small mt-2 mb-0">
                     <?= htmlspecialchars($todo->description) ?>
                  </div>
               </div>
               <div class="task-actions">
                  <button class="btn btn-success btn-sm edit-task-btn" 
                     data-id="<?= $todo->id ?>"
                     data-title="<?= htmlspecialchars($todo->title) ?>"
                     data-description="<?= htmlspecialchars($todo->description) ?>"
                     data-status="<?= $todo->status ?>">
                  <i class="fas fa-edit me-1"></i>Edit
                  </button>
                  <a href="<?= site_url('todo/delete/'.$todo->id) ?>" 
                     class="btn btn-danger btn-sm"
                     onclick="return confirm('Are you sure you want to delete this task?');">
                  <i class="fas fa-trash me-1"></i>Delete
                  </a>
               </div>
            </li>
            <?php endforeach; ?>
         </ul>
         <?php else: ?>
         <div class="empty-state">
            <i class="fas fa-clipboard-list"></i>
            <h4>No tasks found</h4>
            <p>Get started by creating your first task!</p>
         </div>
         <?php endif; ?>
      </div>
      <!-- Pagination -->
      <?php if (!empty($todos) && isset($pagination_links)): ?>
      <div class="pagination-container">
         <?= $pagination_links ?>
      </div>
      <?php endif; ?>
      </div>
      <!-- Add Task Modal -->
      <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="addTaskModalLabel">
                     <i class="fas fa-plus-circle"></i>Add New Task
                  </h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <form method="POST" action="<?= site_url('todo/create') ?>">
                  <div class="modal-body">
                     <!-- Title -->
                     <div class="mb-4">
                        <label for="addTitle" class="form-label">
                        <i class="fas fa-heading me-2"></i>Task Title
                        </label>
                        <input type="text" name="title" id="addTitle" class="form-control" placeholder="Enter task title" required autofocus>
                        <small class="text-danger"><?= form_error('title'); ?></small>
                     </div>
                     <!-- Description -->
                     <div class="mb-2">
                        <label for="addDescription" class="form-label">
                        <i class="fas fa-align-left me-2"></i>Description
                        </label>
                        <textarea name="description" id="addDescription" rows="5" class="form-control" placeholder="Enter task details"></textarea>
                        <small class="text-danger"><?= form_error('description'); ?></small>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                     <i class="fas fa-times me-2"></i>Cancel
                     </button>
                     <button type="submit" class="btn btn-primary">
                     <i class="fas fa-save me-2"></i>Create Task
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Toast  -->
      <div class="toast-container">
         <?php if($this->session->flashdata('success')): ?>
         <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
               <i class="fas fa-check-circle text-success me-2"></i>
               <strong class="me-auto">Success</strong>
               <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
               <?= $this->session->flashdata('success'); ?>
            </div>
         </div>
         <?php endif; ?>
      </div>
      <!-- Edit Task Modal -->
      <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="editTaskModalLabel">
                     <i class="fas fa-edit"></i>Edit Task
                  </h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <form id="editTaskForm" method="POST" action="">
                  <div class="modal-body">
                     <!-- Status Indicator -->
                     <div class="mb-3">
                        <span class="status-indicator status-pending" id="modalStatusIndicator">
                        <i class="fas fa-clock"></i>
                        <span id="modalStatusText">Pending</span>
                        </span>
                     </div>
                     <!-- Title -->
                     <div class="mb-4">
                        <label for="editTitle" class="form-label">
                        <i class="fas fa-heading me-2"></i>Task Title
                        </label>
                        <input type="text" name="title" id="editTitle" class="form-control" placeholder="Enter task title" required>
                     </div>
                     <!-- Description -->
                     <div class="mb-4">
                        <label for="editDescription" class="form-label">
                        <i class="fas fa-align-left me-2"></i>Description
                        </label>
                        <textarea name="description" id="editDescription" rows="5" class="form-control" placeholder="Enter task details"></textarea>
                     </div>
                     <!-- Status -->
                     <div class="mb-4">
                        <label for="editStatus" class="form-label">
                        <i class="fas fa-tasks me-2"></i>Status
                        </label>
                        <select name="status" id="editStatus" class="form-select">
                           <option value="pending">Pending</option>
                           <option value="completed">Completed</option>
                        </select>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                     <i class="fas fa-times me-2"></i>Cancel
                     </button>
                     <button type="submit" class="btn btn-primary">
                     <i class="fas fa-save me-2"></i>Update Task
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
      <script>
         document.addEventListener('DOMContentLoaded', function() {
           const editTaskModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
           const addTaskModal = new bootstrap.Modal(document.getElementById('addTaskModal'));
           const editTaskForm = document.getElementById('editTaskForm');
           const modalStatusIndicator = document.getElementById('modalStatusIndicator');
           const modalStatusText = document.getElementById('modalStatusText');
           
           // Edit task button click handler
           document.querySelectorAll('.edit-task-btn').forEach(button => {
             button.addEventListener('click', function() {
               const taskId = this.getAttribute('data-id');
               const taskTitle = this.getAttribute('data-title');
               const taskDescription = this.getAttribute('data-description');
               const taskStatus = this.getAttribute('data-status');
               
               // Populate form fields
               document.getElementById('editTitle').value = taskTitle;
               document.getElementById('editDescription').value = taskDescription;
               document.getElementById('editStatus').value = taskStatus;
               
               // Update form action
               editTaskForm.action = '<?= site_url('todo/update/') ?>' + taskId;
               
               // Update status indicator
               updateStatusIndicator(taskStatus);
               
               // Show modal
               editTaskModal.show();
             });
           });
           
           // Status change handler for edit modal
           document.getElementById('editStatus').addEventListener('change', function() {
             updateStatusIndicator(this.value);
           });
           
           function updateStatusIndicator(status) {
             modalStatusIndicator.className = 'status-indicator status-' + status;
             modalStatusText.textContent = status.charAt(0).toUpperCase() + status.slice(1);
             
             const icon = modalStatusIndicator.querySelector('i');
             if (status === 'completed') {
               icon.className = 'fas fa-check-circle';
             } else {
               icon.className = 'fas fa-clock';
             }
           }
           
           // Clear add modal when it's closed
           document.getElementById('addTaskModal').addEventListener('hidden.bs.modal', function () {
             document.getElementById('addTitle').value = '';
             document.getElementById('addDescription').value = '';
             document.getElementById('addStatus').value = 'pending';
           });
           
           // Form submission handlers (optional: you can add AJAX here)
           editTaskForm.addEventListener('submit', function(e) {
             // You can add AJAX submission here if you want to avoid page reload
             // For now, it will submit normally and reload the page
           });
           
           // Auto-focus on title field when add modal opens
           document.getElementById('addTaskModal').addEventListener('shown.bs.modal', function () {
             document.getElementById('addTitle').focus();
           });  document.getElementById('editTaskModal').addEventListener('shown.bs.modal', function () {
             document.getElementById('editTitle').focus();
           });
         
           //For Toast autoclose 
         
           const toastEl = document.querySelector('.toast');
           if (toastEl) {
           const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
           toast.show();
         }
         
         });
         
         // Bulk Delete Functionality
         document.addEventListener('DOMContentLoaded', function() {
         const selectAllCheckbox = document.getElementById('selectAll');
         const taskCheckboxes = document.querySelectorAll('.task-checkbox');
         const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
         const selectedCount = document.getElementById('selectedCount');
         
         // Select All functionality
         selectAllCheckbox.addEventListener('change', function() {
             const isChecked = this.checked;
             taskCheckboxes.forEach(checkbox => {
                 checkbox.checked = isChecked;
             });
             updateBulkDeleteUI();
         });
         
         // Individual checkbox change
         taskCheckboxes.forEach(checkbox => {
             checkbox.addEventListener('change', function() {
                 updateBulkDeleteUI();
                 updateSelectAllCheckbox();
             });
         });
         
         function updateBulkDeleteUI() {
             const selectedTasks = document.querySelectorAll('.task-checkbox:checked');
             const count = selectedTasks.length;
             
             if (count > 0) {
                 selectedCount.textContent = count + ' selected';
                 selectedCount.style.display = 'inline-block';
                 bulkDeleteBtn.disabled = false;
             } else {
                 selectedCount.style.display = 'none';
                 bulkDeleteBtn.disabled = true;
             }
         }
         
         function updateSelectAllCheckbox() {
             const totalCheckboxes = taskCheckboxes.length;
             const checkedCheckboxes = document.querySelectorAll('.task-checkbox:checked').length;
             selectAllCheckbox.checked = totalCheckboxes > 0 && totalCheckboxes === checkedCheckboxes;
             selectAllCheckbox.indeterminate = checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
         }
         
         // Bulk Delete Button Click
         bulkDeleteBtn.addEventListener('click', function() {
             const selectedIds = Array.from(document.querySelectorAll('.task-checkbox:checked'))
                 .map(checkbox => checkbox.value);
             
             if (selectedIds.length === 0) {
                 alert('Please select at least one task to delete.');
                 return;
             }
         
             if (confirm('Are you sure you want to delete ' + selectedIds.length + ' selected task(s)?')) {
                 // Create form and submit
                 const form = document.createElement('form');
                 form.method = 'POST';
                 form.action = '<?= site_url('todo/bulk_delete') ?>';
                 
                 // Add CSRF token if you're using it
                 const csrfInput = document.createElement('input');
                 csrfInput.type = 'hidden';
                 csrfInput.name = '<?= $this->security->get_csrf_token_name() ?>';
                 csrfInput.value = '<?= $this->security->get_csrf_hash() ?>';
                 form.appendChild(csrfInput);
         
                 // Add selected IDs
                 selectedIds.forEach(id => {
                     const input = document.createElement('input');
                     input.type = 'hidden';
                     input.name = 'task_ids[]';
                     input.value = id;
                     form.appendChild(input);
                 });
         
                 document.body.appendChild(form);
                 form.submit();
             }
         });
         });
         
         
      </script>
      <?php if(isset($show_add_modal) && $show_add_modal): ?>
      <script>
         document.addEventListener("DOMContentLoaded", function() {
           var myModal = new bootstrap.Modal(document.getElementById('addTaskModal'));
           myModal.show();
         });
      </script>
      <?php endif; ?>
   </body>
</html>