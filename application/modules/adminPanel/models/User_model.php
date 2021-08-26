<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class User_model extends Admin_model
{
	public $table = "users u";
	public $select_column = ['u.id', 'u.name', 'u.mobile', 'ua.address'];
	public $search_column = ['u.name', 'u.mobile', 'ua.address'];
    public $order_column = [null, 'u.name', 'u.mobile', 'ua.address', null];
	public $order = ['u.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
            	 ->where(['u.is_deleted' => 0])
                 ->join('user_address ua', 'u.id = ua.u_id', 'left')
                 ->group_by('ua.u_id');

        $this->datatable();
	}

	public function count()
	{
		return $this->db->select('u.id')
						->from($this->table)
						->where(['u.is_deleted' => 0])
                        ->join('user_address ua', 'u.id = ua.u_id', 'left')
                        ->group_by('ua.u_id')
                        ->get()
						->num_rows();
	}
}