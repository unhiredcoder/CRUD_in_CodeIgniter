<?php
class Todo_model extends CI_Model {

  public function __construct() {
    parent::__construct();
    $this->load->database(); 
  }

public function count_todos($status = null, $search = null)
{
    if ($status) {
        $this->db->where('status', $status);
    }
    if ($search) {
        $this->db->like('title', $search);
        $this->db->or_like('description', $search);
    }
    return $this->db->count_all_results('todos');
}

public function get_todos($limit, $offset, $status = null, $search = null)
{
    if ($status) {
        $this->db->where('status', $status);
    }
    if ($search) {
        $this->db->like('title', $search);
        $this->db->or_like('description', $search);
    }
    $this->db->order_by('id', 'DESC');
    $this->db->limit($limit, $offset);

    $query = $this->db->get('todos');
    return $query->result();
}


  public function get_all_todos($status = null) {
    if ($status) {
      $this->db->where('status', $status);
    }
    return $this->db->get('todos')->result();
  }

  public function insert_todo($data) {
    return $this->db->insert('todos', $data);
  }

  public function get_todo($id) {
    return $this->db->get_where('todos', ['id' => $id])->row();
  }

  public function update_todo($id, $data) {
    return $this->db->where('id', $id)->update('todos', $data);
  }

  public function delete_todo($id) {
    return $this->db->where('id', $id)->delete('todos');
  }

  public function bulk_delete($task_ids)
{
    if (empty($task_ids)) {
        return false;
    }
    
    $this->db->where_in('id', $task_ids);
    $result = $this->db->delete('todos'); // Replace 'todos' with your table name
    
    return $result;
}
}
?>
