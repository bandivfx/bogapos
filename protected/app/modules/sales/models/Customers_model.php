<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customers_model extends CI_Model {

    function get_all($page = 0, $size, $filter = array(), $sort = array()) {
        if ($page)
            $page = $page * $size;
        if ($filter) {
            foreach ($filter as $key => $value) {
                $key = $this->get_alias_key($key);
                $this->db->like($key, $value);
            }
        }
        if ($sort) {
            $key = key($sort);
            $order = ($sort[$key] == 1) ? 'desc' : 'asc';
            $sort = $this->get_alias_key($key);
            $this->db->order_by($sort, $order);
        }
        $this->db->select('id, name, email, phone, city')
                ->limit($size, $page);

        $query = $this->db->get('customers');
        return($query->num_rows() > 0) ? $query : false;
    }

    function get_alias_key($key) {
        switch ($key) {
            case 1: $key = 'name';
                break;
            case 2: $key = 'email';
                break;
            case 3: $key = 'phone';
                break;
            case 4: $key = 'city';
                break;
        }
        return $key;
    }

    function count_all($filter = array()) {
        if ($filter) {
            foreach ($filter as $key => $value) {
                $key = $this->get_alias_key($key);
                $this->db->like($key, $value);
            }
        }
        $this->db->select('IFNULL(COUNT(id),0) count');
        $query = $this->db->get('customers');
        return $query->row()->count;
    }

}
