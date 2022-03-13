<?php
namespace DehaSoft\LaravelGmoPayment\Traits;

use App\Exceptions\GeneralException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Log;

trait MemberGMO
{
    /**
     * Process GMO when register member
     *
     * @param object $member
     * @param array  $data
     *
     * @return bool
     * @throws GeneralException
     */
    public function processRegisterGMO($member, $data)
    {
        $errors = null;
        // register member GMO
        $isMemberExist = $this->checkMemberExist($member->id);
        $gmoMember = false;
        $name = $member->kanji_first_name . ' ' . $member->kanji_last_name;
        if (!$isMemberExist) {
            $gmoMember = $this->saveGMOMember($member->id, $name);
        } else {
            $gmoMember = $this->updateMemberGMO($member->id, $name);
        }

        // register payment GMO
        $gmoPayment = false;
        if ($gmoMember === true) {
            $isPaymentExist = $this->checkPaymentExist($member->id);

            if (!$isPaymentExist) {
                $gmoPayment = $this->saveGMOPayment($member, $data);
            } else {
                $gmoPayment = $this->updateMemberPaymentGMO($data);
            }

            if ($gmoPayment === true) {
                return true;
            } else {
                $this->addLogGMO($gmoPayment, $member->id);
                $errors = $gmoPayment[0];
            }
        } else {
            $this->addLogGMO($gmoMember, $member->id);
            $errors = $gmoMember[0];
        }

        return $errors;
    }

    /**
     * Create new member on GMO payment gateway
     *
     * @param int   $memberId
     * @param array $name
     *
     * @return bool
     */
    public function saveGMOMember($memberId, $name)
    {
        $result = gmo()->connectGMOSite()->saveMember($memberId, $name);
        if ($result['success'] === true) {
            return true;
        } else {
            return gmo()->getErrorMessage($result['result']);
        }
    }

    /**
     * Create GMO payment
     *
     * @param int   $member
     * @param array $input
     *
     * @return bool
     * @throws GeneralException
     */
    public function saveGMOPayment($member, $input)
    {
        $data = [
            'memberId' => $member->id,
            'cardNumberVisa' => $input['card_number'],
            'expire' => $input['card_expire_year'] .
                sprintf('%02d', $input['card_expire_month']),
            'token' => [
                'holder_name' => $input['card_name'],
                'Token'       => $input['card_secret']
            ]
        ];

        $resultRegisterCard = $this->registerCreditCardForMemberGMO($data);
        if ($resultRegisterCard === true) {
            return true;

        }

        return $resultRegisterCard;
    }
    
    /**
     * Write log
     *
     * @param array $errors
     * @param int   $memberId
     *
     * @return mixed
     */
    private function addLogGMO($errors, $memberId)
    {
        $logName = config('gmo.log.name') . date('Y_m_d', time()) . '.log';
        $view_log = new Logger($logName);
        $view_log->pushHandler(
            new StreamHandler(
                storage_path(config('gmo.log.path')) . $logName,
                Logger::INFO
            )
        );

        if ($errors) {
            $view_log->addInfo(
                '[ERROR] Add member '. $memberId .' with ' .
                count($errors) . ' errors:'
            );
            if (is_array($errors)) {
                foreach ($errors as $error) {
                    $view_log->addInfo($error);
                }
            } else {
                $view_log->addInfo($errors);
            }
        }
    }
}