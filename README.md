[![Build Status](https://travis-ci.org/emmetog/feature-flags.svg?branch=master)](https://travis-ci.org/emmetog/feature-flags)

# Feature Flags

This library gives you a fully functional "feature flag" functionality.

## Usage

To use this library you'll need to extend the `FeatureRepositoryInterface` and `FeatureFlagRepositoryInterface`
interfaces. These interfaces describe the interaction with the database. The classes should return `Feature`
and `FeatureFlag` entities respectively.

Once you've done this, inject them into the `FeatureEnabledChecker` service. If you use the Symfony Dependency
Injection Container then you can define this service in your services.yml.

Check if a feature is enabled like this:

```
$featureEnabledChecker = new FeatureEnabledChecker(
    $myFeatureRepository
    $myFeatureFlagRepository,
);

$isFeatureEnabledForUser = $featureEnabledChecker->isFeatureEnabled('my_cool_feature', 'my_user_id');
```