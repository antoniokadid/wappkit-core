<?php

namespace AntonioKadid\WAPPKitCore\Graphics;

use AntonioKadid\WAPPKitCore\Exceptions\GraphicsException;
use InvalidArgumentException;

/**
 * Class Color.
 *
 * Only for true color images.
 *
 * @package AntonioKadid\WAPPKitCore\Graphics
 */
class Color
{
    public const ALICE_BLUE             = 15792383;
    public const ANTIQUE_WHITE          = 16444375;
    public const AQUA                   = 65535;
    public const AQUAMARINE             = 8388564;
    public const AZURE                  = 15794175;
    public const BEIGE                  = 16119260;
    public const BISQUE                 = 16770244;
    public const BLACK                  = 0;
    public const BLANCHED_ALMOND        = 16772045;
    public const BLUE                   = 255;
    public const BLUE_VIOLET            = 9055202;
    public const BROWN                  = 10824234;
    public const BURLY_WOOD             = 14596231;
    public const CADET_BLUE             = 6266528;
    public const CHARTREUSE             = 8388352;
    public const CHOCOLATE              = 13789470;
    public const CORAL                  = 16744272;
    public const CORNFLOWER_BLUE        = 6591981;
    public const CORNSILK               = 16775388;
    public const CRIMSON                = 14423100;
    public const CYAN                   = 65535;
    public const DARK_BLUE              = 139;
    public const DARK_CYAN              = 35723;
    public const DARK_GOLDENROD         = 12092939;
    public const DARK_GRAY              = 11119017;
    public const DARK_GREEN             = 25600;
    public const DARK_KHAKI             = 12433259;
    public const DARK_MAGENTA           = 9109643;
    public const DARK_OLIVE_GREEN       = 5597999;
    public const DARK_ORANGE            = 16747520;
    public const DARK_ORCHID            = 10040012;
    public const DARK_RED               = 9109504;
    public const DARK_SALMON            = 15308410;
    public const DARK_SEA_GREEN         = 9419919;
    public const DARK_SLATE_BLUE        = 4734347;
    public const DARK_SLATE_GRAY        = 3100495;
    public const DARK_TURQUOISE         = 52945;
    public const DARK_VIOLET            = 9699539;
    public const DEEP_PINK              = 16716947;
    public const DEEP_SKY_BLUE          = 49151;
    public const DIM_GRAY               = 6908265;
    public const DODGER_BLUE            = 2003199;
    public const FIREBRICK              = 11674146;
    public const FLORAL_WHITE           = 16775920;
    public const FOREST_GREEN           = 2263842;
    public const FUCHSIA                = 16711935;
    public const GAINSBORO              = 14474460;
    public const GHOST_WHITE            = 16316671;
    public const GOLD                   = 16766720;
    public const GOLDENROD              = 14329120;
    public const GRAY                   = 8421504;
    public const GREEN                  = 32768;
    public const GREEN_YELLOW           = 11403055;
    public const HONEYDEW               = 15794160;
    public const HOT_PINK               = 16738740;
    public const INDIAN_RED             = 13458524;
    public const INDIGO                 = 4915330;
    public const IVORY                  = 16777200;
    public const KHAKI                  = 15787660;
    public const LAVENDER               = 15132410;
    public const LAVENDER_BLUSH         = 16773365;
    public const LAWN_GREEN             = 8190976;
    public const LEMON_CHIFFON          = 16775885;
    public const LIGHT_BLUE             = 11393254;
    public const LIGHT_CORAL            = 15761536;
    public const LIGHT_CYAN             = 14745599;
    public const LIGHT_GOLDENROD_YELLOW = 16448210;
    public const LIGHT_GRAY             = 13882323;
    public const LIGHT_GREEN            = 9498256;
    public const LIGHT_PINK             = 16758465;
    public const LIGHT_SALMON           = 16752762;
    public const LIGHT_SEA_GREEN        = 2142890;
    public const LIGHT_SKY_BLUE         = 8900346;
    public const LIGHT_SLATE_GRAY       = 7833753;
    public const LIGHT_STEEL_BLUE       = 11584734;
    public const LIGHT_YELLOW           = 16777184;
    public const LIME                   = 65280;
    public const LIME_GREEN             = 3329330;
    public const LINEN                  = 16445670;
    public const MAGENTA                = 16711935;
    public const MAROON                 = 8388608;
    public const MEDIUM_AQUAMARINE      = 6737322;
    public const MEDIUM_BLUE            = 205;
    public const MEDIUM_ORCHID          = 12211667;
    public const MEDIUM_PURPLE          = 9662683;
    public const MEDIUM_SEA_GREEN       = 3978097;
    public const MEDIUM_SLATE_BLUE      = 8087790;
    public const MEDIUM_SPRING_GREEN    = 64154;
    public const MEDIUM_TURQUOISE       = 4772300;
    public const MEDIUM_VIOLET_RED      = 13047173;
    public const MIDNIGHT_BLUE          = 1644912;
    public const MINT_CREAM             = 16121850;
    public const MISTY_ROSE             = 16770273;
    public const MOCCASIN               = 16770229;
    public const NAVAJO_WHITE           = 16768685;
    public const NAVY                   = 128;
    public const OLD_LACE               = 16643558;
    public const OLIVE                  = 8421376;
    public const OLIVE_DRAB             = 7048739;
    public const ORANGE                 = 16753920;
    public const ORANGE_RED             = 16729344;
    public const ORCHID                 = 14315734;
    public const PALE_GOLDENROD         = 15657130;
    public const PALE_GREEN             = 10025880;
    public const PALE_TURQUOISE         = 11529966;
    public const PALE_VIOLET_RED        = 14381203;
    public const PAPAYA_WHIP            = 16773077;
    public const PEACH_PUFF             = 16767673;
    public const PERU                   = 13468991;
    public const PINK                   = 16761035;
    public const PLUM                   = 14524637;
    public const POWDER_BLUE            = 11591910;
    public const PURPLE                 = 8388736;
    public const RED                    = 16711680;
    public const ROSY_BROWN             = 12357519;
    public const ROYAL_BLUE             = 4286945;
    public const SADDLE_BROWN           = 9127187;
    public const SALMON                 = 16416882;
    public const SANDY_BROWN            = 16032864;
    public const SEA_GREEN              = 3050327;
    public const SEA_SHELL              = 16774638;
    public const SIENNA                 = 10506797;
    public const SILVER                 = 12632256;
    public const SKY_BLUE               = 8900331;
    public const SLATE_BLUE             = 6970061;
    public const SLATE_GRAY             = 7372944;
    public const SNOW                   = 16775930;
    public const SPRING_GREEN           = 65407;
    public const STEEL_BLUE             = 4620980;
    public const TAN                    = 13808780;
    public const TEAL                   = 32896;
    public const THISTLE                = 14204888;
    public const TOMATO                 = 16737095;
    public const TRANSPARENT            = 2130706432;
    public const TURQUOISE              = 4251856;
    public const VIOLET                 = 15631086;
    public const WHEAT                  = 16113331;
    public const WHITE                  = 16777215;
    public const WHITE_SMOKE            = 16119285;
    public const YELLOW                 = 16776960;
    public const YELLOW_GREEN           = 10145074;

    /** @var null|int */
    private $alpha;
    /** @var int */
    private $blue;
    /** @var int */
    private $green;
    /** @var string */
    private $index;
    /** @var int */
    private $red;

    /**
     * Color constructor.
     *
     * @param int      $red   can be between 0 and 255
     * @param int      $green can be between 0 and 255
     * @param int      $blue  can be between 0 and 255
     * @param null|int $alpha can be between 0 and 255 or NULL
     */
    public function __construct(int $red, int $green, int $blue, ?int $alpha = null)
    {
        $this->validate($red);
        $this->red = $red;

        $this->validate($green);
        $this->green = $green;

        $this->validate($blue);
        $this->blue = $blue;

        if ($alpha != null) {
            $this->validate($alpha);
        }
        $this->alpha = $alpha;

        $this->calculateIndex();
    }

    /**
     * Create a new color based on ARGB format.
     *
     * @param int $alpha can be between 0 and 255
     * @param int $red   can be between 0 and 255
     * @param int $green can be between 0 and 255
     * @param int $blue  can be between 0 and 255
     *
     * @return Color
     */
    public static function fromARGB(int $alpha, int $red, int $green, int $blue): Color
    {
        return new Color($red, $green, $blue, $alpha);
    }

    /**
     * Allocate color on image based on Hex value.
     *
     * @param string $hex can be between #000000 and #FFFFFF or #00000000 and #FFFFFFFF
     *
     * @throws GraphicsException
     *
     * @return Color
     */
    public static function fromHex(string $hex): Color
    {
        if (preg_match('/^\s*#?\s*(?<r>[0-9A-F]{2})(?<g>[0-9A-F]{2})(?<b>[0-9A-F]{2})\s*$/i', $hex, $rgb) === 1) {
            $r = hexdec($rgb['r']);
            $g = hexdec($rgb['g']);
            $b = hexdec($rgb['b']);

            return new Color($r, $g, $b);
        }

        if (
            preg_match(
                '/^\s*#?\s*(?<a>[0-9A-F]{2})(?<r>[0-9A-F]{2})(?<g>[0-9A-F]{2})(?<b>[0-9A-F]{2})\s*$/i',
                $hex,
                $rgb
            )
        ) {
            // convert hex alpha to PHP alpha
            $a = hexdec($rgb['a']);
            $r = hexdec($rgb['r']);
            $g = hexdec($rgb['g']);
            $b = hexdec($rgb['b']);

            return new Color($r, $g, $b, $a);
        }

        throw new GraphicsException('Unable to create color from Hex.');
    }

    /**
     * Create a new color based on RGB format.
     *
     * @param int $red   can be between 0 and 255
     * @param int $green can be between 0 and 255
     * @param int $blue  can be between 0 and 255
     *
     * @return Color
     */
    public static function fromRGB(int $red, int $green, int $blue): Color
    {
        return new Color($red, $green, $blue);
    }

    /**
     * Create a new color based on RGBA format.
     *
     * @param int   $red   can be between 0 and 255
     * @param int   $green can be between 0 and 255
     * @param int   $blue  can be between 0 and 255
     * @param float $alpha Can be between 0 and 1. 0 transparent and 1 opaque.
     *
     * @return Color
     */
    public static function fromRGBA(int $red, int $green, int $blue, float $alpha): Color
    {
        return Color::fromARGB(ceil(255 * $alpha), $red, $green, $blue);
    }

    /**
     * @return null|int
     */
    public function getAlpha(): ?int
    {
        return $this->alpha;
    }

    /**
     * @return int
     */
    public function getBlue(): int
    {
        return $this->blue;
    }

    /**
     * @return int
     */
    public function getGreen(): int
    {
        return $this->green;
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @return int
     */
    public function getRed(): int
    {
        return $this->red;
    }

    /**
     * @param null|int $alpha
     */
    public function setAlpha(?int $alpha): void
    {
        if ($alpha != null) {
            $this->validate($alpha);
        }
        $this->alpha = $alpha;
        $this->calculateIndex();
    }

    /**
     * @param int $blue
     */
    public function setBlue(int $blue): void
    {
        $this->validate($blue);
        $this->blue = $blue;
        $this->calculateIndex();
    }

    /**
     * @param int $green
     */
    public function setGreen(int $green): void
    {
        $this->validate($green);
        $this->green = $green;
        $this->calculateIndex();
    }

    /**
     * @param int $red
     */
    public function setRed(int $red): void
    {
        $this->validate($red);
        $this->red = $red;
        $this->calculateIndex();
    }

    /**
     * Calculate the index used by PHP to identify the color.
     * This index is only for true color images.
     */
    private function calculateIndex(): void
    {
        if ($this->alpha == null) {
            $this->index = hexdec(sprintf('00%02X%02X%02X', $this->red, $this->green, $this->blue));
            return;
        }

        // convert alpha to PHP alpha (0 opaque - 127 transparent)
        $alpha       = 127 - ceil((127 * $this->alpha / 255));
        $this->index = hexdec(sprintf('%02X%02X%02X%02X', $alpha, $this->red, $this->green, $this->blue));
    }

    /**
     * @param int $value
     */
    private function validate(int $value): void
    {
        if ($value < 0 || $value > 255) {
            throw new InvalidArgumentException('Invalid value for color. Minimum value is 0 and maximum value is 255.');
        }
    }
}
