<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/NXP/MathExecutor.php';

class MathParser extends NXP\MathExecutor
{
    function __construct()
    {
        parent::__construct();
    }
}