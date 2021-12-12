<?php

declare(strict_types=1);

/**
 * Check weather the given array is associative or not.
 *
 * @param array $data
 * @return bool
 */
function isDataAssociative(array $data): bool
{
    return $data !== array_values($data);
}

/**
 * Get flatten array from the given array.
 *
 * @param array $data
 * @return array
 */
function flatData(array $data): array
{
    return array_merge(...$data);
}

/**
 * Transpose array from the given array, clockwise.
 *
 * @param array $data
 * @return array
 */
function transposeData(array $data): array
{
    return array_map(null, ...array_reverse($data, true));
}
