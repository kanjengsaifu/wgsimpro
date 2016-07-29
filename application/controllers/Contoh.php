<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Contoh extends CI_Controller {
    function __construct()  {
        parent::__construct();
            $this->load->library('Excel_reader');
            $this->load->helper('form');
            $this->load->helper('url');
    }


    function index() {
      $this->load->view('v_excel1');
    }

    function read_file(){
      //include_once ( APPPATH."Excel/reader.php");
      $data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
         
      $j = -1;
      for ($i=2; $i <= ($data->rowcount($sheet_index=0)); $i++){ 
        $j++;
        $nama[$j]   = $data->val($i, 1);
        $nim[$j]    = $data->val($i, 2);
        $kelas[$j]  = $data->val($i, 3);
      }
      
      $xdata['nama']  = $nama;
      $xdata['nim']  = $nim;
      $xdata['kelas']  = $kelas;
      $this->load->view('v_excel_r1', $xdata);
    }
  

  function ar3d1(){

  $movies = array(
      //Tower, Lantai, Nomor
      array('Office Space' , 'Comedy' , 'Mike Judge' ),
      array('Matrix' , 'Action' , 'Andy / Larry Wachowski' ),
      array('Lost In Translation' , 'Comedy / Drama' , 'Sofia Coppola' ),
      array('A Beautiful Mind' , 'Drama' , 'Ron Howard' ),
      array('Napoleon Dynamite' , 'Comedy' , 'Jared Hess' )
  );

  $units = array(
              array('T1','L1','01-01','01-02','01-03','01-05','01-06','01-07','01-08','01-09','01-10'),
              array('T1','L2','01-02','01-02','01-03','01-05','01-06','01-07','01-08','01-09','01-02'),
              array('T1','L3','01-03','01-03','01-03','01-05','01-06','01-07','01-08','01-09','01-03'),
              array('T1','L5','01-05','01-05','01-03','01-05','01-06','01-07','01-08','01-09','01-05'),
              array('T1','L6','01-06','01-06','01-06','01-05','01-06','01-07','01-08','01-09','01-06'),
              array('T1','L7','01-07','01-07','01-07','01-05','01-06','01-07','01-08','01-09','01-07'),
              array('T1','L8','01-08','01-08','01-08','01-08','01-08','01-08','01-08','01-08','01-08'),
          );

  $lantai = array('','','No.01','No.02','No.03','No.05','No.06','No.07','No.08','No.09','No.10');
  echo '<table border="1">';
  echo '<tr>';
  foreach ($lantai as $k => $v) {
    echo '<td>'.$v.'</td>';
  }
  echo '</tr>';
  //echo '<tr><th>Movies</th><th>Genre</th><th>Director</th></tr>';
  foreach( $units as $unit )
  {
      echo '<tr>';
      foreach( $unit as $key )
      {
          echo '<td>'.$key.'</td>';
      }
      echo '</tr>';
  }
  echo '</table>';



    $sql = "SELECT tower, lantai, urut, no_unit, jenis FROM tr_dashboard";
    $q = $this->db->query($sql);
    $res = $q->result_array();
    $data = array();
    $i=0;
    $unitx = array();

    $group = $this->groupnest($res, 'lantai', 'urut', 'no_unit');
    foreach($res as $rw => $vu){
      $unitx[] = $vu['no_unit'];
    }
   // var_dump($unitx);
    foreach ($res as $k => $v) {
      //$data[$v['tower']][$v['lantai']] = $v['no_unit'];
      //$units[] = array($v['tower'],$v['lantai'],array('no-unit'=>$v['no_unit']),$v['jenis']);
      //$no_urut[] = array($v['no_unit']);
      $data[] = array($i,$v['tower'],$v['lantai'],
                'unit'=>array($i=>$unitx),
                $v['jenis']);
      $i++;
    }
   
    
    echo '<pre>';
    print_r($group);
    echo '</pre>';
die;
    
    $result = array();
    $lop = 0;
    //foreach($res as $arr){
      //$result['tower']= $arr['tower'];
      //$result['lantai'] = array($arr['lantai']);
      //$result[$arr['tower']]['lantai'][$lop]['lantai'][$arr['lantai']] = array('no_unit'=>$arr['no_unit']);

      //$lop++;
    //}
    echo '<table style="border:1px solid #000;padding:5px;">
    <thead>
        <tr>';
           
            echo '<th>Lantai:</th>';
            for ($i = 1; $i < count($data); $i++) {
                echo '<th>Data naon yeuh' . $i . '</th>';
            }
            
    echo'    </tr>
    </thead>
    <tbody>';
        $fieldNames = array_keys($data[1]);
        for ($i = 0; $i < count($fieldNames); $i++) {
            echo '<tr>';
            for ($j = 0; $j < count($data); $j++) {
                $item = $data[$j];
                if ($j == 0) {
                    echo '<th>' . $fieldNames[$i] . '</th>';
                }
                echo '<td>' . $item[$fieldNames[$i]] . '</td>';
            }
            echo '</tr>';
        }
        
    echo '</tbody>
</table> ';
die;
    $data = array();
    $i=0;
    
    foreach($res as $lan => $vl){
      $data['lantai'] = $vl['lantai'];
    }
    foreach($res as $unit){
      $data['unit'] = array($unit['urut']=>$unit['no_unit']);
      
    }
    var_dump($data);
  }
  function getunit(){
        $data   = array();
        $this->db->select('tower,lantai,urut,no_unit');
        $this->db->from('tr_dashboard');
        $q = $this->db->get('tr_dashboard');
        $res = $q->result_array();
        foreach( $res as $key=> $each ){
            //$data[$key]              = $this->db->where('no_unit', $each['lantai'])->get('tr_dashboard')->row_array();
            $data[$key]['no_unit']   = $this->db->where('lantai', $each['lantai'])->get('tr_dashboard')->result_array();  
        }
        print_r($data);

        echo $this->db->last_query();
    }

    function groupnest( $data, $groupkey, $nestname, $innerkey ) {
      $outer0 = array();
      $group = array(); $nested = array();

      foreach( $data as $row ) {
      $outer = array();
      while( list($k,$v) = each($row) ) {
      if( $k==$innerkey ) break;
      $outer[$k] = $v;
      }

      $inner = array( $innerkey => $v );
      while( list($k,$v) = each($row) ) {
      if( $k==$innerkey ) break;
      $inner[$k] = $v;
      }

      if( count($outer0) and $outer[$groupkey]!=$outer0[$groupkey] ) {
      $outer0[$nestname] = $group;
      $nested[] = $outer0;
      $group = array();
      }
      $outer0 = $outer;

      $group[] = $inner;
      }
      $outer[$nestname] = $group;
      $nested[] = $outer;

      return $nested;
    }

    function dua(){
      
      $sql = "SELECT tower, lantai, urut, no_unit FROM tr_dashboard GROUP BY Lantai";
      $q = $this->db->query($sql);
      $this->db->select("tower, lantai, urut, no_unit");
      $res = $q->result_array();
      $data = array();

      foreach($res as $row){
        $data[] = array('tower'=>$row['tower'],'lantai'=>$row['lantai'],
                    'unit'=>array($row['urut']=>$row['no_unit'])
                    );
      }
      echo '<pre>';
      print_r($data);
      echo '</pre>';
    }

}

