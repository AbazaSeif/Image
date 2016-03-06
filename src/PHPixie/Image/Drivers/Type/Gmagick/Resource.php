<?php

namespace PHPixie\Image\Drivers\Type\Gmagick;

/**
 * Gmagick image resource.
 */
class Resource extends \PHPixie\Image\Drivers\Type\Imagick\Resource
{
	/**
	 * Image class to initialize
	 * @var string
	 */
	protected $imageClass = '\Gmagick';

	/**
	 * Draw class to initialize
	 * @var string
	 */
	protected $drawClass  = '\GmagickDraw';

	/**
	 * Composition mode
	 * @var int
	 */
	protected $compositionMode =  \Gmagick::COMPOSITE_OVER;
    
    protected function setQuality($quality) {
        $this->image->setCompressionQuality($quality);
    }
    
	public function getPixel($x, $y) {
		$image = clone $this->image;
        $image->cropImage(1, 1, $x, $y);
        $pixel = $image->getImageHistogram()[0];
        
		$color = $pixel->getColor(true);
		$normalizedColor = $pixel->getColor(true, true);
        print_r([$color, $normalizedColor]);
		$color = ($color['r'] << 16) + ($color['g'] << 8) + $color['b'];
        $opacity = $normalizedColor['a'];
        return $this->buildPixel($x, $y, $color, $opacity);
	}
}