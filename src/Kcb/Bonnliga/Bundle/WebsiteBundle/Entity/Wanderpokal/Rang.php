<?php

namespace Kcb\Bonnliga\Bundle\WebsiteBundle\Entity\Wanderpokal;

use Doctrine\ORM\Mapping as ORM;
use Kcb\Bonnliga\Bundle\WebsiteBundle\Rangliste\StammlokalRangliste;

/**
 * @ORM\Entity
 * @ORM\Table(name="WanderpokalRang")
 */
class Rang {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Monat", inversedBy="raenge")
     * @ORM\JoinColumn(name="monat_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $monat;

    /**
     * @ORM\ManyToOne(targetEntity="Kcb\Bonnliga\Bundle\WebsiteBundle\Entity\Location")
     */
    protected $stammlokal;

    /**
     * @ORM\OneToMany(targetEntity="Bester", mappedBy="rang", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"punkte" = "DESC"})
     */
    protected $beste;

    /**
     * @ORM\Column(type="integer")
     */
    protected $punkte = 0;

    public function __construct(Monat $monat, StammlokalRangliste $stammlokalRangliste) {
        $this->monat = $monat;
        $this->stammlokal = $stammlokalRangliste->getStammlokal();
        $this->beste = new \Doctrine\Common\Collections\ArrayCollection();

        $punkte = 0;
        foreach ($stammlokalRangliste->getRaengeForRangliste(5) as $rang) {
            $this->beste->add(new Bester($this, $rang->getSpieler(), $rang->getPunkte()));
            $punkte += $rang->getPunkte();
        }

        $this->punkte = ceil($punkte / 5);
    }

    public function getId() {
        return $this->id;
    }

    public function getPunkte() {
        return $this->punkte;
    }

    public function getBeste() {
        return $this->beste;
    }

    public function getStammlokal() {
        return $this->stammlokal;
    }

}