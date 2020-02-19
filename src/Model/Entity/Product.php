<?php

declare(strict_types=1);

namespace Model\Entity;

class Product
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId( $id ): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName( $name ): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return self
     */
    public function setPrice( $price ): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
        ];
    }

    /**
     * Метод для клонирования, и постсроения обьекта, на основании данных с фугкций fetch и fetchAll
     * @param array $data
     * @return Product
    **/
    public function buildClone( array $data ) {
        $clonedProduct = clone $this;
        $clonedProduct
            ->setId( $data['id'] )
            ->setName( $data['name'] )
            ->setPrice( $data['price'] );

        return $clonedProduct;
    }
}
