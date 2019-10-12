## referral-marketing-sylius
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/workouse/referral-marketing-sylius/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/workouse/referral-marketing-sylius/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/workouse/referral-marketing-sylius/badges/build.png?b=master)](https://scrutinizer-ci.com/g/workouse/referral-marketing-sylius/build-status/master)

Referral Marketing Bundle for Sylius E-Commerce. Provides customers to send invitations to each other by e-mail and win coupons

Screenshots:
<img src="https://github.com/workouse/referral-marketing-sylius/blob/master/screenshot_1.png" alt="Referral Marketing Bundle" width="100%">
<img src="https://github.com/workouse/referral-marketing-sylius/blob/master/screenshot_2.png" alt="Referral Marketing Bundle Add Reference" width="100%">
<img src="https://github.com/workouse/referral-marketing-sylius/blob/master/screenshot_3.png" alt="Referral Marketing Bundle Referance invite mail" width="100%">

## Installation
```bash
$ composer require workouse/referral-marketing-sylius
```
Add plugin dependencies to your `config/bundles.php` file:
```php
return [
    ...

    Workouse\ReferralMarketingPlugin\WorkouseReferralMarketingPlugin::class => ['all' => true],
];
```

Import required config in your `config/packages/_sylius.yaml` file:

```yaml
# config/packages/_sylius.yaml

imports:
    ...
    
    - { resource: "@WorkouseReferralMarketingPlugin/Resources/config/config.yml" }
```

Import routing in your `config/routes.yaml` file:

```yaml

# config/routes.yaml
...

workouse_referral_marketing_plugin:
    resource: "@WorkouseReferralMarketingPlugin/Resources/config/shop_routing.yml"
```

Extend entity
```php
<?php

declare(strict_types=1);

namespace App\Entity\Promotion;

use Doctrine\ORM\Mapping as ORM;
use Workouse\ReferralMarketingPlugin\Entity\PromotionCouponTrait;
use Sylius\Component\Core\Model\PromotionCoupon as BasePromotionCoupon;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_promotion_coupon")
 */
class PromotionCoupon extends BasePromotionCoupon
{
    use PromotionCouponTrait;
    
    // ...
}
```

Configuration in your `config/routes.yaml` file:
```yaml
#config/packages/workouse_referral_marketing.yml
workouse_referral_marketing:
    service: 'workouse_referral_marketing_plugin.promotion'
    referrer_promotion_code: 'referrer_promotion'
    invitee_promotion_code: 'invitee_promotion'
```

Finish the installation by updating the database schema and installing assets:
```
$ bin/console doctrine:migrations:diff
$ bin/console doctrine:migrations:migrate
$ bin/console cache:clear
```

## Testing & running the plugin
```bash
$ composer install
$ cd tests/Application
$ yarn
$ yarn build
$ bin/console assets:install public -e test
$ bin/console doctrine:database:create -e test
$ bin/console doctrine:schema:create -e test
$ bin/console server:run 127.0.0.1:8080 -d public -e test
$ open http://localhost:8080
$ vendor/bin/behat
```
