<?php


namespace Workouse\ReferralMarketingPlugin\Controller;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Workouse\ReferralMarketingPlugin\Provider\ReferenceStatisticsProvider;
use Workouse\ReferralMarketingPlugin\Repository\ReferenceRepository;

class DashboardController
{
    /** @var EngineInterface */
    private $templatingEngine;

    /** @var ReferenceStatisticsProvider */
    private $statisticsProvider;

    /** @var ReferenceRepository */
    private $referenceRepository;

    public function __construct(EngineInterface $templatingEngine, ReferenceStatisticsProvider $statisticsProvider, ReferenceRepository $referenceRepository)
    {
        $this->templatingEngine = $templatingEngine;
        $this->statisticsProvider = $statisticsProvider;
        $this->referenceRepository = $referenceRepository;
    }

    public function indexAction(): Response
    {
        $statistics = $this->statisticsProvider->getStatistics();
        return $this->templatingEngine->renderResponse(
            '@WorkouseReferralMarketingPlugin/admin/Dashboard/index.html.twig',
            ['statistics' => $statistics]
        );
    }

    public function customerIndexAction(int $count): Response
    {
        $references = $this->referenceRepository->findBy([], [], $count);
        return $this->templatingEngine->renderResponse(
            '@WorkouseReferralMarketingPlugin/admin/Dashboard/_customers.html.twig',
            ['references' => $references]
        );
    }
}
