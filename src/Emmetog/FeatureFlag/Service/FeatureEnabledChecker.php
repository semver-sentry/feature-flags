<?php

namespace Emmetog\FeatureFlag\Service;

use Emmetog\FeatureFlag\Exception\FeatureDoesNotExistException;
use Emmetog\FeatureFlag\Exception\ResourceNotFoundException;
use Emmetog\FeatureFlag\Repository\FeatureFlagRepositoryInterface;
use Emmetog\FeatureFlag\Repository\FeatureRepositoryInterface;

class FeatureEnabledChecker
{
    /**
     * @var FeatureRepositoryInterface
     */
    private $featureRepo;

    /**
     * @var FeatureFlagRepositoryInterface
     */
    private $featureFlagRepo;

    public function __construct(
        FeatureRepositoryInterface $featureRepo,
        FeatureFlagRepositoryInterface $featureFlagRepo
    ) {
        $this->featureRepo = $featureRepo;
        $this->featureFlagRepo = $featureFlagRepo;
    }

    public function isFeatureEnabled($featureName, $userId)
    {
        try {
            $feature = $this->featureRepo->getFeatureByName($featureName);
        } catch (ResourceNotFoundException $e) {
            // This feature doesn't exist.
            throw new FeatureDoesNotExistException($featureName);
        }

        try {
            $featureFlag = $this->featureFlagRepo->getFeatureFlag($feature->getId(), $userId);
        } catch (ResourceNotFoundException $e) {
            // Not specified, return the default.
            return $feature->isFeatureEnabledByDefault();
        }

        return $featureFlag->isEnabled();
    }
}
