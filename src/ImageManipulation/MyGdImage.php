<?php

namespace ImageManipulation;

use BadMethodCallException;
use GdFont;
use GdImage;
use ImageManipulation\Exception\MyGdImageException;
use InvalidArgumentException;

/**
 * @brief Class to use GD functions in an object-oriented way.
 *
 * Each GD function imageXYZ($resource, ...) is mapped to $this->XYZ(...)
 * through __call() as $resource is a property of MyGDImage
 *
 * @see https://www.php.net/manual/fr/ref.image.php
 *
 * @author Jérôme Cutrona
 *
 * @method static array gd_info()
 * @method static GdFont|false loadfont(string $filename)
 * @method bool setstyle(array $style)
 * @method bool istruecolor()
 * @method bool truecolortopalette(bool $dither, int $num_colors)
 * @method bool palettetotruecolor()
 * @method bool colormatch(MyGdImage $image2)
 * @method bool setthickness(int $thickness)
 * @method bool filledellipse(int $center_x, int $center_y, int $width, int $height, int $color)
 * @method bool filledarc(int $center_x, int $center_y, int $width, int $height, int $start_angle, int $end_angle, int $color, int $style)
 * @method bool alphablending(bool $enable)
 * @method bool savealpha(bool $enable)
 * @method bool layereffect(int $effect)
 * @method int|false colorallocatealpha(int $red, int $green, int $blue, int $alpha)
 * @method int colorresolvealpha(int $red, int $green, int $blue, int $alpha)
 * @method int colorclosestalpha(int $red, int $green, int $blue, int $alpha)
 * @method int colorexactalpha(int $red, int $green, int $blue, int $alpha)
 * @method bool copyresampled(MyGdImage $src_image, int $dst_x, int $dst_y, int $src_x, int $src_y, int $dst_width, int $dst_height, int $src_width, int $src_height)
 * @method MyGdImage|false rotate(float $angle, int $background_color, bool $ignore_transparent=false)
 * @method bool settile(MyGdImage $tile)
 * @method bool setbrush(MyGdImage $brush)
 * @method static int types()
 * @method bool xbm(?string $filename, ?int $foreground_color=null)
 * @method bool avif( $file=null, int $quality=-1, int $speed=-1)
 * @method bool gif( $file=null)
 * @method bool png( $file=null, int $quality=-1, int $filters=-1)
 * @method bool webp( $file=null, int $quality=-1)
 * @method bool jpeg( $file=null, int $quality=-1)
 * @method bool wbmp( $file=null, ?int $foreground_color=null)
 * @method bool gd(?string $file=null)
 * @method bool gd2(?string $file=null, int $chunk_size, int $mode)
 * @method bool bmp( $file=null, bool $compressed=true)
 * @method bool destroy()
 * @method int|false colorallocate(int $red, int $green, int $blue)
 * @method void palettecopy(MyGdImage $src)
 * @method int|false colorat(int $x, int $y)
 * @method int colorclosest(int $red, int $green, int $blue)
 * @method int colorclosesthwb(int $red, int $green, int $blue)
 * @method bool colordeallocate(int $color)
 * @method int colorresolve(int $red, int $green, int $blue)
 * @method int colorexact(int $red, int $green, int $blue)
 * @method ?bool colorset(int $color, int $red, int $green, int $blue, int $alpha=0)
 * @method array colorsforindex(int $color)
 * @method bool gammacorrect(float $input_gamma, float $output_gamma)
 * @method bool setpixel(int $x, int $y, int $color)
 * @method bool line(int $x1, int $y1, int $x2, int $y2, int $color)
 * @method bool dashedline(int $x1, int $y1, int $x2, int $y2, int $color)
 * @method bool rectangle(int $x1, int $y1, int $x2, int $y2, int $color)
 * @method bool filledrectangle(int $x1, int $y1, int $x2, int $y2, int $color)
 * @method bool arc(int $center_x, int $center_y, int $width, int $height, int $start_angle, int $end_angle, int $color)
 * @method bool ellipse(int $center_x, int $center_y, int $width, int $height, int $color)
 * @method bool filltoborder(int $x, int $y, int $border_color, int $color)
 * @method bool fill(int $x, int $y, int $color)
 * @method int colorstotal()
 * @method int colortransparent(?int $color=null)
 * @method bool interlace(?bool $enable=null)
 * @method bool polygon(array $points, int $num_points_or_color, ?int $color=null)
 * @method bool openpolygon(array $points, int $num_points_or_color, ?int $color=null)
 * @method bool filledpolygon(array $points, int $num_points_or_color, ?int $color=null)
 * @method static int fontwidth(GdFont|int $font)
 * @method static int fontheight(GdFont|int $font)
 * @method bool char(GdFont|int $font, int $x, int $y, string $char, int $color)
 * @method bool charup(GdFont|int $font, int $x, int $y, string $char, int $color)
 * @method bool string(GdFont|int $font, int $x, int $y, string $string, int $color)
 * @method bool stringup(GdFont|int $font, int $x, int $y, string $string, int $color)
 * @method bool copy(MyGdImage $src_image, int $dst_x, int $dst_y, int $src_x, int $src_y, int $src_width, int $src_height)
 * @method bool copymerge(MyGdImage $src_image, int $dst_x, int $dst_y, int $src_x, int $src_y, int $src_width, int $src_height, int $pct)
 * @method bool copymergegray(MyGdImage $src_image, int $dst_x, int $dst_y, int $src_x, int $src_y, int $src_width, int $src_height, int $pct)
 * @method bool copyresized(MyGdImage $src_image, int $dst_x, int $dst_y, int $src_x, int $src_y, int $dst_width, int $dst_height, int $src_width, int $src_height)
 * @method int sx()
 * @method int sy()
 * @method bool setclip(int $x1, int $y1, int $x2, int $y2)
 * @method array getclip()
 * @method static array|false ftbbox(float $size, float $angle, string $font_filename, string $string, array $options=[])
 * @method array|false fttext(float $size, float $angle, int $x, int $y, int $color, string $font_filename, string $text, array $options=[])
 * @method static array|false ttfbbox(float $size, float $angle, string $font_filename, string $string, array $options=[])
 * @method array|false ttftext(float $size, float $angle, int $x, int $y, int $color, string $font_filename, string $text, array $options=[])
 * @method bool filter(int $filter,  $args)
 * @method bool convolution(array $matrix, float $divisor, float $offset)
 * @method bool flip(int $mode)
 * @method bool antialias(bool $enable)
 * @method MyGdImage|false crop(array $rectangle)
 * @method MyGdImage|false cropauto(int $mode=0, float $threshold=0.5, int $color=-1)
 * @method MyGdImage|false scale(int $width, int $height=-1, int $mode=3)
 * @method MyGdImage|false affine(array $affine, ?array $clip=null)
 * @method static array|false affinematrixget(int $type,  $options)
 * @method static array|false affinematrixconcat(array $matrix1, array $matrix2)
 * @method int getinterpolation()
 * @method bool setinterpolation(int $method=3)
 * @method array|bool resolution(?int $resolution_x=null, ?int $resolution_y=null)
 */
class MyGdImage
{
    public const GD = 'gd';
    public const GD2PART = 'gd2part';
    public const GD2 = 'gd2';
    public const GIF = 'gif';
    public const JPEG = 'jpeg';
    public const PNG = 'png';
    public const WBMP = 'wbmp';
    public const XBM = 'xbm';
    public const XPM = 'xpm';

    /**
     * Factory known types.
     */
    private const FACTORY_TYPES = [
        self::GD,
        self::GD2PART,
        self::GD2,
        self::GIF,
        self::JPEG,
        self::PNG,
        self::WBMP,
        self::XBM,
        self::XPM,
    ];

    /**
     * Image identifier.
     */
    private ?GdImage $resource = null;

    /**
     * Disabled constructor.
     */
    private function __construct()
    {
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        if (!is_null($this->resource)) {
            imagedestroy($this->resource);
        }
    }

    /**
     * Factory to create a MyGdImage instance from width and height parameters.
     *
     * @param int  $x         Image width
     * @param int  $y         Image height
     * @param bool $trueColor creates a true color image if true and a palette based image otherwise
     *
     * @throws MyGdImageException
     */
    public static function createFromSize(int $x, int $y, bool $trueColor = true): self
    {
        if ($trueColor) {
            $resource = @imagecreatetruecolor($x, $y);
        } else {
            $resource = @imagecreate($x, $y);
        }
        if (false !== $resource) {
            $image = new self();
            $image->resource = $resource;

            return $image;
        } else {
            throw new MyGdImageException('Failed to create GD resource');
        }
    }

    /**
     * Factory to create a MyGdImage instance from filename and filetype paramters.
     *
     * @param string $filename name of the file
     * @param string $filetype type of the file (must be an element of self::$_factory_types)
     *
     * @throws MyGdImageException
     */
    public static function createFromFile(string $filename, string $filetype): self
    {
        if (is_file($filename)) {
            if (in_array($filetype, self::FACTORY_TYPES)) {
                $functionName = "imageCreateFrom{$filetype}";
                $image = new self();
                if (($tmp = @$functionName($filename)) === false) {
                    throw new MyGdImageException("unable to load file '{$filename}'");
                }
                $image->resource = $tmp;

                return $image;
            } else {
                throw new MyGdImageException('unknown filetype');
            }
        } else {
            throw new MyGdImageException("{$filename} : no such file");
        }
    }

    /**
     * Factory to create a MyGdImage instance from filename and filetype parameters.
     *
     * @throws MyGdImageException
     */
    public static function createFromString(string $data): self
    {
        if (($tmp = imagecreatefromstring($data)) !== false) {
            $image = new self();
            $image->resource = $tmp;

            return $image;
        } else {
            throw new MyGdImageException('unable to load data');
        }
    }

    /**
     * Trap "inaccessible methods" to invoke GD functions, if available.
     * If a method named 'colorAllocate' is trapped, it will try to invoke 'imageColorAllocate' function.
     *
     * @param string $methodName      name of the "inaccessible method"
     * @param array  $methodArguments array of the arguments of the "inaccessible method"
     *
     * @return mixed
     */
    public function __call(string $methodName, array $methodArguments)
    {
        $gdFunction = "image{$methodName}";
        if (function_exists($gdFunction)) {
            // Prevent direct call of imageCreateFrom...
            if (mb_eregi('^imageCreateFrom', $gdFunction)) {
                throw new BadMethodCallException('Forbidden method call '.self::class."::{$methodName}");
            }
            // Special case of copy functions
            if (mb_eregi('^(copy|colormatch)', $methodName)) {
                // First parameter of the method should be an instance of the class
                if (isset($methodArguments[0]) && $methodArguments[0] instanceof self) {
                    // Preparing argument for GD function call
                    $methodArguments[0] = $methodArguments[0]->resource;
                } else {
                    throw new InvalidArgumentException("First parameter of '".self::class."::{$methodName}' should be an instance of ".get_class($this));
                }
            }
            // Avoid function which first parameter is not an image resource
            if (!mb_eregi('^(imagefont|imageftbbox|imagegrab|imagegrab|imageloadfont|imageps|imagetypes)', $gdFunction)) {
                // First parameter should be the image resource
                array_unshift($methodArguments, $this->resource);
            }
            // Call GD function
            $returnValue = @call_user_func_array($gdFunction, $methodArguments);
            if (null !== $returnValue) {
                if (is_a($returnValue, GdImage::class)) {
                    $newImage = new MyGdImage();
                    /** @var GdImage $returnValue */
                    $newImage->resource = $returnValue;

                    return $newImage;
                } else {
                    return $returnValue;
                }
            } else {
                throw new BadMethodCallException('Error in '.self::class."::{$methodName}");
            }
        } else {
            throw new BadMethodCallException('Unknown method call: '.self::class."::{$methodName}");
        }
    }

    /**
     * Retrieve information about the currently installed GD library.
     *
     * @return array returns an associative array of informations
     */
    public static function info(): array
    {
        return gd_info();
    }

    /**
     * Get the size of an image.
     *
     * @param string $filename   this parameter specifies the file you wish to retrieve information about
     * @param array  $image_info This optional parameter allows you to extract some extended information from the image file
     *
     * @return array an array with up to 7 elements. Not all image types will include the channels and bits elements. Index 0 and 1 contains respectively the width and the height of the image.
     */
    public static function getImageSize(string $filename, array &$image_info = []): array
    {
        return @getimagesize($filename, $image_info);
    }

    /**
     * Trap "inaccessible static methods" to invoke GD functions, if available.
     * If a method named 'colorAllocate' is trapped, it will try to invoke 'imageColorAllocate' function.
     *
     * @param string $methodName      name of the "inaccessible method"
     * @param array  $methodArguments array of the arguments of the "inaccessible method"
     *
     * @throws BadMethodCallException
     *
     * @return mixed
     */
    public static function __callStatic(string $methodName, array $methodArguments)
    {
        $gdFunction = !function_exists($methodName) ? "image{$methodName}" : $methodName;
        if (function_exists($gdFunction) && !mb_eregi('^imageCreateFrom', $gdFunction)) {
            $returnValue = call_user_func_array($gdFunction, $methodArguments);
            if (null !== $returnValue) {
                return $returnValue;
            } else {
                throw new BadMethodCallException('Error in '.self::class."::{$methodName}");
            }
        } else {
            throw new BadMethodCallException('Call to unknown static method '.self::class."::{$methodName}");
        }
    }

    /**
     * Clone.
     *
     * @throws MyGdImageException
     */
    public function __clone()
    {
        if (!imageistruecolor($this->resource)) {
            if (($tmp = @imagecreate(imagesx($this->resource), imagesy($this->resource))) === false) {
                throw new MyGdImageException('unable to clone MyGdImage');
            }
            imagepalettecopy($tmp, $this->resource);
        } else {
            if (($tmp = @imagecreatetruecolor(imagesx($this->resource), imagesy($this->resource))) === false) {
                throw new MyGdImageException('unable to clone MyGdImage');
            }
        }
        imagecopy($tmp, $this->resource, 0, 0, 0, 0, imagesx($this->resource), imagesy($this->resource));
        $this->resource = $tmp;
    }
}
