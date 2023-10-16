<?php
namespace NeosRulez\Shop\Payment\Payment;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use NeosRulez\Shop\Domain\Model\Cart;
use NeosRulez\Shop\Domain\Repository\OrderRepository;
use NeosRulez\Shop\Service\StockService;
use NeosRulez\Shop\Service\MailService;

/**
 * @Flow\Scope("singleton")
 */
abstract class AbstractPayment
{

    /**
     * @Flow\Inject
     * @var Cart
     */
    protected $cart;

    /**
     * @Flow\Inject
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * @Flow\Inject
     * @var StockService
     */
    protected $stockService;

    /**
     * @Flow\Inject
     * @var MailService
     */
    protected $mailService;

    /**
     * @param int $orderNumber
     * @param string $successUri
     * @return string
     */
    public function generateSuccessUri(int $orderNumber, string $successUri): string
    {
        return parse_url($successUri, PHP_URL_SCHEME) . '://' . parse_url($successUri, PHP_URL_HOST) . '/payment/success/' . $orderNumber . '/' . base64_encode($successUri);
    }

}
