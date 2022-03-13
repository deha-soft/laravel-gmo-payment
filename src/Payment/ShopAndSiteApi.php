<?php

/**
 * @file
 * Shop and Site API for GMO SDK.
 */

namespace DehaSoft\LaravelGmoPayment\Payment;

/**
 * Shop and Site API of GMO Payment.
 *
 * Shop ID (ショップ ID)
 * --ShopID string(13) not null.
 *
 * Shop password (ショップパスワード)
 * --ShopPass string(10) not null.
 *
 * Site ID (サイト ID)
 * --SiteID string(13) not null.
 *
 * Site password (サイトパスワード)
 * --SitePass string(20) not null.
 *
 * $data = array('key' => 'value', ...)
 *   It contains not required and conditional required fields.
 *
 * Return result
 *   It will be return only one or multiple records.
 *   Multiple records joined with '|' whatever success or failed.
 */
class ShopAndSiteApi extends Api {

  /**
   * Object constructor.
   */
  public function __construct($host, $shop_id, $shop_pass, $site_id, $site_pass, $params = array()) {
    $params['shop_id']   = $shop_id;
    $params['shop_pass'] = $shop_pass;
    $params['site_id']   = $site_id;
    $params['site_pass'] = $site_pass;
    parent::__construct($host, $params);
  }

  /**
   * Register the card that was used to trade in the specified order ID.
   *
   * @Input parameters
   *
   * Order ID (オーダーID)
   * --OrderID string(27) not null.
   *
   * Member ID (会員 ID)
   * --MemberID string(60) not null.
   *
   * Card registration serial number mode (カード登録連番モード)
   * --SeqMode string(1) null default 0.
   *
   *   Allowed values:
   *     0: Logical mode (default)
   *     1: Physical mode
   *
   * Default flag (デフォルトフラグ)
   * --DefaultFlag string(1) null default 0.
   *
   *   Allowed values:
   *     0: it is not the default card (default)
   *     1: it will be the default card
   *
   * Holder name (名義人)
   * --HolderName string(50) null.
   *
   * @Output parameters
   *
   * Card registration serial number (カード登録連番)
   * --CardSeq integer(1)
   *
   * Card number (カード番号)
   * --CardNo string(16)
   *   Asterisk with the exception of the last four digits.
   *   下 4 桁を除いて伏字
   *
   * Destination code (仕向先コード)
   * --Forward string(7)
   *   Destination code when performing a validity check.
   *   有効性チェックを行ったときの仕向先 コード
   */
  public function tradedCard($order_id, $member_id, $data = array()) {
    if (!is_array($data)) {
      $data = array();
    }
    $data['order_id']  = $order_id;
    $data['member_id'] = $member_id;
    return $this->callApi('tradedCard', $data);
  }

  /**
   * It will return the token that is required in subsequent settlement deal.
   *
   * @Input parameters
   *
   * SiteID and SitePass are required if MemberID exist.
   *
   * Access ID (取引 ID)
   * --AccessID string(32) not null.
   *
   * Access Pass (取引パスワード)
   * --AccessPass string(32) not null.
   *
   * Order ID (オーダーID)
   * --OrderID string(27) not null.
   *
   * Member ID (会員 ID)
   * --MemberID string(60) conditional null.
   *
   *   MemberID is required if need CreateMember.
   *
   * Member Name (会員名)
   * --MemberName string(255) null.
   *
   * Members create flag (会員作成フラグ)
   * --CreateMember string(1) conditional null.
   *
   *   It will specify the operation when the member does not exist.
   *   Allowed values:
   *     0: Don't create. If a member does not exist, it returns an error.
   *     1: Create member. If a member does not exist, I will create new.
   *
   * Client Field 1 (加盟店自由項目 1)
   * --ClientField1 string(100) null.
   *
   * Client Field 2 (加盟店自由項目 2)
   * --ClientField2 string(100) null.
   *
   * Client Field 3 (加盟店自由項目 3)
   * --ClientField3 string(100) null.
   *
   * Commodity (摘要)
   * --Commodity string(48) not null.
   *
   *   Set the information of the products that customers buy.
   *   And that is displayed at the time of the settlement in the KDDI center.
   *   Possible characters are next to "double-byte characters".
   *   お客様が購入する商品の情報を設定。KDDI センターでの決済時に表示される。
   *   設定可能な文字は「全角文字」となります。全角文字についての詳細は、「別 紙:制限事項一覧」を参照下さい。
   *
   * Settlement result back URL (決済結果戻し URL)
   * --RetURL string(256) not null.
   *
   *   Set the result receiving URL for merchants to receive a
   *   settlement result from this service.
   *
   *   Customer authentication on the KDDI center, if you cancel the payment
   *   operations and to send the results to the specified URL when you run
   *   the settlement process in this service via a redirect.
   *
   *   加盟店様が本サービスからの決済結果を受信する為の結果受信 URL を設定。
   *   KDDI センター上でお客様が認証、支払操作をキャンセルした場合や、
   *   本サービスにて決済処理を実行した場合に指定された URL に結果をリダイレクト経由で送信。
   *
   * Payment start date in seconds (支払開始期限秒)
   * --PaymentTermSec integer(5) null.
   *
   *   Deadline of customers from the [settlement] run until
   *   you call the [payment procedure completion IF].
   *   Up to 86,400 seconds (1 day)
   *   If the call parameter is empty, it is processed in 120 seconds
   *   お客様が【決済実行】から【支払手続き完了 IF】を呼び出すまでの期限。
   *   最大 86,400 秒(1 日)
   *   呼出パラメータが空の場合、120 秒で処理される
   *
   * Service Name (表示サービス名)
   * --ServiceName string(48) not null.
   *
   *   Service names of merchants. Displayed on your purchase history.
   *   Possible characters are next to "double-byte characters".
   *   加盟店様のサービス名称。お客様の購入履歴などに表示される。
   *   設定可能な文字は「全角文字」となります。
   *
   * Service Tel (表示電話番号)
   * --ServiceName string(15) not null.
   *
   *   Telephone number of merchants. Displayed on your purchase history.
   *   Possible characters are "single-byte numbers" - "(hyphen)".
   *   加盟店様の電話番号。お客様の購入履歴などに表示される。
   *   設定可能な文字は「半角数字と”-“(ハイフン)」となります。
   *
   * @Output parameters
   *
   * Access ID (アクセス ID)
   * --AccessID string(32)
   *
   * Token (トークン)
   * --Token string(256)
   *
   * Start URL (支払手続き開始 IF のURL)
   * --StartURL string(256)
   *
   * Start Limit Date (支払開始期限日時)
   * --StartLimitDate string(14)
   *   Format: yyyyMMddHHmmss
   */
  public function execTranAu($access_id, $access_pass, $order_id, $commodity, $ret_url, $service_name, $service_tel, $data = array()) {
    if (!is_array($data)) {
      $data = array();
    }
    $data['access_id']    = $access_id;
    $data['access_pass']  = $access_pass;
    $data['order_id']     = $order_id;
    $data['commodity']    = $commodity;
    $data['ret_url']      = $ret_url;
    $data['service_name'] = $service_name;
    $data['service_tel']  = $service_tel;
    return $this->callApi('execTranAu', $data);
  }

  /**
   * It will return the token that is required in subsequent settlement deal.
   *
   * SiteID and SitePass are required if MemberID exist.
   *
   * @Input parameters
   *
   * Access ID (取引 ID)
   * --AccessID string(32) not null.
   *
   * Access Pass (取引パスワード)
   * --AccessPass string(32) not null.
   *
   * Order ID (オーダーID)
   * --OrderID string(27) not null.
   *
   * Member ID (会員 ID)
   * --MemberID string(60) conditional null.
   *
   *   MemberID is required if need CreateMember.
   *
   * Member Name (会員名)
   * --MemberName string(255) null.
   *
   * Members create flag (会員作成フラグ)
   * --CreateMember string(1) conditional null.
   *
   *   It will specify the operation when the member does not exist.
   *   Allowed values:
   *     0: Don't create. If a member does not exist, it returns an error.
   *     1: Create member. If a member does not exist, I will create new.
   *
   * Client Field 1 (加盟店自由項目 1)
   * --ClientField1 string(100) null.
   *
   * Client Field 2 (加盟店自由項目 2)
   * --ClientField2 string(100) null.
   *
   * Client Field 3 (加盟店自由項目 3)
   * --ClientField3 string(100) null.
   *
   * Commodity (摘要)
   * --Commodity string(48) not null.
   *
   *   Description of the end user can recognize the continued billing,
   *   and I will specify the timing of billing.
   *   Possible characters are next to "double-byte characters".
   *   エンドユーザが継続課金を認識できる説明、および課金のタイミングを明記します。
   *   設定可能な文字は「全角文字」となります。
   *
   * Billing timing classification (課金タイミング区分)
   * --AccountTimingKbn string(2) not null.
   *
   *   "01": specified in the accounting timing
   *   "02": the end
   *   “01”: 課金タイミングで指定
   *   “02”: 月末
   *
   * Billing timing (課金タイミング)
   * --AccountTiming string(2) not null.
   *
   *   Set in the 1-28. (29.30,31 can not be specified)
   *   1~28 で設定。(29.30,31 は指定不可)
   *
   * First billing date (初回課金日)
   * --FirstAccountDate string(8) not null.
   *
   *   It specifies the day until six months away from
   *   the day in yyyyMMdd format.
   *
   *   Maximum value example of (6 months ahead)
   *   6/17 → 12 / 17,8 / 31 → 2/28 (29)
   *
   *   当日から 6 ヶ月先までの間の日を yyyyMMdd フォーマットで指定。
   *   最大値(6 ヶ月先)の例 6/17→12/17、8/31→2/28(29)
   *
   * Settlement result back URL (決済結果戻し URL)
   * --RetURL string(256) not null.
   *
   *   Set the result receiving URL for merchants to receive a
   *   settlement result from this service.
   *
   *   Customer authentication on the KDDI center, if you cancel the payment
   *   operations and to send the results to the specified URL when you run
   *   the settlement process in this service via a redirect.
   *
   *   加盟店様が本サービスからの決済結果を受信する為の結果受信 URL を設定。
   *   KDDI センター上でお客様が認証、支払操作をキャンセルした場合や、
   *   本サービスにて決済処理を実行した場合に指定された URL に結果をリダイレクト経由で送信。
   *
   * Payment start date in seconds (支払開始期限秒)
   * --PaymentTermSec integer(5) null.
   *
   *   Deadline of customers from the [settlement] run until
   *   you call the [payment procedure completion IF].
   *   Up to 86,400 seconds (1 day)
   *   If the call parameter is empty, it is processed in 120 seconds
   *   お客様が【決済実行】から【支払手続き完了 IF】を呼び出すまでの期限。
   *   最大 86,400 秒(1 日)
   *   呼出パラメータが空の場合、120 秒で処理される
   *
   * Service Name (表示サービス名)
   * --ServiceName string(48) not null.
   *
   *   Service names of merchants. Displayed on your purchase history.
   *   Possible characters are next to "double-byte characters".
   *   加盟店様のサービス名称。お客様の購入履歴などに表示される。
   *   設定可能な文字は「全角文字」となります。
   *
   * Service Tel (表示電話番号)
   * --ServiceName string(15) not null.
   *
   *   Telephone number of merchants. Displayed on your purchase history.
   *   Possible characters are "single-byte numbers" - "(hyphen)".
   *   加盟店様の電話番号。お客様の購入履歴などに表示される。
   *   設定可能な文字は「半角数字と”-“(ハイフン)」となります。
   *
   * @Output parameters
   *
   * Access ID (アクセス ID)
   * --AccessID string(32)
   *
   * Token (トークン)
   * --Token string(256)
   *
   * Start URL (支払手続き開始 IF のURL)
   * --StartURL string(256)
   *
   * Start Limit Date (支払開始期限日時)
   * --StartLimitDate string(14)
   *   Format: yyyyMMddHHmmss
   */
  public function execTranAuContinuance($access_id, $access_pass, $order_id, $commodity, $account_timing_kbn, $account_timing, $first_account_date, $ret_url, $service_name, $service_tel, $data = array()) {
    if (!is_array($data)) {
      $data = array();
    }
    $data['access_id']          = $access_id;
    $data['access_pass']        = $access_pass;
    $data['order_id']           = $order_id;
    $data['commodity']          = $commodity;
    $data['account_timing_kbn'] = $account_timing_kbn;
    $data['account_timing']     = $account_timing;
    $data['first_account_date'] = $first_account_date;
    $data['ret_url']            = $ret_url;
    $data['service_name']       = $service_name;
    $data['service_tel']        = $service_tel;
    return $this->callApi('execTranAuContinuance', $data);
  }

    /**
     * Execute transcation.
     *
     * Customers using the information of the card number and the
     * expiration date you entered, and conducted a settlement to
     * communicate with the card company, and returns the result.
     *
     * @Input parameters
     *
     * Access ID (取引 ID)
     * --AccessID string(32)
     *
     * Access pass (取引パスワード)
     * --AccessPass string(32)
     *
     * Order ID (オーダーID)
     * --OrderID string(27) not null.
     *
     * Method (支払方法)
     * --Method string(1) conditional null.
     *
     *   Allowed values:
     *     1: 一括
     *     2: 分割
     *     3: ボーナス一括
     *     4: ボーナス分割
     *     5: リボ
     *
     * Pay times (支払回数)
     * --PayTimes integer(2) conditional null.
     *
     * Card number (カード番号)
     * --CardNo string(16) not null.
     *
     * Expiration date (有効期限)
     * --Expire string(4) not null.
     *
     *   Format: YYMM
     *
     * Security code (セキュリティーコード)
     * --SecurityCode string(4) null.
     *
     * Client field 1 (加盟店自由項目 1)
     * --ClientField1 string(100) null.
     *
     * Client field 2 (加盟店自由項目 2)
     * --ClientField2 string(100) null.
     *
     * Client field 3 (加盟店自由項目 3)
     * --ClientField3 string(100) null.
     *
     * @Output parameters
     *
     * ACS (ACS 呼出判定)
     * --ACS string(1)
     *   0: ACS call unnecessary(ACS 呼出不要)
     *
     * Order ID (オーダーID)
     * --OrderID string(27)
     *
     * Forward (仕向先コード)
     * --Forward string(7)
     *
     * Method (支払方法)
     * --Method string(1)
     *
     * Pay times (支払回数)
     * --PayTimes integer(2)
     *
     * Approve (承認番号)
     * --Approve string(7)
     *
     * Transcation ID (トランザクション ID)
     * --TransactionId string(28)
     *
     * Transcation date (決済日付)
     * --TranDate string(14)
     *   Format: yyyyMMddHHmmss
     *
     * Check string (MD5 ハッシュ)
     * --CheckString string(32)
     *   MD5 hash of OrderID ~ TranDate + shop password
     *   OrderID~TranDate+ショップパスワー ドの MD5 ハッシュ
     *
     * Client field 1 (加盟店自由項目 1)
     * --ClientField1 string(100)
     *
     * Client field 2 (加盟店自由項目 2)
     * --ClientField2 string(100)
     *
     * Client field 3 (加盟店自由項目 3)
     * --ClientField3 string(100)
     */
    public function execTran($access_id, $access_pass, $order_id, $data = array()) {
        // Disable shop id and shop pass.
        if (!is_array($data)) {
            $data = array();
        }
        $data['access_id']   = $access_id;
        $data['access_pass'] = $access_pass;
        $data['order_id']    = $order_id;
        if (!isset($data['method']) || $data['method'] != 2 || $data['method'] != 4) {
            unset($data['pay_times']);
        }
        // If member id empty, unset site id and site pass.
        if (!isset($data['member_id']) || 0 > strlen($data['member_id'])) {
            $this->disableSiteIdAndPass();
        }
        // If it doesn't exist cardseq.
        if (!isset($data['card_seq'])) {
            // Chekc CardNo, Expire, SecurityCode exist.
        }
        else {
            unset($data['card_no'], $data['expire'], $data['security_code']);
        }

        $this->addHttpParams();

        return $this->callApi('execTran', $data);
    }

}
