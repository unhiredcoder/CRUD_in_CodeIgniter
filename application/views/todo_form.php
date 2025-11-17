<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Task</title>
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
      display: flex;
      align-items: center;
      padding: 20px 0;
    }
    
    .form-container {
      max-width: 600px;
      margin: 0 auto;
      width: 100%;
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
    
    .form-card {
      background: white;
      border-radius: 16px;
      padding: 30px;
      box-shadow: var(--shadow);
    }
    
    .form-control, .form-select {
      border-radius: 10px;
      border: 1px solid var(--border);
      padding: 12px 15px;
      transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    }
    
    .form-label {
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 8px;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
      border: none;
      border-radius: 10px;
      padding: 12px 30px;
      font-weight: 600;
      transition: all 0.3s ease;
      font-size: 1.1rem;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }
    
    .btn-secondary {
      background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }
    
    .error-message {
      display: flex;
      align-items: center;
      gap: 5px;
      margin-top: 5px;
    }
    
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--primary);
      text-decoration: none;
      font-weight: 500;
      margin-bottom: 20px;
      transition: all 0.3s ease;
    }
    
    .back-link:hover {
      color: var(--secondary);
      transform: translateX(-3px);
    }
    
    .form-header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 25px;
    }
    
    .form-header i {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-size: 1.8rem;
    }
    
    .form-header h2 {
      font-weight: 700;
      color: var(--dark);
      margin: 0;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <!-- Header Section -->
    <div class="header-section">
      <div class="d-flex justify-content-between align-items-center">
        <h1 class="app-title"><i class="fas fa-tasks"></i> Task Manager</h1>
        <a href="<?= site_url('todo/index') ?>" class="btn btn-light btn-lg shadow-sm">
          <i class="fas fa-arrow-left me-2"></i>Back to Tasks
        </a>
      </div>
    </div>
    
    <!-- Form Card -->
    <div class="form-card">
      <a href="<?= site_url('todo/index') ?>" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Task List
      </a>
      
      <div class="form-header">
        <i class="fas fa-plus-circle"></i>
        <h2>Add New Task</h2>
      </div>

      <?php echo form_open('todo/create'); ?>

        <!-- Title field -->
        <div class="mb-4">
          <label for="title" class="form-label">
            <i class="fas fa-heading me-2"></i>Task Title
          </label>
          <input type="text" name="title" class="form-control" value="<?php echo set_value('title'); ?>" placeholder="Enter task title...">
          <!-- Error message for title -->
          <?php if (form_error('title')): ?>
            <div class="error-message text-danger">
              <i class="fas fa-exclamation-circle"></i>
              <?php echo form_error('title'); ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- Description field -->
        <div class="mb-4">
          <label for="description" class="form-label">
            <i class="fas fa-align-left me-2"></i>Description
          </label>
          <textarea name="description" class="form-control" rows="5" placeholder="Enter task description..."><?php echo set_value('description'); ?></textarea>
          <!-- Error message for description -->
          <?php if (form_error('description')): ?>
            <div class="error-message text-danger">
              <i class="fas fa-exclamation-circle"></i>
              <?php echo form_error('description'); ?>
            </div>
          <?php endif; ?>
        </div>

        <div class="d-flex gap-3 mt-4">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Save Task
          </button>
          <a href="<?= site_url('todo/index') ?>" class="btn btn-secondary">
            <i class="fas fa-times me-2"></i>Cancel
          </a>
        </div>

      <?php echo form_close(); ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>