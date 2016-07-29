<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_Tools extends App {

    public function __construct() {
        parent::__construct();
        $this->load->model('tr_tools_model');
        $this->load->library('datatables');
    }

    public function index(){
        $data['idmenu']                 = 'gen-coa-common';
        $data['content']                = '../../tr_tools/views/v_form';
        $data['js']                     = '../../tr_tools/views/v_form_js';

        $this->buildView($data);
    }

	public function updateCoaCommon()
    {
        $res = $this->tr_tools_model->_updateCoaCommon();
        $msg = array();
        if($res > 0){
            $msg = array('msg'=>$res);
        }else{
            $msg = array('msg'=>'Something when wrong. Please try again.');
        }
        
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($msg));
    }

    public function getListNoBuktiWithBlank(){
        //$res = $this->tr_tools_model->_updateCoaCommon();
        $spk = $this->session->userdata('kode_entity');
        $this->datatables->select("(CASE WHEN SUBSTR(no_bukti, -4, 1) = 'K' THEN MAX(no_bukti) END ) as bk_kas,
             (CASE WHEN SUBSTR(no_bukti, -4, 1) = 'B' THEN MAX(no_bukti) END ) as bk_bank,
             (CASE WHEN SUBSTR(no_bukti, -4, 1) = 'M' THEN MAX(no_bukti) END ) as bk_memo",FALSE)
                ->from('tr_accounting')
                ->order_by('no_bukti')
                ->group_by('no_bukti')
                ->where( array('kode_spk'=>$spk) );
        
       echo $this->datatables->generate();
       //echo $this->db->last_query();
    }
    function listCoaCommon(){
        $sql = "SELECT tr.kode_coa, mc.nama
                FROM tr_accounting tr 
                INNER JOIN mst_coa mc ON mc.kode = tr.kode_coa
                WHERE tr.kode_spk='$this->getKodeSPK()'
                GROUP BY tr.kode_coa ASC ";
        //print_r('<pre>'.$sql.'</pre>');
        $q = $this->db->query($sql);

        foreach($q->result_array() as $k => $v){
            //var_dump($k);
        }
    }

    function getLastNoBukti($kbm){
        $res = $this->tr_tools_model->_getLastNoBukti($kbm);

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($res));
    }

    function lookupCommon($jenis)
    {
        $keyword = $this->input->post('term');
        $data['response'] = 'false'; //mengatur default response
        
       
        $query = $this->tr_tools_model->_lookupCommon($jenis); 

        if(! empty($query) ) {
            $data['response']   = 'true'; //mengatur response
            $data['message']    = array(); //membuat array
            foreach( $query as $row ){
                $data['message'][] = array('label' => $row->kode.' - '.$row->nama, 'value' => $row->kode);
            }
        }
        
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));

        /*if(IS_AJAX){
            echo json_encode($data); 
        }else {
            //$this->load->view('home/index',$data); 
        }*/
    }

    function listCOA(){
        $this->datatables->select('id, kode, nama, mand_tahap, mand_sbd, mand_nasabah, mand_pajak, mand_bank')
                ->unset_column('id')
                ->from('mst_coa')
                ->add_column('action', '<a href="javascript:pilihCoa(\'$1\',\'$2\')"><span class="glyphicons glyphicons-edit"></span></a>', 'kode,nama');
        echo $this->datatables->generate();
    }

}