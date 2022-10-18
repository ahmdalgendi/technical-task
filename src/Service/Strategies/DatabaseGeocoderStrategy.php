<?php

namespace App\Service\Strategies;

use App\Repository\ResolvedAddressRepository;
use App\ValueObject\Address;
use App\ValueObject\Coordinates;

class DatabaseGeocoderStrategy implements GeocoderInterface
{
	private ResolvedAddressRepository $resolvedAddressRepository;
	public function __construct(ResolvedAddressRepository $resolvedAddressRepository)
	{
		$this->resolvedAddressRepository = $resolvedAddressRepository;
	}

	public function geocode(Address $address): ?Coordinates
	{
		$coordinates = $this->resolvedAddressRepository->getByAddress($address);
		if (null === $coordinates) {
			return null;
		}
		return new Coordinates($coordinates->getLat(), $coordinates->getLng());
	}
}