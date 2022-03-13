<?php

/**
 * @file
 * Site API for GMO SDK.
 */

namespace DehaSoft\LaravelGmoPayment\Payment;

/**
 * Site API of GMO Payment.
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
class SiteApi extends Api {

  /**
   * Site api constructor.
   */
  public function __construct($host, $site_id, $site_pass, $params = array()) {
    if (!is_array($params)) {
      $params = array();
    }
    $params['site_id']   = $site_id;
    $params['site_pass'] = $site_pass;
    parent::__construct($host, $params);
  }

  /**
   * Register the member information in the specified site.
   *
   * @Input parameters.
   *
   * Member ID (会員 ID)
   * --MemberID string(60) unique not null.
   *
   * Member name (会員名)
   * --MemberName string(255) null.
   *
   * @Output parameters.
   *
   * Member ID (会員 ID)
   * --MemberID string(60)
   */
  public function saveMember($member_id, $member_name = '') {
    $data = array(
      'member_id'   => $member_id,
      'member_name' => $member_name,
    );

    return $this->callApi('saveMember', $data);
  }

  /**
   * Update the member information in the specified site.
   *
   * @Input parameters.
   *
   * Member ID (会員 ID)
   * --MemberID string(60) unique not null.
   *
   * Member name (会員名)
   * --MemberName string(255) null.
   *
   * @Output parameters.
   *
   * Member ID (会員 ID)
   * --MemberID string(60)
   */
  public function updateMember($member_id, $member_name = '') {
    $data = array(
      'member_id'   => $member_id,
      'member_name' => $member_name,
    );

    return $this->callApi('updateMember', $data);
  }

  /**
   * Search the member information in the specified site.
   *
   * @Input parameters.
   *
   * Member ID (会員 ID)
   * --MemberID string(60) not null.
   *
   * @Output parameters.
   *
   * Member ID (会員 ID)
   * --MemberID string
   *
   * Member Name (会員名)
   * --MemberName string
   *
   * Delete flag (削除フラグ)
   * --DeleteFlag string
   *   0: undeleted.
   */
  public function searchMember($member_id) {
    $data = array('member_id' => $member_id);
    return $this->callApi('searchMember', $data);
  }

  /**
   * Delete the member information from the specified site.
   *
   * @Input parameters.
   *
   * Member ID (会員 ID)
   * --MemberID string(60) not null.
   *
   * @Output parameters.
   *
   * Member ID (会員 ID)
   * --MemberID string(60)
   */
  public function deleteMember($member_id) {
    $data = array('member_id' => $member_id);
    return $this->callApi('deleteMember', $data);
  }

  /**
   * Register the card information to the specified member.
   *
   * In addition, it confirms the effectiveness communicates
   * with the card company using a shop ID which is set on the site.
   *
   * Maximum only 10 records can be saved.
   *
   * @Input parameters.
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
   * Card registration serial number (カード登録連番)
   * --CardSeq int(1) conditional null.
   *
   *   This filed is conditional required.
   *   Null value when create, not null when update.
   *
   * Default flag (デフォルトフラグ)
   * --DefaultFlag string(1) null default 0.
   *
   *   Allowed values:
   *     0: it is not the default card (default)
   *     1: it will be the default card
   *
   * Card company abbreviation (カード会社略称)
   * --CardName string(10) null.
   *
   * Card number (カード番号)
   * --CardNo string(16) not null.
   *
   * Card password (カードパスワード)
   * --CardPass string(20) null.
   *
   *   The card password is required for settlement.
   *
   * Expiration date (有効期限)
   * --Expire string(4) not null.
   *
   *   Allowed format: YYMM
   *
   * Holder name (名義人)
   * --HolderName string(50) null.
   *
   * @Output parameters.
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
  public function saveCard($member_id, $card_no, $expire, $data = array()) {
    if (!is_array($data)) {
      $data = array();
    }
    $data['member_id'] = $member_id;
    $data['card_no']   = $card_no;
    $data['expire']    = $expire;
    return $this->callApi('saveCard', $data);
  }

  /**
   * Update the card information.
   *
   * See @saveCard.
   */
  public function updateCard($card_seq, $member_id, $card_no, $expire, $data = array()) {
    if (!is_array($data)) {
      $data = array();
    }
    $data['card_seq'] = $card_seq;
    return $this->saveCard($member_id, $card_no, $expire, $data);
  }

  /**
   * Search the card information of the specified member.
   *
   * @Input parameters.
   *
   * Member ID (会員 ID)
   * --MemberID string(60) not null.
   *
   * Card registration serial number mode (カード登録連番モード)
   * --SeqMode string(1) not null.
   *
   *   Allowed values:
   *     0: Logical mode
   *     1: Physical mode
   *
   * Card registration serial number (カード登録連番)
   * --CardSeq int(1) null.
   *
   *   Registration serial number of the referenced card.
   *
   * @Output parameters.
   *
   * Card registration serial number (カード登録連番)
   * --CardSeq integer(1)
   *
   * Default flag (デフォルトフラグ)
   * --DefaultFlag string(1)
   *
   * Card name (カード会社略称)
   * --CardName string(10)
   *
   * Card number (カード番号)
   * --CardNo string(16)
   *
   * Expiration date (有効期限)
   * --Expire string(4)
   *
   * Holder name (名義人)
   * --HolderName string(50)
   *
   * Delete flag (￼削除フラグ)
   * --DeleteFlag string(1)
   */
  public function searchCard($member_id, $seq_mode, $data = array()) {
    if (!is_array($data)) {
      $data = array();
    }
    $data['member_id'] = $member_id;
    $data['seq_mode']  = $seq_mode;
    return $this->callApi('searchCard', $data);
  }

  /**
   * Delete the card information of the specified member.
   *
   * @Input parameters.
   *
   * Member ID (会員 ID)
   * --MemberID string(60) not null.
   *
   * Card registration serial number mode (カード登録連番モード)
   * --SeqMode string(1) null.
   *
   *   Allowed values:
   *     0: Logical mode
   *     1: Physical mode
   *
   * Card registration serial number (カード登録連番)
   * --CardSeq int(1) not null.
   *
   *   Registration serial number of the referenced card.
   *
   * @Output parameters.
   *
   * Card registration serial number (カード登録連番)
   * --CardSeq integer(1)
   */
  public function deleteCard($member_id, $card_seq, $data = array()) {
    if (!is_array($data)) {
      $data = array();
    }
    $data['member_id'] = $member_id;
    $data['card_seq']  = $card_seq;
    return $this->callApi('deleteCard', $data);
  }

  /**
   * Release au OpenID of the specified member.
   *
   * Input parameters.
   *
   * Member ID (会員 ID)
   * --MemberID string(60) not null.
   *
   * @Output parameters.
   *
   * Site ID (サイト ID)
   * --SiteID string(13)
   *
   * Member ID (会員 ID)
   * --MemberID string(60)
   */
  public function deleteAuOpenID($member_id) {
    $data = array('member_id' => $member_id);
    return $this->callApi('deleteAuOpenID', $data);
  }

}
