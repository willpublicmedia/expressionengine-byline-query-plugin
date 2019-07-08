<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (__DIR__ . '/constants.php');
use IllinoisPublicMedia\EntriesByAuthor\Constants;

class Entries_by_author 
{
    public $return_data;

    private $required_fields = array(
        'byline' => NULL,
        'teaser' => NULL
    );
 
    private $db_prefix = 'exp_';

    private $user;

    public function __construct()
    {
        $this->dbprefix = $this->get_dbprefix();
        $this->load_required_fields();
        
        $this->user = ee()->TMPL->fetch_param('user');
        $tagdata = ee()->TMPL->tagdata;
        
        $results = $this->query_by_id(intval($this->user));
        $bylines = $this->process_results($results);
        
        $data = array('bylines' => $bylines);
        $variables = ee()->TMPL->parse_variables($tagdata, array($data));
        $this->return_data = $variables;
    }

    private function get_dbprefix()
    {
        return ee()->db->dbprefix('channel_titles');
    }

    private function load_required_fields()
    {
        // Watch quote assignment on implode + query.
        $field_list = implode("', '", array_keys($this->required_fields));
        $sql = "SELECT field_id, field_name FROM {$this->db_prefix}channel_fields WHERE field_name IN ('{$field_list}');";
        
        $results = ee()->db->query($sql)->result_array();

        foreach ($results as $field)
        {
            $name = $field['field_name'];
            $this->required_fields[$name] = $field['field_id'];
        }
    }

    private function process_results($query_results)
    {
        $last = end($query_results);
        reset($query_results);

        $processed = '';
        foreach ($query_results as $row)
        {    
            $processed = $processed . $row['entry_id'];
            if ($row != $last);
            {
                $processed = $processed . '|';
            }
        }
        return $processed;
    }

    private function query_by_id($user_id)
    {
        if (!is_int($user_id))
        {
            ee()->TMPL->log_item('Entries by Author: User ID must be a number to query by ID.');
            return ee()->TMPL->no_results();
        }

        $data_teaser_field = 'field_id_' . $this->required_fields['teaser'];
        $data_byline_field = 'field_id_' . $this->required_fields['byline'];
        $screen_name_query = "SELECT screen_name from {$this->db_prefix}members WHERE member_id = ?";

        $byline_query = 
        "SELECT entry_id FROM {$this->db_prefix}channel_data data
            INNER JOIN {$this->db_prefix}members members ON
                LOCATE(
                    ({$screen_name_query}),
                    {$data_byline_field}
                ) > 0
            GROUP BY entry_id";
        
        $results = ee()->db->query($byline_query, $user_id)->result_array();

        return $results;
    }
}