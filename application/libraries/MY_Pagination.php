<?php

class MY_Pagination extends CI_Pagination
{
    public function get_as_array()
    {
        return [
            'total_rows' => $this->total_rows,
            'per_page' => $this->per_page,
            'cur_page' => $this->cur_page,
        ];
    }
}