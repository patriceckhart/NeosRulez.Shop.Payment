<?php
namespace NeosRulez\Shop\Payment\Payment;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Scope("singleton")
 */
class Prepayment extends AbstractPayment
{

    /**
     * @param array $payment
     * @param array $args
     * @param string $successUri
     * @return string
     */
    public function execute(array $payment, array $args, string $successUri): string
    {
        $order = $this->orderRepository->findByOrderNumber($args['order_number']);
        $order->setCanceled(false);
        $this->orderRepository->update($order);

        $this->stockService->execute();
        $this->mailService->execute($args);
        $this->cart->refreshCoupons();

        return $successUri;
    }

}
