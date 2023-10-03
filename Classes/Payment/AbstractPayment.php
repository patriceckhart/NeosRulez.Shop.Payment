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

}
