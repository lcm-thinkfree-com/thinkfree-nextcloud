<?php

namespace OCA\Thinkfree;

require_once __DIR__ . '/../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Crypt {

	private $secret;

	public function __construct(string $secret) {
		$this->secret = $secret;
	}

	public function createToken(array $payload): string {
		return JWT::encode($payload, $this->secret, 'HS256');
	}

	function getJwtClaim(string $token, string $claimKey): ?string {
		try {
			$decoded = JWT::decode($token, new Key($this->secret, 'HS256'));
			$decodedArray = (array)$decoded;
			return $decodedArray[$claimKey] ?? null;
		} catch (Exception $e) {
			// 로그 찍거나 예외 처리
			error_log("JWT decode error: " . $e->getMessage());
			return null;
		}
	}
}
