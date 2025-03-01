<?php
namespace NeosRulez\Shop\Payment\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use NeosRulez\Shop\Domain\Model\Cart;
use NeosRulez\Shop\Domain\Repository\OrderRepository;
use NeosRulez\Shop\Service\FinisherService;
use NeosRulez\Shop\Service\MailService;
use NeosRulez\Shop\Service\StockService;

/**
 * @Flow\Scope("singleton")
 */
class AfterPaymentController extends ActionController
{

    /**
     * @Flow\Inject
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * @Flow\Inject
     * @var FinisherService
     */
    protected $finisherService;

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
     * @Flow\Inject
     * @var Cart
     */
    protected $cart;

    /**
     * @param string $orderNumber
     * @param string $base64EncodedString
     * @return void
     */
    public function resetCartAndRedirectAction(string $orderNumber, string $base64EncodedString): void
    {
        $successUri = base64_decode($base64EncodedString);
        $order = $this->orderRepository->findByOrdernumber($orderNumber);

        $finisherData = json_decode($order->getInvoicedata(), true);
        $summary = json_decode($order->getSummary(), true);
        $finisherData['summary'] = $summary;
        $this->finisherService->initAfterOrderFinishers($finisherData);

        $this->stockService->execute();

        $this->cart->refreshCoupons();
        $this->cart->deleteCart();

        $this->persistenceManager->persistAll();

        $this->redirectToUri($successUri);
    }

}
