<?php

namespace Emmetog\FeatureFlag\Repository;

use Emmetog\FeatureFlag\Entity\FeatureFlag;

interface FeatureFlagRepositoryInterface
{
    /**
     * @return FeatureFlag
     */
    public function getFeatureFlag($featureId, $userId);
}