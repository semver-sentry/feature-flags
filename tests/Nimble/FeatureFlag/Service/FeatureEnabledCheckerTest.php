<?php

namespace Nimble\Dockerous\Domain\Feature\Service;

use Emmetog\FeatureFlag\Entity\Feature;
use Emmetog\FeatureFlag\Entity\FeatureFlag;
use Emmetog\FeatureFlag\Exception\FeatureDoesNotExistException;
use Emmetog\FeatureFlag\Repository\FeatureFlagRepositoryInterface;
use Emmetog\FeatureFlag\Repository\FeatureRepositoryInterface;
use Emmetog\FeatureFlag\Exception\ResourceNotFoundException;
use Emmetog\FeatureFlag\Service\FeatureEnabledChecker;
use PHPUnit_Framework_TestCase;

class FeatureEnabledCheckerTest extends PHPUnit_Framework_TestCase
{
    public function testReturnsTrueWhenFeatureEnabled()
    {
        $featureRepo = $this->whenFeatureExists('test_feature_name');
        $featureFlagRepo = $this->whenFeatureIsEnabledForUser();

        $service = new FeatureEnabledChecker($featureRepo, $featureFlagRepo);

        $this->assertTrue($service->isFeatureEnabled('test_feature_name', 'test_user_id'));
    }

    public function testReturnsFalseWhenFeatureDisabled()
    {
        $featureRepo = $this->whenFeatureExists('test_feature_name');
        $featureFlagRepo = $this->whenFeatureIsDisabledForUser();

        $service = new FeatureEnabledChecker($featureRepo, $featureFlagRepo);

        $this->assertFalse($service->isFeatureEnabled('test_feature_name', 'test_user_id'));
    }

    public function testReturnsTrueWhenFeatureIsNotSpecifiedButDefaultTrue()
    {
        $featureRepo = $this->whenFeatureExists('test_feature_name', true);
        $featureFlagRepo = $this->whenFeatureIsNotSpecifiedForUser();

        $service = new FeatureEnabledChecker($featureRepo, $featureFlagRepo);

        $this->assertTrue($service->isFeatureEnabled('test_feature_name', 'test_user_id'));
    }

    public function testThrowsExceptionWhenFeatureNotInDatabase()
    {
        $featureRepo = $this->whenFeatureDoesNotExist('test_feature_name');
        $featureFlagRepo = $this->whenFeatureIsNotSpecifiedForUser();

        $service = new FeatureEnabledChecker($featureRepo, $featureFlagRepo);

        $this->setExpectedException(FeatureDoesNotExistException::class);
        $service->isFeatureEnabled('test_feature_name', 'test_user_id');
    }

    private function whenFeatureExists($featureName, $default = false)
    {
        $repo = $this->getMock(FeatureRepositoryInterface::class);
        $repo->expects($this->once())
            ->method('getFeatureByName')
            ->willReturn(new Feature(
                'test_feature_id',
                $featureName,
                $default
            ));

        return $repo;
    }

    private function whenFeatureDoesNotExist()
    {
        $repo = $this->getMock(FeatureRepositoryInterface::class);
        $repo->expects($this->once())
            ->method('getFeatureByName')
            ->willThrowException(new ResourceNotFoundException());

        return $repo;
    }

    private function whenFeatureIsEnabledForUser()
    {
        $repo = $this->getMock(FeatureFlagRepositoryInterface::class);
        $repo->expects($this->once())
            ->method('getFeatureFlag')
            ->with('test_feature_id', 'test_user_id')
            ->willReturn(new FeatureFlag('test_feature_id', 'test_user_id', true));

        return $repo;
    }

    private function whenFeatureIsDisabledForUser()
    {
        $repo = $this->getMock(FeatureFlagRepositoryInterface::class);
        $repo->expects($this->once())
            ->method('getFeatureFlag')
            ->with('test_feature_id', 'test_user_id')
            ->willReturn(new FeatureFlag('test_feature_id', 'test_user_id', false));

        return $repo;
    }

    private function whenFeatureIsNotSpecifiedForUser()
    {
        $repo = $this->getMock(FeatureFlagRepositoryInterface::class);
        $repo->expects($this->any())
            ->method('getFeatureFlag')
            ->with('test_feature_id', 'test_user_id')
            ->willThrowException(new ResourceNotFoundException());

        return $repo;
    }
}