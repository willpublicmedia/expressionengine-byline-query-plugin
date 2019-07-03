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
        $this->load_required_fields();
        // $this->user = ee()->TMPL->fetch_param('user');
        // $this->return_data = $this->query_by_id($this->user);
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

    private function query_by_id($user_id)
    {
        // SET @data_teaser_field = CONCAT('field_id_', (SELECT field_id FROM exp_channel_fields WHERE field_name = 'Teaser'));
        // SET @data_byline_field = CONCAT('field_id_', (SELECT field_id FROM exp_channel_fields WHERE field_name = 'Byline'));
        // SET @screen_name_query = CONCAT('(SELECT members.screen_name FROM exp_members members WHERE members.member_id = ', @user_id, ')');
        // SET @byline_query = CONCAT('
		        // SELECT titles.entry_id, titles.title, titles.entry_date, titles.url_title, data.', @data_teaser_field, ', data.', @data_byline_field, ' 
                // FROM exp_channel_data data 
                // INNER JOIN exp_channel_titles titles ON data.entry_id = titles.entry_id
                // INNER JOIN exp_members members ON
			        // LOCATE(
				        // (SELECT members.screen_name FROM exp_members members WHERE members.member_id = ?),',
                        // @data_byline_field, '
                    // ) > 0
                    // GROUP BY entry_id
            // ');
        // PREPARE statement from @byline_query;
        // SET @a = '11';
        // EXECUTE statement USING @a;
        // DEALLOCATE PREPARE statement;
    }
}