<?php
namespace DehaSoft\LaravelGmoPayment\Traits;

trait CheckGMO
{
    /**
     * Check member exist
     *
     * @param int $memberId member id
     *
     * @return mixed
     */
    public function checkMemberExist($memberId)
    {
        $result = gmo()->connectGMOSite()->searchMember($memberId);

        if ($result['success']) {
            return true;
        }

        return false;
    }

    /**
     * Check member exist
     *
     * @param int $memberId member id
     *
     * @return mixed
     */
    public function checkPaymentExist($memberId)
    {
        $result = gmo()->connectGMOSite()
            ->searchCard($memberId, config('gmo.seq_mode'));
        
        if ($result['success']) {
            return true;
        }

        return false;
    }
}