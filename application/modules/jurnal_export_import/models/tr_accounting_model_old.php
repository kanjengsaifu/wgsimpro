<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tr_accounting_model extends CI_Model {
	public function get_integration_ar($payid) {
		$this->db->select('paydet.id AS payment_id, paydet.reserve_no, pay.no_unit, paydet.rp, paydet.tgl_bayar AS tanggal, pay.kode_nasabah, paydet.no_kwitansi AS no_invoice')
			->from('tr_payment_detail paydet')
			->join('tr_payment pay', 'pay.reserve_no = paydet.reserve_no', 'inner')
			->where(array('paydet.id'=>$payid));
		$q = $this->db->get();
		return $q->row_array();
	}

	public function get_datacombo() {
        $q = $this->db->get('mst_coa');
        //$data['coa'] = $q->result_array(); 
        //$data = array();
        $res = $q->result_array(); 
        foreach($res as $k => $v) {
            foreach($v as $k2 => $v2) {
                $data['coa'][$k][$k2] = $v2;
            }
        }

        $q = $this->db->get('mst_nasabah');
        //$data['nasabah'] = $n->result_array(); 
        $res = $q->result_array(); 
        foreach($res as $k => $v) {
            foreach($v as $k2 => $v2) {
                $data['nasabah'][$k][$k2] = $v2;
            }
        }


        $q = $this->db->get('mst_sumberdaya');
        $res = $q->result_array(); 
        foreach($res as $k => $v) {
            foreach($v as $k2 => $v2) {
                $data['sumberdaya'][$k][$k2] = $v2;
            }
        }

        $q = $this->db->get('tr_spk');
        $res = $q->result_array(); 
        foreach($res as $k => $v) {
            foreach($v as $k2 => $v2) {
                $data['spk'][$k][$k2] = $v2;
            }
        }

        $q = $this->db->get('mst_tahap');
        $res = $q->result_array(); 
        foreach($res as $k => $v) {
            foreach($v as $k2 => $v2) {
                $data['tahap'][$k][$k2] = $v2;
            }
        }

        $q = $this->db->get('mst_bank');
        $res = $q->result_array(); 
        foreach($res as $k => $v) {
            foreach($v as $k2 => $v2) {
                $data['bank'][$k][$k2] = $v2;
            }
        }

        return $data;
    }

    public function _insert($data=array())
    {
        return $this->db->insert('tr_accounting', $data);
    }

    public function gen_rpt_neraca_t($periode) {
        list($bln, $thn) = explode('-', $periode);
        $tgl_s = $thn.'-01-01';
        $tgl_e = date("Y-m-t", strtotime($thn.'-'.$bln.'-01'));
        // get coa, varname & rp
        $sql = "
            SELECT
                tbl.coa,
                tbl.varname,
                SUM(tbl.rpmin1th) AS rpmin1th,
                SUM(tbl.rpmin1bln) AS rpmin1bln
            FROM
                (
                    SELECT
                        tmpl_coa.coa,
                        tmpl_coa.varname,
                        IFNULL(SUM(rpmin1th.rp), 0) AS rpmin1th,
                        0 AS rpmin1bln
                    FROM
                        template_coa_list tmpl_coa
                    LEFT JOIN (
                        SELECT
                            kode_coa,
                            SUM(
                                CASE
                                WHEN dk = 'D' THEN
                                    rupiah
                                ELSE
                                    (rupiah *- 1)
                                END
                            ) AS rp
                        FROM
                            tr_accounting
                        WHERE
                            tanggal < '$tgl_s'
                        AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'
                        GROUP BY
                            kode_coa
                    ) rpmin1th ON rpmin1th.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                    WHERE
                        tmpl_coa.jenis_rpt = 'NRCT'
                    AND tmpl_coa.coa <> ''
                    AND tmpl_coa.is_range_current = 0
                    GROUP BY
                        tmpl_coa.coa
                    UNION ALL
                        SELECT
                            tmpl_coa.coa,
                            tmpl_coa.varname,
                            0 AS rpmin1th,
                            IFNULL(SUM(rpmin1bln.rp), 0) AS rpmin1bln
                        FROM
                            template_coa_list tmpl_coa
                        LEFT JOIN (
                            SELECT
                                kode_coa,
                                SUM(
                                    CASE
                                    WHEN dk = 'D' THEN
                                        rupiah
                                    ELSE
                                        (rupiah *- 1)
                                    END
                                ) AS rp
                            FROM
                                tr_accounting
                            WHERE
                                tanggal <= '$tgl_e'
                            AND kode_divisi = 'P'
                            AND kode_spk = '2WGA13'
                            GROUP BY
                                kode_coa
                        ) rpmin1bln ON rpmin1bln.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                        WHERE
                            tmpl_coa.jenis_rpt = 'NRCT'
                        AND tmpl_coa.coa <> ''
                        AND tmpl_coa.is_range_current = 0
                        GROUP BY
                            tmpl_coa.coa
                ) AS tbl
            GROUP BY
                tbl.coa
            UNION ALL
                SELECT
                    tbl.coa,
                    tbl.varname,
                    SUM(tbl.rpmin1th) AS rpmin1th,
                    SUM(tbl.rpmin1bln) AS rpmin1bln
                FROM
                    (
                        SELECT
                            tmpl_coa.coa,
                            tmpl_coa.varname,
                            IFNULL(SUM(rpmin1th.rp), 0) AS rpmin1th,
                            0 AS rpmin1bln
                        FROM
                            template_coa_list tmpl_coa
                        LEFT JOIN (
                            SELECT
                                kode_coa,
                                SUM(
                                    CASE
                                    WHEN dk = 'D' THEN
                                        rupiah
                                    ELSE
                                        (rupiah *- 1)
                                    END
                                ) AS rp
                            FROM
                                tr_accounting
                            WHERE
                                tanggal >= DATE_ADD(
                                    '$tgl_s',
                                    INTERVAL - 1 YEAR
                                )
                            AND tanggal < '$tgl_s'
                            AND kode_divisi = 'P'
                            AND kode_spk = '2WGA13'
                            GROUP BY
                                kode_coa
                        ) rpmin1th ON rpmin1th.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                        WHERE
                            tmpl_coa.jenis_rpt = 'NRCT'
                        AND tmpl_coa.coa <> ''
                        AND tmpl_coa.is_range_current = 1
                        GROUP BY
                            tmpl_coa.coa
                        UNION ALL
                            SELECT
                                tmpl_coa.coa,
                                tmpl_coa.varname,
                                0 AS rpmin1th,
                                IFNULL(SUM(rpmin1bln.rp), 0) AS rpmin1bln
                            FROM
                                template_coa_list tmpl_coa
                            LEFT JOIN (
                                SELECT
                                    kode_coa,
                                    SUM(
                                        CASE
                                        WHEN dk = 'D' THEN
                                            rupiah
                                        ELSE
                                            (rupiah *- 1)
                                        END
                                    ) AS rp
                                FROM
                                    tr_accounting
                                WHERE
                                    tanggal >= '$tgl_s'
                                AND tanggal <= '$tgl_e'
                                AND kode_divisi = 'P'
                                AND kode_spk = '2WGA13'
                                GROUP BY
                                    kode_coa
                            ) rpmin1bln ON rpmin1bln.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                            WHERE
                                tmpl_coa.jenis_rpt = 'NRCT'
                            AND tmpl_coa.coa <> ''
                            AND tmpl_coa.is_range_current = 1
                            GROUP BY
                                tmpl_coa.coa
                    ) AS tbl
                GROUP BY
                    tbl.coa
                UNION ALL
                    SELECT
                        tbl.coa,
                        tbl.varname,
                        SUM(tbl.rpmin1th) AS rpmin1th,
                        SUM(tbl.rpmin1bln) AS rpmin1bln
                    FROM
                        (
                            SELECT
                                tmpl_coa.coa,
                                tmpl_coa.varname,
                                IFNULL(SUM(rpmin1th.rp), 0) AS rpmin1th,
                                0 AS rpmin1bln
                            FROM
                                template_coa_list tmpl_coa
                            LEFT JOIN (
                                SELECT
                                    kode_coa,
                                    SUM(
                                        CASE
                                        WHEN dk = 'D' THEN
                                            rupiah
                                        ELSE
                                            (rupiah *- 1)
                                        END
                                    ) AS rp
                                FROM
                                    tr_accounting
                                WHERE
                                    tanggal < DATE_ADD(
                                        '$tgl_s',
                                        INTERVAL - 1 YEAR
                                    )
                                AND kode_divisi = 'P'
                                AND kode_spk = '2WGA13'
                                GROUP BY
                                    kode_coa
                            ) rpmin1th ON rpmin1th.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                            WHERE
                                tmpl_coa.jenis_rpt = 'NRCT'
                            AND tmpl_coa.coa <> ''
                            AND tmpl_coa.is_range_current = 2
                            GROUP BY
                                tmpl_coa.coa
                            UNION ALL
                                SELECT
                                    tmpl_coa.coa,
                                    tmpl_coa.varname,
                                    0 AS rpmin1th,
                                    IFNULL(SUM(rpmin1bln.rp), 0) AS rpmin1bln
                                FROM
                                    template_coa_list tmpl_coa
                                LEFT JOIN (
                                    SELECT
                                        kode_coa,
                                        SUM(
                                            CASE
                                            WHEN dk = 'D' THEN
                                                rupiah
                                            ELSE
                                                (rupiah *- 1)
                                            END
                                        ) AS rp
                                    FROM
                                        tr_accounting
                                    WHERE
                                        tanggal < '$tgl_s'
                                    AND kode_divisi = 'P'
                                    AND kode_spk = '2WGA13'
                                    GROUP BY
                                        kode_coa
                                ) rpmin1bln ON rpmin1bln.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                                WHERE
                                    tmpl_coa.jenis_rpt = 'NRCT'
                                AND tmpl_coa.coa <> ''
                                AND tmpl_coa.is_range_current = 2
                                GROUP BY
                                    tmpl_coa.coa
                        ) AS tbl
                    GROUP BY
                        tbl.coa
        ";
        $qVar = $this->db->query($sql);
        $resVar = $qVar->result_array();
        // math lib
        $this->load->library('MathParser');
        $math_now = new MathParser();
        $math_past = new MathParser();
        // register var & val
        foreach ($resVar as $k => $v) {
            $math_now->setVars(
                array(
                    $v['varname']=>$v['rpmin1bln']
                ),
                FALSE
            );
            $math_past->setVars(
                array(
                    $v['varname']=>$v['rpmin1th']
                ),
                FALSE
            );
        }
        // get rpt template
        $sql = "
            SELECT 
                tmpl_l.description AS l_desc, 
                tmpl_l._line AS l_line, 
                tmpl_l.is_bold AS l_bold, 
                tmpl_l.varname AS l_var, 
                IFNULL(tmpl_l._formula,'') AS l_formula, 
                tmpl_r.description AS r_desc, 
                tmpl_r._line AS r_line, 
                tmpl_r.is_bold AS r_bold, 
                tmpl_r.varname AS r_var, 
                IFNULL(tmpl_r._formula,'') AS r_formula 
            FROM 
                ( 
                    SELECT 
                        * 
                    FROM 
                        template_report 
                    WHERE 
                        _position = 'L' 
                ) tmpl_l 
                LEFT JOIN  
                ( 
                    SELECT 
                        * 
                    FROM 
                        template_report 
                    WHERE 
                        _position = 'R' 
                ) tmpl_r ON tmpl_r.jenis_rpt = tmpl_l.jenis_rpt 
                 AND tmpl_r.no_urut = tmpl_l.no_urut 
            WHERE 
                tmpl_l.jenis_rpt = 'NRCT' 
            ORDER BY 
                tmpl_l.no_urut
        ";
        $qTmpl = $this->db->query($sql);
        $resTmpl = $qTmpl->result_array();
        $data = array();
        foreach ($resTmpl as $k => $v) {
            $l_rp1 = strpos($v['l_formula'], 'nt')!==FALSE ? $math_now->execute($v['l_formula']) : 0;
            $l_rp1 = strpos($v['l_formula'], 'L')!==FALSE ? $math_now->execute($v['l_formula']) : $l_rp1;
            $l_rp2 = strpos($v['l_formula'], 'nt')!==FALSE ? $math_past->execute($v['l_formula']) : 0;
            $l_rp2 = strpos($v['l_formula'], 'L')!==FALSE ? $math_past->execute($v['l_formula']) : $l_rp2;
            $l_nonsum = $v['l_formula']!=='' ? '0' : '1';
            $r_rp1 = strpos($v['r_formula'], 'nt')!==FALSE ? $math_now->execute($v['r_formula']) : 0;
            $r_rp1 = strpos($v['r_formula'], 'R')!==FALSE ? $math_now->execute($v['r_formula']) : $r_rp1;
            $r_rp2 = strpos($v['r_formula'], 'nt')!==FALSE ? $math_past->execute($v['r_formula']) : 0;
            $r_rp2 = strpos($v['r_formula'], 'R')!==FALSE ? $math_past->execute($v['r_formula']) : $r_rp2;
            $r_nonsum = $v['r_formula']!=='' ? '0' : '1';
            $data[] = array(
                'l_desc'=>$v['l_desc'],
                'l_line'=>$v['l_line'],
                'l_bold'=>$v['l_bold'],
                'l_rpmin1bln'=>number_format($l_rp1,2),
                'l_rpmin1thn'=>number_format($l_rp2,2),
                'l_nonsum'=>$l_nonsum,
                'r_desc'=>$v['r_desc'],
                'r_line'=>$v['r_line'],
                'r_bold'=>$v['r_bold'],
                'r_rpmin1bln'=>number_format($r_rp1,2),
                'r_rpmin1thn'=>number_format($r_rp2,2),
                'r_nonsum'=>$r_nonsum
            );
            if($v['l_var']!=='') {
                $math_now->setVars(
                    array(
                        $v['l_var']=>$l_rp1
                    ),
                    FALSE
                );
                $math_past->setVars(
                    array(
                        $v['l_var']=>$l_rp2
                    ),
                    FALSE
                );
            }
            if($v['r_var']!=='') {
                $math_now->setVars(
                    array(
                        $v['r_var']=>$r_rp1
                    ),
                    FALSE
                );
                $math_past->setVars(
                    array(
                        $v['r_var']=>$r_rp2
                    ),
                    FALSE
                );
            }
        }
        return $data;
    }

    public function gen_rpt_neraca_lajur($periode) {
        list($bln, $thn) = explode('-', $periode);
        $tgl_s = $thn.'-'.$bln.'-01';
        $tgl_e = date("Y-m-t", strtotime($tgl_s));
        // build sql
        $sql = "
            SELECT
                tbl.kode,
                tbl.nama,
                SUM(tbl.sa_d) AS sa_d,
                SUM(tbl.sa_k) AS sa_k,
                SUM(tbl.now_d) AS now_d,
                SUM(tbl.now_k) AS now_k
            FROM
                (
                    SELECT
                        coa.kode,
                        coa.nama,
                        CASE
                    WHEN IFNULL(SUM(sa.rp_dk), 0) > 0 THEN
                        IFNULL(SUM(sa.rp_dk), 0)
                    ELSE
                        0
                    END sa_d,
                    CASE
                WHEN IFNULL(SUM(sa.rp_dk), 0) < 0 THEN
                    IFNULL(SUM(sa.rp_dk) *- 1, 0)
                ELSE
                    0
                END sa_k,
                0 now_d,
                0 now_k
            FROM
                (
                    SELECT
                        kode_coa,
                        SUM(
                            CASE
                            WHEN dk = 'D' THEN
                                rupiah
                            ELSE
                                (rupiah *- 1)
                            END
                        ) AS rp_dk
                    FROM
                        tr_accounting
                    WHERE
                        tanggal < '$tgl_s'
                    AND kode_divisi = 'P'
                    AND kode_spk = '2WGA13'
                    GROUP BY
                        kode_coa
                ) sa
            LEFT JOIN mst_coa coa ON sa.kode_coa LIKE CONCAT(coa.kode, '%')
            GROUP BY
                coa.kode
            HAVING
                IFNULL(SUM(sa.rp_dk), 0) <> 0
            UNION ALL
                SELECT
                    coa.kode,
                    coa.nama,
                    0 sa_d,
                    0 sa_k,
                    IFNULL(SUM(now.rp_d), 0) now_d,
                    IFNULL(SUM(now.rp_k), 0) now_k
                FROM
                    (
                        SELECT
                            kode_coa,
                            SUM(
                                CASE
                                WHEN dk = 'D' THEN
                                    rupiah
                                ELSE
                                    0
                                END
                            ) AS rp_d,
                            SUM(
                                CASE
                                WHEN dk = 'K' THEN
                                    rupiah
                                ELSE
                                    0
                                END
                            ) AS rp_k
                        FROM
                            tr_accounting
                        WHERE
                            tanggal >= '$tgl_s'
                        AND tanggal <= '$tgl_e'
                        AND kode_divisi = 'P'
                        AND kode_spk = '2WGA13'
                        GROUP BY
                            kode_coa
                    ) AS now
                LEFT JOIN mst_coa coa ON now.kode_coa LIKE CONCAT(coa.kode, '%')
                GROUP BY
                    coa.kode
                ) AS tbl
            GROUP BY
                tbl.kode
        ";
        $q = $this->db->query($sql);
        return $q->result_array();
    }

    public function gen_rpt_labarugi($periode) {
        list($bln, $thn) = explode('-', $periode);
        $tgl_now_s = $thn.'-'.$bln.'-01';
        $tgl_now_e = date("Y-m-t", strtotime($tgl_now_s));
        $tgl_year_s = $thn.'-01-01';
        // build sql
        $sql = "
            SELECT
                tmpl_coa.coa,
                tmpl_coa.varname,
                IFNULL(rpmin1bln_d.rp, 0) AS rpmin1bln_d,
                IFNULL(rp_now_d.rp, 0) AS rp_now_d,
                IFNULL(rpmin1bln_p.rp, 0) AS rpmin1bln_p,
                IFNULL(rp_now_p.rp, 0) AS rp_now_p
            FROM
                template_coa_list tmpl_coa
            LEFT JOIN (
                SELECT
                    tmpl_coa.coa,
                    SUM(
                        CASE
                        WHEN dk = 'D' THEN
                            acc.rupiah
                        ELSE
                            (acc.rupiah *- 1)
                        END
                    ) AS rp
                FROM
                    template_coa_list tmpl_coa
                LEFT JOIN tr_accounting acc ON acc.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                WHERE
                    acc.tanggal >= '$tgl_year_s'
                AND acc.tanggal < '$tgl_now_s'
                AND acc.tr_level = 'Dept'
                AND acc.kode_divisi = 'P'
                GROUP BY
                    tmpl_coa.coa
            ) rpmin1bln_d ON rpmin1bln_d.coa = tmpl_coa.coa
            LEFT JOIN (
                SELECT
                    tmpl_coa.coa,
                    SUM(
                        CASE
                        WHEN dk = 'D' THEN
                            acc.rupiah
                        ELSE
                            (acc.rupiah *- 1)
                        END
                    ) AS rp
                FROM
                    template_coa_list tmpl_coa
                LEFT JOIN tr_accounting acc ON acc.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                WHERE
                    acc.tanggal >= '$tgl_now_s'
                AND acc.tanggal <= '$tgl_now_e'
                AND acc.tr_level = 'Dept'
                AND acc.kode_divisi = 'P'
                GROUP BY
                    tmpl_coa.coa
            ) rp_now_d ON rp_now_d.coa = tmpl_coa.coa
            LEFT JOIN (
                SELECT
                    tmpl_coa.coa,
                    SUM(
                        CASE
                        WHEN dk = 'D' THEN
                            acc.rupiah
                        ELSE
                            (acc.rupiah *- 1)
                        END
                    ) AS rp
                FROM
                    template_coa_list tmpl_coa
                LEFT JOIN tr_accounting acc ON acc.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                WHERE
                    acc.tanggal >= '$tgl_year_s'
                AND acc.tanggal < '$tgl_now_s'
                AND acc.tr_level = 'Proyek'
                AND acc.kode_divisi = 'P'
                GROUP BY
                    tmpl_coa.coa
            ) rpmin1bln_p ON rpmin1bln_p.coa = tmpl_coa.coa
            LEFT JOIN (
                SELECT
                    tmpl_coa.coa,
                    SUM(
                        CASE
                        WHEN dk = 'D' THEN
                            acc.rupiah
                        ELSE
                            (acc.rupiah *- 1)
                        END
                    ) AS rp
                FROM
                    template_coa_list tmpl_coa
                LEFT JOIN tr_accounting acc ON acc.kode_coa LIKE CONCAT(tmpl_coa.coa, '%')
                WHERE
                    acc.tanggal >= '$tgl_now_s'
                AND acc.tanggal <= '$tgl_now_e'
                AND acc.tr_level = 'Proyek'
                AND acc.kode_divisi = 'P'
                GROUP BY
                    tmpl_coa.coa
            ) rp_now_p ON rp_now_p.coa = tmpl_coa.coa
            WHERE
                tmpl_coa.coa <> ''
            AND tmpl_coa.jenis_rpt = 'LBRG'
            GROUP BY
                tmpl_coa.coa
        ";
        $qVar = $this->db->query($sql);
        $resVar = $qVar->result_array();
        // math lib
        $this->load->library('MathParser');
        $math_now_d = new MathParser();
        $math_now_p = new MathParser();
        $math_past_d = new MathParser();
        $math_past_p = new MathParser();
        // register var & val
        foreach ($resVar as $k => $v) {
            $math_past_d->setVars(
                array(
                    $v['varname']=>$v['rpmin1bln_d']
                ),
                FALSE
            );
            $math_now_d->setVars(
                array(
                    $v['varname']=>$v['rp_now_d']
                ),
                FALSE
            );
            $math_past_p->setVars(
                array(
                    $v['varname']=>$v['rpmin1bln_p']
                ),
                FALSE
            );
            $math_now_p->setVars(
                array(
                    $v['varname']=>$v['rp_now_p']
                ),
                FALSE
            );
        }
        // get rpt template
        $qTmpl = $this->db->query("
            SELECT 
                _line,
                is_bold,
                description,
                IFNULL(varname,'') AS varname, 
                IFNULL(_formula, '') AS _formula
            FROM 
                template_report 
            WHERE 
                jenis_rpt = 'LBRG' 
            ORDER BY 
                no_urut");
        $resTmpl = $qTmpl->result_array();
        $data = array();
        foreach ($resTmpl as $k => $v) {
            $rp_past_d = strpos($v['_formula'], 'lb')!==FALSE ? $math_past_d->execute($v['_formula']) : 0;
            $rp_past_d = strpos($v['_formula'], 'L')!==FALSE ? $math_past_d->execute($v['_formula']) : $rp_past_d;
            $rp_now_d = strpos($v['_formula'], 'lb')!==FALSE ? $math_now_d->execute($v['_formula']) : 0;
            $rp_now_d = strpos($v['_formula'], 'L')!==FALSE ? $math_now_d->execute($v['_formula']) : $rp_now_d;
            $rp_past_p = strpos($v['_formula'], 'lb')!==FALSE ? $math_past_p->execute($v['_formula']) : 0;
            $rp_past_p = strpos($v['_formula'], 'L')!==FALSE ? $math_past_p->execute($v['_formula']) : $rp_past_p;
            $rp_now_p = strpos($v['_formula'], 'lb')!==FALSE ? $math_now_p->execute($v['_formula']) : 0;
            $rp_now_p = strpos($v['_formula'], 'L')!==FALSE ? $math_now_p->execute($v['_formula']) : $rp_now_p;
            $data[] = array(
                'description'=>$v['description'],
                'line'=>$v['_line'],
                'isbold'=>$v['is_bold'],
                'rp_past_d'=>$rp_past_d,
                'rp_now_d'=>$rp_now_d,
                'rp_past_p'=>$rp_past_p,
                'rp_now_p'=>$rp_now_p,
                'is_nonsum'=>$v['_formula']==='' ? '1' : '0'
            );
            if($v['varname']!=='') {
                $math_past_d->setVars(
                    array(
                        $v['varname']=>$rp_past_d
                    ),
                    FALSE
                );
                $math_now_d->setVars(
                    array(
                        $v['varname']=>$rp_now_d
                    ),
                    FALSE
                );
                $math_past_p->setVars(
                    array(
                        $v['varname']=>$rp_past_p
                    ),
                    FALSE
                );
                $math_now_p->setVars(
                    array(
                        $v['varname']=>$rp_now_p
                    ),
                    FALSE
                );
            }
        }
        return $data;
    }
}