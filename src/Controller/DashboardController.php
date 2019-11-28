<?php

declare(strict_types=1);

namespace Workouse\SyliusReferralMarketingPlugin\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;
use Workouse\SyliusReferralMarketingPlugin\Provider\ReferenceStatisticsProvider;
use Workouse\SyliusReferralMarketingPlugin\Repository\ReferenceRepository;

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
            '@WorkouseSyliusReferralMarketingPlugin/admin/Dashboard/index.html.twig',
            ['statistics' => $statistics]
        );
    }

    public function customerIndexAction(int $count): Response
    {
        $references = $this->referenceRepository->findBy([], [], $count);

        return $this->templatingEngine->renderResponse(
            '@WorkouseSyliusReferralMarketingPlugin/admin/Dashboard/_customers.html.twig',
            ['references' => $references]
        );
    }
}
