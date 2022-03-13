<?php

namespace DehaSoft\LaravelGmoPayment\Traits;

trait CardInfoGMO
{
    /**
     * Get information member GMO
     *
     * @param int $memberId member id
     *
     * @return mixed
     */
    public function getInfoMemberGMO($memberId = null)
    {
        $infoCard = [];
        $member = config('gmo.member_model')::find($memberId);
        if (isset($member->payment)) {
            if ($member->payment->old_gmo) {
                $infoCard = gmo()->connectGMOSite()
                    ->searchCard($member->payment->old_gmo, config('gmo.seq_mode'));
            } else {
                $infoCard = gmo()->connectGMOSite()
                    ->searchCard($member->id, config('gmo.seq_mode'));
            }


            if ($infoCard['success'] && isset($infoCard['result'])) {
                $infoCard = $this->getCardInfo($infoCard['result']);
            } else {
                $infoCard = null;
            }
        }

        return $this->getCardFormat($infoCard);
    }

    public function getCardFormat($data)
    {
        if ($data) {
            return [
                'card_number' => $data['card_no'],
                'card_name' => $data['holder_name'],
                'card_expire_month' => substr($data['expire'], 2, 2),
                'card_expire_year' => substr($data['expire'], 0, 2),
            ];
        } else {
            return [
                'card_number' => null,
                'card_name' => null,
                'card_expire_month' => null,
                'card_expire_year' => null,
            ];
        }
    }

    /**
     * Get data of credit card
     *
     * @param array $data data
     *
     * @return array|mixed
     */
    public function getCardInfo($data)
    {
        if (isset($data['card_no'])
            && isset($data['expire'])
            && isset($data['holder_name'])
        ) {
            return $data;
        } else {
            return reset($data);
        }
    }
}