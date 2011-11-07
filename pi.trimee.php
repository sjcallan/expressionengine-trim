<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
	'pi_name' => 'TrimEE',
	'pi_version' =>'1.0',
	'pi_author' =>'Steve Callan',
	'pi_author_url' => 'http://www.stevecallan.com/',
	'pi_description' => 'Trims content down to a specified character count.',
	'pi_usage' => trimee::usage()
);

/**
* Form Class
*
* @package		ExpressionEngine
* @category		Plugin
* @author		Steve Callan
* @copyright	Copyright (c) 2011, Watts Water Technologies
*/

class Trimee {

	function __construct()
	{
		$this->EE =& get_instance();
	}
	
	function trim()
	{	
	
		/* Intitial Variables */
			$tag_content = $this->EE->TMPL->tagdata;
			$char_count = $this->EE->TMPL->fetch_param('count');
			$include_trailing = $this->EE->TMPL->fetch_param('include_trailing');
			$complete_words = $this->EE->TMPL->fetch_param('complete_words');
			
			if($include_trailing == "")
			{	
				$include_trailing = TRUE;
			}
			else
			{
				$include_trailing = FALSE;
			}
			
			if($complete_words == "")
			{	
				$complete_words = TRUE;
			}
			else
			{
				$complete_words = FALSE;
			}
			
			
		/* TRIM content down */
			if(strlen($tag_content) >= $char_count)
			{
				if($complete_words)
				{
					$output = $this->_trim_one($tag_content,$char_count);
				}
				else
				{
					$output = substr($tag_content,0,$char_count);
				}
			}
			else
			{
				$output = $tag_content;
			}
		
		/* Add trailing ... if we want it */
			if($include_trailing == TRUE)
			{
				$output = trim($output);
				$output .= "...";
			}
		
		/*  AND finally return */
			return $output;
		
	}
	
	function _trim_one($string, $count)
	{
		$string_length = strlen($string);
		$trimmed_string = substr($string,0,$count);
		
		if(substr($trimmed_string,-1) == " ")
		{
			return $trimmed_string;
		}
		else
		{
			return $this->_trim_one($string, $count-1);
		}		
	
	}
		
	function usage()
	{
	
		ob_start(); 
		?>
		TrimEE plugin trims down a supplied content to a set number of characters.
		
		{exp:trimee:trim}
			This is my content.
		{/exp:trimee:trim}
		
		
		<?php
		$buffer = ob_get_contents();
		
		ob_end_clean(); 
		
		return $buffer;
	
	}
	
}

