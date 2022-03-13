<?php

/**
 * @file
 * Base API for GMO SDK.
 */

namespace DehaSoft\LaravelGmoPayment\Payment;

/**
 * Method : IKKATU(一括).
 */
const METHOD_IKKATU = 1;

/**
 * Method : IKKATU(分割).
 */
const METHOD_BUNKATU = 2;

/**
 * Method : IKKATU(ボーナス一括).
 */
const METHOD_BONUS_IKKATU = 3;

/**
 * Method : IKKATU(ボーナス分割).
 */
const METHOD_BONUS_BUNKATU = 4;

/**
 * Method : IKKATU(リボ).
 */
const METHOD_REVO = 5;

/**
 * Base API of GMO Payment.
 */
class Api {
  /**
   * Api version.
   */
  const VERSION = '1.0.0';
  /**
   * User.
   */
  const GMO_USER = 'GMO-PG-PHP-1.0.0';
  /**
   * Version.
   */
  const GMO_VERSION = '100';
  /**
   * HTTP_USER_AGENT.
   */
  const HTTP_USER_AGENT = 'curl/7.30.0';
  /**
   * HTTP_ACCEPT.
   */
  const HTTP_ACCEPT = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
  /**
   * Multiple separator for API response.
   */
  const RESPONSE_SEPARATOR = '|';
  /**
   * API methods.
   */
  public static $apiMethods = array(
    'entryTran'                     => 'EntryTran.idPass',
    'execTran'                      => 'ExecTran.idPass',
    'alterTran'                     => 'AlterTran.idPass',
    'tdVerify'                      => 'SecureTran.idPass',
    'changeTran'                    => 'ChangeTran.idPass',
    'saveCard'                      => 'SaveCard.idPass',
    'deleteCard'                    => 'DeleteCard.idPass',
    'searchCard'                    => 'SearchCard.idPass',
    'tradedCard'                    => 'TradedCard.idPass',
    'saveMember'                    => 'SaveMember.idPass',
    'deleteMember'                  => 'DeleteMember.idPass',
    'searchMember'                  => 'SearchMember.idPass',
    'updateMember'                  => 'UpdateMember.idPass',
    'bookSalesProcess'              => 'BookSalesProcess.idPass',
    'unbookSalesProcess'            => 'UnbookSalesProcess.idPass',
    'searchBookingInfo'             => 'SearchBookingInfo.idPass',
    'searchTrade'                   => 'SearchTrade.idPass',
    'entryTranSuica'                => 'EntryTranSuica.idPass',
    'execTranSuica'                 => 'ExecTranSuica.idPass',
    'entryTranEdy'                  => 'EntryTranEdy.idPass',
    'execTranEdy'                   => 'ExecTranEdy.idPass',
    'entryTranCvs'                  => 'EntryTranCvs.idPass',
    'execTranCvs'                   => 'ExecTranCvs.idPass',
    'entryTranPayEasy'              => 'EntryTranPayEasy.idPass',
    'execTranPayEasy'               => 'ExecTranPayEasy.idPass',
    'entryTranPaypal'               => 'EntryTranPaypal.idPass',
    'execTranPaypal'                => 'ExecTranPaypal.idPass',
    'paypalStart'                   => 'PaypalStart.idPass',
    'cancelTranPaypal'              => 'CancelTranPaypal.idPass',
    'entryTranWebmoney'             => 'EntryTranWebmoney.idPass',
    'execTranWebmoney'              => 'ExecTranWebmoney.idPass',
    'webmoneyStart'                 => 'WebmoneyStart.idPass',
    'paypalSales'                   => 'PaypalSales.idPass',
    'cancelAuthPaypal'              => 'CancelAuthPaypal.idPass',
    'entryTranAu'                   => 'EntryTranAu.idPass',
    'execTranAu'                    => 'ExecTranAu.idPass',
    'auStart'                       => 'AuStart.idPass',
    'auCancelReturn'                => 'AuCancelReturn.idPass',
    'auSales'                       => 'AuSales.idPass',
    'deleteAuOpenID'                => 'DeleteAuOpenID.idPass',
    'entryTranDocomo'               => 'EntryTranDocomo.idPass',
    'execTranDocomo'                => 'ExecTranDocomo.idPass',
    'docomoStart'                   => 'DocomoStart.idPass',
    'docomoCancelReturn'            => 'DocomoCancelReturn.idPass',
    'docomoSales'                   => 'DocomoSales.idPass',
    'entryTranDocomoContinuance'    => 'EntryTranDocomoContinuance.idPass',
    'execTranDocomoContinuance'     => 'ExecTranDocomoContinuance.idPass',
    'docomoContinuanceSales'        => 'DocomoContinuanceSales.idPass',
    'docomoContinuanceCancelReturn' => 'DocomoContinuanceCancelReturn.idPass',
    'docomoContinuanceUserChange'   => 'DocomoContinuanceUserChange.idPass',
    'docomoContinuanceUserEnd'      => 'DocomoContinuanceUserEnd.idPass',
    'docomoContinuanceShopChange'   => 'DocomoContinuanceShopChange.idPass',
    'docomoContinuanceShopEnd'      => 'DocomoContinuanceShopEnd.idPass',
    'docomoContinuanceStart'        => 'DocomoContinuanceStart.idPass',
    'entryTranJibun'                => 'EntryTranJibun.idPass',
    'execTranJibun'                 => 'ExecTranJibun.idPass',
    'jibunStart'                    => 'JibunStart.idPass',
    'entryTranSb'                   => 'EntryTranSb.idPass',
    'execTranSb'                    => 'ExecTranSb.idPass',
    'sbStart'                       => 'SbStart.idPass',
    'sbCancel'                      => 'SbCancel.idPass',
    'sbSales'                       => 'SbSales.idPass',
    'entryTranAuContinuance'        => 'EntryTranAuContinuance.idPass',
    'execTranAuContinuance'         => 'ExecTranAuContinuance.idPass',
    'auContinuanceStart'            => 'AuContinuanceStart.idPass',
    'auContinuanceCancel'           => 'AuContinuanceCancel.idPass',
    'auContinuanceChargeCancel'     => 'AuContinuanceChargeCancel.idPass',
    'entryTranJcbPreca'             => 'EntryTranJcbPreca.idPass',
    'execTranJcbPreca'              => 'ExecTranJcbPreca.idPass',
    'jcbPrecaBalanceInquiry'        => 'JcbPrecaBalanceInquiry.idPass',
    'jcbPrecaCancel'                => 'JcbPrecaCancel.idPass',
    'searchTradeMulti'              => 'SearchTradeMulti.idPass',
  );

  protected $countRequestNumber = 0;

  /**
   * Input parameters mapping.
   */
  public static $inputParams = array(
    'access_id' => array(
      'key' => 'AccessID',
      'length' => 32,
    ),
    'access_pass' => array(
      'key' => 'AccessPass',
      'length' => 32,
    ),
    'account_timing_kbn' => array(
      'key' => 'AccountTimingKbn',
      'max-length' => 2,
    ),
    'account_timing' => array(
      'key' => 'AccountTiming',
      'max-length' => 2,
    ),
    'amount' => array(
      'key' => 'Amount',
      'max-length' => 6,
      'integer' => TRUE,
    ),
    'approve' => array(
      'key' => 'Approve',
      'max-length' => 7,
    ),
    'approval_no' => array(
      'key' => 'ApprovalNo',
      'max-length' => 16,
    ),
    'cancel_amount' => array(
      'key' => 'CancelAmount',
      'max-length' => 6,
      'integer' => TRUE,
    ),
    'cancel_tax' => array(
      'key' => 'CancelTax',
      'max-length' => 6,
      'integer' => TRUE,
    ),
    'card_name' => array(
      'key' => 'CardName',
      'max-length' => 10,
    ),
    'card_no' => array(
      'key' => 'CardNo',
      'min-length' => 10,
      'max-length' => 16,
    ),
    'card_pass' => array(
      'key' => 'CardPass',
      'max-length' => 20,
    ),
    'card_seq' => array(
      'key' => 'CardSeq',
      'allow' => array(0, 1),
    ),
    'carry_info' => array(
      'key' => 'CarryInfo',
      'max-length' => 34,
    ),
    'client_field_1' => array(
      'key' => 'ClientField1',
      'max-length' => 100,
    ),
    'client_field_2' => array(
      'key' => 'ClientField2',
      'max-length' => 100,
    ),
    'client_field_3' => array(
      'key' => 'ClientField3',
      'max-length' => 100,
    ),
    'client_field_flag' => array(
      'key' => 'ClientFieldFlag',
      'allow' => array(0, 1),
    ),
    'commodity' => array(
      'key' => 'Commodity',
      'max-length' => 48,
    ),
    'confirm_base_date' => array(
      'key' => 'ConfirmBaseDate',
      'length' => 2,
    ),
    'continuance_month' => array(
      'key' => 'ContinuanceMonth',
      'length' => 6,
    ),
    'convenience' => array(
      'key' => 'Convenience',
      'max-length' => 5,
    ),
    'create_member' => array(
      'key' => 'CreateMember',
      'allow' => array(0, 1),
    ),
    'currency' => array(
      'key' => 'Currency',
      'allow' => '/^[a-zA-Z]{3}$/',
    ),
    'customer_kana' => array(
      'key' => 'CustomerKana',
      'max-length' => 40,
    ),
    'customer_name' => array(
      'key' => 'CustomerName',
      'max-length' => 40,
    ),
    'default_flag' => array(
      'key' => 'DefaultFlag',
      'allow' => array(0, 1),
    ),
    'delete_flag' => array(
      'key' => 'DeleteFlag',
      'allow' => array(0, 1),
    ),
    'device_category' => array(
      'key' => 'DeviceCategory',
      'allow' => array(0, 1),
    ),
    'disp_mail_address' => array(
      'key' => 'DispMailAddress',
      'max-length' => 100,
    ),
    'disp_phone_number' => array(
      'key' => 'DispPhoneNumber',
      'max-length' => 13,
    ),
    'disp_shop_name' => array(
      'key' => 'DispShopName',
      'max-length' => 50,
    ),
    'display_date' => array(
      'key' => 'DisplayDate',
      'length' => 6,
    ),
    'docomo_disp_1' => array(
      'key' => 'DocomoDisp1',
      'max-length' => 40,
    ),
    'docomo_disp_2' => array(
      'key' => 'DocomoDisp2',
      'max-length' => 40,
    ),
    'eddy_add_info_1' => array(
      'key' => 'EdyAddInfo1',
      'max-length' => 180,
    ),
    'eddy_add_info_2' => array(
      'key' => 'EdyAddInfo2',
      'max-length' => 320,
    ),
    'expire' => array(
      'key' => 'Expire',
      'allow' => '/^\d{4}$/',
    ),
    'first_account_date' => array(
      'key' => 'FirstAccountDate',
      'allow' => '/^\d{8}$/',
    ),
    'first_amount' => array(
      'key' => 'FirstAmount',
      'max-length' => 7,
      'integer' => TRUE,
    ),
    'first_tax' => array(
      'key' => 'FirstTax',
      'max-length' => 7,
      'integer' => TRUE,
    ),
    'first_month_free_flag' => array(
      'key' => 'FirstMonthFreeFlag',
      'allow' => array(0, 1),
    ),
    'forward' => array(
      'key' => 'Forward',
      'max-length' => 7,
    ),
    'holder_name' => array(
      'key' => 'HolderName',
      'max-length' => 50,
    ),
    'http_accept' => array(
      'key' => 'HttpAccept',
    ),
    'http_user_agent' => array(
      'key' => 'HttpUserAgent',
    ),
    'item_code' => array(
      'key' => 'ItemCode',
      'max-length' => 7,
    ),
    'item_name' => array(
      'key' => 'ItemName',
      'max-length' => 40,
    ),
    'job_cd' => array(
      'key' => 'JobCd',
      'allow' => array(),
    ),
    'last_month_free_flag' => array(
      'key' => 'LastMonthFreeFlag',
      'allow' => array(0, 1),
    ),
    'md' => array(
      'key' => 'MD',
      'max-length' => 32,
    ),
    'mail_address' => array(
      'key' => 'MailAddress',
      'max-length' => 256,
    ),
    'member_id' => array(
      'key' => 'MemberID',
      'max-length' => 60,
    ),
    'member_name' => array(
      'key' => 'MemberName',
      'max-length' => 255,
    ),
    'member_no' => array(
      'key' => 'MemberNo',
      'max-length' => 20,
    ),
    'method' => array(
      'key' => 'Method',
      'allow' => array(1, 2, 3, 4, 5),
    ),
    'order_id' => array(
      'key' => 'OrderID',
      'max-length' => 27,
    ),
    'pa_res' => array(
      'key' => 'PaRes',
    ),
    'process_date' => array(
      'key' => 'ProcessDate',
      'length' => 14,
    ),
    'pay_description' => array(
      'key' => 'PayDescription',
      'max-length' => 40,
    ),
    'pay_times' => array(
      'key' => 'PayTimes',
      'max-length' => 2,
      'integer' => TRUE,
    ),
    'pay_type' => array(
      'key' => 'PayType',
      'allow' => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14),
    ),
    'payment_term_day' => array(
      'key' => 'PaymentTermDay',
      'max-length' => 2,
      'integer' => TRUE,
    ),
    'payment_term_sec' => array(
      'key' => 'PaymentTermSec',
      'max' => 86400,
      'integer' => TRUE,
    ),
    'receipts_disp_1' => array(
      'key' => 'ReceiptsDisp1',
      'max-length' => 60,
    ),
    'receipts_disp_2' => array(
      'key' => 'ReceiptsDisp2',
      'max-length' => 60,
    ),
    'receipts_disp_3' => array(
      'key' => 'ReceiptsDisp3',
      'max-length' => 60,
    ),
    'receipts_disp_4' => array(
      'key' => 'ReceiptsDisp4',
      'max-length' => 60,
    ),
    'receipts_disp_5' => array(
      'key' => 'ReceiptsDisp5',
      'max-length' => 60,
    ),
    'receipts_disp_6' => array(
      'key' => 'ReceiptsDisp6',
      'max-length' => 60,
    ),
    'receipts_disp_7' => array(
      'key' => 'ReceiptsDisp7',
      'max-length' => 60,
    ),
    'receipts_disp_8' => array(
      'key' => 'ReceiptsDisp8',
      'max-length' => 60,
    ),
    'receipts_disp_9' => array(
      'key' => 'ReceiptsDisp9',
      'max-length' => 60,
    ),
    'receipts_disp_10' => array(
      'key' => 'ReceiptsDisp10',
      'max-length' => 60,
    ),
    'receipts_disp_11' => array(
      'key' => 'ReceiptsDisp11',
      'max-length' => 42,
    ),
    'receipts_disp_12' => array(
      'key' => 'ReceiptsDisp12',
      'max-length' => 12,
    ),
    'receipts_disp_13' => array(
      'key' => 'ReceiptsDisp13',
      'max-length' => 11,
    ),
    'redirect_url' => array(
      'key' => 'RedirectURL',
      'max-length' => 200,
    ),
    'register_disp_1' => array(
      'key' => 'RegisterDisp1',
      'max-length' => 32,
    ),
    'register_disp_2' => array(
      'key' => 'RegisterDisp2',
      'max-length' => 32,
    ),
    'register_disp_3' => array(
      'key' => 'RegisterDisp3',
      'max-length' => 32,
    ),
    'register_disp_4' => array(
      'key' => 'RegisterDisp4',
      'max-length' => 32,
    ),
    'register_disp_5' => array(
      'key' => 'RegisterDisp5',
      'max-length' => 32,
    ),
    'register_disp_6' => array(
      'key' => 'RegisterDisp6',
      'max-length' => 32,
    ),
    'register_disp_7' => array(
      'key' => 'RegisterDisp7',
      'max-length' => 32,
    ),
    'register_disp_8' => array(
      'key' => 'RegisterDisp8',
      'max-length' => 32,
    ),
    'reserve_no' => array(
      'key' => 'ReserveNo',
      'max-length' => 20,
    ),
    'ret_url' => array(
      'key' => 'RetURL',
      'max-length' => 256,
    ),
    'security_code' => array(
      'key' => 'SecurityCode',
      'max-length' => 4,
    ),
    'seq_mode' => array(
      'key' => 'SeqMode',
      'allow' => array(0, 1),
    ),
    'service_name' => array(
      'key' => 'ServiceName',
      'max-length' => 48,
    ),
    'service_tel' => array(
      'key' => 'ServiceTel',
      'max-length' => 15,
    ),
    'shop_id' => array(
      'key' => 'ShopID',
      'length' => 13,
    ),
    'shop_mail_address' => array(
      'key' => 'ShopMailAddress',
      'max-length' => 256,
    ),
    'shop_pass' => array(
      'key' => 'ShopPass',
      'length' => 10,
    ),
    'site_id' => array(
      'key' => 'SiteID',
      'length' => 13,
    ),
    'site_pass' => array(
      'key' => 'SitePass',
      'length' => 20,
    ),
    'status' => array(
      'key' => 'Status',
      'max-length' => 15,
    ),
    'suica_add_info_1' => array(
      'key' => 'SuicaAddInfo1',
      'max-length' => 256,
    ),
    'suica_add_info_2' => array(
      'key' => 'SuicaAddInfo2',
      'max-length' => 256,
    ),
    'suica_add_info_3' => array(
      'key' => 'SuicaAddInfo3',
      'max-length' => 256,
    ),
    'suica_add_info_4' => array(
      'key' => 'SuicaAddInfo4',
      'max-length' => 256,
    ),
    'tax' => array(
      'key' => 'Tax',
      'max-length' => 6,
      'integer' => TRUE,
    ),
    'td_flag' => array(
      'key' => 'TdFlag',
      'allow' => array(0, 1),
    ),
    'td_tenant_name' => array(
      'key' => 'TdTenantName',
      'max-length' => 25,
    ),
    'tel_no' => array(
      'key' => 'TelNo',
      'max-length' => 13,
    ),
    'token' => array(
      'key' => 'Token',
      'max-length' => 256,
    ),
    'tran_id' => array(
      'key' => 'TranID',
      'max-length' => 28,
    ),
    'user' => array(
      'key' => 'User',
    ),
    'version' => array(
      'key' => 'Version',
    ),
  );

  /**
   * Output parameters mapping.
   */
  public static $outputParams = array(
    'AccessID'             => 'access_id',
    'AccessPass'           => 'access_pass',
    'ACS'                  => 'acs',
    'AfterBalance'         => 'after_balance',
    'Amount'               => 'amount',
    'Approve'              => 'approve',
    'BeforeBalance'        => 'before_balance',
    'BkCode'               => 'bk_code',
    'CancelAmount'         => 'cancel_amount',
    'CancelTax'            => 'cancel_tax',
    'CardActivateStatus'   => 'card_activate_status',
    'CardInvalidStatus'    => 'card_invalid_status',
    'CardName'             => 'card_name',
    'CardNo'               => 'card_no',
    'CardSeq'              => 'card_seq',
    'CardTermStatus'       => 'card_term_status',
    'CardTypeCode'         => 'card_type_code',
    'CardValidLimit'       => 'card_valid_limit',
    'CardWebInquiryStatus' => 'card_web_inquiry_status',
    'CheckString'          => 'check_string',
    'ClientField1'         => 'client_field_1',
    'ClientField2'         => 'client_field_2',
    'ClientField3'         => 'client_field_3',
    'ConfNo'               => 'conf_no',
    'ContinuanceMonth'     => 'continuance_month',
    'Convenience'          => 'convenience',
    'CustID'               => 'cust_id',
    'DefaultFlag'          => 'default_flag',
    'DeleteFlag'           => 'delete_flag',
    'EdyOrderNo'           => 'edy_order_no',
    'EncryptReceiptNo'     => 'encrypt_receipt_no',
    'Expire'               => 'expire',
    'Forward'              => 'forward',
    'HolderName'           => 'holder_name',
    'ItemCode'             => 'item_code',
    'JobCd'                => 'job_cd',
    'MemberID'             => 'member_id',
    'MemberName'           => 'member_name',
    'Method'               => 'method',
    'OrderID'              => 'order_id',
    'PaymentTerm'          => 'payment_term',
    'PayTimes'             => 'pay_times',
    'PayType'              => 'pay_type',
    'ProcessDate'          => 'process_date',
    'ReceiptNo'            => 'receipt_no',
    'SiteID'               => 'site_id',
    'StartLimitDate'       => 'start_limit_date',
    'StartURL'             => 'start_url',
    'Status'               => 'status',
    'SuicaOrderNo'         => 'suica_order_no',
    'Tax'                  => 'tax',
    'Token'                => 'token',
    'TranDate'             => 'tran_date',
    'TranID'               => 'tran_id',
    'TransactionId'        => 'transaction_id',
  );

  /**
   * Verify field by condition before call api.
   */
  public function verifyField($value, $condition) {
    $key = $condition['key'];
    // Check length.
    if (isset($condition['length'])) {
      if (strlen($value) != $condition['length']) {
        return sprintf('Field [%s] value length should be [%s].', $key, $condition['length']);
      }
    }
    else {
      if (isset($condition['min-length'])) {
        if (strlen($value) < $condition['min-length']) {
          return sprintf('Field [%s] value length should be more than [%s].', $key, $condition['min-length']);
        }
      }
      if (isset($condition['max-length'])) {
        if (strlen($value) > $condition['max-length']) {
          return sprintf('Field [%s] value length should not be more than [%s].', $key, $condition['max-length']);
        }
      }
    }
    // Check integer.
    if (isset($condition['integer']) && $condition['integer'] === TRUE) {
      if (!is_numberic($value)) {
        return sprintf('Field [%s] value should be integer.', $key);
      }
    }
    // Check allowed values.
    if (isset($condition['allow'])) {
      if (is_array($condition['allow'])) {
        if (!in_array($value, $condition['allow'])) {
          return sprintf('Field [%s] value should be one of [%s].', $key, implode(',', $condition['allow']));
        }
      }
      else {
        if (!preg_match($condition['allow'], $value)) {
          return sprintf('Field [%s] value should be match regex [%s].', $key, $condition['allow']);
        }
      }
    }
    // Check allowed values.
    if (isset($condition['max'])) {
      $value = (int) $value;
      $max = (int) $condition['max'];
      if ($value > $max) {
        return sprintf('Field [%s] value should be larger than [%s].', $key, $max);
      }
    }

    return TRUE;
  }
  /**
   * Sandbox: https://pt01.mul-pay.jp/payment/.
   */
  protected $host;
  /**
   * Example: https://pt01.mul-pay.jp/payment/EntryTran.idPass.
   */
  protected $apiUrl;
  /**
   * Tran method: entry_tran -> EntryTran.idPass.
   */
  protected $method;
  /**
   * Post parameters for api call.
   */
  protected $params = array();
  /**
   * Default parameters.
   */
  protected $defaultParams = array();
  /**
   * Input parameters mapping.
   */
  protected $inputParamsMapping = array();

  /**
   * Object constructor.
   */
  public function __construct($host, $params = array()) {
    $this->host = trim($host, '/');
    // Set default parameters.
    if ($params && is_array($params)) {
      $this->defaultParams = $params;
    }
    // Set input parameters mapping.
    $this->inputParamsMapping = self::$inputParams;
  }

  /**
   * Get input parameters mapping.
   */
  protected function getParamsMapping() {
    return $this->inputParamsMapping;
  }

  /**
   * Check required parameters exist.
   */
  protected function paramsExist() {
    // $required = self:getRequiredParams($this->method);
    $required = array();
    $params = array();
    foreach ($required as $key) {
      if (!array_key_exists($key, $this->params)) {
        $params[$key] = $key;
      }
    }

    return $params;
  }

  /**
   * Initial post parameters, such as user, version, api info.
   */
  protected function initParams() {
    $this->params = array('user' => self::GMO_USER, 'version' => self::GMO_VERSION);
    $this->defaultParams();
  }

  /**
   * Append default parameters.
   */
  protected function defaultParams() {
    if ($this->defaultParams) {
      $this->params = array_merge($this->params, $this->defaultParams);
    }
  }

  /**
   * Add new parameters.
   */
  public function addParams($params) {
    if ($params && is_array($params)) {
      $this->params = array_merge($this->params, $params);
    }
  }

  /**
   * Set param value.
   */
  public function setParam($key, $value) {
    $this->params[$key] = $value;
  }

  /**
   * Get param value.
   */
  public function getParam($key, $default = '') {
    if (array_key_exists($key, $this->params)) {
      return $this->params[$key];
    }
    return $default;
  }

  /**
   * Post request with curl and return response.
   */
  protected function request($uri, $params) {
    $response = $this->callCurl($uri, $params);
    // Process response before return.
    if ($response) {
      $response = self::processResponse($response);
      return $response;
    }

    return NULL;
  }

    /**
     * Call curl for request api
     *
     * @param $uri
     * @param $params
     *
     * @return mixed
     */
  protected function callCurl($uri, $params) {
      $this->countRequestNumber++;
      $ch = curl_init($uri);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
      curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
      // Append post fields.
      if ($params) {
          curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));
      }
      $response = curl_exec($ch);
      // Throw exception if curl error.
      $error = curl_error($ch);
      if ($error && $this->countRequestNumber <= 3) {
          $response = $this->callCurl($uri, $params);
      }
      // Close curl connect.
      curl_close($ch);

      return $response;
  }

  /**
   * Response separator.
   */
  public static function responseSeparator($value) {
    return explode(self::RESPONSE_SEPARATOR, $value);
  }

  /**
   * Process curl response before return callback.
   */
  public static function processResponse($response) {
    // mb_convert_encoding($value, 'UTF-8', 'SJIS');
    parse_str($response, $data);
    // API error or success.
    $success = isset($data['ErrCode']) ? FALSE : TRUE;
    // Check single or multiple of API response.
    $multiple = FALSE;
    $first = current($data);
    $result = array();
    if (strpos($first, self::RESPONSE_SEPARATOR) === FALSE) {
      foreach ($data as $key => $value) {
        if (isset(self::$outputParams[$key])) {
          $key = self::$outputParams[$key];
        }
        $result[$key] = $value;
      }
    }
    else {
      $multiple = TRUE;
      // Rearrange data with new structure.
      $data = array_map('self::responseSeparator', $data);
      foreach ($data as $key => $value) {
        if (isset(self::$outputParams[$key])) {
          $key = self::$outputParams[$key];
        }
        foreach ($value as $k => $v) {
          if (!isset($result[$k])) {
            $result[$k] = array();
          }
          $result[$k][$key] = $v;
        }
      }
    }
    // Return readle values after processed.
    return array(
      'success' => $success,
      'multiple' => $multiple,
      'response' => $response,
      'result' => $result,
    );
  }

  /**
   * Add http parameters.
   */
  protected function addHttpParams() {
    // Add user agent.
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
      $this->defaultParams['http_user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    }
    else {
      $this->defaultParams['http_user_agent'] = self::HTTP_USER_AGENT;
    }
    // Add accept.
    if (isset($_SERVER['HTTP_ACCEPT'])) {
      $this->defaultParams['http_accept'] = $_SERVER['HTTP_ACCEPT'];
    }
    else {
      $this->defaultParams['http_accept'] = self::HTTP_ACCEPT;
    }
  }

  /**
   * Get api url.
   */
  public function getApiUrl() {
    return $this->apiUrl;
  }

  /**
   * Execute api call method.
   */
  public function callApi($method, $params = array()) {
    $this->call($method, $params);
    return $this->execute();
  }

  /**
   * Pre-call api method.
   */
  public function call($method, $params = array()) {
    // Check api method exist.
    if (!isset(self::$apiMethods[$method])) {
      throw new \Exception(sprintf('API method %s does not exist.', $method));
    }
    $this->method = $method;
    $this->apiUrl = $this->host . '/' . self::$apiMethods[$method];
    // Initinial parameters.
    $this->initParams();
    // Add new params.
    $this->addParams($params);
  }

  /**
   * Execute call api and return results.
   */
  public function execute() {
    $uri = $this->getApiUrl();
    // Process parameters as GMO format.
    $params = $this->buildParams();
    return $this->request($uri, $params);
  }

  /**
   * Process parameters as GMO format.
   */
  protected function buildParams() {
    $params = array();
    $mapping = $this->getParamsMapping();
    foreach ($this->params as $key => $value) {
      if (isset($mapping[$key])) {
        $gmo_key = $mapping[$key]['key'];
        // Only convert fields which need to be convert.
        if (isset($mapping[$key]['encode']) && $mapping[$key]['encode'] === TRUE) {
          $value = mb_convert_encoding($value, 'SJIS', 'UTF-8');
        }
        $params[$gmo_key] = $value;
      }
    }
    return $params;
  }

}
