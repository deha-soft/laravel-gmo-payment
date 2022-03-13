<?php
namespace DehaSoft\LaravelGmoPayment\Traits;


trait RegisterGMO
{
    /**
     * Register new member in GMO
     *
     * @param array $data member data
     *
     * @return mixed
     */
    public function registerMemberGMO($data)
    {
        $member = gmo()->connectGMOSite()
            ->saveMember($data['id'], mb_convert_encoding($data['name'], 'SJIS'));

        if ($member['success']) {
            return true;
        }

        return gmo()->getErrorMessage($member['result']);
    }

    /**
     * Register new payment for member in GMO
     *
     * @param object $data Update Request
     *
     * @return mixed
     */
    public function registerMemberPaymentGMO($data)
    {
        return false;
    }

    /**
     * Register credit card for member GMO
     *
     * @param array $data data
     *
     * @return boolean
     */
    public function registerCreditCardForMemberGMO($data)
    {
        $result = gmo()->connectGMOSite()
            ->saveCard(
                $data['memberId'],
                $data['cardNumberVisa'],
                $data['expire'],
                $data['token']
            );


	if ($result['success']) {
	    session()->put('gmo_card_data', $result['result']);
            return true;
        }

        return gmo()->getErrorMessage($result['result']);
    }
}
