<?php

class Mydb extends CI_Model
{

    function removeEmptyvalue($myarray)
    {
        foreach ($myarray as $key => $value) {
            if (is_null($value) || $value == '')
                unset($myarray[$key]);
        }
        return $myarray;
    }

    function createSlug($str, $delimiter = '-')
    {

        $slug = trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter);
        return $slug;
    }


    public function hash($password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }

    //verify password
    public function verifyHash($password, $vpassword)
    {
        if (password_verify($password, $vpassword)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    function get_table_count($table, $where = '', $select = '*')
    {
        $count = 0;
        $this->db->select($select);
        $this->db->from($table);
        if ($where != "") {
            $this->db->where($where);
        }
        $query =  $this->db->get();

        $count = $query->row()->countt;

        return $count;
    }
    function get_table_data($table, $where = '', $select = '*', $mode = false, $sortby = '', $orderby = "")
    {
        $this->db->select($select);
        $this->db->from($table);
        if ($where != "") {
            $this->db->where($where);
        }
        if ($orderby != "") {

            $this->db->order_by($sortby, $orderby);
        }
        $query = $this->db->get();
        if ($mode == true) {
            return $query;
        } else {
            return $query->result_array();
        }
    }

    function get_column_name($table)
    {
        $sql = "SHOW COLUMNS FROM $table";
        $query = $this->db->query($sql);
        return $query;
    }


    public function get_data_join($table, $fields, $data)
    {
        //pega os campos passados para o select
        foreach ($fields as $coll => $value) {
            $this->db->select($value);
        }
        //pega a tabela
        $this->db->from($table);
        //pega os campos do join
        foreach ($data as $coll => $value) {
            $this->db->join($coll, $value);
        }
        //obtem os valores
        $query = $this->db->get();
    }
    function select_data_by_condition($tablename, $condition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array())
    {
        $this->db->select($data);
        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if ($join['join_type'] == '') {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        //condition array pass to where condition
        $this->db->where($condition_array);


        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }
        //order by query
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }

        $query = $this->db->get($tablename);

        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }
        //if limit is not empty then return result array
        return $query;
    }

    function update_table_data($table, $where, $data)
    {

        $this->db->where($where);
        $this->db->update($table, $data);
        $id = $this->db->affected_rows();
        return $id;
    }

    function delete_table_data($table, $where)
    {
        $reValue = 0;
        $this->db->where($where);
        $this->db->delete($table);
        $id = $this->db->affected_rows();
        if ($id > 0) {

            $reValue = $this->db->affected_rows();
        } else {

            $db_error = $this->db->error();

            //print_r($db_error);

            if ($db_error['code'] == 1451) {
                $reValue = -1451;
            }
        }
        return $reValue;
    }

    function insert_table_data($table, $data)
    {
        $data = $this->removeEmptyvalue($data);
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function getPaginationData($perpage, $current_page, $total_rows)
    {
        $page = $current_page;
        if ($page != "") {
            $page_number = $page;
        } else {
            $page_number = 1; //if there's no page number, set it to 1
        }
        $total_pages = ceil($total_rows / $perpage);
        $data['page_position'] = (($page_number - 1) * $perpage);
        $data['perpage'] = $perpage;
        $data['page_number'] = $page_number;
        $data['total_rows'] = $total_rows;
        $data['total_pages'] = $total_pages;
        return $data;
    }


    function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
    {
        $pagination = '';
        if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) { //verify total pages and current page number
            $pagination .= '<ul class="pagination pagination-split">';

            $right_links = $current_page + 3;
            $previous = $current_page - 3; //previous link 
            $next_link = $current_page + 1; //next link
            $previous_link = $current_page - 1;
            $first_link = true; //boolean var to decide our first link

            if ($current_page > 1) {
                //$previous_link = ($previous==0)?1:$previous;
                $pagination .= '<li class="first page-item"><a class="page-link" href="javascript:void(0)" data-page="1" title="First">&laquo;</a></li>'; //first link
                $pagination .= '<li class="page-item"><a href="javascript:void(0)" class="page-link"  data-page="' . $previous_link . '" title="Previous">&lt;</a></li>'; //previous link
                for ($i = ($current_page - 2); $i < $current_page; $i++) { //Create left-hand side links
                    if ($i > 0) {
                        $pagination .= '<li class="page-item"><a class="page-link"  href="javascript:void(0)" data-page="' . $i . '" title="Page' . $i . '">' . $i . '</a></li>';
                    }
                }
                $first_link = false; //set first link to false
            }

            if ($first_link) { //if current active page is first link
                $pagination .= '<li class="first active page-item"><a class="page-link"  href="javascript:void(0)">' . $current_page . '</a></li>';
            } elseif ($current_page == $total_pages) { //if it's the last active link
                $pagination .= '<li class="last active page-item"><a class="page-link"  href="javascript:void(0)">' . $current_page . '</a></li>';
            } else { //regular current link
                $pagination .= '<li class="active page-item"><a class="page-link"  href="javascript:void(0)">' . $current_page . '</a></li>';
            }

            for ($i = $current_page + 1; $i < $right_links; $i++) { //create right-hand side links
                if ($i <= $total_pages) {
                    $pagination .= '<li class="page-item"><a class="page-link"  href="javascript:void(0)" data-page="' . $i . '" title="Page ' . $i . '">' . $i . '</a></li>';
                }
            }
            if ($current_page < $total_pages) {
                //$next_link = ($i > $total_pages)? $total_pages : $i;
                $pagination .= '<li class="page-item"><a class="page-link"  href="javascript:void(0)" data-page="' . $next_link . '" title="Next">&gt;</a></li>'; //next link
                $pagination .= '<li class="last page-item"><a class="page-link"  href="javascript:void(0)" data-page="' . $total_pages . '" title="Last">&raquo;</a></li>'; //last link
            }

            $pagination .= '</ul>';
        }
        return $pagination; //return pagination links
    }


    /**
     * Get search data from this method.
     */


    public function do_search($table_name, $model_name, $all=false)
    {
        $param_default = array('search', 'perpage', 'page', 'sortby', 'orderby');
        $parameters = $this->input->get();
        $diff = array();
        $data = array();
        $data['data_list'] = array();
        $search = "";
        $perpage = 10;
        $page = 1;
        $sortby = $table_name . ".id";
        $orderby = "DESC";
        $data['slno'] = '';

        if (!empty($parameters)) {
            $parem_key = array_keys($parameters);
            $diff = array_diff($parem_key, $param_default);
            $intersect = array_intersect($parem_key, $param_default);
        }

        if (!empty($intersect)) {
            foreach ($intersect as $inst) {
                $rml =  str_replace('-', '.', $parameters[$inst]);
                $$inst = $rml;
            }
        }

        $filter_data[0]['type'] = 'search';
        $filter_data[0]['value'] = $search;

        if (!empty($diff)) {
            $i = count($filter_data);
            foreach ($diff as $p) {
                if (!empty($this->input->get($p))) {
                    $pa = str_replace('-', '.', $p);
                    $filter_data[$i]['type'] = $pa;
                    $filter_data[$i]['value'] = $this->input->get($p);
                }
                $i++;
            }
        }

        $total_rows = $this->$model_name->filter($filter_data, 0, 0, $sortby, $orderby, $all);

        $udata = $this->Mydb->getPaginationData($perpage, $page, $total_rows);
        $data = array_merge($data, $udata);
        $getData = $this->$model_name->filter($filter_data, $perpage, $data['page_position'], $sortby, $orderby, $all);


        $data['pagination'] = $this->Mydb->paginate_function($perpage, $data['page_number'], $total_rows, $data['total_pages']);

        if ($getData->num_rows() > 0) {
            foreach ($getData->result() as $row) {
                $data['data_list'][] = $row;
            }
            if ($page == 1) {
                $data['slno'] = 1;
            } else {
                $data['slno'] = (($page - 1) * $perpage) + 1;
            }
            if ($all) {
                array_splice($data, 1);
            }
        } else {
            $data = array();
        }
        return $data;
    }


    /**
     * Get single record from this method.
     */

    public function get_single_result($id, $table_name, $model_name)
    {
        $filter_data[0]['type'] = $table_name . '.id';
        $filter_data[0]['value'] = $id;
        $getData = $this->$model_name->filter($filter_data);
        $data = $getData->row_array();
        if (!empty($data)) {
            return array('details' => $data);
        } else {
            return array();
        }
    }


    /**
     * Update custom field data from this method.
     */

    public function data_field_crud($table_name, $id, $data_fields)
    {
        $status = 0;
        $data_fields = json_decode($data_fields, true);
        $data = $this->Mydb->get_table_data($table_name);
        if (empty($data[0]['data_fields'])) {
            foreach ($data_fields as $k => $v) {
                $data_key = $k;
                $data_type = $v['data_type'];
                $up_array[$data_type] = $v['data_value'];
            }
            $update_data['data_fields'] = json_encode($up_array);
            $update = $this->Mydb->update_table_data($table_name, array('id' => $id), $update_data);
            $status = 1;
        } else {
            foreach ($data_fields as $k => $v) {
                $data_key = $k;
                $data_type = $v['data_type'];
                $data_value = json_encode($v['data_value']);
                $sql = "UPDATE $table_name SET data_fields = JSON_SET(data_fields, '$.$data_type', JSON_COMPACT('$data_value')) WHERE id = $id";
                $query = $this->db->query($sql);
                $status = 1;
            }
            $r_sql = "UPDATE $table_name SET data_fields = replace(data_fields,'\\\','') WHERE id = $id";
            $query = $this->db->query($r_sql);
        }
        return $status;
    }
}
