<?php

namespace Tests\Unit;

use App\Services\SpkService;
use PHPUnit\Framework\TestCase;

class SpkServiceTest extends TestCase
{
    protected SpkService $spkService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->spkService = new SpkService;
    }

    public function test_it_returns_sample_datasets(): void
    {
        $datasets = $this->spkService->getSampleDatasets();
        $this->assertArrayHasKey('ai_server', $datasets);
        $this->assertArrayHasKey('distributed_model', $datasets);
        $this->assertNotEmpty($datasets['ai_server']['criteria']);
        $this->assertNotEmpty($datasets['ai_server']['alternatives']);
    }

    public function test_it_calculates_saw_correctly(): void
    {
        $dataset = $this->spkService->getSampleDatasets()['ai_server'];
        $result = $this->spkService->calculateSaw($dataset['criteria'], $dataset['alternatives']);

        $this->assertEquals('Simple Additive Weighting (SAW)', $result['method']);
        $this->assertNotEmpty($result['final_scores']);
        $this->assertEquals(1, $result['final_scores'][0]['rank']);

        // Check normalization
        $this->assertArrayHasKey('A1', $result['normalized_matrix']);
        $this->assertArrayHasKey('C1', $result['normalized_matrix']['A1']);
    }

    public function test_it_calculates_topsis_correctly(): void
    {
        $dataset = $this->spkService->getSampleDatasets()['ai_server'];
        $result = $this->spkService->calculateTopsis($dataset['criteria'], $dataset['alternatives']);

        $this->assertStringContainsString('TOPSIS', $result['method']);
        $this->assertNotEmpty($result['final_scores']);
        $this->assertEquals(1, $result['final_scores'][0]['rank']);
        $this->assertArrayHasKey('A1', $result['distances']);

        // Relative closeness score C_i should be between 0 and 1
        foreach ($result['final_scores'] as $item) {
            $this->assertGreaterThanOrEqual(0.0, $item['score']);
            $this->assertLessThanOrEqual(1.0, $item['score']);
        }
    }

    public function test_it_calculates_weighted_product_correctly(): void
    {
        $dataset = $this->spkService->getSampleDatasets()['ai_server'];
        $result = $this->spkService->calculateWeightedProduct($dataset['criteria'], $dataset['alternatives']);

        $this->assertEquals('Weighted Product (WP)', $result['method']);
        $this->assertNotEmpty($result['vector_v']);
        $this->assertEquals(1, $result['vector_v'][0]['rank']);

        // Sum of relative preference vector V should be close to 1
        $sumV = array_sum(array_column($result['vector_v'], 'score'));
        $this->assertEqualsWithDelta(1.0, $sumV, 0.01);
    }
}
