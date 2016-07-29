<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "home";
$route['404_override'] = '';

// login
$route['login'] = 'login';
// $route['login/form'] = 'login/form'; 
$route['login/do'] = 'login/doLogin'; 
$route['logout'] = 'login/doLogout'; 

// home
$route['home'] = 'home';

//tool
$route['gen-dashboard'] 				= 'app/generate_dashboard';
$route['gen-dashboard/generate/(:any)'] = 'app/gen_dashboard/$1';

$route['bank/delete/(:num)'] = 'mst_bank/delete/$1';
$route['bank/edit/(:num)'] = 'mst_bank/form/$1';
$route['bank/save'] = 'mst_bank/save';
$route['bank/form'] = 'mst_bank/form';
$route['bank/DT'] = 'mst_bank/genDT';
$route['bank'] = 'mst_bank';

$route['bank-alokasi/child/(:any)/(:any)'] 		= 'mst_bank/open_child/$1/$2';
$route['bank-alokasi/save'] 				= 'mst_bank/save_alokasi';
$route['bank-alokasi/DT'] 					= 'mst_bank/genDT_alokasi';
$route['bank-alokasi/(:any)'] 				= 'mst_bank/get_alokasi/$1';
$route['bank-alokasi'] 						= 'mst_bank/form_alokasi';


$route['bank-plafond/save'] 				= 'mst_bank/save_plafond';
$route['bank-plafond/DT'] 					= 'mst_bank/genDT_plafond';
$route['bank-plafond/(:any)'] 					= 'mst_bank/get_plafond/$1';
$route['bank-plafond'] 							= 'mst_bank/form_plafond';

//irul
$route['jurnal/bank-in/entry'] 						= 'tr_accounting/bank_form/in';
$route['jurnal/bank-in/post'] 						= 'tr_accounting/bank_posting/in';
$route['jurnal/bank-in/post/dt'] 					= 'tr_accounting/genDT_bankpost_confirm_payment';
$route['jurnal/bank-in/voucher'] 					= 'tr_accounting/bank_form/in';
$route['jurnal/bank-in/voucher/dt'] 				= 'tr_accounting/gen_bankinout_data';
$route['jurnal/bank-out/entry'] 					= 'tr_accounting/bank_form/out';
$route['jurnal/bank-out/post'] 						= 'tr_accounting/bank_form';
$route['jurnal/bank-ou/voucher'] 					= 'tr_accounting/bank_form/out';
$route['jurnal/bank-out/voucher/dt'] 				= 'tr_accounting/gen_bankinout_data';
 

$route['optional-stock'] = 'mst_optional_stock';
$route['optional-stock/save'] = 'mst_optional_stock/save';
$route['optional-stock/DT/(:any)'] = 'mst_optional_stock/genDT/$1';
$route['optional-stock/edit/(:num)'] = 'mst_optional_stock/form/$1';
$route['optional-stock/delete/(:num)'] = 'mst_optional_stock/delete/$1';

$route['stock'] = 'mst_stock';
$route['stock/form'] = 'mst_stock/form';
$route['stock/save'] = 'mst_stock/save';
$route['stock/DT'] = 'mst_stock/genDT';
$route['stock/DT-view'] = 'mst_stock/genDT_ro';
$route['stock/edit/(:num)'] = 'mst_stock/form/$1';
$route['stock/delete/(:num)'] = 'mst_stock/delete/$1';

$route['nasabah'] 					= 'mst_nasabah';
$route['nasabah/form'] 			= 'mst_nasabah/form';
$route['nasabah/save'] 			= 'mst_nasabah/save';
$route['nasabah/DT'] 				= 'mst_nasabah/genDT';
$route['nasabah/edit/(:num)'] 		= 'mst_nasabah/form/$1';
$route['nasabah/delete/(:num)'] 	= 'mst_nasabah/delete/$1';

$route['optional'] = 'mst_optional';
$route['optional/form'] = 'mst_optional/form';
$route['optional/save'] = 'mst_optional/save';
$route['optional/DT'] = 'mst_optional/genDT';
$route['optional/edit/(:num)'] = 'mst_optional/form/$1';
$route['optional/delete/(:num)'] = 'mst_optional/delete/$1';

$route['optional-unit-price'] = 'mst_optional_unit_price';
$route['optional-unit-price/save'] = 'mst_optional_unit_price/save';
$route['optional-unit-price/DT/(:any)'] = 'mst_optional_unit_price/genDT/$1';
$route['optional-unit-price/edit/(:num)'] = 'mst_optional_unit_price/form/$1';
$route['optional-unit-price/delete/(:num)'] = 'mst_optional_unit_price/delete/$1';

$route['unit-price/round/(:any)'] = 'mst_unit_price/set_rounding/$1';
$route['unit-price/form/(:num)'] = 'mst_unit_price/form/$1';
$route['unit-price/get/(:any)'] = 'mst_unit_price/get_price/$1';
// $route['unit-price/edit/(:num)'] = 'mst_unit_price/form/$1';
$route['unit-price/delete/(:num)'] = 'mst_unit_price/delete/$1';
$route['unit-price/form'] = 'mst_unit_price/form';
$route['unit-price/save'] = 'mst_unit_price/save';
$route['unit-price/DT'] = 'mst_unit_price/genDT';
$route['unit-price'] = 'mst_unit_price/form';
/*
$route['perijinan/save/tanggal'] = 'mst_perijinan/save_tanggal';
$route['perijinan/save'] = 'mst_perijinan/save';
$route['perijinan/DT'] = 'mst_perijinan/genDT';
$route['perijinan/(:any)'] = 'mst_perijinan/get_unit/$1';
$route['perijinan'] = 'mst_perijinan';
*/
$route['perijinan/save/master-2'] 				= 'mst_perijinan/save_master_2';
$route['perijinan/save/master'] 				= 'mst_perijinan/save_master';
$route['perijinan/save/tanggal'] 				= 'mst_perijinan/save_tanggal';
$route['perijinan/save'] 						= 'mst_perijinan/save';
$route['perijinan/unit'] 						= 'mst_perijinan/get_master_unit';
$route['perijinan/master-2'] 					= 'mst_perijinan/form_master_2';
$route['perijinan/master'] 						= 'mst_perijinan/form_master';
$route['perijinan/unit'] 						= 'mst_perijinan/get_master_unit';
$route['perijinan/DT'] 							= 'mst_perijinan/genDT';
$route['perijinan/(:any)'] 						= 'mst_perijinan/get_unit/$1';
$route['perijinan'] 							= 'mst_perijinan';
$route['perijinan-list']            			= 'mst_perijinan/table_perijinan';
$route['perijinan-list/DT']            			= 'mst_perijinan/genDT_perijinan';
// b: ade 20151015 => optional perijinan
$route['optional-perijinan']            		= 'mst_perijinan/table_optional';
$route['optional-perijinan/form/(:num)']  		= 'mst_perijinan/form_optional/$1';
$route['optional-perijinan/form']         		= 'mst_perijinan/form_optional';
$route['optional-perijinan/DT']           		= 'mst_perijinan/genDT_optional';
$route['optional-perijinan/save']         		= 'mst_perijinan/save_optional';
$route['optional-perijinan/delete/(:num)']		= 'mst_perijinan/delete_optional/$1';


$route['payment-plan/delete/(:any)/(:num)'] 	= 'mst_payment_plan/delete/$1/$2';
$route['payment-plan/form/(:any)/(:num)'] 		= 'mst_payment_plan/form/$1/$2';
$route['payment-plan/save/(:any)'] 				= 'mst_payment_plan/save/$1';
$route['payment-plan/form/(:any)'] 				= 'mst_payment_plan/form/$1';
$route['payment-plan/DT/(:any)'] 				= 'mst_payment_plan/genDT/$1';
$route['payment-plan/(:any)'] 					= 'mst_payment_plan/table/$1';

$route['entity'] 								= 'mst_entity';
$route['entity/form'] 							= 'mst_entity/form';
$route['entity/save'] 							= 'mst_entity/save';
$route['entity/DT'] 							= 'mst_entity/genDT';
$route['entity/edit/(:num)'] 					= 'mst_entity/form/$1';
$route['entity/delete/(:num)'] 					= 'mst_entity/delete/$1';

// $route['hold/get/filter/(:any)/(:any)'] = 'tr_sales/get_hold_filterby/$1/$2';
// $route['hold/get/group/(:any)'] = 'tr_sales/get_hold_groupby/$1';
// $route['hold/get/(:any)'] = 'tr_sales/get_hold/$1';
// $route['hold/DT/(:any)'] = 'tr_sales/genDT_hold/$1';

$route['hold/extend/(:any)'] 					= 'tr_sales/extend_hold/$1';
$route['hold/cancel/(:any)'] 					= 'tr_sales/cancel_hold/$1';
$route['hold/(:any)'] 							= 'tr_sales/form_hold_2/$1';
$route['hold/DT'] 								= 'tr_sales/genDT_stock';
$route['hold/DTret'] 							= 'tr_sales/genDT_hold';
$route['hold/save'] 							= 'tr_sales/save_hold';
$route['hold'] 									= 'tr_sales/form_hold';
$route['hold'] 									= 'tr_sales/form_hold'; 
$route['hold/lookup/(:any)']					= 'tr_sales/lookup/$1';
$route['hold/DTCustomer'] 						= 'tr_sales/genDTcustomer';

$route['reserve/get/payment-plan/(:any)'] 		= 'tr_sales/get_reserve_payment/$1';
$route['reserve/get/payment-mode/(:any)'] 		= 'tr_sales/get_reserve_payment_det/$1';
$route['reserve/payment/(:num)'] 				= 'tr_sales/get_payment/$1';
$route['reserve/get/(:any)'] 					= 'tr_sales/get_reserve/$1';
$route['reserve/save'] 							= 'tr_sales/save_reserve';
$route['reserve/DT/(:any)'] 					= 'tr_sales/genDT_stock/$1';
$route['reserve/(:any)'] 						= 'tr_sales/form_reserve_2/$1';
$route['reserve/DT'] 							= 'tr_sales/genDT_stock';
$route['reserve/DTret'] 						= 'tr_sales/genDT_reserve';
$route['reserve'] 								= 'tr_sales/form_reserve';

$route['payplan']								= 'tr_sales/form_payplan';
$route['payplan/(:any)']						= 'tr_sales/form_payplan/$1';

$route['booking/payment/(:any)/(:any)/(:any)'] 	= 'tr_sales/get_saved_payment/$1/$2/$3';
$route['booking/get/payment-mode/(:any)'] 		= 'tr_sales/get_reserve_payment_det/$1';
$route['booking/payment/(:num)'] 				= 'tr_sales/get_payment/$1';
$route['booking/get/(:any)'] 					= 'tr_sales/get_booking/$1';
$route['booking/save'] 							= 'tr_sales/save_booking';
$route['booking/DT'] 							= 'tr_sales/genDT_stock';
$route['booking/DTret'] 						= 'tr_sales/genDT_booking';
$route['booking/(:any)'] 						= 'tr_sales/form_booking_2/$1';
$route['booking'] 								= 'tr_sales/form_booking';

$route['pesanan'] 								= 'tr_sales/form_pesanan';
$route['pesanan/save'] 							= 'tr_sales/save_pesanan';
$route['pesanan/get/(:any)'] 					= 'tr_sales/get_booking/$1';
$route['pesanan/payment/(:num)'] 				= 'tr_sales/get_payment/$1';

$route['payment/kuitansi/(:any)'] 				= 'tr_sales/pdf_kwitansi/$1';
$route['payment/get/(:any)'] 					= 'tr_sales/get_payment_details/$1';
$route['payment/save'] 							= 'tr_sales/save_confirm_payment';
$route['payment/DT'] 							= 'tr_sales/genDT_confirm_payment';
$route['payment'] 								= 'tr_sales/form_confirm_payment';

$route['custom-ppl']							= 'tr_ubah_payplant/form';
$route['custom-ppl/DT']							= 'tr_sales/genDT_confirm_payment';

$route['ri-kpr/save'] 							= 'tr_ri_kpr/save';
$route['ri-kpr/DT'] 							= 'tr_ri_kpr/genDT';
$route['ri-kpr/(:any)'] 						= 'tr_ri_kpr/get_tr/$1';
$route['ri-kpr'] 								= 'tr_ri_kpr';

$route['set-entity/(:any)'] 					= 'home/session_set_entity/$1';
$route['set-divisi/(:any)'] 					= 'home/session_set_divisi/$1';

$route['sales-dashboard'] 						= 'tr_sales/form_dashboard';
$route['dashboard'] 							= 'tr_sales/dashboard';

$route['display-dashboard'] 					= 'tr_sales/display_dashboard';


$route['sales-cancel/get-reserve/(:any)'] 		= 'tr_sales/get_reserve_and_payment_data/$1';
$route['sales-cancel/save'] 					= 'tr_sales/save_cancellation';
$route['sales-cancel'] 							= 'tr_sales/form_cancellation';
$route['cancel-hold'] 							= 'tr_sales/list_cancel_hold';
$route['cancel-hold/batal/(:any)'] 				= 'tr_sales/cancel_hold_byadmin/$1';
$route['cancel-hold-dt'] 						= 'tr_sales/list_cancel_hold_dt';

$route['sales-change-owner'] 					= 'tr_sales/form_change_owner';
$route['sales-change-owner/save'] 				= 'tr_sales/save_change_owner';

$route['sales-change-unit'] 					= 'tr_sales/form_change_unit';
$route['sales-change-unit/save'] 				= 'tr_sales/save_change_unit';


$route['sales-change-owner'] 					= 'tr_sales/form_change_owner';
$route['sales-change-owner/save'] 				= 'tr_sales/save_change_owner';

$route['sales-change-unit'] 					= 'tr_sales/form_change_unit';
$route['sales-change-unit/save'] 				= 'tr_sales/save_change_unit';
 
$route['sales/rpt-op/(:any)/(:any)'] 				= 'rpt_sales/form_rpt_op/$1/$2';
$route['sales/rpt-ok/(:any)/(:any)'] 				= 'rpt_sales/form_rpt_ok/$1/$2';
$route['sales/penagihan-kpr/(:any)/(:any)'] 		= 'rpt_sales/form_penagihan_kpr/$1/$2';
$route['sales/penagihan/(:any)/(:any)'] 			= 'rpt_sales/form_penagihan/$1/$2';
$route['sales/penagihannew/(:any)/(:any)'] 			= 'rpt_sales/form_penagihannew/$1/$2';
$route['sales/kartu-piutang/(:any)/(:any)'] 		= 'rpt_sales/form_kartu_piutang/$1/$2';
$route['sales/kartu-piutangnew/(:any)/(:any)'] 		= 'rpt_sales/form_kartu_piutangnew/$1/$2';
$route['sales/kartu-nasabah/(:any)/(:any)'] 		= 'rpt_sales/form_kartu_nasabah/$1/$2';
$route['sales/konfirmasi-unit/(:any)/(:any)'] 		= 'rpt_sales/rpt_kesepakatan_pesanan/$1/$2';
$route['sales/surat-pesanan/(:any)/(:any)'] 		= 'rpt_sales/form_surat_pesanan/$1/$2';
$route['sales/surat-pesanan/(:any)/(:any)'] 		= 'rpt_sales/rpt_suratpesanan/$1/$2';
$route['sales/kartu-stock-opname/(:any)'] 			= 'rpt_sales/form_kartu_masterstock/$1';
$route['sales/filter/(:any)/(:any)'] 				= 'tr_sales/get_filterby/$1/$2';
$route['sales/report/(:any)'] 						= 'rpt_sales/index/$1';
$route['sales/get-group/(:any)'] 					= 'tr_sales/get_groupby/$1';
$route['sales/get/(:any)'] 							= 'tr_sales/get_unit/$1';
$route['sales/payment-plan/(:any)'] 				= 'tr_sales/get_payment_plan/$1';
$route['sales/payment-mode/(:any)'] 				= 'tr_sales/get_payment_mode/$1';
$route['sales/DT-stock/(:any)'] 					= 'rpt_sales/genDT_stock/$1';
$route['sales/DT-customer/(:any)'] 					= 'rpt_sales/genDT_customer/$1';

$route['sales-agent'] 								= 'mst_sales_agent';
$route['sales-agent/DT'] 							= 'mst_sales_agent/saDT';
$route['sales-agent/edit/(:any)'] 					= 'mst_sales_agent/form/$1';
$route['sales-agent/skp/(:any)']					= 'mst_sales_agent/change_sales_skp/$1';
$route['sales-agent/skp/save']						= 'mst_sales_agent/ubah_saler';

/*
$route['sales/penagihan/(:any)/(:any)'] 		= 'rpt_sales/form_penagihan/$1/$2';
$route['sales/kartu-piutang/(:any)/(:any)'] 	= 'rpt_sales/form_kartu_piutang/$1/$2';
$route['sales/kartu-nasabah/(:any)/(:any)'] 	= 'rpt_sales/form_kartu_nasabah/$1/$2';
$route['sales/konfirmasi-unit/(:any)/(:any)'] 	= 'rpt_sales/rpt_kesepakatan_pesanan/$1/$2';
//$route['sales/konfirmasi-unit/(:any)/(:any)'] 	= 'rpt_sales/form_konfirmasi_unit/$1/$2';
$route['sales/surat-pesanan/(:any)/(:any)'] 	= 'rpt_sales/form_surat_pesanan/$1/$2';
$route['sales/surat-pesanan/(:any)/(:any)'] 	= 'rpt_sales/rpt_suratpesanan/$1/$2';
$route['sales/filter/(:any)/(:any)'] 			= 'tr_sales/get_filterby/$1/$2';
$route['sales/report/(:any)'] 					= 'rpt_sales/index/$1';
$route['sales/get-group/(:any)'] 				= 'tr_sales/get_groupby/$1';
$route['sales/get/(:any)'] 						= 'tr_sales/get_unit/$1';
$route['sales/payment-plan/(:any)'] 			= 'tr_sales/get_payment_plan/$1';
$route['sales/payment-mode/(:any)'] 			= 'tr_sales/get_payment_mode/$1';
$route['sales/DT-stock/(:any)'] 				= 'rpt_sales/genDT_stock/$1';
$route['sales/DT-customer/(:any)'] 				= 'rpt_sales/genDT_customer/$1';
//new
$route['sales/penagihannew/(:any)/(:any)'] 		= 'rpt_sales/form_penagihannew/$1/$2';
$route['sales/kartu-piutangnew/(:any)/(:any)'] 	= 'rpt_sales/form_kartu_piutangnew/$1/$2';
*/

$route['sales/coba'] 							= 'rpt_sales/rpt_coba';
$route['sales/rpt_sp/(:any)/(:any)'] 			= 'rpt_sales/rpt_suratpesanan/$1/$2';
$route['sales/rpt_skp/(:any)/(:any)'] 			= 'rpt_sales/rpt_kesepakatan_pesanan/$1/$2';
$route['sales/rpt_paydetail/(:any)/(:any)'] 	= 'rpt_sales/rpt_konfirmasi_pembayaran/$1/$2';
/* u */ 
$route['sumberdaya'] 							= 'mst_sumberdaya';
$route['sumberdaya/DT'] 						= 'mst_sumberdaya/genDT';
$route['sumberdaya/form'] 						= 'mst_sumberdaya/form';
$route['sumberdaya/save'] 						= 'mst_sumberdaya/save';
$route['sumberdaya/edit/(:num)'] 				= 'mst_sumberdaya/form/$1';
$route['sumberdaya/delete/(:num)'] 				= 'mst_sumberdaya/delete/$1';

$route['harga-sumberdaya'] 						= 'mst_harga_sumberdaya';
$route['harga-sumberdaya/save'] 				= 'mst_harga_sumberdaya/save';
$route['harga-sumberdaya/DT/(:any)'] 			= 'mst_harga_sumberdaya/genDT/$1';
$route['harga-sumberdaya/delete/(:num)'] 		= 'mst_harga_sumberdaya/delete/$1';

$route['rekanan'] 								= 'mst_rekanan';
$route['rekanan/DT'] 							= 'mst_rekanan/genDT';
$route['rekanan/form'] 							= 'mst_rekanan/form';
$route['rekanan/save'] 							= 'mst_rekanan/save';
$route['rekanan/edit/(:num)'] 					= 'mst_rekanan/form/$1';
$route['rekanan/delete/(:num)'] 				= 'mst_rekanan/delete/$1';

$route['tahap-pekerjaan'] = 'mst_tahap_pekerjaan';
$route['tahap-pekerjaan/DT'] = 'mst_tahap_pekerjaan/genDT';
$route['tahap-pekerjaan/save'] = 'mst_tahap_pekerjaan/save';
$route['tahap-pekerjaan/form'] = 'mst_tahap_pekerjaan/form';
$route['tahap-pekerjaan/edit/(:num)'] = 'mst_tahap_pekerjaan/form/$1';
$route['tahap-pekerjaan/delete/(:num)'] = 'mst_tahap_pekerjaan/delete/$1';

$route['kontrak'] = 'tr_kontrak';
$route['kontrak/DT'] = 'tr_kontrak/genDT';
$route['kontrak/form'] = 'tr_kontrak/form';
$route['kontrak/save'] = 'tr_kontrak/save';
$route['kontrak/edit/(:num)'] = 'tr_kontrak/form/$1';
$route['kontrak/delete/(:num)'] = 'tr_kontrak/delete/$1';

$route['opname-progress'] = 'tr_opname_progress';
$route['opname-progress/form'] = 'tr_opname_progress/form';
$route['opname-progress/DT'] = 'tr_opname_progress/genDT';
$route['opname-progress/save'] = 'tr_opname_progress/save';
$route['opname-progress/edit/(:num)'] = 'tr_opname_progress/form/$1';
$route['opname-progress/delete/(:num)'] = 'tr_opname_progress/delete/$1';

$route['po'] 						= 'tr_po';
$route['po/DT'] 					= 'tr_po/genDT';
$route['po/form']				 	= 'tr_po/form';
$route['po/save'] 					= 'tr_po/save';
$route['po/edit/(:num)'] 			= 'tr_po/form/$1';
$route['po/delete/(:num)'] 			= 'tr_po/delete/$1';
$route['po/f_unit/(:num)'] 			= 'tr_po/load_child/$1';
$route['po/d_unit/(:num)'] 			= 'tr_po/del_unit/$1';
$route['po/genCUnit'] 				= 'tr_po/genNoUnitEdit';
$route['po/ad_unit'] 				= 'tr_po/add_unit';

//irul-12/08/2015
$route['sppk'] 					= 'tr_spk_pekerjaan';
$route['sppk/DT'] 				= 'tr_spk_pekerjaan/genDT';
$route['sppk/form'] 			= 'tr_spk_pekerjaan/form';
$route['sppk/save'] 			= 'tr_spk_pekerjaan/save';
$route['sppk/delete/(:num)'] 	= 'tr_spk_pekerjaan/delete/$1';
$route['sppk/edit/(:num)'] 		= 'tr_spk_pekerjaan/form/$1';;
$route['sppk/f_unit/(:num)'] 	= 'tr_spk_pekerjaan/load_child/$1';
$route['sppk/d_unit/(:num)'] 	= 'tr_spk_pekerjaan/del_unit/$1';
$route['sppk/genCUnit'] 		= 'tr_spk_pekerjaan/genNoUnitEdit';
$route['sppk/ad_unit'] 			= 'tr_spk_pekerjaan/add_unit';

$route['bapb'] 					= 'tr_bapb';
$route['bapb/form'] 			= 'tr_bapb/form';
$route['bapb/edit/(:num)'] 		= 'tr_bapb/form/$1';
$route['bapb/DT'] 				= 'tr_bapb/genDT';
$route['bapb/DT-po'] 			= 'tr_bapb/genDT_po';
$route['bapb/save'] 			= 'tr_bapb/save';
$route['bapb/get/(:any)'] 		= 'tr_bapb/get_po/$1';

$route['bpm'] = 'tr_bpm';
$route['bpm/DT'] = 'tr_bpm/genDT';
$route['bpm/form'] = 'tr_bpm/form';
$route['bpm/save'] = 'tr_bpm/save';
$route['bpm/edit/(:num)'] = 'tr_bpm/form/$1';
$route['bpm/delete/(:num)'] = 'tr_bpm/delete/$1';

$route['rencana'] = 'mst_rik';
$route['rencana/DT'] = 'mst_rik/genDT';
$route['rencana/save'] = 'mst_rik/save';
$route['rencana/(:any)'] = 'mst_rik/form/$1';

$route['bpdp'] = 'tr_bpdp';
$route['bpdp/DT'] = 'tr_bpdp/genDT';
$route['bpdp/save'] = 'tr_bpdp/save';
$route['bpdp/form/(:any)/(:num)/(:any)/(:any)'] = 'tr_bpdp/get/$1/$2/$3/$4';
$route['bpdp/form/(:any)/(:num)'] = 'tr_bpdp/get/$1/$2';
$route['bpdp/form/(:any)'] = 'tr_bpdp/form/$1';

$route['invoice/delete/(:num)'] = 'tr_invoice/delete/$1';
$route['invoice/edit/(:num)'] = 'tr_invoice/form/$1';
$route['invoice/save'] = 'tr_invoice/save';
$route['invoice/form'] = 'tr_invoice/form';
$route['invoice/DT'] = 'tr_invoice/genDT';
$route['invoice'] = 'tr_invoice';

$route['hpp'] 							= 'tr_hpp/form';
$route['hpp/DT'] 						= 'tr_hpp/genDT';
$route['hpp/save'] 						= 'tr_hpp/save';
$route['hpp/save/(:num)'] 				= 'tr_hpp/save/$1';
$route['hpp/get-hpp/(:any)'] 			= 'tr_hpp/get_hpp_hr/$1';
$route['hpp/get/(:any)'] 				= 'tr_hpp/get_hpp/$1';

$route['rpt-progress'] 					= 'tr_hpp/form_progress';
$route['rpt-progress/DT'] 				= 'tr_hpp/genDT_progress';
/* end : u */

$route['jurnal-entry/(:any)'] 			= 'tr_accounting/entry_jurnal/$1';
$route['jurnal/voucher/(:any)'] 		= 'tr_accounting/simpan_voucher/$1';
$route['jurnal/voucher-print/(:num)'] 	= 'tr_bank/print_voucher/$1';
$route['jurnal/ar/(:num)'] 				= 'tr_accounting/do_integration_ar/$1';
$route['jurnal/ar/DT'] 					= 'tr_accounting/genDT_ar';
$route['jurnal/ar'] 					= 'tr_accounting/form_integrasi_ar';
$route['jurnal/view'] 					= 'tr_accounting/view_jurnal';
$route['jurnal/view2'] 					= 'tr_accounting/view_jurnal2';
$route['jurnal/view2/page'] 			= 'tr_accounting/view_jurnal2';
$route['jurnal/page/limit'] 			= 'tr_accounting/page_limit';
$route['jurnal/view2/page/(:num)'] 		= 'tr_accounting/view_jurnal2/$1';
$route['jurnal/view2/page/(:num)/(:num)'] 		= 'tr_accounting/view_jurnal2/$1/$2';
//$route['jurnal/entry'] 				= 'tr_accounting/input_jurnal';
//$route['jurnal/input'] 				= 'tr_accounting/entry_jurnal';
$route['jurnal/batch']	 				= 'tr_accounting/get_batch';
$route['jurnal/simpan'] 				= 'tr_accounting/save_jurnal';
$route['jurnal/DT'] 					= 'tr_accounting/genDT_jurnal';
$route['jurnal/DT/(:any)'] 				= 'tr_accounting/genDT_jurnal/$1';
$route['jurnal/upload'] 				= 'tr_accounting/doUpload';
$route['jurnal/upload/(:any)'] 			= 'tr_accounting/doUpload/$1';
$route['jurnal/trx_upload'] 			= 'tr_accounting/do_transfer';
$route['jurnal/loadupload'] 			= 'tr_accounting/loadjurnal';
$route['jurnal/cek_uploaded'] 			= 'tr_accounting/cek_uploaded';
$route['jurnal/ismandatory/(:any)'] 	= 'tr_accounting/cekMandatory/$1';
$route['jurnal-entry/cekNomorBukti'] 	= 'tr_accounting/cekNomorBukti';
$route['jurnal/lookup/(:any)']			= 'tr_accounting/lookup/$1';
$route['jurnal/slookup/(:any)']			= 'tr_accounting/sales_lookup/$1';
$route['jurnal/DT2'] 					= 'tr_accounting/genDT_jurnal2';
$route['jurnal/del_nobuk'] 				= 'tr_accounting/delete_jurnal';
//$route['jurnal/edit'] 					= 'tr_accounting/entry_jurnal';
$route['jurnal/json_nobuk'] 			= 'tr_accounting/json_jurnalnobuk';
$route['jurnal/json_deco'] 				= 'tr_accounting/json_deco';
$route['jurnal/jsons'] 					= 'tr_accounting/jsons';

$route['jurnal/qview'] 					= 'tr_accounting/query_jurnal';
$route['jurnal/queryjurnal'] 			= 'tr_accounting/queryjurnal';
$route['jurnal/vjurnal_dt/(:any)/(:any)'] 	= 'tr_accounting/genDT_jurnal/$1/$2';
$route['jurnal/listNoBuk']				= 'tr_tools/getListNoBuktiWithBlank';




$route['diskon'] 						= 'mst_diskon/table';
$route['diskon/DT'] 					= 'mst_diskon/genDT';
$route['diskon/form'] 					= 'mst_diskon/form';
$route['diskon/form/(:num)'] 			= 'mst_diskon/form/$1';
$route['diskon/save'] 					= 'mst_diskon/save';
$route['diskon/delete/(:num)'] 			= 'mst_diskon/delete/$1';
$route['diskon/tr'] 					= 'mst_diskon/tr_diskon';
$route['diskon/tr/save'] 				= 'mst_diskon/tr_diskon_save';

/*
---------------------------------------------------------------------------------------------------------------------------
	LAPORAN KEUANGAN
---------------------------------------------------------------------------------------------------------------------------
*/
$route['rpt-acc/neraca-t'] 				= 'tr_accounting/rpt_neraca_t';
$route['rpt-acc/neraca-t/(:any)'] 		= 'tr_accounting/rpt_neraca_t/$1';
$route['rpt-acc/neraca-lajur'] 			= 'tr_accounting/rpt_neraca_lajur';
$route['rpt-acc/neraca-lajur/(:any)'] 	= 'tr_accounting/rpt_neraca_lajur/$1';
$route['rpt-acc/labarugi'] 				= 'tr_accounting/rpt_labarugi';
$route['rpt-acc/labarugi/(:any)'] 		= 'tr_accounting/rpt_labarugi/$1';
$route['rpt-acc/labarugi-proyek/'] 		= 'tr_accounting/rpt_labarugi_proyek';
$route['rpt-acc/labarugi-proyek/(:any)']= 'tr_accounting/rpt_labarugi_proyek/$1';

$route['rpt-acc/ledger'] 				= 'tr_accounting/rpt_bukubesar';
$route['rpt-acc/ledger/(:any)'] 		= 'tr_accounting/rpt_bukubesar/$1';
$route['rpt-acc/kasbank'] 				= 'tr_accounting/rpt_kasbank';
$route['rpt-acc/kasbank/(:any)'] 		= 'tr_accounting/rpt_kasbank/$1';

$route['rpt-acc/ledger2'] 				= 'tr_accounting/rpt_bukubesar_ext';
$route['rpt-acc/ledger2/(:any)'] 		= 'tr_accounting/rpt_bukubesar_ext/$1';

$route['rpt-acc/utang-pemasok'] 					= 'tr_accounting/rpt_utang_pemasok';
$route['rpt-acc/opensystem-pemasok/(:any)'] 		= 'tr_accounting/rpt_utang_pemasok/$1';
$route['rpt-acc/utang-subkon'] 						= 'tr_accounting/rpt_utang_subkon';
$route['rpt-acc/opensystem-subkon/(:any)'] 			= 'tr_accounting/rpt_utang_subkon/$1';
$route['rpt-acc/utang-mandor'] 						= 'tr_accounting/rpt_utang_mandor';
$route['rpt-acc/opensystem-mandor/(:any)'] 			= 'tr_accounting/rpt_utang_mandor/$1';
$route['rpt-acc/utang-badmaterial'] 				= 'tr_accounting/rpt_utang_badmaterial';
$route['rpt-acc/opensystem-badmaterial/(:any)'] 	= 'tr_accounting/rpt_utang_badmaterial/$1';
$route['rpt-acc/utang-badupah'] 					= 'tr_accounting/rpt_utang_badupah';
$route['rpt-acc/opensystem-badupah/(:any)'] 		= 'tr_accounting/rpt_utang_badupah/$1';
$route['rpt-acc/utang-badalat'] 					= 'tr_accounting/rpt_utang_badalat';
$route['rpt-acc/opensystem-badalat/(:any)'] 		= 'tr_accounting/rpt_utang_badalat/$1';
$route['rpt-acc/utang-badsubkon'] 					= 'tr_accounting/rpt_utang_badsubkon';
$route['rpt-acc/opensystem-badsubkon/(:any)'] 		= 'tr_accounting/rpt_utang_badsubkon/$1';
$route['rpt-acc/utang-piutangusaha'] 				= 'tr_accounting/rpt_utang_piutangusaha';
$route['rpt-acc/opensystem-piutangusaha/(:any)'] 	= 'tr_accounting/rpt_utang_piutangusaha/$1';
$route['rpt-acc/utang-piutangretensi'] 				= 'tr_accounting/rpt_utang_piutangretensi';
$route['rpt-acc/opensystem-piutangretensi/(:any)'] 	= 'tr_accounting/rpt_utang_piutangretensi/$1';

/*
* NEW OPENSYSTEM
*/
$route['rpt-opsys'] 								= 'rpt_opensystem/f_periode';
$route['rpt-opsys/(:any)'] 							= 'rpt_opensystem/generateReport/$1';
$route['rpt-opsys/(:any)/(:any)/(:any)'] 			= 'rpt_opensystem/generateReport/$1/$2/$3';

$route['rpt-ops/tes/(:any)/(:any)'] 				= 'rpt_opensystem/rpt_opsys/$1/$2';
/*
*
*/


$route['rpt-acc/utang-pemasok-DT/(:any)'] 			= 'tr_accounting/genDT_utang_pemasok/$1';
$route['rpt-acc/child/bukubesar/(:any)/(:any)'] 	= 'tr_accounting/load_child/$1/$2';

$route['rpt-acc/rk'] 								= 'tr_accounting/rpt_rk';
$route['rpt-acc/rk/(:any)'] 						= 'tr_accounting/rpt_rk/$1';

$route['settos'] 						= 'mst_settingos';
$route['settos/save'] 					= 'mst_settingos/save';
$route['settos/DT'] 					= 'mst_settingos/genDT';
$route['settos/form'] 					= 'mst_settingos/form';
$route['settos/edit/(:num)'] 			= 'mst_settingos/form/$1';
$route['settos/getdata/(:num)'] 		= 'mst_settingos/form/$1';

$route['mandcoa'] 						= 'mst_mandatory_coa';
$route['mandcoa/save'] 					= 'mst_mandatory_coa/save';
$route['mandcoa/update/(:num)'] 		= 'mst_mandatory_coa/save/$1';
$route['mandcoa/delete/(:num)'] 		= 'mst_mandatory_coa/delete/$1';

$route['progress'] 						= 'tr_progress';
$route['progress/unit'] 				= 'tr_progress/get_progress_unit';
$route['progress/save'] 				= 'tr_progress/save';
$route['progress/list'] 				= 'tr_progress/table_progress';
$route['progress/DT'] 					= 'tr_progress/genDT_progress';

// b: ade 20151013 => user group
$route['user-group']            		= 't_user_group';
$route['user-group/menu']         		= 't_user_group/gen_menu';
$route['user-group/menu/(:num)'] 		= 't_user_group/gen_menu/$1';
$route['user-group/form']         		= 't_user_group/form';
$route['user-group/form/(:num)']  		= 't_user_group/form/$1';
$route['user-group/DT']           		= 't_user_group/genDT';
$route['user-group/save']         		= 't_user_group/save';
$route['user-group/delete/(:num)']		= 't_user_group/delete/$1';
// e
// b: ade 20151015 => user
$route['user']            				= 't_user';
$route['user/form']         			= 't_user/form';
$route['user/form/(:num)']  			= 't_user/form/$1';
$route['user/DT']           			= 't_user/genDT';
$route['user/save']         			= 't_user/save';
$route['user/delete/(:num)']			= 't_user/delete/$1'; 

$route['roleuser']            				= 'mst_user';
$route['roleuser/get_divisi/(:any)']      	= 'mst_user/getUnitKerja/$1';
$route['roleuser/form']         			= 'mst_user/form';
$route['roleuser/form/(:num)']  			= 'mst_user/form/$1';
$route['roleuser/DT']           			= 'mst_user/genDT';
$route['roleuser/save/(:num)']         		= 'mst_user/simpan/$1';
$route['roleuser/delete/(:num)']			= 'mst_user/delete/$1';
$route['roleuser/lookup/(:any)']			= 'mst_user/lookup/$1';

$route['cb/cash']							= 'tr_bank/cashbank';
$route['cb/cash/(:num)']					= 'tr_bank/cashbank/cash/$2';
$route['cb/bank/(:num)']					= 'tr_bank/cashbank/bank/$2';
$route['cb/penerimaan']						= 'tr_bank/gen_penerimaan_bank';

$route['chain/grp_user']					= 'mst_user/chain_ukerbyuser';
$route['chain/kode_div']					= 'mst_user/chain_kodedivisi';


$route['nasabah/konstruksi']				= 'mst_nasabah_konstruksi';
$route['nasabah/konstruksi/list']			= 'mst_nasabah_konstruksi/daftar_nasabah';
$route['nasabah/konstruksi/cari/(:any)']	= 'mst_nasabah_konstruksi/lookup/$1';
$route['nasabah/konstruksi/new/(:any)/(:any)']	= 'mst_nasabah_konstruksi/form/$1/$2';
$route['nasabah/konstruksi/new']	= 'mst_nasabah_konstruksi/form/data/0';
$route['nasabah/konstruksi/edit/(:any)/(:any)']	= 'mst_nasabah_konstruksi/form/$1/$2';
$route['nasabah/konstruksi/save']			= 'mst_nasabah_konstruksi/save';
$route['nasabah/konstruksi/edit/(:num)']	= 'mst_nasabah_konstruksi/form/edit/$1';
$route['nasabah/konstruksi/delete/(:num)']	= 'mst_nasabah_konstruksi/hapus/$1';
$route['nasabah/konstruksi/exp2pdx']		= 'mst_nasabah_konstruksi/export2paradox';
$route['nasabah/konstruksi/DT']				= 'mst_nasabah_konstruksi/genDT';
$route['nasabah/konstruksi/listDT']			= 'mst_nasabah_konstruksi/listDT';
$route['nasabah/konstruksi/getWaiting']	= 'mst_nasabah_konstruksi/getNasabah';
$route['nasabah/konstruksi/approved']	= 'mst_nasabah_konstruksi/approved';


//20/12/2015-SYM

$route['tahap'] 							= 'mst_tahap';
$route['tahap/DT']			 				= 'mst_tahap/genDT';
$route['tahap/save'] 						= 'mst_tahap/save';
$route['tahap/form'] 						= 'mst_tahap/form';
$route['tahap/edit/(:num)'] 				= 'mst_tahap/form/$1';
$route['tahap/delete/(:num)'] = 'mst_tahap/delete/$1';

$route['rab-bl'] 						= 'mst_rab_bl';
$route['rab-bl/DT'] 					= 'mst_rab_bl/genDT';
$route['rab-bl/save'] 					= 'mst_rab_bl/save';
$route['rab-bl/form'] 					= 'mst_rab_bl/form';
$route['rab-bl/edit/(:num)'] 			= 'mst_rab_bl/form/$1';
$route['rab-bl/delete/(:num)'] 			= 'mst_rab_bl/delete/$1';

$route['rab-btl'] 						= 'mst_rab_btl';
$route['rab-btl/DT'] 					= 'mst_rab_btl/genDT';
$route['rab-btl/save'] 					= 'mst_rab_btl/save';
$route['rab-btl/form'] 					= 'mst_rab_btl/form';
$route['rab-btl/edit/(:num)'] 			= 'mst_rab_btl/form/$1';
$route['rab-btl/delete/(:num)'] 		= 'mst_rab_btl/delete/$1';
	

	
$route['harga-sumberdaya-excel']= 'mst_harga_sumberdaya/excel';
$route['harga-sumberdaya-excel/save']= 'mst_harga_sumberdaya/save_excel';

$route['rab-btl-excel']= 'tr_rab_btl/excel';
$route['rab-btl-excel/save']= 'tr_rab_btl/save_excel';

$route['tahap/rpt-ra-ri/form']      		= 'tr_tahap/form_rpt_ra_ri';
$route['tahap/rpt-ra-ri/(:any)/(:any)']    	= 'tr_tahap/genRaRiXls/$1/$2';
$route['tahap/rpt-rari']      				= 'tr_tahap/rpt_tahaprari';
$route['tahap/rpt-rari/(:any)']    			= 'tr_tahap/rpt_tahaprari/$1';
//$route['tahap/rpt-rari/dt/(:any)']    = 'tr_tahap/genDT/$1';

//12-01-2016::Irul
$route['sales-statistic']	= 'rpt_graphic';
	
$route['export-import']  = 'jurnal_export_import';
$route['export-import/export']  = 'jurnal_export_import/export';
$route['export-import/generate']  = 'jurnal_export_import/export_generate';
$route['export-import/porta']  = 'jurnal_export_import/porta';
$route['export-import/transfer']  = 'jurnal_export_import/transfer';
$route['export-import/successtransfer/(:any)/(:any)/(:any)']  = 'jurnal_export_import/successtransfer/$1/$2/$3';


//broadcast MAIL
	
$route['mail/brcs']  							= 'mail_notification/broadcast';

//Sinkron
$route['sinkron/sales']							= 'tr_sinkron/form_sales';
$route['sinkron/sales/do']						= 'tr_sinkron/do_sinkron_sales';
$route['sinkron/trx']							= 'tr_sinkron/form_trx';
$route['sinkron/trx/do']						= 'tr_sinkron/do_backup_trx';

//BDG, 23-04-2016
$route['apk']									= 'rpt_persediaan/f_periode';
$route['apk/(:any)/(:any)']						= 'rpt_persediaan/generateReport/$1/$2';
$route['apk/(:any)/(:any)']						= 'rpt_persediaan/generateReport/$1/$2';


//BKS 28/04
$route['coa_common']							= 'tr_tools/index';
$route['gen_coacom']							= 'tr_tools/updateCoaCommon';
$route['s_common']								= 'tr_tools/listCoaCommon';

$route['jurnal/getLastNoBuk/(:any)']			= 'tr_tools/getLastNoBukti/$1';
$route['jurnal/lookupCommon/(:any)']			= 'tr_tools/lookupCommon/$1';
$route['jurnal/listCoa']						= 'tr_tools/listCoa';
$route['jurnal/validasiSimpanJurnal/(:any)']	= 'tr_accounting/doubleEntryNoBukChecking/$1';

/* Location: ./application/config/routes.php */
