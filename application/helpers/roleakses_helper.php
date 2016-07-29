<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

/**
 * CodeIgniter Combo Helpers
 *
 * @package        	CodeIgniter
 * @subpackage    	Helpers
 * @category    	Helpers
 * @author        	Chairul
 * @link        
 */

// ------------------------------------------------------------------------


if (! function_exists('getUnitKerja')) {
    function getUnitKerja($username)  {
        $CI =& get_instance();
        
                
        //Get data 
        $CI->db->where(array('is_active'=>1,'as_sidemenu'=>1));
        $CI->db->where('parent is not null');
        $CI->db->select('kode, judul_menu');
        $CI->db->from('mst_menu');
        $query = $CI->db->get();

        foreach ($query->result() as $row) {
            $retval .= "<option value=\"".$row->kode."\"";
            if ($row->kode==$selected) $retval .= " selected=\"selected\" ";
            $retval .= " >".$row->judul_menu."</option>";
        }
        
        $retval .= "</select>";
        return $retval;
    }
}

if (! function_exists('_userAksesGroup')) {
    function _userAksesGroup($user)
    {
        $data = array();
        $sql = "SELECT DISTINCT tug.username, mug.gid, mug.group_name, mug.group_level, mug.divisi_level, mug.is_aktif, 
                    mug.is_insert, mug.is_update, mug.is_delete,
                    mug.is_akses_role, mug.is_akses_role_user, mug.is_akses_role_group, mug.is_akses_role_menu
                FROM mst_user_group mug 
                INNER JOIN t_user_group tug ON tug.gid = mug.gid
                WHERE tug.username = '".$user."'";
        $query = $this->db->query( $sql );
        $data = $query->row_array();
        return $data;       
    }
}


?>