<?php


namespace Workouse\ReferralMarketingPlugin\Controller;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Workouse\ReferralMarketingPlugin\Provider\ReferenceStatisticsProvider;

class DashboardController
{
    /** @var EngineInterface */
    private $templatingEngine;

    /** @var ReferenceStatisticsProvider */
    private $statisticsProvider;

    public function __construct(EngineInterface $templatingEngine, ReferenceStatisticsProvider $statisticsProvider)
    {
        $this->templatingEngine = $templatingEngine;
        $this->statisticsProvider = $statisticsProvider;
    }

    public function indexAction(): Response
    {
        $statistics = $this->statisticsProvider->getStatistics();
        return $this->templatingEngine->renderResponse(
            '@WorkouseReferralMarketingPlugin/admin/Dashboard/index.html.twig',
            ['statistics' => $statistics]
        );
    }
}
