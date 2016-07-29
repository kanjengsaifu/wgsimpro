<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPCLASS;

class Tr_Tools extends App {

    public function __construct() {
        parent::__construct();
        $this->load->model('tr_tools_model');
        $this->load->library('datatables');
    }

    public function index(){
       
    }

    public function coa_common(){
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

    public function getListNoBuk($jenis='M',$periode){
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        ini_set('memory_limit', '-1');
        $periode = $periode.'-01';
        $res = $this->tr_tools_model->_getListNoBuk($jenis,$periode);

       //var_dump($res);

        $status = '';
        $result = array();// array('data'=>$res);
        $n=0;
        /*echo '<pre>';
        print_r($res[0]['nmin']);die;
        echo '</pre>';
        */
        //var_dump($res);die;
        //for($n=1; $n<count($res['nmax']);$n++){
            //echo $res[$n][0];
        //foreach ($res as $k => $v) {
            //print_r($v[0]);//substr($res[0][1],2,4)
        //    $mimin = ($res[0]['nmin']-1);
        //    $nmaxim = 9999;
            for($i=0; $i<1000;$i++){
                /*$no = explode(',',sprintf('%04d',$i));
                if( $no[0]===$res[$i]['nomor']){
                    $status = $res[$i]['status'];
                }else{
                    $status = $res[$i]['status'];
                }
                $result[]= ['nomor'=>$nomor[0],'status'=>$status ];
                */
                echo $result = '<tr>
                            <td>'.$res[$i]['nomor'].'</td>
                            <td>'.$res[$i]['status'].'</td>
                            <td>pilih-['.$res[$i]['nomor'].']</td>
                        </tr>';
            } 
            //var_dump($result);

        /*return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode( $res, JSON_PRETTY_PRINT ));*/
        
    }


    public function getListUnsedNoBuk(){

        $res = $this->tr_tools_model->_getListUnsedNoBuk();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($res));
    }

    public function getListNoBuktiWithBlank(){
        //$res = $this->tr_tools_model->_updateCoaCommon();
        $spk = $this->session->userdata('kode_entity');
        $this->datatables->select("SELECT max(no_bukti)
FROM tr_accounting
WHERE MONTH(tanggal) = MONTH(DATE(now())) AND YEAR(tanggal) = YEAR(DATE(now()))
-- GROUP BY no_bukti, tanggal
ORDER BY no_bukti DESC, tanggal DESC", FALSE)
        ->from('tr_accounting')
        ->order_by('no_bukti')
        ->where( array('MONTH(tanggal)'=>MONTH(DATE(now())), 'YEAR(tanggal)'=>YEAR(DATE(now())) ) );
        /*$this->datatables->select("(CASE WHEN SUBSTR(no_bukti, -4, 1) = 'K' THEN MAX(no_bukti) END ) as bk_kas,
             (CASE WHEN SUBSTR(no_bukti, -4, 1) = 'B' THEN MAX(no_bukti) END ) as bk_bank,
             (CASE WHEN SUBSTR(no_bukti, -4, 1) = 'M' THEN MAX(no_bukti) END ) as bk_memo",FALSE)
                ->from('tr_accounting')
                ->order_by('no_bukti')
                ->group_by('no_bukti')
                ->where( array('kode_spk'=>$spk) );
        */
        
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

    function lookupCommon($jenis,$kode)
    {
        $keyword = $this->input->post('term');
        $data['response'] = 'false'; //mengatur default response
        
       
        $query = $this->tr_tools_model->_lookupCommon($jenis,$kode); 

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