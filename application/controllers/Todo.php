<?php
class Todo extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Todo_model');
    $this->load->helper(['form', 'url']);
    $this->load->library(['form_validation', 'pagination']);
  }

public function index()
{
    $this->load->library('pagination');

    // Get filter from query string
    $status = $this->input->get('status');
    $search = $this->input->get('q'); // new search parameter

    // Pagination config
    $config['base_url'] = site_url('todo/index');
    $config['total_rows'] = $this->Todo_model->count_todos($status, $search);
    $config['per_page'] = 5;
    $config['uri_segment'] = 3;
    $config['reuse_query_string'] = TRUE; // keep ?status and ?q in pagination links

    // Bootstrap pagination styling (same as before)
    $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
    $config['full_tag_close'] = '</ul>';
    $config['attributes'] = ['class' => 'page-link'];
    $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close'] = '</span></li>';

    $this->pagination->initialize($config);

    $offset = $this->uri->segment($config['uri_segment'], 0);

    // Pass filter + search into model
    $data['todos'] = $this->Todo_model->get_todos($config['per_page'], $offset, $status, $search);
    $data['pagination_links'] = $this->pagination->create_links();
    $data['status'] = $status;
    $data['search'] = $search;

    $this->load->view('todo_list', $data);
}
  
  public function create() {
    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('description', 'description', 'required');

if ($this->form_validation->run() === FALSE) {
    $data['show_add_modal'] = true; // flag to reopen modal
    $this->load->view('todo_list', $data);
} else {
    $data = [
        'title' => $this->input->post('title'),
        'description' => $this->input->post('description')
    ];
    $this->Todo_model->insert_todo($data);
    $this->session->set_flashdata('success', 'Task created successfully!');
    redirect('todo');
}

  }

  
  public function edit($id) {
    $data['todo'] = $this->Todo_model->get_todo($id);
    $this->load->view('todo_list', $data);
  }

  
 public function update($id) {
    $data = [
        'title'       => $this->input->post('title'),
        'description' => $this->input->post('description'),
        'status'      => $this->input->post('status')
    ];
    $this->Todo_model->update_todo($id, $data);
    // Set flash message
    $this->session->set_flashdata('success', 'Task updated successfully!');
    redirect('todo');
}


 
  public function delete($id) {
    $this->Todo_model->delete_todo($id);
    //set flash message
    $this->session->set_flashdata('success', 'Task deleted successfully!');
    redirect('todo');
  }

public function bulk_delete()
{
    // Check if it's a POST request
    if ($this->input->server('REQUEST_METHOD') === 'POST') {
        $task_ids = $this->input->post('task_ids');
        
        if (!empty($task_ids)) {
            // Convert all IDs to integers for security
            $task_ids = array_map('intval', $task_ids);
            
            // Delete tasks
            $deleted = $this->Todo_model->bulk_delete($task_ids);
            
            if ($deleted) {
                $this->session->set_flashdata('success', count($task_ids) . ' task(s) deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Error deleting tasks. Please try again.');
            }
        } else {
            $this->session->set_flashdata('error', 'No tasks selected for deletion.');
        }
    }
    
    // Redirect back to the task list
    redirect('todo/index');
}



public function import_csv() {
    if (!empty($_FILES['csv_file']['name'])) {
        $file = fopen($_FILES['csv_file']['tmp_name'], 'r');
        

        while (($row = fgetcsv($file)) !== FALSE) {
            $data = [
                'title'   => $row[0],
                'description'  => $row[1],
                'status' => $row[2],
            ];
            $this->Todo_model->insert_todo($data);
        }
        fclose($file);

        $this->session->set_flashdata('success', 'CSV imported successfully!');
    } else {
        $this->session->set_flashdata('error', 'Please upload a valid CSV file.');
    }
    redirect('todo');
}

}
?>
