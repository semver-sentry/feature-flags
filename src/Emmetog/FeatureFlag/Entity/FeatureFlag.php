<?php

namespace Emmetog\FeatureFlag\Entity;

class FeatureFlag
{
    /**
     * The id of the feature.
     *
     * @var string
     */
    private $featureId;

    /**
     * @var string
     */
    private $userId;

    /**
     * Is the feature enabled for this user.
     *
     * @var boolean
     */
    private $isEnabled;

    public function __construct($featureId, $isEnabled, $userId)
    {
        $this->featureId = $featureId;
        $this->isEnabled = $isEnabled;
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getFeatureId()
    {
        return $this->featureId;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->isEnabled;
    }
}