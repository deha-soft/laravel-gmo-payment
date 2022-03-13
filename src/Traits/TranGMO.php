<?php

namespace DehaSoft\LaravelGmoPayment\Traits;

trait TranGMO
{
    /**
     * Register a transaction
     *
     * @param object $data data
     *
     * @return mixed
     *
     * @internal param $orderID
     * @internal param $amount
     * @internal param string $jobCd
     */
    public function registerTran($data)
    {
        if (!isset($data->id) || !isset($data->amount)) {
            return false;
        }

        $orderId = $data->id.'-'.uniqid();

        $result = gmo()->connectGMOShop()
            ->entryTran($orderId, 'CAPTURE', $data->amount);

        if (true === $result['success']) {
            $result['order_id'] = $orderId;
            return $result;
        }

        return gmo()->getErrorMessage($result['result']);
    }

    /**
     * Change money
     *
     * @param array $data data
     *
     * @return mixed
     */
    public function charge($data)
    {
        $regResult = $this->registerTran($data);

        if (isset($regResult['success'])
            || $this->_isOrderAlreadyExisted($regResult)
        ) {
            return $this->executeTran($data, $regResult);
        }
        return $regResult;
    }

    /**
     * Execute a registered transaction
     *
     * @param object $order $order
     * @param array  $data    data
     *
     * @return mixed
     */
    public function executeTran($order, $data)
    {
        $result = gmo()->connectGMOShopAndSite()
            ->execTran(
                $data['result']['access_id'],
                $data['result']['access_pass'],
                $data['order_id'], //order id
                [
                    'member_id' => $order->family_id,
                    'card_seq' => '0',
                    'method' => '1'
                ]
            );

        if (true === $result['success']) {
            $order->gmo_order_id = $result['result']['order_id'];
            $order->save();

            return true;
        }
        return gmo()->getErrorMessage($result['result']);
    }

    /**
     * Check if order was created already
     *
     * @param array $result result
     *
     * @return bool
     */
    private function _isOrderAlreadyExisted($result)
    {
        if (isset($result['multiple'])) {
            if (false === $result['multiple']) {
                // order already exist
                if ('E01040010' === $result['result']['ErrInfo']) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Execute a change transaction
     *
     * @param array $data data
     *
     * @return mixed
     */
    public function changeTran($data)
    {
        $search = gmo()->connectGMOShop()->searchTradeMulti($data->order_id, '0');

        if ($search['result'] == true) {
            if (
                !empty($search['result']['access_id']) &&
                !empty($search['result']['access_pass'])
            ) {
                $result = gmo()->connectGMOShop()
                    ->alterTran(
                        $search['result']['access_id'],
                        $search['result']['access_pass'],
                        [
                            'job_cd' => 'VOID'
                        ]
                    );

                if (true === $result['success']) {
                    return $result;
                }

                return gmo()->getErrorMessage($result['result']);
            }
        }
    }
}