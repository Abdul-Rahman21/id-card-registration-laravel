<?php

use Illuminate\Support\Facades\DB;

function getColumnvalue($column,$table,$where)
{
    return collect(DB::select("SELECT $column FROM $table $where"))->first();
}

