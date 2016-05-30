<?php

namespace Emmetog\FeatureFlag\Entity;

class Feature
{
    /**
     * @var string
     */
    private $id;

    /**
     * The name of the feature.
     *
     * @var string
     */
    private $featureName;

    /**
     * Whether or not the feature is enabled for all users by default.
     *
     * @var boolean
     */
    private $featureDefault;

    public function __construct($id, $featureName, $featureDefault)
    {
        $this->id = $id;
        $this->featureName = $featureName;
        $this->featureDefault = $featureDefault;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFeatureName()
    {
        return $this->featureName;
    }

    /**
     * @return boolean
     */
    public function isFeatureEnabledByDefault()
    {
        return $this->featureDefault;
    }
}