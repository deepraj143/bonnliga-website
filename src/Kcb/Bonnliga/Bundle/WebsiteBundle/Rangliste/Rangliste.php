<?php

namespace Kcb\Bonnliga\Bundle\WebsiteBundle\Rangliste;

use Doctrine\ORM\EntityManager;
use Kcb\Bonnliga\Bundle\WebsiteBundle\Entity\Platzierung;
use Kcb\Bonnliga\Bundle\WebsiteBundle\Entity\Spieler;

abstract class Rangliste {

    protected $entityManager;
    protected $geaendert = false;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    abstract protected function getEntityRepository();

    public function getRaenge() {
        return $this->getEntityRepository()->findRaenge();
    }

    public function getRaengeForRangliste($limit) {
        return $this->getEntityRepository()->findRaengeForRangliste($limit);
    }

    public function getRang(Spieler $spieler) {
        return $this->getEntityRepository()->findOneBySpieler($spieler);
    }

    public function zuruecksetzen() {
        foreach ($this->getRaenge(false) as $rang) {
            $rang->zuruecksetzen();
        }
    }

    public function beruecksichtige(Platzierung $platzierung) {
        $this->getRang($platzierung->getSpieler())->beruecksichtige($platzierung);
        $this->geaendert = true;
    }

    public function aktualisieren() {
        if (!$this->geaendert)
            return;

        $raenge = $this->getRaenge();

        usort($raenge, function($a, $b) {
            $aPunkte = $a->getPunkte();
            $bPunkte = $b->getPunkte();
            if ($aPunkte != $bPunkte)
                return $b->getPunkte() - $a->getPunkte();

            $teilnahmenA = count($a->getSpieler()->getPlatzierungen());
            $teilnahmenB = count($b->getSpieler()->getPlatzierungen());
            if ($teilnahmenA != $teilnahmenB)
                return $teilnahmenA - $teilnahmenB;

            return strcmp($a->getSpieler()->getName(), $b->getSpieler()->getName());
        });

        $aktuellePunktzahl = PHP_INT_MAX;
        $aktuelleTeilnahmen = 0;
        $naechsterRang = 0;
        $aktuellerRang = 0;
        foreach ($raenge as $rang) {
            $punkte = $rang->getPunkte();
            $teilnahmen = count($rang->getSpieler()->getPlatzierungen());
            $naechsterRang++;
            if (($punkte < $aktuellePunktzahl) || ($teilnahmen > $aktuelleTeilnahmen)) {
                $aktuellerRang = $naechsterRang;
            }
            if ($punkte == 0) {
                $rang->setRang(null);
            } else {
                $rang->setRang($aktuellerRang);
            }
            $aktuellePunktzahl = $punkte;
            $aktuelleTeilnahmen = $teilnahmen;
        }

        $this->geaendert = false;
    }

}