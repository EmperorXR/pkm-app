<?php

namespace App\Services;

class SpkService
{
    /**
     * Get predefined sample datasets for learning and simulation.
     *
     * @return array<string, array{title: string, description: string, criteria: array<int, array{code: string, name: string, weight: float, type: string}>, alternatives: array<int, array{code: string, name: string, values: array<string, float>}>}>
     */
    public function getSampleDatasets(): array
    {
        return [
            'ai_server' => [
                'title' => 'Pemilihan Infrastruktur Server AI Terdistribusi',
                'description' => 'Evaluasi arsitektur komputasi untuk menjalankan beban kerja inferensi AI terdistribusi.',
                'criteria' => [
                    ['code' => 'C1', 'name' => 'Throughput Inferensi (req/sec)', 'weight' => 0.30, 'type' => 'benefit'],
                    ['code' => 'C2', 'name' => 'Latensi Respons (ms)', 'weight' => 0.25, 'type' => 'cost'],
                    ['code' => 'C3', 'name' => 'Biaya Operasional per Bulan ($)', 'weight' => 0.20, 'type' => 'cost'],
                    ['code' => 'C4', 'name' => 'Toleransi Kesalahan / Failover (Skor 1-10)', 'weight' => 0.15, 'type' => 'benefit'],
                    ['code' => 'C5', 'name' => 'Kemudahan Skalabilitas (Skor 1-10)', 'weight' => 0.10, 'type' => 'benefit'],
                ],
                'alternatives' => [
                    [
                        'code' => 'A1',
                        'name' => 'GPU Cluster Dedicated (Kubernetes On-Premise)',
                        'values' => ['C1' => 850.0, 'C2' => 45.0, 'C3' => 3200.0, 'C4' => 8.5, 'C5' => 7.8],
                    ],
                    [
                        'code' => 'A2',
                        'name' => 'Cloud Elastic Inference (AWS ECS / SageMaker)',
                        'values' => ['C1' => 920.0, 'C2' => 38.0, 'C3' => 4100.0, 'C4' => 9.2, 'C5' => 9.5],
                    ],
                    [
                        'code' => 'A3',
                        'name' => 'Hybrid Edge AI Cluster (Distributed Fog Nodes)',
                        'values' => ['C1' => 640.0, 'C2' => 22.0, 'C3' => 1800.0, 'C4' => 7.0, 'C5' => 8.0],
                    ],
                    [
                        'code' => 'A4',
                        'name' => 'Serverless Distributed Inference (Cloud Run / Workers)',
                        'values' => ['C1' => 710.0, 'C2' => 60.0, 'C3' => 1400.0, 'C4' => 8.0, 'C5' => 9.0],
                    ],
                ],
            ],
            'distributed_model' => [
                'title' => 'Evaluasi Strategi Distributed Deep Learning',
                'description' => 'Menentukan metode training/fine-tuning terdistribusi yang paling optimal untuk dataset skala besar.',
                'criteria' => [
                    ['code' => 'C1', 'name' => 'Akurasi Model (%)', 'weight' => 0.35, 'type' => 'benefit'],
                    ['code' => 'C2', 'name' => 'Waktu Pelatihan (Jam)', 'weight' => 0.25, 'type' => 'cost'],
                    ['code' => 'C3', 'name' => 'Konsumsi Bandwidth Jaringan (GB/s)', 'weight' => 0.20, 'type' => 'cost'],
                    ['code' => 'C4', 'name' => 'Efisiensi Sinkronisasi Gradien (Skor 1-10)', 'weight' => 0.20, 'type' => 'benefit'],
                ],
                'alternatives' => [
                    [
                        'code' => 'A1',
                        'name' => 'Data Parallelism (Synchronous Ring-AllReduce)',
                        'values' => ['C1' => 94.5, 'C2' => 14.0, 'C3' => 4.8, 'C4' => 8.8],
                    ],
                    [
                        'code' => 'A2',
                        'name' => 'Pipeline Parallelism (1F1B Schedule)',
                        'values' => ['C1' => 93.8, 'C2' => 11.5, 'C3' => 3.2, 'C4' => 7.9],
                    ],
                    [
                        'code' => 'A3',
                        'name' => 'Tensor Sharding (ZeRO Stage-3 DeepSpeed)',
                        'values' => ['C1' => 95.2, 'C2' => 16.0, 'C3' => 5.5, 'C4' => 9.1],
                    ],
                    [
                        'code' => 'A4',
                        'name' => 'Federated Learning (FedAvg with Privacy Preserving)',
                        'values' => ['C1' => 91.2, 'C2' => 28.0, 'C3' => 1.2, 'C4' => 6.5],
                    ],
                ],
            ],
        ];
    }

    /**
     * Compute Simple Additive Weighting (SAW).
     *
     * @param  array<int, array{code: string, name: string, weight: float, type: string}>  $criteria
     * @param  array<int, array{code: string, name: string, values: array<string, float>}>  $alternatives
     * @return array{method: string, normalized_matrix: array<string, array<string, float>>, final_scores: array<int, array{code: string, name: string, score: float, rank: int}>, steps: array<string, mixed>}
     */
    public function calculateSaw(array $criteria, array $alternatives): array
    {
        $criteriaMap = [];
        $totalWeight = 0.0;
        foreach ($criteria as $criterion) {
            $criteriaMap[$criterion['code']] = $criterion;
            $totalWeight += (float) $criterion['weight'];
        }

        // Normalize weights if needed
        $weights = [];
        foreach ($criteria as $criterion) {
            $weights[$criterion['code']] = $totalWeight > 0 ? ((float) $criterion['weight'] / $totalWeight) : 0;
        }

        // Find min and max for each criterion
        $extremes = [];
        foreach ($criteria as $criterion) {
            $code = $criterion['code'];
            $vals = [];
            foreach ($alternatives as $alt) {
                $vals[] = (float) ($alt['values'][$code] ?? 0);
            }
            $extremes[$code] = [
                'min' => ! empty($vals) ? min($vals) : 1,
                'max' => ! empty($vals) ? max($vals) : 1,
            ];
        }

        // Normalized matrix
        $normalizedMatrix = [];
        foreach ($alternatives as $alt) {
            $altCode = $alt['code'];
            $normalizedMatrix[$altCode] = [];
            foreach ($criteria as $criterion) {
                $code = $criterion['code'];
                $val = (float) ($alt['values'][$code] ?? 0);
                $isBenefit = strtolower($criterion['type']) === 'benefit';

                if ($isBenefit) {
                    $max = $extremes[$code]['max'];
                    $norm = $max != 0 ? ($val / $max) : 0;
                } else {
                    $min = $extremes[$code]['min'];
                    $norm = $val != 0 ? ($min / $val) : 0;
                }

                $normalizedMatrix[$altCode][$code] = round($norm, 4);
            }
        }

        // Preference scores
        $results = [];
        foreach ($alternatives as $alt) {
            $altCode = $alt['code'];
            $score = 0.0;
            foreach ($criteria as $criterion) {
                $code = $criterion['code'];
                $w = $weights[$code];
                $r = $normalizedMatrix[$altCode][$code];
                $score += ($w * $r);
            }

            $results[] = [
                'code' => $alt['code'],
                'name' => $alt['name'],
                'score' => round($score, 4),
                'rank' => 0,
            ];
        }

        // Sort ranking descending
        usort($results, function (array $a, array $b): int {
            return $b['score'] <=> $a['score'];
        });

        foreach ($results as $index => &$res) {
            $res['rank'] = $index + 1;
        }
        unset($res);

        return [
            'method' => 'Simple Additive Weighting (SAW)',
            'normalized_matrix' => $normalizedMatrix,
            'final_scores' => $results,
            'steps' => [
                'extremes' => $extremes,
                'normalized_weights' => $weights,
            ],
        ];
    }

    /**
     * Compute Technique for Order Preference by Similarity to Ideal Solution (TOPSIS).
     *
     * @param  array<int, array{code: string, name: string, weight: float, type: string}>  $criteria
     * @param  array<int, array{code: string, name: string, values: array<string, float>}>  $alternatives
     * @return array{method: string, normalized_matrix: array<string, array<string, float>>, weighted_matrix: array<string, array<string, float>>, ideal_positive: array<string, float>, ideal_negative: array<string, float>, distances: array<string, array{d_plus: float, d_minus: float}>, final_scores: array<int, array{code: string, name: string, score: float, rank: int}>}
     */
    public function calculateTopsis(array $criteria, array $alternatives): array
    {
        $totalWeight = 0.0;
        foreach ($criteria as $criterion) {
            $totalWeight += (float) $criterion['weight'];
        }

        $weights = [];
        foreach ($criteria as $criterion) {
            $weights[$criterion['code']] = $totalWeight > 0 ? ((float) $criterion['weight'] / $totalWeight) : 0;
        }

        // Euclidean divisor for normalization
        $divisors = [];
        foreach ($criteria as $criterion) {
            $code = $criterion['code'];
            $sumSq = 0.0;
            foreach ($alternatives as $alt) {
                $val = (float) ($alt['values'][$code] ?? 0);
                $sumSq += ($val * $val);
            }
            $divisors[$code] = sqrt($sumSq) ?: 1.0;
        }

        // Normalized & Weighted Normalized Matrix
        $normalizedMatrix = [];
        $weightedMatrix = [];
        foreach ($alternatives as $alt) {
            $altCode = $alt['code'];
            $normalizedMatrix[$altCode] = [];
            $weightedMatrix[$altCode] = [];
            foreach ($criteria as $criterion) {
                $code = $criterion['code'];
                $val = (float) ($alt['values'][$code] ?? 0);
                $norm = $val / $divisors[$code];
                $weighted = $norm * $weights[$code];

                $normalizedMatrix[$altCode][$code] = round($norm, 4);
                $weightedMatrix[$altCode][$code] = round($weighted, 4);
            }
        }

        // Ideal Positive (A+) and Ideal Negative (A-)
        $idealPositive = [];
        $idealNegative = [];
        foreach ($criteria as $criterion) {
            $code = $criterion['code'];
            $colValues = [];
            foreach ($alternatives as $alt) {
                $colValues[] = $weightedMatrix[$alt['code']][$code];
            }

            $isBenefit = strtolower($criterion['type']) === 'benefit';
            if ($isBenefit) {
                $idealPositive[$code] = max($colValues);
                $idealNegative[$code] = min($colValues);
            } else {
                $idealPositive[$code] = min($colValues);
                $idealNegative[$code] = max($colValues);
            }
        }

        // Distances D+ and D-
        $distances = [];
        $results = [];
        foreach ($alternatives as $alt) {
            $altCode = $alt['code'];
            $dPlusSum = 0.0;
            $dMinusSum = 0.0;

            foreach ($criteria as $criterion) {
                $code = $criterion['code'];
                $val = $weightedMatrix[$altCode][$code];

                $diffPlus = $val - $idealPositive[$code];
                $diffMinus = $val - $idealNegative[$code];

                $dPlusSum += ($diffPlus * $diffPlus);
                $dMinusSum += ($diffMinus * $diffMinus);
            }

            $dPlus = sqrt($dPlusSum);
            $dMinus = sqrt($dMinusSum);

            $distances[$altCode] = [
                'd_plus' => round($dPlus, 4),
                'd_minus' => round($dMinus, 4),
            ];

            $totalDist = $dMinus + $dPlus;
            $ci = $totalDist > 0 ? ($dMinus / $totalDist) : 0.0;

            $results[] = [
                'code' => $alt['code'],
                'name' => $alt['name'],
                'score' => round($ci, 4),
                'rank' => 0,
            ];
        }

        usort($results, function (array $a, array $b): int {
            return $b['score'] <=> $a['score'];
        });

        foreach ($results as $index => &$res) {
            $res['rank'] = $index + 1;
        }
        unset($res);

        return [
            'method' => 'TOPSIS (Technique for Order Preference by Similarity to Ideal Solution)',
            'normalized_matrix' => $normalizedMatrix,
            'weighted_matrix' => $weightedMatrix,
            'ideal_positive' => $idealPositive,
            'ideal_negative' => $idealNegative,
            'distances' => $distances,
            'final_scores' => $results,
        ];
    }

    /**
     * Compute Weighted Product (WP).
     *
     * @param  array<int, array{code: string, name: string, weight: float, type: string}>  $criteria
     * @param  array<int, array{code: string, name: string, values: array<string, float>}>  $alternatives
     * @return array{method: string, vector_s: array<string, float>, vector_v: array<int, array{code: string, name: string, score: float, rank: int}>, normalized_weights: array<string, float>}
     */
    public function calculateWeightedProduct(array $criteria, array $alternatives): array
    {
        $totalWeight = 0.0;
        foreach ($criteria as $criterion) {
            $totalWeight += (float) $criterion['weight'];
        }

        $weights = [];
        foreach ($criteria as $criterion) {
            $code = $criterion['code'];
            $isBenefit = strtolower($criterion['type']) === 'benefit';
            $w = $totalWeight > 0 ? ((float) $criterion['weight'] / $totalWeight) : 0;
            $weights[$code] = $isBenefit ? $w : (-1 * $w);
        }

        $vectorS = [];
        $totalS = 0.0;
        foreach ($alternatives as $alt) {
            $altCode = $alt['code'];
            $prod = 1.0;
            foreach ($criteria as $criterion) {
                $code = $criterion['code'];
                $val = (float) ($alt['values'][$code] ?? 1.0);
                $p = $weights[$code];
                $prod *= pow(max($val, 0.0001), $p);
            }
            $vectorS[$altCode] = round($prod, 4);
            $totalS += $prod;
        }

        $results = [];
        foreach ($alternatives as $alt) {
            $altCode = $alt['code'];
            $score = $totalS > 0 ? ($vectorS[$altCode] / $totalS) : 0.0;
            $results[] = [
                'code' => $alt['code'],
                'name' => $alt['name'],
                'score' => round($score, 4),
                'rank' => 0,
            ];
        }

        usort($results, function (array $a, array $b): int {
            return $b['score'] <=> $a['score'];
        });

        foreach ($results as $index => &$res) {
            $res['rank'] = $index + 1;
        }
        unset($res);

        return [
            'method' => 'Weighted Product (WP)',
            'vector_s' => $vectorS,
            'vector_v' => $results,
            'normalized_weights' => $weights,
        ];
    }
}
