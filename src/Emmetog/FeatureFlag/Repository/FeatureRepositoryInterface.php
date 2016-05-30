<?php

namespace Emmetog\FeatureFlag\Repository;

use Emmetog\FeatureFlag\Entity\Feature;

interface FeatureRepositoryInterface
{
    /**
     * @return Feature
     */
    public function getFeatureByName($featureName);
}