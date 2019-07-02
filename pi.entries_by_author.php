<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (__DIR__ . '/constants.php');
use IllinoisPublicMedia\EntriesByAuthor\Constants;

class Entries_by_author 
{
    public $return_data;

    private $user;

    public function __construct()
    {
        $this->user = ee()->TMPL->fetch_param('user');
        $this->return_data = $this->user;
    }
}