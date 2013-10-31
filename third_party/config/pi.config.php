<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
  'pi_name' => 'Config Variables',
  'pi_version' => '0.2',
  'pi_author' => 'Trevor Davis',
  'pi_author_url' => 'http://trevordavis.net/',
  'pi_description' => 'Returns the specified config variable',
  'pi_usage' => Config::usage()
  );

/**
 * Config Class
 *
 * @package     ExpressionEngine
 * @category    Plugin
 * @author      Trevor Davis
 * @copyright   Copyright (c) 2011, Trevor Davis
 * @link        https://github.com/davist11/Config-Variables-Plugin
 */

class Config
{

  // --------------------------------------------------------------------

  function __construct()
  {
    $this->EE =& get_instance();
  }

  /**
   * Vars
   *
   * This function returns the config variable so you don't have to use PHP in templates
   *
   * @access  public
   * @return  string
   */
  function vars()
  {
    $param = $this->EE->TMPL->fetch_param('value');
    $delimeter = $this->EE->TMPL->fetch_param('delimeter', ':');

    $str = '';
    $config_arr = $this->EE->config->config;
    if($param === 'all') {
      print_r($config_arr);
      exit();
    } else {

      $keys = explode($delimeter, $param);
      $current = $config_arr;

      foreach ($keys as $key) {
        if (isset($current[$key])) {
          $current = $current[$key];

          if (!is_array($current)) {
            break;
          }

        }
      }

      $str = is_scalar($current) ? $current : '';
    }
    return $str;
  }

  // --------------------------------------------------------------------

  /**
   * Usage
   *
   * This function describes how the plugin is used.
   *
   * @access  public
   * @return  string
   */

  //  Make sure and use output buffering

  function usage()
  {
  ob_start();
  ?>
Outputs a string value from the available config variables.

{exp:config:vars value="base_path"}

To retreive variables in nested arrays, use the ":" delimeter.

{exp:config:vars value="upload_preferences:1:url"}

If you want to see all avaiable parameters, pass in all to have the array printed:

{exp:config:vars value="all"}
  <?php
  $buffer = ob_get_contents();

  ob_end_clean();

  return $buffer;
  }
  // END

}
/* End of file pi.config.php */
/* Location: ./system/expressionengine/third_party/config/pi.config.php */
