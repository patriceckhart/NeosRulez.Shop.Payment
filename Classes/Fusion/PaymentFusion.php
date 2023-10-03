<?php
namespace NeosRulez\Shop\Payment\Fusion;

use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Eel\FlowQuery\Operations;
use Neos\ContentRepository\Domain\Service\ContextFactoryInterface;

class PaymentFusion extends AbstractFusionObject
{

    /**
     * @Flow\Inject
     * @var ContextFactoryInterface
     */
    protected $contextFactory;

    /**
     * @return array
     */
    public function evaluate(): array
    {
        $context = $this->contextFactory->create();
        $result = [];
        $nodes = (new FlowQuery(array($context->getCurrentSiteNode())))->find('[instanceof NeosRulez.Shop.Payment:Payment.Generic]')->context(array('workspaceName' => 'live'))->sort('_index', 'ASC')->get();
        foreach ($nodes as $node) {
            $result[] = [
                'identifier' => $node->getIdentifier(),
                'isNode' => true,
                'label' => $node->getProperty('title'),
                'icon' => $node->getProperty('faicon'),
                'success_page' => $node->hasProperty('successPage') ? $node->getProperty('successPage') : false,
                'failure_page' => $node->hasProperty('failurePage') ? $node->getProperty('failurePage') : false,
            ];
        }
        return $result;
    }

}
