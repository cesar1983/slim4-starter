<?php

namespace App\Domain\Country;

use Doctrine\ORM\EntityRepository;

class CountryRepository extends EntityRepository
{
    /**
     * @param int $id
     * @return Country
     * @throws CountryNotFoundException
     */
    public function findCountryById(int $id): Country
    {
        return $this->findOneBy(['id' => $id]);
    }
}
