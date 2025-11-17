<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modern To-Do List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --primary-light: #4895ef;
      --secondary: #3f37c9;
      --success: #4cc9f0;
      --danger: #f72585;
      --light: #f8f9fa;
      --dark: #212529;
      --gray: #6c757d;
      --border: #e9ecef;
      --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      --card-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      padding: 20px 0;
    }
    
    .app-container {
      max-width: 800px;
      margin: 0 auto;
    }
    
    .header-section {
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      color: white;
      border-radius: 16px;
      padding: 25px 30px;
      margin-bottom: 30px;
      box-shadow: var(--shadow);
    }
    
    .app-title {
      font-weight: 700;
      font-size: 2.2rem;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .filter-section {
      background: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: var(--card-shadow);
    }
    
    .form-control, .form-select {
      padding: 10px 15px;
      transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: none !important;
      box-shadow: none !important;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .btn-success {
      background: linear-gradient(135deg, var(--success) 0%, #3a86ff 100%);
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(76, 201, 240, 0.3);
    }
    
    .btn-danger {
      background: linear-gradient(135deg, var(--danger) 0%, #b5179e 100%);
      border: none;
      border-radius: 8px;
      padding: 8px 16px;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .btn-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(247, 37, 133, 0.3);
    }
    
    .tasks-container {
      background: white;
      border-radius: 12px;
      box-shadow: var(--card-shadow);
      overflow: hidden;
      max-height: 500px;
      overflow-y: auto;
    }
    
    .task-item {
      padding: 20px;
      border-bottom: 1px solid var(--border);
      transition: all 0.3s ease;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }
    
    .task-item:hover {
      background-color: #f8fafc;
    }
    
    .task-item:last-child {
      border-bottom: none;
    }
    
    .task-content {
      flex: 1;
      padding-right: 20px;
    }
    
    .task-title {
      font-weight: 600;
      font-size: 1.1rem;
      margin-bottom: 5px;
      color: var(--dark);
    }
    
    .task-status {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
    }
    
    .status-pending {
      background-color: #fff3cd;
      color: #856404;
    }
    
    .status-completed {
      background-color: #d1edff;
      color: #0c5460;
    }
    
    .task-actions {
      display: flex;
      flex-direction: column;
      gap: 10px;
      min-width: 120px;
    }
    
    .empty-state {
      text-align: center;
      padding: 40px 20px;
      color: var(--gray);
    }
    
    .empty-state i {
      font-size: 3rem;
      margin-bottom: 15px;
      color: #dee2e6;
    }
    
    .pagination-container {
      margin-top: 30px;
      display: flex;
      justify-content: center;
    }
    
    .page-item.active .page-link {
      background-color: var(--primary);
      border-color: var(--primary);
    }
    
    .page-link {
      color: var(--primary);
      border-radius: 8px;
      margin: 0 3px;
      border: 1px solid var(--border);
    }
    
    .stats-container {
      display: flex;
      gap: 15px;
      margin-bottom: 20px;
    }
    
    .stat-card {
      background: white;
      border-radius: 10px;
      padding: 15px;
      flex: 1;
      text-align: center;
      box-shadow: var(--card-shadow);
    }
    
    .stat-value {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 5px;
    }
    
    .stat-label {
      font-size: 0.9rem;
      color: var(--gray);
    }
    
    /* Modal Styles */
    .modal-content {
      border-radius: 16px;
      border: none;
      box-shadow: var(--shadow);
    }
    
    .modal-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      color: white;
      border-radius: 16px 16px 0 0;
      padding: 20px 25px;
      border-bottom: none;
    }
    
    .modal-title {
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .modal-body {
      padding: 25px;
    }
    
    .modal-footer {
      border-top: 1px solid var(--border);
      padding: 20px 25px;
      border-radius: 0 0 16px 16px;
    }
    
    .status-indicator {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
      margin-left: 10px;
    }
    
    .status-pending {
      background-color: #fff3cd;
      color: #856404;
    }
    
    .status-completed {
      background-color: #d1edff;
      color: #0c5460;
    }
    
    /* Responsive adjustments */
    @media (max-width: 576px) {
      .task-item {
        flex-direction: column;
      }
      
      .task-actions {
        flex-direction: row;
        justify-content: flex-end;
        width: 100%;
        margin-top: 15px;
        min-width: auto;
      }
      
      .task-content {
        padding-right: 0;
      }
    }
  </style>
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
    </div>
    
    <!-- Tasks List -->
    <div class="tasks-container" style="max-height: 400px">
      <?php if (!empty($todos)): ?>
        <ul class="list-unstyled mb-0">
          <?php foreach ($todos as $todo): ?> 
            <li class="task-item">
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
            </div>

            <!-- Description -->
            <div class="mb-2">
              <label for="addDescription" class="form-label">
                <i class="fas fa-align-left me-2"></i>Description
              </label>
              <textarea name="description" id="addDescription" rows="5" class="form-control" placeholder="Enter task details"></textarea>
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
      });
    });
  </script>
</body>
</html>