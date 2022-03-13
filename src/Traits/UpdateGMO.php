<?php

namespace DehaSoft\LaravelGmoPayment\Traits;

trait UpdateGMO
{
    /**
     * Update GMO Payment
     *
     * @param int    $memberId member id
     * @param string $name       name
     *
     * @return mixed
     */
    public function updateMemberGMO($memberId, $name)
    {
        $member = gmo()->connectGMOSite()->updateMember(
                $memberId, mb_convert_encoding($name, 'SJIS')
            );

        if ($member['success'] === true) {
            return true;
        }
        return gmo()->getErrorMessage($member['result']);
    }

    /**
     * Update payment GMO for member
     *
     * @param array $data
     *
     * @return mixed
     */
    public function updateMemberPaymentGMO($data)
    {
        $member = $this->member();
        if (!$member) {
            return false;
        }

        $infoCard = gmo()->connectGMOSite()
            ->searchCard($member->id, config('gmo.seq_mode'))['result'];

        if (isset($infoCard[0])) {
            $infoCard = $infoCard[0];
        }

        $result = gmo()->connectGMOSite()
            ->updateCard(
                $infoCard['card_seq'],
                $member->id,
                $data['card_number'],
                $data['card_expire_year'] . $data['card_expire_month'],
                [
                    'holder_name' => $data['card_name'],
                    'Token'       => $data['card_secret']
                ]
            );

        if ($result['success'] === true) {
            if (isset($member->payment)) {
                $payment = $member->payment;
                $payment->gmo_serial = $result['result']['forward'];
                if ($payment->save()) {
                    return true;
                }
            }
            return false;
        }

        return gmo()->getErrorMessage($result['result']);
    }
}