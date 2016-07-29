<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_tahap_model extends CI_Model {
    
    public function genRaRiXls($tanggal,$kdentity) {
        $sql = "
            SELECT
             *
            FROM
             (
              SELECT
               'BIAYA LANGSUNG' AS grup,
               thp.kode AS kode_item,
               thp.nama AS nama_item,
               sd.kode AS kode_sd,
               sd.nama AS nama_sd,
               bl.volume AS ra_vol,
               bl.volume*hsd.harga_satuan AS ra_harga,
               IFNULL(acc.volume,0) AS ri_vol,
               IFNULL(SUM(IF(acc.dk='D',acc.rupiah,(acc.rupiah*-1))),0) AS ri_harga
              FROM
               tr_rab_bl AS bl
               INNER JOIN mst_tahap AS thp ON thp.kode = bl.kode_tahap
                AND thp.kode_entity = bl.kode_entity
               INNER JOIN mst_sumberdaya AS sd ON sd.kode = bl.kode_sumberdaya
               INNER JOIN mst_harga_sumberdaya AS hsd ON hsd.kode_sumberdaya = sd.kode
                AND hsd.kode_entity = bl.kode_entity
               LEFT JOIN (
                SELECT
                 kode_tahap,
                 kode_sumberdaya,
                 kode_spk,
                 dk,
                 rupiah,
                 volume
                FROM
                 tr_accounting
                WHERE
                 tanggal <= '$tanggal'
                 AND kode_tahap IS NOT NULL
                 AND kode_sumberdaya IS NOT NULL
               ) AS acc ON acc.kode_tahap = bl.kode_tahap
                AND acc.kode_sumberdaya = bl.kode_sumberdaya AND acc.kode_spk = bl.kode_entity
              WHERE
               bl.kode_entity = '$kdentity'
              GROUP BY
               bl.kode_tahap,
               bl.kode_sumberdaya
              UNION ALL
              SELECT
               'BIAYA TIDAK LANGSUNG' AS grup,
               btl.kode_coa AS kode_item,
               coa.nama AS nama_item,
               btl.kode_sumberdaya AS kode_sd,
               sd.nama AS nama_sd,
               0 AS ra_vol,
               btl.harga AS ra_harga,
               0 AS ri_vol,
               IFNULL(SUM(IF(acc.dk='D',acc.rupiah,(acc.rupiah*-1))),0) AS ri_harga
              FROM
               tr_rab_btl AS btl
               LEFT JOIN mst_coa AS coa ON coa.kode = btl.kode_coa
               LEFT JOIN mst_sumberdaya AS sd ON sd.kode = btl.kode_sumberdaya
               LEFT JOIN (
                SELECT
                 kode_coa,
                 kode_sumberdaya,
                 kode_spk,
                 dk,
                 rupiah,
                 volume
                FROM
                 tr_accounting
                WHERE
                 tanggal <= '$tanggal'
                 AND kode_sumberdaya IS NOT NULL
               ) AS acc ON acc.kode_coa = btl.kode_coa
                AND acc.kode_sumberdaya = btl.kode_sumberdaya AND acc.kode_spk = btl.kode_entity
              WHERE
               btl.kode_entity = '$kdentity'
              GROUP BY
               btl.kode_coa,
               btl.kode_sumberdaya
             ) AS tmp
            ORDER BY
             tmp.grup,
             tmp.kode_item,
             tmp.kode_sd
        ";
        $q = $this->db->query($sql);
        return $q->num_rows()>0 ? $q->result_array() : 0;
    }

    public function genReportRaRi($kel_biya='BLBTL',$periode){
      
    }
    
}




