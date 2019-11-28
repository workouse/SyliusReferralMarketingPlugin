<?php

declare(strict_types=1);

namespace Workouse\SyliusReferralMarketingPlugin\Service;

use Symfony\Component\HttpFoundation\Response;

class TransparentPixelResponse extends Response
{
    /**
     * Base 64 encoded contents for 1px transparent gif and png
     *
     * @var string
     */
    const IMAGE_CONTENT =
        'R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==';

    /**
     * The response content type
     *
     * @var string
     */
    const CONTENT_TYPE = 'gif';

    /**
     * Constructor
     */
    public function __construct($contentType = self::CONTENT_TYPE)
    {
        $content = base64_decode(self::IMAGE_CONTENT);
        parent::__construct($content);
        $this->headers->set('Content-Type', 'image/' . $contentType);
        $this->setPrivate();
        $this->headers->addCacheControlDirective('no-cache', true);
        $this->headers->addCacheControlDirective('must-revalidate', true);
    }
}
