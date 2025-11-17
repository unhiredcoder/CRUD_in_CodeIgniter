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
      $this->load->view('todo_form');
    } else {
      $data = [
        'title' => $this->input->post('title'),
        'description' => $this->input->post('description')
      ];
      $this->Todo_model->insert_todo($data);
      redirect('todo');
    }
  }

  
  public function edit($id) {
    $data['todo'] = $this->Todo_model->get_todo($id);
    $this->load->view('todo_edit', $data);
  }

  
  public function update($id) {
    $data = [
      'title' => $this->input->post('title'),
      'description' => $this->input->post('description'),
      'status' => $this->input->post('status')
    ];
    $this->Todo_model->update_todo($id, $data);
    redirect('todo');
  }

 
  public function delete($id) {
    $this->Todo_model->delete_todo($id);
    redirect('todo');
  }
}
?>
